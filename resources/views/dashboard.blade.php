@extends('layouts.app')

@section('title', __('dashboard') . ' - POS System')

@section('content')

<style>
    /* ==========================================
       CSS VARIABLES (HIERARCHY & PURPLE THEME)
       ========================================== */
    :root {
        /* Gradient Banner */
        --primary-gradient: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #9333ea 100%);
        
        /* Background & Surface */
        --bg-slate: #f5f3ff;
        --card-bg: #ffffff;
        --card-border: #e9d5ff;

        /* HIERARCHY WARNA TEKS (Dari yang paling utama sampai sekunder) */
        --text-heading: #2e1065;   /* Level 1: Judul Utama & Angka Penting (Sangat Kontras) */
        --text-body: #4c1d95;      /* Level 2: Teks Isian & Nama Produk */
        --text-muted: #6b21a8;     /* Level 3: Label, Subtitle & Keterangan Tambahan */
        --text-light: #9333ea;     /* Level 4: Aksesori & Elemen Pendukung */

        /* Ikon & Accent */
        --icon-bg: #f3e8ff;
        --icon-color: #7e22ce;
        --table-head-bg: #f3e8ff;
        --table-hover-bg: #faf5ff;

        --radius-lg: 20px;
        --radius-md: 14px;
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%) !important;
        color: var(--text-body) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* HEADER BANNER - LEVEL 1 VISUAL IMPORTANCE */
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

    /* HIERARCHY TYPOGRAPHY CLASS */
    .h-title-main {
        color: var(--text-heading) !important;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .h-title-sub {
        color: var(--text-muted) !important;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .h-metric-label {
        color: var(--text-muted) !important;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .h-metric-value {
        color: var(--text-heading) !important;
        font-size: 1.85rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    /* WADAH & IKON SERBA UNGU - VISUAL ANCHOR */
    .icon-box-modern {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        transition: var(--transition);
        background-color: var(--icon-bg) !important;
        color: var(--icon-color) !important;
        border: 1px solid var(--card-border);
    }

    .icon-box-modern i {
        color: var(--icon-color) !important;
    }

    .dashboard-card:hover .icon-box-modern {
        transform: scale(1.08);
        background-color: #7e22ce !important;
        color: #ffffff !important;
    }

    .dashboard-card:hover .icon-box-modern i {
        color: #ffffff !important;
    }

    /* BADGES */
    .badge-purple {
        background-color: #f3e8ff !important;
        color: #6b21a8 !important;
        border: 1px solid #e9d5ff;
        font-weight: 600;
    }

    /* CARDS STRUCTURE */
    .dashboard-card {
        border-radius: var(--radius-md);
        border: 1px solid var(--card-border) !important;
        background: var(--card-bg) !important;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.04);
        position: relative;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(124, 58, 237, 0.12);
        border-color: #a855f7 !important;
    }

    .card-top-accent {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--primary-gradient) !important;
    }

    /* TABLES HIERARCHY */
    .table-custom {
        margin-bottom: 0;
    }

    .table-custom thead {
        background-color: var(--table-head-bg) !important;
        border-bottom: 1px solid var(--card-border) !important;
    }

    .table-custom th {
        color: var(--text-muted) !important;
        font-size: 0.725rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
        padding: 0.875rem 1.25rem;
        border: none;
    }

    .table-custom td {
        padding: 1rem 1.25rem;
        color: var(--text-body) !important;
        border-bottom: 1px solid var(--card-border) !important;
        font-size: 0.9rem;
    }

    .table-custom tbody tr:hover {
        background-color: var(--table-hover-bg) !important;
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none !important;
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    {{-- HEADER BANNER --}}
    <div class="dashboard-header-banner mb-4">
        <div class="row align-items-center g-3 position-relative" style="z-index: 1;">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <div class="date-badge">
                        <i class="bi bi-calendar3"></i>
                        <span>{{ __('today') }} &bull; {{ $tanggalHariIni->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="date-badge">
                        <i class="bi bi-clock-history"></i>
                        <span id="liveClock">00:00:00 WIB</span>
                    </div>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    {{ __('welcome_back') }}! 👋
                </h1>
                <p class="text-white-50 mb-0 fs-6">{{ __('dashboard_subtitle') }}</p>
            </div>
        </div>
    </div>


    {{-- SALES OVERVIEW (ADMIN/OWNER ONLY) --}}
    @can('viewAny', App\Models\User::class)

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <div class="icon-box-modern me-3 shadow-sm">
                <i class="bi bi-graph-up-arrow"></i>
            </div>
            <div>
                <h2 class="h-title-main mb-0">{{ __('sales_summary') }}</h2>
                <span class="h-title-sub">{{ __('sales_summary_subtitle') }}</span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">

        {{-- TOTAL PENJUALAN --}}
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">{{ __('total_revenue') }}</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                    <div class="h-metric-value mb-2">
                        Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}
                    </div>
                    <span class="badge badge-purple rounded-pill py-1 px-2.5">
                        <i class="bi bi-arrow-up-short"></i> {{ __('total_today') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- JUMLAH TRANSAKSI --}}
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">{{ __('total_orders') }}</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                    <div class="h-metric-value mb-2">
                        {{ number_format($ringkasan['total_transaksi'], 0, ',', '.') }} <span class="fs-6 fw-semibold" style="color: var(--text-muted);">{{ __('transactions') }}</span>
                    </div>
                    <span class="h-title-sub">{{ __('successful_transactions') }}</span>
                </div>
            </div>
        </div>

        {{-- PEMBAYARAN TUNAI --}}
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">{{ __('cash_payment') }}</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                    <div class="h-metric-value mb-2">
                        Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}
                    </div>
                    <span class="h-title-sub">{{ __('cash_received') }}</span>
                </div>
            </div>
        </div>

        {{-- PEMBAYARAN NON TUNAI --}}
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">{{ __('non_cash_payment') }}</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-credit-card-2-front-fill"></i>
                        </div>
                    </div>
                    <div class="h-metric-value mb-2">
                        Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}
                    </div>
                    <span class="h-title-sub">{{ __('digital_payment') }}</span>
                </div>
            </div>
        </div>

    </div>

    @endcan


    {{-- PRODUK TERLARIS --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box-modern" style="width: 42px; height: 42px; font-size: 1.1rem;">
                            <i class="bi bi-stars"></i>
                        </div>
                        <div>
                            <h3 class="h-title-main mb-0">{{ __('best_selling_products') }}</h3>
                            <span class="h-title-sub">{{ __('best_selling_subtitle') }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 mt-2">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">{{ __('product_name') }}</th>
                                    <th>{{ __('stock_availability') }}</th>
                                    <th class="pe-4 text-end">{{ __('total_sales') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkTerlaris as $produk)
                                <tr>
                                    <td class="fw-bold ps-4" style="color: var(--text-heading);">
                                        <i class="bi bi-box-seam me-2" style="color: var(--text-light);"></i>{{ $produk->nama }}
                                    </td>
                                    <td>
                                        <span class="badge badge-purple px-3 py-1.5 rounded-pill">
                                            {{ $produk->stok }} {{ __('units_available') }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <span class="badge badge-purple px-3 py-2 rounded-pill fw-bold">
                                            <i class="bi bi-bag-check-fill me-1"></i> {{ number_format($produk->total_terjual, 0, ',', '.') }} {{ __('sold') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5" style="color: var(--text-muted);">
                                        <i class="bi bi-inbox fs-1 d-block mb-2" style="color: var(--text-light);"></i>
                                        <span>{{ __('no_best_selling_data') }}</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- STATS RINGKASAN PRODUK & INVENTARIS --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <div class="icon-box-modern me-3 shadow-sm">
                <i class="bi bi-boxes"></i>
            </div>
            <div>
                <h2 class="h-title-main mb-0">{{ __('stock_condition') }}</h2>
                <span class="h-title-sub">{{ __('stock_condition_subtitle') }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">

        {{-- STOK MENIPIS --}}
        <div class="col-lg-6">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-warning d-flex align-items-center gap-2 fs-6">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ __('low_stock') }}
                    </span>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1 fw-bold">
                        {{ method_exists($produkStokRendah, 'count') ? $produkStokRendah->count() : count($produkStokRendah) }} {{ __('product_item') }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4" style="width: 60px;">#</th>
                                    <th>{{ __('item_name') }}</th>
                                    <th class="pe-4 text-end">{{ __('remaining_stock') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkStokRendah as $index => $produk)
                                <tr>
                                    <td class="ps-4 fw-semibold" style="color: var(--text-muted); font-size: 0.8rem;">
                                        {{ method_exists($produkStokRendah, 'firstItem') ? $produkStokRendah->firstItem() + $index : $loop->iteration }}
                                    </td>
                                    <td class="fw-bold" style="color: var(--text-heading);">{{ $produk->nama }}</td>
                                    <td class="pe-4 text-end">
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1 fw-bold">
                                            {{ $produk->stok }} {{ __('unit') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5" style="color: var(--text-muted);">
                                        <i class="bi bi-check-circle-fill fs-1 d-block mb-2" style="color: var(--text-light);"></i>
                                        <span>{{ __('all_stock_safe') }}</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- STOK HABIS --}}
        <div class="col-lg-6">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-danger d-flex align-items-center gap-2 fs-6">
                        <i class="bi bi-x-circle-fill"></i> {{ __('out_of_stock') }}
                    </span>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1 fw-bold">
                        {{ method_exists($produkStokHabis, 'count') ? $produkStokHabis->count() : count($produkStokHabis) }} {{ __('product_item') }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4" style="width: 60px;">#</th>
                                    <th>{{ __('item_name') }}</th>
                                    <th class="pe-4 text-end">{{ __('remarks') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkStokHabis as $index => $produk)
                                <tr>
                                    <td class="ps-4 fw-semibold" style="color: var(--text-muted); font-size: 0.8rem;">
                                        {{ method_exists($produkStokHabis, 'firstItem') ? $produkStokHabis->firstItem() + $index : $loop->iteration }}
                                    </td>
                                    <td class="fw-bold" style="color: var(--text-heading);">{{ $produk->nama }}</td>
                                    <td class="pe-4 text-end">
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1 fw-bold">
                                            {{ __('out_of_stock_status') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5" style="color: var(--text-muted);">
                                        <i class="bi bi-emoji-smile-fill fs-1 d-block mb-2" style="color: var(--text-light);"></i>
                                        <span>{{ __('no_out_of_stock') }}</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- SCRIPT JAM REALTIME --}}
<script>
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('liveClock').textContent = `${hours}:${minutes}:${seconds} WIB`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

@endsection