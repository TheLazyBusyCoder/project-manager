@section('title', 'PM Projects')
@extends('layout.project_manager-layout')

@section('main')

    <div class="container-fluid">

        <h4 class="mb-3">Projects</h4>
        <p class="text-muted">Manage and track all your projects.</p>

        {{-- Tabs --}}
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <button class="nav-link active"
                        data-bs-toggle="tab"
                        data-bs-target="#projects-list"
                        type="button">
                    Projects List
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#projects-create"
                        type="button">
                    Create Project
                </button>
            </li>
        </ul>

        <div class="tab-content">

            {{-- LIST TAB --}}
            <div class="tab-pane fade show active" id="projects-list">

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($projects as $p)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-semibold">{{ $p->name }}</td>
                                            <td class="text-muted">{{ $p->description }}</td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                                                </span>
                                            </td>
                                            <td>{{ $p->created_at?->format('d M Y') }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('pm.project.view', ['project_id' => $p->id]) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>

                                                <form method="POST"
                                                    action=""
                                                    class="d-inline"
                                                    onsubmit="return confirm('Delete this project?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                No projects found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            {{-- CREATE TAB --}}
            <div class="tab-pane fade" id="projects-create">

                <div class="card">
                    <div class="card-body">

                        <form method="POST"
                            action="{{ route('pm.projects.create') }}"
                            onsubmit="return confirm('Create this project?')">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Project Name</label>
                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status"
                                            class="form-select"
                                            required>
                                        <option value="planned">Planned</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="on_hold">On Hold</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                        class="form-control"
                                        rows="3"></textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Start Date</label>
                                    <input type="date"
                                        name="start_date"
                                        class="form-control"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">End Date</label>
                                    <input type="date"
                                        name="end_date"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary">
                                    Add Project
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
