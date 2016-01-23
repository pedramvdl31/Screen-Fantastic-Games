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
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Admin;
use App\Role;
use App\RoleUser;
use App\Project;
use App\Permission;
use App\PermissionRole;
use App\Task;
use App\Tax;
use App\TaskComment;
use App\Helpers\UploadHelper;

class TaxesController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $taxes = Tax::PrepareTaxesForIndex(Tax::all());

        return view('taxes.index')
            ->with('layout',$this->layout)
            ->with('taxes',$taxes);
    }
    /**
     * Adds a task 
     *
     * @return Response
     */
    public function getAdd()
    {
        $kr_cities = Job::StatesOfKoreaForSelect();
        $country_code = Job::country_code();


        return view('taxes.add')
            ->with('layout',$this->layout)
            ->with('country_code',$country_code)
            ->with('kr_cities',$kr_cities);
    }  
    /**
     * Process Task Request
     *
     * @return Response
     */
    public function postAdd()
    {       

        $validator = Validator::make(Input::all(), Tax::$rule_add);
        if ($validator->passes()) {
            $title = Input::get('title');
            $description = Input::get('description');
            $city = Input::get('city');
            $country = Input::get('country');
            $rate = Input::get('rate');

            $taxes_data = new Tax;
            $taxes_data->title = $title;
            $taxes_data->description = $description;
            $taxes_data->city = $city;
            $taxes_data->country = $country;
            $taxes_data->rate = $rate;
            $taxes_data->status = 1;
            if ($taxes_data->save()) {
                 Flash::success('Successfully added!');
                 return Redirect::route('taxes_index');
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
    /**
     * /admins/tasks/edit.
     * @param $id - task_id
     * @return Response
     */
    public function getEdit($id = null)
    {
        if (isset($id)) {
            $kr_cities = Job::StatesOfKoreaForSelect();
            $country_code = Job::country_code();
            $taxes = Tax::find($id);
            $status = Tax::PrepareStatusForSelect();
                return view('taxes.edit')
                ->with('layout',$this->layout)
                ->with('country_code',$country_code)
                ->with('kr_cities',$kr_cities)
                ->with('status',$status)
                ->with('taxes',$taxes);
        } else {
            Redirect::back();
        }
    } 
    /**
     * Process Task Edit Request
     *
     * @return Response
     */
    public function postEdit()
    {
       $validator = Validator::make(Input::all(), Tax::$rule_add);
        if ($validator->passes()) {
            $title = Input::get('title');
            $description = Input::get('description');
            $city = Input::get('city');
            $country = Input::get('country');
            $rate = Input::get('rate');
            $id = Input::get('id');
            $status = Input::get('status');

            $taxes_data = Tax::find($id);
            $taxes_data->title = $title;
            $taxes_data->description = $description;
            $taxes_data->city = $city;
            $taxes_data->country = $country;
            $taxes_data->rate = $rate;
            $taxes_data->status = $status;
            if ($taxes_data->save()) {
                 Flash::success('Successfully added!');
                 return Redirect::route('taxes_index');
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
    /**
     * /admins/tasks/view.
     * @param $id - task_id
     * @return Response
     */
    public function getView($id = null)
    {

    } 

}
