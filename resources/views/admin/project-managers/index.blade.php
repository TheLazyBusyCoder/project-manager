@section('title', 'Admin')
@extends('layout.admin-layout')

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
    <h1>Admin Panel</h1>
    <p>Manage Project Managers and control system-level settings.</p>

    <div class="card">
        <h3>Project Managers</h3>
        <div class="actions">
            <form autocomplete="off" method="post" action="{{route('admin.project-managers')}}" onsubmit="return confirm('Are you sure?')">
                @csrf
                <input 
                    type="text"
                    name="name"
                    placeholder="Name"
                    autocomplete="none"
                    class="btn"
                    required
                >
                <input 
                    type="email"
                    name="email"
                    placeholder="Email"
                    autocomplete="new-email"
                    class="btn"
                    required
                >
                <button class="btn">Create Project Manager</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projectManagers as $pm)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pm->name }}</td>
                        <td>{{ $pm->email }}</td>
                        <td class="{{ $pm->status === 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($pm->status) }}
                        </td>
                        <td>{{ $pm->created_at?->format('d M Y') ?? '' }}</td>
                        <td>
                            <a href="#" class="btn">View</a>
                            <a href="#" class="btn">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No Project Managers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
