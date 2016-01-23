<?php
namespace App\Http\Controllers;

use Input;
use Validator;
use Redirect;
use Hash;
use Request;
use Route;
use Response;
use Auth;
use URL;
use Session;
use Laracasts\Flash\Flash;
use View;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Admin;
use App\Role;
use App\Permission;
use App\PermissionRole;

class PermissionRolesController extends Controller
{
    public function __construct() {

       if (Auth::user()) {
            switch (Auth::user()->roles) {
                case 1:
                    $this->layout = 'layouts.admins';
                    break;
                case 2:
                    $this->layout = 'layouts.admins';
                    break;
                case 3:
                    $this->layout = 'layouts.admins_simple';
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }
    public function getIndex()
    {   
        $per_roles = PermissionRole::all();
        $output = [];
        $roles_array = [];
        foreach ($per_roles as $prkey => $prvalue) {
            $role = Role::find($prvalue->role_id);
            if (isset($role)) {
                $roles_array[$role->role_title] = $role->role_title;
                $permission = Permission::find($prvalue->permission_id);
                if (isset($permission)) {
                    $output[$role->role_title][$prvalue->id] = $permission->permission_slug;
                }
            }

        }
        return view('permission_roles.index')
        ->with('layout',$this->layout)
        ->with('output',$output)
        ->with('roles_array',$roles_array);
    }

    public function getAdd()
    {   

        $per_roles = PermissionRole::all();
        $output = [];
        $roles_array = [];
        foreach ($per_roles as $prkey => $prvalue) {
            $role = Role::find($prvalue->role_id);
            if (isset($role)) {
                $roles_array[$role->role_title] = $role->role_title;
                $permission = Permission::find($prvalue->permission_id);
                if (isset($permission)) {
                    $output[$role->role_title][$prvalue->id] = $permission->permission_slug;
                }
            }
        }     


        $permissions = Permission::PerpareAllForSelect();
        $roles = Role::PerpareAllForSelect();
        return view('permission_roles.add')
        ->with('layout',$this->layout)
        ->with('permissions',$permissions)
        ->with('roles',$roles)
        ->with('output',$output)
        ->with('roles_array',$roles_array);
    }
    //PERMISISON ROLE
    public function postAdd()
    {
        $permission = Input::get('permission_id');
        $role = Input::get('role_id');
        $perm_count = count(PermissionRole::
            where('permission_id',$permission)
            ->where('role_id',$role)
            ->get());
        $validator = Validator::make(Input::all(), Admin::$add_permission_role);
        if ($validator->passes()) {
            if ($perm_count == 0) {
                if ($permission == "-999") {
                   $all_permissions = Permission::all();
                   foreach ($all_permissions as $alkey => $alvalue) {
                    $all_p_count = count(PermissionRole::where('permission_id',$alvalue->id)
                        ->where('role_id',$role)
                        ->get());
                       if ($all_p_count == 0) {
                        $permission_role = new PermissionRole;
                        $permission_role->permission_id = $alvalue->id;
                        $permission_role->role_id = $role;
                        $permission_role->save();
                        }  
                   }
                } else if ($role == "-999") {//ALL
                    $all_roles = Role::all();
                    foreach ($all_roles as $arkey => $arvalue) {
                        $all_count = count(PermissionRole::
                            where('permission_id',$permission)
                            ->where('role_id',$arvalue->id)
                            ->get());
                        if ($all_count == 0) {
                            $permission_role = new PermissionRole;
                            $permission_role->permission_id = $permission;
                            $permission_role->role_id = $arvalue->id;
                            $permission_role->save();
                        }
                        else {
                            Flash::error('Duplicate Entry');
                        }
                    }
                } else {
                    $permission_role = new PermissionRole;
                    $permission_role->permission_id = $permission;
                    $permission_role->role_id = $role;
                    if ($permission_role->save()) {
                        return Redirect::action('PermissionRolesController@getAdd');
                    }  
                }
                return Redirect::action('PermissionRolesController@getAdd');
            } else {
                Flash::error('Duplicate Entry');
                return Redirect::action('PermissionRolesController@getAdd');
            }
        }
        else {
            // validation has failed, display error messages    
            return Redirect::back()
            ->with('message', 'The following errors occurred')
            ->with('alert_type','alert-danger')
            ->withErrors($validator)
            ->withInput();  
        } 
    }
    public function getEdit($id = null)
    {   
        $p_role = PermissionRole::find($id);

        $permissions = Permission::PerpareAllForSelect();
        $roles = Role::PerpareAllForSelect();

        return view('permission_roles.edit')
        ->with('layout',$this->layout)
        ->with('p_role',$p_role)
        ->with('permissions',$permissions)
        ->with('roles',$roles);

    }
    //PERMISISON ROLE
    public function postEdit()
    {
        $pre_roles = PermissionRole::find(Input::get('id'));
        $pre_roles->permission_id = Input::get('permission_id');
        $pre_roles->role_id = Input::get('role_id');

        if ($pre_roles->save()) {
            return Redirect::action('PermissionRolesController@getIndex');
        }

    }

    public function getDelete($id = null)
    {   
        $pre_roles = PermissionRole::find($id);
        if ($pre_roles->delete()) {
            return Redirect::action('PermissionRolesController@getIndex');
        }
    }
}
