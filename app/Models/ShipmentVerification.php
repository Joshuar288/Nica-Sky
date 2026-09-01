<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentVerification extends Model
{
    protected $fillable = ['purchase_notification_id', 'seller_id', 'auditor_id', 'tracking_number', 'evidence_path', 'seller_notes', 'status', 'review_notes', 'reviewed_at'];

    protected function casts(): array
    {
        return ['reviewed_at' => 'datetime'];
    }

    public function seller(): BelongsTo { return $this->belongsTo(User::class, 'seller_id'); }
    public function auditor(): BelongsTo { return $this->belongsTo(User::class, 'auditor_id'); }
}
