@extends('layouts.app')

@section('title', 'Categories')
@section('page-title', 'Task Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0" style="font-size:.9rem">Organize your tasks into meaningful groups.</p>
    <a href="{{ route('categories.create') }}" class="btn btn-sm" style="background:#6366f1;color:#fff;border-radius:8px">
        <i class="fas fa-plus me-1"></i> New Category
    </a>
</div>

@if($categories->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:4rem;color:#d1d5db"><i class="fas fa-tags"></i></div>
        <h5 class="mt-3 text-muted">No categories yet</h5>
        <p class="text-muted">Create categories to better organize your tasks.</p>
        <a href="{{ route('categories.create') }}" class="btn" style="background:#6366f1;color:#fff;border-radius:8px">
            <i class="fas fa-plus me-2"></i>Create Your First Category
        </a>
    </div>
@else
    <div class="row g-3">
        @foreach($categories as $category)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card border-0 rounded-3 shadow-sm h-100" style="border-left:4px solid {{ $category->color }} !important;border-left-width:4px !important">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle" style="width:14px;height:14px;background:{{ $category->color }}"></div>
                                <h6 class="mb-0 fw-semibold">{{ $category->name }}</h6>
                            </div>
                            <span class="badge" style="background:{{ $category->color }}20;color:{{ $category->color }};border:1px solid {{ $category->color }}40">
                                {{ $category->tasks_count }} task{{ $category->tasks_count !== 1 ? 's' : '' }}
                            </span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('dashboard', ['category_id' => $category->id]) }}"
                               class="btn btn-sm btn-outline-secondary flex-fill" style="font-size:.8rem">
                                <i class="fas fa-eye me-1"></i>View Tasks
                            </a>
                            <a href="{{ route('categories.edit', $category) }}"
                               class="btn btn-sm btn-outline-primary" style="font-size:.8rem">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                  onsubmit="return confirm('Delete this category? Tasks in it will remain uncategorized.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size:.8rem">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
