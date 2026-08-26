@extends('layouts.app')

@section('title', 'Profil Pengguna - POS System')

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
                        <i class="bi bi-person"></i>
                        <span>Profil Pengguna</span>
                    </div>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    Profil Saya
                </h1>
                <p class="text-white-50 mb-0 fs-6">Kelola informasi profil dan pengaturan akun Anda.</p>
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
        {{-- PROFILE CARD --}}
        <div class="col-lg-4">
            <div class="card dashboard-card h-100">
                <div class="card-top-accent"></div>
                <div class="card-body p-4 text-center">
                    <div class="profile-avatar-container">
                        @if ($user->photo && Illuminate\Support\Facades\Storage::disk('public')->exists($user->photo))
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Avatar" class="profile-avatar">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=7c3aed&color=ffffff&bold=true&size=200" alt="Avatar" class="profile-avatar">
                        @endif
                    </div>

                    <h3 class="fw-bold mb-2" style="color: var(--text-heading); font-size: 1.5rem;">{{ $user->name }}</h3>
                    <p class="text-muted mb-3" style="color: var(--text-muted);">{{ $user->email }}</p>

                    <div class="badge badge-purple px-4 py-2 rounded-pill fs-6 mb-4">
                        <i class="bi bi-shield-fill me-2"></i>
                        {{ ucfirst($user->role->name ?? $user->role->NAME ?? (is_string($user->role) ? $user->role : 'Admin')) }}
                    </div>

                    <div class="mt-4 pt-4 border-top" style="border-color: var(--card-border) !important;">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small" style="color: var(--text-muted);">ID Pengguna</span>
                            <span class="small fw-bold" style="color: var(--text-heading);">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="small" style="color: var(--text-muted);">Terdaftar Sejak</span>
                            <span class="small fw-bold" style="color: var(--text-heading);">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DETAILED INFORMATION --}}
        <div class="col-lg-8">
            {{-- PERSONAL INFORMATION --}}
            <div class="card dashboard-card mb-4">
                <div class="card-top-accent"></div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box-modern me-3">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Personal Information</h4>
                            <span class="text-muted small" style="color: var(--text-muted);">Informasi pribadi Anda</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="color: var(--text-muted); font-size: 0.75rem;">Full Name</label>
                                <div class="form-control-plaintext fw-semibold" style="color: var(--text-heading); border: 1px solid var(--card-border); padding: 0.75rem; border-radius: 10px; background: var(--icon-bg);">
                                    {{ $user->name }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="color: var(--text-muted); font-size: 0.75rem;">Email Address</label>
                                <div class="form-control-plaintext fw-semibold" style="color: var(--text-heading); border: 1px solid var(--card-border); padding: 0.75rem; border-radius: 10px; background: var(--icon-bg);">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="color: var(--text-muted); font-size: 0.75rem;">Role</label>
                                <div class="form-control-plaintext fw-semibold" style="color: var(--text-heading); border: 1px solid var(--card-border); padding: 0.75rem; border-radius: 10px; background: var(--icon-bg);">
                                    {{ ucfirst($user->role->name ?? $user->role->NAME ?? (is_string($user->role) ? $user->role : 'Admin')) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="color: var(--text-muted); font-size: 0.75rem;">User ID</label>
                                <div class="form-control-plaintext fw-semibold" style="color: var(--text-heading); border: 1px solid var(--card-border); padding: 0.75rem; border-radius: 10px; background: var(--icon-bg);">
                                    #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACCOUNT INFORMATION --}}
            <div class="card dashboard-card mb-4">
                <div class="card-top-accent"></div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box-modern me-3">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Account Information</h4>
                            <span class="text-muted small" style="color: var(--text-muted);">Informasi akun dan aktivitas</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="color: var(--text-muted); font-size: 0.75rem;">Terdaftar Sejak</label>
                                <div class="form-control-plaintext fw-semibold" style="color: var(--text-heading); border: 1px solid var(--card-border); padding: 0.75rem; border-radius: 10px; background: var(--icon-bg);">
                                    {{ $user->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold" style="color: var(--text-muted); font-size: 0.75rem;">Terakhir Update</label>
                                <div class="form-control-plaintext fw-semibold" style="color: var(--text-heading); border: 1px solid var(--card-border); padding: 0.75rem; border-radius: 10px; background: var(--icon-bg);">
                                    {{ $user->updated_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>

@endsection