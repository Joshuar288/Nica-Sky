<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'rute',
        'is_first',
    ];

    protected $casts = [
        'is_first' => 'boolean',
    ];

    /**
     * Get the product that owns the Image
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
