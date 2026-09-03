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

        $items = [];

        // 1. Ambil relasi itemPenjualan sesuai skema Controller
        $details = $this->sale->itemPenjualan 
                ?? $this->sale->details 
                ?? $this->sale->detailPenjualans 
                ?? [];

        foreach ($details as $detail) {
            // Ambil nama barang dari relasi produk atau atribut lokal
            $productName = $detail->produk->nama 
                        ?? $detail->produk->nama_produk 
                        ?? $detail->produk->name 
                        ?? $detail->nama 
                        ?? $detail->nama_produk 
                        ?? null;

            if ($productName) {
                $items[] = $productName;
            }
        }

        // 2. Fallback jika relasi belum ter-load sempurna
        if (empty($items) && isset($this->sale->id)) {
            try {
                $rows = \Illuminate\Support\Facades\DB::table('item_penjualans')
                    ->where('penjualan_id', $this->sale->id)
                    ->get();

                if ($rows->isEmpty()) {
                    $rows = \Illuminate\Support\Facades\DB::table('detail_penjualans')
                        ->where('penjualan_id', $this->sale->id)
                        ->get();
                }

                foreach ($rows as $row) {
                    if (!empty($row->produk_id)) {
                        $p = \Illuminate\Support\Facades\DB::table('produks')->where('id', $row->produk_id)->first();
                        if ($p) {
                            $items[] = $p->nama ?? $p->nama_produk ?? $p->name ?? null;
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        return [
            'sale_id'   => $this->sale->id,
            'total'     => $this->total,
            'user_name' => $userName,
            'user_role' => $userRole,
            'items'     => array_values(array_filter(array_unique($items))),
            'message'   => 'Transaksi Baru #' . $this->sale->id,
        ];
    }
}