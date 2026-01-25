@section('title', 'PM')
@extends('layout.project_manager-layout')

@section('main')

<style>

    /* Form styling */
    .tab-content input,
    .tab-content textarea,
    .tab-content select,
    .tab-content {
        padding: 6px 8px;
        margin-bottom: 8px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        transition: all 0.1s;
    }

    .tab-content input:focus,
    .tab-content textarea:focus,
    .tab-content select:focus {
        outline: none;
        border-color: #5b7df0;
        box-shadow: 0 0 2px rgba(91, 125, 240, 0.2);
    }

    .tab-content textarea {
        resize: vertical;
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
    }

    th {
        background: #f9f9f9;
        width: 200px;
    }
</style>

<div class="container">
    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" data-tab="list">PROJECTS</div>
        <div class="tab " data-tab="create">CREATE</div>
    </div>
    <!-- Tab Contents -->
    <div class="tab-content" id="list" >
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->description }}</td>
                        <td>{{$p->status }}</td>
                        <td>{{ $p->created_at?->format('d M Y') ?? '' }}</td>
                        <td>
                            <a href="{{route('pm.project.view' , ['project_id' => $p->id])}}" class="btn">View</a>
                            <form method="POST" action="" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" onclick="return confirm('Delete this project?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No Projects found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="create" style="display:none;">
        <form method="POST" action="{{ route('pm.projects.create') }}" autocomplete="off"
            onsubmit="return confirm('Create this project?')">
            @csrf

            <table class="form-table">
                <tr>
                    <td><label>Project Name</label></td>
                    <td>
                        <input type="text" name="name" required>
                    </td>
                </tr>

                <tr>
                    <td><label>Description</label></td>
                    <td>
                        <textarea name="description" rows="3"></textarea>
                    </td>
                </tr>

                <tr>
                    <td><label>Status</label></td>
                    <td>
                        <select name="status" required>
                            <option value="planned">planned</option>
                            <option value="in_progress">in_progress</option>
                            <option value="on_hold">on_hold</option>
                            <option value="completed">completed</option>
                            <option value="cancelle">cancelle</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label>Start Date</label></td>
                    <td>
                        <input type="date" name="start_date" required>
                    </td>
                </tr>

                <tr>
                    <td><label>End Date</label></td>
                    <td>
                        <input type="date" name="end_date">
                    </td>
                </tr>

                <tr>
                    <td>Action</td>
                    <td>
                        <button class="btn" type="submit">Add Project</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>
@endsection
