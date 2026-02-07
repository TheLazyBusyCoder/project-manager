

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
            <form method="POST" action="{{ route('tester.tasks.comment' , $task->id) }}">
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
        <div>
            <a class="btn" target="_blank" href="{{route('tester.project.view' , $task->module->project_id)}}">View Full Project</a>
            <a class="btn" target="_blank" href="{{route('tester.documentation.view' , $task->module->documentation->id)}}">View Documentation</a>
        </div>

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
            <form id="docForm">
                <input 
                    type="text" 
                    name="title" 
                    placeholder="Title"
                    value="{{$task->module->documentation->title}}"
                    readonly
                >
                <input 
                    type="text" 
                    name="version" 
                    placeholder="Version"
                    value="{{$task->module->documentation->version}}"
                    readonly
                >
                <div id="editor">
                </div>
            </form>
        </div>
    </div>

    <div class="tab-content" id="bugs" style="display: none;">
        <!-- Add Bug -->
        <div class="card">
            <h3>Report Bug</h3>
            <form method="POST" 
                action="{{ route('tester.bugs.store') }}" 
                enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="project_id" value="{{ $task->module->project_id }}">
                <input type="hidden" name="module_id" value="{{ $task->module->id }}">

                <div class="actions">
                    <input class="form-control" name="title" placeholder="Bug title" required>
                </div>

                <div class="actions">
                    <textarea class="form-control" name="description" placeholder="Description"></textarea>
                    <textarea class="form-control" name="steps_to_reproduce" placeholder="Steps to reproduce"></textarea>
                </div>

                <div class="actions">
                    <select name="severity" class="form-control">
                        <option value="minor">Minor</option>
                        <option value="major">Major</option>
                        <option value="critical">Critical</option>
                        <option value="blocker">Blocker</option>
                    </select>

                    <select name="assigned_to" class="form-control">
                        <option value="">Unassigned</option>
                        @foreach($developers as $dev)
                            <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 🔥 Attachments -->
                <div class="actions">
                    <input type="file" 
                        name="attachments[]" 
                        multiple 
                        class="form-control">
                    <small>Attach screenshots, logs, or files</small>
                </div>

                <button class="btn">Report Bug</button>
            </form>
        </div>
        <!-- Bug List -->
        <div class="card">
            <h3>Reported Bugs</h3>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th>Attachments</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($task->module->bugs as $bug)
                        <tr>
                            <td>{{ $bug->title }}</td>
                            <td>{{ ucfirst($bug->severity) }}</td>
                            <td>{{ ucfirst(str_replace('_',' ', $bug->status)) }}</td>
                            <td>{{ optional($bug->assignee)->name ?? '—' }}</td>
                            <td>
                                @forelse($bug->attachments as $file)
                                    <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">
                                        {{ basename($file->file_path) }}
                                    </a><br>
                                @empty
                                    —
                                @endforelse
                            </td>
                            <td>
                                <a href="{{route('tester.bugs.view' , $bug->id)}}" class="btn">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No bugs reported.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
    quill.root.innerHTML = @json($task->module->documentation->content ?? '');
</script>
@endsection
