@extends('layouts.admin')

@section('page_title', 'Course Categories')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-folder2 me-2 text-primary"></i> Course Categories</h6>
            <small class="text-muted">Drag rows to adjust category sorting on the courses catalog page.</small>
        </div>
        <a href="{{ route('admin.course-categories.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="bi bi-plus-circle me-1"></i> Add Category
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 sortable-table" data-reorder-url="{{ route('admin.course-categories.reorder') }}">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Active Courses</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr data-id="{{ $category->id }}">
                            <td class="text-muted text-center">
                                <i class="bi bi-grip-vertical drag-handle fs-5"></i>
                            </td>
                            <td class="fw-semibold text-dark">
                                {{ $category->name }}
                            </td>
                            <td class="font-monospace small text-muted">
                                {{ $category->slug }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $category->courses_count }} Courses</span>
                            </td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Hidden</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.course-categories.edit', $category) }}" class="btn btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.course-categories.destroy', $category) }}" class="d-inline confirm-delete-form" data-confirm-message="Delete this category? Only allowed if no courses are attached.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No course categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
