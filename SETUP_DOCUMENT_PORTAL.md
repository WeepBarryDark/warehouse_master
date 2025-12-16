# Document Management Portal Setup Guide

This guide will help you set up the Document Management Portal for uploading and managing shipping documents (装柜装箱明细).

## Features

- ✅ Upload Excel files (装柜装箱明细表)
- ✅ Automatic Excel parsing and data extraction
- ✅ Support for multiple product models (ES, EV, AQUA, EC series, Moschino)
- ✅ Document listing with search and filters
- ✅ Detailed document view with item breakdown
- ✅ Download original files
- ✅ Bilingual support (English & Chinese)

## Installation Steps

### 1. Install PHP Dependencies

First, install the PhpSpreadsheet library for Excel parsing:

```bash
composer require phpoffice/phpspreadsheet
```

### 2. Run Database Migrations

Run the migrations to create the necessary tables:

```bash
php artisan migrate
```

This will create two tables:
- `shipping_documents` - Main document records
- `shipping_items` - Individual items from each document

### 3. Configure Storage

Make sure the storage link is created:

```bash
php artisan storage:link
```

### 4. Add Routes

Add the following routes to `routes/web.php`:

```php
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    // ... existing routes ...

    // Shipping Documents
    Route::get('/documents', [ShippingDocumentController::class, 'index'])->name('dashboard.documents');
    Route::get('/documents/create', [ShippingDocumentController::class, 'create'])->name('dashboard.documents.create');
    Route::post('/documents', [ShippingDocumentController::class, 'store'])->name('dashboard.documents.store');
    Route::get('/documents/{document}', [ShippingDocumentController::class, 'show'])->name('dashboard.documents.show');
    Route::post('/documents/{document}/parse', [ShippingDocumentController::class, 'parse'])->name('dashboard.documents.parse');
    Route::get('/documents/{document}/download', [ShippingDocumentController::class, 'download'])->name('dashboard.documents.download');
    Route::delete('/documents/{document}', [ShippingDocumentController::class, 'destroy'])->name('dashboard.documents.destroy');
});
```

### 5. Register Policy

Add the ShippingDocumentPolicy to `app/Providers/AuthServiceProvider.php`:

```php
use App\Models\ShippingDocument;
use App\Policies\ShippingDocumentPolicy;

protected $policies = [
    ShippingDocument::class => ShippingDocumentPolicy::class,
];
```

## Excel File Format

The system expects Excel files with the following column structure:

| Column | Field | Description |
|--------|-------|-------------|
| A | Model Number | 型号 (e.g., ES-01, EV-07, AQUA-003) |
| B | Product Name | 产品名称 |
| C | Category | 分类 |
| D | Quantity | 数量 |
| E | Unit Price | 单价 |
| F | Carton Quantity | 箱数 |
| G | Carton Number | 箱号 |
| H | Gross Weight | 毛重 (kg) |
| I | Net Weight | 净重 (kg) |
| J | Volume | 体积 (m³) |
| K | Specifications | 规格 |
| L | Notes | 备注 |

### Supported Model Numbers

The system recognizes the following product series:

- **ES Series**: ES-01, ES-02, ES-03, ES-09
- **EV Series**: EV-01, EV-06, EV-07, EV-09
- **AQUA Series**: AQUA-003
- **EC Series**: EC03, EC04, EC13
- **Other**: Moschino, and more

## Usage

### Uploading a Document

1. Navigate to **Documents → Upload Document** from the sidebar
2. Click to upload or drag-and-drop your Excel file
3. Fill in optional details:
   - Order/Batch Number (订单号)
   - ETA Date (预计到达时间)
   - Container Number (柜号)
   - Notes (备注)
4. Check "Automatically parse and import data" to process the file immediately
5. Click "Upload Document"

### Viewing Documents

1. Navigate to **Documents → Document List**
2. View all uploaded documents with their status
3. Click on any document to view detailed information
4. Download original files or delete documents as needed

### Parsing Documents

If you didn't enable auto-parse during upload:

1. Go to the document details page
2. Click "Parse Document" button
3. The system will extract all items from the Excel file

## Database Schema

### shipping_documents Table

```sql
- id: Primary key
- user_id: User who uploaded
- order_number: Order/batch number (e.g., LM250220-2C)
- eta_date: Estimated time of arrival
- container_number: Container/柜号
- file_name: Original filename
- file_path: Storage path
- file_type: File extension (xlsx, xls, csv)
- file_size: File size in bytes
- total_amount: Total货款
- total_items: Number of items
- notes: Additional notes
- status: pending, processed, failed
- processed_at: When the file was parsed
- created_at, updated_at
- deleted_at: Soft delete
```

### shipping_items Table

```sql
- id: Primary key
- shipping_document_id: Foreign key to documents
- model_number: Product model (型号)
- product_name: Product name
- category: Category
- quantity: Quantity
- carton_quantity: Number of cartons
- unit_price: Price per unit
- total_price: Total price
- carton_number: Carton number
- gross_weight: Gross weight (kg)
- net_weight: Net weight (kg)
- volume: Volume (m³)
- specifications: Product specs
- notes: Item notes
- row_number: Excel row number
- created_at, updated_at
```

## Customization

### Adjusting Column Mapping

If your Excel files use a different column structure, edit the `parseExcelFile()` method in `ShippingDocumentController.php`:

```php
private function parseExcelFile(ShippingDocument $document)
{
    // Adjust column letters to match your Excel format
    $modelNumber = $sheet->getCell('A' . $row)->getValue();  // Change 'A' to your column
    $productName = $sheet->getCell('B' . $row)->getValue();  // Change 'B' to your column
    // ... etc
}
```

### Adding New Fields

1. Create a migration to add columns to the tables
2. Update the model's `$fillable` array
3. Modify the parsing logic in the controller
4. Update the frontend components to display the new fields

## Troubleshooting

### File Upload Fails

- Check that `storage/app/public` is writable
- Verify `storage:link` was created successfully
- Check PHP `upload_max_filesize` and `post_max_size` settings

### Excel Parsing Errors

- Ensure the first row contains headers
- Check that data starts from row 2
- Verify column letters match the expected format
- Check error logs: `storage/logs/laravel.log`

### Permission Errors

- Verify the policy is registered in AuthServiceProvider
- Check user authentication middleware
- Ensure users can only access their own documents

## Next Steps

### Recommended Enhancements

1. **Export Functionality**: Add ability to export document data to Excel/CSV
2. **Batch Operations**: Delete or download multiple documents at once
3. **Advanced Search**: Filter by date range, model numbers, status
4. **Statistics Dashboard**: Show trends and analytics
5. **Email Notifications**: Alert users when documents are processed
6. **Template Validation**: Verify Excel structure before parsing
7. **Backup System**: Automatic backup of uploaded files

## Support

For issues or questions:
- Check the Laravel logs: `storage/logs/laravel.log`
- Review the browser console for frontend errors
- Verify database migrations ran successfully

---

Created for Warehouse Management System
装柜装箱明细管理系统
