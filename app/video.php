<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class video extends Model
{
    static public function PrepareVideosForIndex($data) {

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
    		}
    	}
    	return $data;
    }
}
