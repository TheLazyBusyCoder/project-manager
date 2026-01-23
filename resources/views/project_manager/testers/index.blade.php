@section('title', 'PM')
@extends('layout.project_manager-layout')

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
    <h1>PM Panel</h1>
    <p>Manage Testers</p>

    <div class="card">
        <h3>Testers</h3>

        <div class="actions">
            <form method="post" action="{{ route('pm.testers') }}" autocomplete="off" onsubmit="return confirm('Are you sure?')">
                @csrf
                <input 
                    type="text"
                    name="name"
                    placeholder="Name"
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
                <button class="btn">Add Tester</button>
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
                @forelse($testers as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $t->name }}</td>
                        <td>{{ $t->email }}</td>
                        <td class="{{ $t->status === 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ ucfirst($t->status) }}
                        </td>
                        <td>{{ $t->created_at?->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('pm.tester', $t->id) }}" class="btn">View</a>
                            <form action="{{ route('pm.tester.delete', $t->id) }}"
                                method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('Are you sure you want to delete this tester?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No Testers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
