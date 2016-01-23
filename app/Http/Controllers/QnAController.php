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



class QnAController extends Controller
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
        $qnas = QuestionsNAnswer::PrepareForIndex(QuestionsNAnswer::get());
        return view('qna.index')
        ->with('layout',$this->layout)
        ->with('qnas',$qnas);
    }

        public function getView($id = null)
    {   
        $qnas = QuestionsNAnswer::PrepareSingleDataForView(QuestionsNAnswer::find($id));
        return view('qna.view')
        ->with('layout',$this->layout)
        ->with('qna_id',$id)
        ->with('qnas',$qnas);

    }
    
        public function postView()
    {   
            $user_id = Auth::user()->id;
            $qna_id_input = Input::get('qna_id');
            $qnas = new QuestionsNAnswer();
            $qnas->title = Input::get('title');
            $qnas->description = Input::get('description');
            $qnas->inventory_id = Input::get('inventory_id');
            $qnas->parent_id = $qna_id_input;
            $qnas->user_id = $user_id;
            $qnas->status = 1;
            $qnas->type = 2;
            if ($qnas->save()) {
                $old_qna = QuestionsNAnswer::find($qna_id_input);
                $old_qna->status = 2;
                if ($old_qna->save()) {
                    return Redirect::route('qna_index');
                }
            }
    }

    public function postAjaxqnaAdd()
    {
        if(Request::ajax()){
            $status = 400;
            $title = Input::get('title');
            $description = Input::get('description');
            $inventory_id = Input::get('inventory_id');
            $user_id = Auth::user()->id;
            $qnas = new QuestionsNAnswer();
            $qnas->title = Input::get('title');
            $qnas->description = Input::get('description');
            $qnas->inventory_id = Input::get('inventory_id');
            $qnas->user_id = $user_id;
            $qnas->status = 1;
            $qnas->type = 1;
            if ($qnas->save()) {
                $status = 200;
            }
            return Response::json(array(
            'status' => $status
            ));
        }
    }

}
