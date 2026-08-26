@extends('layouts.app')

@section('title', __('manage_categories_title') . ' - POS ILHAM')

@section('content')

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    .dashboard-header-banner {
        background: var(--primary-gradient) !important;
        border-radius: var(--radius-lg);
        padding: 2.5rem 2.25rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(124, 58, 237, 0.15);
        position: relative;
        overflow: hidden;
    }

    .custom-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius-lg);
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.08);
    }

    .table thead th {
        background-color: var(--table-head-bg);
        color: var(--text-heading);
        font-weight: 600;
        border-bottom: 2px solid #e9d5ff;
    }

    .table tbody tr:hover {
        background-color: var(--table-hover-bg);
    }

    .btn-primary-custom {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: var(--radius-md);
        padding: 0.6rem 1.5rem;
        transition: var(--transition);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
        color: white;
    }

    .btn-action {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .btn-edit {
        background: #f3e8ff;
        color: #7c3aed;
        border: 1px solid #ddd6fe;
    }

    .btn-edit:hover {
        background: #7c3aed;
        color: white;
        border-color: #7c3aed;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }

    .search-box {
        border: 2px solid #e9d5ff;
        border-radius: var(--radius-md);
        padding: 0.2rem 0.5rem;
        transition: var(--transition);
    }

    .search-box:focus-within {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .swal2-popup {
        border-radius: 20px !important;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    {{-- HEADER BANNER --}}
    <div class="dashboard-header-banner position-relative">
        <div class="position-relative" style="z-index: 1;">
            <h2 class="fw-bold text-white mb-2 d-flex align-items-center gap-2">
                <i class="bi bi-tags-fill fs-2"></i> {{ __('Kategori / Jenis Produk') }}
            </h2>
            <p class="text-white opacity-75 mb-0">{{ __('Kelola kategori produk untuk mempermudah pengelompokan barang.') }}</p>
        </div>
        <div class="position-absolute end-0 bottom-0 opacity-15 pe-4 pb-2 d-none d-md-block">
            <i class="bi bi-tags text-white" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="custom-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            {{-- Search Box --}}
            <form action="{{ route('jenis.index') }}" method="GET" class="flex-grow-1" style="max-width: 400px;">
                <div class="input-group search-box">
                    <span class="input-group-text bg-transparent border-0 text-muted">
                        <i class="bi bi-search" style="color: #7c3aed;"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-0 shadow-none"
                           placeholder="{{ __('Cari Kategori...') }}" value="{{ request('search') }}">
                    @if(request('search'))
                        <a href="{{ route('jenis.index') }}" class="btn btn-link text-muted pe-2 border-0 shadow-none align-self-center">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    @endif
                </div>
            </form>

            {{-- Tombol Tambah --}}
            @can('create', App\Models\Jenis::class)
            <a href="{{ route('jenis.create') }}" class="btn btn-primary-custom d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span>{{ __('Tambah Kategori') }}</span>
            </a>
            @endcan
        </div>

        {{-- Tabel Data --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 10%;" class="ps-3">No</th>
                        <th style="width: 60%;">Kategori / Jenis</th>
                        <th style="width: 30%;" class="pe-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenis as $item)
                    <tr>
                        <td class="fw-semibold ps-3 text-muted">
                            {{ method_exists($jenis, 'firstItem') ? $jenis->firstItem() + $loop->index : $loop->iteration }}
                        </td>
                        <td class="fw-bold" style="color: var(--text-heading);">
                            <span class="badge bg-purple-subtle text-purple border px-3 py-2 rounded-pill fw-semibold" style="background-color: #f3e8ff; color: #7e22ce; border-color: #e9d5ff !important;">
                                <i class="bi bi-tag-fill me-1"></i>{{ $item->nama }}
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                @can('update', $item)
                                <a href="{{ route('jenis.edit', $item) }}" class="btn btn-action btn-edit d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-pencil-fill"></i>
                                    <span>{{ __('Edit') }}</span>
                                </a>
                                @endcan

                                @can('delete', $item)
                                <button type="button" 
                                        class="btn btn-action btn-delete d-inline-flex align-items-center gap-1"
                                        onclick="triggerDeleteModal('{{ route('jenis.destroy', $item) }}', '{{ $item->nama }}')">
                                    <i class="bi bi-trash-fill"></i>
                                    <span>{{ __('Hapus') }}</span>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2" style="color: var(--icon-color);"></i>
                                <p class="mb-0 fw-medium">{{ __('Tidak ada data kategori ditemukan.') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($jenis, 'hasPages') && $jenis->hasPages())
        <div class="d-flex justify-content-center mt-4 pt-2 border-top">
            {{ $jenis->links() }}
        </div>
        @endif
    </div>

</div>

{{-- Form Hapus Global --}}
<form id="globalDeleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    // Konfirmasi Hapus SweetAlert2
    function triggerDeleteModal(deleteUrl, categoryName) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: `Apakah Anda yakin ingin menghapus kategori "${categoryName}"? Data yang terhubung mungkin akan terpengaruh.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
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
        // Flash Message Notifikasi Sukses / Gagal
        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#7c3aed',
                confirmButtonText: 'Tutup'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#7c3aed',
                confirmButtonText: 'Tutup',
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    });
</script>
@endsection