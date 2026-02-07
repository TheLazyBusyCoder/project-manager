@section('title', 'Admin')
@extends('layout.admin-layout')

@section('main')

<div class="container">

    {{-- Page Header --}}
    <div class="mb-4">
        <h1 class="h4 fw-bold">Admin Panel</h1>
        <p class="text-muted">
            Manage Project Managers and control system-level settings.
        </p>
    </div>

    {{-- Card --}}
    <div class="card">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Project Managers</h5>
            </div>

            {{-- Create Form --}}
            <form
                class="row g-2 mb-4"
                autocomplete="off"
                method="post"
                action="{{ route('admin.project-managers.store') }}"
                onsubmit="return confirm('Are you sure?')"
            >
                @csrf

                <div class="col-md-4">
                    <input
                        type="text"
                        name="name"
                        class="form-control form-control-sm"
                        placeholder="Name"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-sm"
                        placeholder="Email"
                        required
                    >
                </div>

                <div class="col-md-4 d-grid">
                    <button class="btn btn-outline-secondary btn-sm">
                        Create Project Manager
                    </button>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th style="width: 140px;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($projectManagers as $pm)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $pm->name }}</td>

                                <td>{{ $pm->email }}</td>

                                <td>
                                    <span class="badge {{ $pm->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($pm->status) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $pm->created_at?->format('d M Y') }}
                                </td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="#" class="btn btn-outline-secondary btn-sm">
                                            View
                                        </a>
                                        <a href="#" class="btn btn-outline-danger btn-sm">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    No Project Managers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

@endsection
