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
use App\Event;
use App\WebsiteBrand;

class HomeController extends Controller
{
    public function __construct() {
        $this->layout = "layouts.index-layouts.index";
        //CHECK IF THE HOMEPAGE IS SET
    }

    public function getSetPreferedLayoutSession($layout_title=null,$id=null)
    {
        $data = [];
        $error = true;
        if (isset($layout_title,$id)) {
            $data['layout_title'] = $layout_title;
            $data['layout_id'] = $id;
            $error = false;
        } 
        Session::forget('prefered_layout_session');
        Session::put('prefered_layout_session',$data);

        if (Session::get('_previous')) {
            $route_ = Session::get('_previous');
            return Redirect::to($route_['url']);
            $error = false;
        } 
        if ($error == true) {
            return Redirect::route('home_index');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

        public function getHomePage()
    {
        $layout_title = 'layouts.customize_layout';
        $pages = Page::take(1)->first();
        if (isset($pages)) {
            $prefered_layout_set = null;
            $all_categories = Category::where('status',1)->get();
            $layout_titles = Layout::PrepareLayout(Layout::select('title','id')->take(3)->get());
            $slider_images = Page::PareparePageSlider($pages);
            $param1_lowered = $pages->param_one;
            $prefered_layout_set = Layout::CheckUserPreferedLayout();


            $all_inventories = Inventory::PrepareInventoriesForIndex(Inventory::orderBy('order')
                                    ->where('status',1)->get(),$prefered_layout_set);


            return view('home.homepage')
            ->with('layout',$layout_title)
            ->with('all_categories',$all_categories)
            ->with('all_inventories',$all_inventories)
            ->with('slider_images',$slider_images)
            ->with('layout_titles',$layout_titles)
            ->with('param1_lowered',$param1_lowered)
            ->with('prefered_layout',$prefered_layout_set)
            ->with('is_home',1)
            ->with('slider_option',$pages->slider_option);
        }
    }

    public function getEvents()
    {
        $events = Event::PrepareEventsForEventPage();
        $layout_title = 'layouts.customize_layout';
        return view('pages.website_pages.events')
        ->with('layout',$layout_title)
        ->with('events',$events);
    }
    public function getCalendar()
    {
        $layout_title = 'layouts.customize_layout';
        return view('pages.website_pages.calendar')
        ->with('layout',$layout_title);
    }


    //     public function getPage($param1 = null, $param2 = null)
    // {

    //     if (!isset($param2)) { //LINK
            
    //         $param1_lowered = strtolower($param1);
    //         $pages = Page::where('status', 1)->where('param_one', $param1_lowered)->first();
    //         if (isset($pages)) {
    //         $all_categories = Category::all()->where('status',1);
    //         $empty_height = '';
    //         if (empty($all_inventories)) {
    //             $empty_height = 'height:300px;';
    //         }
    //         Session::put('this_slug',$param1_lowered);

    //         $all_inventories = Inventory::PrepareInventoriesForIndex(Inventory::orderBy('order')
    //                                         ->where('page_id',$pages->id)
    //                                         ->where('status',1)->get());
    //         $slider_images = null;
    //         if ($pages->slider_option == true) {
    //             if (!empty($pages->slider_images) && isset($pages->slider_images) ) {
    //                 $len = sizeof(json_decode($pages->slider_images, true));
    //                 if ($len > 0) {
    //                     $slider_images =  json_decode($pages->slider_images, true);
    //                 }
    //             } 
    //         }

    //         $layout_titles = Page::select('title')->take(3)->get();
    //         foreach ($layout_titles as $ltkey => $ltvalue) {
    //             $layout_titles[$ltkey]['lowered'] = strtolower($ltvalue->title);
    //         }

    //         return view('home.pages')
    //             ->with('layout',$this->layout)
    //             ->with('slider_option',$pages->slider_option)
    //             ->with('all_categories',$all_categories)
    //             ->with('all_inventories',$all_inventories)
    //             ->with('this_slug',$param1_lowered)
    //             ->with('slider_images',$slider_images)
    //             ->with('layout_titles',$layout_titles)
    //             ->with('param1_lowered',$param1_lowered)
    //             ->with('empty_height',$empty_height);

    //         } else {
    //             return view('errors.101')
    //                ->with('layout','layouts.default');
    //         }
    //     } elseif (isset($param1) && isset($param2)) { //GROUP
    //         // $page = Page::where('status', 2)
    //         // ->where('param_one', $param1)
    //         // ->where('param_two', $param2)->first();
    //         // $title = isset($page->title)?$page->title:null;
    //         // if (isset($page)) {
    //         //     //PAGE FOUND
    //         //     $page_content          = json_decode($page->content_data);
    //         //     return view('pages.page')
    //         //     ->with('layout','layouts.pages')
    //         //     ->with('title',$title)
    //         //     ->with('page_content', $page_content);
    //         // } else {
    //         //     //PAGE NOT FOUND 404
    //         //     return view('errors.missing')
    //         //     ->with('layout','layouts.pages');
    //         // }
    //     }

    // }
}
