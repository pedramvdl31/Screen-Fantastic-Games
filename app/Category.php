<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public static $add_roles = array(
        'category-title'=>'required',
        'category-description'=>'required'
    );
    static public function PrepareForIndex($all_cats) {

    	if(isset($all_cats)) {
    		foreach ($all_cats as $ackey => $acvalue) {
				if(isset($acvalue['created_at'])) {
					$acvalue['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($acvalue['created_at']) );
				}    		
				if(isset($acvalue['status'])) {
					switch ($acvalue['status']) {
						case 1: // Set but not paid
							$acvalue['status_message']= '<span class="label label-success">Active</span>';
							break;
						case 2: // Recieved payment & success
							$acvalue['status_message']= '<span class="label label-warning">Inactive</span>';
							break;

						case 3: // Recieved with error
							$acvalue['status_message']= '<span class="label label-danger">Error</span>';
							break;

						default:
							$acvalue['status_message']= '<span class="label label-default">Deleted</span>';
							break;

					}
				}
			}

    	}

    	return $all_cats;
    }

    static public function PrepareSingleCategory($cat) {

    	if(isset($cat)) {
				if(isset($cat['created_at'])) {
					$cat['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($cat['created_at']) );
				}    		
				if(isset($cat['status'])) {
					switch ($cat['status']) {
						case 1: // Set but not paid
							$cat['status_message']= '<span class="label label-success">Active</span>';
							break;
						case 1: // Recieved payment & success
							$cat['status_message']= '<span class="label label-warning">Inactive</span>';
							break;

						case 3: // Recieved with error
							$cat['status_message']= '<span class="label label-danger">Error</span>';
							break;

						default:
							$cat['status_message']= '<span class="label label-default">Deleted</span>';
							break;
					}
				}
    	}
    	return $cat;
    }

    static public function PrepareSingleCategoryForEdit($cat) {

    	if(isset($cat)) {
				if(isset($cat['created_at'])) {
					$cat['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($cat['created_at']) );
				}    		
    	}
    	return $cat;
    }
    public static function PerpareCategoriesListForSelect() {
        $cats = array(
        				''=>'Select Role',
        				'1' => 'Active',
        				'2' => 'Inactive',
        				'3' => 'Deleted'
        			);
        return $cats;
    }
    public static function PrepareCatsForSelect($cats) {
        $o_cats = array(''=>'Select a Category');
        if (isset($cats)) {
        	foreach ($cats as $key => $value) {
        		$o_cats[$value->id] = $value->title; 
        	}
        }
        return $o_cats;
    }
}
