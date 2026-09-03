@extends('layouts.app')

@section('title', 'Notifikasi - POS System')

@section('content')
@php
    $currentUser = $user ?? auth()->user();
    $unreadCount = $currentUser ? $currentUser->unreadNotifications->count() : 0;
@endphp

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #9333ea 100%);
        --card-bg: #ffffff;
        --card-border: #e9d5ff;
        --text-heading: #2e1065;
        --text-body: #4c1d95;
        --text-muted: #6b21a8;
        --radius-lg: 20px;
        --radius-md: 14px;
    }

    body {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%) !important;
        color: var(--text-body) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .dashboard-header-banner {
        background: var(--primary-gradient) !important;
        border-radius: var(--radius-lg);
        padding: 2.5rem 2.25rem;
        color: #ffffff !important;
        box-shadow: 0 10px 25px -5px rgba(124, 58, 237, 0.35);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header-banner::after {
        content: '';
        position: absolute;
        top: -40%;
        right: -8%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.12);
        border-radius: 50%;
        pointer-events: none;
    }

    .date-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50px;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dashboard-card {
        border-radius: var(--radius-md);
        border: 1px solid var(--card-border) !important;
        background: var(--card-bg) !important;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.04);
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .notification-item {
        border-left: 4px solid;
        transition: all 0.25s ease;
        background: #ffffff;
    }

    .notification-item.unread {
        border-left-color: #7c3aed;
        background: #fcfaff;
    }

    .notification-item.read {
        border-left-color: #e9d5ff;
        background: #ffffff;
    }

    .notification-item:hover {
        transform: translateY(-1px);
    }

    .btn-mark-read {
        border: 1px solid #d8b4fe !important;
        background: #ffffff !important;
        color: #2e1065 !important;
        border-radius: 50px;
        padding: 0.3rem 1.1rem;
        font-size: 0.825rem;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(124, 58, 237, 0.06);
        transition: all 0.25s ease;
    }

    .btn-mark-read:hover {
        background: #f3e8ff !important;
        border-color: #c084fc !important;
    }

    .notification-time {
        font-size: 0.85rem;
        color: #7e22ce !important;
        font-weight: 500;
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    {{-- HEADER BANNER --}}
    <div class="dashboard-header-banner mb-4">
        <div class="row align-items-center g-3 position-relative" style="z-index: 1;">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <div class="date-badge">
                        <i class="bi bi-bell"></i>
                        <span>Notifikasi</span>
                    </div>
                    @if($unreadCount > 0)
                    <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background: #ef4444; color: white; font-size: 0.85rem;">
                        {{ $unreadCount }} Belum Dibaca
                    </span>
                    @endif
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    Riwayat Notifikasi
                </h1>
                <p class="text-white-50 mb-0 fs-6">Pantau semua pemberitahuan penjualan dan stok di sini.</p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex gap-2 justify-content-lg-end">
                    @if($unreadCount > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light rounded-pill px-4 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                            <i class="bi bi-check-all"></i>
                            <span>Tandai Semua Dibaca</span>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card dashboard-card p-4">
                @if(isset($notifications) && $notifications->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notification)
                            @php
                                $data = is_array($notification->data) ? $notification->data : (json_decode($notification->data, true) ?? []);
                                $mainMessage = $data['message'] ?? $data['title'] ?? null;

                                // 1. Deteksi Nama Produk Notifikasi Stok
                                $produkName = $data['produk_name']
                                    ?? $data['product_name']
                                    ?? $data['nama_produk']
                                    ?? $data['produk']
                                    ?? $data['product']
                                    ?? $data['item_name']
                                    ?? $data['name']
                                    ?? null;

                                $produkId = $data['produk_id'] ?? $data['product_id'] ?? null;

                                if (empty($produkName) && $mainMessage) {
                                    if (preg_match('/Stok\s+(.*?)\s+menipis/i', $mainMessage, $matches)) {
                                        $produkName = trim($matches[1]);
                                    }
                                }

                                if (empty($produkName) && $produkId && class_exists('App\Models\Produk')) {
                                    try {
                                        $produkObj = \App\Models\Produk::find($produkId);
                                        if ($produkObj) {
                                            $produkName = $produkObj->name ?? $produkObj->nama_produk ?? $produkObj->nama ?? null;
                                        }
                                    } catch (\Throwable $e) {}
                                }

                                // 2. Deteksi Nilai Sisa Stok
                                $stockValue = $data['current_stock'] ?? $data['stok'] ?? $data['stock'] ?? null;
                                if (is_null($stockValue) && $mainMessage) {
                                    if (preg_match('/tersisa\s+(\d+)/i', $mainMessage, $matches)) {
                                        $stockValue = $matches[1];
                                    } elseif (preg_match('/:\s*(\d+)/', $mainMessage, $matches)) {
                                        $stockValue = $matches[1];
                                    }
                                }

                                // 3. Tipe Notifikasi
                                $isStockNotif = $notification->type === 'App\Notifications\StockNotification' || !is_null($stockValue) || (!empty($produkName) && !isset($data['sale_id']) && !isset($data['penjualan_id']) && !isset($data['total']));

                                // 4. EKSTRAKSI NAMA PRODUK TRANSAKSI PENJUALAN
                                $saleProducts = [];

                                // A. Cek dari JSON Data Notifikasi
                                $rawItems = $data['items'] ?? $data['products'] ?? $data['produk'] ?? $data['details'] ?? $data['cart'] ?? $data['order_items'] ?? null;
                                if (is_array($rawItems)) {
                                    foreach ($rawItems as $item) {
                                        if (is_array($item)) {
                                            $saleProducts[] = $item['name'] ?? $item['nama_produk'] ?? $item['product_name'] ?? $item['nama'] ?? $item['title'] ?? null;
                                        } elseif (is_string($item)) {
                                            $saleProducts[] = $item;
                                        }
                                    }
                                } elseif (is_string($rawItems)) {
                                    $saleProducts[] = $rawItems;
                                }

                                if (isset($data['items_summary'])) $saleProducts[] = $data['items_summary'];
                                if (isset($data['produk_name'])) $saleProducts[] = $data['produk_name'];
                                if (isset($data['product_name'])) $saleProducts[] = $data['product_name'];

                                // B. Ambil ID Transaksi
                                $saleId = $data['sale_id'] ?? $data['penjualan_id'] ?? $data['transaction_id'] ?? $data['order_id'] ?? $data['id'] ?? null;
                                if (!$saleId && $mainMessage) {
                                    if (preg_match('/#(\d+)/', $mainMessage, $matches)) {
                                        $saleId = $matches[1];
                                    }
                                }

                                // C. SCAN OTOMATIS SELURUH TABEL DATABASE
                                if (empty(array_filter($saleProducts)) && $saleId) {
                                    try {
                                        $allTables = \Illuminate\Support\Facades\Schema::getTableListing();

                                        foreach ($allTables as $table) {
                                            $cols = \Illuminate\Support\Facades\Schema::getColumnListing($table);
                                            
                                            $idCols = array_filter($cols, function($c) {
                                                return (bool) preg_match('/penjualan_id|sale_id|transaksi_id|order_id|header_id|checkout_id/i', $c);
                                            });

                                            if (!empty($idCols)) {
                                                foreach ($idCols as $fkCol) {
                                                    $rows = \Illuminate\Support\Facades\DB::table($table)->where($fkCol, $saleId)->get();
                                                    if ($rows->isNotEmpty()) {
                                                        foreach ($rows as $row) {
                                                            $foundName = null;
                                                            foreach (['nama_produk', 'product_name', 'nama', 'name', 'item_name', 'produk'] as $nc) {
                                                                if (isset($row->$nc) && !empty($row->$nc)) {
                                                                    $foundName = $row->$nc;
                                                                    break;
                                                                }
                                                            }

                                                            if (!$foundName) {
                                                                foreach (['produk_id', 'product_id', 'item_id', 'barang_id'] as $pFk) {
                                                                    if (isset($row->$pFk) && !empty($row->$pFk)) {
                                                                        foreach ($allTables as $pTable) {
                                                                            if (preg_match('/produk|product|item|barang/i', $pTable) && !preg_match('/detail|item_sale|line|histori|log/i', $pTable)) {
                                                                                $pRow = \Illuminate\Support\Facades\DB::table($pTable)->where('id', $row->$pFk)->first();
                                                                                if ($pRow) {
                                                                                    foreach (['nama_produk', 'name', 'nama', 'product_name', 'title'] as $pNc) {
                                                                                        if (isset($pRow->$pNc) && !empty($pRow->$pNc)) {
                                                                                            $foundName = $pRow->$pNc;
                                                                                            break 2;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                            if ($foundName) {
                                                                $saleProducts[] = $foundName;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } catch (\Throwable $e) {}
                                }

                                $saleProductsStr = implode(', ', array_filter(array_unique($saleProducts)));

                                // 5. Judul Notifikasi
                                if ($isStockNotif) {
                                    $displayTitle = !is_null($stockValue) ? "Stok menipis: " . $stockValue : ($mainMessage ?? 'Stok Menipis');
                                } else {
                                    $displayTitle = $saleId ? "Transaksi Baru #" . $saleId : ($mainMessage ?? "Transaksi Baru");
                                }
                            @endphp

                            <div class="list-group-item notification-item {{ $notification->read_at ? 'read' : 'unread' }} p-3 p-md-4 mb-3 rounded-3 border" style="border-color: var(--card-border) !important;">
                                <div class="d-flex align-items-start gap-3">
                                    
                                    {{-- Icon Notifikasi --}}
                                    <div class="flex-shrink-0 mt-1">
                                        @if($isStockNotif)
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
                                                <i class="bi bi-box-seam-fill fs-5"></i>
                                            </div>
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                                                <i class="bi bi-cart-check-fill fs-5"></i>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Konten Utama Notifikasi --}}
                                    <div class="flex-grow-1">
                                        
                                        {{-- Baris 1: Judul & Badge Baru --}}
                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                            <h6 class="fw-bold mb-0" style="color: var(--text-heading); font-size: 1rem;">
                                                {{ $displayTitle }}
                                            </h6>
                                            @if(!$notification->read_at)
                                                <span class="badge rounded-pill px-3 py-1 fw-semibold flex-shrink-0" style="background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%); color: white; font-size: 0.75rem;">Baru</span>
                                            @endif
                                        </div>

                                        {{-- Baris 2: Subtitle Produk / Total --}}
                                        <div class="mb-3">
                                            @if($isStockNotif && $produkName)
                                                <div class="fw-bold text-danger d-flex align-items-center gap-1" style="font-size: 0.9rem;">
                                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                                    <span>Produk Kritis: {{ $produkName }}</span>
                                                </div>
                                            @else
                                                @if(isset($data['total']))
                                                    <div class="fw-bold text-success d-flex align-items-center gap-1" style="font-size: 0.9rem;">
                                                        <i class="bi bi-cash-stack"></i>
                                                        <span>Total: Rp {{ number_format($data['total'], 0, ',', '.') }}</span>
                                                    </div>
                                                @endif

                                                {{-- Menampilkan Daftar Produk --}}
                                                @if(!empty($saleProductsStr))
                                                    <div class="fw-medium d-flex align-items-center gap-1 mt-1" style="font-size: 0.875rem; color: #4c1d95;">
                                                        <i class="bi bi-bag-check-fill text-primary"></i>
                                                        <span>Produk: <strong>{{ $saleProductsStr }}</strong></span>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        {{-- Baris 3: Waktu & Tombol Action --}}
                                        <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(233, 213, 255, 0.4) !important;">
                                            <span class="notification-time">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            @if(!$notification->read_at)
                                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline mb-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-mark-read">
                                                        <i class="bi bi-check-lg me-1"></i> Tandai Dibaca
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bi bi-bell-slash" style="font-size: 4rem; color: var(--text-muted);"></i>
                        </div>
                        <h4 class="fw-bold" style="color: var(--text-heading);">Belum Ada Notifikasi</h4>
                        <p class="text-muted">Semua pemberitahuan akan muncul di sini setelah ada aktivitas baru.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection