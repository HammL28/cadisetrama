<style>
    :root {
        --purple-deep: #6366f1;
        --purple-main: #8b5cf6;
        --purple-light: #a855f7;
        --purple-bright: #c084fc;
        --pink-accent: #e879f9;
        --purple-dark: #4f46e5;
        --sidebar-width: 260px;
        --sidebar-collapsed-width: 70px;
    }

    /* SIDEBAR CONTAINER */
    .sidebar-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: linear-gradient(135deg, var(--purple-dark) 0%, var(--purple-deep) 25%, var(--purple-main) 50%, var(--purple-light) 75%, var(--pink-accent) 100%);
        box-shadow: 4px 0 32px rgba(139, 92, 246, 0.4);
        z-index: 1000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow-y: auto;
        overflow-x: hidden;
    }

    .sidebar-wrapper.collapsed {
        width: var(--sidebar-collapsed-width);
    }

    /* SIDEBAR HEADER */
    .sidebar-header {
        padding: 1.5rem 1.25rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        gap: 1rem;
        min-height: 80px;
    }

    .sidebar-brand-logo {
        background: rgba(255, 255, 255, 0.2);
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .sidebar-brand-logo:hover {
        transform: scale(1.05);
        background: rgba(255, 255, 255, 0.25);
    }

    .sidebar-brand-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .sidebar-brand-text {
        font-weight: 800;
        font-size: 1.1rem;
        color: #ffffff;
        letter-spacing: 0.5px;
        white-space: nowrap;
        transition: opacity 0.3s ease;
    }

    .sidebar-wrapper.collapsed .sidebar-brand-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }

    /* SIDEBAR MENU */
    .sidebar-menu {
        padding: 1.25rem 0.75rem;
        list-style: none;
        margin: 0;
    }

    .sidebar-menu-item {
        margin-bottom: 0.5rem;
    }

    .sidebar-menu-link {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem 1rem;
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .sidebar-menu-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, var(--purple-bright) 0%, var(--pink-accent) 100%);
        border-radius: 0 4px 4px 0;
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .sidebar-menu-link:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        transform: translateX(4px);
        box-shadow: 0 4px 16px rgba(139, 92, 246, 0.3);
    }

    .sidebar-menu-link:hover::before {
        transform: scaleY(1);
    }

    .sidebar-menu-link.active {
        background: linear-gradient(90deg, rgba(139, 92, 246, 0.3) 0%, rgba(168, 85, 247, 0.2) 100%);
        color: #ffffff;
        font-weight: 600;
        box-shadow: 0 4px 16px rgba(139, 92, 246, 0.4);
        border-right: 3px solid var(--purple-bright);
    }

    .sidebar-menu-link.active::before {
        transform: scaleY(1);
    }

    .sidebar-menu-icon {
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }

    .sidebar-menu-link:hover .sidebar-menu-icon {
        transform: scale(1.15);
    }

    .sidebar-menu-text {
        white-space: nowrap;
        transition: opacity 0.3s ease;
    }

    .sidebar-wrapper.collapsed .sidebar-menu-text {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }

    /* SIDEBAR FOOTER - USER PROFILE */
    .sidebar-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem 0.75rem;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        background: rgba(0, 0, 0, 0.1);
    }

    .sidebar-user-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
        transition: all 0.3s ease;
    }

    .sidebar-user-card:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    .sidebar-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1rem;
        flex-shrink: 0;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .sidebar-user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sidebar-user-info {
        flex: 1;
        min-width: 0;
        transition: opacity 0.3s ease;
    }

    .sidebar-wrapper.collapsed .sidebar-user-info {
        opacity: 0;
        width: 0;
        overflow: hidden;
    }

    .sidebar-user-name {
        color: #ffffff;
        font-weight: 600;
        font-size: 0.85rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-user-role {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar-logout-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
        text-decoration: none;
    }

    .sidebar-logout-btn:hover {
        background: #ef4444;
        border-color: #ef4444;
        box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
        transform: rotate(90deg);
    }

    /* TOGGLE BUTTON */
    .sidebar-toggle {
        position: fixed;
        top: 1rem;
        left: calc(var(--sidebar-width) + 1rem);
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--purple-main) 0%, var(--purple-light) 100%);
        border: 1px solid rgba(139, 92, 246, 0.3);
        box-shadow: 0 4px 16px rgba(139, 92, 246, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1001;
        transition: all 0.3s ease;
        color: #ffffff;
    }

    .sidebar-toggle:hover {
        background: linear-gradient(135deg, var(--purple-light) 0%, var(--pink-accent) 100%);
        color: #ffffff;
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(168, 85, 247, 0.5);
    }

    .sidebar-wrapper.collapsed ~ .sidebar-toggle {
        left: calc(var(--sidebar-collapsed-width) + 1rem);
    }

    /* MAIN CONTENT OFFSET */
    .main-content-with-sidebar {
        margin-left: var(--sidebar-width);
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        min-height: 100vh;
    }

    .sidebar-wrapper.collapsed ~ .main-content-with-sidebar {
        margin-left: var(--sidebar-collapsed-width);
    }

    /* MOBILE RESPONSIVE */
    @media (max-width: 991px) {
        .sidebar-wrapper {
            transform: translateX(-100%);
        }

        .sidebar-wrapper.mobile-open {
            transform: translateX(0);
        }

        .sidebar-toggle {
            left: 1rem !important;
        }

        .main-content-with-sidebar {
            margin-left: 0 !important;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }
    }

    /* SCROLLBAR STYLING */
    .sidebar-wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-wrapper::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
    }

    .sidebar-wrapper::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
    }

    .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }
