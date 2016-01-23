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
use App\Thread;
use App\Category;
use App\Search;
use App\Inventory;
use App\Layout;

class LayoutsController extends Controller
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
        $layouts = Layout::PreparelayoutsForIndex(Layout::all());

        return view('layouts.admins.index')
            ->with('layout',$this->layout)
            ->with('layouts',$layouts);
    }

    public function getAdd()
    {
        $slider_option_select = Layout::PrepareSliderOptionSelect();
        return view('layouts.admins.add')
            ->with('slider_option_select',$slider_option_select)
            ->with('layout',$this->layout);
    }  
    /**
     * Process Task Request
     *
     * @return Response
     */
    public function postAdd()
    {       
        $validator = Validator::make(Input::all(), Layout::$rule_add);
        if ($validator->passes()) {
            $title = Input::get('title');
            $title_lowered = strtolower($title);
            $description = Input::get('description');
            $layouts_data = new Layout;
            $layouts_data->title = $title;
            $layouts_data->description = $description;
            $layouts_data->status = 1;
            if ($layouts_data->save()) {
                 Flash::success('Successfully added!');
                 return Redirect::route('layouts_index');
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

        if (isset($id)) {

            $layouts_ob = Layout::find($id);
            if (isset($layouts_ob)) {
                return view('layouts.admins.edit')
                    ->with('layouts_ob',$layouts_ob )
                    ->with('layout',$this->layout);
            }
        }
    } 

    public function postEdit()
    {
        $validator = Validator::make(Input::all(), Layout::$rule_edit);
        if ($validator->passes()) {
            if (Input::get('id')) {
                $layout = Layout::find(Input::get('id'));
                if (isset($layout)) {
                    $layout->title = Input::get('title');
                    $layout->description = Input::get('description');

                    if ($layout->save()) {
                         Flash::success('Successfully added!');
                         return Redirect::route('layouts_index');
                    }
                }
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

    public function getRemove($id = null)
    {
        if (isset($id)) {
            $layout = Layout::find($id);
            if (isset($layout)) {
                if ($layout->delete()) {
                    Flash::success('Successfully Removed!');
                    return Redirect::route('layouts_index');
                }
            }
        }
    } 


    public function getView($id = null)
    {

    } 
}
