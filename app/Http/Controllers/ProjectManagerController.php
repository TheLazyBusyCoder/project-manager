<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BugCommentModel;
use App\Models\ModuleDocumentationModel;
use App\Models\ProjectModel;
use App\Models\BugModel;
use App\Models\ModuleModel;
use App\Models\TaskModel;
use App\Models\User;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectManagerController extends Controller
{
    public function dashboard() {
        return view('project_manager.dashboard');
    }

    public function developersIndex()
    {
        $pmId = Auth::id();

        $developers = User::where('role', 'developer')
            ->where('manager_id', $pmId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('project_manager.developers.index', compact('developers'));
    }

    public function developersStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        DB::beginTransaction();

        try {
            $pmId = Auth::id();

            $developer = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => bcrypt('password'), // temporary
                'role'       => 'developer',
                'status'     => 'active',
                'manager_id' => $pmId, // PM who created
            ]);

            // setup token
            $token = Str::random(64);

            DB::table('password_reset_tokens')->insert([
                'email'      => $developer->email,
                'token'      => $token,
                'created_at' => now(),
            ]);

            $setupLink = url('/setup-account?token=' . $token . '&email=' . urlencode($developer->email));

            // optional mail later
            // Mail::to($developer->email)->send(new DeveloperSetupMail($setupLink));

            DB::commit();

            return back()->with('success', 'Developer added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function developerView($developer_id)
    {
        $pmId = Auth::id();

        $developer = User::where('id', $developer_id)
            ->where('role', 'developer')
            ->where('manager_id', $pmId)
            ->firstOrFail();

        return view('project_manager.developers.view', compact('developer'));
    }

    public function developerDelete($developer_id)
    {
        $pmId = Auth::id();

        $developer = User::where('id', $developer_id)
            ->where('role', 'developer')
            ->where('manager_id', $pmId)
            ->firstOrFail();

        // Hard delete
        $developer->delete();

        return redirect()
            ->route('pm.developers')
            ->with('success', 'Developer deleted successfully.');
    }

    public function developersUpdate(Request $request, $developer_id)
    {
        $pmId = auth()->id();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $developer_id,
            'status' => 'required|in:active,inactive',
        ]);

        $developer = User::where('id', $developer_id)
            ->where('role', 'developer')
            ->where('manager_id', $pmId)
            ->firstOrFail();

        $developer->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Developer updated successfully.');
    }

    public function testersIndex()
    {
        $pmId = Auth::id();

        $testers = User::where('role', 'tester')
            ->where('manager_id', $pmId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('project_manager.testers.index', compact('testers'));
    }

    public function testersStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        DB::beginTransaction();

        try {
            $pmId = Auth::id();

            $tester = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => bcrypt('password'), // temporary
                'role'       => 'tester',
                'status'     => 'active',
                'manager_id' => $pmId,
            ]);

            // setup token
            $token = Str::random(64);

            DB::table('password_reset_tokens')->insert([
                'email'      => $tester->email,
                'token'      => $token,
                'created_at' => now(),
            ]);

            $setupLink = url('/setup-account?token=' . $token . '&email=' . urlencode($tester->email));

            // optional mail later
            // Mail::to($tester->email)->send(new TesterSetupMail($setupLink));

            DB::commit();

            return back()->with('success', 'Tester added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function testerView($tester_id)
    {
        $pmId = Auth::id();

        $tester = User::where('id', $tester_id)
            ->where('role', 'tester')
            ->where('manager_id', $pmId)
            ->firstOrFail();

        return view('project_manager.testers.view', compact('tester'));
    }

    public function testerDelete($tester_id)
    {
        $pmId = Auth::id();

        $tester = User::where('id', $tester_id)
            ->where('role', 'tester')
            ->where('manager_id', $pmId)
            ->firstOrFail();

        // Hard delete
        $tester->delete();

        return redirect()
            ->route('pm.testers')
            ->with('success', 'Tester deleted successfully.');
    }

    public function testersUpdate(Request $request, $tester_id)
    {
        $pmId = auth()->id();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $tester_id,
            'status' => 'required|in:active,inactive',
        ]);

        $tester = User::where('id', $tester_id)
            ->where('role', 'tester')
            ->where('manager_id', $pmId)
            ->firstOrFail();

        $tester->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Tester updated successfully.');
    }

    public function projectsIndex(Request $request) {
        $pmId = Auth::id();

        $projects = ProjectModel::where('project_manager_id', $pmId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('project_manager.projects.index' , compact('projects'));
    }

    public function projectCreate(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
        ]);

        ProjectModel::create([
            'project_manager_id' => Auth::id(), // or $request->user()->id
            'name'               => $request->name,
            'description'        => $request->description,
            'status'             => $request->status,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
        ]);

        return redirect()
            ->route('pm.projects')
            ->with('success', 'Project created successfully');
    }

    // private function moduleToJsTree($modules)
    // {
    //     return $modules->map(function ($module) {
    //         return [
    //             'id' => 'module_' . $module->id,
    //             'text' => $module->name,
    //             'a_attr' => [
    //                 'href' => route('pm.modules.view', $module->id)
    //             ],
    //             // 'state' => ['opened' => true],
    //             'children' => $this->moduleToJsTree($module->children)
    //         ];
    //     });
    // }

    private function moduleToJsTree($modules, $currentModuleId = -1)
    {
        return $modules->map(function ($module) use ($currentModuleId) {

            $isCurrent = $module->id == $currentModuleId;

            return [
                'id' => 'module_' . $module->id,
                'text' => $module->name,
                'a_attr' => [
                    'href' => route('pm.modules.view', $module->id)
                ],
                'state' => [
                    'opened'   => $this->hasCurrentInTree($module, $currentModuleId),
                    'selected' => $isCurrent
                ],
                'children' => $this->moduleToJsTree($module->children, $currentModuleId)
            ];
        });
    }

    private function hasCurrentInTree($module, $currentModuleId)
    {
        if ($module->id == $currentModuleId) {
            return true;
        }

        foreach ($module->children as $child) {
            if ($this->hasCurrentInTree($child, $currentModuleId)) {
                return true;
            }
        }

        return false;
    }



    public function projectView($project_id)
    {
        $project = ProjectModel::findOrFail($project_id);

        // Flat list (for table + select)
        $modules = ModuleModel::where('project_id', $project_id)->where('parent_module_id' , null)->get();

        // Tree (for sidebar)
        $rootModules = ModuleModel::where('project_id', $project_id)
            ->whereNull('parent_module_id')
            ->with('children')
            ->get();

        $treeData = $this->moduleToJsTree($rootModules);

        return view(
            'project_manager.projects.view',
            compact('project', 'modules', 'treeData')
        );
    }


    public function moduleCreate(Request $request, $project_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
            'parent_module_id' => 'nullable|exists:modules,id'
        ]);

        ModuleModel::create([
            'project_id'        => $project_id,
            'parent_module_id'  => $request->parent_module_id,
            'name'              => $request->name,
            'description'       => $request->description,
            'status'            => $request->status,
        ]);

        return back()->with('success', 'Module created successfully');
    }

    public function moduleCreateSub(Request $request, $module_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:not_started,in_progress,blocked,completed',
        ]);

        $parent = ModuleModel::findOrFail($module_id);

        ModuleModel::create([
            'project_id'       => $parent->project_id,
            'parent_module_id' => $parent->id,
            'name'             => $request->name,
            'description'      => $request->description,
            'status'           => $request->status,
        ]);

        return back()->with('success', 'Sub-module created successfully');
    }

    public function moduleView($module_id)
    {
        $module = ModuleModel::with('children')->findOrFail($module_id);

        $rootModules = ModuleModel::where('project_id', $module->project_id)
            ->whereNull('parent_module_id')
            ->with('children')
            ->get();

        $treeData = $this->moduleToJsTree($rootModules, $module_id);

        $modules = ModuleModel::where('parent_module_id', $module_id)->get();

        $developers = User::whereIn('role', ['developer', 'tester'])
            ->where('manager_id', Auth::id())
            ->get();

        $tasks = TaskModel::where('module_id' , $module_id)->get();

        $documentation = ModuleDocumentationModel::where('module_id' , $module_id)->first();

        $bugs = BugModel::where('module_id' , $module_id)->get();

        return view(
            'project_manager.projects.module.view',
            compact('module', 'modules', 'treeData' , 'developers' , 'tasks' , 'documentation' , 'bugs')
        );
    }

    public function viewTask($module_id, $task_id)
    {
        $module = ModuleModel::with('children')->findOrFail($module_id);

        $task = TaskModel::with('taskComments')->where('id', $task_id)
            ->where('module_id', $module_id)
            ->firstOrFail();

        $assigned_to = User::find($task->assigned_to);

        return view(
            'project_manager.projects.module.tasks.view',
            compact('module', 'task', 'assigned_to')
        );
    }

    public function taskStore(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'module_id'  => 'required|exists:modules,id',
            'title'      => 'required|string|max:255',
            'priority'   => 'required|in:low,medium,high,critical',
            'status'     => 'required|in:todo,in_progress,code_review,done',
        ]);

        DB::table('tasks')->insert([
            'project_id'      => $request->project_id,
            'module_id'       => $request->module_id,
            'assigned_to'     => $request->assigned_to,
            'created_by'      => Auth::id(),
            'title'           => $request->title,
            'description'     => $request->description,
            'priority'        => $request->priority,
            'status'          => $request->status,
            'estimated_hours' => $request->estimated_hours,
            'due_date'        => $request->due_date,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return back()->with('success', 'Task created successfully');
    }

    public function bugsView($bug_id) {
        $bug = BugModel::
        with(['comments' , 'attachments' , 'assignee'])->
        find($bug_id);
        return view('project_manager.bugs.view' , compact('bug'));
    }

    public function addBugComment(Request $request , $bug_id) {
        $comment = $request->input('comment');
        BugCommentModel::insert(['bug_id' => $bug_id, 'comment' => $comment , 'user_id' => Auth::user()->id]);
        return redirect()->back()->with('success' , 'Comment added');
    }
}
