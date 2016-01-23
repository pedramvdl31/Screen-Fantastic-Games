<?php 
namespace App;
use Route;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /*
    |--------------------------------------------------------------------------
    | Relationship Methods
    |--------------------------------------------------------------------------
    */

    /**
     * many-to-many relationship method
     *
     * @return QueryBuilder
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public static function PerpareAllForSelect() {
        $data = Permission::get();
        $permissions = array(''=>'Select Permission');
        $permissions['-999'] = 'All';
        if(isset($data)) {
            foreach ($data as $key => $value) {
                $permissions_id = $value['id'];
                $permissions_title = $value['permission_title'];
                $permissions[$permissions_id] = $permissions_title; 
            }
        }
        return $permissions;
    }


    public static function PrepareAllRouteForSelect() {
        $created_permissions = Permission::all();  
        $name = Route::getRoutes();
        $routeCollection = Route::getRoutes();
        $controller_names = [];
        foreach ($routeCollection as $key => $value) {
            //KEEP THE NAME OF THE ROUTE
            $controller_names[$key] = $value->getPath();
        }   
        //TAKE OUT DUPLICATE AND REINDEX
        $new_controller_names = array_values(array_unique($controller_names));

        $permissions_r = array(''=>'Select Permission');
        if(isset($new_controller_names)) {
            foreach ($new_controller_names as $key => $value) {
                $check_slug = false;
                foreach ($created_permissions as $cp) { // Check to see if the slug matches anything from db
                    if($cp->permission_slug == $value) {
                        $check_slug = true;
                        break;
                    }
                }   
                if($check_slug == false) { // Only add in the new row if there is not a match
                    $permissions_r[$value] = $value; 
                }
                
            }
        }
        return $permissions_r;
    }

}