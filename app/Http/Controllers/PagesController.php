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

class PagesController extends Controller
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
        Session::forget('page_step_1_data');
        Session::forget('pages-data-add');
        Session::forget('page_step_2_data');
        Session::forget('sorted');
        Session::forget('preview-step-input-all');


        $pages = Page::PreparepagesForIndex(Page::all());
        return view('pages.index')
        ->with('layout',$this->layout)
        ->with('pages',$pages);
    }

    public function postAddPreviewStep2()
    {
    }
    public function getAdd()
    {

        $slider_option_select = Page::PrepareSliderOptionSelect();
        return view('pages.add')
        ->with('layout',$this->layout);
    }  

    public function postAdd()
    {      
        $pages = new Page();
        $pages->title = Input::get('title');
        $pages->keywords = json_encode(Input::get('keywords'));
        $pages->param_one = Job::UrlFriendly(Input::get('title'));
        $pages->section_content = Input::get('content');
        $pages->status = 1;
        if ($pages->save()) {
            Flash::success('Successfully Saved');
            return Redirect::route('pages_index');
        }

    }  

    public function getEdit($id = null)
    {
        if (isset($id)) {
            $page = Page::find($id);
            if (isset($page)) {
                $slider_option_select = Page::PrepareSliderOptionSelect();
                $data_add_session = null;
                $data = [];
                $data['id'] = $page->id;
                $data['page_title'] = $page->title;
                $data['page_keywords'] = json_decode($page->keywords,true);
                $data['page_section_content'] = $page->section_content;
                if ($id == 1) {
                    return view('pages.edit')
                        ->with('page_data',$data)//ignore the wrong name
                        ->with('layout',$this->layout);
                } else {
                    return view('pages.edit')
                        ->with('page_data',$data)//ignore the wrong name
                        ->with('layout',$this->layout);
                }


            }
        }
    } 


    public function postEdit()
    {
        $page_id = Input::get('page_id');
        $error = 1;
        if (isset($page_id)) {
            $pages = Page::find($page_id);
            if (isset($pages)) {
                $pages->title = Input::get('title');
                $pages->keywords = json_encode(Input::get('keywords'));
                $pages->param_one = Job::UrlFriendly(Input::get('title'));
                $pages->section_content = Input::get('content');
                $pages->status = 1;
                if ($pages->save()) {
                     $error = 0;
                    Flash::success('Successfully Saved');
                    return Redirect::route('pages_index');
                }
            }
            if ($error == 1) {
                Flash::success('Error');
                return Redirect::route('pages_index');
            }
        }
    }  

    public function getRemove($id = null)
    {
        $error = 1;
        if (isset($id)) {
            if ($id != 1) {
                $page = Page::find($id);
                if (isset($page)) {
                    if ($page->delete()) {
                        $error = 0;
                        Flash::success('Successfully Removed');
                        return Redirect::route('pages_index');
                    }
                }
            }
        }
        if ($error == 1) {
            Flash::success('Error');
            return Redirect::route('pages_index');
        }
    }

    public function getPage($param1 = null)
    {
        // Set layout
        if (isset($param1)) { //LINK
            $page = Page::where('status', 1)->where('param_one', $param1)->first();
            if (isset($page)) {
                //PAGE FOUND
                $title = isset($page->title)?$page->title:null;
                $page_content  = $page->section_content;
                return view('pages.website_pages.customize_page')
                ->with('layout','layouts.customize_layout')
                ->with('title',$title)
                ->with('page_content', $page_content);
            } else {
                $this->layout->content = View::make('errors.missing');
            }
        }
    }





public function getSlidersEdit($id = null)
{

    $pages = Page::find($id);
    $title = $pages->title;

    $data =  Page::PrepareSlidersForEdit(Page::find($id));

    return view('pages.sliders.edit')
    ->with('data',$data)
    ->with('title',$title)
    ->with('layout',$this->layout);

}  


public function postSlidersEdit()
{

    $images = Input::get('pre_files');
    $new_images = Input::get('files');
    $del_images = Input::get('del_files');

    $id = Input::get('page_id');

    $image_names = [];
    $new_image_name = [];
    $deleted_image_names = [];
    $array_count = 0;
    $array_count2 = 0;
    $array_count3 = 0;

        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
    if (isset($images)) {
        foreach ($images as $imkey => $imvalue) {
            $array_count = 0;
            $image_ex_pre = explode(DIRECTORY_SEPARATOR, $imvalue['path']);
            $array_count = sizeof($image_ex_pre);
            $image_ex_name_type_pre = $image_ex_pre[$array_count-1];
            $image_names[$imkey] = $image_ex_name_type_pre;
        }
    }

    $pre_count = sizeof($image_names);

        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
    if (isset($new_images) && !empty($new_images)) {
        foreach ($new_images as $nimkey => $nimvalue) {
            $array_count2 = 0;
            $image_ex_new = explode(DIRECTORY_SEPARATOR, $nimvalue['path']);

            $array_count2 = sizeof($image_ex_new);
            $image_ex_name_type_new = $image_ex_new[$array_count2-1];
            $new_image_name[$nimkey]=$image_ex_new[$array_count2-1];
            $image_names[$pre_count] = $image_ex_name_type_new;
            $pre_count++;
        }
    }

        // GO THROUGH ALL IMAGES AND SAVE THE NAMES
    if (isset($del_images)) {
        foreach ($del_images as $nimkey => $nimvalue) {
            $array_count3 = 0;
            $image_ex_del = explode(DIRECTORY_SEPARATOR, $nimvalue['path']);
            $array_count3 = sizeof($image_ex_del);
            $image_ex_name_type_del = $image_ex_del[$array_count3-1];
            $deleted_image_names[$nimkey] = $image_ex_name_type_del;
        }
    }

    $pages = Page::find($id);
    $title = $pages->title;
    $pages->slider_images = json_encode($image_names);
    if ($pages->save()) {
       if (isset($deleted_image_names) && !empty($deleted_image_names)) {
        // Job::dump($deleted_image_names);
           foreach ($deleted_image_names as $dinkey => $dinvalue) {
            $path = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR.$title.DIRECTORY_SEPARATOR.$dinvalue);
            if (file_exists($path)) {
                unlink($path);
            } 
            
        }
    }
    $title_lowered = strtolower($title);
    if (!file_exists('assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'sliders'.DIRECTORY_SEPARATOR.$title_lowered)) {
        mkdir('assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'sliders'.DIRECTORY_SEPARATOR.$title_lowered, 0777, true);
    } 
    if (isset($new_image_name)) {
       foreach ($new_image_name as $neinkey => $neinvalue) {
        $oldpath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR.$neinvalue);
        $newpath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR.$title.DIRECTORY_SEPARATOR.$neinvalue);
        rename($oldpath, $newpath);
    }
}


return Redirect::route('sliders_index');
}

}  

public function postUploadPagesSliderImage()
{
    error_reporting(E_ALL | E_STRICT);
    $destinationPath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR);
    $savePath = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR;
    // Check if directory is made for this company if not then create a new directory
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $files = Input::file('files');
    $fileName = str_random(12).'.jpg';


    // Save image and rename it to new name
    if(Input::file('files')->move($destinationPath, $fileName)){
        return Response::json([
            'success'=>true,
            'path'=> $savePath.$fileName
            ]);
    } else {
        return Response::json([
            'success'=>false,
            'reason'=> 'Error saving image.' 
            ]);
    } 
}   

public function postUploadPagesImageSingle()
{
    error_reporting(E_ALL | E_STRICT);
    $destinationPath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."single".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR);
    $savePath = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."pages".DIRECTORY_SEPARATOR."single".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR;
    // Check if directory is made for this company if not then create a new directory
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
    }

    $files = Input::file('files');
    $fileName = str_random(12).'.jpg';


    // Save image and rename it to new name
    if(Input::file('files')->move($destinationPath, $fileName)){
        return Response::json([
            'success'=>true,
            'path'=> $savePath.$fileName
            ]);
    } else {
        return Response::json([
            'success'=>false,
            'reason'=> 'Error saving image.' 
            ]);
    } 
}   

