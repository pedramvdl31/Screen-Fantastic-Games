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
use App\Page;
use App\Layout;
use App\Invoice;
use App\Tag;
use App\WebsiteBrand;
use App\QuestionsNAnswer;
use App\Review;

class ReviewsController extends Controller
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
        $review = Review::PrepareForIndex(Review::withTrashed()->get());
        return view('reviews.index')
        ->with('layout',$this->layout)
        ->with('review',$review);
    }

       public function postAjaxReviewAdd()
    {
        if(Request::ajax()){
            $status = 400;
            $this_review_id = 0;
            $title = Input::get('title');
            $description = Input::get('description');
            $inventory_id = Input::get('inventory_id');
            $user_id = Auth::user()->id;
            $reviewss = new Review();
            $reviewss->title = Input::get('title');
            $reviewss->description = Input::get('description');
            $reviewss->inventory_id = Input::get('inventory_id');
            $reviewss->user_id = $user_id;
            $reviewss->status = 1;
            if ($reviewss->save()) {
                $status = 200;
                $this_review_id = $reviewss->id;
            }
            return Response::json(array(
            'status' => $status,
            'this_review_id' => $this_review_id,
            ));
        }
    }
       public function postAjaxReviewEdit()
    {
        if(Request::ajax()){
            $status = 400;
            $inventory_id = Input::get('inventory_id');
            $review_id = Input::get('review_id');
            $reviewss = Review::find($review_id);
            if (isset($reviewss)) {
                $reviewss->title = Input::get('title');
                $reviewss->description = Input::get('description');
                if ($reviewss->save()) {
                    $status = 200;
                }
            }
            return Response::json(array(
            'status' => $status
            ));
        }
    }

    public function postDeleteReview()
    {
        $id = Input::get('review_id');
        $review = Review::find($id);
        $review->status = 3;
        $review->save();
        if ($review->delete()) {
             return Redirect::route('review_index');
        }

    }

    public function getView($id = null)
    {   
        $review = Review::PrepareSingleDataForView(Review::find($id));
        return view('reviews.view')
        ->with('layout',$this->layout)
        ->with('review_id',$id)
        ->with('review',$review);

    }
}
