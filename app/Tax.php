<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{

	public static $rule_add = array(
        'title'=>'required',
        'description'=>'required',
        'city'=>'required',
        'country'=>'required',
        'rate'=>'required',
    );
    static public function PrepareTaxesForIndex($data) {

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

    static public function PrepareStatusForSelect() {
    	return [
    		''	=> 'Select Status',
    		'1' => 'Active',
    		'2' => 'In-Active'
    	];
    }
}
