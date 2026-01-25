@section('title', 'Developer Details')
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
    <form method="POST" action="{{ route('pm.developers.update', $developer->id) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <table>
                <tr>
                    <th>Name</th>
                    <td>
                        <input class="btn" type="text" name="name" value="{{ $developer->name }}">
                    </td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>
                        <input class="btn" type="email" name="email" value="{{ $developer->email }}">
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        <select class="btn" name="status">
                            <option value="active" {{ $developer->status === 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ $developer->status === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $developer->created_at?->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            <div class="actions">
                <a href="{{ route('pm.developers') }}" class="btn">Back</a>
                <button type="submit" class="btn">Update</button>
            </div>
        </div>
    </form>

</div>

@endsection
