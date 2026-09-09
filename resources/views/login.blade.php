<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POINT OF SALE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --purple-deep: #2e1065;
            --purple-main: #6d28d9;
            --purple-light: #8b5cf6;
            --purple-glow: rgba(109, 40, 217, 0.25);
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --font-heading: 'Outfit', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: 
                linear-gradient(135deg, rgba(15, 7, 32, 0.75) 0%, rgba(46, 16, 101, 0.7) 100%),
                url("{{ asset('img/ciwi.png') }}") no-repeat center center / cover,
                #1e1b4b;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-body);
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        .login-container {
            width: 100%;
            max-width: 980px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.5), 
                        0 0 40px rgba(109, 40, 217, 0.25);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            overflow: hidden;
            width: 100%;
            display: flex;
            flex-direction: row;
        }

        /* Panel Sisi Kiri (Branding POS) */
        .login-branding {
            background: linear-gradient(145deg, rgba(23, 8, 56, 0.96) 0%, rgba(91, 33, 182, 0.9) 100%);
            padding: 3.5rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
            color: white;
            flex: 1;
            min-width: 380px;
            position: relative;
        }

        .branding-header {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .branding-icon-wrapper {
            width: 64px;
            height: 64px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #c084fc;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .branding-badge {
            background: rgba(139, 92, 246, 0.2);
            border: 1px solid rgba(192, 132, 252, 0.4);
            padding: 0.4rem 1.1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-family: var(--font-heading);
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #e9d5ff;
        }

        .branding-title {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 0.75rem;
            letter-spacing: 1.5px;
            line-height: 1.1;
            color: #ffffff;
            text-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .branding-title span {
            color: #c084fc;
        }

        .branding-subtitle {
            font-family: var(--font-body);
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            line-height: 1.6;
            font-weight: 400;
            max-width: 300px;
        }

        /* Highlights Grid */
        .branding-highlights {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.85rem;
            width: 100%;
            margin-bottom: 1.5rem;
        }

        .highlight-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 18px;
            padding: 0.9rem 0.75rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .highlight-card:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .highlight-icon {
            font-size: 1.4rem;
            color: #c084fc;
            margin-bottom: 0.3rem;
        }

        .highlight-title {
            font-family: var(--font-heading);
            font-size: 0.85rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.15rem;
        }

        .highlight-desc {
            font-size: 0.725rem;
            color: rgba(255, 255, 255, 0.65);
            font-weight: 400;
        }

        .branding-footer-text {
            font-size: 0.775rem;
            color: rgba(255, 255, 255, 0.6);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 500;
        }

        /* Panel Sisi Kanan (Form Login) */
        .login-form-section {
            padding: 3.5rem 3.25rem;
            flex: 1.2;
            min-width: 360px;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.35rem;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.925rem;
            margin: 0;
            font-weight: 500;
        }

        .form-label {
            font-family: var(--font-heading);
            font-weight: 700;
            color: #334155;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            border-radius: 14px;
            padding: 0.9rem 1rem 0.9rem 3.2rem;
            border: 1.8px solid #e2e8f0;
            font-size: 0.95rem;
            font-family: var(--font-body);
            transition: all 0.25s ease;
            background: #f8fafc;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-control:focus {
            border-color: var(--purple-main);
            box-shadow: 0 0 0 4px var(--purple-glow);
            background: #ffffff;
        }

        .input-icon {
            position: absolute;
            left: 1.15rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.2rem;
            transition: color 0.25s ease;
            pointer-events: none;
        }

        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--purple-main);
        }

        .password-toggle {
            position: absolute;
            right: 1.15rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0;
            font-size: 1.15rem;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--purple-main);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .remember-me input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
            accent-color: var(--purple-main);
            border-radius: 4px;
            cursor: pointer;
        }

        .remember-me label {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
            cursor: pointer;
        }

        .forgot-password-link {
            font-size: 0.875rem;
            color: var(--purple-main);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s ease;
        }

        .forgot-password-link:hover {
            color: var(--purple-deep);
            text-decoration: underline;
        }

        /* Tombol Utama */
        .btn-gradient-login {
            background: linear-gradient(135deg, var(--purple-deep) 0%, var(--purple-main) 100%);
            border: none;
            color: white;
            padding: 0.95rem;
            border-radius: 14px;
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.25s ease;
            box-shadow: 0 6px 20px -4px rgba(109, 40, 217, 0.4);
        }

        .btn-gradient-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -5px rgba(109, 40, 217, 0.55);
            color: white;
        }

        .btn-gradient-login:active {
            transform: translateY(0);
        }

        .error-badge {
            font-size: 0.8rem;
            border-radius: 8px;
            padding: 0.4rem 0.75rem;
            margin-top: 0.45rem;
            display: inline-block;
            font-weight: 600;
        }

        .caps-lock-warning {
            display: none;
            background: #fffbeb;
            border: 1px solid #fef3c7;
            color: #b45309;
            padding: 0.5rem 0.8rem;
            border-radius: 10px;
            font-size: 0.825rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .loading-spinner {
            display: none;
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-gradient-login.loading .loading-spinner {
            display: inline-block;
        }

        .btn-gradient-login.loading span,
        .btn-gradient-login.loading i {
            display: none;
        }

        @media (max-width: 768px) {
            .login-container { max-width: 450px; }
            .login-card { flex-direction: column; }
            .login-branding { display: none; }
            .login-form-section { padding: 2.5rem 1.75rem; }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card login-card">
        
        <!-- Panel Sisi Kiri (Branding POS) -->
        <div class="login-branding">
            <div class="branding-header">
                <div class="branding-icon-wrapper">
                    <i class="bi bi-shop"></i>
                </div>
                <div class="branding-badge">
                    <i class="bi bi-cpu-fill"></i> Smart Cashier POS
                </div>
                <h1 class="branding-title">POINT <span>OF SALE</span></h1>
                <p class="branding-subtitle">Kelola transaksi, stok barang, dan laporan penjualan bisnis Anda secara otomatis & akurat.</p>
            </div>
            
            <!-- Grid Fitur Kasir -->
            <div class="branding-highlights">
                <div class="highlight-card">
                    <i class="bi bi-lightning-charge-fill highlight-icon"></i>
                    <div class="highlight-title">Transaksi Cepat</div>
                    <div class="highlight-desc">Proses kasir hitungan detik</div>
                </div>

                <div class="highlight-card">
                    <i class="bi bi-qr-code-scan highlight-icon"></i>
                    <div class="highlight-title">Scan Barcode</div>
                    <div class="highlight-desc">Dukungan hardware lengkap</div>
                </div>

                <div class="highlight-card">
                    <i class="bi bi-graph-up-arrow highlight-icon"></i>
                    <div class="highlight-title">Laporan Akurat</div>
                    <div class="highlight-desc">Pantau omzet real-time</div>
                </div>

                <div class="highlight-card">
                    <i class="bi bi-shield-check highlight-icon"></i>
                    <div class="highlight-title">Aman &amp; Stabil</div>
                    <div class="highlight-desc">Proteksi data terjamin</div>
                </div>
            </div>

            <div class="branding-footer-text">
                <i class="bi bi-check-circle-fill text-success"></i> Sistem Siap Digunakan
            </div>
        </div>

        <!-- Panel Sisi Kanan (Form Login) -->
        <div class="login-form-section">
            <div class="login-header">
                <h2>Selamat Datang</h2>
                <p>Masuk ke akun kasir Anda untuk memulai transaksi</p>
            </div>

            <form action="{{ route('auth') }}" method="POST" id="loginForm">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email Kasir / Pengguna</label>
                    <div class="input-wrapper">
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               placeholder="kasir@email.com" 
                               required 
                               autofocus>
                        <i class="bi bi-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <div class="badge bg-danger-subtle text-danger border border-danger-subtle error-badge">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-wrapper">
                        <input type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               placeholder="••••••••" 
                               required
                               style="padding-right: 3.2rem;">
                        <i class="bi bi-lock input-icon"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Lihat Kata Sandi">
                            <i class="bi bi-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                    
                    <div class="caps-lock-warning" id="capsLockWarning">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <strong>Caps Lock Aktif!</strong> Perhatikan penggunaan huruf kapital.
                    </div>
                    
                    @error('password')
                        <div class="badge bg-danger-subtle text-danger border border-danger-subtle error-badge">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Ingat Saya</label>
                    </div>
                    <a href="#" class="forgot-password-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                        Lupa Sandi?
                    </a>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-gradient-login d-flex align-items-center justify-content-center gap-2" id="loginButton">
                        <span>Buka Sesi Kasir</span>
                        <div class="loading-spinner"></div>
                        <i class="bi bi-arrow-right-circle-fill fs-5"></i>
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted mb-0" style="font-size: 0.9rem; font-weight: 500;">
                    Belum punya akun? 
                    <a href="#" class="fw-bold" style="color: var(--purple-main); text-decoration: none;" data-bs-toggle="modal" data-bs-target="#registerModal">Buat Akun Baru</a>
                </p>
            </div>
        </div>

    </div>
</div>

<!-- Modal Lupa Sandi -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header border-0 text-white p-4" style="background: linear-gradient(135deg, #2e1065 0%, #6d28d9 100%);">
                <h5 class="modal-title fw-bold" id="forgotPasswordModalLabel" style="font-family: var(--font-heading);">
                    <i class="bi bi-key-fill me-2"></i>Lupa Kata Sandi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Masukkan email akun Anda untuk menerima tautan pemulihan kata sandi.</p>
                    
                    <div class="mb-3">
                        <label for="reset_email" class="form-label">Alamat Email</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" id="reset_email" class="form-control" placeholder="nama@email.com" required>
                            <i class="bi bi-envelope input-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 fw-semibold px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-login text-white rounded-3 fw-semibold px-4">Kirim Tautan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pendaftaran -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header border-0 text-white p-4" style="background: linear-gradient(135deg, #2e1065 0%, #6d28d9 100%);">
                <h5 class="modal-title fw-bold" id="registerModalLabel" style="font-family: var(--font-heading);">
                    <i class="bi bi-person-plus-fill me-2"></i>Daftar Akun Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="reg_name" class="form-label">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <input type="text" name="name" id="reg_name" class="form-control" placeholder="Nama Lengkap" required>
                            <i class="bi bi-person input-icon"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reg_email" class="form-label">Alamat Email</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" id="reg_email" class="form-control" placeholder="nama@email.com" required>
                            <i class="bi bi-envelope input-icon"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reg_password" class="form-label">Kata Sandi</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" id="reg_password" class="form-control" placeholder="••••••••" required>
                            <i class="bi bi-lock input-icon"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reg_password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="input-wrapper">
                            <input type="password" name="password_confirmation" id="reg_password_confirmation" class="form-control" placeholder="••••••••" required>
                            <i class="bi bi-shield-lock input-icon"></i>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 fw-semibold px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-login text-white rounded-3 fw-semibold px-4">Daftar Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('passwordToggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }

    const passwordInput = document.getElementById('password');
    const capsLockWarning = document.getElementById('capsLockWarning');

    function checkCapsLock(e) {
        if (e.getModifierState && e.getModifierState('CapsLock')) {
            capsLockWarning.style.display = 'block';
        } else {
            capsLockWarning.style.display = 'none';
        }
    }

    passwordInput.addEventListener('keydown', checkCapsLock);
    passwordInput.addEventListener('keyup', checkCapsLock);

    document.getElementById('loginForm').addEventListener('submit', function() {
        const button = document.getElementById('loginButton');
        button.classList.add('loading');
    });

    @if(session('demo_link'))
        Swal.fire({
            html: `
                <div class="p-2 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px; background: #f3e8ff; color: #6d28d9;">
                        <i class="bi bi-envelope-check-fill fs-2"></i>
                    </div>
                    <h4 class="fw-bold mb-2" style="color: #2e1065; font-family: var(--font-heading);">Instruksi Terkirim</h4>
                    <p class="text-muted small mb-4">
                        {{ session('status') ?? 'Kami telah menyiapkan tautan pemulihan kata sandi untuk akun Anda.' }}
                    </p>
                    
                    <div class="p-3 text-start rounded-3 mb-4" style="background-color: #faf5ff; border: 1px dashed #c084fc;">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-info-circle-fill" style="color: #6d28d9;"></i>
                            <span class="fw-semibold text-dark small">Sistem Lingkungan Pengembang</span>
                        </div>
                        <p class="text-secondary mb-0" style="font-size: 0.8rem; line-height: 1.4;">
                            Pengiriman email nyata dinonaktifkan. Silakan pergunakan tombol di bawah untuk menyimulasikan pembukaan tautan dari email.
                        </p>
                    </div>

                    <a href="{{ session('demo_link') }}" class="btn text-white w-100 fw-semibold py-2 d-flex align-items-center justify-content-center gap-2 shadow-sm" style="background: linear-gradient(135deg, #2e1065 0%, #6d28d9 100%); border-radius: 12px; font-family: var(--font-heading);">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Lanjutkan Reset Kata Sandi</span>
                    </a>
                </div>
            `,
            showConfirmButton: false,
            showCloseButton: true,
            padding: '1.5rem',
            customClass: { popup: 'rounded-4 border-0 shadow-lg' }
        });
    @elseif(session('status'))
        Swal.fire({
            icon: 'info',
            iconColor: '#6d28d9',
            title: 'Informasi',
            text: "{{ session('status') }}",
            confirmButtonColor: '#6d28d9',
            customClass: { popup: 'rounded-4' }
        });
    @endif

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false,
            confirmButtonColor: '#6d28d9',
            customClass: { popup: 'rounded-4' }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            confirmButtonColor: '#6d28d9',
            customClass: { popup: 'rounded-4' }
        });
    @endif
</script>

</body>
</html>