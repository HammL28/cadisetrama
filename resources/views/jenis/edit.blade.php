@extends('layouts.app')

@section('title', __('edit_category') . ' - POS ILHAM')

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
    }

    .custom-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius-lg);
        box-shadow: 0 4px 20px rgba(124, 58, 237, 0.08);
    }

    .form-control {
        border: 2px solid #e9d5ff;
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        transition: var(--transition);
    }

    .form-control:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .form-label {
        color: var(--text-heading);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .btn-primary-custom {
        background: var(--primary-gradient);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: var(--radius-md);
        padding: 0.75rem 2rem;
        transition: var(--transition);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
        color: white;
    }

    .btn-secondary-custom {
        background: #f3e8ff;
        border: 1px solid #ddd6fe;
        color: #7c3aed;
        font-weight: 600;
        border-radius: var(--radius-md);
        padding: 0.75rem 2rem;
        transition: var(--transition);
    }

    .btn-secondary-custom:hover {
        background: #7c3aed;
        color: white;
        border-color: #7c3aed;
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    {{-- HEADER BANNER --}}
    <div class="dashboard-header-banner position-relative overflow-hidden">
        <div class="position-relative" style="z-index: 1;">
            <h2 class="fw-bold text-white mb-2 d-flex align-items-center gap-2">
                <i class="bi bi-pencil-square fs-2"></i> {{ __('Edit Kategori / Jenis') }}
            </h2>
            <p class="text-white opacity-75 mb-0">{{ __('Ubah nama kategori barang sesuai kebutuhan kamu.') }}</p>
        </div>
        <div class="position-absolute end-0 bottom-0 opacity-15 pe-4 pb-2 d-none d-md-block">
            <i class="bi bi-tag text-white" style="font-size: 6rem;"></i>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="custom-card p-4 p-md-5">
                {{-- CATATAN: Variabel $jeni di-pass dari JenisController (Route Model Binding) --}}
                <form action="{{ route('jenis.update', $jeni ?? $jenis) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="nama" class="form-label">{{ __('Nama Kategori / Jenis') }} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-color: #e9d5ff; border-radius: var(--radius-md) 0 0 var(--radius-md);">
                                <i class="bi bi-tag-fill" style="color: #7c3aed;"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 @error('nama') is-invalid @enderror"
                                   id="nama" name="nama" value="{{ old('nama', $jeni->nama ?? $jenis->nama) }}"
                                   placeholder="{{ __('Masukkan nama kategori (ex: Makanan, Snack)...') }}" 
                                   style="border-radius: 0 var(--radius-md) var(--radius-md) 0;" required>
                        </div>
                        @error('nama')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3 justify-content-end pt-3 border-top">
                        <a href="{{ route('jenis.index') }}" class="btn btn-secondary-custom d-inline-flex align-items-center gap-2">
                            <i class="bi bi-arrow-left"></i>
                            <span>{{ __('Batal') }}</span>
                        </a>
                        <button type="submit" class="btn btn-primary-custom d-inline-flex align-items-center gap-2">
                            <i class="bi bi-check-lg"></i>
                            <span>{{ __('Simpan Perubahan') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection