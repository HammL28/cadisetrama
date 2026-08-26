<style>
    :root {
        --purple-main: #7c3aed;
        --purple-light: #a855f7;
        --pink-accent: #e879f9;
    }

    /* NAVBAR BASE ELEGAN */
    .navbar-custom {
        background: linear-gradient(135deg, var(--purple-main) 0%, var(--purple-light) 50%, var(--pink-accent) 100%) !important;
        box-shadow: 0 8px 32px 0 rgba(124, 58, 237, 0.25);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    /* BRAND LOGO PREMIUM */
    .navbar-brand-logo {
        background: rgba(255, 255, 255, 0.15);
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        padding: 4px;
    }

    .navbar-brand:hover .navbar-brand-logo {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
    }

    .brand-title {
        font-weight: 800; /* Bold Tebal */
        letter-spacing: 0.5px;
        font-size: 1.25rem;
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    /* MENU ITEM ELEGAN */
    .nav-link-custom {
        color: rgba(255, 255, 255, 0.8) !important;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.6rem 1.1rem !important;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        gap: 0.55rem;
        letter-spacing: 0.2px;
    }

    .nav-link-custom i {
        font-size: 1rem;
        opacity: 0.9;
        transition: transform 0.3s ease;
    }

    .nav-link-custom:hover {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.15);
        letter-spacing: 0.4px;
    }

    .nav-link-custom:hover i {
        transform: scale(1.15);
    }

    /* STATE AKTIF KACA (GLASSMORPHISM) */
    .nav-link-custom.active {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(8px);
        font-weight: 600;
        box-shadow: inset 0 1px 1px rgba(255, 255, 255, 0.4), 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    /* CARD PROFIL USER & LINK PROFIL */
    .user-profile-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 50px;
        padding: 0.3rem 0.4rem 0.3rem 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .profile-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none !important;
        color: inherit;
        border-radius: 50px;
        padding: 0.2rem 0.4rem;
        transition: all 0.2s ease;
    }

    .profile-link:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    .user-avatar-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 0.9rem;
        overflow: hidden;
    }

    /* TOMBOL LOGOUT RED GLOW */
    .btn-logout-custom {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.25);
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        padding: 0;
    }

    .btn-logout-custom:hover {
        background: #ef4444 !important;
        border-color: #ef4444 !important;
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
        transform: rotate(90deg);
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top py-2.5">
    <div class="container-fluid px-4">
        
        {{-- BRAND / LOGO --}}
        <a class="navbar-brand d-flex align-items-center gap-3 me-4" href="{{ route('dashboard') }}">
            <div class="navbar-brand-logo">
                <img src="{{ asset('img/smk4logo.png') }}" alt="SMKN 4 Logo" style="width: 100%; height: 100%; object-fit: contain;">
            </div>
            <div class="d-flex flex-column">
                <span class="brand-title fw-bold">POS ILHAM</span>
            </div>
        </a>

        {{-- TOGGLER MOBILE --}}
        <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- NAV CONTENT --}}
        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarSupportedContent">
            
            {{-- MENU UTAMA --}}
            <ul class="navbar-nav me-auto mb-3 mb-lg-0 gap-2">
                <li class="nav-item">
                    <a class="nav-link-custom {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                {{-- KHUSUS ADMIN --}}
                @php
                    $userRole = Auth::user()->role->name ?? Auth::user()->role->NAME ?? (is_string(Auth::user()->role) ? Auth::user()->role : '');
                @endphp

                @if(Auth::check() && strtolower($userRole) === 'admin')
                <li class="nav-item">
                    <a class="nav-link-custom {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Users</span>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link-custom {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                        <i class="bi bi-box-seam-fill"></i>
                        <span>Produk</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link-custom {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
                        <i class="bi bi-cart-check-fill"></i>
                        <span>Penjualan</span>
                    </a>
                </li>
            </ul>

            {{-- PROFIL SINGKAT + LOGOUT --}}
            <div class="d-flex align-items-center justify-content-between justify-content-lg-end gap-3 pt-3 pt-lg-0 border-top border-lg-0 border-white-25">
                
                @auth
                <div class="user-profile-card">
                    
                    {{-- LINK KE HALAMAN PROFIL / DATA DIRI --}}
                    <a href="{{ route('profile.index') }}" class="profile-link" title="Lihat / Edit Profil">
                        <div class="d-flex flex-column text-end leading-tight">
                            <span class="fw-semibold text-white" style="font-size: 0.85rem;">{{ Auth::user()->name ?? 'Kasir' }}</span>
                            <span class="text-white-50 text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                {{ Auth::user()->role->name ?? Auth::user()->role->NAME ?? (is_string(Auth::user()->role) ? Auth::user()->role : 'Staff') }}
                            </span>
                        </div>
                        <div class="user-avatar-icon">
                            @if(Auth::user()->photo && Storage::disk('public')->exists(Auth::user()->photo))
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User Photo" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="bi bi-person-fill"></i>
                            @endif
                        </div>
                    </a>
                    
                    {{-- TOMBOL LOGOUT --}}
                    <form action="{{ route('logout') }}" method="POST" class="m-0 ms-1">
                        @csrf
                        <button type="submit" class="btn btn-logout-custom" title="Keluar / Logout">
                            <i class="bi bi-power fs-6"></i>
                        </button>
                    </form>

                </div>
                @endauth

            </div>

        </div>
    </div>
</nav>