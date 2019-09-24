<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project;
use App\Task;
use Carbon\Carbon;

class TasksController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$task = new Task;
		
		$task->name = $request->taskName;
		$task->desc = "";
		$task->owner = auth()->id();
		$task->parent = $request->taskParent;
		$task->due = Carbon::now();
		$task->save();
		
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view ("angular-layouts.show-task-modal", ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
		
        return view ("angular-layouts.edit-task-modal", ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task, Request $request)
    {
		//$task->complete(request()->has('completed'));
		// Start here
		if (request()->modal == true)
		{
			$updates = [
			'name' => $request->name
			];
			
			// for whatever reason, I cannot update multiple rows. Do more research on a fix in future projects.
			DB::table('tasks')->where ('id', $task->id)->update (['desc' => $request->desc]);
			
			$task->fill($updates);
			$task->save();
			
			
		} else {
			
			if (request()->completed == true)
			{
				
				$task->update ([
					'status' => 1
				]);
			
			} else {  
				
				$task->update ([
					'status' => 0
				]);
			}
		}
		
		request()->session()->flash ('status', 'Task has been updated');
		return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        
    }
}


