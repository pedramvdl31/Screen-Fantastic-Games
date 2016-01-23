<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    public static function GetUserRoleId($id)
    {
    	$role_users = RoleUser::where('user_id',$id)->first();
        return $role_users->role_id;
    }
}
