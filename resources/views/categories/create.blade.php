@extends('layouts.app')

@section('title', 'New Category')
@section('page-title', 'Create Category')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-5">
        <div class="mb-3">
            <a href="{{ route('categories.index') }}" class="text-decoration-none text-muted" style="font-size:.875rem">
                <i class="fas fa-arrow-left me-1"></i> Back to Categories
            </a>
        </div>

        <div class="card form-card">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0" style="font-weight:600">
                    <i class="fas fa-tag me-2" style="color:#6366f1"></i>Category Details
                </h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="name">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="e.g. Work, Personal, Health" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="color">Label Color <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" name="color" id="color"
                                   class="form-control form-control-color @error('color') is-invalid @enderror"
                                   value="{{ old('color', '#6366f1') }}" style="width:60px;height:42px;padding:2px;cursor:pointer">
                            <div class="flex-grow-1">
                                <div class="d-flex flex-wrap gap-2" id="color-presets">
                                    @foreach(['#6366f1','#ef4444','#f59e0b','#22c55e','#3b82f6','#8b5cf6','#ec4899','#14b8a6','#f97316','#64748b'] as $preset)
                                        <div class="rounded-circle color-preset"
                                             data-color="{{ $preset }}"
                                             style="width:24px;height:24px;background:{{ $preset }};cursor:pointer;border:2px solid transparent;transition:border .15s"
                                             title="{{ $preset }}"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @error('color')<div class="text-danger mt-1" style="font-size:.875rem">{{ $message }}</div>@enderror
                        <div class="form-text">Pick a color to represent this category.</div>
                    </div>

                    {{-- Preview --}}
                    <div class="mb-4 p-3 rounded-3" style="background:#f8fafc;border:1px dashed #e2e8f0">
                        <div class="text-muted mb-1" style="font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Preview</div>
                        <span class="badge" id="preview-badge" style="background:#6366f120;color:#6366f1;border:1px solid #6366f140;font-size:.8rem">
                            Category Name
                        </span>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn flex-fill" style="background:#6366f1;color:#fff;border-radius:8px;font-weight:600">
                            <i class="fas fa-save me-2"></i>Create Category
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary" style="border-radius:8px">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const colorInput   = document.getElementById('color');
    const nameInput    = document.getElementById('name');
    const previewBadge = document.getElementById('preview-badge');
    const presets      = document.querySelectorAll('.color-preset');

    function updatePreview() {
        const color = colorInput.value;
        const name  = nameInput.value || 'Category Name';
        previewBadge.style.background = color + '20';
        previewBadge.style.color      = color;
        previewBadge.style.border     = '1px solid ' + color + '40';
        previewBadge.textContent      = name;
    }

    colorInput.addEventListener('input', updatePreview);
    nameInput.addEventListener('input', updatePreview);

    presets.forEach(p => {
        p.addEventListener('click', () => {
            colorInput.value = p.dataset.color;
            presets.forEach(x => x.style.border = '2px solid transparent');
            p.style.border = '2px solid #1e1b4b';
            updatePreview();
        });
    });
</script>
@endsection
