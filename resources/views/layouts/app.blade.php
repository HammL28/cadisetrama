<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    
@include('layouts.sidebar')

<div class="main-content-with-sidebar">
    <div class="container py-4">
        @yield('content')
    </div>
</div>

{{-- SCRIPT SWEETALERT2 DARI CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- POP-UP AUTOMATIS GLOBAL (SUCCESS) --}}
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-4'
            }
        });
    </script>
@endif

{{-- POP-UP AUTOMATIS GLOBAL (ERROR) --}}
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#7c3aed',
            customClass: {
                popup: 'rounded-4'
            }
        });
    </script>
@endif

{{-- NOTIFICATION TOAST CONTAINER --}}
<div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;"></div>

{{-- NOTIFICATION POLLING --}}
@auth
    @if(Auth::check() && Auth::user()->role && (Auth::user()->role->name === 'admin' || Auth::user()->role->NAME === 'ADMIN'))
    <script>
        // Poll untuk cek notifikasi baru setiap 30 detik
        let lastNotificationCount = {{ Auth::user()->unreadNotifications->count() }};

        setInterval(function() {
            fetch('/api/unread-count')
                .then(response => response.json())
                .then(data => {
                    if (data.count > lastNotificationCount) {
                        // Ada notifikasi baru
                        showNotificationToast(data.notification);
                        lastNotificationCount = data.count;
                        
                        // Update badge di sidebar
                        const badge = document.querySelector('.sidebar-menu-link[href*="notifications"] .badge');
                        if (badge) {
                            badge.textContent = data.count;
                        }
                    }
                })
                .catch(error => console.log('Error checking notifications:', error));
        }, 30000); // Cek setiap 30 detik

        function showNotificationToast(notification) {
            const container = document.getElementById('notification-container');
            
            const toast = document.createElement('div');
            toast.style.cssText = `
                background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
                color: white;
                padding: 16px 20px;
                border-radius: 12px;
                margin-bottom: 10px;
                box-shadow: 0 4px 20px rgba(124, 58, 237, 0.4);
                cursor: pointer;
                animation: slideIn 0.3s ease;
                display: flex;
                align-items: center;
                gap: 12px;
            `;
            
            let icon = 'bi-bell-fill';
            if (notification.type === 'App\\Notifications\\SaleNotification') {
                icon = 'bi-cart-check-fill';
            } else if (notification.type === 'App\\Notifications\\StockNotification') {
                icon = 'bi-box-seam-fill';
            }
            
            toast.innerHTML = `
                <i class="bi ${icon}" style="font-size: 1.5rem;"></i>
                <div style="flex: 1;">
                    <div style="font-weight: 600; margin-bottom: 4px;">Notifikasi Baru</div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">${notification.data.message || 'Anda memiliki notifikasi baru'}</div>
                </div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; font-size: 1.2rem; cursor: pointer;">&times;</button>
            `;
            
            toast.onclick = function() {
                window.location.href = '/notifications';
            };
            
            container.appendChild(toast);
            
            // Auto remove setelah 5 detik
            setTimeout(function() {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(function() {
                    toast.remove();
                }, 300);
            }, 5000);
        }

        // Tambahkan CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
    @endif
@endauth

</body>
</html>
