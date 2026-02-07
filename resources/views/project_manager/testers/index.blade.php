@section('title', 'PM Testers')
@extends('layout.project_manager-layout')

@section('main')

<div class="container-fluid">

    <h4 class="mb-3">Testers</h4>
    <p class="text-muted">Manage testers assigned to your projects.</p>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active"
                    data-bs-toggle="tab"
                    data-bs-target="#testers-list"
                    type="button">
                Testers List
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#testers-create"
                    type="button">
                Create Tester
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- LIST TAB --}}
        <div class="tab-pane fade show active" id="testers-list">

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($testers as $t)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $t->name }}</td>
                                        <td>{{ $t->email }}</td>
                                        <td>
                                            <span class="badge {{ $t->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($t->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $t->created_at?->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('pm.tester', $t->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>

                                            <form action="{{ route('pm.tester.delete', $t->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Delete this tester?')">
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
                                            No testers found.
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
        <div class="tab-pane fade" id="testers-create">

            <div class="card">
                <div class="card-body">

                    <form method="POST"
                          action="{{ route('pm.testers.store') }}"
                          onsubmit="return confirm('Create tester?')">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       placeholder="Tester name"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       placeholder="Email address"
                                       required>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">
                                Add Tester
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection
