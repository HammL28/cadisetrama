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
                    Tampilan & Cetak Nota
                </h1>
                <p class="text-white-50 mb-0 fs-6">Sesuaikan header, footer, ukuran kertas, dan informasi toko pada struk belanja.</p>
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
                            <input type="text" name="receipt_header_title" id="receipt_header_title" class="form-control" placeholder="Toko Maju Jaya POS" value="{{ old('receipt_header_title', $user->receipt_header_title ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="receipt_address" class="form-label">Alamat Toko</label>
                            <textarea name="receipt_address" id="receipt_address" class="form-control" rows="2" placeholder="Jl. Sudirman No. 123, Jakarta">{{ old('receipt_address', $user->receipt_address ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="receipt_phone" class="form-label">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="receipt_phone" id="receipt_phone" class="form-control" placeholder="0812-3456-7890" value="{{ old('receipt_phone', $user->receipt_phone ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. FOOTER & PESAN PENUTUP --}}
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-chat-left-quote"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Footer & Pesan Penutup</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Pesan ucapan & info sosmed di bawah nota</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="receipt_footer_msg" class="form-label">Pesan Penutup (Footer)</label>
                            <textarea name="receipt_footer_msg" id="receipt_footer_msg" class="form-control" rows="2" placeholder="Terima Kasih Atas Kunjungan Anda!">{{ old('receipt_footer_msg', $user->receipt_footer_msg ?? 'Terima Kasih!') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="receipt_social" class="form-label">Info Sosial Media / Website</label>
                            <input type="text" name="receipt_social" id="receipt_social" class="form-control" placeholder="IG: @tokokamu | www.tokokamu.com" value="{{ old('receipt_social', $user->receipt_social ?? '') }}">
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Cetak Kode QR Transaksi</div>
                                <div class="small" style="color: var(--text-muted);">Tampilkan QR di bawah nota untuk verifikasi/cek struk</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch {{ ($user->show_qr_on_receipt ?? true) ? 'active' : '' }}" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="show_qr_on_receipt" value="1" {{ ($user->show_qr_on_receipt ?? true) ? 'checked' : '' }} hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. FORMAT PRINTER & UKURAN KERTAS --}}
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-printer"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Format Thermal Printer</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Pengaturan ukuran dan opsi cetak</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="paper_size" class="form-label">Ukuran Kertas Thermal</label>
                            <select name="paper_size" id="paper_size" class="form-select">
                                <option value="58mm" {{ (old('paper_size', $user->paper_size ?? '') == '58mm') ? 'selected' : '' }}>58 mm (Struk Kecil Standard)</option>
                                <option value="80mm" {{ (old('paper_size', $user->paper_size ?? '') == '80mm') ? 'selected' : '' }}>80 mm (Struk Lebar / Kasir Besar)</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3 mb-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Auto Print Setelah Bayar</div>
                                <div class="small" style="color: var(--text-muted);">Langsung cetak struk tanpa menekan tombol print</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch {{ ($user->auto_print_receipt ?? true) ? 'active' : '' }}" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="auto_print_receipt" value="1" {{ ($user->auto_print_receipt ?? true) ? 'checked' : '' }} hidden>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Buka Cash Drawer Otomatis</div>
                                <div class="small" style="color: var(--text-muted);">Kirim sinyal potong kertas & buka laci uang</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch {{ ($user->open_cash_drawer ?? true) ? 'active' : '' }}" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="open_cash_drawer" value="1" {{ ($user->open_cash_drawer ?? true) ? 'checked' : '' }} hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. LOGO & TAMPILAN ELEMEN --}}
            <div class="col-lg-6">
                <div class="card dashboard-card h-100">
                    <div class="card-top-accent"></div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="icon-box-modern me-3">
                                <i class="bi bi-image"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-heading);">Logo & Opsi Tambahan</h4>
                                <span class="text-muted small" style="color: var(--text-muted);">Visibilitas elemen cetak</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3 mb-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Tampilkan Nama Kasir</div>
                                <div class="small" style="color: var(--text-muted);">Cetak nama petugas kasir yang melayani</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch {{ ($user->show_cashier_name ?? true) ? 'active' : '' }}" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="show_cashier_name" value="1" {{ ($user->show_cashier_name ?? true) ? 'checked' : '' }} hidden>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3 mb-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Tampilkan Nama Pelanggan</div>
                                <div class="small" style="color: var(--text-muted);">Sertakan nama member/customer jika ada</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch {{ ($user->show_customer_name ?? true) ? 'active' : '' }}" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="show_customer_name" value="1" {{ ($user->show_customer_name ?? true) ? 'checked' : '' }} hidden>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between py-3 px-3 rounded-3" style="background: var(--icon-bg); border: 1px solid var(--card-border);">
                            <div class="flex-grow-1 me-2">
                                <div class="fw-semibold mb-1" style="color: var(--text-heading);">Tampilkan Rincian Pajak/Diskon</div>
                                <div class="small" style="color: var(--text-muted);">Pisahkan potongan diskon & pajak secara transparan</div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="toggle-switch {{ ($user->show_tax_discount_breakdown ?? true) ? 'active' : '' }}" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="show_tax_discount_breakdown" value="1" {{ ($user->show_tax_discount_breakdown ?? true) ? 'checked' : '' }} hidden>
                                </div>
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
                        <i class="bi bi-check-circle-fill me-2"></i>Simpan Pengaturan Struk
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
</script>

@endsection