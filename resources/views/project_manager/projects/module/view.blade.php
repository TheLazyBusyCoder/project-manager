@section('title', 'Developer Details')
@extends('layout.project_manager-layout')


@section('head')
    <link rel="stylesheet" href="{{asset('css/vis.min.css')}}">
    <script src="{{asset('js/vis.min.js')}}"></script>
@endsection

@section('sidebar')
    @include('partials.sidebar')
@endsection


@section('main')


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

<div class="container">   

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" data-tab="details">DETAILS</div>
        <div class="tab" data-tab="list">SUB MODULES</div>
        <div class="tab" data-tab="create">CREATE SUB MODULE</div>
        <div class="tab" data-tab="createTask">CREATE TASK</div>
    </div>

    <hr>

    <div class="tab-content" id="details" >
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr bgcolor="#f2f2f2">
                    <th align="left">Property</th>
                    <th align="left">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Module Name</b></td>
                    <td>{{ $module->name }}</td>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <td>{{ $module->status }}</td>
                </tr>
                <tr>
                    <td valign="top"><b>Description</b></td>
                    <td>{{ $module->description }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="list" style="display:none;" >
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($modules as $child)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $child->name }}</td>
                        <td>{{ $child->status }}</td>
                        <td>{{ $child->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('pm.modules.view', $child->id) }}" class="btn">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No modules created yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- {{  dd($module) }} --}}
    <div class="tab-content" id="create" style="display:none;">
        <form method="POST" action="{{ route('pm.modules.create.sub' , $module->id) }}">
            @csrf

            <table>
                <tr>
                    <td>Module Name</td>
                    <td>
                        <input type="text" name="name" class="btn" required style="width:100%">
                    </td>
                </tr>

                <tr>
                    <td>Description</td>
                    <td>
                        <textarea name="description" class="btn" rows="3" style="width:100%"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select class="btn" name="status">
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="blocked">Blocked</option>
                            <option value="completed">Completed</option>
                        </select>
                    </td>
                </tr>
            </table>

            <div class="actions">
                <button class="btn">Create Module</button>
            </div>
        </form>
    </div>
</div>

@endsection
