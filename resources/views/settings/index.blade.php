@extends('layouts.app')

@section('title', 'Pengaturan Struk & Branding - POS System')

@section('content')

<style>
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

        --radius-lg: 20px;
        --radius-md: 14px;
        --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
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

    .toggle-switch {
        position: relative;
        width: 56px;
        height: 30px;
        background: #e9d5ff;
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .toggle-switch.active {
        background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
    }

    .toggle-switch::after {
        content: '';
        position: absolute;
        top: 4px;
        left: 4px;
        width: 22px;
        height: 22px;
        background: #ffffff;
        border-radius: 50%;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toggle-switch.active::after {
        left: 30px;
    }

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

    .form-label {
        color: var(--text-heading);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border-color: var(--card-border) !important;
        padding: 0.75rem;
        border-radius: 10px;
        color: var(--text-body);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--icon-color) !important;
        box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
    }

    /* KUSTOMISASI SIDEBAR - preview swatch warna */
    .sidebar-color-preview {
        height: 48px;
        border-radius: 10px;
        border: 1px solid var(--card-border);
        margin-top: 0.75rem;
    }

    .form-control-color {
        height: 46px;
        padding: 0.3rem;
        cursor: pointer;
    }

    .form-range::-webkit-slider-thumb {
        background: #7c3aed;
    }

    .current-photo-preview {
        width: 100%;
        height: 90px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--card-border);
        margin-bottom: 0.5rem;
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    {{-- HEADER BANNER --}}
    <div class="dashboard-header-banner mb-4">
        <div class="row align-items-center g-3 position-relative" style="z-index: 1;">
            <div class="col-lg-7">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <div class="date-badge">
                        <i class="bi bi-receipt"></i>
                        <span>Pengaturan Struk</span>
                    </div>
                </div>
                <h1 class="fw-bold text-white mb-2 fs-2">
                    Pengaturan
                </h1>
                <p class="text-white-50 mb-0 fs-6">Sesuaikan header, footer, rekening bank, ukuran kertas, dan informasi toko pada struk belanja.</p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light rounded-pill px-4 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    {{-- NOTIFIKASI SUKSES ATAU ERROR --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <strong class="d-block mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Menyimpan:</strong>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- FORM UTAMA PENGATURAN --}}
    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
        @csrf
        @method('PUT')

        <div class="row g-4 mb-4">

           

            {{-- 1. HEADER STRUK & IDENTITAS TOKO --}}
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Header & Identitas Struk</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Informasi bagian atas cetakan nota</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="receipt_header_title" class="form-label">Nama Toko / Judul Struk</label>
                            <input type="text" name="receipt_header_title" id="receipt_header_title" class="form-control" placeholder="Toko Maju Jaya POS" value="{{ old('receipt_header_title', $user->store_name ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="receipt_address" class="form-label">Alamat Toko</label>
                            <textarea name="receipt_address" id="receipt_address" class="form-control" rows="2" placeholder="Jl. Sudirman No. 123, Jakarta">{{ old('receipt_address', $user->store_address ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="receipt_phone" class="form-label">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="receipt_phone" id="receipt_phone" class="form-control" placeholder="0812-3456-7890" value="{{ old('receipt_phone', $user->store_phone ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. REKENING BANK SEBAGAI METODE PEMBAYARAN --}}
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-bank"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Pengaturan Rekening Bank</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Nomor rekening transfer untuk pembayaran Kasir</span>
                            </div>
                        </div>

                        {{-- Rekening BCA --}}
                        <div class="p-3 mb-3 border rounded-3 bg-light">
                            <div class="fw-bold mb-2 text-primary d-flex align-items-center gap-1">
                                <i class="bi bi-credit-card"></i> Bank BCA
                            </div>
                            <div class="row g-2">
                                <div class="col-md-7">
                                    <label class="form-label small mb-1">Nomor Rekening BCA</label>
                                    <input type="text" name="bca_account_number" class="form-control form-control-sm" placeholder="Contoh: 1234567890" value="{{ old('bca_account_number', $user->bca_account_number ?? '1234567890') }}">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small mb-1">Atas Nama (A.N)</label>
                                    <input type="text" name="bca_account_holder" class="form-control form-control-sm" placeholder="A.N Pemilik" value="{{ old('bca_account_holder', $user->bca_account_holder ?? 'PT TOKO KASIR POS') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Rekening Mandiri --}}
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="fw-bold mb-2 text-warning d-flex align-items-center gap-1">
                                <i class="bi bi-credit-card"></i> Bank Mandiri
                            </div>
                            <div class="row g-2">
                                <div class="col-md-7">
                                    <label class="form-label small mb-1">Nomor Rekening Mandiri</label>
                                    <input type="text" name="mandiri_account_number" class="form-control form-control-sm" placeholder="Contoh: 1370001234567" value="{{ old('mandiri_account_number', $user->mandiri_account_number ?? '1370001234567') }}">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small mb-1">Atas Nama (A.N)</label>
                                    <input type="text" name="mandiri_account_holder" class="form-control form-control-sm" placeholder="A.N Pemilik" value="{{ old('mandiri_account_holder', $user->mandiri_account_holder ?? 'PT TOKO KASIR POS') }}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

           
           

            {{-- KUSTOMISASI TAMPILAN SIDEBAR --}}
            <div class="col-12">
                <div class="card dashboard-card">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-layout-sidebar-inset"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Tampilan Sidebar</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Atur nama, warna, logo, dan bentuk tampilan sidebar aplikasi.</span>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="sidebar_brand_text" class="form-label">Nama Brand Sidebar</label>
                                <input type="text" name="sidebar_brand_text" id="sidebar_brand_text" class="form-control" maxlength="50" placeholder="POS ILHAM" value="{{ old('sidebar_brand_text', $user->sidebar_brand_text ?? 'POS ILHAM') }}">
                            </div>

                            <div class="col-lg-6">
                                <label for="sidebar_logo_shape" class="form-label">Bentuk Logo</label>
                                <select name="sidebar_logo_shape" id="sidebar_logo_shape" class="form-select">
                                    <option value="circle" {{ old('sidebar_logo_shape', $user->sidebar_logo_shape ?? 'circle') === 'circle' ? 'selected' : '' }}>Lingkaran</option>
                                    <option value="square" {{ old('sidebar_logo_shape', $user->sidebar_logo_shape ?? 'circle') === 'square' ? 'selected' : '' }}>Kotak Membulat</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="sidebar_color_from" class="form-label">Warna Awal Gradasi</label>
                                <input type="color" name="sidebar_color_from" id="sidebar_color_from" class="form-control form-control-color w-100" value="{{ old('sidebar_color_from', $user->sidebar_color_from ?? '#4f46e5') }}">
                            </div>

                            <div class="col-md-6">
                                <label for="sidebar_color_to" class="form-label">Warna Akhir Gradasi</label>
                                <input type="color" name="sidebar_color_to" id="sidebar_color_to" class="form-control form-control-color w-100" value="{{ old('sidebar_color_to', $user->sidebar_color_to ?? '#e879f9') }}">
                            </div>

                            <div class="col-12">
                                <div id="sidebarColorPreview" class="sidebar-color-preview" aria-label="Preview warna sidebar"></div>
                            </div>

                            <div class="col-lg-7">
                                <label for="sidebar_bg_photo" class="form-label">Logo Sidebar</label>
                                <input type="file" name="sidebar_bg_photo" id="sidebar_bg_photo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                                <div class="form-text">Format JPG, PNG, atau WEBP. Ukuran maksimal 2 MB.</div>
                                @if(!empty($user->sidebar_bg_photo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->sidebar_bg_photo))
                                    <img src="{{ asset('storage/' . $user->sidebar_bg_photo) }}" alt="Logo sidebar saat ini" class="current-photo-preview mt-2">
                                @endif
                            </div>

                            <div class="col-lg-5">
                                <label for="sidebar_bg_opacity" class="form-label">Transparansi Logo: <span id="sidebarOpacityValue">{{ old('sidebar_bg_opacity', $user->sidebar_bg_opacity ?? 25) }}%</span></label>
                                <input type="range" name="sidebar_bg_opacity" id="sidebar_bg_opacity" class="form-range mt-2" min="0" max="80" value="{{ old('sidebar_bg_opacity', $user->sidebar_bg_opacity ?? 25) }}">
                                <div class="form-text">Atur tingkat transparansi logo pada header sidebar.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL SIMPAN --}}
            <div class="col-12">
                <div class="card dashboard-card p-4">
                    <div class="text-center mb-4">
                        <div class="icon-box-modern mx-auto mb-3" style="display: inline-flex;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--text-heading);">Simpan Perubahan</h4>
                        <p class="text-muted mb-0" style="color: var(--text-muted);">Periksa kembali semua data sebelum menyimpan pengaturan.</p>
                    </div>

                    <button type="submit" class="btn btn-back w-100 py-3">
                        <i class="bi bi-check-circle-fill me-2"></i>Simpan Pengaturan Struk & Rekening
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
    function toggleSwitch(element) {
        element.classList.toggle('active');
        const checkbox = element.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = element.classList.contains('active');
        }
    }

    // Live preview gradasi warna sidebar
    function updateSidebarColorPreview() {
        const from = document.getElementById('sidebar_color_from').value;
        const to = document.getElementById('sidebar_color_to').value;
        const preview = document.getElementById('sidebarColorPreview');
        preview.style.background = `linear-gradient(135deg, ${from} 0%, ${to} 100%)`;
    }

    document.getElementById('sidebar_color_from').addEventListener('input', updateSidebarColorPreview);
    document.getElementById('sidebar_color_to').addEventListener('input', updateSidebarColorPreview);
    document.getElementById('sidebar_bg_opacity').addEventListener('input', function () {
        document.getElementById('sidebarOpacityValue').textContent = `${this.value}%`;
    });
    document.addEventListener('DOMContentLoaded', updateSidebarColorPreview);
</script>

@endsection