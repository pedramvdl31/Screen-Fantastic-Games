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
use App\Article;


class ArticlesController extends Controller
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
        $articles = Article::PrepareArticlesForIndex(Article::all());
        return view('articles.index')
            ->with('layout',$this->layout)
            ->with('articles',$articles);

    }
    /**
     * Adds a task 
     *
     * @return Response
     */
    public function getAdd()
    {
        return view('articles.add')
            ->with('layout',$this->layout);
    }  
    /**
     * Process Task Request
     *
     * @return Response
     */
    public function postAdd()
    {       

        $validator = Validator::make(Input::all(), Article::$articles_add);
        if ($validator->passes()) {
            $title = Input::get('title');
            $description = Input::get('content');
            $articles_data = new Article;
            $articles_data->title = $title;
            $articles_data->description = $description;
            if ($articles_data->save()) {
                 Flash::success('Successfully added!');
                 return Redirect::route('articles_index');
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
            $articles = Article::find($id);
                return view('articles.edit')
                ->with('layout',$this->layout)
                ->with('articles',$articles);
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
        $validator = Validator::make(Input::all(), Article::$articles_add);
        if ($validator->passes()) {
            $id = Input::get('article_id');
            $articles_data = Article::find($id);
            if (isset($articles_data)) {
                $title = Input::get('title');
                $description = Input::get('content');
                $articles_data->title = $title;
                $articles_data->description = $description;
                if ($articles_data->save()) {
                     Flash::success('Successfully added!');
                     return Redirect::route('articles_index');
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
            $article = Article::find($id);
            if (isset($article)) {
                if ($article->delete()) {
                    Flash::success('Successfully Removed!');
                    return Redirect::route('articles_index');
                }
            }
        }
    } 


  
}
