@extends('layouts.app')

@section('title', 'New Task')
@section('page-title', 'Create New Task')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="mb-3">
            <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted" style="font-size:.875rem">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        <div class="card form-card">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 fw-600" style="font-weight:600">
                    <i class="fas fa-plus-circle me-2" style="color:#6366f1"></i>Task Details
                </h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="title">Task Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" placeholder="What do you need to do?" required autofocus>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Add any additional details…">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" for="priority">Priority <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>🔴 High</option>
                            </select>
                            @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">— None —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if($categories->isEmpty())
                                <div class="form-text">
                                    <a href="{{ route('categories.create') }}" style="color:#6366f1">Create a category first</a>
                                </div>
                            @endif
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label" for="due_date">Due Date</label>
                            <input type="date" name="due_date" id="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date') }}">
                            @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="due_time">Due Time</label>
                            <input type="time" name="due_time" id="due_time"
                                   class="form-control @error('due_time') is-invalid @enderror"
                                   value="{{ old('due_time') }}">
                            @error('due_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn flex-fill" style="background:#6366f1;color:#fff;border-radius:8px;font-weight:600">
                            <i class="fas fa-save me-2"></i>Create Task
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" style="border-radius:8px">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
