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
use App\Review;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Thread;
use App\Category;
use App\Search;
use App\Inventory;
use App\Page;
use App\Layout;
use App\Invoice;
use App\Tag;
use App\Event;
use App\WebsiteBrand;
use App\QuestionsNAnswer;
use App\InventoryOption;


class EventsController extends Controller
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
        $all_events = Event::PrepareForIndex(Event::all());
        return view('events.index')
        ->with('layout',$this->layout)
        ->with('all_events',$all_events);
    }

    public function getAdd()
    {   
        return view('events.add')
        ->with('layout',$this->layout);
    }

        public function postAdd()
    {   
        $description = Input::get('description');
        $date = Input::get('date');
        $new_event = new Event();
        $new_event->title = Input::get('title');
        $new_event->description = json_encode($description);
        $new_event->event_date = $date;
        $new_event->status = 1;
        if ($new_event->save()) {
            Flash::success('Successfully Added');
            return Redirect::route('events_index');
        }

    }

        public function getEdit($id = null)
    {   
        $events = Event::PrepareEventForEdit(Event::find($id));
        return view('events.edit')
        ->with('layout',$this->layout)
        ->with('events',$events);
    }

        public function postEdit()
    {   
        $event_id = Input::get('event_id');
        $description = Input::get('description');
        $date = Input::get('date');
        $new_event = Event::find($event_id);
        if (isset($new_event)) {
            $new_event->title = Input::get('title');
            $new_event->description = json_encode($description);
            $new_event->event_date = $date;
            $new_event->status = 1;
            if ($new_event->save()) {
                Flash::success('Successfully Edited');
                return Redirect::route('events_index');
            }
        } else {
                Flash::success("Event doesn't exist");
                return Redirect::route('events_index');
        }


    }

    public function getView($id = null)
    {   
        $events = Event::PrepareEventForEdit(Event::find($id));
        return view('events.view')
        ->with('layout',$this->layout)
        ->with('events',$events);
    }

    public function getRemove($id = null)
    {   
        $event = Event::find($id);
        if (isset($event)) {
            if ($event->delete()) {
                Flash::success("Event Deleted!");
                return Redirect::route('events_index');
            }
        } else {
                Flash::success("Event doesn't exist");
                return Redirect::route('events_index');
        }
    }

}