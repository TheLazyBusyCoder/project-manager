@section('title', 'Project Details')
@extends('layout.project_manager-layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/vis.min.css') }}">
    <script src="{{ asset('js/vis.min.js') }}"></script>
@endsection

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('main')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">{{ $project->name }}</h4>
            <small class="text-muted">
                {{ $project->start_date }} → {{ $project->end_date }}
            </small>
        </div>

        <span class="badge bg-secondary">
            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
        </span>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <button class="nav-link active"
                    data-bs-toggle="tab"
                    data-bs-target="#details"
                    type="button">
                Details
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#modules"
                    type="button">
                Sub Modules
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#create-module"
                    type="button">
                Create Module
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- DETAILS --}}
        <div class="tab-pane fade show active" id="details">
            <div class="card">
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Project Name</dt>
                        <dd class="col-sm-9">{{ $project->name }}</dd>

                        <dt class="col-sm-3">Dates</dt>
                        <dd class="col-sm-9">
                            {{ $project->start_date }} – {{ $project->end_date }}
                        </dd>

                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-secondary">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                        </dd>

                        <dt class="col-sm-3">Description</dt>
                        <dd class="col-sm-9 text-muted">
                            {{ $project->description }}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        {{-- MODULE LIST --}}
        <div class="tab-pane fade" id="modules">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Parent</th>
                                    <th>Created</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($modules as $module)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-semibold">{{ $module->name }}</td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ ucfirst(str_replace('_', ' ', $module->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ optional($module->parent)->name ?? '-' }}</td>
                                        <td>{{ $module->created_at->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('pm.modules.view', $module->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"
                                            class="text-center text-muted py-4">
                                            No modules created yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- CREATE MODULE --}}
        <div class="tab-pane fade" id="create-module">
            <div class="card">
                <div class="card-body">

                    <form method="POST"
                          action="{{ route('pm.modules.create', $project->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Module Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      class="form-control"
                                      rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Parent Module</label>
                            <select name="parent_module_id"
                                    class="form-select">
                                <option value="">None</option>
                                @foreach ($modules as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status"
                                    class="form-select">
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="blocked">Blocked</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">
                                Create Module
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

    <div class="mt-3">
        <a href="{{ route('pm.projects') }}"
           class="btn btn-outline-secondary">
            ← Back to Projects
        </a>
    </div>

</div>

@endsection
