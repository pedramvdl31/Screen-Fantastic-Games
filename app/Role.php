<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * many-to-many relationship method.
     *
     * @return QueryBuilder
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }


    public static function PerpareAllForSelect() {
        $data = Role::get();
        
        $roles = array(''=>'Select Role');
        $roles['-999'] = 'All';
        if(isset($data)) {
            foreach ($data as $key => $value) {
                
                $roles_id = $value['id'];
                $roles_title = $value['role_title'];
                $roles[$roles_id] = $roles_title; 
            }

        }
        return $roles;
    }
    public static function PerpareAdminRoleSelect() {
        $data = Role::get();
        
        $roles = [];
        if(isset($data)) {
            foreach ($data as $key => $value) {
                
                $roles_id = $value['id'];
                $roles_title = $value['role_title'];
                $roles[$roles_id] = $roles_title; 
            }

        }
        return $roles;
    }
    public static function PerpareRolesForSelect() {
        $roles = array( '1' => 'Superadmins',
                        '2' => 'Admins',
                        '3' => 'Admins (Simple)',
                        '4' => 'Employees',
                        '5' => 'Users',
                        '6' => 'Guests'
                        );
        

        return $roles;
    }        
    public static function PerpareRoleslugsForSelect() {
        $roles = array( '1' => 'superadmins',
                        '2' => 'admins',
                        '3' => 'admins',
                        '4' => 'employees',
                        '5' => 'users',
                        '6' => 'guests'
                        );
        

        return $roles;
    }        

    public static function AutoFillRoles() {
        $make = false;
        $var = null;
        for ($i=1; $i <= 5 ; $i++) { 
            $var = Role::find($i);
            if (!isset($var)) {
                $make = true;
                break;
            }
        }

        if ($make == true) {
            $all_roles = Role::PerpareRolesForSelect();
            $all_roles_slug = Role::PerpareRoleslugsForSelect();

            foreach ($all_roles as $key => $value) {
                $this_role = new Role();
                $this_role->role_title = $value;
                $this_role->role_slug = $all_roles_slug[$key];
                $this_role->save();
            }
        }

    }

    
}