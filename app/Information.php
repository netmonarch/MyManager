<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    public function owner()
	{
		return $this->belongsTo(User::class);
	}
	
	public function infoArray($given)
	{
		return DB::table("information")->where('id', $given)->first();
	}
}
