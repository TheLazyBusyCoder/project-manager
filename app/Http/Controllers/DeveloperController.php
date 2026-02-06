<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ModuleDocumentationModel;
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
        return view('developer.tasks.view' , compact('task'));
    }

    public function addComment(Request $request , $task_id) {
        $comment = $request->input('comment');
        TaskCommentsModel::insert(['task_id' => $task_id, 'comment' => $comment , 'user_id' => Auth::id()]);
        return redirect()->back()->with('success' , 'Comment added');
    }

    public function addModuleDocumentation(Request $request , $module_id) {

        ModuleDocumentationModel::insert([
            'module_id' => $module_id,
            'written_by' => Auth::id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'version' => $request->input('version'),
        ]);
        return redirect()->back()->with('success' , 'Documentation created');
    }

    public function viewDocumentation($doc_id) {
        $doc = ModuleDocumentationModel::find($doc_id);
        return $doc->content;
    }
}
