<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — TaskMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .auth-card { background: #fff; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,.1); width: 100%; max-width: 440px; overflow: hidden; }
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
            <div class="mb-2" style="font-size:2rem;color:#a5b4fc"><i class="fas fa-user-plus"></i></div>
            <h2>Create Account</h2>
            <p>Start managing your tasks today</p>
        </div>
        <div class="auth-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3" role="alert" style="font-size:.875rem">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name"><i class="fas fa-user me-1 text-muted"></i> Full Name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="John Doe" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email"><i class="fas fa-envelope me-1 text-muted"></i> Email Address</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password"><i class="fas fa-lock me-1 text-muted"></i> Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Minimum 8 characters" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="password_confirmation"><i class="fas fa-lock me-1 text-muted"></i> Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                           placeholder="Repeat your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-user-plus me-2"></i>Create Account
                </button>
            </form>

            <div class="divider"></div>
            <p class="text-center text-muted mb-0" style="font-size:.875rem">
                Already have an account?
                <a href="{{ route('login') }}" style="color:#6366f1;font-weight:600">Sign in</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
