@section('title', 'Developer')
@extends('layout.developer-layout')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
    <style>
        #editor .ql-editor {
            min-height: 300px;
        }
    </style>
@endsection

@section('main')
    <div class="container-fluid">

        <h4 class="mb-3">My Task</h4>
        <p class="text-muted">Manage and track all your tasks.</p>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="taskTabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#task">Task</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#module">Module</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bugs">Bugs</button>
            </li>
        </ul>

        <div class="tab-content">

            <!-- TASK -->
            <div class="tab-pane fade show active" id="task">
                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Title</th>
                                    <td>{{ $task->title }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $task->description }}</td>
                                </tr>
                                <tr>
                                    <th>Priority</th>
                                    <td>{{ $task->priority }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $task->status }}</td>
                                </tr>
                                <tr>
                                    <th>Estimated Hours</th>
                                    <td>{{ $task->estimated_hours }}</td>
                                </tr>
                                <tr>
                                    <th>Due Date</th>
                                    <td>{{ $task->due_date }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $task->created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form method="POST" action="{{ route('developer.tasks.comment', $task->id) }}" class="mb-4">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="comment" class="form-control" placeholder="Add a comment" required>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Comment</th>
                            <th>Commented By</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($task->taskComments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $comment->comment }}</td>
                                <td>{{ $comment->user->name }}</td>
                                <td>{{ $comment->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No comments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- MODULE -->
            <div class="tab-pane fade" id="module">
                <div class="mb-3">
                    <a class="btn btn-outline-primary me-2" target="_blank"
                        href="{{ route('developer.project.view', $task->module->project_id) }}">
                        View Project
                    </a>
                    @if ($task->module->documentation)
                        <a class="btn btn-outline-secondary" target="_blank"
                            href="{{ route('developer.documentation.view', $task->module->documentation->id) }}">
                            View Documentation
                        </a>
                    @endif
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $task->module->name }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $task->module->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $task->module->status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <form id="docForm" method="POST"
                    action="{{ route('developer.module.documentation', $task->module->id) }}">
                    @csrf

                    <div class="row g-2 mb-2">
                        <div class="col">
                            <input class="form-control" name="title" placeholder="Title"
                                value="{{ $task->module->documentation->title ?? '' }}" required>
                        </div>
                        <div class="col">
                            <input class="form-control" name="version" placeholder="Version"
                                value="{{ $task->module->documentation->version ?? '' }}" required>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success">Save</button>
                        </div>
                    </div>

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

            <!-- BUGS -->
            <div class="tab-pane fade" id="bugs">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Severity</th>
                                    <th>Status</th>
                                    <th>Reporter</th>
                                    <th>Attachments</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($task->module->bugs->where('assigned_to', Auth::id()) as $bug)
                                    <tr>
                                        <td>{{ $bug->title }}</td>
                                        <td>{{ ucfirst($bug->severity) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $bug->status)) }}</td>
                                        <td>{{ optional($bug->reporter)->name ?? '—' }}</td>
                                        <td>
                                            @forelse($bug->attachments as $file)
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                                    {{ basename($file->file_path) }}
                                                </a><br>
                                            @empty —
                                            @endforelse
                                        </td>
                                        <td>
                                            <a href="{{ route('developer.bugs.view', $bug->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No bugs assigned</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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
    document.querySelector('#docForm').addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML;
    });
</script> @endsection
