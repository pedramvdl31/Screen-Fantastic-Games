<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;
use App\InventoryOption;
class Inventory extends Model
{
	public static $add_roles = array(
        'inventory-title'=>'required',
        'inventory-description'=>'required',
        'price' => 'required'
    );
    static public function PrepareForIndex($all_invs) {

    	if(isset($all_invs)) {
    		foreach ($all_invs as $ackey => $acvalue) {
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

    	return $all_invs;
    }

    public static function search_by() {
            return array(
                ''          => 'Search Item by',
                'id'        => 'item id',
                'title'      => 'title',
                'price_range'  => 'price range',
                );
    }

    static public function PrepareSingleInventory($inv) {

    	if(isset($inv)) {
				if(isset($inv['created_at'])) {
					$inv['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($inv['created_at']) );
				}    		
				if(isset($inv['status'])) {
					switch ($inv['status']) {
						case 1: // Set but not paid
							$inv['status_message']= '<span class="label label-success">Active</span>';
							break;
						case 1: // Recieved payment & success
							$inv['status_message']= '<span class="label label-warning">Inactive</span>';
							break;

						case 3: // Recieved with error
							$inv['status_message']= '<span class="label label-danger">Error</span>';
							break;

						default:
							$inv['status_message']= '<span class="label label-default">Deleted</span>';
							break;
					}
				}

				if (isset($inv['image_srcs'])) {
					$new_srcs = json_decode($inv['image_srcs']);
					foreach ($new_srcs as $iskey => $isvalue) {
						if (is_array($new_srcs)) {
							$new_srcs[$iskey] = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isvalue;
						} else {
							$new_srcs->$iskey = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isvalue;
						}
					}

					$inv['image_srcs'] = $new_srcs;
				}
    	}
    	return $inv;
    }

    static public function PrepareItemForViewItems($inv) {

    	if(isset($inv)) {
            if(isset($inv['created_at'])) {
                $inv['created_at_html'] = date ( 'Y/n/d',  strtotime($inv['created_at']) );
                $new_format = date ( 'Y-n-d h:i:s A',  strtotime($inv['created_at']) );
                $inv['human_time'] = Job::formatTimeAgo(Job::humanTiming($new_format));
            }           
            if(isset($inv['unit_price'])) {
                //korean currency formating
                $inv['formated_unit_price'] = number_format($inv['unit_price'], 0, '', ',');
            }           
			if(isset($inv['status'])) {
				switch ($inv['status']) {
					case 1: // Set but not paid
						$inv['status_message']= '<span class="label label-success">Still Available</span>';
						break;
					case 3: // Recieved with error
						$inv['status_message']= '<span class="label label-danger">Error</span>';
						break;

					default:
						$inv['status_message']= '<span class="label label-default">Deleted</span>';
						break;
				}
			}
			$count_item = 0;
			if (isset($inv['image_srcs'])) {
				$new_srcs = json_decode($inv['image_srcs']);
				foreach ($new_srcs as $iskey => $isvalue) {
					$count_item++;
					if (is_array($new_srcs)) {
						$new_srcs[$iskey] = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isvalue;
					} else {
						$new_srcs->$iskey = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isvalue;
					}
				}
				$inv['image_srcs'] = $new_srcs;
			}
            
            if (isset($inv['primary_image'])) {
                $new_srcsp = json_decode($inv['primary_image'],true);
                
                if (!empty($new_srcsp)) {
                    if (isset($new_srcsp)) {
                        foreach ($new_srcsp as $ispkey => $ispvalue) {
                                $inv['primary_image'] = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$ispvalue;
                        }

                    }
                }
            }

            if (isset($inv['description_image'])) {
                $new_srcsd = json_decode($inv['description_image']);
                if (!empty($new_srcsd)) {
                    if (isset($new_srcsd)) {
                        foreach ($new_srcsd as $isdkey => $isdvalue) {
                            if (is_array($new_srcsd)) {
                                $new_srcsd[$isdkey] = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isdvalue;
                            } else {
                                $new_srcsd->$isdkey = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isdvalue;
                            }
                        }

                    }
                }

                $inv['description_image'] = $new_srcsd;
            }
    	}
    	return $inv;
    }



    static public function PrepareInventoryOptions($id) {
        $inv = Inventory::find($id);
        $new_array = [];
        if (isset($inv)) {
            $all_options = InventoryOption::where('status',1)->where('inventory_id',$inv->id)
                                            ->get();
            if (isset($all_options)) {
                foreach ($all_options as $allkey => $allvalue) {
                    $new_array[$allkey+1]['id'] = $allvalue->id;
                    $new_array[$allkey+1]['text'] = $allvalue->text;
                    $new_array[$allkey+1]['price'] = $allvalue->price;
                }
            }
        }
        return $new_array;
    }

    

    static public function PrepareSingleInventoryForEdit($inv) {

    	if(isset($inv)) {
                if(isset($inv['created_at'])) {
                    $inv['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($inv['created_at']) );
                }           
                if(isset($inv['tags_array'])) {
                    $tags = json_decode($inv['tags_array']);
                    $new_tag_array = [];
                    if (isset($tags)) {
                        foreach ($tags as $ttkey => $ttvalue) {
                            $this_tag = Tag::find($ttkey);
                            if (isset($this_tag)) {
                                $new_tag_array[$ttkey] = $this_tag->title;
                            }
                        }
                    }
                    $inv['tags_title'] = $new_tag_array;
                }           
    	}
        if (isset($inv['image_srcs'])) {
            $new_srcs = json_decode($inv['image_srcs']);
            if (!empty($new_srcs)) {
                if (isset($new_srcs)) {
                    foreach ($new_srcs as $iskey => $isvalue) {
                        if (is_array($new_srcs)) {
                            $new_srcs[$iskey] = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isvalue;
                        } else {
                            $new_srcs->$iskey = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isvalue;
                        }
                    }

                }
            }

            $inv['image_srcs'] = $new_srcs;
        }

        if (isset($inv['primary_image'])) {
            $new_srcsp = json_decode($inv['primary_image']);
            if (!empty($new_srcsp)) {
                if (isset($new_srcsp)) {
                    foreach ($new_srcsp as $ispkey => $ispvalue) {
                        if (is_array($new_srcs)) {
                            $new_srcsp[$ispkey] = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$ispvalue;
                        } else {
                            $new_srcsp->$ispkey = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$ispvalue;
                        }
                    }

                }
            }

            $inv['primary_image'] = $new_srcsp;
        }
        if (isset($inv['id'])) {
            $all_options = InventoryOption::where('status',1)->where('inventory_id',$inv->id)
                                            ->get();
            $new_array = [];
            if (isset($all_options)) {
                foreach ($all_options as $allkey => $allvalue) {
                    $new_array[$allkey+1]['id'] = $allvalue->id;
                    $new_array[$allkey+1]['text'] = $allvalue->text;
                    $new_array[$allkey+1]['price'] = $allvalue->price;
                }
            }
            $inv['decoded_options'] = $new_array;
        }

        if (isset($inv['description_image'])) {
            $new_srcsd = json_decode($inv['description_image']);
            if (!empty($new_srcsd)) {
                if (isset($new_srcsd)) {
                    foreach ($new_srcsd as $isdkey => $isdvalue) {
                        if (is_array($new_srcsd)) {
                            $new_srcsd[$isdkey] = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isdvalue;
                        } else {
                            $new_srcsd->$isdkey = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."perm".DIRECTORY_SEPARATOR.$isdvalue;
                        }
                    }

                }
            }

            $inv['description_image'] = $new_srcsd;
        }
    	return $inv;
    }


    static public function PrepareInventoriesForIndex($inv,$prefered_layout_set) {
    	if (isset($inv)) {


    		foreach ($inv as $invkey => $invvalue) {
                $invvalue['included'] = false;
                if (isset($invvalue->layouts)) {
                    $layouts = json_decode($invvalue->layouts);
                    if (isset($layouts)) {
                        foreach ($layouts as $key => $value) {
                            $this_title = strtolower($key);
                            if ($this_title == $prefered_layout_set['strtolow_title']) {
                                $invvalue['included'] = true;
                            }
                        }
                    }
                }

                if(isset($invvalue['tags_array'])) {
                    $tags = json_decode($invvalue['tags_array']);
                    $new_tag_array = [];
                    if (isset($tags)) {
                        foreach ($tags as $ttkey => $ttvalue) {
                            $this_tag = Tag::find($ttkey);
                            if (isset($this_tag)) {
                                $new_tag_array[$ttkey] = $this_tag->title;
                            }
                        }
                    }
                    $invvalue['tags_title'] = $new_tag_array;
                } 

    			if (isset($invvalue->unit_price)) {
                    $invvalue['sum_price'] = number_format($invvalue->unit_price, 0, '', ',');
    			}
    			//KEEP THE FIRST PICTURE FOR THE THUMBNAIL
                if (isset($invvalue->image_srcs)) {
                        $new_srcs = json_decode($invvalue->image_srcs);
                        if (!empty($new_srcs)) {
                            $invvalue['thumbnail_image_src'] = $new_srcs[0];
                        }
                }
                if (isset($invvalue->primary_image)) {
                    $new_primary = json_decode($invvalue->primary_image,true);
                    foreach ($new_primary as $npkey => $npvalue) {
                       $invvalue['primary_0_src'] = $npvalue;
                    }
                    
                }
    			if (isset($invvalue->category_id)) {
    				$categories = Category::find($invvalue->category_id);
    				if (isset($categories)) {
    					$invvalue['cat_title'] = $categories->title;
    				} else {
    					$invvalue['cat_title'] = 'error';
    				}
    			}
    		}
    		
    	} else {
    		$inv = false;
    	}


        $new_inv = [];
        if (isset($inv)) {
        	foreach ($inv as $nikey => $nivalue) {
                if ($nivalue['included']==true) {
                    if (isset($nivalue->cat_title)) {
                        $new_inv[$nivalue->cat_title][$nivalue->id] = $nivalue;
                    } else {
                        $new_inv['no-title'][$nivalue->id] = $nivalue;
                    }
                }
        	}
        }

    	return $new_inv;
    }
    static public function PrepareInventoriesForOrder($inv) {

    	if (isset($inv)) {
    		foreach ($inv as $invkey => $invvalue) {
    			if (isset($invvalue->tax)) {
    				if (isset($invvalue->unit_price)) {
    					$sum = $invvalue->tax + $invvalue->unit_price;
    					$invvalue['sum_price'] = number_format($sum);
    				}
    			}
    			//KEEP THE FIRST PICTURE FOR THE THUMBNAIL
    			if (isset($invvalue->image_srcs)) {
    					$new_srcs = json_decode($invvalue->image_srcs);
    					if (!empty($new_srcs)) {
    						$invvalue['thumbnail_image_src'] = $new_srcs[0];
    					}
    			}
    			if (isset($invvalue->category_id)) {
    				$categories = Category::find($invvalue->category_id);
    				if (isset($categories)) {
    					$invvalue['cat_title'] = $categories->title;
    				} else {
    					$invvalue['cat_title'] = 'error';
    				}
    			}
    		}
    		
    	} else {
    		$inv = false;
    	}

    	return $inv;
    }

    public static function PerpareInventoriesListForSelect() {
        $cats = array(
                        ''=>'Select Role',
                        '1' => 'Active',
                        '2' => 'Inactive',
                        '3' => 'Deleted'
                    );
        return $cats;
    }
    public static function PrepareAllItemsHtml() {
        $items = Inventory::where('status',1)->get();
        $html['data'] = '<div class="row" style="margin-top:0">';
        foreach ($items as $itkey => $itvalue) {
            $options = Inventory::PrepareInventoryOptions($itvalue->id);
            $primary_image_srcs = json_decode($itvalue->primary_image);
            $html['data'] .= '
              <div class="col-sm-6 col-md-4">
                <div class="thumbnail thumbnail-fix-height" style="height:auto;min-height:240px">
                  <img src="/assets/images/inventories/perm/'.$primary_image_srcs[0].'" alt="..." style="height: 90px;">
                  <div class="caption">
                    <h4>'.$itvalue->title.'</h4>
                    <p>'.$itvalue->description.'</p>
                    <p>Price: '.$itvalue->unit_price.'</p>';



                    $html['data'] .= '<select class="form-control" class="all_options">';
                    foreach ($options as $aokey => $ao) {
                        $html['data'] .= $ao["text"];
                         $html['data'] .= '<option value="'.$ao["price"].'" option-id="'.$ao["id"].'">'.$ao["text"].'';
                              if($ao["price"]>0) {
                                $html['data'] .=    '&nbsp(+₩'.$ao["price"].')';
                              }
                         $html['data'] .=   '</option>';
                    }
                    $html['data'] .= '</select>';



            $html['data'] .= '        
                        <p>
                        <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant[2]">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                            </span>
                            <input type="text" name="items[2]" class="form-control input-number " readonly="" value="1" min="1" max="100">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                  <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </span>
                        </div>
                    </p>
                    <p><a class="btn btn-primary btn-block select-item-btn" role="button" item_id="'.$itvalue->id.'">Select</a></p>
                  </div>
                </div>
              </div>
            ';
        }
        $html['data'] .= '</div>';
        return $html;
    }

    public static function PrepareItemsHtml($search) {
        $html = [];
        $html['message'] = "Couldn't Find Any Items";
        $html['data'] = "";
        foreach ($search as $key => $value) {
            $type = $key;
            switch ($type) {
                case 'id':
                $item = Inventory::find($value);
                if (isset($item)) {
                    $primary_image_srcs = json_decode($item->primary_image);
                    $html['data'] = '
                        <div class="row" style="margin-top:0">
                          <div class="col-sm-6 col-md-4">
                            <div class="thumbnail thumbnail-fix-height" style="height:auto;min-height:240px">
                              <img src="/assets/images/inventories/perm/'.$primary_image_srcs[0].'" alt="..." style="height: 90px;">
                              <div class="caption">
                                <h4>'.$item->title.'</h4>
                                <p>'.$item->description.'</p>
                                <p>Price: '.$item->unit_price.'</p>

                                <p>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                          <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant[2]">
                                            <span class="glyphicon glyphicon-minus"></span>
                                          </button>
                                        </span>
                                        <input type="text" name="items[2]" class="form-control input-number " readonly="" value="1" min="1" max="100">
                                        <span class="input-group-btn">
                                          <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                              <span class="glyphicon glyphicon-plus"></span>
                                          </button>
                                        </span>
                                    </div>
                                </p>


                                <p><a class="btn btn-primary btn-block select-item-btn" role="button" item_id="'.$item->id.'">Select</a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                    ';
                }

                break;
                case 'title':
                    $items = Inventory::where('title','LIKE','%'.$value.'%')->get();
                    if (isset($items)) {
                        $html['data'] = '<div class="row" style="margin-top:0">';
                        foreach ($items as $itkey => $itvalue) {
                            $primary_image_srcs = json_decode($itvalue->primary_image);
                            $html['data'] .= '
                              <div class="col-sm-6 col-md-4">
                                <div class="thumbnail thumbnail-fix-height" style="height:auto;min-height:240px">
                                  <img src="/assets/images/inventories/perm/'.$primary_image_srcs[0].'" alt="..." style="height: 90px;">
                                  <div class="caption">
                                    <h4>'.$itvalue->title.'</h4>
                                    <p>'.$itvalue->description.'</p>
                                    <p>Price: '.$itvalue->unit_price.'</p>
                                    <p>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant[2]">
                                                <span class="glyphicon glyphicon-minus"></span>
                                              </button>
                                            </span>
                                            <input type="text" name="items[2]" class="form-control input-number " readonly="" value="1" min="1" max="100">
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                            </span>
                                        </div>
                                    </p>
                                    <p><a class="btn btn-primary btn-block select-item-btn" role="button" item_id="'.$itvalue->id.'">Select</a></p>
                                  </div>
                                </div>
                              </div>
                            ';
                        }
                        $html['data'] .= '</div>';

                    }
                break;
                case 'price_range':
                    $min = $value['min'];
                    $max = $value['max'];
                    if ($min < $max) {
                        $items = Inventory::where('unit_price','>=',$min)
                                            ->where('unit_price','<=',$max)->get();
                        if (isset($items)) {
                            $html['data'] = '<div class="row" style="margin-top:0">';
                            foreach ($items as $itkey => $itvalue) {
                                $primary_image_srcs = json_decode($itvalue->primary_image);
                                $html['data'] .= '
                                  <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail thumbnail-fix-height" style="height:auto;min-height:240px">
                                      <img src="/assets/images/inventories/perm/'.$primary_image_srcs[0].'" alt="..." style="height: 90px;">
                                      <div class="caption">
                                        <h4>'.$itvalue->title.'</h4>
                                        <p>'.$itvalue->description.'</p>
                                        <p>Price: '.$itvalue->unit_price.'</p>
                                        <p>
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                  <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant[2]">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                  </button>
                                                </span>
                                                <input type="text" name="items[2]" class="form-control input-number" readonly="" value="1" min="1" max="100">
                                                <span class="input-group-btn">
                                                  <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                                      <span class="glyphicon glyphicon-plus"></span>
                                                  </button>
                                                </span>
                                            </div>
                                        </p>

                                        <p><a class="btn btn-primary btn-block select-item-btn" role="button" item_id="'.$itvalue->id.'">Select</a></p>
                                      </div>
                                    </div>
                                  </div>
                                ';
                            }
                            $html['data'] .= '</div>';
                        }
                        
                    }
                break;
                // default:
                // foreach ($value as $column_name => $column_value) {
                //     $users = User::where($column_name,'LIKE','%'.$column_value.'%')->get();
                // }

                // if(count($users) == 0) {
                //     $status = 401;
                //     $message = 'No such user';
                // }
                break;
            }
        }
        return $html;
    }


    
    public static function PreparePagesCheckbox($data) {

        $html = '';
        if (isset($data)) {
            foreach ($data as $dkey => $dvalue) {
                $lowered_title = strtolower($dvalue->title);
                $html .= ' <div class="checkbox">
                            <label>
                              <input type="checkbox" name="layouts['.$lowered_title.']">'.$dvalue->title.'
                            </label>
                          </div>
                          ';  
            }
        }
        return $html;
    }
    public static function PreparePagesCheckboxForEdit($data,$Inventory) {

        $html = '';
        if (isset($data,$Inventory)) {
            $layouts = json_decode($Inventory->layouts);
            foreach ($data as $dkey => $dvalue) {
                $lowered_title = strtolower($dvalue->title);
                $checked='';
                if (!empty($layouts)) {
                    foreach ($layouts as $lkey => $lvalue) {
                        if ($lkey == $lowered_title) {
                            $checked = 'checked';
                        }
                    }
                }

                $html .= ' <div class="checkbox">
                            <label>
                              <input '.$checked.' type="checkbox" name="layouts['.$lowered_title.']">'.$dvalue->title.'
                            </label>
                          </div>
                          ';  
            }
        }
        return $html;
    }


    public static function PrepareCartCount($cart_data) {
        $count = 0 ;
        if (isset($cart_data)) {
            foreach ($cart_data as $item_id => $cvalue) {
                foreach ($cvalue as $option_id => $opivalue) {
                    $count += 1;
                }
            }
        }
        return $count;
    }
    public static function PrepareCartItemsDropdown($cart_data) {
        $data_output = null;
        $data_output2 = null;
        $all_count = 0;
        if (isset($cart_data)) {
            foreach ($cart_data as $item_id => $cvalue) {
                $this_item = Inventory::find($item_id);
                $primary_image = json_decode($this_item['primary_image'],true);
                if (isset($this_item)) {
                    $this_item_options = Inventory::PrepareInventoryOptions($item_id);
                    foreach ($cvalue as $option_id => $opivalue) {
                        $data_output[$item_id][$option_id]['title'] = $this_item_options[$option_id]['text']?$this_item_options[$option_id]['text']:null;
                        $data_output[$item_id][$option_id]['qty'] = $opivalue['qty'];
                        $data_output[$item_id][$option_id]['primary_image'] = $primary_image[0]?$primary_image[0]:null;
                    }
                }
            }
        }
        return $data_output;
    }
    public static function PrepareLikedItemsDropdown($liked_data) {
        $data_output = null;
        if (isset($liked_data)) {
            $occurrence_array = array_count_values($liked_data);
            foreach ($liked_data as $cdkey => $cdvalue) {
                $data_output[$cdvalue]['item_id'] = $cdvalue;
                $item = Inventory::find($cdvalue);
                if (isset($item)) {
                    $data_output[$cdvalue]['item_title'] = $item->title;
                    $data_output[$cdvalue]['primary_image'] = json_decode($item->primary_image,true);
                }
            }
            $all_count = sizeof($occurrence_array);
            $data_output['all_count']= $all_count;
        }
        // Job::dump($data_output);
        return $data_output;
    }
    public static function PrepareLikedHtmlAjax($liked_session_items) {
        $html = '';
        if (isset($liked_session_items)) {
            if (isset($liked_session_items['all_count'])) {
                if ($liked_session_items['all_count'] > 0) {
                    $html .= '<span class="badge like-badge" style="">'.$liked_session_items['all_count'].'</span>
                              <a type="button" class="no-padding-top btn btn-default dropdown-toggle vpscu-toogle clearfix vpscu_icons" style=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="glyphicon glyphicon-star liked-heart liked-icon"></i><span class="caret caret-cls"></span>
                                <span class="badge like-badge-toogle" style="display:none">'.$liked_session_items['all_count'].'</span>
                              </a>';
                } else {
                            $html .= ' <span class="badge like-badge" style=""></span>
                            <a type="button" class="no-padding-top btn btn-default dropdown-toggle vpscu-toogle clearfix vpscu_icons" style=""
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="glyphicon glyphicon-star-empty liked-heart liked-icon"></i>
                            </a>'; 
                }
            } else {
                $html .= ' <span class="badge like-badge" style=""></span>
                            <a type="button" class="no-padding-top btn btn-default dropdown-toggle vpscu-toogle clearfix vpscu_icons" style=""
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="glyphicon glyphicon-star-empty liked-heart liked-icon"></i>
                            </a>';
            }
            $html .= '<ul class="dropdown-menu vpscu-icons-dropdown">';
            if (isset($liked_session_items)) {
                foreach ($liked_session_items as $litemskey => $litems) {
                    if($litemskey != 'all_count' ){
                        $html .= '  <li class="pull-right col-md-12 col-sm-12 col-xs-12 vpscu-icons-li">
                                      <a class="clearfix col-md-12 vpscu-dropdown-a" style="">
                                        <div class="col-md-4" style="padding-left: 0;padding-right: 0;">
                                          <img class="" src="/assets/images/inventories/perm/'.$litems['primary_image'][0].'" height="70px" width="70px"  alt="">
                                        </div>
                                        <div class="col-md-6" style="white-space: normal;padding-left: 0;margin-top:20px;">
                                          '.$litems['item_title'].'
                                        </div>  
                                        <div class="col-md-2" style="padding-left: 0;padding-right: 4px;">
                                          <!-- delete-item-cart -->
                                            <i class="glyphicon glyphicon-remove-circle delete-single-item-liked pull-right" item-id="'.$litems['item_id'].'"  style="font-size: 18px;color: #4B4B4B;"></i>
                                        </div>
                                      </a>
                                    </li>';
                    }
                }
            }
            if (isset($liked_session_items)) {
                $html .= '<li><a href="invoices/reset-liked">Delete all likes</a></li>';
            }
            $html .= '</ul>';
        } 
        
        return $html;
    }


}
