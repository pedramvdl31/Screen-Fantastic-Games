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
use App\Video;
use App\Article;
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
            $layout_titles = Layout::PrepareLayout(Layout::select('title','id')->take(3)->get());
            $slider_images = Page::PareparePageSlider($pages);
            $param1_lowered = $pages->param_one;



            return view('home.homepage')
            ->with('layout',$layout_title)
            ->with('param1_lowered',$param1_lowered)
            ->with('is_home',1);
        }
    }
        public function getVideos()
    {
            $layout_title = 'layouts.default';
            $videos = Video::get();
            return view('pages.website_pages.videos')
            ->with('layout',$layout_title)
            ->with('videos',$videos);
    }

        public function getArticles()
    {
            $layout_title = 'layouts.default';
            $articles = Article::PrepareForPublicPage(Article::get());
            return view('pages.website_pages.articles')
            ->with('layout',$layout_title)
            ->with('articles',$articles);
    }


}
