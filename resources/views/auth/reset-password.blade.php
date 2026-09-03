<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - POS ILHAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --purple-deep: #4c1d95;
            --purple-main: #7c3aed;
            --purple-bright: #a855f7;
        }

        body {
            background: linear-gradient(135deg, #2e1065 0%, #581c87 40%, #7e22ce 70%, #6b21a8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            padding: 1rem;
        }

        .card-reset {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 50px -12px rgba(15, 3, 38, 0.5);
            backdrop-filter: blur(20px);
            max-width: 450px;
            width: 100%;
            padding: 2.5rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 2px solid #e2e8f0;
            font-size: 0.95rem;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--purple-main);
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.15);
            background: white;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--purple-deep) 0%, var(--purple-main) 50%, var(--purple-bright) 100%);
            border: none;
            color: white;
            padding: 0.85rem;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
        }

        .btn-gradient:hover {
            color: white;
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.45);
        }
    </style>
</head>
<body>

<div class="card-reset">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-dark">Atur Ulang Kata Sandi</h3>
        <p class="text-muted small">Masukkan kata sandi baru untuk akun Anda.</p>
    </div>

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        
        <input type="hidden" name="token" value="{{ request()->route('token') ?? $token }}">

        <div class="mb-3">
            <label class="form-label text-secondary fw-semibold small">ALAMAT EMAIL</label>
            <div class="input-wrapper">
                <input type="email" name="email" value="{{ request()->email ?? old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com" required readonly>
                <i class="bi bi-envelope input-icon"></i>
            </div>
            @error('email')
                <small class="text-danger mt-1 d-block">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label text-secondary fw-semibold small">KATA SANDI BARU</label>
            <div class="input-wrapper">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required autofocus>
                <i class="bi bi-lock input-icon"></i>
            </div>
            @error('password')
                <small class="text-danger mt-1 d-block">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label text-secondary fw-semibold small">KONFIRMASI KATA SANDI</label>
            <div class="input-wrapper">
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                <i class="bi bi-shield-lock input-icon"></i>
            </div>
        </div>

        <button type="submit" class="btn btn-gradient">
            <i class="bi bi-check-circle me-1"></i> Simpan Kata Sandi Baru
        </button>
    </form>
</div>

</body>
</html>