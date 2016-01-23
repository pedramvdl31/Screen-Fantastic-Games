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
use View;
use Session;
use Laracasts\Flash\Flash;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Thread;
use App\Category;
use App\RoleUser;
use App\WebsiteBrand;

class WebsiteBrandController extends Controller
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
        //check if nothing is set, set the default image and title
        WebsiteBrand::CheckDataAndReturn();
    }  
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $website_brand = WebsiteBrand::find(1);
        return view('website_brand.index')
            ->with('layout',$this->layout)
            ->with('website_brand',$website_brand);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function postIndex()
    {
        $images = Input::get('files');
        $imagename = [];
        $file_name = '';


        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($images) && !empty($images)) {
            foreach ($images as $immkey => $immvalue) {
                $imagem_ex = explode(DIRECTORY_SEPARATOR, $immvalue['path']);
                $imagem_ex_count = sizeof($imagem_ex);
                $image_ex_name_type = $imagem_ex[$imagem_ex_count-1];
                $imagename[$immkey] = $image_ex_name_type;
            }
            $file_name = $imagename[0];
        }


        $webbrands = WebsiteBrand::find(1);
        $webbrands->title = Input::get('brand-title');
        $webbrands->brand_img_src = $file_name?$file_name:'brand_placeholder.jpg';
        if ($webbrands->save()) {



            if (isset($images) && !empty($images)) {
                if (!file_exists('assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'brand_image'.DIRECTORY_SEPARATOR.'perm')) {
                    mkdir('assets'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'brand_image'.DIRECTORY_SEPARATOR.'perm', 0777, true);
                }
                $oldpath_s = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."brand_image".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR."".$file_name);
                $newpath_s = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."brand_image".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR."".$file_name);
                rename($oldpath_s, $newpath_s);
            }

            return Redirect::route('website_brand_index');
        }

    }

    public function postUpload()
    {
        error_reporting(E_ALL | E_STRICT);
        $destinationPath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."brand_image".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR);
        $savePath = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."brand_image".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR;
        // Check if directory is made for this company if not then create a new directory
        if (!file_exists($destinationPath)) {
            @mkdir($destinationPath);
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

}
