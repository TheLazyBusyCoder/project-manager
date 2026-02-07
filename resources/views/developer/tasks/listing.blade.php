@section('title', 'Developer')
@extends('layout.developer-layout')

@section('main')
<div class="container-fluid">

    <h4 class="mb-3">My Task</h4>
    <p class="text-muted">Manage and track all your tasks.</p>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Module</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $task->title }}</td>
                                <td class="text-muted">
                                    {{ Str::limit($task->description, 50) }}
                                </td>
                                <td>{{ $task->module->name }}</td>
                                <td>
                                    <span class="">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="">
                                        {{ str_replace('_',' ', ucfirst($task->status)) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '—' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('developer.tasks.view', $task->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    😌 Nice, no tasks pending
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
