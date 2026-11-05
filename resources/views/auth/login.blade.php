<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Internal - PDAM Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f1f5f9; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 400px; border: none; border-radius: 12px; }
        .btn-login { background: #1e3a8a; color: white; font-weight: bold; }
        .btn-login:hover { background: #172554; color: white; }
    </style>
</head>
<body>

<div class="card login-card shadow-sm">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-primary" style="letter-spacing: 1px;">PORTAL INTERNAL</h4>
            <p class="text-muted small">Khusus Admin, Kasir & Petugas Lapangan PDAM</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold text-secondary">Email Official</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="nama@pdam.com" autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label small fw-bold text-secondary">Password</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-login w-100 py-2 shadow-sm">Masuk Sistem 🔑</button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('pelanggan.dashboard') }}" class="text-decoration-none small text-secondary">← Kembali ke Beranda Pelanggan</a>
        </div>
    </div>
</div>

</body>
</html>