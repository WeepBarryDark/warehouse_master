<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'eta_date',
        'container_number',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'total_amount',
        'total_items',
        'notes',
        'status',
        'processed_at',
    ];

    protected $casts = [
        'eta_date' => 'date',
        'total_amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the document
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the shipping document
     */
    public function items(): HasMany
    {
        return $this->hasMany(ShippingItem::class);
    }

    /**
     * Get the file URL
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }

    /**
     * Scope for pending documents
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for processed documents
     */
    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }
}
