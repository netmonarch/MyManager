<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
		'name', 'status'
	];
	
	
	public function Project ()
	{
		return $this->belongsTo(Project::class);
	}
	
	public function complete ($completed)
	{
		$this->update(compact('completed'));
	}
	
	public function incomplete ()
	{
		$this->status ('incomplete');
	}
}
