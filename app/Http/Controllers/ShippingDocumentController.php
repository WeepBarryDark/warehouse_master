<?php

namespace App\Http\Controllers;

use App\Models\ShippingDocument;
use App\Models\ShippingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ShippingDocumentController extends Controller
{
    /**
     * Display a listing of the documents
     */
    public function index()
    {
        $documents = ShippingDocument::with('user', 'items')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return Inertia::render('dashboard/documents/Index', [
            'documents' => $documents,
        ]);
    }

    /**
     * Show the form for creating a new document
     */
    public function create()
    {
        return Inertia::render('dashboard/documents/Upload');
    }

    /**
     * Store a newly created document in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // 10MB max
            'order_number' => 'nullable|string|max:255',
            'eta_date' => 'nullable|date',
            'container_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        try {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('shipping_documents', $fileName, 'public');

            // Create document record
            $document = ShippingDocument::create([
                'user_id' => auth()->id(),
                'order_number' => $request->order_number,
                'eta_date' => $request->eta_date,
                'container_number' => $request->container_number,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // Parse and store Excel data
            if ($request->has('auto_parse') && $request->auto_parse) {
                $this->parseExcelFile($document);
            }

            return redirect()->route('dashboard.documents.show', $document)
                ->with('success', 'Document uploaded successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to upload document: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified document
     */
    public function show(ShippingDocument $document)
    {
        $this->authorize('view', $document);

        $document->load('items', 'user');

        return Inertia::render('dashboard/documents/Show', [
            'document' => $document,
        ]);
    }

    /**
     * Parse Excel file and store items
     */
    public function parse(ShippingDocument $document)
    {
        $this->authorize('update', $document);

        try {
            $this->parseExcelFile($document);

            return back()->with('success', 'Document parsed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to parse document: ' . $e->getMessage()]);
        }
    }

    /**
     * Download the original document
     */
    public function download(ShippingDocument $document)
    {
        $this->authorize('view', $document);

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }

    /**
     * Remove the specified document from storage
     */
    public function destroy(ShippingDocument $document)
    {
        $this->authorize('delete', $document);

        try {
            // Delete file from storage
            Storage::disk('public')->delete($document->file_path);

            // Delete document and related items (cascade)
            $document->delete();

            return redirect()->route('dashboard.documents')
                ->with('success', 'Document deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete document: ' . $e->getMessage()]);
        }
    }

    /**
     * Display analytics dashboard
     */
    public function analytics()
    {
        $userId = auth()->id();

        // Get all processed documents for the user
        $documents = ShippingDocument::where('user_id', $userId)
            ->where('status', 'processed')
            ->with('items')
            ->get();

        // Calculate statistics
        $totalDocuments = $documents->count();
        $totalItems = $documents->sum('total_items');
        $totalValue = $documents->sum('total_amount');

        // Group by model number
        $modelStats = ShippingItem::whereIn('shipping_document_id', $documents->pluck('id'))
            ->selectRaw('model_number,
                         COUNT(*) as count,
                         SUM(quantity) as total_quantity,
                         SUM(total_price) as total_value,
                         SUM(gross_weight) as total_weight,
                         SUM(volume) as total_volume')
            ->groupBy('model_number')
            ->orderByDesc('total_quantity')
            ->get();

        // Group by category
        $categoryStats = ShippingItem::whereIn('shipping_document_id', $documents->pluck('id'))
            ->selectRaw('category,
                         COUNT(*) as count,
                         SUM(quantity) as total_quantity,
                         SUM(total_price) as total_value')
            ->whereNotNull('category')
            ->groupBy('category')
            ->get();

        // Recent documents timeline
        $recentDocuments = ShippingDocument::where('user_id', $userId)
            ->where('status', 'processed')
            ->latest()
            ->limit(10)
            ->get();

        // Monthly trend
        $monthlyTrend = ShippingDocument::where('user_id', $userId)
            ->where('status', 'processed')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month,
                         COUNT(*) as document_count,
                         SUM(total_items) as items_count,
                         SUM(total_amount) as total_value')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return Inertia::render('dashboard/documents/Analytics', [
            'stats' => [
                'totalDocuments' => $totalDocuments,
                'totalItems' => $totalItems,
                'totalValue' => $totalValue,
            ],
            'modelStats' => $modelStats,
            'categoryStats' => $categoryStats,
            'recentDocuments' => $recentDocuments,
            'monthlyTrend' => $monthlyTrend,
        ]);
    }

    /**
     * Parse Excel file and extract data
     */
    private function parseExcelFile(ShippingDocument $document)
    {
        $filePath = storage_path('app/public/' . $document->file_path);

        // Load spreadsheet
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();

        $totalAmount = 0;
        $itemCount = 0;

        // Start from row 2 (assuming row 1 is header)
        for ($row = 2; $row <= $highestRow; $row++) {
            $modelNumber = $sheet->getCell('A' . $row)->getValue();

            // Skip empty rows
            if (empty($modelNumber)) {
                continue;
            }

            $quantity = (int) $sheet->getCell('D' . $row)->getValue();
            $unitPrice = (float) $sheet->getCell('E' . $row)->getValue();
            $totalPrice = $quantity * $unitPrice;
            $totalAmount += $totalPrice;

            ShippingItem::create([
                'shipping_document_id' => $document->id,
                'model_number' => $modelNumber,
                'product_name' => $sheet->getCell('B' . $row)->getValue(),
                'category' => $sheet->getCell('C' . $row)->getValue(),
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $totalPrice,
                'carton_quantity' => (int) $sheet->getCell('F' . $row)->getValue(),
                'carton_number' => $sheet->getCell('G' . $row)->getValue(),
                'gross_weight' => (float) $sheet->getCell('H' . $row)->getValue(),
                'net_weight' => (float) $sheet->getCell('I' . $row)->getValue(),
                'volume' => (float) $sheet->getCell('J' . $row)->getValue(),
                'specifications' => $sheet->getCell('K' . $row)->getValue(),
                'notes' => $sheet->getCell('L' . $row)->getValue(),
                'row_number' => $row,
            ]);

            $itemCount++;
        }

        // Update document with totals
        $document->update([
            'total_amount' => $totalAmount,
            'total_items' => $itemCount,
            'status' => 'processed',
            'processed_at' => now(),
        ]);
    }
}
