<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Information;
use App\Project;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function Projects()
	{
		 // Try to make this an eloquent relationship later.
		 // Experienced issues that would return an empty array
		 // when accessing via $this->hasMany(Project::class)
		 
		$myprojects = DB::table('projects')->where('owner', auth()->id())->latest()->paginate(9);
		$this->hasMany(Project::class);
		return $myprojects;
	}
	
	public function Information ($id)
	{
		return DB::table('information')->where('id', $id)->first();
	}
}
