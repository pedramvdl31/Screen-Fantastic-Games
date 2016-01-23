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
use App\Tag;
use App\TaskComment;
use App\Helpers\UploadHelper;

class TagsController extends Controller
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
        $tags = Tag::PrepareTagsForIndex(Tag::all());
        return view('tags.index')
            ->with('layout',$this->layout)
            ->with('tags',$tags);

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


        return view('tags.add')
            ->with('layout',$this->layout);
    }  
    /**
     * Process Task Request
     *
     * @return Response
     */
    public function postAdd()
    {       

        $validator = Validator::make(Input::all(), Tag::$rule_add);
        if ($validator->passes()) {
            $title = Input::get('title');
            $description = Input::get('description');
            $tags_data = new Tag;
            $tags_data->title = $title;
            $tags_data->description = $description;
            if ($tags_data->save()) {
                 Flash::success('Successfully added!');
                 return Redirect::route('tags_index');
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
            $tags = Tag::find($id);
            $status = Tag::PrepareStatusForSelect();
                return view('tags.edit')
                ->with('layout',$this->layout)
                ->with('status',$status)
                ->with('tags',$tags);
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
       $validator = Validator::make(Input::all(), Tag::$rule_add);
        if ($validator->passes()) {
            $title = Input::get('title');
            $description = Input::get('description');
            $id = Input::get('id');
            $tags_data = Tag::find($id);
            $tags_data->title = $title;
            $tags_data->description = $description;
            if ($tags_data->save()) {
                 Flash::success('Successfully added!');
                 return Redirect::route('tags_index');
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

    public function getRemove($id = null)
    {
        if (isset($id)) {
            $page = Tag::find($id);
            if (isset($page)) {
                if ($page->delete()) {
                    Flash::success('Successfully Removed!');
                    return Redirect::route('tags_index');
                }
            }
        }
    } 

}
