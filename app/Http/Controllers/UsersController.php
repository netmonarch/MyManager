<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Information;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function update(User $user)
        {
            
            $updates = [
            'name' => request()->name,
            'email' => request()->email
            ];

            $user->fill($updates);
            $user->save();

            
            $info_updates = [
                'first' => request()->first,
                'last' => request()->last,
                'city' => request()->city,
                'state' => request()->state,
                'zip' => request()->zip,
                'phone' => request()->phone
            ];
            DB::table('information')
                ->where('id', $user->id)
                ->update($info_updates);
            


            return back();

        }
}
