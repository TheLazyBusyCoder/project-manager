@section('title', 'Task Details')
@extends('layout.project_manager-layout')


<style>
    .container {
        max-width: 900px;
        margin: 10px auto;
        font-family: Arial, sans-serif;
    }

    h1 {
        font-size: 22px;
        margin-bottom: 10px;
    }

    p {
        color: #555;
        margin-bottom: 20px;
    }

    .card {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .card h3 {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .actions {
        margin-bottom: 15px;
        margin-top: 15px;
    }

    .btn {
        padding: 6px 12px;
        border: 1px solid #333;
        background: #fff;
        font-size: 13px;
        margin-right: 5px;
        text-decoration: none;
        color: #333;
    }

    .btn:hover {
        background: #f5f5f5;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background: #f9f9f9;
    }

    .status-active {
        color: green;
    }

    .status-inactive {
        color: red;
    }
</style>

@section('main')

<div class="container">   

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab" data-tab="moduleDetails">MODULE DETAILS</div>
        <div class="tab active" data-tab="details">TASK DETAILS</div>
        <div class="tab" data-tab="assigned_to">ASSIGNED TO</div>
        <div class="tab" data-tab="taskComments">TASK COMMENTS</div>
    </div>

    <div class="tab-content" id="moduleDetails" style="display: none;">
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td><b>Name</b></td>
                    <td>{{  $module->name }}</td>
                </tr>
                <tr>
                    <td><b>Description</b></td>
                    <td>{{ $module->description }}</td>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <td>{{  $module->status }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="details" >
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td><b>Title</b></td>
                    <td>{{ $task->title }}</td>
                </tr>
                <tr>
                    <td><b>Description</b></td>
                    <td>{{  $task->description }}</td>
                </tr>
                <tr>
                    <td><b>Priority</b></td>
                    <td>{{  $task->priority }}</td>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <td>{{  $task->status }}</td>
                </tr>
                <tr>
                    <td><b>Estimated Hours</b></td>
                    <td>{{  $task->estimated_hours }}</td>
                </tr>
                <tr>
                    <td><b>Due Date</b></td>
                    <td>{{  $task->due_date }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="assigned_to" style="display: none;">
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <tbody>
                <tr>
                    <td><b>Name</b></td>
                    <td>{{  $assigned_to->name }}</td>
                </tr>
                <tr>
                    <td><b>Email</b></td>
                    <td>{{ $assigned_to->email }}</td>
                </tr>
                <tr>
                    <td><b>Role</b></td>
                    <td>{{  $assigned_to->role }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="taskComments" style="display:none;" >
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Comments</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($task->taskComments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $comment->user->name . ' ' . $comment->user->email . ' ' . $comment->user->role }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>{{ $comment->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No tasks comments yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <div class="actions">
        <a href="{{ route('pm.modules.view' , $module->id) }}" class="btn">Back</a>
    </div>

</div>

@endsection
