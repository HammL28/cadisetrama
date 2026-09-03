@extends('layouts.app')

@section('title', 'Kelola Produk - POS ILHAM')

@section('content')

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* ==========================================
       CSS VARIABLES (HIERARCHY & PURPLE THEME)
       ========================================== */
    :root {
        --primary-gradient: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #9333ea 100%);
        --bg-slate: #f5f3ff;
        --card-bg: #ffffff;
        --card-border: #e9d5ff;

        --text-heading: #2e1065;
        --text-body: #4c1d95;
        --text-muted: #6b21a8;
        --text-light: #9333ea;

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

    /* HEADER BANNER */
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

    /* TYPOGRAPHY */
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

    /* IKON & BOX */
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

    .badge-purple {
        background-color: #f3e8ff !important;
        color: #6b21a8 !important;
        border: 1px solid #e9d5ff;
        font-weight: 600;
    }

    /* CARDS */
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

    /* TABLES */
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

    /* BUTTONS */
    .btn-action-purple {
        background-color: #f3e8ff !important;
        color: var(--icon-color) !important;
        border: none !important;
        transition: var(--transition);
    }
    .btn-action-purple:hover {
        background-color: #7e22ce !important;
        color: #ffffff !important;
        transform: scale(1.1);
    }

    .btn-action-edit {
        background-color: #faf5ff !important;
        color: var(--icon-color) !important;
        border: 1px solid #e9d5ff !important;
        transition: var(--transition);
    }
    .btn-action-edit:hover {
        background-color: #7e22ce !important;
        color: #ffffff !important;
        transform: scale(1.1);
    }

    .btn-action-delete {
        background-color: #fff1f2 !important;
        color: #e11d48 !important;
        border: 1px solid #ffe4e6 !important;
        transition: var(--transition);
    }
    .btn-action-delete:hover {
        background-color: #e11d48 !important;
        color: #ffffff !important;
        transform: scale(1.1);
    }

    /* INPUTS & BADGES */
    .bg-search {
        background-color: #ffffff !important;
        border: 1px solid #ddd6fe !important;
        transition: var(--transition);
    }

    .search-box:focus-within .bg-search {
        border-color: var(--icon-color) !important;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.15) !important;
    }

    .badge-soft-emerald {
        background-color: #dcfce7 !important;
        color: #15803d !important;
        border: 1px solid #a7f3d0 !important;
    }

    .badge-soft-amber {
        background-color: #fef3c7 !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }

    .badge-soft-danger {
        background-color: #fee2e2 !important;
        color: #b91c1c !important;
        border: 1px solid #fca5a5 !important;
    }

    .product-thumb {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 12px;
    }

    .product-thumb-placeholder {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background-color: var(--icon-bg);
        color: var(--icon-color);
    }

    .swal2-popup {
        border-radius: 20px !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }

    /* PAGINATION */
    .pagination-modern {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .pagination-modern .page-item {
        margin: 0;
    }

    .pagination-modern .page-link {
        border: 1px solid var(--card-border) !important;
        background-color: var(--card-bg) !important;
        color: var(--text-body) !important;
        border-radius: 10px !important;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: var(--transition);
        min-width: 40px;
        text-align: center;
    }

    .pagination-modern .page-link:hover {
        background-color: var(--icon-bg) !important;
        border-color: var(--icon-color) !important;
        color: var(--icon-color) !important;
        transform: translateY(-2px);
    }

    .pagination-modern .page-item.active .page-link {
        background-color: var(--icon-color) !important;
        border-color: var(--icon-color) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .pagination-modern .page-item.disabled .page-link {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
        color: #94a3b8 !important;
        cursor: not-allowed;
    }

    .pagination-info {
        color: var(--text-muted) !important;
        font-size: 0.875rem;
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
                        <i class="bi bi-box-seam"></i>
                        <span>Manajemen Produk</span>
                    </div>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    Kelola Produk
                </h1>
                <p class="text-white-50 mb-0 fs-6">Kelola dan pantau stok barang Anda secara real-time</p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button onclick="window.print()" class="btn btn-outline-light rounded-pill px-3 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                        <i class="bi bi-printer-fill"></i>
                        <span>Cetak Data</span>
                    </button>

                    @can('create', App\Models\Produk::class)
                        <a href="{{ route('produk.create') }}" class="btn btn-light rounded-pill px-4 shadow-sm fw-bold d-inline-flex align-items-center gap-2" style="color: var(--text-heading) !important;">
                            <i class="bi bi-plus-circle-fill" style="color: var(--icon-color);"></i>
                            <span>Tambah Produk</span>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- STATISTIK RINGKASAN PRODUK --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <div class="icon-box-modern me-3 shadow-sm">
                <i class="bi bi-boxes"></i>
            </div>
            <div>
                <h2 class="h-title-main mb-0">Ringkasan Produk</h2>
                <span class="h-title-sub">Informasi statistik stok produk</span>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- TOTAL PRODUK --}}
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">Total Produk</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-boxes"></i>
                        </div>
                    </div>
                    <div class="h-metric-value">{{ method_exists($products, 'total') ? $products->total() : count($products) }}</div>
                </div>
            </div>
        </div>

        {{-- TOTAL STOK --}}
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">Total Stok Barang</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-stack"></i>
                        </div>
                    </div>
                    <div class="h-metric-value">{{ $products->sum('stok') }}</div>
                </div>
            </div>
        </div>

        {{-- STOK KRITIS --}}
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">Stok Kritis</span>
                        <div class="icon-box-modern" style="background-color: #fef3c7 !important; color: #b45309 !important; border-color: #fde68a !important;">
                            <i class="bi bi-exclamation-triangle-fill" style="color: #b45309 !important;"></i>
                        </div>
                    </div>
                    <div class="h-metric-value" style="color: #b45309 !important;">{{ $products->where('stok', '<=', 10)->where('stok', '>', 0)->count() }}</div>
                </div>
            </div>
        </div>

        {{-- STOK HABIS --}}
        <div class="col-md-6 col-xl-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">Stok Habis</span>
                        <div class="icon-box-modern" style="background-color: #fee2e2 !important; color: #b91c1c !important; border-color: #fca5a5 !important;">
                            <i class="bi bi-x-circle-fill" style="color: #b91c1c !important;"></i>
                        </div>
                    </div>
                    <div class="h-metric-value" style="color: #b91c1c !important;">{{ $products->where('stok', 0)->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CARD --}}
    <div class="card dashboard-card mb-4">

        {{-- CARD HEADER / FILTER & SEARCH --}}
        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
            <form action="{{ route('produk.index') }}" method="GET">
                <div class="row g-3 justify-content-between align-items-center">

                    {{-- SEARCH BAR --}}
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group search-box">
                            <span class="input-group-text border-end-0 rounded-start-pill ps-3 bg-search">
                                <i class="bi bi-search" style="color: var(--icon-color);"></i>
                            </span>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control border-start-0 rounded-end-pill ps-0 bg-search shadow-none"
                                placeholder="Cari nama produk..."
                                id="fastSearchInput"
                            >
                        </div>
                    </div>

                    {{-- FILTER KATEGORI & STATUS STOK --}}
                    <div class="col-md-7 col-lg-8 d-flex flex-wrap align-items-center justify-content-md-end gap-2">

                        {{-- FILTER JENIS / KATEGORI --}}
                        <select name="jenis" class="form-select bg-search rounded-pill shadow-none w-auto" onchange="this.form.submit()" style="color: var(--text-body); font-weight: 500;">
                            <option value="">Semua Kategori</option>
                            <option value="Minuman" {{ request('jenis') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                            <option value="Makanan" {{ request('jenis') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                            <option value="Snack" {{ request('jenis') == 'Snack' ? 'selected' : '' }}>Snack</option>
                            <option value="Elektronik" {{ request('jenis') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="ATK" {{ request('jenis') == 'ATK' ? 'selected' : '' }}>ATK</option>
                        </select>

                        {{-- FILTER STATUS STOK --}}
                        <select name="stok_status" class="form-select bg-search rounded-pill shadow-none w-auto" onchange="this.form.submit()" style="color: var(--text-body); font-weight: 500;">
                            <option value="">Semua Status Stok</option>
                            <option value="ready" {{ request('stok_status') == 'ready' ? 'selected' : '' }}>Stok Tersedia</option>
                            <option value="kritis" {{ request('stok_status') == 'kritis' ? 'selected' : '' }}>Stok Kritis</option>
                            <option value="habis" {{ request('stok_status') == 'habis' ? 'selected' : '' }}>Stok Habis</option>
                        </select>

                        @if(request('search') || request('jenis') || request('stok_status'))
                            <a href="{{ route('produk.index') }}" class="btn btn-sm btn-light rounded-pill px-3 border-0" style="color: var(--icon-color); background: var(--icon-bg);">
                                <i class="bi bi-x-circle me-1"></i>Reset
                            </a>
                        @endif
                    </div>

                </div>
            </form>
        </div>

        {{-- TABLE SECTION --}}
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-custom">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 5%;">No</th>
                            <th style="width: 8%;">Foto</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Ditambahkan Oleh</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th class="pe-4 text-end" style="width: 12%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($products as $product)
                        <tr class="product-row">
                            <td class="ps-4 text-muted small fw-semibold">
                                {{ method_exists($products, 'firstItem') ? $products->firstItem() + $loop->index : $loop->iteration }}
                            </td>
                            <td>
                                @if(!empty($product->foto))
                                    <img src="{{ Str::startsWith($product->foto, ['http://', 'https://']) ? $product->foto : asset('storage/' . $product->foto) }}" 
                                         alt="{{ $product->nama }}" 
                                         class="product-thumb shadow-sm border"
                                         onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=No+Image';">
                                @else
                                    <div class="product-thumb-placeholder d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                        <i class="bi bi-image" style="color: var(--icon-color);"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold d-block" style="color: var(--text-heading);">{{ $product->nama }}</span>
                            </td>
                            <td>
                                <span class="badge badge-purple px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-tag-fill me-1"></i>{{ $product->jenis ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                <span class="badge badge-purple px-2.5 py-1 rounded-pill fw-medium">
                                    <i class="bi bi-person-fill me-1"></i>{{ $product->user->name ?? '-' }}
                                </span>
                            </td>
                            <td class="text-secondary small fw-semibold">
                                Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                            </td>
                            <td class="fw-bold small" style="color: var(--text-heading); font-size: 0.95rem;">
                                Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($product->stok > 10)
                                    <span class="badge badge-soft-emerald px-3 py-1.5 rounded-pill fw-bold">
                                        {{ $product->stok }} Pcs
                                    </span>
                                @elseif($product->stok > 0)
                                    <span class="badge badge-soft-amber px-3 py-1.5 rounded-pill fw-bold">
                                        {{ $product->stok }} Pcs (Kritis)
                                    </span>
                                @else
                                    <span class="badge badge-soft-danger px-3 py-1.5 rounded-pill fw-bold">
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    {{-- DETAIL --}}
                                    @can('view', $product)
                                        <a href="{{ route('produk.show', $product) }}" class="btn btn-action-purple rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Lihat Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @endcan

                                    {{-- EDIT --}}
                                    @can('update', $product)
                                        <a href="{{ route('produk.edit', $product) }}" class="btn btn-action-edit rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Edit Produk">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    @endcan

                                    {{-- DELETE --}}
                                    @can('delete', $product)
                                        <button type="button"
                                                class="btn btn-action-delete rounded-circle d-inline-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px;"
                                                title="Hapus Produk"
                                                onclick="triggerDeleteModal('{{ route('produk.destroy', $product) }}', '{{ $product->nama }}')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-1 d-block mb-2" style="color: var(--icon-color);"></i>
                                <span class="fw-medium">Tidak ada produk yang ditemukan</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION FOOTER --}}
            @if(method_exists($products, 'hasPages') && $products->hasPages())
                <div class="card-footer bg-white border-0 px-4 py-3 border-top" style="background-color: var(--card-bg) !important; border-color: var(--card-border) !important;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                        <span class="pagination-info">
                            Menampilkan <strong>{{ $products->firstItem() }}</strong> - <strong>{{ $products->lastItem() }}</strong> dari <strong>{{ $products->total() }}</strong> produk
                        </span>
                        <nav>
                            <ul class="pagination-modern">
                                {{-- Previous Button --}}
                                @if($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}{{ request()->query() ? '&' . http_build_query(request()->except('page')) : '' }}">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Page Numbers --}}
                                @php
                                    $startPage = max(1, $products->currentPage() - 2);
                                    $endPage = min($products->lastPage(), $products->currentPage() + 2);
                                @endphp
                                @for($i = $startPage; $i <= $endPage; $i++)
                                    @if($i == $products->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link">{{ $i }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->url($i) }}{{ request()->query() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor

                                {{-- Next Button --}}
                                @if($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}{{ request()->query() ? '&' . http_build_query(request()->except('page')) : '' }}">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
        </div>

    </div>

</div>

{{-- FORM HIDDEN UNTUK PROSES HAPUS --}}
<form id="globalDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function triggerDeleteModal(deleteUrl, productName) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: `Apakah Anda yakin ingin menghapus produk "${productName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: { popup: 'shadow-lg' }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('globalDeleteForm');
                form.action = deleteUrl;
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            Swal.fire({
                title: 'Gagal Dihapus!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#6d28d9',
                confirmButtonText: 'Mengerti'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#6d28d9',
                confirmButtonText: 'Tutup',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Instant Client-Side Fast Search Filter
        const searchInput = document.getElementById('fastSearchInput');
        const tableRows = document.querySelectorAll('.product-row');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase().trim();

                tableRows.forEach(function(row) {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection