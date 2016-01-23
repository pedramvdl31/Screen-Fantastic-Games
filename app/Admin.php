<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Job;
use App\RoleUser;
use App\User;
class Admin extends Model
{
    public static $add_roles = array(
        'role-title'=>'required',
        'role-slug'=>'required'
    );
    public static $add_permission = array(
        'permission-title'=>'required',
        'permission-slug'=>'required',
        'permission-description'=>'required'
    );

    public static $add_permission_role = array(
        'permission_id'=>'required',
        'role_id'=>'required'
    );

    public static function getApprovedAdmins() {
        $admins = [''=>'Select Administrator'];
        $roles = 2; //Anything below this number we will allow to set tasks
        $approved = RoleUser::where('role_id', '<=', $roles)->get();
        if($approved) {
            foreach ($approved as $a) {
                $user_id = $a->user_id;
                $users = User::find($user_id);
                $admins[$user_id] = $users->username;
            }
        }

        return $admins;
    }
}