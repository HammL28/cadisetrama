@extends('layouts.app')

@section('title', 'Kasir & Penjualan (POS)')

@section('content')

<!-- SweetAlert2 & Font/Icons -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --primary-purple: #6d28d9;
        --primary-hover: #5b21b6;
        --secondary-purple: #8b5cf6;
        --light-bg: #f8fafc;
        --card-border: #e2e8f0;
        --accent-purple-light: #f3e8ff;
    }

    body {
        background-color: var(--light-bg) !important;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }

    /* POS Banner Header */
    .pos-header-card {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%);
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 10px 20px -5px rgba(124, 58, 237, 0.3);
    }

    /* POS Main Container Cards */
    .pos-card {
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        background: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
    }

    /* Product Grid Layout */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(165px, 1fr));
        gap: 1rem;
    }

    .product-card {
        border: 1px solid var(--card-border);
        border-radius: 1rem;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
    }

    .product-card:hover {
        border-color: var(--secondary-purple);
        transform: translateY(-3px);
        box-shadow: 0 10px 18px -6px rgba(109, 40, 217, 0.15);
    }

    .product-img-wrapper {
        width: 100%;
        height: 105px;
        background-color: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid #f1f5f9;
    }

    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .qty-input-group {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .qty-input-group .form-control {
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.3rem 0.4rem;
        border: 1px solid #cbd5e1;
        color: #1e293b;
    }

    .btn-add-item {
        background-color: var(--primary-purple);
        color: #ffffff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.35rem 0.7rem;
        font-weight: 600;
        transition: background 0.2s;
    }

    .btn-add-item:hover {
        background-color: var(--primary-hover);
        color: #ffffff;
    }

    /* Sticky Cart Container */
    .cart-sticky-container {
        position: sticky;
        top: 1.5rem;
    }

    /* Modern Cart Item List */
    .cart-items-container {
        max-height: 380px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 2px;
    }

    .cart-items-container::-webkit-scrollbar {
        width: 4px;
    }
    .cart-items-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .cart-item-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem;
        background-color: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 0.75rem;
        margin-bottom: 0.6rem;
        transition: border-color 0.2s;
    }

    .cart-item-row:hover {
        border-color: #e2e8f0;
        background-color: #fafafc;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
        padding-right: 0.5rem;
    }

    /* Badge Harga Eceran Modern */
    .unit-price-badge {
        font-size: 0.7rem;
        color: #64748b;
        background-color: #f1f5f9;
        padding: 1px 6px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 500;
        margin-top: 2px;
    }

    /* Qty Stepper Controls */
    .cart-qty-stepper {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 0.5rem;
        padding: 2px;
        border: 1px solid #e2e8f0;
    }

    .cart-qty-btn {
        border: none;
        background: #ffffff;
        color: var(--primary-purple);
        width: 22px;
        height: 22px;
        border-radius: 0.35rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
        cursor: pointer;
        transition: all 0.15s;
    }

    .cart-qty-btn:hover:not(:disabled) {
        background: var(--primary-purple);
        color: #ffffff;
    }

    .cart-qty-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .cart-qty-val {
        width: 24px;
        border: none;
        background: transparent;
        text-align: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: #0f172a !important;
        padding: 0;
    }

    /* Trash Button */
    .btn-delete-cart {
        background-color: #fef2f2;
        color: #ef4444;
        border: 1px solid #fee2e2;
        width: 28px;
        height: 28px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-delete-cart:hover:not(:disabled) {
        background-color: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    .payment-summary-box {
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
        border: 1.5px dashed var(--secondary-purple);
        border-radius: 1rem;
    }

    /* ==========================================
       TAMPILAN KHUSUS STRUK CETAK THERMAL (PRINT)
       ========================================== */
    #receipt-print {
        display: none; /* Sembunyikan di tampilan layar biasa */
    }

    @media print {
        body * {
            visibility: hidden; /* Sembunyikan seluruh tampilan web saat print */
        }
        #receipt-print, #receipt-print * {
            visibility: visible; /* Hanya tampilkan elemen struk */
        }
        #receipt-print {
            display: block !important;
            position: absolute;
            left: 0;
            top: 0;
            width: 80mm; /* Ukuran Kertas Kasir Standard (Thermal 80mm) */
            padding: 5px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            background: #fff;
        }
        .receipt-dashed {
            border-top: 1px dashed #000;
            margin: 6px 0;
        }
        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-table td {
            padding: 2px 0;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-4">

    {{-- NOTIFIKASI ERROR / SUCCESS --}}
    @if(session('errors'))
        <div class="alert alert-danger rounded-4 shadow-sm mb-4 border-0 border-start border-4 border-danger">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>
                    @if(is_object(session('errors')) && method_exists(session('errors'), 'all'))
                        @foreach(session('errors')->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    @else
                        {{ session('errors') }}
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success rounded-4 shadow-sm mb-4 border-0 border-start border-4 border-success">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    {{-- HEADER BANNER --}}
    <div class="card pos-header-card p-4 mb-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 text-white">
            <div>
                <h3 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-calculator-fill"></i> Kasir & Penjualan (POS)
                </h3>
                <p class="opacity-75 small mb-0">Kelola transaksi penjualan barang dengan cepat, efisien, dan praktis.</p>
            </div>
            <div>
                <a href="{{ route('penjualan.index') }}" class="btn btn-light rounded-pill px-4 fw-semibold shadow-sm d-inline-flex align-items-center gap-2" style="color: var(--primary-purple);">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- KATALOG PRODUK (SISI KIRI) --}}
        <div class="col-lg-7 col-xl-8">
            <div class="pos-card p-4 h-100">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="fw-bold mb-0 text-dark">Katalog Barang</h5>
                        <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background-color: var(--accent-purple-light); color: var(--primary-purple);">
                            {{ count($products) }} Produk
                        </span>
                    </div>

                    {{-- Search Input --}}
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control bg-light border-start-0 rounded-end-pill shadow-none" placeholder="Cari barang..." onkeyup="filterProducts()">
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="product-grid" id="productList">
                    @forelse($products as $product)
                        <div class="product-item" data-name="{{ strtolower($product->nama) }}">
                            <div class="product-card p-2.5 h-100">

                                {{-- Image / Icon Handler --}}
                                <div class="product-img-wrapper rounded-3 mb-2">
                                    @php
                                        $fotoPath = $product->foto ?? $product->gambar ?? $product->image ?? null;
                                        $isUnsplash = $fotoPath && \Illuminate\Support\Str::contains($fotoPath, 'unsplash');
                                        
                                        if ($fotoPath && !$isUnsplash) {
                                            $imageUrl = \Illuminate\Support\Str::startsWith($fotoPath, ['http://', 'https://']) 
                                                ? $fotoPath 
                                                : asset('storage/' . $fotoPath);
                                        } else {
                                            $imageUrl = null;
                                        }
                                    @endphp

                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $product->nama }}">
                                    @else
                                        <i class="bi bi-box-seam text-secondary fs-2"></i>
                                    @endif
                                </div>

                                {{-- Detail Produk --}}
                                <div class="px-1 mb-2">
                                    <div class="fw-bold text-dark text-truncate small mb-0.5" title="{{ $product->nama }}">
                                        {{ $product->nama }}
                                    </div>
                                    <div class="fw-extrabold small" style="color: var(--primary-purple); font-size: 0.9rem;">
                                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                    </div>
                                    @if(isset($product->stok))
                                        <div class="text-muted" style="font-size: 0.725rem;">
                                            Stok: 
                                            <span class="fw-semibold {{ $product->stok <= 5 ? 'text-danger' : 'text-dark' }}">
                                                {{ $product->stok }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Form Tambah ke Keranjang --}}
                                <form method="POST" action="{{ route('itempenjualan.store') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                                    <div class="qty-input-group">
                                        <input type="number" name="quantity" value="1" min="1" 
                                               @if(isset($product->stok)) max="{{ $product->stok }}" @endif 
                                               class="form-control text-center shadow-none" 
                                               {{ $sale->status === 'COMPLETED' || (isset($product->stok) && $product->stok <= 0) ? 'disabled' : '' }}>
                                        
                                        <button type="submit" 
                                                class="btn btn-add-item shadow-sm d-flex align-items-center justify-content-center {{ $sale->status === 'COMPLETED' || (isset($product->stok) && $product->stok <= 0) ? 'disabled' : '' }}" 
                                                title="Tambah ke Keranjang">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted col-12">
                            <i class="bi bi-box-seam fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            <span class="fw-semibold">Tidak ada produk tersedia.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- KERANJANG BELANJA (SISI KANAN) --}}
        <div class="col-lg-5 col-xl-4">
            <div class="cart-sticky-container">
                <div class="pos-card p-3 p-md-4">
                    
                    {{-- Cart Header --}}
                    <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cart3 fs-4" style="color: var(--primary-purple);"></i>
                            <h5 class="fw-bold mb-0">Keranjang</h5>
                        </div>
                        <span class="badge rounded-pill text-white px-3 py-1.5 fw-semibold" style="background-color: var(--primary-purple);">
                            TRX #{{ $sale->id }}
                        </span>
                    </div>

                    {{-- Item List Keranjang --}}
                    <div class="cart-items-container mb-3">
                        @forelse($sale->itemPenjualan as $item)
                            <div class="cart-item-row">
                                
                                {{-- Detail Nama & Harga --}}
                                <div class="cart-item-info">
                                    <div class="fw-bold text-dark small text-truncate" title="{{ $item->produk->nama }}">
                                        {{ $item->produk->nama }}
                                    </div>
                                    <div class="unit-price-badge">
                                        Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }} / pcs
                                    </div>
                                </div>

                                {{-- Qty Control Stepper --}}
                                <div class="me-2">
                                    <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <div class="cart-qty-stepper">
                                            <button type="submit" name="action" value="decrease" class="cart-qty-btn" {{ $sale->status === 'COMPLETED' || $item->kuantitas <= 1 ? 'disabled' : '' }}>
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            
                                            <input type="text" name="quantity" value="{{ $item->kuantitas }}" readonly class="cart-qty-val">
                                            
                                            <button type="submit" name="action" value="increase" class="cart-qty-btn" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                {{-- Subtotal --}}
                                <div class="text-end me-2" style="min-width: 65px;">
                                    <div class="fw-extrabold small" style="color: var(--primary-purple); font-size: 0.85rem;">
                                        {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- Tombol Hapus --}}
                                <div>
                                    @can('delete', $item)
                                        <form id="delete-item-{{ $item->id }}" method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteItem({{ $item->id }})" class="btn-delete-cart" title="Hapus Item" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                                <i class="bi bi-trash3-fill" style="font-size: 0.75rem;"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>

                            </div>
                        @empty
                            <div class="text-center py-4 text-muted bg-light rounded-4 border border-dashed">
                                <i class="bi bi-cart-x fs-2 d-block mb-1 text-secondary opacity-50"></i>
                                <span class="small fw-semibold">Keranjang belanja kosong.</span>
                            </div>
                        @endforelse
                    </div>

                    {{-- RINGKASAN & PEMBAYARAN --}}
                    <div class="payment-summary-box p-3 mb-3 text-center">
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1" style="letter-spacing: 0.5px;">Total Bayar</span>
                        <h2 class="fw-extrabold mb-0" style="color: var(--primary-purple); font-weight: 800;">
                            Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                        </h2>
                    </div>

                    <form id="checkoutForm" method="POST" action="{{ route('penjualan.update', $sale->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <select id="paymentMethodSelect" name="payment_method" class="form-select rounded-pill px-3 shadow-none bg-light border" required {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                <option value="">-- Pilih Pembayaran --</option>
                                <option value="CASH" {{ ($sale->metode_pembayaran ?? '') === 'CASH' ? 'selected' : '' }}>Cash / Tunai</option>
                                <option value="QRIS" {{ ($sale->metode_pembayaran ?? '') === 'QRIS' ? 'selected' : '' }}>QRIS (Scan Barcode)</option>
                                <option value="TRANSFER" {{ ($sale->metode_pembayaran ?? '') === 'TRANSFER' ? 'selected' : '' }}>Transfer Bank</option>
                            </select>
                        </div>

                        <button type="button" onclick="handleCheckout()" class="btn btn-success w-100 rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Selesaikan Transaksi</span>
                        </button>
                    </form>

                    {{-- TOMBOL CETAK STRUK --}}
                    @if($sale->status === 'COMPLETED')
                        <button type="button" onclick="window.print()" class="btn btn-dark w-100 rounded-pill py-2 mt-2 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-sm">
                            <i class="bi bi-printer-fill"></i>
                            <span>Cetak Struk</span>
                        </button>
                    @endif

                    @can('delete', $sale)
                        <form id="cancelTransactionForm" action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmCancelTransaction()" class="btn btn-link text-danger w-100 text-decoration-none small fw-semibold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                Batalkan Transaksi
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODAL QRIS --}}
<div class="modal fade" id="qrisModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header text-white border-0 py-3" style="background-color: var(--primary-purple);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-qr-code-scan"></i> Pembayaran QRIS
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="text-muted small mb-3">Scan QR Code menggunakan aplikasi E-Wallet / Bank Anda.</p>
                
                <div class="payment-summary-box p-3 d-inline-block shadow-sm mb-3">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=POS-TRX-{{ $sale->id }}-TOTAL-{{ $sale->total_pembayaran }}" alt="QRIS Code" class="img-fluid rounded-3 mb-2">
                    <div class="small fw-bold text-muted"><i class="bi bi-shield-check text-success"></i> STANDAR QRIS NATIONAL</div>
                </div>

                <div class="fw-bold fs-3 mb-2" style="color: var(--primary-purple);">
                    Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                </div>
                
                <div class="badge bg-warning text-dark px-3 py-2 rounded-pill small mb-4">
                    <i class="bi bi-clock"></i> Sisa Waktu: <span id="qrisTimer">05:00</span>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" onclick="submitFinalCheckout()" class="btn btn-success fw-bold rounded-pill py-2.5">
                        Konfirmasi Sudah Bayar
                    </button>
                    <button type="button" class="btn btn-light rounded-pill text-muted" data-bs-dismiss="modal">
                        Kembali / Ganti Metode
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TEMPLATE NOTA / STRUK KHUSUS PRINT PRINTER THERMAL KASIR --}}
<div id="receipt-print">
    <div style="text-align: center;">
        <h3 style="margin: 0; font-size: 16px; font-weight: bold;">TOKO KASIR POS</h3>
        <p style="margin: 2px 0;">Jl. Raya Utama No. 123</p>
        <p style="margin: 0;">Telp: 0812-3456-7890</p>
    </div>

    <div class="receipt-dashed"></div>

    <table class="receipt-table">
        <tr>
            <td>No. Trx</td>
            <td style="text-align: right;">#{{ $sale->id }}</td>
        </tr>
        <tr>
            <td>Tgl</td>
            <td style="text-align: right;">{{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Metode</td>
            <td style="text-align: right;">{{ $sale->metode_pembayaran ?? 'CASH' }}</td>
        </tr>
    </table>

    <div class="receipt-dashed"></div>

    {{-- Detail Item Belanja --}}
    <table class="receipt-table">
        @foreach($sale->itemPenjualan as $item)
            <tr>
                <td colspan="2" style="font-weight: bold;">{{ $item->produk->nama }}</td>
            </tr>
            <tr>
                <td>{{ $item->kuantitas }} x {{ number_format($item->produk->harga_jual, 0, ',', '.') }}</td>
                <td style="text-align: right;">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="receipt-dashed"></div>

    {{-- Total Pembayaran --}}
    <table class="receipt-table">
        <tr style="font-weight: bold; font-size: 14px;">
            <td>TOTAL</td>
            <td style="text-align: right;">Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="receipt-dashed"></div>

    <div style="text-align: center; margin-top: 10px;">
        <p style="margin: 0; font-weight: bold;">-- TERIMA KASIH --</p>
        <p style="margin: 2px 0;">Barang yang sudah dibeli</p>
        <p style="margin: 0;">tidak dapat ditukar/dikembalikan</p>
    </div>
</div>

{{-- JAVASCRIPT HANDLERS --}}
<script>
    // Filter Katalog Produk
    function filterProducts() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('.product-item');

        items.forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(query) ? "" : "none";
        });
    }

    // Checkout Handling
    let timerInterval;

    function handleCheckout() {
        const method = document.getElementById('paymentMethodSelect').value;
        const total = Number({{ (float) $sale->total_pembayaran }});

        if (!method) {
            Swal.fire({ icon: 'warning', title: 'Perhatian', text: 'Pilih metode pembayaran terlebih dahulu!', confirmButtonColor: '#6d28d9' });
            return;
        }

        if (total <= 0) {
            Swal.fire({ icon: 'error', title: 'Keranjang Kosong', text: 'Tambahkan minimal 1 produk ke keranjang!', confirmButtonColor: '#6d28d9' });
            return;
        }

        if (method === 'QRIS') {
            const modalEl = document.getElementById('qrisModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
            startQrisTimer(300);

            modalEl.addEventListener('hidden.bs.modal', () => clearInterval(timerInterval));
        } else {
            Swal.fire({
                title: 'Konfirmasi',
                text: `Selesaikan pembayaran via ${method}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                confirmButtonText: 'Ya, Selesaikan'
            }).then((res) => {
                if (res.isConfirmed) document.getElementById('checkoutForm').submit();
            });
        }
    }

    // Timer QRIS
    function startQrisTimer(sec) {
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            let m = Math.floor(sec / 60), s = sec % 60;
            document.getElementById('qrisTimer').textContent = `${m < 10 ? '0':''}${m}:${s < 10 ? '0':''}${s}`;
            if (--sec < 0) {
                clearInterval(timerInterval);
                bootstrap.Modal.getInstance(document.getElementById('qrisModal')).hide();
                Swal.fire({ icon: 'error', title: 'Waktu Habis', text: 'Sisa waktu transaksi QRIS telah kedaluwarsa.' });
            }
        }, 1000);
    }

    function submitFinalCheckout() {
        document.getElementById('checkoutForm').submit();
    }

    // SweetAlert Confirmations
    function confirmDeleteItem(id) {
        Swal.fire({
            title: 'Hapus Item?',
            text: 'Item akan dihapus dari keranjang belanja.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus'
        }).then((res) => {
            if (res.isConfirmed) document.getElementById(`delete-item-${id}`).submit();
        });
    }

    function confirmCancelTransaction() {
        Swal.fire({
            title: 'Batalkan Transaksi?',
            text: 'Semua barang di keranjang akan dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Batalkan'
        }).then((res) => {
            if (res.isConfirmed) document.getElementById('cancelTransactionForm').submit();
        });
    }
</script>

@endsection