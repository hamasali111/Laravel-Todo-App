@extends('layouts.app')

@section('title', 'Edit Task')
@section('page-title', 'Edit Task')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="mb-3">
            <a href="{{ route('dashboard') }}" class="text-decoration-none text-muted" style="font-size:.875rem">
                <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
            </a>
        </div>

        <div class="card form-card">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0" style="font-weight:600">
                    <i class="fas fa-pen me-2" style="color:#6366f1"></i>Edit Task
                </h6>
                <span class="badge {{ $task->isCompleted() ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ ucfirst($task->status) }}
                </span>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label" for="title">Task Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $task->title) }}" required autofocus>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" id="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Add any additional details…">{{ old('description', $task->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label" for="priority">Priority <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="low" {{ old('priority', $task->priority) === 'low' ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority', $task->priority) === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                <option value="high" {{ old('priority', $task->priority) === 'high' ? 'selected' : '' }}>🔴 High</option>
                            </select>
                            @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">— None —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $task->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label" for="due_date">Due Date</label>
                            <input type="date" name="due_date" id="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
                            @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="due_time">Due Time</label>
                            <input type="time" name="due_time" id="due_time"
                                   class="form-control @error('due_time') is-invalid @enderror"
                                   value="{{ old('due_time', $task->due_time ? substr($task->due_time, 0, 5) : '') }}">
                            @error('due_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn flex-fill" style="background:#6366f1;color:#fff;border-radius:8px;font-weight:600">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" style="border-radius:8px">
                            Cancel
                        </a>
                    </div>
                </form>

                <hr class="my-4">
                <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                      onsubmit="return confirm('Are you sure you want to delete this task?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100" style="border-radius:8px">
                        <i class="fas fa-trash me-2"></i>Delete This Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
