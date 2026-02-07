@section('title', 'Task Details')
@extends('layout.project_manager-layout')

@section('main')

<div class="container my-3">

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="taskTabs">
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#moduleDetails">MODULE DETAILS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#details">TASK DETAILS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#assigned_to">ASSIGNED TO</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#taskComments">TASK COMMENTS</a>
        </li>
    </ul>

    <div class="tab-content">

        <!-- Module Details -->
        <div class="tab-pane fade" id="moduleDetails">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th width="30%">Name</th>
                                <td>{{ $module->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $module->description }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $module->status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Task Details -->
        <div class="tab-pane fade show active" id="details">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th width="30%">Title</th>
                                <td>{{ $task->title }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $task->description }}</td>
                            </tr>
                            <tr>
                                <th>Priority</th>
                                <td>{{ $task->priority }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $task->status }}</td>
                            </tr>
                            <tr>
                                <th>Estimated Hours</th>
                                <td>{{ $task->estimated_hours }}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td>{{ $task->due_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Assigned To -->
        <div class="tab-pane fade" id="assigned_to">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th width="30%">Name</th>
                                <td>{{ $assigned_to->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $assigned_to->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ $assigned_to->role }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Task Comments -->
        <div class="tab-pane fade" id="taskComments">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Comment</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($task->taskComments as $comment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $comment->user->name }} <br>
                                        <small class="text-muted">
                                            {{ $comment->user->email }} | {{ $comment->user->role }}
                                        </small>
                                    </td>
                                    <td>{{ $comment->comment }}</td>
                                    <td>{{ $comment->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No task comments yet
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Actions -->
    <div class="mt-3">
        <a href="{{ route('pm.modules.view', $module->id) }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

</div>

@endsection
