<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Inventory;
use App\User;
use App\Job;
use App\Review;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
	use SoftDeletes;
	static public function PrepareForIndex($data) {
    	if(isset($data)) {
    		foreach ($data as $ackey => $acvalue) {
				if(isset($acvalue['created_at'])) {
					$acvalue['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($acvalue['created_at']) );
				}    		
				if(isset($acvalue['inventory_id'])) {
					$item = Inventory::find($acvalue['inventory_id']);
					$item_name = $item['title'];
					$acvalue['item_name'] = $item_name;
				}    		
				if(isset($acvalue['user_id'])) {
					$user = User::find($acvalue['user_id']);
					$username = $user->username;
					$acvalue['username'] = $username;
				}    		
				if(isset($acvalue['status'])) {
					switch ($acvalue['status']) {
						case 1: // Set but not paid
							$acvalue['status_message']= '<span class="label label-success">Active</span>';
							break;
						case 3: // Recieved with error
							$acvalue['status_message']= '<span class="label label-danger">Deleted</span>';
							break;
						default:
							$acvalue['status_message']= '<span class="label label-default">Deleted</span>';
							break;

					}
				}
			}

    	}

    	return $data;
    }
	static public function PrepareReviewForViewItem($item_id) {
		$html = '';	
		if (isset($item_id)) {
			
			$all_reviews = Review::where('inventory_id',$item_id)->orderBy('id', 'DESC')->get();
			if (isset($all_reviews)) {
				foreach ($all_reviews as $aqkey => $aqvalue) {
					$user_id = $aqvalue->user_id;
					$users = User::find($user_id);
					if (isset($users)) {
						$editable = '';
						if (Auth::check()) {
							if (Auth::user()->id == $user_id) {
								$editable = '<i this-review="'.$aqvalue->id.'" class="glyphicon glyphicon-edit edit-this-review" style="color:#337ab7"></i>';
								$new_this_username = Auth::user()->username;
							} else {
								$this_username = $users->username;
								$new_this_username= $this_username;								
							}
						} else {
							$this_username = $users->username;
							$stars = '*******';
							$sting_length = strlen($this_username);
							$last_two = $sting_length-1;
							$new_this_username= substr($this_username, 0, 1).substr($stars, 0, rand(2,4)).substr($this_username, $last_two, $sting_length);						
						}

						$data_time = date ( 'd-n-Y',  strtotime($aqvalue['created_at']) );
						
						if ( (Auth::check()) && (Auth::user()->id == $user_id)) {
							$html .= '<div class="media" style="background:#bce8f1">';
						} else {
							$html .= '<div class="media">';
						}

						
						$html .= 	'<div class="media-body body-'.$aqvalue['id'].'">
							            <h4 class="media-heading"><span class="this-review-title">'.$aqvalue['title'].'</span> <span class="qa-meta">'.$new_this_username.'&nbsp'.$data_time.'&nbsp'.$editable.'</sapn></h4>
											<span class="this-review-description">'.$aqvalue['description'].'</span>
							        </div>';

						$html .=	'</div>';
						$html .=	'<hr>';
					}
				}
			}
		}
		return $html;
	}


	   	static public function PrepareSingleDataForView($data) {
    	if(isset($data)) {
			if(isset($data['inventory_id'])) {
				$item = Inventory::find($data['inventory_id']);
				$item_name = $item->title;
				$data['item_name'] = $item_name;
			}    		
			if(isset($data['user_id'])) {
				$user = User::find($data['user_id']);
				$username = $user->username;
				$data['username'] = $username;
			}   
			if(isset($data['created_at'])) {
				$data['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($data['created_at']) );
			}    		
			if(isset($data['status'])) {
				switch ($data['status']) {
					case 1: // Set but not paid
						$data['status_message']= '<span class="label label-success">New</span>';
						break;
					case 2: // Recieved payment & success
						$data['status_message']= '<span class="label label-warning">Answered</span>';
						break;

					case 3: // Recieved with error
						$data['status_message']= '<span class="label label-danger">Error</span>';
						break;

					default:
						$data['status_message']= '<span class="label label-default">Deleted</span>';
						break;
				}
			}
    	}
    	return $data;
    }
}
