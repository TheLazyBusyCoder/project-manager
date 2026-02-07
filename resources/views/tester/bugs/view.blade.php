

@section('title' , 'Tester')
@extends('layout.tester-layout')

@section('head')

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css"
/>
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />

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

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th, td {
        padding: 8px;
        text-align: left;
    }

    .status-active {
        color: green;
    }

    .status-inactive {
        color: red;
    }
</style>

<style>
    #editor .ql-editor {
        min-height: 300px;
    }
</style>

<div class="container">

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" data-tab="bug">BUG</div>
        <div class="tab" data-tab="comments">COMMENTS</div>
        <div class="tab" data-tab="attachments">ATTACHMENTS</div>
    </div>

    <hr>

    <div class="tab-content" id="bug" >
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr bgcolor="#f2f2f2">
                    <th align="left">Property</th>
                    <th align="left">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Title</b></td>
                    <td>{{ $bug->title }}</td>
                </tr>
                <tr>
                    <td><b>Description</b></td>
                    <td>{{$bug->description}}</td>
                </tr>
                <tr>
                    <td><b>Priority</b></td>
                    <td>{{ $bug->severity }}</td>
                </tr>
                <tr>
                    <td valign="top"><b>Status</b></td>
                    <td>{{ $bug->status }}</td>
                </tr>
                <tr>
                    <td valign="top"><b>Steps</b></td>
                    <td>{{ $bug->steps_to_reproduce }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="comments"  style="display: none;">
        <div class="form">
            <form method="POST" action="{{route('tester.bugs.comments.add' , $bug->id)}}">
                @csrf
                <input 
                    type="text" 
                    name="comment" 
                    placeholder="Comment"
                    value=""
                    required
                >
                <button type="submit">Add comment</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Comment</th>
                    <th>Commented By</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bug->comments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No Comments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="attachments" style="display: none;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>File</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bug->attachments as $attachment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ asset('storage/'.$attachment->file_path) }}" target="_blank">
                                {{ basename($attachment->file_path) }}
                            </a>
                        </td>
                        <td>{{ $attachment->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No Comments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')

@endsection
