<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'ranked',
        'coment',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the user that owns the Qualification
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the Qualification
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
