<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SaleNotification extends Notification
{
    use Queueable;

    public $sale;
    public $total;
    public $userName;
    public $userRole;

    /**
     * Create a new notification instance.
     */
    public function __construct($sale, $total, $userName = null, $userRole = null)
    {
        $this->sale = $sale;
        $this->total = $total;
        $this->userName = $userName;
        $this->userRole = $userRole;
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
        $userName = $this->userName ?? $this->sale->user->name ?? 'User';
        $userRole = $this->userRole ?? ucfirst($this->sale->user->role->name ?? $this->sale->user->role->NAME ?? 'User');
        
        return (new MailMessage)
            ->subject('Penjualan Baru - POS System')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Ada penjualan baru di sistem.')
            ->line('ID Transaksi: #' . $this->sale->id)
            ->line('Oleh: ' . $userName . ' (' . $userRole . ')')
            ->line('Total: Rp ' . number_format($this->total, 0, ',', '.'))
            ->action('Lihat Detail', route('penjualan.show', $this->sale))
            ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $userName = $this->userName ?? $this->sale->user->name ?? 'User';
        $userRole = $this->userRole ?? ucfirst($this->sale->user->role->name ?? $this->sale->user->role->NAME ?? 'User');
        
        return [
            'sale_id' => $this->sale->id,
            'total' => $this->total,
            'user_name' => $userName,
            'user_role' => $userRole,
            'message' => 'Penjualan baru #' . $this->sale->id . ' oleh ' . $userName . ' (' . $userRole . ') dengan total Rp ' . number_format($this->total, 0, ',', '.'),
        ];
    }
}
