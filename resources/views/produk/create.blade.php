@extends('layouts.app')

@section('title', 'Tambah Produk - POS ILHAM')

@section('content')

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #5b21b6 0%, #7c3aed 50%, #9333ea 100%);
        --card-border: #e9d5ff;
        --text-heading: #2e1065;
        --text-body: #4c1d95;
        --radius-lg: 20px;
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

    .card-custom {
        border-radius: var(--radius-lg);
        border: 1px solid var(--card-border) !important;
        background: #ffffff !important;
        box-shadow: 0 4px 12px rgba(109, 40, 217, 0.04);
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    {{-- HEADER BANNER --}}
    <div class="dashboard-header-banner mb-4">
        <div class="position-relative" style="z-index: 1;">
            <h2 class="fw-bold mb-1 text-white d-flex align-items-center gap-2 fs-2">
                <i class="bi bi-box-seam-fill"></i> Tambah Produk Baru
            </h2>
            <p class="text-white-50 mb-0 fs-6">Isi formulir di bawah ini untuk menambahkan barang baru ke inventaris toko.</p>
        </div>
    </div>

    {{-- FORM CARD --}}
    <div class="card card-custom border-0 shadow-sm overflow-hidden mb-4">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('produk.store') }}" 
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @include('produk._form')
            </form>
        </div>
    </div>

</div>

@endsection