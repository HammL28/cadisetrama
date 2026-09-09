@extends('layouts.app')

@section('title', 'Detail Transaksi #' . $penjualan->id)

@section('content')

<style>
    :root {
        --purple-deep: #6366f1;
        --purple-main: #8b5cf6;
        --purple-light: #a855f7;
        --purple-bright: #c084fc;
        --pink-accent: #e879f9;
    }

    body {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 50%, #f3e8ff 100%) !important;
    }

    .banner-purple-gradient {
        background: linear-gradient(135deg, var(--purple-deep) 0%, var(--purple-main) 25%, var(--purple-light) 50%, var(--purple-bright) 75%, var(--pink-accent) 100%) !important;
        color: #ffffff !important;
    }

    .text-purple {
        color: var(--purple-main) !important;
    }

    .bg-purple-subtle {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(168, 85, 247, 0.12) 100%) !important;
        color: #6b21a8 !important;
    }

    .card-detail {
        border-radius: 16px;
        border: 1px solid rgba(139, 92, 246, 0.2);
        box-shadow: 0 4px 16px rgba(139, 92, 246, 0.1);
    }

    .qr-container {
        background: #ffffff;
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        display: inline-block;
    }

    /* Sembunyikan elemen cetak di mode layar biasa */
    #receipt-print-area {
        display: none;
    }

    /* PERBAIKAN CSS PRINT (SOLUSI LAYAR KOSONG & TOMBOL BURGER) */
    @media print {
        @page {
            size: portrait;
            margin: 0mm;
        }

        /* Paksa browser mencetak background & warna */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Sembunyikan tampilan web internal & navbar/sidebar/tombol burger */
        .container-web-view,
        nav,
        header,
        footer,
        aside,
        .sidebar,
        .navbar,
        .navbar-toggler,
        .btn-toggle,
        #sidebarToggle,
        button {
            display: none !important;
        }

        /* Paksa area struk tampil menutupi seluruh halaman print */
        #receipt-print-area {
            display: block !important;
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            max-width: 80mm !important; /* Sesuaikan 58mm atau 80mm sesuai lebar printer thermal */
            padding: 5mm !important;
            margin: 0 auto !important;
            background: #ffffff !important;
            font-family: 'Courier New', Courier, monospace !important;
            font-size: 11px !important;
            z-index: 999999 !important;
            box-sizing: border-box !important;
        }

        #receipt-print-area table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        #receipt-print-area tr {
            display: table-row !important;
        }

        #receipt-print-area td, 
        #receipt-print-area th {
            display: table-cell !important;
        }
    }
</style>

@php
    $userPenjualan = $penjualan->user ?? Auth::user();
    
    $storeName = $userPenjualan->store_name ?? 'ILHAM JAYA HEBAT';
    $storeAddress = $userPenjualan->store_address ?? 'JL.JL.JL.J';
    $storePhone = $userPenjualan->store_phone ?? '087786888522';

    // Ambil nama kasir
    $cashierName = $userPenjualan->name ?? 'Kasir';

    // Ambil Role Kasir tanpa merender Object/JSON
    $roleRaw = $userPenjualan->role ?? 'STAFF';
    if (is_object($roleRaw) || is_array($roleRaw)) {
        $cashierRole = strtoupper($roleRaw->name ?? $roleRaw['name'] ?? 'STAFF');
    } else {
        $cashierRole = strtoupper((string) $roleRaw);
    }
@endphp

{{-- TAMPILAN MONITOR / WEB --}}
<div class="container py-4 container-web-view" style="padding-top: 5rem;">

    <div class="banner-purple-gradient p-4 rounded-4 mb-4 shadow-sm">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold mb-1 text-white d-flex align-items-center gap-2">
                    <i class="bi bi-receipt fs-2"></i> Detail Transaksi #{{ $penjualan->id }}
                </h2>
                <p class="text-white opacity-75 small mb-0">Informasi rincian transaksi dan daftar barang yang dibeli.</p>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <button onclick="window.print()" class="btn btn-light rounded-pill px-3 fw-semibold text-purple shadow-sm d-flex align-items-center gap-1">
                    <i class="bi bi-printer-fill"></i> Cetak Struk
                </button>
                <a href="{{ route('penjualan.index') }}" class="btn btn-outline-light rounded-pill px-4 fw-semibold shadow-sm d-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 card-detail h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-4 text-purple d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle-fill"></i> Ringkasan Transaksi
                        </h5>
                        
                        <div class="mb-3">
                            <label class="text-muted small d-block">ID Transaksi</label>
                            <span class="fw-bold text-dark fs-6">#{{ $penjualan->id }}</span>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small d-block">Tanggal Transaksi</label>
                            <span class="fw-semibold text-dark">{{ $penjualan->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small d-block">Kasir / Petugas</label>
                            <span class="fw-semibold text-dark">{{ $cashierName }} ({{ $cashierRole }})</span>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small d-block">Metode Pembayaran</label>
                            <span class="badge bg-purple-subtle px-3 py-2 rounded-pill fw-semibold">
                                {{ strtoupper($penjualan->metode_pembayaran) }}
                            </span>
                        </div>

                        <div class="mb-4">
                            <label class="text-muted small d-block mb-1">Status Transaksi</label>
                            @if(strtoupper($penjualan->status) === 'COMPLETED' || strtoupper($penjualan->status) === 'SELESAI')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-clock-history me-1"></i> {{ ucfirst($penjualan->status) }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-3">

                    <div class="text-center pt-2">
                        <div class="qr-container shadow-sm mb-2">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data={{ urlencode(route('penjualan.show', $penjualan->id)) }}" 
                                 alt="QR Code Transaksi #{{ $penjualan->id }}" 
                                 class="img-fluid"
                                 width="130" height="130">
                        </div>
                        <span class="d-block text-muted small fw-medium">Scan untuk verifikasi resi</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 card-detail h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-purple d-flex align-items-center gap-2">
                        <i class="bi bi-basket-fill"></i> Rincian Barang
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light small">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Harga Satuan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penjualan->itemPenjualan as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $item->produk->nama ?? $item->produk->nama_produk ?? 'Produk Terhapus' }}</div>
                                        </td>
                                        <td class="text-end">Rp {{ number_format($item->harga_satuan ?? ($item->subtotal / max($item->kuantitas, 1)), 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border px-2 py-1">{{ $item->kuantitas }}</span>
                                        </td>
                                        <td class="text-end fw-semibold text-dark">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Tidak ada rincian barang untuk transaksi ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-group-divider">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-5 pt-3">Total Pembayaran:</td>
                                    <td class="text-end fw-bold fs-5 text-purple pt-3">
                                        Rp {{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- AREA STRUK BERWARNA & TERISOLASI UNTUK PRINT --}}
<div id="receipt-print-area">
    <div style="text-align: center; border-bottom: 2px dashed #8b5cf6; padding-bottom: 8px; margin-bottom: 8px;">
        <h3 style="margin: 0; font-size: 13px; font-weight: bold; text-transform: uppercase; color: #8b5cf6;">
            {{ $storeName }}
        </h3>
        <p style="margin: 3px 0 0 0; font-size: 9px; color: #4b5563;">
            {{ $storeAddress }}
        </p>
        <p style="margin: 1px 0 0 0; font-size: 9px; color: #4b5563;">
            Telp / WA: {{ $storePhone }}
        </p>
    </div>

    <table style="width: 100%; font-size: 9px; border-collapse: collapse; margin-bottom: 6px; color: #1f2937;">
        <tr>
            <td style="padding: 2px 0;">No. Trx:</td>
            <td style="text-align: right; padding: 2px 0; font-weight: bold; color: #8b5cf6;">#{{ $penjualan->id }}</td>
        </tr>
        <tr>
            <td style="padding: 2px 0;">Tanggal:</td>
            <td style="text-align: right; padding: 2px 0;">{{ $penjualan->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 2px 0;">Kasir:</td>
            <td style="text-align: right; padding: 2px 0; font-weight: bold;">{{ $cashierName }} ({{ $cashierRole }})</td>
        </tr>
        <tr>
            <td style="padding: 2px 0;">Metode Bayar:</td>
            <td style="text-align: right; padding: 2px 0; font-weight: bold; color: #8b5cf6;">
                {{ strtoupper($penjualan->metode_pembayaran) }}
            </td>
        </tr>
    </table>

    <div style="border-top: 1px dashed #8b5cf6; margin: 6px 0;"></div>

    <table style="width: 100%; font-size: 9px; border-collapse: collapse; color: #1f2937;">
        @foreach($penjualan->itemPenjualan as $item)
            <tr>
                <td colspan="2" style="font-weight: bold; padding-top: 3px;">
                    {{ $item->produk->nama ?? $item->produk->nama_produk ?? 'Produk' }}
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 4px; color: #4b5563;">
                    {{ $item->kuantitas }} x Rp {{ number_format($item->harga_satuan ?? ($item->subtotal / max($item->kuantitas, 1)), 0, ',', '.') }}
                </td>
                <td style="text-align: right; padding-bottom: 4px; font-weight: bold;">
                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
    </table>

    <div style="border-top: 1px dashed #8b5cf6; margin: 6px 0;"></div>

    <table style="width: 100%; font-size: 10px; font-weight: bold; color: #8b5cf6;">
        <tr>
            <td>TOTAL BAYAR</td>
            <td style="text-align: right;">Rp {{ number_format($penjualan->total_pembayaran, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div style="border-top: 2px dashed #8b5cf6; margin: 8px 0;"></div>

    <div style="text-align: center; margin-top: 10px; font-size: 9px; color: #4b5563;">
        <p style="margin: 0; font-weight: bold; color: #8b5cf6;">-- TERIMA KASIH --</p>
        <p style="margin: 2px 0;">Barang yang sudah dibeli</p>
        <p style="margin: 0;">tidak dapat ditukar / dikembalikan</p>
    </div>
</div>

@endsection