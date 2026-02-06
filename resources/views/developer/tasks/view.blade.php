

@section('title' , 'Developer')
@extends('layout.developer-layout')

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

<div class="container">

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" data-tab="task">TASK</div>
        <div class="tab" data-tab="module">MODULE</div>
        <div class="tab" data-tab="bugs">BUGS</div>
    </div>

    <hr>

    <div class="tab-content" id="task" >
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
                    <td>{{ $task->title }}</td>
                </tr>
                <tr>
                    <td><b>Description</b></td>
                    <td>{{$task->description}}</td>
                </tr>
                <tr>
                    <td><b>Priority</b></td>
                    <td>{{ $task->priority }}</td>
                </tr>
                <tr>
                    <td valign="top"><b>Status</b></td>
                    <td>{{ $task->status }}</td>
                </tr>
                <tr>
                    <td valign="top"><b>Estimated Hours</b></td>
                    <td>{{ $task->estimated_hours }}</td>
                </tr>
                <tr>
                    <td valign="top"><b>Due date</b></td>
                    <td>{{ $task->due_date }}</td>
                </tr>
                <tr>
                    <td valign="top"><b>Created at</b></td>
                    <td>{{ $task->created_at }}</td>
                </tr>
            </tbody>
        </table>

        <div class="form">
            <form method="POST" action="{{ route('developer.tasks.comment' , $task->id) }}">
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
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($task->taskComments as $comment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $comment->comment }}</td>
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

    <div class="tab-content" id="module" style="display: none;" >
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr bgcolor="#f2f2f2">
                    <th align="left">Property</th>
                    <th align="left">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Name</b></td>
                    <td>{{ $task->module->name }}</td>
                </tr>
                <tr>
                    <td><b>Description</b></td>
                    <td>{{$task->module->description}}</td>
                </tr>
                <tr>
                    <td><b>Status</b></td>
                    <td>{{ $task->module->status }}</td>
                </tr>
            </tbody>
        </table>

        <div class="form">
            <form id="docForm" method="POST" action="{{ route('developer.module.documentation' , $task->module->id) }}">
                @csrf
                <input 
                    type="text" 
                    name="title" 
                    placeholder="Title"
                    value=""
                    required
                >
                <input 
                    type="text" 
                    name="version" 
                    placeholder="Version"
                    value=""
                    required
                >
                <button type="submit">Add Documentation</button>
                <div id="toolbar-container">
                    <span class="ql-formats">
                        <select class="ql-font"></select>
                        <select class="ql-size"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-color"></select>
                        <select class="ql-background"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-script" value="sub"></button>
                        <button class="ql-script" value="super"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-header" value="1"></button>
                        <button class="ql-header" value="2"></button>
                        <button class="ql-blockquote"></button>
                        <button class="ql-code-block"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-indent" value="-1"></button>
                        <button class="ql-indent" value="+1"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-direction" value="rtl"></button>
                        <select class="ql-align"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-link"></button>
                        <button class="ql-image"></button>
                        <button class="ql-video"></button>
                        <button class="ql-formula"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-clean"></button>
                    </span>
                    </div>
                    <div id="editor">
                    </div>
                <input type="hidden" name="content" id="content">
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Version</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($task->module->documentations as $doc)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $doc->title }}</td>
                        <td>{{ $doc->version }}</td>
                        <td>
                            <a target="_blank" href="{{route('developer.documentation.view' , $doc->id)}}" class="btn">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No Documentation found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="bugs" style="display: none;" >
        
    </div>

    <div class="tab-content" id="comments"  style="display: none;">
        
    </div>
</div>

@endsection

@section('script')
<script>
    const quill = new Quill('#editor', {
        modules: {
        syntax: true,
        toolbar: '#toolbar-container',
        },
        placeholder: 'Compose an epic...',
        theme: 'snow',
    });
    document.querySelector('#docForm').addEventListener('submit', function () {
        document.getElementById('content').value = quill.root.innerHTML;
    });
</script>
@endsection
