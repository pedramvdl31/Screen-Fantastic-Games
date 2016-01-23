<?php

namespace App;
use App\Job;
use App\RoleUser;
use App\User;
use App\Layout;
use Session;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    public static $rule_add = array(
        'title'=>'required',
        'description'=>'required'
    );
    public static $rule_edit = array(
        'title'=>'required',
        'description'=>'required'
    );
        static public function PreparelayoutsForIndex($data) {

        if (isset($data)) {
            foreach ($data as $dkey => $dvalue) {
                if(isset($dvalue['created_at'])) {
                    $dvalue['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($dvalue['created_at']) );
                }           
                if(isset($dvalue['status'])) {
                    switch ($dvalue['status']) {
                        case 1: // Set but not paid
                            $dvalue['status_message']= '<span class="label label-success">Active</span>';
                            break;
                        case 1: // Recieved payment & success
                            $dvalue['status_message']= '<span class="label label-warning">Inactive</span>';
                            break;

                        case 3: // Recieved with error
                            $dvalue['status_message']= '<span class="label label-danger">Error</span>';
                            break;

                        default:
                            $dvalue['status_message']= '<span class="label label-default">Deleted</span>';
                            break;

                    }
                }
                if(isset($dvalue['city'])) {
                    switch ($dvalue['city']) {
                        case 1: // 
                            $dvalue['city_txt']= '광역시도';
                            break;
                        case 2: // 
                            $dvalue['city_txt']= '강원도';
                            break;
                        case 3: // 
                            $dvalue['city_txt']= '경기도';
                            break;
                        case 4: // 
                            $dvalue['city_txt']= '경상남도';
                            break;
                        case 5: // 
                            $dvalue['city_txt']= '경상북도';
                            break;
                        case 6: // 
                            $dvalue['city_txt']= '광주광역시';
                            break;
                        case 7: // 
                            $dvalue['city_txt']= '대구광역시';
                            break;
                        case 8: // 
                            $dvalue['city_txt']= '대전광역시';
                            break;
                        case 9: // 
                            $dvalue['city_txt']= '부산광역시';
                            break;
                        case 10: // 
                            $dvalue['city_txt']= '서울특별시';
                            break;
                        case 11: // 
                            $dvalue['city_txt']= '세종특별자치시';
                            break;
                        case 12: // 
                            $dvalue['city_txt']= '울산광역시';
                            break;
                        case 13: // 
                            $dvalue['city_txt']= '인천광역시';
                            break;
                        case 14: // 
                            $dvalue['city_txt']= '전라남도';
                            break;
                        case 15: // 
                            $dvalue['city_txt']= '전라북도';
                            break;
                        case 16: // 
                            $dvalue['city_txt']= '제주특별자치도';
                            break;
                        case 17: // 
                            $dvalue['city_txt']= '충청남도';
                            break;
                        case 18: // 
                            $dvalue['city_txt']= '충청북도';
                            break;

                        default:
                            $dvalue['city_txt']= 'error';
                            break;

                    }
                }
            }
        }
        return $data;
    }
    static public function PrepareLayout($data) {
        if (isset($data)) {
            foreach ($data as $ltkey => $ltvalue) {
                $data[$ltkey]['lowered'] = strtolower($ltvalue->title);
                $data[$ltkey]['id'] = strtolower($ltvalue->id);
            }
        }
        return $data;
    }

    
    static public function CheckUserPreferedLayout() {
        $selected_layout = Session::get('prefered_layout_session')?Session::get('prefered_layout_session'):null;
        if (!isset($selected_layout)) {
            $first_layout = Layout::find(1);
            if (isset($first_layout)) {
                if (isset($first_layout['title'])) {
                    $first_layout['strtolow_title'] = strtolower($first_layout['title']);
                }
                $selected_layout = $first_layout;
            }
        } else {
            $data = Session::get('prefered_layout_session');
            $id = $data['layout_id'];
            if (isset($id)) {
                $layout = Layout::find($id)?Layout::find($id):Layout::find(1);
                if (isset($layout)) {
                    if (isset($layout['title'])) {
                        $layout['strtolow_title'] = strtolower($layout['title']);
                    }
                    $selected_layout = $layout;
                }
            }
        }
        return $selected_layout;
    }


    static public function SetUserPreferedLayout($prefered_layout,$id) {
        $selected_layout = null;
        if (isset($prefered_layout,$id)) {
            $layout = Layout::find($id);
            if (isset($layout)) {
                Session::put('prefered_layout',$id);
                if (isset($layout['title'])) {
                    $layout['strtolow_title'] = strtolower($layout['title']);
                }
                $selected_layout = $layout;
            }
        }
        return $selected_layout;
    }
    static public function PrepareSlidersForIndex($data) {
        $output = [];

        foreach ($data as $dkey => $dvalue) {
            $title = $dvalue->title;
            $images = json_decode($dvalue->slider_images);

            $output[$title]['images'] = $images;

            $output[$title]["id"] = $dvalue->id;
        }
        return $output;
    }

    static public function PrepareSlidersForEdit($data) {
        $output = [];
        $title = $data->title;
        $images = json_decode($data->slider_images);
        $output['images'] = $images;
        $output["id"] = $data->id;
        return $output;
    }

	    public static function PerpareLayoutsSelect() {
        $data =  Layout::all();
        $ps = array(''=>'Select a Layout');
        if(isset($data)) {
            foreach ($data as $dkey => $dvalue) {
                
                $idd = $dvalue->id;
                $title = $dvalue['title'];
                $ps[$idd] = $title; 
            }

        }
        return $ps;
    }

    public static function PrepareSliderOptionSelect() {
        $cats = array(
                        ''=>'Slider Option',
                        '1' => 'Yes',
                        '0' => 'No'
                    );
        return $cats;
    }
}
