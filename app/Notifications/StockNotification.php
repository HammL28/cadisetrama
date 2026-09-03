<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Produk;

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
        // Jika yang dikirim hanya ID produk (angka), cari objek Produk di database
        if (is_numeric($product)) {
            $product = Produk::find($product);
        }

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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $namaProduk = is_object($this->product) 
            ? ($this->product->nama_produk ?? $this->product->name ?? $this->product->nama ?? 'Produk') 
            : 'Produk';

        return (new MailMessage)
            ->subject('Peringatan Stok Menipis - POS System')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Stok produk menipis.')
            ->line('Produk: ' . $namaProduk)
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
        $productId = is_object($this->product) ? $this->product->id : $this->product;
        
        $productName = is_object($this->product) 
            ? ($this->product->nama_produk ?? $this->product->name ?? $this->product->nama ?? 'Produk #' . $productId) 
            : 'Produk #' . $productId;

        return [
            'title'         => 'Stok Menipis: ' . $productName,
            'message'       => 'Stok ' . $productName . ' menipis, tersisa ' . $this->currentStock . ' unit.',
            'product_id'    => $productId,
            'produk_id'     => $productId,
            'product_name'  => $productName,
            'produk_name'   => $productName,
            'nama_produk'   => $productName,
            'current_stock' => $this->currentStock,
            'stok'          => $this->currentStock,
        ];
    }
}