@extends('layouts.app')

@section('title', 'Kasir & Penjualan (POS)')

@section('content')

@php
    $receiptOwner = \App\Models\User::whereHas('role', function ($query) {
        $query->whereRaw('LOWER(name) = ?', ['admin']);
    })->first() ?? $user;
    $receiptPaperSize = in_array($receiptOwner->paper_size ?? '58mm', ['58mm', '80mm'], true)
        ? ($receiptOwner->paper_size ?? '58mm')
        : '58mm';
    $grossTotal = $sale->itemPenjualan->sum('subtotal');
    $discount = (int) ($sale->diskon ?? 0);
    $netTotal = max(0, $grossTotal - $discount);
@endphp

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
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-align: left;
        padding: 0.6rem 0.75rem;
    }

    .bank-card-selectable:hover {
        border-color: var(--secondary-purple);
        background-color: #ffffff;
    }

    .bank-card-selectable.selected {
        border-color: var(--primary-purple);
        background-color: #f3e8ff;
    }

    .bank-logo-badge {
        width: 34px;
        height: 34px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 800;
        font-size: 0.7rem;
        flex-shrink: 0;
    }

    .bank-logo-badge.bca { background: #1e40af; }
    .bank-logo-badge.mandiri { background: #eab308; color: #1e293b; }

    .bank-card-selectable .bi-check-circle-fill {
        margin-left: auto;
        color: var(--primary-purple);
        opacity: 0;
        transition: opacity 0.15s;
    }

    .bank-card-selectable.selected .bi-check-circle-fill {
        opacity: 1;
    }

    .copy-feedback {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* ==== TRANSFER / VIRTUAL ACCOUNT MODAL ==== */
    .bank-tab-switch {
        display: flex;
        background: #f1f5f9;
        border-radius: 0.75rem;
        padding: 4px;
        gap: 4px;
    }

    .bank-tab-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        background: transparent;
        color: #64748b;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.55rem 0.5rem;
        border-radius: 0.6rem;
        cursor: pointer;
        transition: all 0.15s;
    }

    .bank-tab-btn.active {
        background: #ffffff;
        color: var(--primary-purple);
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .bank-tab-btn .mini-logo {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.55rem;
        font-weight: 800;
        color: #ffffff;
    }

    .mini-logo.bca { background: #1e40af; }
    .mini-logo.mandiri { background: #eab308; color: #1e293b; }

    .va-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .va-status-badge .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #f59e0b;
        animation: va-pulse 1.4s infinite;
    }

    @keyframes va-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.35; }
    }

    .va-identity-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.9rem;
    }

    .va-identity-row .bank-logo-badge {
        width: 42px;
        height: 42px;
        font-size: 0.75rem;
    }

    .va-identity-row .va-identity-label {
        font-size: 0.7rem;
        color: #94a3b8;
        font-weight: 600;
    }

    .va-number-box {
        background: #ffffff;
        border: 1.5px dashed var(--secondary-purple);
        border-radius: 0.85rem;
        padding: 0.9rem 1rem;
        margin-bottom: 0.65rem;
    }

    .va-number-value {
        font-family: 'Courier New', Courier, monospace;
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: 1px;
        color: #1e293b;
        word-break: break-all;
    }

    .va-copy-btn {
        width: 100%;
        border: none;
        border-radius: 0.6rem;
        padding: 0.6rem;
        font-weight: 700;
        font-size: 0.85rem;
        background: var(--primary-purple);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: background 0.15s;
    }

    .va-copy-btn:hover {
        background: var(--primary-hover);
        color: #ffffff;
    }

    .va-copy-btn.copied {
        background: #16a34a;
    }

    .va-amount-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #faf5ff;
        border: 1px solid #ede9fe;
        border-radius: 0.7rem;
        padding: 0.7rem 0.9rem;
        margin-bottom: 0.9rem;
    }

    .va-amount-row .amount-value {
        font-weight: 800;
        color: var(--primary-purple);
        font-size: 1rem;
    }

    .va-amount-copy {
        border: 1px solid var(--secondary-purple);
        background: #ffffff;
        color: var(--primary-purple);
        border-radius: 0.5rem;
        padding: 0.3rem 0.6rem;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .va-timer-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.78rem;
        color: #64748b;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .va-timer-row #transferTimer {
        color: #dc2626;
        font-weight: 800;
        font-family: 'Courier New', Courier, monospace;
    }

    .va-instructions summary {
        cursor: pointer;
        list-style: none;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 700;
        font-size: 0.85rem;
        color: #334155;
        padding: 0.6rem 0;
        border-top: 1px solid #f1f5f9;
    }

    .va-instructions summary::-webkit-details-marker {
        display: none;
    }

    .va-instructions summary .chevron {
        transition: transform 0.2s;
        color: var(--primary-purple);
    }

    .va-instructions[open] summary .chevron {
        transform: rotate(180deg);
    }

    .va-instructions ol {
        margin: 0 0 0.75rem 0;
        padding-left: 1.1rem;
        font-size: 0.8rem;
        color: #475569;
        line-height: 1.6;
    }

    .va-qr-toggle-btn {
        background: none;
        border: none;
        color: var(--primary-purple);
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: underline;
        padding: 0;
        margin: 0.5rem 0 0.9rem;
    }

    /* Quick cash denomination buttons */
    .quick-cash-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-top: 0.6rem;
    }

    .quick-cash-btn {
        border: 1.5px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        border-radius: 0.6rem;
        padding: 0.45rem 0.3rem;
        font-size: 0.8rem;
        font-weight: 700;
        transition: all 0.15s;
        cursor: pointer;
    }

    .quick-cash-btn:hover {
        border-color: var(--secondary-purple);
        background: var(--accent-purple-light);
        color: var(--primary-purple);
    }

    .quick-cash-btn.active {
        border-color: var(--primary-purple);
        background: var(--primary-purple);
        color: #ffffff;
    }

    /* Change / kembalian result card */
    .change-result-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        transition: all 0.2s;
    }

    .change-result-card.insufficient {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .change-result-card .change-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: none;
    }

    .change-result-card .change-value {
        font-size: 1.05rem;
        font-weight: 800;
    }

    .change-result-card.insufficient .change-value { color: #dc2626; }
    .change-result-card:not(.insufficient) .change-value { color: #16a34a; }

    /* Print struk thermal mengikuti ukuran yang dipilih admin */
    #receipt-print {
        display: none;
    }

    @media print {
        @page {
            size: {{ $receiptPaperSize }} auto;
            margin: 0 !important;
        }

        html, body {
            width: {{ $receiptPaperSize }} !important;
            min-width: {{ $receiptPaperSize }} !important;
            max-width: {{ $receiptPaperSize }} !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        body * {
            visibility: hidden !important;
        }

        #receipt-print,
        #receipt-print * {
            visibility: visible !important;
        }

        #receipt-print {
            display: block !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: {{ $receiptPaperSize }} !important;
            max-width: {{ $receiptPaperSize }} !important;
            min-width: {{ $receiptPaperSize }} !important;
            box-sizing: border-box;
            padding: 2.5mm 3mm !important;
            font-family: 'Courier New', Courier, monospace;
            font-size: 10.5px;
            line-height: 1.3;
            color: #000;
            background: #fff;
            page-break-inside: avoid !important;
            margin: 0 !important;
            box-shadow: none !important;
        }

        #receipt-print table {
            width: 100% !important;
            table-layout: fixed;
            word-break: break-word;
            border-collapse: collapse;
        }

        #receipt-print td {
            vertical-align: top;
            padding: 1px 0;
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

                    <div class="payment-summary-box p-3 mb-3">
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Subtotal</span>
                            <strong id="subtotalDisplay">Rp {{ number_format($grossTotal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text bg-white border-end-0">Diskon</span>
                            <select id="discountType" class="form-select form-select-sm border-start-0 border-end-0" style="max-width: 90px;" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                                <option value="nominal">Rp</option>
                                <option value="percent">%</option>
                            </select>
                            <input type="number" id="discountInput" name="diskon" form="checkoutForm" class="form-control border-start-0 text-end" min="0" step="0.01" value="{{ $discount }}" placeholder="0" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                            <input type="hidden" id="discountTypeHidden" name="discount_type" value="nominal">
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                            <span class="text-muted small text-uppercase fw-bold" style="letter-spacing: 0.5px;">Total Bayar</span>
                            <h2 id="totalDisplay" class="fw-extrabold mb-0" style="color: var(--primary-purple); font-weight: 800;">
                                Rp {{ number_format($netTotal, 0, ',', '.') }}
                            </h2>
                        </div>
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
                                <input type="number" id="cashAmountInput" name="cash_amount" class="form-control bg-light border-start-0 rounded-end-pill shadow-none" placeholder="Uang Diterima" oninput="calculateChange(); syncActiveQuickBtn();" {{ $sale->status === 'COMPLETED' ? 'disabled' : '' }}>
                            </div>

                            <div class="quick-cash-row" id="quickCashRow"></div>

                            <div id="changeResultCard" class="change-result-card">
                                <span class="change-label">Kembalian</span>
                                <span id="changeTextDisplay" class="change-value">Rp 0</span>
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
                    <img id="qrisQrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=POS-TRX-{{ $sale->id }}-TOTAL-{{ $netTotal }}" alt="QRIS Code" class="img-fluid rounded-3 mb-2">
                    <div class="small fw-bold text-muted"><i class="bi bi-shield-check text-success"></i> STANDAR QRIS NATIONAL</div>
                </div>

                <div class="fw-bold fs-3 mb-2" style="color: var(--primary-purple);">
                    <span id="qrisTotalDisplay">Rp {{ number_format($netTotal, 0, ',', '.') }}</span>
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

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="va-status-badge"><span class="dot"></span> Menunggu Pembayaran</span>
                    <div class="va-timer-row mb-0">
                        Batas waktu: <span id="transferTimer">15:00</span>
                    </div>
                </div>

                {{-- Segmented switch pilih bank tujuan --}}
                <div class="bank-tab-switch mb-3">
                    <button type="button" class="bank-tab-btn active" id="cardBca" onclick="selectBank('BCA')">
                        <span class="mini-logo bca">BCA</span> Bank BCA
                    </button>
                    <button type="button" class="bank-tab-btn" id="cardMandiri" onclick="selectBank('MANDIRI')">
                        <span class="mini-logo mandiri">MDR</span> Bank Mandiri
                    </button>
                </div>

                {{-- Identitas bank tujuan --}}
                <div class="va-identity-row">
                    <div class="bank-logo-badge bca" id="bankLogoDisplay">BCA</div>
                    <div>
                        <span class="va-identity-label d-block">Transfer ke Virtual Account</span>
                        <span id="bankNameDisplay" class="fw-bold text-dark">Bank BCA</span>
                    </div>
                </div>

                {{-- Nomor VA --}}
                <div class="va-number-box text-center">
                    <div class="va-identity-label mb-1">Nomor Virtual Account</div>
                    <div id="bankAccountNumber" class="va-number-value">{{ $bcaNumber }}</div>
                    <div class="text-muted mt-1" style="font-size: 0.75rem;">
                        Atas Nama: <strong id="bankAccountHolder">{{ $bcaHolder }}</strong>
                    </div>
                </div>

                <button type="button" class="va-copy-btn mb-3" id="copyBankBtn" onclick="copyCurrentBankNo()">
                    <i class="bi bi-copy"></i> Salin Nomor VA
                </button>

                {{-- Nominal transfer --}}
                <div class="va-amount-row">
                    <div>
                        <div class="va-identity-label">Nominal Transfer</div>
                        <div class="amount-value" id="transferTotalDisplay">Rp {{ number_format($netTotal, 0, ',', '.') }}</div>
                    </div>
                    <button type="button" class="va-amount-copy" onclick="copyTransferAmount()">
                        <i class="bi bi-copy"></i> Salin
                    </button>
                </div>

                <p class="text-muted mb-2" style="font-size: 0.75rem;">
                    <i class="bi bi-info-circle"></i> Transfer sesuai nominal di atas agar pembayaran mudah diverifikasi.
                </p>

                {{-- Cara transfer (accordion) --}}
                <details class="va-instructions">
                    <summary>
                        <span><i class="bi bi-phone me-1"></i> Cara Bayar - Mobile / Internet Banking</span>
                        <i class="bi bi-chevron-down chevron"></i>
                    </summary>
                    <ol>
                        <li>Buka aplikasi Mobile/Internet Banking bank kamu.</li>
                        <li>Pilih menu <strong>Transfer</strong> ke bank tujuan di atas.</li>
                        <li>Masukkan Nomor Virtual Account: <strong id="vaInlineRef">{{ $bcaNumber }}</strong></li>
                        <li>Pastikan nama penerima & nominal sudah sesuai, lalu konfirmasi.</li>
                        <li>Setelah transfer berhasil, klik tombol <em>"Konfirmasi Pembayaran Diterima"</em> di bawah.</li>
                    </ol>
                </details>

                <details class="va-instructions">
                    <summary>
                        <span><i class="bi bi-credit-card me-1"></i> Cara Bayar - ATM</span>
                        <i class="bi bi-chevron-down chevron"></i>
                    </summary>
                    <ol>
                        <li>Masukkan kartu ATM & PIN di mesin ATM bank manapun.</li>
                        <li>Pilih menu <strong>Transfer &rarr; Ke Rekening Bank Lain</strong> (jika beda bank).</li>
                        <li>Masukkan Nomor Virtual Account: <strong id="vaInlineRefAtm">{{ $bcaNumber }}</strong></li>
                        <li>Masukkan nominal sesuai total di atas, lalu ikuti instruksi hingga selesai.</li>
                    </ol>
                </details>

                <button type="button" class="va-qr-toggle-btn" onclick="toggleQrSection()" id="qrToggleBtn">
                    Atau scan QR untuk transfer &rsaquo;
                </button>

                <div id="qrSection" class="text-center d-none mb-3">
                    <img id="bankQrDisplay" src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TRANSFER-BCA-{{ $bcaNumberClean }}-TOTAL-{{ $netTotal }}" alt="QR Transfer" class="img-fluid rounded-3 border bg-white p-2 shadow-sm" style="max-width: 160px;">
                    <div class="small text-muted mt-1" style="font-size: 0.72rem;">Scan via Mobile Banking / E-Wallet</div>
                </div>

                <div class="d-grid gap-2 mt-2">
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
            <td style="text-align: right;">Rp {{ number_format($netTotal, 0, ',', '.') }}</td>
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
    window.addEventListener('beforeprint', function () {
        var style = document.getElementById('pos-receipt-page-size');
        if (!style) {
            style = document.createElement('style');
            style.id = 'pos-receipt-page-size';
            document.head.appendChild(style);
        }
        style.textContent = '@page { size: {{ $receiptPaperSize }} auto; margin: 0; }';
    });

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

    function getCheckoutTotal() {
        const subtotal = Number({{ (float) $grossTotal }});
        const discountType = document.getElementById('discountType')?.value || 'nominal';
        const rawValue = Number(document.getElementById('discountInput')?.value || 0);

        let discount = 0;
        if (discountType === 'percent') {
            const percent = Math.min(Math.max(rawValue, 0), 100);
            discount = subtotal * (percent / 100);
        } else {
            discount = Math.min(Math.max(rawValue, 0), subtotal);
        }

        return subtotal - discount;
    }

    function updateDiscountSummary() {
        const discountInput = document.getElementById('discountInput');
        const discountType = document.getElementById('discountType')?.value || 'nominal';
        const discountTypeHidden = document.getElementById('discountTypeHidden');
        const subtotal = Number({{ (float) $grossTotal }});
        const rawValue = Number(discountInput.value || 0);

        if (discountTypeHidden) {
            discountTypeHidden.value = discountType;
        }

        let discount = 0;
        if (discountType === 'percent') {
            const percent = Math.min(Math.max(rawValue, 0), 100);
            discountInput.value = percent;
            discount = subtotal * (percent / 100);
        } else {
            discount = Math.min(Math.max(rawValue, 0), subtotal);
            discountInput.value = discount;
        }

        const total = subtotal - discount;

        document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
        const qrisTotal = document.getElementById('qrisTotalDisplay');
        if (qrisTotal) qrisTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        const qrisQrImage = document.getElementById('qrisQrImage');
        if (qrisQrImage) {
            qrisQrImage.src = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=POS-TRX-{{ $sale->id }}-TOTAL-' + total;
        }
        const transferTotal = document.getElementById('transferTotalDisplay');
        if (transferTotal) transferTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        if (typeof bankData !== 'undefined') {
            Object.keys(bankData).forEach((bank) => {
                bankData[bank].qrUrl = bankData[bank].qrUrl.replace(/TOTAL-[^&]*/, 'TOTAL-' + total);
            });
            const bankQrDisplay = document.getElementById('bankQrDisplay');
            if (bankQrDisplay && typeof activeBank !== 'undefined') {
                bankQrDisplay.src = bankData[activeBank].qrUrl;
            }
        }
    }

    // ==== QUICK CASH DENOMINATION BUTTONS ====
    function generateQuickCashOptions(total) {
        const options = new Set();
        options.add(total); // uang pas

        const steps = [5000, 10000, 20000, 50000, 100000];
        steps.forEach(step => {
            const rounded = Math.ceil(total / step) * step;
            if (rounded > total) options.add(rounded);
        });

        return Array.from(options).sort((a, b) => a - b).slice(0, 6);
    }

    function renderQuickCashButtons() {
        const total = getCheckoutTotal();
        const row = document.getElementById('quickCashRow');
        if (!row) return;

        const options = generateQuickCashOptions(total);
        row.innerHTML = '';

        options.forEach(amount => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'quick-cash-btn';
            btn.textContent = amount === total ? 'Uang Pas' : 'Rp ' + amount.toLocaleString('id-ID');
            btn.dataset.amount = amount;
            btn.onclick = function () {
                document.getElementById('cashAmountInput').value = amount;
                calculateChange();
                syncActiveQuickBtn();
            };
            row.appendChild(btn);
        });
    }

    function syncActiveQuickBtn() {
        const current = Number(document.getElementById('cashAmountInput').value) || 0;
        document.querySelectorAll('.quick-cash-btn').forEach(btn => {
            btn.classList.toggle('active', Number(btn.dataset.amount) === current);
        });
    }

    function calculateChange() {
        const total = getCheckoutTotal();
        const cash = Number(document.getElementById('cashAmountInput').value) || 0;
        const change = cash - total;

        const card = document.getElementById('changeResultCard');
        const display = document.getElementById('changeTextDisplay');

        if (change >= 0) {
            card.classList.remove('insufficient');
            display.textContent = "Rp " + change.toLocaleString('id-ID');
        } else {
            card.classList.add('insufficient');
            display.textContent = "Kurang Rp " + Math.abs(change).toLocaleString('id-ID');
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
            qrUrl: "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TRANSFER-BCA-{{ $bcaNumberClean }}-TOTAL-{{ $netTotal }}"
        },
        MANDIRI: {
            name: "Bank Mandiri",
            number: "{{ $mandiriNumber }}",
            cleanNumber: "{{ $mandiriNumberClean }}",
            holder: "{{ $mandiriHolder }}",
            qrUrl: "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=TRANSFER-MANDIRI-{{ $mandiriNumberClean }}-TOTAL-{{ $netTotal }}"
        }
    };

    let activeBank = 'BCA';

    function selectBank(bank) {
        activeBank = bank;
        document.getElementById('selectedBankInput').value = bank;

        document.getElementById('cardBca').classList.remove('active');
        document.getElementById('cardMandiri').classList.remove('active');

        const logoDisplay = document.getElementById('bankLogoDisplay');

        if (bank === 'BCA') {
            document.getElementById('cardBca').classList.add('active');
            logoDisplay.className = 'bank-logo-badge bca';
            logoDisplay.textContent = 'BCA';
        } else if (bank === 'MANDIRI') {
            document.getElementById('cardMandiri').classList.add('active');
            logoDisplay.className = 'bank-logo-badge mandiri';
            logoDisplay.textContent = 'MDR';
        }

        const info = bankData[bank];
        document.getElementById('bankNameDisplay').textContent = info.name;
        document.getElementById('bankAccountNumber').textContent = info.number;
        document.getElementById('bankAccountHolder').textContent = info.holder;
        document.getElementById('bankQrDisplay').src = info.qrUrl;

        const vaRef = document.getElementById('vaInlineRef');
        const vaRefAtm = document.getElementById('vaInlineRefAtm');
        if (vaRef) vaRef.textContent = info.number;
        if (vaRefAtm) vaRefAtm.textContent = info.number;
    }

    function copyCurrentBankNo() {
        const info = bankData[activeBank];
        navigator.clipboard.writeText(info.cleanNumber).then(() => {
            const btn = document.getElementById('copyBankBtn');
            const original = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Nomor VA Tersalin';
            btn.classList.add('copied');
            setTimeout(() => {
                btn.innerHTML = original;
                btn.classList.remove('copied');
            }, 1500);
        });
    }

    function copyTransferAmount() {
        const total = getCheckoutTotal();
        navigator.clipboard.writeText(String(total)).then(() => {
            const btn = event.currentTarget;
            const original = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Tersalin';
            setTimeout(() => { btn.innerHTML = original; }, 1500);
        });
    }

    function toggleQrSection() {
        const section = document.getElementById('qrSection');
        const btn = document.getElementById('qrToggleBtn');
        const hidden = section.classList.toggle('d-none');
        btn.textContent = hidden ? 'Atau scan QR untuk transfer \u203a' : 'Sembunyikan QR \u2039';
    }

    let transferTimerInterval;

    function startTransferTimer(sec) {
        clearInterval(transferTimerInterval);
        transferTimerInterval = setInterval(() => {
            let m = Math.floor(sec / 60), s = sec % 60;
            const el = document.getElementById('transferTimer');
            if (el) el.textContent = `${m < 10 ? '0':''}${m}:${s < 10 ? '0':''}${s}`;
            if (--sec < 0) {
                clearInterval(transferTimerInterval);
            }
        }, 1000);
    }

    let timerInterval;

    function handleCheckout() {
        const method = document.getElementById('paymentMethodSelect').value;
        const total = getCheckoutTotal();
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
            startTransferTimer(900);
            bankModalEl.addEventListener('hidden.bs.modal', () => clearInterval(transferTimerInterval));
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
        renderQuickCashButtons();

        const discountType = document.getElementById('discountType');
        const discountInput = document.getElementById('discountInput');

        if (discountType) {
            discountType.addEventListener('change', () => {
                const currentValue = Number(discountInput?.value || 0);
                if (discountType.value === 'percent') {
                    discountInput.value = Math.min(Math.max(currentValue, 0), 100);
                } else {
                    discountInput.value = Math.min(Math.max(currentValue, 0), Number({{ (float) $grossTotal }}));
                }
                updateDiscountSummary();
                renderQuickCashButtons();
            });
        }

        discountInput?.addEventListener('input', () => {
            updateDiscountSummary();
            renderQuickCashButtons();
        });
    });
</script>

@endsection