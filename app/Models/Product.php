<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'price',
        'unit',
        'stock',
        'state',
        'is_recommended',
    ];

    protected function casts(): array
    {
        return [
            'views_count' => 'integer',
            'is_recommended' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the Product
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the Product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the images for the Product
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get all of the qualifications for the Product
     */
    public function qualifications(): HasMany
    {
        return $this->hasMany(Qualification::class);
    }

    public function viewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_views')->withTimestamps();
    }
}
