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

class CategoriesController extends Controller
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
        
        $all_cats = Category::PrepareForIndex(Category::all());
        return view('categories.index')
        ->with('layout',$this->layout)
        ->with('all_cats',$all_cats);
    }
    public function getAdd()
    {   
        
        return view('categories.add')
        ->with('layout',$this->layout);
    }

    public function postAdd()
    {   
        $validator = Validator::make(Input::all(), Category::$add_roles);
        if ($validator->passes()) {
            $title = Input::get('category-title');
            $description = Input::get('category-description');
            $duplicate = count(Category::where('title',$title)->get());
            if ($duplicate == 0) {
                $categories = new Category;
                $categories->title = $title;
                $categories->description = $description;
                $categories->status = 1;
                if ($categories->save()) {
                    return view('categories.add')
                    ->with('layout',$this->layout)
                    ->with('message_feedback','Successfully Added');
                }
            } else {
                Flash::error('Error: Duplicate Entry');
                return Redirect::back();
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
            $category = Category::PrepareSingleCategoryForEdit(Category::find($id));
            $select_data = Category::PerpareCategoriesListForSelect();
            return view('categories.edit')
                ->with('layout',$this->layout)
                ->with('category',$category)
                ->with('select_data',$select_data);
        }
    }

    public function postEdit()
    {   
        $validator = Validator::make(Input::all(), Category::$add_roles);
        if ($validator->passes()) {
            $title = Input::get('category-title');
            $description = Input::get('category-description');
            $status = Input::get('cats');
            $cat_id = Input::get('cat_id');

            $categories = Category::find($cat_id);
            $categories->title = $title;
            $categories->description = $description;
            $categories->status = $status;
            if ($categories->save()) {
                Flash::success('Well done! Successfully Edited');
                return Redirect::route('category_index');
            }

        } else {
            // validation has failed, display error messages    
            return Redirect::back()
                ->with('message', 'The following errors occurred')
                ->with('alert_type','alert-danger')
                ->withErrors($validator)
                ->withInput();  
        }
    }

    public function getView($id = null)
    {   
        if (isset($id)) {
            $category = Category::PrepareSingleCategory(Category::find($id));
            return view('categories.view')
                ->with('layout',$this->layout)
                ->with('category',$category);
        }

    }


}
