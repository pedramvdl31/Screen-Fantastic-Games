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

class PermissionsController extends Controller
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
            $permissions = Permission::all();
            $perm = []; // Start the output

            foreach ($permissions as $key => $value) {
                $idx = 0;
                $permission_roles = PermissionRole::where('permission_id',$value->id)->get();
                if($permission_roles){
                    foreach ($permission_roles as $prkey => $prvalue) {
                        $idx++;
                        $roles = Role::find($prvalue->role_id);
                        $perm[$key][$idx] = $roles->role_title;
                    }
                }
            }
            if(count($perm) > 0){
                foreach ($perm as $permkey => $permvalue) {
                    $permissions[$permkey]['role_list'] = $permvalue;
                }
            }

            return view('permissions.index')
            ->with('layout',$this->layout)
            ->with('permissions',$permissions);
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


        $saved_permissions = Permission::all();
        $all_routes = Permission::PrepareAllRouteForSelect();
        return view('permissions.add')
            ->with('layout',$this->layout)
            ->with('all_routes',$all_routes)
            ->with('permissions',$saved_permissions);
    }
    
    public function postAdd()
    {   
        $validator = Validator::make(Input::all(), Admin::$add_permission);
        if ($validator->passes()) {
            $title = Input::get('permission-title');
            $slug = Input::get('permission-slug');
            $description = Input::get('permission-description');
            $permissions = new Permission;
            $permissions->permission_title = $title;
            $permissions->permission_slug = $slug;
            $permissions->permission_description = $description;
            if ($permissions->save()) {
                $all_routes = Permission::PrepareAllRouteForSelect();
                return view('permissions.add')
                    ->with('layout',$this->layout)
                    ->with('all_routes',$all_routes)
                    ->with('message_feedback','Successfully Added');
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
            $per = Permission::find($id);
            return view('permissions.edit')
                ->with('layout',$this->layout)
                ->with('permissions',$per);
        }
     public function postEdit()
        {   
            $per = Permission::find(Input::get('id'));
            $per->permission_title = Input::get('title');
            $per->permission_slug = Input::get('slug');
            $per->permission_description = Input::get('description');

            if ($per->save()) {
                return Redirect::action('PermissionsController@getIndex');
            }
        }
        public function getAutoUpdate()
    {   
        $saved_permissions = Permission::all();
        $all_routes = Permission::PrepareAllRouteForSelect();

        foreach ($all_routes as $key => $value) {
            if ($value != 'Select Permission') {
                $permissions = new Permission;
                $permissions->permission_title = $value;
                $permissions->permission_slug = $value;
                $permissions->permission_description = $value.' route';
                $permissions->save();
            }
        }
        Flash::success('Successfully Updated Permissions list');
        return Redirect::back();
    }

    public function getDelete($id = null)
    {   
        $pre_roles = Permission::find($id);
        if ($pre_roles->delete()) {
            return Redirect::action('PermissionsController@getIndex');
        }
    }
}
