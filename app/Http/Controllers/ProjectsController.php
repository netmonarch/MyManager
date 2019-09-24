<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Project;
use App\Task;
use App\Information;
use Carbon\Carbon;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
		$fetchAll = DB::table('users')->get();
        return view ("createProject", ['user' => $user, 'users' => $fetchAll]);
    }
	
	public function angularRequest (Project $project)
	{
		return view ("angular-layouts.project-modal", ['projects' => $project]);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$now = Carbon::now();
		
		$requestOBJ = json_decode ($request->projectJSON);
		
		$row = Project::create ([
		'name' => $requestOBJ->projectName,
		'desc' => $requestOBJ->projectDesc,
		'owner' => auth()->id(),
		'view' => 'public',
		'due' => $now->toDateTimeString()
		]);
		
		
		
		foreach ($requestOBJ->projectTasks as $tasks)
		{
			// Noted error trying to insert tasks the same way one inserts a project.
			$task = new Task();

			$task->name= $tasks->name;
			$task->desc = $tasks->description;
			$task->status = 'incomplete';
			$task->owner = auth()->id();
			$task->parent = $row->id;
			$task->due = $now->toDateTimeString();
			
			$task->save();
		}
		
		foreach ($requestOBJ->projectUsers as $users)
		{
			DB::table ('assigned')->insert([
			'user_id' => $users->id,
			'project_id' => $row->id
			]);
		}
		
		
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$project = Project::find($id);
        return view ("angular-layouts.project-modal", ['project'=>$project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
		$assigned = DB::table("assigned")->where('project_id', $project->id)->get();
		
		return view ("edit", ['project' => $project, 'assigned' => $assigned]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
		return back();
    }
}
