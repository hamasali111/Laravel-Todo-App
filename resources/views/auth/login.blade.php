<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — TaskMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: #fff; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,.1); width: 100%; max-width: 420px; overflow: hidden; }
        .auth-header { background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 100%); padding: 2rem; text-align: center; }
        .auth-header h2 { color: #fff; font-weight: 700; margin: 0; }
        .auth-header p { color: #c7d2fe; margin: .4rem 0 0; font-size: .88rem; }
        .auth-body { padding: 2rem; }
        .form-label { font-weight: 500; font-size: .875rem; color: #374151; }
        .form-control { border-color: #d1d5db; border-radius: 8px; padding: .6rem .9rem; }
        .form-control:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
        .btn-primary { background: #6366f1; border-color: #6366f1; border-radius: 8px; padding: .65rem; font-weight: 600; }
        .btn-primary:hover { background: #4f46e5; border-color: #4f46e5; }
        .divider { border-top: 1px solid #e5e7eb; margin: 1.25rem 0; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div class="mb-2" style="font-size:2rem;color:#a5b4fc"><i class="fas fa-check-double"></i></div>
            <h2>TaskMaster</h2>
            <p>Sign in to manage your tasks</p>
        </div>
        <div class="auth-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3" role="alert" style="font-size:.875rem">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email"><i class="fas fa-envelope me-1 text-muted"></i> Email Address</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password"><i class="fas fa-lock me-1 text-muted"></i> Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter your password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input" style="accent-color:#6366f1">
                    <label class="form-check-label text-muted" for="remember" style="font-size:.875rem">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                </button>
            </form>

            <div class="divider"></div>
            <p class="text-center text-muted mb-0" style="font-size:.875rem">
                Don't have an account?
                <a href="{{ route('register') }}" style="color:#6366f1;font-weight:600">Create one</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