</style>

<!-- SIDEBAR OVERLAY FOR MOBILE -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<div class="sidebar-wrapper" id="sidebar">
    <!-- HEADER -->
    <div class="sidebar-header">
       
        <div class="sidebar-brand-text">POS ILHAM</div>
    </div>

    <!-- MENU -->
    <ul class="sidebar-menu">
        <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{ Request::is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid-1x2-fill sidebar-menu-icon"></i>
                <span class="sidebar-menu-text">{{ __('Dashboard') }}</span>
            </a>
        </li>

        @php
            $userRole = Auth::user()->role->name ?? Auth::user()->role->NAME ?? (is_string(Auth::user()->role) ? Auth::user()->role : '');
        @endphp

        {{-- MENU ADMIN ONLY --}}
        @if(Auth::check() && strtolower($userRole) === 'admin')
        <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                <i class="bi bi-people-fill sidebar-menu-icon"></i>
                <span class="sidebar-menu-text">{{ __('Users') }}</span>
            </a>
        </li>
        @endif

        {{-- MENU PRODUK (Admin & Kasir) --}}
        <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">
                <i class="bi bi-box-seam-fill sidebar-menu-icon"></i>
                <span class="sidebar-menu-text">{{ __('Products') }}</span>
            </a>
        </li>

        {{-- MENU JENIS (Admin & Kasir) --}}
        <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{ Request::is('jenis*') ? 'active' : '' }}" href="{{ route('jenis.index') }}">
                <i class="bi bi-tags-fill sidebar-menu-icon"></i>
                <span class="sidebar-menu-text">{{ __('Jenis') }}</span>
            </a>
        </li>

        {{-- MENU PENJUALAN (Admin & Kasir) --}}
        <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">
                <i class="bi bi-cart-check-fill sidebar-menu-icon"></i>
                <span class="sidebar-menu-text">{{ __('Penjualan') }}</span>
            </a>
        </li>

        {{-- MENU AKUN --}}
        <li class="sidebar-menu-item mt-3">
            <div class="sidebar-menu-text px-3 mb-2" style="opacity: 0.7; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                {{ __('AKUN') }}
            </div>
        </li>

        <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{ Request::is('profile*') ? 'active' : '' }}" href="{{ route('profile.index') }}">
                <i class="bi bi-person-circle sidebar-menu-icon"></i>
                <span class="sidebar-menu-text">{{ __('Profile') }}</span>
            </a>
        </li>

       

        @if(Auth::check() && Auth::user()->role && (Auth::user()->role->name === 'admin' || Auth::user()->role->NAME === 'ADMIN'))
        <li class="sidebar-menu-item">
            <a class="sidebar-menu-link {{ Request::is('notifications*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                <i class="bi bi-bell-fill sidebar-menu-icon"></i>
                <span class="sidebar-menu-text">{{ __('Notifications') }}</span>
                @if(Auth::user()->unreadNotifications->count() > 0)
                <span class="badge rounded-pill" style="background: #ef4444; color: white; font-size: 0.7rem; margin-left: auto;">
                    {{ Auth::user()->unreadNotifications->count() }}
                </span>
                @endif
            </a>
        </li>
        @endif
    </ul>

    <!-- FOOTER - USER PROFILE -->
    <div class="sidebar-footer">
        @auth
        <div class="sidebar-user-card">
            <a href="{{ route('profile.index') }}" class="sidebar-user-avatar" title="{{ __('view_edit_profile') }}">
                @if(Auth::user()->photo && Storage::disk('public')->exists(Auth::user()->photo))
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="User Photo">
                @else
                    <i class="bi bi-person-fill"></i>
                @endif
            </a>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ Auth::user()->name ?? __('cashier') }}</div>
                <div class="sidebar-user-role">
                    {{ Auth::user()->role->name ?? Auth::user()->role->NAME ?? (is_string(Auth::user()->role) ? Auth::user()->role : __('staff')) }}
                </div>
            </div>
            <a href="{{ route('logout') }}" class="sidebar-logout-btn" title="{{ __('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
        @endauth
    </div>
</div>

<!-- TOGGLE BUTTON -->
<button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
    <i class="bi bi-list"></i>
</button>

<!-- HIDDEN LOGOUT FORM -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Toggle sidebar on desktop
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                // Mobile: show/hide with overlay
                sidebar.classList.toggle('mobile-open');
                sidebarOverlay.classList.toggle('active');
            } else {
                // Desktop: collapse/expand
                sidebar.classList.toggle('collapsed');
            }
        });

        // Close sidebar on mobile when clicking overlay
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
            }
        });
    });
</script>