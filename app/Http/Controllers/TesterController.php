<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BugAttachmentModel;
use App\Models\BugCommentModel;
use App\Models\BugModel;
use App\Models\ModuleDocumentationModel;
use App\Models\ModuleModel;
use App\Models\ProjectModel;
use App\Models\TaskCommentsModel;
use App\Models\TaskModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TesterController extends Controller
{
    public function dashboard() {
        return view('tester.dashboard');
    }

    public function tasks() {
        $tasks = TaskModel::where('assigned_to' , Auth::id())
        ->with('module')
        ->get();
        return view('tester.tasks.listing' , compact('tasks'));
    }

    public function viewTask($task_id) {
        $task = TaskModel::with(['module' , 'taskComments'])->find($task_id);
        $bugs = BugModel::where('module_id', $task->module_id)
            ->with(['assignee', 'reporter'])
            ->latest()
            ->get();

        $developers = User::where('role' , 'developer')->where('manager_id' , Auth::user()->manager_id)->get();
        return view('tester.tasks.view' , compact('task' , 'bugs' ,'developers'));
    }

    public function addComment(Request $request , $task_id) {
        $comment = $request->input('comment');
        TaskCommentsModel::insert(['task_id' => $task_id, 'comment' => $comment , 'user_id' => Auth::id()]);
        return redirect()->back()->with('success' , 'Comment added');
    }


    public function viewDocumentation($doc_id) {
        $doc = ModuleDocumentationModel::find($doc_id);
        return $doc->content;
    }

    private function buildVisTree($modules, $parentId, &$nodes, &$edges)
    {
        foreach ($modules as $module) {

            $nodeId = 'module_'.$module->id;

            $nodes[] = [
                'id' => $nodeId,
                'label' => $module->name,
                'shape' => 'ellipse',
                'data' => [
                    'doc' => optional($module->documentation)->content,
                    'title' => optional($module->documentation)->title
                ]
            ];

            $edges[] = [
                'from' => $parentId,
                'to' => $nodeId
            ];

            if ($module->children->count()) {
                $this->buildVisTree(
                    $module->children,
                    $nodeId,
                    $nodes,
                    $edges
                );
            }
        }
    }


    public function viewProjectTree($project_id)
    {
        $project = ProjectModel::findOrFail($project_id);

        $modules = ModuleModel::where('project_id', $project_id)
            ->whereNull('parent_module_id')
            ->with(['children', 'documentation'])
            ->get();

        // Convert modules to vis.js nodes
        $nodes = [];
        $edges = [];

        $nodes[] = [
            'id' => 'project_'.$project->id,
            'label' => $project->name,
            'shape' => 'box',
            'color' => '#2c3e50',
            'font' => ['color' => '#fff']
        ];

        $this->buildVisTree(
            $modules,
            'project_'.$project->id,
            $nodes,
            $edges
        );

        return view('tester.projects.view', compact(
            'project',
            'nodes',
            'edges'
        ));
    }

    public function bugsStore(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'module_id'  => 'required|exists:modules,id',
            'title'      => 'required|string|max:255',
            'severity'   => 'required|in:minor,major,critical,blocker',
            'attachments.*' => 'file|max:5120', // 5MB each
        ]);

        // 1️⃣ Create Bug
        $bug = BugModel::create([
            'project_id' => $request->project_id,
            'module_id'  => $request->module_id,
            'reported_by' => Auth::id(),
            'assigned_to' => $request->assigned_to,
            'title' => $request->title,
            'description' => $request->description,
            'severity' => $request->severity,
            'status' => 'open',
            'steps_to_reproduce' => $request->steps_to_reproduce,
        ]);

        // 2️⃣ Handle attachments (if any)
        if ($request->hasFile('attachments')) {

            foreach ($request->file('attachments') as $file) {

                $path = $file->store('bug_attachments', 'public');

                BugAttachmentModel::create([
                    'bug_id' => $bug->id,
                    'uploaded_by' => Auth::id(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }

        return back()->with('success', 'Bug reported successfully');
    }

    public function bugsView(Request $request , $bug_id) {
        $bug = BugModel::
        with(['comments' , 'attachments' , 'assignee'])->
        find($bug_id);
        return view('tester.bugs.view' , compact('bug'));
    }

    public function addBugComment(Request $request , $bug_id) {
        $comment = $request->input('comment');
        BugCommentModel::insert(['bug_id' => $bug_id, 'comment' => $comment , 'user_id' => Auth::id()]);
        return redirect()->back()->with('success' , 'Comment added');
    }

}

