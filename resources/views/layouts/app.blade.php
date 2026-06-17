<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TaskMaster') — TaskMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f0f2f5; }

        /* Sidebar */
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: width .25s;
            overflow-x: hidden;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .sidebar-brand h4 { color: #fff; font-weight: 700; margin: 0; letter-spacing: .5px; }
        .sidebar-brand span { color: #a5b4fc; font-size: .78rem; }

        .sidebar-nav { padding: .75rem 0; }
        .nav-section-label {
            color: #a5b4fc;
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 1rem 1.25rem .4rem;
        }
        .sidebar-nav .nav-link {
            color: #c7d2fe;
            padding: .55rem 1.25rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: .75rem;
            font-size: .9rem;
            transition: all .2s;
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.12);
        }
        .sidebar-nav .nav-link i { width: 18px; text-align: center; font-size: .95rem; }

        .sidebar-user {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.1);
            background: rgba(0,0,0,.15);
        }
        .sidebar-user .user-name { color: #fff; font-size: .88rem; font-weight: 600; }
        .sidebar-user .user-email { color: #a5b4fc; font-size: .75rem; }

        /* Main content */
        #main-content { margin-left: 260px; min-height: 100vh; }

        .top-bar {
            background: #fff;
            padding: .875rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
        }
        .top-bar h5 { margin: 0; font-weight: 600; color: #111827; }
        .content-area { padding: 1.5rem; }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.07);
            transition: transform .2s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .icon-box {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
        }
        .stat-card .stat-value { font-size: 1.75rem; font-weight: 700; color: #111827; }
        .stat-card .stat-label { color: #6b7280; font-size: .83rem; }

        /* Task list */
        .task-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: .875rem 1rem;
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            transition: box-shadow .2s;
        }
        .task-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.08); }
        .task-card.completed { opacity: .6; }
        .task-card.completed .task-title { text-decoration: line-through; color: #9ca3af; }
        .task-card.overdue { border-left: 4px solid #ef4444; }

        .task-title { font-weight: 500; color: #111827; font-size: .95rem; }
        .task-meta { font-size: .78rem; color: #9ca3af; }

        .priority-indicator { width: 4px; height: 40px; border-radius: 4px; flex-shrink: 0; }

        /* Form styles */
        .form-card {
            background: #fff;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,.07);
        }
        .form-label { font-weight: 500; font-size: .875rem; color: #374151; }
        .form-control, .form-select {
            border-color: #d1d5db;
            border-radius: 8px;
            font-size: .9rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.15);
        }

        /* Badges */
        .badge { font-weight: 500; font-size: .72rem; }

        /* Pagination */
        .pagination .page-link { border-color: #e5e7eb; color: #6366f1; }
        .pagination .page-item.active .page-link { background: #6366f1; border-color: #6366f1; }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar { width: 0; }
            #main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

{{-- Sidebar --}}
<div id="sidebar">
    <div class="sidebar-brand">
        <h4><i class="fas fa-check-double me-2" style="color:#a5b4fc"></i>TaskMaster</h4>
        <span>Task Management System</span>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="{{ route('tasks.create') }}" class="nav-link {{ request()->routeIs('tasks.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Add New Task
        </a>

        <div class="nav-section-label">Filter Tasks</div>
        <a href="{{ route('dashboard', ['filter' => 'pending']) }}" class="nav-link {{ request('filter') === 'pending' ? 'active' : '' }}">
            <i class="fas fa-clock"></i> Pending Tasks
        </a>
        <a href="{{ route('dashboard', ['filter' => 'completed']) }}" class="nav-link {{ request('filter') === 'completed' ? 'active' : '' }}">
            <i class="fas fa-check-circle"></i> Completed Tasks
        </a>
        <a href="{{ route('dashboard', ['priority' => 'high']) }}" class="nav-link {{ request('priority') === 'high' ? 'active' : '' }}">
            <i class="fas fa-exclamation-circle" style="color:#f87171"></i> High Priority
        </a>

        <div class="nav-section-label">Organize</div>
        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> Categories
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle bg-indigo-500 d-flex align-items-center justify-content-center"
                 style="width:34px;height:34px;background:#6366f1;color:#fff;font-weight:700;font-size:.85rem;flex-shrink:0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <div class="user-name text-truncate">{{ auth()->user()->name }}</div>
                <div class="user-email text-truncate">{{ auth()->user()->email }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-sm w-100 text-start"
                    style="color:#fca5a5;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1)">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </button>
        </form>
    </div>
</div>

{{-- Main content --}}
<div id="main-content">
    <div class="top-bar">
        <h5>@yield('page-title', 'Dashboard')</h5>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary">{{ now()->format('M d, Y') }}</span>
            <a href="{{ route('tasks.create') }}" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:8px">
                <i class="fas fa-plus me-1"></i> New Task
            </a>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
