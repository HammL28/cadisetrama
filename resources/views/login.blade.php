<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS ILHAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --purple-deep: #4c1d95;
            --purple-main: #7c3aed;
            --purple-light: #8b5cf6;
            --purple-bright: #a855f7;
            --purple-glow: #c084fc;
            --pink-accent: #e879f9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            /* Perpaduan warna ungu elegan (Deep Purple -> Royal Purple -> Violet) */
            background: linear-gradient(135deg, #2e1065 0%, #581c87 40%, #7e22ce 70%, #6b21a8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Animated Purple Radial Glow Background */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(168, 85, 247, 0.35) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(124, 58, 237, 0.4) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(217, 70, 239, 0.25) 0%, transparent 50%);
            animation: pulse 15s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(1) rotate(0deg); opacity: 0.7; }
            50% { transform: scale(1.1) rotate(3deg); opacity: 0.9; }
            100% { transform: scale(1) rotate(0deg); opacity: 0.7; }
        }

        /* Floating Purple Shapes */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 50%;
            animation: floatShape 15s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 8%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 65%;
            right: 8%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 70px;
            height: 70px;
            bottom: 15%;
            left: 18%;
            animation-delay: 4s;
        }

        @keyframes floatShape {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(180deg); }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 900px;
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .login-card {
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(15, 3, 38, 0.5);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            overflow: hidden;
            width: 100%;
            display: flex;
            flex-direction: row;
        }

        /* Left Side - Branding */
        .login-branding {
            background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 50%, #a855f7 100%);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            flex: 1;
            min-width: 300px;
        }

        .branding-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            animation: brandFloat 4s ease-in-out infinite;
        }

        @keyframes brandFloat {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-12px) scale(1.03); }
        }

        .branding-icon i {
            font-size: 3.5rem;
        }

        .branding-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .branding-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .branding-features {
            text-align: left;
            width: 100%;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            backdrop-filter: blur(5px);
        }

        .feature-item i {
            font-size: 1.2rem;
            width: 24px;
        }

        .feature-item span {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Right Side - Form */
        .login-form-section {
            padding: 3rem 2.5rem;
            flex: 1;
            min-width: 350px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2e1065;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 2px solid #e2e8f0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #f8fafc;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: var(--purple-main);
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.15);
            background: white;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: color 0.3s ease;
            font-size: 1.1rem;
        }

        .form-control:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--purple-main);
        }

        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .btn-gradient-login {
            background: linear-gradient(135deg, var(--purple-deep) 0%, var(--purple-main) 50%, var(--purple-bright) 100%);
            border: none;
            color: white;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
        }

        .btn-gradient-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.5s ease;
        }

        .btn-gradient-login:hover::before {
            left: 100%;
        }

        .btn-gradient-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.45);
            color: white;
        }

        .btn-gradient-login:active {
            transform: translateY(0);
        }

        .error-badge {
            font-size: 0.8rem;
            border-radius: 10px;
            padding: 0.5rem 0.75rem;
            margin-top: 0.5rem;
            display: inline-block;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
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

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a0aec0;
            cursor: pointer;
            padding: 0;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--purple-main);
        }

        .input-wrapper {
            position: relative;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
            accent-color: var(--purple-main);
            cursor: pointer;
        }

        .remember-me label {
            font-size: 0.9rem;
            color: #64748b;
            cursor: pointer;
            user-select: none;
        }

        .caps-lock-warning {
            display: none;
            background: #fef3c7;
            border: 1px solid #fcd34d;
            color: #92400e;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .attempts-warning {
            display: none;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            animation: shake 0.5s ease-in-out;
        }

        @media (max-width: 768px) {
            .login-container { max-width: 440px; }
            .login-card { flex-direction: column; }
            .login-branding { display: none; }
            .login-form-section { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="floating-shapes">
    <div class="shape"></div>
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<div class="login-container">
    <div class="card login-card">
        
        <div class="login-branding">
            
            <h1 class="branding-title">POINT OF SALE</h1>
            <p class="branding-subtitle">Sistem Point of Sale modern untuk mengelola bisnis Anda dengan mudah dan efisien</p>
            
            <div class="branding-features">
                <div class="feature-item">
                    <i class="bi bi-speedometer2"></i>
                    <span>Transaksi Cepat</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-graph-up"></i>
                    <span>Laporan Real-time</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-shield-check"></i>
                    <span>Keamanan Terjamin</span>
                </div>
                <div class="feature-item">
                    <i class="bi bi-cloud"></i>
                    <span>Akses Dari Mana Saja</span>
                </div>
            </div>
        </div>

        <div class="login-form-section">
            <div class="login-header">
                <h2>Selamat Datang Kembali</h2>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <div class="attempts-warning" id="attemptsWarning">
                <i class="bi bi-shield-exclamation me-2"></i>
                <span id="attemptsText">Terlalu banyak percobaan login gagal. Coba lagi dalam beberapa menit.</span>
            </div>
            
            <form action="{{ route('auth') }}" method="POST" id="loginForm">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               placeholder="nama@email.com" 
                               required 
                               autofocus
                               style="padding-left: 2.8rem;">
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
                               style="padding-left: 2.8rem; padding-right: 2.8rem;">
                        <i class="bi bi-lock input-icon"></i>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                    
                    <div class="caps-lock-warning" id="capsLockWarning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Caps Lock aktif!</strong> Pastikan kata sandi benar.
                    </div>
                    
                    @error('password')
                        <div class="badge bg-danger-subtle text-danger border border-danger-subtle error-badge">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-gradient-login d-flex align-items-center justify-content-center gap-2" id="loginButton">
                        <span>Masuk</span>
                        <div class="loading-spinner"></div>
                        <i class="bi bi-box-arrow-in-right fs-5"></i>
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    Belum punya akun? 
                    <a href="#" class="fw-bold" style="color: var(--purple-main); text-decoration: none;" onclick="showRegisterInfo()">Hubungi Admin</a>
                </p>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Toggle Password Visibility
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

    // Caps Lock Detection
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

    // Form Loading State
    document.getElementById('loginForm').addEventListener('submit', function() {
        const button = document.getElementById('loginButton');
        button.classList.add('loading');
    });

    // Show Register Info
    function showRegisterInfo() {
        Swal.fire({
            title: 'Daftar Akun Baru',
            html: `
                <div style="text-align: left;">
                    <p>Untuk membuat akun baru, silakan hubungi administrator sistem:</p>
                    <ul style="margin-top: 1rem; padding-left: 1.5rem;">
                        <li>Admin POS ILHAM</li>
                        <li>Email: admin@posilham.com</li>
                        <li>Telepon: +62 812-3456-7890</li>
                    </ul>
                </div>
            `,
            confirmButtonColor: '#7c3aed',
            customClass: { popup: 'rounded-4' }
        });
    }

    {{-- POP-UP SUKSES --}}
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2500,
            showConfirmButton: false,
            confirmButtonColor: '#7c3aed',
            customClass: { popup: 'rounded-4' }
        });
    @endif

    {{-- POP-UP GAGAL LOGIN --}}
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal Masuk',
            text: "{{ session('error') }}",
            confirmButtonColor: '#7c3aed',
            customClass: { popup: 'rounded-4' }
        });
    @endif
</script>

</body>
</html>