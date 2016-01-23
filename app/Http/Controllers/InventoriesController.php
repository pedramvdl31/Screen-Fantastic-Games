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
use App\Review;

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
use App\Invoice;
use App\Tag;
use App\WebsiteBrand;
use App\QuestionsNAnswer;
use App\InventoryOption;

class InventoriesController extends Controller
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
    public function getIndex()
    {   
        $all_invs = Inventory::PrepareForIndex(Inventory::all());
        return view('inventories.index')
        ->with('layout',$this->layout)
        ->with('all_invs',$all_invs);
    }
    public function getOrder()
    {   
        $all_inventories = Inventory::PrepareInventoriesForOrder(Inventory::orderBy('order')->get());
        $pages_for_select = Page::PerparePagesSelect();
        return view('inventories.order')
            ->with('layout',$this->layout)
            ->with('pages_for_select',$pages_for_select)
            ->with('all_inventories',$all_inventories);
    }

    public function postOrder()
    {   
        $order_array = Input::get('order-input');

        foreach ($order_array as $key => $value) {
            $this_inv = Inventory::find($key);
            $this_inv->order = $value;
            $this_inv->save();
        }

        Flash::success('Successfully Re-ordered');
        return Redirect::route('inventory_index');

    }

    public function getAdd()
    {   
        $categories = Category::PrepareCatsForSelect(Category::get());
        $pages_for_select = Page::PerparePagesSelect();
        $pages_checkboxes_html = Inventory::PreparePagesCheckbox(Layout::where('status',1)->get());
        $tags_for_select = Tag::PrepareAllTagsForSelect();

        return view('inventories.add')
        ->with('layout',$this->layout)
        ->with('tags_for_select',$tags_for_select)
        ->with('pages_for_select',$pages_for_select)
        ->with('pages_checkboxes_html',$pages_checkboxes_html)
        ->with('categories',$categories);
    }

    public function postAdd()
    {   
        // Job::dump(Input::all());
        $image_main = Input::get('files');
        $images = Input::get('files-extra');
        $image_des = Input::get('files-des');
        $image_main_name = [];
        $image_des_name = [];
        $image_names = [];

        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($image_main)) {
            foreach ($image_main as $immkey => $immvalue) {
                $imagem_ex = explode('/', $immvalue['path']);
                $imagem_ex_name_type = $imagem_ex[5];
                $image_main_name[$immkey] = $imagem_ex_name_type;
            }
        }
        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($image_des)) {
            foreach ($image_des as $imdkey => $imdvalue) {
                $imaged_ex = explode('/', $imdvalue['path']);
                $imaged_ex_name_type = $imaged_ex[5];
                $image_des_name[$imdkey] = $imaged_ex_name_type;
            }
        }
        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($images)) {
            foreach ($images as $imkey => $imvalue) {
                $image_ex = explode('/', $imvalue['path']);
                $image_ex_name_type = $image_ex[5];
                $image_names[$imkey] = $image_ex_name_type;
            }
        }
        
        $validator = Validator::make(Input::all(), inventory::$add_roles);
        if ($validator->passes()) {
            $title = Input::get('inventory-title');
            $categories = Input::get('categories');
            $description = Input::get('inventory-description');

            $price = Job::OnlyNumberFilter(Input::get('price'));
            $tax = Job::OnlyNumberFilter(Input::get('tax'));

            $tag_text = Input::get('tag_text');

            $inventories = new Inventory;
            $inventories->title = $title;
            $inventories->serial_number = Input::get('inventory-serial-number');
            $inventories->description = $description;
            $inventories->unit_price = $price;
            $inventories->category_id = $categories;
            $inventories->tags_array = json_encode(Input::get('tag'));
            $inventories->layouts = json_encode(Input::get('layouts'));
            $inventories->image_srcs = json_encode($image_names);
            $inventories->primary_image = json_encode($image_main_name);
            $inventories->description_image = json_encode($image_des_name);
            $inventories->status = 1;

            if ($inventories->save()) {
                if (!file_exists('assets/images/inventories/perm')) {
                    mkdir('assets/images/inventories/perm', 0777, true);
                }

                //SAVE OPTIONS
                $all_options = Input::get('options');
                if (isset($all_options)) {
                    foreach ($all_options as $allopkey => $allopvalue) {
                        $inventory_options = new InventoryOption;
                        $inventory_options->inventory_id = $inventories->id;
                        $inventory_options->text = $allopvalue['text'];
                        $inventory_options->price = $allopvalue['price'];
                        $inventory_options->status = 1;
                        $inventory_options->save();
                    }
                }

                //SAVE INVENTORY ORDER
                $inventories->order = $inventories->id;
                $inventories->save();

                //SAVE IMAGES
               foreach ($image_names as $inkey => $invalue) {
                    $oldpath = public_path("assets/images/inventories/temp/".$invalue);
                    $newpath = public_path("assets/images/inventories/perm/".$invalue);
                    rename($oldpath, $newpath);
               }
               foreach ($image_main_name as $inmkey => $inmvalue) {
                    $oldmpath = public_path("assets/images/inventories/temp/".$inmvalue);
                    $newmpath = public_path("assets/images/inventories/perm/".$inmvalue);
                    rename($oldmpath, $newmpath);
               }
               foreach ($image_des_name as $indkey => $indvalue) {
                    $olddpath = public_path("assets/images/inventories/temp/".$indvalue);
                    $newdpath = public_path("assets/images/inventories/perm/".$indvalue);
                    rename($olddpath, $newdpath);
               }
                return Redirect::route('inventory_index');
    
                } else {
                    Flash::error('Error: Oops');
                    return Redirect::back();
                }
        }
        else {
           foreach ($image_names as $inkey => $invalue) {
                $oldpath = public_path("assets/images/inventories/temp/".$invalue);
                unlink($oldpath);
           }
            // validation has failed, display error messages    
            return Redirect::back()
                ->with('message', 'The following errors occurred')
                ->with('alert_type','alert-danger')
                ->withErrors($validator)
                ->withInput();  
        }
    }


    public function getEdit($id = null)
    {   
        if (isset($id)) {
            $pages_checkboxes_html = Inventory::PreparePagesCheckboxForEdit(Layout::where('status',1)->get(),Inventory::find($id));
            $categories = Category::PrepareCatsForSelect(Category::get());
            $inventory = Inventory::PrepareSingleInventoryForEdit(Inventory::find($id));
            $select_data = Inventory::PerpareInventoriesListForSelect();
            $tags_for_select = Tag::PrepareAllTagsForSelect();

            return view('inventories.edit')
                ->with('layout',$this->layout)
                ->with('pages_checkboxes_html',$pages_checkboxes_html)
                ->with('categories',$categories)
                ->with('tags_for_select',$tags_for_select)
                ->with('inventory',$inventory)
                ->with('select_data',$select_data);
        }
    }

    public function postEdit()
    {   
        $image_main = Input::get('pre_files_primary');
        $image_des = Input::get('pre_files_description');
        $image_main_name = [];
        $image_des_name = [];

        $main_change_indi = Input::get('main_changed');
        $des_change_indi = Input::get('des_changed');

        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($image_main)) {
            foreach ($image_main as $immkey => $immvalue) {
                $imagem_ex = explode('/', $immvalue['path']);
                $imagem_ex_name_type = $imagem_ex[5];
                $image_main_name[$immkey] = $imagem_ex_name_type;
            }
        }
        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($image_des)) {
            foreach ($image_des as $imdkey => $imdvalue) {
                $imaged_ex = explode('/', $imdvalue['path']);
                $imaged_ex_name_type = $imaged_ex[5];
                $image_des_name[$imdkey] = $imaged_ex_name_type;
            }
        }

        $images = Input::get('pre_files');
        $new_images = Input::get('files');
        $del_images = Input::get('del_files');
        $image_names = [];
        $new_image_name = [];
        $deleted_image_names = [];

        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($images) && !empty($images)) {
            foreach ($images as $imkey => $imvalue) {
                $image_ex_pre = explode('/', $imvalue['path']);
                $image_ex_name_type_pre = $image_ex_pre[5];
                $image_names[$imkey] = $image_ex_name_type_pre;
            }
        }

        $pre_count = sizeof($image_names);
        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($new_images) && !empty($new_images)) {
            foreach ($new_images as $nimkey => $nimvalue) {
                $image_ex_new = explode('/', $nimvalue['path']);
                $image_ex_name_type_new = $image_ex_new[5];
                $new_image_name[$nimkey]=$image_ex_new[5];
                $image_names[$pre_count] = $image_ex_name_type_new;
                $pre_count++;
            }
        }
        //GO THROUGH ALL IMAGES AND SAVE THE NAMES
        if (isset($del_images) && !empty($del_images)) {
            foreach ($del_images as $nimkey => $nimvalue) {
                $image_ex_del = explode('/', $nimvalue['path']);
                $image_ex_name_type_del = $image_ex_del[5];
                $deleted_image_names[$nimkey] = $image_ex_name_type_del;
            }
        }

        $validator = Validator::make(Input::all(), inventory::$add_roles);
        if ($validator->passes()) {
            $title = Input::get('inventory-title');
            $description = Input::get('inventory-description');
            $price = Job::OnlyNumberFilter(Input::get('price'));
            $tax = Job::OnlyNumberFilter(Input::get('tax'));

            $status = Input::get('status');
            $id = Input::get('inv_id');
            $inventories = Inventory::find($id);
            $inventories->tags_array = json_encode(Input::get('tag'));
            $inventories->title = $title;
            $inventories->serial_number = Input::get('inventory-serial-number');
            $inventories->description = $description;
            $inventories->unit_price = $price;
            $inventories->category_id = Input::get('categories');
            $inventories->tax = $tax;
            $inventories->layouts = json_encode(Input::get('layouts'));
            $image_names = array_values($image_names);
            $inventories->image_srcs = json_encode($image_names);

            if (!empty($image_main_name)) {
                $inventories->primary_image = json_encode($image_main_name);
            }
            if (!empty($image_des_name)) {
                $inventories->description_image = json_encode($image_des_name);
            }  

            $inventories->status = $status;
            if ($inventories->save()) {

                //DELETED OPTIONS
                $deleted_options = Input::get('deleted-option');
                if (isset($deleted_options)) {
                    foreach ($deleted_options as $dokey => $dovalue) {
                        $this_options = InventoryOption::find($dovalue);
                        if (isset($this_options)) {
                            $this_options->delete();
                        }
                    }
                }


                //SAVE OPTIONS
                $all_options = Input::get('options');
                if (isset($all_options)) {
                    foreach ($all_options as $allopkey => $allopvalue) {
                        $inventory_options = new InventoryOption;
                        $inventory_options->inventory_id = $inventories->id;
                        $inventory_options->text = $allopvalue['text'];
                        $inventory_options->price = $allopvalue['price'];
                        $inventory_options->status = 1;
                        $inventory_options->save();
                    }
                }

               if (isset($deleted_image_names)) {
                   foreach ($deleted_image_names as $dinkey => $dinvalue) {
                        $path = public_path("assets/images/inventories/perm/".$dinvalue);
                        unlink($path);
                   }
               }
               if (isset($new_image_name)) {
                   foreach ($new_image_name as $neinkey => $neinvalue) {
                        $oldpath = public_path("assets/images/inventories/temp/".$neinvalue);
                        $newpath = public_path("assets/images/inventories/perm/".$neinvalue);
                        rename($oldpath, $newpath);
                   }
               }

               if (!empty($image_main_name) && $main_change_indi == true) {
                    foreach ($image_main_name as $inmkey => $inmvalue) {
                        $oldmpath = public_path("assets/images/inventories/temp/".$inmvalue);
                        $newmpath = public_path("assets/images/inventories/perm/".$inmvalue);
                         rename($oldmpath, $newmpath);
                     }
               }
               if (!empty($image_des_name) && $des_change_indi == true ) {
                   foreach ($image_des_name as $indkey => $indvalue) {
                        $olddpath = public_path("assets/images/inventories/temp/".$indvalue);
                        $newdpath = public_path("assets/images/inventories/perm/".$indvalue);
                        rename($olddpath, $newdpath);
                   }
               }


                return Redirect::route('inventory_index');
                } else {
                    Flash::error('Error: Oops');
                    return Redirect::back();
                }
        }
        else {
            if (isset($image_names)) {
                if (!empty($image_names)) {
                    foreach ($image_names as $inkey => $invalue) {
                        $oldpath = public_path("assets/images/inventories/temp/".$invalue);
                        unlink($oldpath);
                   }
                }
            }
            // validation has failed, display error messages    
            return Redirect::back()
                ->with('message', 'The following errors occurred')
                ->with('alert_type','alert-danger')
                ->withErrors($validator)
                ->withInput();  
        }
    }

    public function getView($id = null)
    {   
        if (isset($id)) {
            $inventory = Inventory::PrepareSingleInventory(Inventory::find($id));
            return view('inventories.view')
                ->with('layout',$this->layout)
                ->with('inventory',$inventory);
        }
    }

    public function getViewItem($id = null)
    {   
        if (isset($id)) {
            $layout = 'layouts.customize_layout';
            $item = Inventory::PrepareItemForViewItems(Inventory::find($id));
            $qna_html = Auth::check()?QuestionsNAnswer::PrepareQnAForViewItem($id):null;
            $review_html = Review::PrepareReviewForViewItem($id);
            $this_i = Inventory::find($id);
            $options = Inventory::PrepareInventoryOptions($id);

            return view('inventories.view-items')
                ->with('layout',$layout)
                ->with('qna_html',$qna_html)
                ->with('review_html',$review_html)
                ->with('options',$options)
                ->with('item',$item);                
        }
    }
        public function postUpload()
    {

        error_reporting(E_ALL | E_STRICT);
        $destinationPath = public_path("assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR);
        $savePath = DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."inventories".DIRECTORY_SEPARATOR."temp".DIRECTORY_SEPARATOR;
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
       public function postDelete()
    {
        $id = Input::get('inv_idd');
        $inventories = Inventory::find($id);
        $image_sources =json_decode($inventories->image_srcs) ;

        if ($inventories->delete()) {
            foreach ($image_sources as $inkey => $invalue) {
                $oldpath = public_path("assets/images/inventories/perm/".$invalue);
                unlink($oldpath);
           }
           return Redirect::route('inventory_index');
        }

    }
            public function postItemLiked()
    {

            if(Request::ajax()){
            $status = 400;
            $item_id = Input::get('this_id');
            $liked_session_count = 0;

            if (Session::get('liked_session')) {
                $status = 200;
                $s_data =   Session::get('liked_session');

                $is_exists = false;
                foreach ($s_data as $sdkey => $sdvalue) {
                    if ($sdvalue == $item_id) {
                        $is_exists = true;
                    }
                }

                if ($is_exists == false) {
                    array_push($s_data,$item_id);
                }
                
                Session::put('liked_session',$s_data);
                # code...
            } else {
                $status = 200;
                $s_data = array($item_id);
                Session::put('liked_session',$s_data);
            }
            $liked_session_count = sizeof(Session::get('liked_session'));


            $liked_session_html = Session::get('liked_session')?
            Inventory::PrepareLikedHtmlAjax(Inventory::PrepareLikedItemsDropdown(Session::get('liked_session'))):null;


            return Response::json(array(
                'status' => $status,
                'liked_session_count' => $liked_session_count,
                'liked_session_html' => $liked_session_html 
                ));
        }
  
    } 
       public function postLikeRemoved()
    {

        if(Request::ajax()){
            $status = 400;
            $item_id = Input::get('this_id');
            $liked_session_count = 0;
            $is_exists = false;
            if (Session::get('liked_session')) {
                $status = 200;
                $s_data =   Session::get('liked_session');
                foreach ($s_data as $sdkey => $sdvalue) {
                    if ($sdvalue == $item_id) {
                        $is_exists = true;
                    }
                }
                if ($is_exists == true) {
                    $status = 200;
                    $arr = array_diff(Session::get('liked_session'), array($item_id));
                    Session::put('liked_session',$arr);
                }
            }
            
            $liked_session_count = sizeof(Session::get('liked_session'));
            $liked_session_html = Inventory::PrepareLikedHtmlAjax(Inventory::PrepareLikedItemsDropdown(Session::get('liked_session')));
            
            return Response::json(array(
                'status' => $status,
                'liked_session_count' => $liked_session_count,
                'liked_session_html' => $liked_session_html 
                ));
        }
  
    } 
       public function postReturnItem()
    {
        if(Request::ajax()){
            $status = 400;
            $items = null;
            $search = Input::get('search');
            if (isset($search)) {
                $status = 200;
                $items = Inventory::PrepareItemsHtml($search);
            }
            return Response::json(array(
                'status' => $status,
                'items' => $items
                ));
        }
  
    } 
       public function postItemSelected()
    {
        if(Request::ajax()){
            $status = 400;
            $html_data = '';
            $id = Input::get('item_id');
            $qty = Input::get('qty');
            $this_item = Inventory::find($id);
            if (isset($this_item)) {
                $status = 200;
                $session_data = Session::get('sales_session')?Session::get('sales_session'):null;
                $data_array = [];
                $random_str = Job::generateRandomString(10);
                if (isset($session_data)) {
                    $new_array = [];
                    $new_array["id"] = $id;
                    $new_array["qty"] = $qty;
                    $new_array["order_id"] = $random_str;
                    array_push($session_data,$new_array);
                    Session::put('sales_session',$session_data);
                } else {
                    $new_array = [];
                    $new_array["id"] = $id;
                    $new_array["qty"] = $qty;
                    $new_array["order_id"] = $random_str;
                    array_push($data_array,$new_array);
                    Session::put('sales_session',$data_array);
                }


                //GET TOTAL
                $total = 0;
                $new_session = Session::get('sales_session');
                if (Session::get('sales_session')) {
                    foreach ($new_session as $nskey => $nsvalue) {
                        $this_item_id = $nsvalue['id'];
                        $qty = $nsvalue['qty'];
                        $this_item = Inventory::find($this_item_id);
                        $this_item_price = 0;
                        if (isset($this_item)) {
                            $this_item_price = $this_item->unit_price;
                        }
                        $total+= $this_item_price * $qty;
                    }
                }

                $ordering_array = Invoice::SumUpSalesSession($new_session);

                foreach ($ordering_array as $key => $value) {
                    $this_item = Inventory::find($value['id']);
                    $qty = $value['qty'];
                    $random_str = $value['order_id'];
                    if (isset($this_item)) {
                        $primary_image_srcs = json_decode($this_item->primary_image);
                        $html_data .='<div class="row col-md-12 col-sm-12 col-xs-12 '.$random_str.'" style="margin-top:0">
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <h4>'.$qty.'</h4>
                                    </div> 
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <img src="/assets/images/inventories/perm/'.$primary_image_srcs[0].'" alt="" style="height: 60px;">
                                    </div>
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <p>'.$this_item->title.'</p>
                                    </div>
                                    <div class="col-md-1 col-sm-1 col-xs-1">
                                        <i class="remove_this_item glyphicon glyphicon-trash remove-item" item_id="'.$this_item->id.'" item_qty="'.$qty.'" order_id="'.$random_str.'"></i>
                                    </div> 
                                </div>
                                <div class="row col-md-12 col-sm-12 col-xs-12 '.$random_str.' " style="margin-top:0" >
                                    <hr>
                                </div>';
                    }

                }
                $new_total = number_format($total, 0, '', ',');
                $html_data .= '
                    <div class="row col-md-12 col-sm-12 col-xs-12" style="margin-top:0" >
                        <h3>Total: <small id="total_text">'.$new_total.'원</small></h3>
                    </div>
                ';
            }


            // Session::forget('sales_session');
            return Response::json(array(
                'status' => $status,
                'html_data' => $html_data
                ));
        }
  
    } 
       public function postItemRemoved()
    {
        if(Request::ajax()){
            $status = 200;
            $id = Input::get('order_id');
            $session_data = Session::get('sales_session')?Session::get('sales_session'):null;
            if (isset($session_data)) {
                foreach ($session_data as $key => $value) {
                    if ($value['order_id'] == $id) {
                        unset($session_data[$key]);
                    }
                }
            } 
            Session::forget('sales_session');
            Session::put('sales_session',$session_data);


            $total = 0;
            $new_session = Session::get('sales_session');
            foreach ($new_session as $nskey => $nsvalue) {
                $this_item_id = $nsvalue['id'];
                $qty = $nsvalue['qty'];
                $this_item = Inventory::find($this_item_id);
                $this_item_price = 0;
                if (isset($this_item)) {
                    $this_item_price = $this_item->unit_price;
                }
                $total+= $this_item_price * $qty;
            }
            $new_total = number_format($total, 0, '', ',').'원';
            return Response::json(array(
                'status' => $status,
                'new_total' => $new_total,
                ));
        }
  
    } 
       public function postViewAllItems()
    {
        if(Request::ajax()){
            $status = 200;
            $items = Inventory::PrepareAllItemsHtml();
            return Response::json(array(
                'status' => $status,
                'html_data_s' => $items,
                ));
        }
    } 

}
