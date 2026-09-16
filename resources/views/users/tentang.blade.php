@extends('layouts.app')

@section('title', 'Tentang Aplikasi - POS System')

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

    /* BADGES */
    .badge-purple {
        background-color: #f3e8ff !important;
        color: #6b21a8 !important;
        border: 1px solid #e9d5ff;
        font-weight: 600;
    }

    /* Profile Avatar */
    .profile-avatar-container {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        padding: 4px;
        background: var(--primary-gradient);
        box-shadow: 0 8px 24px rgba(124, 58, 237, 0.3);
        margin: 0 auto 1.5rem;
        position: relative;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #ffffff;
        border: 4px solid #ffffff;
    }

    /* Info Box */
    .info-box {
        background: var(--icon-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius-md);
        padding: 1.25rem;
        transition: var(--transition);
    }

    .info-box:hover {
        background: #ede9ff;
        border-color: var(--icon-color);
    }

    .info-label {
        color: var(--text-muted);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .info-value {
        color: var(--text-heading);
        font-size: 1rem;
        font-weight: 600;
    }

    /* Back Button */
    .btn-back {
        background: var(--primary-gradient) !important;
        color: #ffffff !important;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    {{-- HEADER BANNER --}}
    <div class="dashboard-header-banner mb-4">
        <div class="row align-items-center g-3 position-relative" style="z-index: 1;">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <div class="date-badge">
                        <i class="bi bi-shop"></i>
                        <span>Tentang Aplikasi</span>
                    </div>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
            POINT OF SALE 
                </h1>
                <p class="text-white-50 mb-0 fs-6">Solusi kasir modern untuk usaha yang lebih efisien dan terukur.</p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light rounded-pill px-4 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="dashboard-card p-4 position-relative">
                <div class="card-top-accent"></div>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="icon-box-modern">
                        <i class="bi bi-shop-window"></i>
                    </div>
                    <div>
                        <span class="badge badge-purple px-3 py-2 rounded-pill">Tentang Aplikasi</span>
                        <h2 class="mb-0 mt-2 fw-bold" style="color: var(--text-heading);">POINT OF SALE</h2>
                    </div>
                </div>

                <p class="mb-3" style="color: var(--text-body); line-height: 1.8;">
                    POINT OF SALE adalah sistem point of sale yang dirancang untuk membantu bisnis retail, usaha kecil,
                    dan toko modern dalam mengelola transaksi, stok barang, serta laporan penjualan secara cepat dan akurat.
                    Dengan antarmuka yang sederhana namun powerful, aplikasi ini membantu operasional toko menjadi lebih efisien,
                    rapi, dan mudah dipantau dari satu dashboard.
                </p>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="info-box h-100">
                            <div class="info-label">Visi</div>
                            <div class="info-value">Menyediakan solusi kasir modern yang mudah digunakan oleh semua level pengguna.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box h-100">
                            <div class="info-label">Misi</div>
                            <div class="info-value">Mempermudah pengelolaan transaksi, stok, dan laporan agar usaha lebih berkembang.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="dashboard-card p-4 position-relative h-100">
                <div class="card-top-accent"></div>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="icon-box-modern">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h4 class="mb-0 fw-bold" style="color: var(--text-heading);">Keunggulan</h4>
                </div>

                <ul class="list-unstyled mb-0" style="color: var(--text-body); line-height: 2;">
                    <li><i class="bi bi-check-circle-fill me-2" style="color: #7c3aed;"></i>Transaksi cepat dan akurat</li>
                    <li><i class="bi bi-check-circle-fill me-2" style="color: #7c3aed;"></i>Manajemen stok otomatis</li>
                    <li><i class="bi bi-check-circle-fill me-2" style="color: #7c3aed;"></i>Pencatatan pelanggan & penjualan</li>
                    <li><i class="bi bi-check-circle-fill me-2" style="color: #7c3aed;"></i>Laporan harian dan bulanan</li>
                    <li><i class="bi bi-check-circle-fill me-2" style="color: #7c3aed;"></i>Antarmuka yang user-friendly</li>
                </ul>
            </div>
        </div>

        <div class="col-12">
            <div class="dashboard-card p-4 position-relative">
                <div class="card-top-accent"></div>
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2" style="color: var(--text-heading);">Fitur Unggulan POS</h3>
                    <p class="mb-0 text-muted" style="color: var(--text-muted);">Semua kebutuhan operasional toko dalam satu platform</p>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 col-xl-3">
                        <div class="info-box h-100">
                            <div class="icon-box-modern mb-3">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div class="info-label">Kasir</div>
                            <div class="info-value">Proses transaksi lebih cepat dengan tampilan kasir yang sederhana dan efisien.</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="info-box h-100">
                            <div class="icon-box-modern mb-3">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="info-label">Inventori</div>
                            <div class="info-value">Pantau stok barang, pembaruan produk, dan pemantauan ketersediaan secara real time.</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="info-box h-100">
                            <div class="icon-box-modern mb-3">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="info-label">Pelanggan</div>
                            <div class="info-value">Kelola data pelanggan, histori pembelian, dan hubungan bisnis yang lebih terarah.</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="info-box h-100">
                            <div class="icon-box-modern mb-3">
                                <i class="bi bi-bar-chart-line"></i>
                            </div>
                            <div class="info-label">Laporan</div>
                            <div class="info-value">Analisa penjualan harian, bulanan, dan performa produk dengan laporan yang jelas.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="dashboard-card p-4 position-relative">
                <div class="card-top-accent"></div>
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <h3 class="fw-bold mb-3" style="color: var(--text-heading);">Kenapa bisnis Anda perlu aplikasi POS ini?</h3>
                        <p style="color: var(--text-body); line-height: 1.8; mb-0;">
                            Karena setiap usaha membutuhkan sistem transaksi yang cepat, rapi, dan terukur. Dengan POINT OF SALE, Anda dapat mengelola penjualan, stok, dan laporan dengan lebih mudah, sehingga fokus pada pengembangan bisnis menjadi lebih optimal.
                            Anda dapat mengurangi kesalahan pencatatan, mempercepat proses checkout, serta mengambil keputusan bisnis
                            dengan data penjualan yang lebih akurat dan terstruktur.
                        </p>
                    </div>
                    <div class="col-lg-5">
                        <div class="info-box h-100">
                            <div class="info-label">Nilai utama</div>
                            <div class="info-value">Efisiensi operasional, transparansi data, dan keputusan bisnis yang lebih tepat.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection