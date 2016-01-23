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
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use App\User;
use App\Thread;
use App\Category;
use App\Search; 
use App\Invoice; 
use App\Inventory; 
use App\Layout; 
use App\InvoiceItem; 
use App\WebsiteBrand;
use App\RoleUser;

class InvoicesController extends Controller
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
        $all_invoices = Invoice::PrepareForIndex(Invoice::all());
        return view('invoices.index')
        ->with('layout',$this->layout)
        ->with('all_invs',$all_invoices);
    }
    public function getAdd()
    {   
        $country = Job::country_code();
        $search_by = User::search_by();
        $payment_select = Invoice::PaymentSelect();
        return view('invoices.add')
        ->with('layout',$this->layout)
        ->with('search_by',$search_by)
        ->with('payment_select',$payment_select)
        ->with('country_code',$country);
    }

    public function postAdd()
    {   
        $validator = Validator::make(Input::all(), Invoice::$add_roles);
        if ($validator->passes()) {
            $invoices = new Invoice;
            $invoices->user_id = Input::get('customer_id');
            $invoices->naver_username = Input::get('naver_username');
            $invoices->firstname = Input::get('firstname');
            $invoices->lastname = Input::get('lastname');
            $invoices->email = Input::get('email');
            $invoices->phone = Input::get('phone');
            $invoices->country = Input::get('country');
            $invoices->city = Input::get('city');
            $invoices->street = Input::get('street');
            $invoices->zipcode = Input::get('zipcode');

            $invoices->pretax = Job::OnlyNumberFilter(Input::get('pretax'));
            $invoices->tax = Job::OnlyNumberFilter(Input::get('tax'));
            $invoices->aftertax = Job::OnlyNumberFilter(Input::get('aftertax'));

            $invoices->payment_id = Input::get('payment_id');
            $invoices->payment_merchant = Input::get('payment_type');
            $invoices->quantity = Input::get('quantity');
            $invoices->status = 1;
            if ($invoices->save()) {
                return Redirect::route('invoice_index');
            }

        } else {
            // validation has failed, display error messages   
            return Redirect::back()
                ->with('data', Input::get('customer_id'))
                ->with('message', 'The following errors occurred')
                ->with('alert_type','alert-danger')
                ->withErrors($validator)
                ->withInput();  
        }
    }


    public function getEdit($id = null)
    {   
        $invoices = Invoice::find($id);
        $country = Job::country_code();
        $search_by = User::search_by();
        $payment_select = Invoice::PaymentSelect();

        return view('invoices.edit')
            ->with('layout',$this->layout)
            ->with('country_code',$country)
            ->with('search_by',$search_by)
            ->with('payment_select',$payment_select)
            ->with('invoices',$invoices);
    }

    public function postEdit()
    {   
        $validator = Validator::make(Input::all(), Invoice::$add_roles);
        if ($validator->passes()) {
            $invoice_id = Input::get('invoice_id');
            $invoices = Invoice::find($invoice_id);
            $invoices->user_id = Input::get('customer_id');
            $invoices->naver_username = Input::get('naver_username');
            $invoices->firstname = Input::get('firstname');
            $invoices->lastname = Input::get('lastname');
            $invoices->email = Input::get('email');
            $invoices->phone = Input::get('phone');
            $invoices->country = Input::get('country');
            $invoices->city = Input::get('city');
            $invoices->street = Input::get('street');
            $invoices->zipcode = Input::get('zipcode');

            $invoices->pretax = Job::OnlyNumberFilter(Input::get('pretax'));
            $invoices->tax = Job::OnlyNumberFilter(Input::get('tax'));
            $invoices->aftertax = Job::OnlyNumberFilter(Input::get('aftertax'));

            $invoices->payment_id = Input::get('payment_id');
            $invoices->payment_merchant = Input::get('payment_type');
            $invoices->quantity = Input::get('quantity');
            $invoices->status = 1;
            if ($invoices->save()) {
                return Redirect::route('invoice_index');
            }

        } else {
            // validation has failed, display error messages   
            return Redirect::back()
                ->with('data', Input::get('customer_id'))
                ->with('message', 'The following errors occurred')
                ->with('alert_type','alert-danger')
                ->withErrors($validator)
                ->withInput();  
        }
    }

    public function getView($id = null)
    {   
        $invoices = Invoice::PrepareSingleInvoice(Invoice::find($id));
        return view('invoices.view')
            ->with('layout',$this->layout)
            ->with('invoices',$invoices);
    }

        public function postAddToCart()
    {
        if(Request::ajax()){
            $status = 400;
            $item_id = Input::get('i_id');
            $qty = Input::get('qty');

            $cart_session_count = 0;

            if (Session::get('cart_session')) {
                $status = 200;
                $s_data =   Session::get('cart_session');
                for ($i=1; $i <= $qty; $i++) { 
                    array_push($s_data,$item_id);
                }
                Session::put('cart_session',$s_data);
                # code...
            } else {
                $status = 200;
                $s_data = [];
                for ($i=1; $i <= $qty; $i++) { 
                    array_push($s_data,$item_id);
                }
                
                Session::put('cart_session',$s_data);
            }
            $cart_session_items_c = Session::get('cart_session')?Inventory::PrepareCartItemsDropdown(Session::get('cart_session')):null;
            $_count = $cart_session_items_c['all_count']?$cart_session_items_c['all_count']:0;
            return Response::json(array(
                'status' => $status,
                'cart_session_count' => $_count 
                ));
        }
    }
    

    public function postAddAndProceed()
    { 
        // Job::dump(Input::all());        
        $item_id = Input::get('item_id');
        $selected_options = Input::get('selected_input');

        $new_array = [];
        foreach ($selected_options as $item_id => $sovalue) {
            foreach ($sovalue as $option_id => $sovvalue) {
                $quantity = 0;
                foreach ($sovvalue as $count_key => $ckvalue) {
                    $quantity += $ckvalue['qty'];
                }
                $new_array[$item_id][$option_id]['qty'] = $quantity;
            }
        }

        if (Session::get('cart_session')) {
            // Job::dump($new_array);
            // Job::dump(Session::get('cart_session'));
            $cart_session = Session::get('cart_session');
            foreach ($new_array as $item_id => $iivalue) {
                foreach ($iivalue as $option_id => $opivalue) {
                    if (isset($cart_session[$item_id][$option_id])) {
                        $cart_session[$item_id][$option_id]['qty'] += $opivalue['qty'];
                    } else {
                        $cart_session[$item_id][$option_id]['qty'] = $opivalue['qty'];
                    }
                }
            }
            // Job::dump($cart_session);
            Session::put('cart_session',$cart_session);
        } else {
            $status = 200;
            $s_data = [];
            Session::put('cart_session',$new_array);
        }
        return Redirect::route('invoice_checkout');

    }  


    public function getCheckout()
    {   

        if (Auth::check()) {
            $layout = 'layouts.customize_layout';
            $session_data = Session::get('cart_session')?Session::get('cart_session'):null;
            $checkout_html = Invoice::PrepareCheckoutTable($session_data);
            $address_array = json_decode(Auth::user()->address_array,true);
            $user_phone = Auth::user()->phone?Auth::user()->phone:null;
            return view('invoices.checkout')
                ->with('item','empty')
                ->with('checkout_html',$checkout_html)
                ->with('user_id',Auth::user()->id)
                ->with('address_array',$address_array)
                ->with('user_phone',$user_phone)
                ->with('layout',$layout);
        } else {
            if (Session::get('checkout_data')) {
                return Redirect::route('invoice_checkout_guest');
            } else {
                return Redirect::route('invoice_user_login',0);
            }
        }           
    }

    public function postCheckoutConfirmation()
    {   
        
        $layout = 'layouts.customize_layout';
        $checkout_data = [];
        $user_id = Input::get('user_id');
        $address = [];
        if (!isset($user_id)) {
            $address = Input::get('address');
        } else {
            $this_user = User::find($user_id);
            if (isset($this_user)) {
                $address = json_decode($this_user->address_array,true);
                $address['name'] = $this_user->firstname.' '.$this_user->lastname;
                $address['email'] = $this_user->email;
                $address['phone'] = $this_user->phone;
            }
        }
        $items = Input::get('items');

        Session::forget('cart_session');
        Session::put('cart_session',$items);

        $new_items_array = Invoice::CreateCompleteArrayFromCartSession();

        $checkout_data['user_id'] = isset($user_id)?$user_id:0;
        $checkout_data['address'] = $address;
        $checkout_data['items'] = $new_items_array;
        Session::forget('checkout_data');
        Session::put('checkout_data',$checkout_data);

        if (isset($checkout_data['address']['phone'])) {
            $checkout_data['address']['phone'] = Job::MakePhoneFormat($checkout_data['address']['phone']);
        }

        return view('invoices.checkout_confirmation')
            ->with('layout',$layout)
            ->with('checkout_data',$checkout_data);
    }

    public function postCheckout()
    {   
        $error = true;
        // Job::dump(Session::get('checkout_data'));
        if (Session::get('checkout_data')) {
            // Job::dump(Session::get('checkout_data'));
            $checkout_data = Session::get('checkout_data');
            $items = $checkout_data['items']?$checkout_data['items']:null;
            if (isset($items)) {
                $invoices = new Invoice;
                $invoices->user_id = $checkout_data['user_id'];
                $invoices->address_array = json_encode($checkout_data['address']);
                $invoices->quantity = $items['prices']['total_qty'];
                $invoices->shipping_cost = 0;
                $invoices->subtotal = $items['prices']['subtotal'];
                $invoices->total = $items['prices']['total'];
                $invoices->status = 1;
                if ($invoices->save()) {
                    foreach ($items['cart'] as $item_id => $ivalue) {
                        foreach ($ivalue as $option_id => $opivalue) {
                            $invoice_item = new InvoiceItem();
                            $invoice_item->invoice_id = $invoices->id;
                            $invoice_item->inventory_id = $item_id;
                            $invoice_item->option_id = $option_id;
                            $invoice_item->quantity = $opivalue['qty'];
                            $invoice_item->total = $opivalue['row_total'];
                            $invoice_item->status = 1;
                            $invoice_item->save();
                        }
                    }
                    $user_email = $checkout_data['address']['email'];

                    if (Mail::send('emails.order_success', array(
                        'checkout_data' => $checkout_data
                    ), function($message) use ($user_email)
                    {
                        $message->to($user_email)->cc($user_email);
                        $message->subject('Order Details');
                    })) {
                        Session::forget('cart_session');
                        Session::forget('checkout_data');
                        return Redirect::route('home_index');
                    }
                }
                $error = false;
            }
        }
        if ($error == true) {
            Session::forget('checkout_data');
            Session::forget('cart_session');
            Flash::success('Oops Something Went Wrong!');
            return Redirect::route('home_index');
        }

    }

        public function getUserLoginPage($id = null)
    {   
        $layout = 'layouts.customize_layout';
        return view('invoices.user_login')
            ->with('layout',$layout)
            ->with('incorrect',$id);

    }
    public function getCheckoutAsGuest()
    {   
        if (Auth::check()) {
            return Redirect::route('invoice_checkout');
        } else {
            $checkout_data = Session::get('checkout_data')?Session::get('checkout_data'):null;
            $layout = 'layouts.customize_layout';
            $cart_session_count = Session::get('cart_session')?sizeof(Session::get('cart_session')):0;
            $session_data = Session::get('cart_session')?Session::get('cart_session'):null;
            $checkout_html = Invoice::PrepareCheckoutTable($session_data);
            return view('invoices.checkout')
                ->with('layout',$layout)
                ->with('item','empty')
                ->with('checkout_html',$checkout_html)
                ->with('checkout_data',$checkout_data)
                ->with('cart_session_count',$cart_session_count); 
           
        }
    }

        public function getResetAddressGuest()
    {   
        Session::forget('checkout_data');
        return Redirect::route('invoice_checkout_guest');
    }

        public function postLoginInvoices()
    {
        $username = Input::get('username');
        $password = Input::get('password');
        if (Auth::attempt(array('username'=>$username, 'password'=>$password))) {
            return Redirect::route('invoice_checkout');
        } else { //LOGING FAILED
            return Redirect::route('invoice_user_login',1);
        }
    }

        public function getRestCart()
    {
        Session::forget('cart_session');
        if (Session::get('_previous')) {
            $route_ = Session::get('_previous');
            return Redirect::to($route_['url']);
        } else {
            return Redirect::route('home_index',null);
        }
    }  

        public function getDeleteItemCart($id = null)
    {
        // Job::dump(Session::get('_previous'));
        $error = false;
        $data = null;
        $new_data = null;
        if (isset($id)) {
            if (Session::get('cart_session')) {
                // Job::dump(Session::get('cart_session'));
                $ids = explode('-', $id);
                $item_id = $ids[0];
                $option_id = $ids[1];
                $data = Session::get('cart_session');
                if (isset($data[$item_id][$option_id])) {
                    unset($data[$item_id][$option_id]);
                }
                Session::forget('cart_session');
                Session::put('cart_session',$data);
                if (Session::get('_previous')) {
                    $route_ = Session::get('_previous');
                    return Redirect::to($route_['url']);
                } else {
                    return Redirect::route('home_index',null);
                }

            } else {
                $error = true;
            }
            # code...
        } else {
            $error = true;
        }

        if ($error == true) {
            return Redirect::route('home_index');
        }

    }  

        public function getRestLiked()
    {
        Session::forget('liked_session');
        if (Session::get('_previous')) {
            $route_ = Session::get('_previous');
            return Redirect::to($route_['url']);
        } else {
            return Redirect::route('home_index');
        }
    }  

        public function getDeleteItemLiked($id = null)
    {
        $error = false;
        $data = null;
        $new_data = null;
        if (isset($id)) {
            if (Session::get('liked_session')) {
                $data = Session::get('liked_session');
                foreach ($data as $cdkey => $cdvalue) {
                    if ($cdvalue == $id) {
                        unset($data[$cdkey]);
                    }
                }
                $new_data = array_values($data);
                Session::forget('liked_session');
                Session::put('liked_session',$new_data);
                if (Session::get('_previous')) {
                    $route_ = Session::get('_previous');
                    return Redirect::to($route_['url']);
                } else {
                    return Redirect::route('home_index');
                }
            } else {
                $error = true;
            }
            # code...
        } else {
            $error = true;
        }
        if ($error == true) {
            return Redirect::route('home_index');
        }

    }  
    
    public function getSalesIndex()
    {   
        $all_invoices = Invoice::PrepareForIndex(Invoice::all());
        return view('invoices.sales_index')
        ->with('layout',$this->layout)
        ->with('all_invs',$all_invoices);
    }

    public function getSalesAdd()
    {   
        $search_by = Inventory::search_by();
        $session_data = Session::get('sales_session')?Session::get('sales_session'):null;
        $ch_html = Invoice::PrepareCheckoutTableFromSession($session_data);
        return view('invoices.sales_add')
        ->with('search_by',$search_by)
        ->with('ch_html',$ch_html)
        ->with('layout',$this->layout);
    }
    
    public function postAdminCheckout()
    {
        $session_data = Session::get('sales_session')?Session::get('sales_session'):null;
        
        $checkout_html = Invoice::PrepareAdminCheckoutTable($session_data);
        $search_by = User::search_by();
        $country_code = Job::country_code();
        return view('invoices.sales_checkout')
        ->with('layout',$this->layout)
        ->with('country_code',$country_code)
        ->with('search_by',$search_by)
        ->with('checkout_html',$checkout_html);
    }
    public function postAdminCheckoutConfirmation()
    {
        $address_type = Input::get('address_type');
        $address = Input::get('address_'.$address_type);
        if ($address_type == 'add_user') {
            $check = User::where('username',$address['username'])->first();
                if(!isset($check)) {
                    $user = new User;
                    $user->roles = 5;
                    $user->username = $address['username'];
                    $user->firstname = $address['first_name'];
                    $user->lastname = $address['last_name'];
                    $user->email = $address['email'];
                    $user->age = $address['age'];
                    $user->password = Hash::make($address['password']); 
                    $user->address_array = $address['arr']?json_encode($address['arr']):null; 
                    $user->profile_image = Input::get('profile-image')?$final_path.'.'.$image_type:'blank_male.png';           
                    if($user->save()) { // Save the user and redirect to owners home
                    //ASSIGN LEVEL TWO ACL (GUESTS)
                    $new_rule = new RoleUser;
                    $new_rule->role_id = 5;
                    $new_rule->user_id = $user->id;
                    $new_rule->save();
                    Flash::success('User successfully been registered as '.$user->username.'!');
                    }                    
                }
        }
        $items = Input::get('items');

        $session_data = Session::get('sales_session')?Session::get('sales_session'):null;
        if (isset($session_data,$items)) {
            foreach ($items as $itemskey => $itemsvalue) {
                $session_data[$itemskey]['qty'] = $itemsvalue;
            }
            Session::forget('sales_session');
            Session::put('sales_session',$session_data);
        }


        $cart_session_replace = [];
        $counter = 0;
        foreach ($items as $itemskey => $itemsvalue) {
            for ($i=1; $i <=$itemsvalue ; $i++) { 
                $cart_session_replace[$counter] = $itemskey;
                $counter++;
            }
        }
        $new_items_array = [];
        $shipping_cost = Input::get('shipping_cost')?Input::get('shipping_cost'):0;
        $subtotal = 0;
        $total = 0;
        $total_qty = 0;
        foreach ($items as $itkey => $itvalue) {
            $this_item = Inventory::find($itkey);
            $this_qty = $itvalue;
            $this_total = $this_item->unit_price * $this_qty;
            $subtotal += $this_total;
            $total_qty += $itvalue;

            $new_items_array[$itkey]['item_id'] = $itkey;
            $new_items_array[$itkey]['item_title'] = $this_item->title;
            $new_items_array[$itkey]['item_price'] = number_format($this_item->unit_price, 0, '', ',');
            $new_items_array[$itkey]['qty'] = $itvalue;
            $new_items_array[$itkey]['item_total_price'] = number_format($this_item->unit_price * $itvalue, 0, '', ',');
        }
        $total = $shipping_cost + $subtotal;
        $checkout_data['items'] = $new_items_array;
        $checkout_data['user_id'] = Input::get('user_id')?Input::get('user_id'):null;


        if ($address_type == 'add_user') {
            $address['arr']['phone'] = $address['phone'];
            $address['arr']['email'] = $address['email'];
            $address['arr']['name'] = $address['first_name'].' '.$address['last_name'];
            $checkout_data['address'] = $address['arr'];
            if (isset($address['phone'],$address['email'])) {
                Session::put('user_address',$checkout_data['address']);
            } else {
                $checkout_data['address'] = Session::get('user_address');
            }
        } else{
            if (!empty($address['phone'])) {
                $checkout_data['address'] = $address;
                Session::put('user_address',$address);
            } else {
                $checkout_data['address'] = Session::get('user_address');
            }
        }

        $checkout_data['subtotal'] = number_format($subtotal, 0, '', ',');
        $checkout_data['shipping_cost'] = number_format($shipping_cost, 0, '', ',');
        $checkout_data['total'] = number_format($total, 0, '', ',');

        return view('invoices.sales_checkout_confirmation')
            ->with('layout',$this->layout)
            ->with('checkout_data',$checkout_data);

    }
    public function postSalesAdd()
    {
        $address_session = Session::get('user_address')?Session::get('user_address'):null;
        $session_data = Session::get('sales_session')?Session::get('sales_session'):null;
        Invoice::SaveInvoiceAndInvoiceItems($address_session,$session_data);
        Invoice::ClearAllSessions();
        Flash::success('Successfully Added');
        $search_by = Inventory::search_by();
        $session_data = Session::get('sales_session')?Session::get('sales_session'):null;
        $ch_html = Invoice::PrepareCheckoutTableFromSession($session_data);
        return view('invoices.sales_add')
        ->with('search_by',$search_by)
        ->with('ch_html',$ch_html)
        ->with('layout',$this->layout);

    }
    public function getSalesEdit($id = null)
    {   

    }
    public function postSalesEdit()
    {

    }
    public function getViewReceipt()
    {   
        $address_session = Session::get('user_address')?Session::get('user_address'):null;
        $session_data = Session::get('sales_session')?Session::get('sales_session'):null;
        $receipt_html = Invoice::CreateReceipt($address_session,$session_data);

        Invoice::SaveInvoiceAndInvoiceItems($address_session,$session_data);

        return view('invoices.receipt')
            ->with('layout','layouts.clear_layout')
            ->with('receipt_html',$receipt_html);
    }
    
}
