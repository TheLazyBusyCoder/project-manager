@section('title', 'Developer Details')
@extends('layout.project_manager-layout')


@section('head')
    <link rel="stylesheet" href="{{asset('css/vis.min.css')}}">
    <script src="{{asset('js/vis.min.js')}}"></script>
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
         <div class="card">
            Status: {{ $project->status }},
            Project: {{ $project->name }} ( {{$project->start_date}} - {{$project->end_date}} ) <br>
            Description: {{ $project->description }}

            <hr>

            <h3>Modules</h3>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Parent</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($modules as $module)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $module->name }}</td>
                            <td>{{ $module->status }}</td>
                            <td>
                                {{ optional($module->parent)->name ?? '-' }}
                            </td>
                            <td>{{ $module->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No modules created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <hr>

            <h3>Create Module</h3>

            <form method="POST" action="{{ route('pm.modules.create', $project->id) }}">
                @csrf

                <table>
                    <tr>
                        <td>Module Name</td>
                        <td>
                            <input type="text" name="name" required style="width:100%">
                        </td>
                    </tr>

                    <tr>
                        <td>Description</td>
                        <td>
                            <textarea name="description" rows="3" style="width:100%"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Parent Module</td>
                        <td>
                            <select name="parent_module_id" style="width:100%">
                                <option value="">None</option>
                                @foreach ($modules as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td>
                            <select name="status">
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

            <div class="actions">
                <a href="{{ route('pm.projects') }}" class="btn">Back</a>
            </div>
        </div>
    </form>

</div>

@endsection
