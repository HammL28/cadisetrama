@extends('layouts.app')

@section('title', 'Kasir & Penjualan (POS)')

@section('content')

<!-- Font/Icons & CSRF Token Meta -->
<meta name="csrf-token" content="{{ csrf_token() }}">
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

    .modal-backdrop {
        z-index: 1050 !important;
    }
    .modal {
        z-index: 1060 !important;
    }

    .pos-header-card {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #9333ea 100%);
        border: none;
        border-radius: 1.25rem;
        box-shadow: 0 10px 20px -5px rgba(124, 58, 237, 0.3);
    }

    .pos-card {
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        background: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
    }

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

    .cart-sticky-container {
        position: sticky;
        top: 1.5rem;
    }

    .cart-items-container {
        max-height: 340px;
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

    /* CARD INTERAKTIF BANK */
    .bank-card-selectable {
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        background-color: #f8fafc;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }

    .bank-card-selectable:hover {
        border-color: var(--secondary-purple);
        background-color: #ffffff;
    }

    .bank-card-selectable.selected {
        border-color: var(--primary-purple);
        background-color: #f3e8ff;
    }

    /* Print Struk Thermal 80mm */
    #receipt-print {
        display: none;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        #receipt-print, #receipt-print * {
            visibility: visible;
        }
        #receipt-print {
            display: block !important;
            position: absolute;
            left: 0;
            top: 0;
            width: 80mm;
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

@php
    // Data rekening bank dari akun user yang sedang login (Pengaturan Toko)
    // Fallback ke nilai default kalau user belum mengisi apapun
    $bcaNumber      = $user->bca_account_number ?? '1234567890';
    $bcaHolder      = $user->bca_account_holder ?? 'PT TOKO KASIR POS';
    $mandiriNumber  = $user->mandiri_account_number ?? '1370001234567';
    $mandiriHolder  = $user->mandiri_account_holder ?? 'PT TOKO KASIR POS';

    // Versi angka saja (tanpa strip/spasi) untuk isi QR & fungsi salin
    $bcaNumberClean     = preg_replace('/[^0-9]/', '', $bcaNumber);
    $mandiriNumberClean = preg_replace('/[^0-9]/', '', $mandiriNumber);
@endphp

<div class="container-fluid px-3 px-md-4 py-4">

    {{-- Header Banner --}}
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

        {{-- Katalog Produk --}}
        <div class="col-lg-7 col-xl-8">
            <div class="pos-card p-4 h-100">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="fw-bold mb-0 text-dark">Katalog Barang</h5>
                        <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background-color: var(--accent-purple-light); color: var(--primary-purple);">
                            {{ count($products) }} Produk
                        </span>
                    </div>

                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control bg-light border-start-0 rounded-end-pill shadow-none" placeholder="Cari barang..." onkeyup="filterProducts()" autofocus>
                    </div>
                </div>

                <div class="product-grid" id="productList">
                    @forelse($products as $product)
                        <div class="product-item" data-name="{{ strtolower($product->nama) }}">
                            <div class="product-card p-2.5 h-100">

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

                                <form method="POST" action="{{ route('itempenjualan.store') }}" class="form-tambah-keranjang">
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

        {{-- Keranjang Belanja --}}
        <div class="col-lg-5 col-xl-4">
            <div class="cart-sticky-container">
                <div class="pos-card p-3 p-md-4">

                    <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cart3 fs-4" style="color: var(--primary-purple);"></i>
                            <h5 class="fw-bold mb-0">Keranjang</h5>
                        </div>
                        <span class="badge rounded-pill text-white px-3 py-1.5 fw-semibold" style="background-color: var(--primary-purple);">
                            TRX #{{ $sale->id }}
                        </span>
                    </div>

                    <div class="cart-items-container mb-3">
                        @forelse($sale->itemPenjualan as $item)
                            <div class="cart-item-row">
                                <div class="cart-item-info">
                                    <div class="fw-bold text-dark small text-truncate" title="{{ $item->produk->nama }}">
                                        {{ $item->produk->nama }}
                                    </div>
                                    <div class="unit-price-badge">
                                        Rp {{ number_format($item->produk->harga_jual, 0, ',', '.') }} / pcs
                                    </div>
                                </div>

                                <div class="me-2">
                                    <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}" class="m-0 form-update-qty">
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

                                <div class="text-end me-2" style="min-width: 65px;">
                                    <div class="fw-extrabold small" style="color: var(--primary-purple); font-size: 0.85rem;">
                                        {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>

                                <div>
                                    @can('delete', $item)
                                        <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}" class="m-0 form-hapus-item">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete-cart" title="Hapus Item" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
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

                    <div class="payment-summary-box p-3 mb-3 text-center">
                        <span class="text-muted small text-uppercase fw-bold d-block mb-1" style="letter-spacing: 0.5px;">Total Bayar</span>
                        <h2 class="fw-extrabold mb-0" style="color: var(--primary-purple); font-weight: 800;">
                            Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                        </h2>
                    </div>

                    {{-- Form Utama POS Checkout --}}
                    <form id="checkoutForm" method="POST" action="{{ route('penjualan.update', $sale->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" id="selectedBankInput" name="bank_name" value="BCA">

                        <div class="mb-3">
                            <select id="paymentMethodSelect" name="payment_method" class="form-select rounded-pill px-3 shadow-none bg-light border" onchange="toggleCashInput()" required {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                <option value="">-- Pilih Pembayaran --</option>
                                <option value="CASH" {{ ($sale->metode_pembayaran ?? '') === 'CASH' ? 'selected' : '' }}>Cash / Tunai</option>
                                <option value="QRIS" {{ ($sale->metode_pembayaran ?? '') === 'QRIS' ? 'selected' : '' }}>QRIS (Scan Barcode)</option>
                                <option value="TRANSFER" {{ ($sale->metode_pembayaran ?? '') === 'TRANSFER' ? 'selected' : '' }}>Transfer Bank</option>
                            </select>
                        </div>

                        <div id="cashInputContainer" class="mb-3 d-none">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted fw-bold">Rp</span>
                                <input type="number" id="cashAmountInput" name="cash_amount" class="form-control bg-light border-start-0 rounded-end-pill shadow-none" placeholder="Uang Diterima" oninput="calculateChange()" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2 px-2 small">
                                <span class="text-muted fw-semibold">Kembalian:</span>
                                <span id="changeTextDisplay" class="fw-bold text-success">Rp 0</span>
                            </div>
                        </div>

                        <button type="button" onclick="handleCheckout()" class="btn btn-success w-100 rounded-pill py-2.5 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Selesaikan Transaksi</span>
                        </button>
                    </form>

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
                            <button type="submit" class="btn btn-link text-danger w-100 text-decoration-none small fw-semibold {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}">
                                Batalkan Transaksi
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Modal QRIS --}}
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
                        Konfirmasi Pembayaran QRIS
                    </button>
                    <button type="button" class="btn btn-light rounded-pill text-muted" data-bs-dismiss="modal">
                        Kembali / Ganti Metode
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Transfer Bank (Dinamis QR Code & No Rekening dari Pengaturan Toko) --}}
<div class="modal fade" id="bankModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header text-white border-0 py-3" style="background-color: var(--primary-purple);">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i class="bi bi-bank"></i> Pilih Tujuan Transfer
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">Pilih salah satu bank di bawah untuk melihat QR Code & Nomor Rekening:</p>

                {{-- Tombol Pilihan Bank --}}
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bank-card-selectable p-2 text-center selected" id="cardBca" onclick="selectBank('BCA')">
                            <span class="badge bg-primary rounded-pill mb-1">BCA</span>
                            <div class="fw-bold text-dark small">Bank BCA</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bank-card-selectable p-2 text-center" id="cardMandiri" onclick="selectBank('MANDIRI')">
                            <span class="badge bg-warning text-dark rounded-pill mb-1">Mandiri</span>
                            <div class="fw-bold text-dark small">Bank Mandiri</div>
                        </div>
                    </div>
                </div>

                {{-- Area Tampilan Detail Bank Terpilih (default: BCA, dari $user) --}}
                <div class="p-3 mb-3 border rounded-3 bg-light text-center">
                    <div class="mb-2">
                        <span id="bankNameDisplay" class="fw-bold text-dark fs-5">Bank BCA</span>
                    </div>

                    {{-- QR Code Bank --}}
                    <div class="mb-3">
                        <img id="bankQrDisplay" src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TRANSFER-BCA-{{ $bcaNumberClean }}-TOTAL-{{ $sale->total_pembayaran }}" alt="QR Transfer" class="img-fluid rounded-3 border bg-white p-2 shadow-sm" style="max-width: 170px;">
                        <div class="small text-muted mt-1" style="font-size: 0.75rem;">Scan via Mobile Banking / E-Wallet</div>
                    </div>

                    {{-- Details Nomor Rekening & Salin --}}
                    <div class="bg-white p-2 rounded border d-flex align-items-center justify-content-between mb-2">
                        <div class="text-start ps-2">
                            <div class="text-muted" style="font-size: 0.7rem;">Nomor Rekening / VA</div>
                            <div id="bankAccountNumber" class="fw-extrabold text-dark fs-6">{{ $bcaNumber }}</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary fw-semibold" onclick="copyCurrentBankNo()">
                            <i class="bi bi-copy"></i> Salin
                        </button>
                    </div>

                    <div class="text-muted text-start ps-1" style="font-size: 0.75rem;">
                        Atas Nama: <strong id="bankAccountHolder">{{ $bcaHolder }}</strong>
                    </div>
                </div>

                <div class="payment-summary-box p-3 mb-3 text-center">
                    <span class="text-muted small text-uppercase fw-bold d-block mb-1">Total Yang Harus Ditransfer</span>
                    <h3 class="fw-extrabold mb-0" style="color: var(--primary-purple);">
                        Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" onclick="submitFinalCheckout()" class="btn btn-success fw-bold rounded-pill py-2.5 shadow-sm">
                        <i class="bi bi-check-circle-fill me-1"></i> Konfirmasi Pembayaran Diterima
                    </button>
                    <button type="button" class="btn btn-light rounded-pill text-muted fw-semibold" data-bs-dismiss="modal">
                        Batal / Ganti Metode
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Thermal Printer Struk Layout --}}
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

    <table class="receipt-table">
        <tr style="font-weight: bold; font-size: 14px;">
            <td>TOTAL</td>
            <td style="text-align: right;">Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</td>
        </tr>
        @if(isset($sale->bayar))
            <tr>
                <td>BAYAR</td>
                <td style="text-align: right;">Rp {{ number_format($sale->bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>KEMBALI</td>
                <td style="text-align: right;">Rp {{ number_format($sale->kembali, 0, ',', '.') }}</td>
            </tr>
        @endif
    </table>

    <div class="receipt-dashed"></div>

    <div style="text-align: center; margin-top: 10px;">
        <p style="margin: 0; font-weight: bold;">-- TERIMA KASIH --</p>
        <p style="margin: 2px 0;">Barang yang sudah dibeli</p>
        <p style="margin: 0;">tidak dapat ditukar/dikembalikan</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('submit', '.form-tambah-keranjang', function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function() { window.location.reload(); },
            error: function(xhr) { console.error("Gagal menambahkan item:", xhr.responseText); }
        });
    });

    $(document).on('submit', '.form-update-qty', function(e) {
        e.preventDefault();
        let form = $(this);
        let clickedButton = $(document.activeElement);
        let actionVal = clickedButton.attr('name') === 'action' ? clickedButton.val() : null;
        let formData = form.serializeArray();
        if (actionVal) formData.push({ name: 'action', value: actionVal });

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: $.param(formData),
            success: function() { window.location.reload(); },
            error: function(xhr) { console.error("Gagal memperbarui kuantitas:", xhr.responseText); }
        });
    });

    $(document).on('submit', '.form-hapus-item', function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function() { window.location.reload(); },
            error: function(xhr) { console.error("Gagal menghapus item:", xhr.responseText); }
        });
    });

    function filterProducts() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(query) ? "" : "none";
        });
    }

    function toggleCashInput() {
        const method = document.getElementById('paymentMethodSelect').value;
        const cashContainer = document.getElementById('cashInputContainer');
        if (method === 'CASH') {
            cashContainer.classList.remove('d-none');
        } else {
            cashContainer.classList.add('d-none');
        }
    }

    function calculateChange() {
        const total = Number({{ (float) $sale->total_pembayaran }});
        const cash = Number(document.getElementById('cashAmountInput').value) || 0;
        const change = cash - total;

        const display = document.getElementById('changeTextDisplay');
        if (change >= 0) {
            display.className = "fw-bold text-success";
            display.textContent = "Rp " + change.toLocaleString('id-ID');
        } else {
            display.className = "fw-bold text-danger";
            display.textContent = "- Rp " + Math.abs(change).toLocaleString('id-ID');
        }
    }

    // CONFIG & LOGIKA PILIH BANK
    // Nomor rekening & QR sekarang diambil dari data yang disimpan lewat
    // halaman Pengaturan Toko (kolom bca_account_number, mandiri_account_number, dst)
    const bankData = {
        BCA: {
            name: "Bank BCA",
            number: "{{ $bcaNumber }}",
            cleanNumber: "{{ $bcaNumberClean }}",
            holder: "{{ $bcaHolder }}",
            qrUrl: "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TRANSFER-BCA-{{ $bcaNumberClean }}-TOTAL-{{ $sale->total_pembayaran }}"
        },
        MANDIRI: {
            name: "Bank Mandiri",
            number: "{{ $mandiriNumber }}",
            cleanNumber: "{{ $mandiriNumberClean }}",
            holder: "{{ $mandiriHolder }}",
            qrUrl: "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TRANSFER-MANDIRI-{{ $mandiriNumberClean }}-TOTAL-{{ $sale->total_pembayaran }}"
        }
    };

    let activeBank = 'BCA';

    function selectBank(bank) {
        activeBank = bank;
        document.getElementById('selectedBankInput').value = bank;

        document.getElementById('cardBca').classList.remove('selected');
        document.getElementById('cardMandiri').classList.remove('selected');

        if (bank === 'BCA') {
            document.getElementById('cardBca').classList.add('selected');
        } else if (bank === 'MANDIRI') {
            document.getElementById('cardMandiri').classList.add('selected');
        }

        const info = bankData[bank];
        document.getElementById('bankNameDisplay').textContent = info.name;
        document.getElementById('bankAccountNumber').textContent = info.number;
        document.getElementById('bankAccountHolder').textContent = info.holder;
        document.getElementById('bankQrDisplay').src = info.qrUrl;
    }

    function copyCurrentBankNo() {
        const info = bankData[activeBank];
        navigator.clipboard.writeText(info.cleanNumber).then(() => {
            alert(`Nomor Rekening ${info.name} (${info.number}) berhasil disalin!`);
        });
    }

    let timerInterval;

    function handleCheckout() {
        const method = document.getElementById('paymentMethodSelect').value;
        const total = Number({{ (float) $sale->total_pembayaran }});
        const cash = Number(document.getElementById('cashAmountInput').value) || 0;

        if (!method) {
            alert('Silakan pilih metode pembayaran terlebih dahulu.');
            return;
        }

        if (total <= 0) {
            alert('Keranjang belanja masih kosong.');
            return;
        }

        if (method === 'CASH') {
            if (cash < total) {
                alert('Jumlah uang cash yang dimasukkan masih kurang!');
                return;
            }
            submitFinalCheckout();
        } else if (method === 'QRIS') {
            const modalEl = document.getElementById('qrisModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
            startQrisTimer(300);
            modalEl.addEventListener('hidden.bs.modal', () => clearInterval(timerInterval));
        } else if (method === 'TRANSFER') {
            const bankModalEl = document.getElementById('bankModal');
            const modal = bootstrap.Modal.getOrCreateInstance(bankModalEl);
            modal.show();
        }
    }

    function startQrisTimer(sec) {
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            let m = Math.floor(sec / 60), s = sec % 60;
            const timerEl = document.getElementById('qrisTimer');
            if (timerEl) timerEl.textContent = `${m < 10 ? '0':''}${m}:${s < 10 ? '0':''}${s}`;
            if (--sec < 0) {
                clearInterval(timerInterval);
                bootstrap.Modal.getInstance(document.getElementById('qrisModal'))?.hide();
            }
        }, 1000);
    }

    function submitFinalCheckout() {
        const checkoutForm = document.getElementById('checkoutForm');
        if (checkoutForm) {
            checkoutForm.submit();
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        toggleCashInput();
    });
</script>

@endsection