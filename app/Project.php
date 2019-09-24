<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $guarded = [
	
	];
	
	public function owner()
	{
		
		return $this->belongsTo('App\User')->first();
	}
	
	public static function Tasks ($id)
	{
		$all = DB::table('tasks')->where('parent', $id)->get(); 
		return $all;
	}
	
	public static function UsersOnProject ($id)
	{
		$all = DB::table('assigned')->where('project_id', $id)->get();
		return $all;
	}
	
	public function addTask ($tasksRows)
	{
		
	}
}
