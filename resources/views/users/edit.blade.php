@extends('layouts.app')

@section('title', 'Edit User - POS ILHAM')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 50%, #f3e8ff 100%) !important;
    }

    .banner-purple-gradient {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 25%, #a855f7 50%, #c084fc 75%, #e879f9 100%) !important;
        color: #ffffff !important;
    }

    .card {
        border: 1px solid rgba(139, 92, 246, 0.2) !important;
        box-shadow: 0 4px 16px rgba(139, 92, 246, 0.1);
    }
</style>

<div class="container py-4" style="padding-top: 5rem;">

    {{-- HEADER BANNER --}}
    <div class="banner-purple-gradient p-4 rounded-4 mb-4 shadow-sm">
        <h2 class="fw-bold mb-1 text-white d-flex align-items-center gap-2">
            <i class="bi bi-person-gear fs-2"></i> Edit Data User
        </h2>
        <p class="text-white opacity-75 small mb-0">Perbarui informasi pengguna, email, hak akses role, atau ganti password.</p>
    </div>

    {{-- FORM CARD --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('users._form')
            </form>
        </div>
    </div>

</div>

@endsection