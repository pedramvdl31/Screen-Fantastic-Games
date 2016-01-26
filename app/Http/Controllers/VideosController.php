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
use App\Video;


class VideosController extends Controller
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
                    $this->layout = 'layouts.admins';
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
        $videos = Video::PrepareVideosForIndex(Video::all());
        return view('videos.index')
            ->with('layout',$this->layout)
            ->with('videos',$videos);

    }
    /**
     * Adds a task 
     *
     * @return Response
     */
    public function getAdd()
    {
        return view('videos.add')
            ->with('layout',$this->layout);
    }  
    /**
     * Process Task Request
     *
     * @return Response
     */
    public function postAdd()
    {       
        $validator = Validator::make(Input::all(), Video::$videos_add);
        if ($validator->passes()) {
            $videos_data = new Video;
            $videos_data->title = Input::get('title');
            $videos_data->description = Input::get('description');
            $videos_data->url = Input::get('url');
            $videos_data->status = 1;
            if ($videos_data->save()) {
                 Flash::success('Successfully added!');
                 return Redirect::route('videos_index');
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
            $videos = Video::find($id);
                return view('videos.edit')
                ->with('layout',$this->layout)
                ->with('videos',$videos);
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
        $validator = Validator::make(Input::all(), Video::$videos_add);
        if ($validator->passes()) {
            $id = Input::get('video_id');
            $videos_data = Video::find($id);
            if (isset($videos_data)) {
                $videos_data->title = Input::get('title');
                $videos_data->description = Input::get('description');
                $videos_data->url = Input::get('url');
            }

            if ($videos_data->save()) {
                 Flash::success('Successfully added!');
                 return Redirect::route('videos_index');
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
       if (isset($id)) {
            $videos = Video::find($id);
                return view('videos.view')
                ->with('layout',$this->layout)
                ->with('videos',$videos);
        } else {
            Redirect::back();
        }
    } 

    public function getRemove($id = null)
    {
        if (isset($id)) {
            $video = Video::find($id);
            if (isset($video)) {
                if ($video->delete()) {
                    Flash::success('Successfully Removed!');
                    return Redirect::route('videos_index');
                }
            }
        }
    } 








}
