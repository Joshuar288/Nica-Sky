<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductPurchasedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly array $purchase)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return $this->purchase;
    }
}
