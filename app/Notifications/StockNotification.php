<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StockNotification extends Notification
{
    use Queueable;

    public $product;
    public $currentStock;

    /**
     * Create a new notification instance.
     */
    public function __construct($product, $currentStock)
    {
        $this->product = $product;
        $this->currentStock = $currentStock;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Selalu gunakan database untuk notifikasi
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Peringatan Stok Menipis - POS System')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Stok produk menipis.')
            ->line('Produk: ' . $this->product->nama_produk)
            ->line('Stok saat ini: ' . $this->currentStock)
            ->action('Kelola Stok', route('produk.index'))
            ->line('Silakan segera tambah stok produk.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->nama_produk,
            'current_stock' => $this->currentStock,
            'message' => 'Stok ' . $this->product->nama_produk . ' menipis: ' . $this->currentStock,
        ];
    }
}
