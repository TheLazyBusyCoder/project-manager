@section('title', 'Developer Details')
@extends('layout.project_manager-layout')

@section('head')
<link rel="stylesheet" href="{{ asset('css/vis.min.css') }}">
<script src="{{ asset('js/vis.min.js') }}"></script>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
@endsection

@section('sidebar')
@include('partials.sidebar')
@endsection

@section('main')
<div class="container py-3">

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3">
        @foreach([
            'details' => 'Details',
            'list' => 'Sub Modules',
            'create' => 'Create Sub Module',
            'tasks' => 'Tasks',
            'createTask' => 'Create Task',
            'viewDocumentation' => 'Documentation',
            'viewBugs' => 'Bugs'
        ] as $id => $label)
            <li class="nav-item">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#{{ $id }}">
                    {{ $label }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">

        {{-- DETAILS --}}
        <div class="tab-pane fade show active" id="details">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered mb-0">
                        <tr><th>Module Name</th><td>{{ $module->name }}</td></tr>
                        <tr><th>Status</th><td>{{ $module->status }}</td></tr>
                        <tr><th>Description</th><td>{{ $module->description }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- SUB MODULES --}}
        <div class="tab-pane fade" id="list">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th><th>Name</th><th>Status</th><th>Created</th><th>Action</th>
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
                                <a href="{{ route('pm.modules.view', $child->id) }}" class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">No modules created yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CREATE SUB MODULE --}}
        <div class="tab-pane fade" id="create">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('pm.modules.create.sub', $module->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Module Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="blocked">Blocked</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <button class="btn btn-outline-secondary btn-sm">Create Module</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- TASKS --}}
        <div class="tab-pane fade" id="tasks">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th><th>Title</th><th>Priority</th><th>Status</th>
                            <th>Assigned To</th><th>Due</th><th>Created</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ ucfirst($task->priority) }}</td>
                            <td>{{ str_replace('_',' ', ucfirst($task->status)) }}</td>
                            <td>{{ optional($task->assignedUser)->name ?? 'Unassigned' }}</td>
                            <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '-' }}</td>
                            <td>{{ $task->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('pm.tasks.view', [ $module->id , $task->id]) }}"
                                   class="btn btn-sm btn-outline-primary">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center">No tasks created yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CREATE TASK --}}
        <div class="tab-pane fade" id="createTask">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('pm.tasks.store') }}">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $module->project_id }}">
                        <input type="hidden" name="module_id" value="{{ $module->id }}">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Assign To</label>
                                <select name="assigned_to" class="form-select">
                                    <option value="">Unassigned</option>
                                    @foreach($developers as $dev)
                                        <option value="{{ $dev->id }}">{{ $dev->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="todo">To Do</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="code_review">Code Review</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control">
                            </div>
                        </div>

                        <button class="btn btn-success mt-3">Create Task</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- DOCUMENTATION --}}
        <div class="tab-pane fade" id="viewDocumentation">
            @if ($documentation)
                <p><strong>{{ $documentation->title }}</strong> (v{{ $documentation->version }})</p>
                <div id="editor"></div>
            @else
                <p>No documentation has been created for this module.</p>
            @endif
        </div>

        {{-- BUGS --}}
        <div class="tab-pane fade" id="viewBugs">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th><th>Severity</th><th>Status</th>
                                <th>Reporter</th><th>Attachments</th><th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bugs as $bug)
                            <tr>
                                <td>{{ $bug->title }}</td>
                                <td>{{ ucfirst($bug->severity) }}</td>
                                <td>{{ ucfirst(str_replace('_',' ', $bug->status)) }}</td>
                                <td>{{ optional($bug->reporter)->name ?? '—' }}</td>
                                <td>
                                    @forelse($bug->attachments as $file)
                                        <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">
                                            {{ basename($file->file_path) }}
                                        </a><br>
                                    @empty — @endforelse
                                </td>
                                <td>
                                    <a href="{{ route('pm.bugs.view', $bug->id) }}"
                                       class="btn btn-sm btn-outline-primary">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center">No bugs reported.</td></tr>
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
    theme: 'snow',
    modules: { syntax: true }
});
quill.root.innerHTML = @json($documentation->content ?? '');
</script>
@endsection
