<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BugCommentModel;
use App\Models\BugModel;
use App\Models\ModuleDocumentationModel;
use App\Models\ModuleModel;
use App\Models\ProjectModel;
use App\Models\TaskCommentsModel;
use App\Models\TaskModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperController extends Controller
{
    public function dashboard() {
        return view('developer.dashboard');
    }

    public function tasks() {
        $tasks = TaskModel::where('assigned_to' , Auth::id())
        ->with('module')
        ->get();
        return view('developer.tasks.listing' , compact('tasks'));
    }

    public function viewTask($task_id) {
        $task = TaskModel::with(['module' , 'taskComments'])->find($task_id);
        // $bugs = BugModel::where('module_id', $task->module_id)
        //     ->with(['assignee', 'reporter'])
        //     ->latest()
        //     ->get();
        return view('developer.tasks.view' , compact('task'));
    }

    public function addComment(Request $request , $task_id) {
        $comment = $request->input('comment');
        TaskCommentsModel::insert(['task_id' => $task_id, 'comment' => $comment , 'user_id' => Auth::id()]);
        return redirect()->back()->with('success' , 'Comment added');
    }

    public function addModuleDocumentation(Request $request, $module_id)
    {
        ModuleDocumentationModel::updateOrCreate(
            // condition to find the record
            ['module_id' => $module_id],

            // values to update or insert
            [
                'written_by' => Auth::id(),
                'title'      => $request->input('title'),
                'content'    => $request->input('content'),
                'version'    => $request->input('version'),
            ]
        );

        return redirect()->back()->with('success', 'Documentation saved successfully');
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

        return view('developer.projects.view', compact(
            'project',
            'nodes',
            'edges'
        ));
    }

    public function bugsView(Request $request , $bug_id) {
        $bug = BugModel::
        with(['comments' , 'attachments' , 'assignee'])->
        find($bug_id);
        return view('developer.bugs.view' , compact('bug'));
    }

    public function addBugComment(Request $request , $bug_id) {
        $comment = $request->input('comment');
        BugCommentModel::insert(['bug_id' => $bug_id, 'comment' => $comment , 'user_id' => Auth::id()]);
        return redirect()->back()->with('success' , 'Comment added');
    }

}

