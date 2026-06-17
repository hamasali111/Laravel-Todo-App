@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'My Tasks')

@section('content')

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#eef2ff">
                    <i class="fas fa-list-check" style="color:#6366f1"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#fef3c7">
                    <i class="fas fa-clock" style="color:#f59e0b"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#dcfce7">
                    <i class="fas fa-check-circle" style="color:#22c55e"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['completed'] }}</div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box" style="background:#fee2e2">
                    <i class="fas fa-exclamation-circle" style="color:#ef4444"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['high'] }}</div>
                    <div class="stat-label">High Priority</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<div class="card border-0 rounded-3 shadow-sm mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('dashboard') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search tasks…" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-md-2">
                <select name="filter" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('filter') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('filter') === 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="priority" class="form-select form-select-sm">
                    <option value="">All Priority</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="category_id" class="form-select form-select-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-2 d-flex gap-1">
                <button type="submit" class="btn btn-sm flex-fill" style="background:#6366f1;color:#fff">
                    <i class="fas fa-filter me-1"></i>Filter
                </button>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary flex-fill">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Task List --}}
@if($tasks->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:4rem;color:#d1d5db"><i class="fas fa-clipboard-list"></i></div>
        <h5 class="mt-3 text-muted">No tasks found</h5>
        <p class="text-muted">Get started by creating your first task.</p>
        <a href="{{ route('tasks.create') }}" class="btn" style="background:#6366f1;color:#fff;border-radius:8px">
            <i class="fas fa-plus me-2"></i>Add Your First Task
        </a>
    </div>
@else
    @foreach($tasks as $task)
        @php
            $priorityColors = ['high' => '#ef4444', 'medium' => '#f59e0b', 'low' => '#22c55e'];
            $priorityColor  = $priorityColors[$task->priority] ?? '#9ca3af';
        @endphp
        <div class="task-card {{ $task->isCompleted() ? 'completed' : '' }} {{ $task->isOverdue() ? 'overdue' : '' }}">
            {{-- Priority indicator --}}
            <div class="priority-indicator" style="background:{{ $priorityColor }}"></div>

            {{-- Toggle checkbox --}}
            <form method="POST" action="{{ route('tasks.toggle', $task) }}" class="flex-shrink-0">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Toggle status"
                        style="font-size:1.25rem;color:{{ $task->isCompleted() ? '#22c55e' : '#d1d5db' }}">
                    <i class="fas fa-{{ $task->isCompleted() ? 'check-circle' : 'circle' }}"></i>
                </button>
            </form>

            {{-- Task info --}}
            <div class="flex-grow-1 min-w-0">
                <div class="task-title">{{ $task->title }}</div>
                <div class="task-meta d-flex flex-wrap gap-2 mt-1">
                    @if($task->due_time)
    at {{ \Carbon\Carbon::parse($task->due_time)->format('h:i A') }}
@endif
                    @if($task->isOverdue())
                        <span class="text-danger fw-semibold"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                    @endif
                </div>
            </div>

            {{-- Badges --}}
            <div class="d-flex gap-1 flex-wrap align-items-center">
                <span class="badge" style="background:{{ $priorityColor }}20;color:{{ $priorityColor }};border:1px solid {{ $priorityColor }}40">
                    {{ ucfirst($task->priority) }}
                </span>
                @if($task->category)
                    <span class="badge" style="background:{{ $task->category->color }}20;color:{{ $task->category->color }};border:1px solid {{ $task->category->color }}40">
                        {{ $task->category->name }}
                    </span>
                @endif
                <span class="badge {{ $task->isCompleted() ? 'bg-success' : 'bg-secondary' }} bg-opacity-75">
                    {{ ucfirst($task->status) }}
                </span>
            </div>

            {{-- Actions --}}
            <div class="d-flex gap-1 flex-shrink-0">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary rounded-2" title="Edit">
                    <i class="fas fa-pen"></i>
                </a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                      onsubmit="return confirm('Delete this task?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    @if($tasks->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->links('pagination::bootstrap-5') }}
        </div>
    @endif
@endif

@endsection
