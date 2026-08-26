@extends('layouts.app')

@section('title', 'Kelola Users - POS System')

@section('content')

<style>
    /* ==========================================
       CSS VARIABLES & THEME SYSTEM
       ========================================== */
    :root {
        /* Gradient Banner & Accents */
        --primary-gradient: linear-gradient(135deg, #4c1d95 0%, #6d28d9 50%, #7c3aed 100%);
        --accent-gradient: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
        
        /* Surface & Borders */
        --bg-slate: #f8fafc;
        --card-bg: #ffffff;
        --card-border: #e9d5ff;

        /* HIERARCHY WARNA TEKS (DIPERBAIKI UNTUK KONTRAS TERBAIK) */
        --text-heading: #1e1b4b;   /* Level 1: Judul Utama & Nama Penting */
        --text-body: #334155;      /* Level 2: Isian Tabel & Teks Utama (Penggunaan Slate Netral) */
        --text-muted: #64748b;     /* Level 3: Label, Subtitle, ID & Meta */
        --text-purple-accent: #6d28d9; /* Level 4: Penekanan Khusus / Brand Color */

        /* Badges & Elements */
        --icon-bg: #f3e8ff;
        --icon-color: #7c3aed;
        --table-head-bg: #f8f5ff;
        --table-hover-bg: #fcf9ff;

        --radius-lg: 18px;
        --radius-md: 12px;
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background: #f3f0ff !important;
        color: var(--text-body) !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* HEADER BANNER */
    .dashboard-header-banner {
        background: var(--primary-gradient) !important;
        border-radius: var(--radius-lg);
        padding: 2.25rem 2rem;
        color: #ffffff !important;
        box-shadow: 0 10px 25px -5px rgba(109, 40, 217, 0.3);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header-banner::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -5%;
        width: 280px;
        height: 280px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        pointer-events: none;
    }

    /* TYPOGRAPHY HIERARCHY */
    .h-metric-label {
        color: var(--text-muted) !important;
        font-size: 0.725rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .h-metric-value {
        color: var(--text-heading) !important;
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .h-title-sub {
        color: var(--text-muted) !important;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* CARDS & STATS */
    .dashboard-card {
        border-radius: var(--radius-md);
        border: 1px solid var(--card-border) !important;
        background: var(--card-bg) !important;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.03);
        position: relative;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(124, 58, 237, 0.08);
        border-color: #c084fc !important;
    }

    .card-top-accent {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary-gradient) !important;
    }

    /* ICON BOXES */
    .icon-box-modern {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
        transition: var(--transition);
        background-color: var(--icon-bg) !important;
        color: var(--icon-color) !important;
        border: 1px solid #e9d5ff;
    }

    .dashboard-card:hover .icon-box-modern {
        transform: scale(1.05);
        background-color: var(--icon-color) !important;
        color: #ffffff !important;
    }

    /* AVATAR & BADGES */
    .avatar-purple {
        background: linear-gradient(135deg, #f3e8ff 0%, #ddd6fe 100%) !important;
        color: #6d28d9 !important;
        font-weight: 700;
        font-size: 0.9rem;
        border: 1px solid var(--card-border);
    }

    .avatar-img-table {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .badge-role-admin {
        background-color: #f3e8ff !important;
        color: #6d28d9 !important;
        border: 1px solid #ddd6fe !important;
        font-weight: 700;
        font-size: 0.75rem;
    }

    .badge-role-kasir {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        border: 1px solid #e2e8f0 !important;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-soft-emerald {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
        font-weight: 600;
        font-size: 0.725rem;
    }

    /* SEARCH & CONTROLS */
    .bg-search {
        background-color: #f8f5ff !important;
        border-color: var(--card-border) !important;
        color: var(--text-heading) !important;
        transition: var(--transition);
    }

    .search-box:focus-within .bg-search {
        background-color: #ffffff !important;
        border-color: #a855f7 !important;
        box-shadow: 0 0 0 0.2rem rgba(168, 85, 247, 0.15) !important;
    }

    /* ACTION BUTTONS */
    .btn-action-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: var(--transition);
        border: none;
        font-size: 0.875rem;
    }

    .btn-edit-soft {
        background-color: #fef3c7 !important;
        color: #d97706 !important;
    }

    .btn-edit-soft:hover {
        background-color: #d97706 !important;
        color: #ffffff !important;
        transform: scale(1.1);
    }

    .btn-delete-soft {
        background-color: #fee2e2 !important;
        color: #dc2626 !important;
    }

    .btn-delete-soft:hover {
        background-color: #dc2626 !important;
        color: #ffffff !important;
        transform: scale(1.1);
    }

    /* TABLE HIERARCHY */
    .table-custom {
        margin-bottom: 0;
    }

    .table-custom thead {
        background-color: var(--table-head-bg) !important;
        border-bottom: 1px solid var(--card-border) !important;
    }

    .table-custom th {
        color: var(--text-muted) !important;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
        padding: 0.875rem 1.25rem;
        border: none;
    }

    .table-custom td {
        padding: 1rem 1.25rem;
        color: var(--text-body) !important;
        border-bottom: 1px solid #f1f5f9 !important;
        font-size: 0.875rem;
    }

    .table-custom tbody tr:hover {
        background-color: var(--table-hover-bg) !important;
    }

    .table-custom tbody tr:hover .user-name-text {
        color: var(--text-purple-accent) !important;
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none !important;
    }
</style>

<div class="container py-4" style="padding-top: 4rem;">

    {{-- HEADER BANNER GRADIENT --}}
    <div class="dashboard-header-banner mb-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index: 1;">
            <div>
                <h1 class="fw-bold text-white mb-1 fs-3 d-flex align-items-center gap-2">
                    <i class="bi bi-people-fill fs-3"></i>
                    <span>Kelola Users</span>
                </h1>
                <p class="text-white-50 mb-0 fs-6">Atur hak akses, kredensial, dan kelola daftar pengguna sistem POS Anda.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button onclick="window.print()" class="btn btn-outline-light rounded-pill px-3 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                    <i class="bi bi-printer"></i>
                    <span>Cetak Data</span>
                </button>

                <a href="{{ route('admin.users.create') }}" class="btn btn-light rounded-pill px-4 shadow-sm fw-bold d-inline-flex align-items-center gap-2" style="color: var(--text-purple-accent) !important;">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Tambah User</span>
                </a>
            </div>
        </div>
        <div class="position-absolute end-0 bottom-0 opacity-25 pe-4 pb-2 d-none d-md-block">
            <i class="bi bi-shield-check text-white" style="font-size: 6rem;"></i>
        </div>
    </div>


    {{-- STATISTIK RINGKASAN USER (4 KARTU SEJAJAR) --}}
    <div class="row g-3 mb-4">
        {{-- TOTAL USER --}}
        <div class="col-6 col-md-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">Total User</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <div class="h-metric-value mb-1">
                        {{ method_exists($users, 'total') ? $users->total() : count($users) }}
                    </div>
                    <span class="h-title-sub">Pengguna terdaftar</span>
                </div>
            </div>
        </div>

        {{-- ADMINISTRATOR --}}
        <div class="col-6 col-md-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">Administrator</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <div class="h-metric-value mb-1">
                        {{ $users->filter(fn($u) => strtolower(is_object($u->role) ? $u->role->name : $u->role ?? '') == 'admin')->count() }}
                    </div>
                    <span class="h-title-sub">Akses sistem penuh</span>
                </div>
            </div>
        </div>

        {{-- PETUGAS KASIR --}}
        <div class="col-6 col-md-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">Petugas Kasir</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-person-badge"></i>
                        </div>
                    </div>
                    <div class="h-metric-value mb-1">
                        {{ $users->filter(fn($u) => strtolower(is_object($u->role) ? $u->role->name : $u->role ?? '') != 'admin')->count() }}
                    </div>
                    <span class="h-title-sub">Akses modul kasir</span>
                </div>
            </div>
        </div>

        {{-- STATUS SISTEM --}}
        <div class="col-6 col-md-3">
            <div class="card dashboard-card h-100 p-3">
                <div class="card-top-accent"></div>
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="h-metric-label">Status Sistem</span>
                        <div class="icon-box-modern">
                            <i class="bi bi-check-circle-fill text-success"></i>
                        </div>
                    </div>
                    <div class="h-metric-value mb-1 text-success fs-5 fw-bold" style="line-height: 1.4;">
                        Aktif Normal
                    </div>
                    <span class="h-title-sub">Otentikasi berjalan baik</span>
                </div>
            </div>
        </div>
    </div>


    {{-- MAIN CARD DATA TABLE --}}
    <div class="card dashboard-card mb-4">

        {{-- CARD HEADER / FILTER & SEARCH --}}
        <div class="card-header bg-transparent border-0 pt-3 px-4 pb-2">
            <form action="{{ route('admin.users') }}" method="GET">
                <div class="row g-2 justify-content-between align-items-center">

                    {{-- Input Search --}}
                    <div class="col-md-5 col-lg-4">
                        <div class="input-group search-box">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control rounded-start-pill ps-3 bg-search shadow-none border-end-0"
                                placeholder="Cari nama atau email...">
                            <button class="btn bg-search border-start-0 rounded-end-pill pe-3 d-flex align-items-center" type="submit">
                                <i class="bi bi-search" style="color: var(--text-purple-accent);"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Filter Role & Reset --}}
                    <div class="col-md-7 col-lg-6 d-flex align-items-center justify-content-md-end gap-2">
                        <select name="role" class="form-select bg-search rounded-pill shadow-none border-0 w-auto fw-semibold cursor-pointer" onchange="this.form.submit()">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ request('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>

                        @if(request('search') || request('role'))
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-light rounded-pill px-3 border-0 d-inline-flex align-items-center gap-1" style="color: var(--text-muted);">
                            <i class="bi bi-x-circle"></i>
                            <span>Reset</span>
                        </a>
                        @endif
                    </div>

                </div>
            </form>
        </div>

        {{-- TABLE SECTION --}}
        <div class="card-body p-0 mt-2">
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 5%;">NO</th>
                            <th>NAMA PENGGUNA</th>
                            <th>EMAIL</th>
                            <th>HAK AKSES / ROLE</th>
                            <th>STATUS</th>
                            <th class="pe-4 text-end" style="width: 12%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        @php
                        $roleName = is_object($user->role) ? ($user->role->name ?? 'User') : ($user->role ?? 'User');
                        @endphp
                        <tr>
                            <td class="ps-4 fw-semibold" style="color: var(--text-muted); font-size: 0.8rem;">
                                {{ method_exists($users, 'firstItem') ? $users->firstItem() + $loop->index : $loop->iteration }}
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-purple rounded-circle d-flex align-items-center justify-content-center shadow-sm overflow-hidden" style="width: 40px; height: 40px; flex-shrink: 0;">
                                        @if(isset($user->photo) && $user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}"
                                            alt="{{ $user->name }}"
                                            class="avatar-img-table"
                                            onerror="this.onerror=null; this.parentNode.innerHTML='{{ strtoupper(substr($user->name, 0, 1)) }}';">
                                        @else
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <span class="user-name-text d-block fw-bold" style="color: var(--text-heading); font-size: 0.925rem;">{{ $user->name }}</span>
                                        <span class="h-title-sub" style="font-size: 0.75rem;">ID User: #{{ $user->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <i class="bi bi-envelope text-muted me-1"></i>
                                    <span class="fw-medium" style="color: var(--text-body);">{{ $user->email }}</span>
                                    <button type="button"
                                        class="btn btn-sm btn-link p-0 ms-1 border-0"
                                        style="color: var(--text-muted);"
                                        onclick="copyToClipboard('{{ $user->email }}', this)"
                                        title="Salin Email">
                                        <i class="bi bi-clipboard fs-6"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                @if(strtolower($roleName) == 'admin')
                                <span class="badge badge-role-admin px-3 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-shield-lock-fill"></i> Admin
                                </span>
                                @else
                                <span class="badge badge-role-kasir px-3 py-1.5 rounded-pill d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-person-badge"></i> {{ ucfirst($roleName) }}
                                </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-soft-emerald px-2.5 py-1 rounded-pill d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-circle-fill" style="font-size: 0.4rem;"></i> Aktif
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-action-icon btn-edit-soft" title="Edit Akun">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    @if(auth()->id() === $user->id)
                                        <button type="button"
                                            class="btn-action-icon btn-delete-soft"
                                            style="opacity: 0.4; cursor: not-allowed;"
                                            title="Tidak bisa menghapus akun yang sedang digunakan"
                                            disabled
                                            data-bs-toggle="tooltip">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    @else
                                        <button type="button"
                                            class="btn-action-icon btn-delete-soft"
                                            title="Hapus User"
                                            onclick="triggerDeletePopup('{{ $user->id }}', '{{ $user->name }}')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                        {{-- Form Hapus untuk SweetAlert --}}
                                        <form id="deleteForm-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5" style="color: var(--text-muted);">
                                <i class="bi bi-people fs-1 d-block mb-2 text-muted"></i>
                                <span>Tidak ada data user yang ditemukan.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION FOOTER --}}
        @if(method_exists($users, 'hasPages') && $users->hasPages())
        <div class="card-footer bg-transparent border-0 px-4 py-3 border-top" style="border-color: var(--card-border) !important;">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <span class="small" style="color: var(--text-muted);">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} user
                </span>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        @endif

    </div>

</div>

{{-- SCRIPT SWEETALERT2 POP-UP KONFIRMASI HAPUS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function triggerDeletePopup(userId, userName) {
        Swal.fire({
            title: 'Hapus User?',
            text: `Apakah Anda yakin ingin menghapus "${userName}"? Data ini tidak bisa dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4',
                confirmButton: 'rounded-pill px-4',
                cancelButton: 'rounded-pill px-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`deleteForm-${userId}`).submit();
            }
        });
    }

    function copyToClipboard(text, btnElement) {
        navigator.clipboard.writeText(text).then(() => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'success',
                title: 'Email berhasil disalin'
            });

            const icon = btnElement.querySelector('i');
            icon.className = 'bi bi-check2 text-success fs-6';
            setTimeout(() => {
                icon.className = 'bi bi-clipboard fs-6';
            }, 1500);
        });
    }
</script>

@endsection