

@section('title' , 'Tester')
@extends('layout.tester-layout')

@section('main')

<div class="container">

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" data-tab="list">TASKS</div>
    </div>

    <hr>

    <div class="tab-content" id="list" >
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Module</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->module->name }}</td>
                        <td>{{ $task->priority }}</td>
                        <td>{{ $task->status }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>
                            <a href="{{ route('tester.tasks.view' , $task->id) }}" class="btn">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Noice, No task pending</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
