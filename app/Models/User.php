<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'city_id',
        'name',
        'phone',
        'email',
        'name_bussines',
        'description',
        'is_verified',
        'plan',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_verified' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get all of the products for the User
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the qualifications for the User
     */
    public function qualifications(): HasMany
    {
        return $this->hasMany(Qualification::class);
    }

    public function viewedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_views')->withTimestamps();
    }

    public function recommendedProductsLimit(): ?int
    {
        return match ($this->plan) {
            'pro_1' => 5,
            'pro_2' => 15,
            'pro_3' => null,
            default => 0,
        };
    }

    public function recommendedProductsCount(): int
    {
        return $this->products()->where('is_recommended', true)->count();
    }

    public function canSelectRecommendations(): bool
    {
        return in_array($this->plan, ['pro_1', 'pro_2'], true);
    }

    public function canRecommendAnotherProduct(): bool
    {
        $limit = $this->recommendedProductsLimit();

        return is_null($limit) || $this->recommendedProductsCount() < $limit;
    }
}
