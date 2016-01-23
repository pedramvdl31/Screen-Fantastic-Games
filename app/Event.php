<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    static public function PrepareForIndex($all_events) {

    	if(isset($all_events)) {
    		foreach ($all_events as $ackey => $acvalue) {
				if(isset($acvalue['created_at'])) {
					$acvalue['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($acvalue['created_at']) );
				}    		
				if(isset($acvalue['status'])) {

					if ($acvalue['status'] == 3) {
						$acvalue['status_message']= '<span class="label label-danger">Deleted</span>';
					} else {
						$this_date = strtotime($acvalue->event_date);
			    		$now_time = time();
			    		if ($this_date > $now_time) {
			    			$acvalue['status_message']= '<span class="label label-success">Active</span>';
			    		} else {
			    			$acvalue['status_message']= '<span class="label label-warning">Ended</span>';
			    		}
					}
				}
			}

    	}

    	return $all_events;
    }


    static public function PrepareEventForEdit($event) {

    	if(isset($event)) {
                if(isset($event['created_at'])) {
                    $event['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($event['created_at']) );
                }
                if(isset($event['description'])) {
                	$event['decoded_description'] = json_decode($event['description']);
                }           
          
    	}

    	return $event;
    }

    static public function CountEventsForIndex() {

    	$events = Event::all();
    	$all_count = 0;
    	foreach ($events as $key => $event) {
    		$this_date = strtotime($event->event_date);
    		$now_time = time();
    		if ($this_date > $now_time) {
    			$all_count++;
    		}
    	}

    	return $all_count;
    }

    static public function PrepareEventsForEventPage() {
    	$all_events = Event::all();
    	if(isset($all_events)) {
    		foreach ($all_events as $ackey => $acvalue) {
				if(isset($acvalue['created_at'])) {
					$acvalue['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($acvalue['created_at']) );
				}    		
				if(isset($acvalue['status'])) {

					if ($acvalue['status'] == 3) {
						$acvalue['status_message']= '<span class="label label-danger">Deleted</span>';
					} else {
						$this_date = strtotime($acvalue->event_date);
			    		$now_time = time();
			    		if ($this_date > $now_time) {

			    			$acvalue['status_message']= '<span class="label label-success">Active</span>';
			    		} else {
			    			$acvalue['status_message']= '<span class="label label-warning">Ended</span>';
			    		}
					}
				}

				if(isset($acvalue['description'])) {
                	$acvalue['decoded_description'] = json_decode($acvalue['description']);
				}  

				if(isset($acvalue['event_date'])) {
						$this_date = strtotime($acvalue['event_date']);
			    		$now_time = time();
			    		$new_date = date('l jS M',$this_date);
			    		if ($this_date > $now_time) {
							$acvalue['date_formated_label']= '<span class="label label-warning pull-right event_date_label">'.$new_date.'</span>';
			    		} else {
							$acvalue['date_formated_label']= '<span class="label label-danger pull-right event_date_label">'.$new_date.'&nbspEnded!</span>';
			    		}
				}  
			}
    	}
    	return $all_events;
    }

    
}
