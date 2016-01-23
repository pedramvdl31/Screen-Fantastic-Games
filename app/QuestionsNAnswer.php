<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Inventory;
use App\User;
use App\Job;
use Auth;

class QuestionsNAnswer extends Model
{
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
							$acvalue['status_message']= '<span class="label label-success">New</span>';
							break;
						case 2: // Recieved payment & success
							$acvalue['status_message']= '<span class="label label-warning">Answered</span>';
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

    	return $data;
    }
    
	static public function PrepareQnAForViewItem($item_id) {
		$html = '';	
		if (isset($item_id)) {
			$username = Auth::user()->username;
			$all_questions = QuestionsNAnswer::where('user_id',Auth::user()->id)
												->where('inventory_id',$item_id)->whereNull('parent_id')->get();
			if (isset($all_questions)) {
				foreach ($all_questions as $aqkey => $aqvalue) {
					$data_time_q = date ( 'd-n-Y',  strtotime($aqvalue['created_at']) );
					$all_ansewers = QuestionsNAnswer::where('parent_id',$aqvalue->id)
												->where('inventory_id',$item_id)->get();
					$html .= '
						<div class="media"> 
						    <div class="media" style="">
						        <div class="media-body">
						            <h4 class="media-heading">'.$aqvalue['title'].' <span class="qa-meta">'.$username.'&nbsp'.$data_time_q.'</sapn></h4>
										'.$aqvalue['description'].'
						        </div>

						    </div>';
					if (isset($all_ansewers)) {
						foreach ($all_ansewers as $askey => $asvalue) {
							$data_time_a = date ( 'd-n-Y',  strtotime($asvalue['created_at']) );
							$html .= '
								<div class="media" style="background: #d6e9c6;">
							        <div class="media-left">
							        </div>
							        <div class="media-body">
							            <h4 class="media-heading">Answer <span class="qa-meta">Admin&nbsp'.$data_time_a.'</sapn></h4>
											'.$asvalue['description'].' 
							        </div>

							    </div>
							';
						}
					}

					$html .=	'</div>';
					$html .=	'<hr>';
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

