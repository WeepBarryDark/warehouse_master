<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingItem extends Model
{
    protected $fillable = [
        'shipping_document_id',
        'model_number',
        'product_name',
        'category',
        'quantity',
        'carton_quantity',
        'unit_price',
        'total_price',
        'carton_number',
        'gross_weight',
        'net_weight',
        'volume',
        'specifications',
        'notes',
        'row_number',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'gross_weight' => 'decimal:2',
        'net_weight' => 'decimal:2',
        'volume' => 'decimal:3',
    ];

    /**
     * Get the shipping document that owns the item
     */
    public function shippingDocument(): BelongsTo
    {
        return $this->belongsTo(ShippingDocument::class);
    }

    /**
     * Calculate total price based on quantity and unit price
     */
    public function calculateTotalPrice(): void
    {
        if ($this->quantity && $this->unit_price) {
            $this->total_price = $this->quantity * $this->unit_price;
        }
    }
}