public function postUploadSlider()
{

    error_reporting(E_ALL | E_STRICT);
    $destinationPath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR);
    $savePath = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR;
        // Check if directory is made for this company if not then create a new directory
    if (!file_exists($destinationPath)) {
        @mkdir($destinationPath);
    }    
    $files = Input::file('files');
    $fileName = str_random(12).'.jpg';

        // Check image for errors

        // Save image and rename it to new name
    if(Input::file('files')->move($destinationPath, $fileName)){
        return Response::json([
            'success'=>true,
            'path'=> $savePath.$fileName
            ]);
    } else {
        return Response::json([
            'success'=>false,
            'reason'=> 'Error saving image.' 
            ]);
    } 


}   

    /**
     * /admins/tasks/edit.
     * @param $id - task_id
     * @return Response
     */

    public function postEditDataStep()
    {
        $data_add_session = null;
        $sorted = Session::get('sorted')?Session::get('sorted'):null;
        $page_id = Input::get('page_id');
        $page = Page::find($page_id);
        $this_page_data = [];
        if (isset($page)) {
            $this_page_data['page_title'] = $page->title;
            $this_page_data['page_description'] = $page->escription;
            $this_page_data['page_keywords'] = json_decode($page->keywords,true);
            $this_page_data['page_header_option'] = $page->header_option;
            $this_page_data['page_slider_option'] = $page->slider_option;
            $this_page_data['page_image_option'] = $page->image_option;
            $this_page_data['page_section_number'] = $page->section_number;
            $this_page_data['sorting_order'] = $page->sorting_order;
            $this_page_data['page_content'] = json_decode($page->section_content,true);
        }
        $step_2_data = Session::get('page_step_2_data')?Session::get('page_step_2_data'):null;
        if (Input::get('back-btn') && Input::get('sorted') ) {
            $sorted = Input::get('sorted');
            Session::put('sorted',$sorted);
            $data = Session::get('page_step_1_data')?Session::get('page_step_1_data'):null;
            $new_array = [];
            $count = 0;
            $is_tab_active_array = [];
            $t_count = 0;
            foreach ($data as $pskey => $psvalue) {
                if ($pskey == 'page_header_option' || $pskey == 'page_slider_option' || $pskey == 'page_image_option' || $pskey == 'page_section_number') {
                    if ($psvalue != 0) {
                        $count++;

                        $new_array[$count][$pskey] = $psvalue;
                        $new_array[$count]['count'] = $count;
                        $new_title = explode('_', $pskey);
                        $new_array[$count]['title'] = $new_title[1];

                        //is tab active
                        if ($count == 1) {
                            $is_tab_active_array[$pskey]['active'] = 'active';
                        }
                    }
                }
            }
                return view('pages.add_data_edit')
                ->with('preview_session_data',$data)
                ->with('step_2_data',$step_2_data)
                ->with('new_array',$new_array)
                ->with('is_tab_active_array',$is_tab_active_array)
                ->with('data_add_session',$data_add_session)
                ->with('page_id',$page_id)
                ->with('this_page_data',$this_page_data)
                ->with('layout',$this->layout);
        } else {
            $validator = Validator::make(Input::all(), Page::$rule_add);
            if ($validator->passes()) {
                $page_title = Input::get('title');
                $page_description = Input::get('description');
                $page_keywords = Input::get('keywords');
                $page_header_option = Input::get('header-option');
                $page_slider_option = Input::get('slider-option');
                $page_image_option = Input::get('image-option');
                $page_section_number = Input::get('section-number');

                $data = [];
                if (!Session::get('page_step_1_data')) {
                    $data['page_title'] = $page_title;
                    $data['page_description'] = $page_description;
                    $data['page_keywords'] = $page_keywords;
                    $data['page_header_option'] = $page_header_option;
                    $data['page_slider_option'] = $page_slider_option;
                    $data['page_image_option'] = $page_image_option;
                    $data['page_section_number'] = $page_section_number;
                    Session::put('page_step_1_data',$data);
                } else {
                    $data = Session::get('page_step_1_data');
                }

                $new_array = [];
                $count = 0;
                $is_tab_active_array = [];
                $t_count = 0;

                foreach ($data as $pskey => $psvalue) {
                    if ($pskey == 'page_header_option' || $pskey == 'page_slider_option' || $pskey == 'page_image_option' || $pskey == 'page_section_number') {
                        if ($psvalue != 0) {
                            $count++;

                            $new_array[$count][$pskey] = $psvalue;
                            $new_array[$count]['count'] = $count;
                            $new_title = explode('_', $pskey);
                            $new_array[$count]['title'] = $new_title[1];

                            //is tab active
                            if ($count == 1) {
                                $is_tab_active_array[$pskey]['active'] = 'active';
                            }
                        }
                    }
                }
                return view('pages.add_data_edit')
                ->with('preview_session_data',$data)
                ->with('new_array',$new_array)
                ->with('is_tab_active_array',$is_tab_active_array)
                ->with('this_page_data',$this_page_data)
                ->with('data_add_session',$data_add_session)
                ->with('step_2_data',$step_2_data)
                ->with('page_id',$page_id)
                ->with('layout',$this->layout);
            } else {
                 // validation has failed, display error messages    
                return Redirect::back()
                ->with('message', 'The following errors occurred')
                ->with('alert_type','alert-danger')
                ->withErrors($validator)
                ->withInput(); 
            }
        }
    }

        public function postEditPreviewStep()
    {
        $page_id = Input::get('page_id');
        $this_page = null;
        $sorting_order = null;

        $issorted = false;
        $sorted_data = null;
        $_layout = Layout::CheckUserPreferedLayout();
        $layout_titles = Layout::PrepareLayout(Layout::select('title')->take(3)->get());
        if (Session::get('sorted')) {
            $sorted_data = Session::get('sorted');
            $issorted = true;
        } else {
            $this_page = Page::find($page_id);
            $sorting_order =json_decode($this_page->sorting_order,true) ;
        }

        $data_array = [];
        $data_array['header_text'] = Input::get('header_text');
        $data_array['files'] = Input::get('files');
        $data_array['section'] = Input::get('section');
        $data_array['file-single'] = Input::get('file-single');
        $data_array['section_number'] = sizeof(Input::get('section'));

        Session::put('page_step_2_data',$data_array);
        $data = Session::get('page_step_1_data')?Session::get('page_step_1_data'):null;

        $new_array = [];
        $count = 0;
        if (isset($data)) {
            foreach ($data as $pskey => $psvalue) {
                if ($pskey == 'page_header_option' || $pskey == 'page_slider_option' || $pskey == 'page_image_option' || $pskey == 'page_section_number') {
                    if ($psvalue != 0) {
                        $count++;

                        $new_array[$count][$pskey] = $psvalue;
                        $new_array[$count]['count'] = $count;
                        $new_title = explode('_', $pskey);
                        $new_array[$count]['title'] = $new_title[1];
                    }
                }
            }
        }

        return view('pages.edit_preview')
        ->with('data',$data)
        ->with('new_array',$new_array)
        ->with('layout_titles',$layout_titles)
        ->with('issorted',$issorted)
        ->with('data_array',$data_array)
        ->with('sorted_data',$sorted_data)
        ->with('page_id',$page_id)
        ->with('sorting_order',$sorting_order)
        ->with('layout','layouts.preview-layout');

    }


    public function getView($id = null)
    {

    } 

        /**
     * getPage Method
     * retrieves content from url by parameter and displays page based on user input from pages/add || pages/edit
     * Home page being the only special route we need to keep in mind for routing
     * @param $param1 = menu group
     * @param $param2 = menu item
     **/

    
    public function postAddSection()
    {
        if(Request::ajax()){
            $data_session = Session::get('preview-step-input-all')?Session::get('preview-step-input-all'):null;
            $section_html = '';
            if (isset($data_session)) {
                $new_number = null;
                $page_section_number = $data_session['page_section_number'];
                $new_number = $page_section_number+1;
                $data_session['page_section_number'] = $new_number;
                //ADD TO SESSION
                Session::put('preview-step-input-all',$data_session);

                //PREPARE HTML
                $section_html = Page::PrepareSectionHtml($new_number);
            }
            $sorted_data_session = Session::get('sorted')?Session::get('sorted'):null;
            $pages_data_add_session = Session::get('pages-data-add')?Session::get('pages-data-add'):null;
 
            // Job::dump('$data_session');
            // Job::dump($data_session);
            // Job::dump('$sorted_data_session');
            // Job::dump($sorted_data_session);
            // Job::dump('$pages_data_add_session');
            // Job::dump($pages_data_add_session);

            return Response::json(array(
                'status' => 200,
                'section_html' => $section_html
                ));
        }
    }
    public function postAddSectionEdit()
    {
        if(Request::ajax()){
            $data_session = Session::get('page_step_1_data')?Session::get('page_step_1_data'):null;
            $section_html = '';
            if (isset($data_session)) {
                $new_number = null;
                $page_section_number = $data_session['page_section_number'];
                $new_number = $page_section_number+1;
                $data_session['page_section_number'] = $new_number;
                //ADD TO SESSION
                Session::put('page_step_1_data',$data_session);

                //PREPARE HTML
                $section_html = Page::PrepareSectionHtml($new_number);
            }
            $sorted_data_session = Session::get('sorted')?Session::get('sorted'):null;
            $pages_data_add_session = Session::get('pages-data-add')?Session::get('pages-data-add'):null;
 
            // Job::dump('$data_session');
            // Job::dump($data_session);
            // Job::dump('$sorted_data_session');
            // Job::dump($sorted_data_session);
            // Job::dump('$pages_data_add_session');
            // Job::dump($pages_data_add_session);

            return Response::json(array(
                'status' => 200,
                'section_html' => $section_html
                ));
        }
    }




        public function postAddDataStep()
    {
        $sorted = Session::get('sorted')?Session::get('sorted'):null;
        $data_add_session = null;
        if (Input::get('back-btn') && Input::get('sorted') ) {
            $sorted = Input::get('sorted');
            Session::put('sorted',$sorted);
            $data_add_session = Session::get('pages-data-add')?Session::get('pages-data-add'):null;
            $data = Session::get('preview-step-input-all')?Session::get('preview-step-input-all'):null;
            $new_array = [];
            $count = 0;
            $is_tab_active_array = [];
            $t_count = 0;
            foreach ($data as $pskey => $psvalue) {
                if ($pskey == 'page_header_option' || $pskey == 'page_slider_option' || $pskey == 'page_image_option' || $pskey == 'page_section_number') {
                    if ($psvalue != 0) {
                        $count++;
                        $new_array[$count][$pskey] = $psvalue;
                        $new_array[$count]['count'] = $count;
                        $new_title = explode('_', $pskey);
                        $new_array[$count]['title'] = $new_title[1];
                        //is tab active
                        if ($count == 1) {
                            $is_tab_active_array[$pskey]['active'] = 'active';
                        }
                    }
                }
            }
            return view('pages.add_data')
            ->with('preview_session_data',$data)
            ->with('new_array',$new_array)
            ->with('is_tab_active_array',$is_tab_active_array)
            ->with('data_add_session',$data_add_session)
            ->with('layout',$this->layout);
        } else {
            $validator = Validator::make(Input::all(), Page::$rule_add);
            if ($validator->passes()) {
                $data_add_session = Session::get('pages-data-add')?Session::get('pages-data-add'):null;
                $page_title = Input::get('title');
                $page_description = Input::get('description');
                $page_keywords = Input::get('keywords');
                $page_header_option = Input::get('header-option');
                $page_slider_option = Input::get('slider-option');
                $page_image_option = Input::get('image-option');
                $page_section_number = Input::get('section-number');
                $data = [];

                if (!Session::get('preview-step-input-all')) {
                    $data['page_title'] = $page_title;
                    $data['page_description'] = $page_description;
                    $data['page_keywords'] = $page_keywords;
                    $data['page_header_option'] = $page_header_option;
                    $data['page_slider_option'] = $page_slider_option;
                    $data['page_image_option'] = $page_image_option;
                    $data['page_section_number'] = $page_section_number;
                    Session::put('preview-step-input-all',$data);
                } else {
                    $data = Session::get('preview-step-input-all');
                }
                
                $new_array = [];
                $count = 0;
                $is_tab_active_array = [];
                $t_count = 0;
                foreach ($data as $pskey => $psvalue) {
                    if ($pskey == 'page_header_option' || $pskey == 'page_slider_option' || $pskey == 'page_image_option' || $pskey == 'page_section_number') {
                        if ($psvalue != 0) {
                            $count++;
                            $new_array[$count][$pskey] = $psvalue;
                            $new_array[$count]['count'] = $count;
                            $new_title = explode('_', $pskey);
                            $new_array[$count]['title'] = $new_title[1];
                            //is tab active
                            if ($count == 1) {
                                $is_tab_active_array[$pskey]['active'] = 'active';
                            }
                        }
                    }
                }
                return view('pages.add_data')
                ->with('preview_session_data',$data)
                ->with('new_array',$new_array)
                ->with('is_tab_active_array',$is_tab_active_array)
                ->with('data_add_session',$data_add_session)
                ->with('layout',$this->layout);
            } else {
                 // validation has failed, display error messages    
                return Redirect::back()
                ->with('message', 'The following errors occurred')
                ->with('alert_type','alert-danger')
                ->withErrors($validator)
                ->withInput(); 
            }
        }
    }


    public function postAddPreviewStep()
    {
        
        $issorted = false;
        $sorted_data = null;
        $data_array = [];

        if (Session::get('sorted')) {
            $sorted_data = Session::get('sorted');
            $issorted = true;
        }

        $_layout = Layout::CheckUserPreferedLayout();
        $layout_titles = Layout::PrepareLayout(Layout::select('title')->take(3)->get());
        $data_array['header_text'] = Input::get('header_text');
        $data_array['files'] = Input::get('files');
        $data_array['file-single'] = Input::get('file-single');
        $data_array['section'] = Input::get('section');
        Session::put('pages-data-add',$data_array);
        $data = Session::get('preview-step-input-all')?Session::get('preview-step-input-all'):null;

        $new_array = [];
        $count = 0;
        if (isset($data)) {
            foreach ($data as $pskey => $psvalue) {
                if ($pskey == 'page_header_option' || $pskey == 'page_slider_option' || $pskey == 'page_image_option' || $pskey == 'page_section_number') {
                    if ($psvalue != 0) {
                        $count++;

                        $new_array[$count][$pskey] = $psvalue;
                        $new_array[$count]['count'] = $count;
                        $new_title = explode('_', $pskey);
                        $new_array[$count]['title'] = $new_title[1];
                    }
                }
            }
        }

        return view('pages.preview')
        ->with('data',$data)
        ->with('new_array',$new_array)
        ->with('layout_titles',$layout_titles)
        ->with('issorted',$issorted)
        ->with('data_array',$data_array)
        ->with('sorted_data',$sorted_data)
        ->with('layout','layouts.preview-layout');

    }
    public function postAddSortStep()
    {
        return view('pages.sort')
        ->with('layout',$this->layout);
    }
    public function getSlidersIndex()
    {
        $all_sliders = Page::PrepareSlidersForIndex(Page::all());
        return view('pages.sliders.index')
        ->with('layout',$this->layout)
        ->with('all_sliders',$all_sliders);
    }
    public function getSlidersAdd()
    {
        $pages_select = Page::PerparePagesSelect();
        return view('pages.sliders.add')
        ->with('pages_select',$pages_select)
        ->with('layout',$this->layout);

    }  
    public function postSlidersAdd()
    {
        $images = Input::get('files');
        $page_id = Input::get('pages');
        $image_names = [];
        $array_count = 0;


        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($images)) {
            foreach ($images as $imkey => $imvalue) {
                $array_count = 0;

                $image_ex = explode(DIRECTORY_SEPARATOR, $imvalue['path']);
                $array_count = sizeof($image_ex);
                $image_ex_name_type = $image_ex[$array_count-1];
                $image_names[$imkey] = $image_ex_name_type;
            }
        }



        $pages = Page::find($page_id);
        $pages->slider_images = json_encode($image_names);
        $page_title_x = $pages->title;
        $page_title = strtolower($page_title_x);

        if (!file_exists('assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'sliders'.DIRECTORY_SEPARATOR.''.$page_title)) {
            mkdir('assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'sliders'.DIRECTORY_SEPARATOR.''.$page_title, 0777, true);
        }

        if ($pages->save()) {
           foreach ($image_names as $inkey => $invalue) {
            $oldpath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR."".$invalue);
            $newpath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."sliders".DIRECTORY_SEPARATOR."".$page_title."".DIRECTORY_SEPARATOR."".$invalue);
            rename($oldpath, $newpath);
        }
        return Redirect::route('sliders_add');
        }


    }  
}
