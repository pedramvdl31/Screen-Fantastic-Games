<?php

namespace App;
use App\Job;
use App\RoleUser;
use App\User;
use App\Inventory;
use App\InvoiceItem;
use Session;
use Input;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
public static $add_roles = array(
        'firstname'=>'required',
        'lastname'=>'required',
        'naver_username'=>'required',
        'email'=>'required',
        'phone'=>'required',
        'street'=>'required',
        'zipcode'=>'required',
        'city'=>'required',
        'pretax'=>'required',
        'tax'=>'required',
        'aftertax'=>'required',
        'quantity'=>'required',
        'payment_id'=>'required',
        'payment_type'=>'required'
    );
    static public function PrepareForIndex($all_invos) {

    	if(isset($all_invos)) {
    		foreach ($all_invos as $ackey => $acvalue) {
				if(isset($acvalue['created_at'])) {
					$acvalue['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($acvalue['created_at']) );
				}    		
				if(isset($acvalue['status'])) {
					switch ($acvalue['status']) {
						case 1: // Set but not paid
							$acvalue['status_message']= '<span class="label label-success">Active</span>';
							break;
						case 1: // Recieved payment & success
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

    	return $all_invos;
    }

    static public function CreateCompleteArrayFromCartSession() {
        $output_array = [];
        if (Session::get('cart_session')) {
            $session_data = Session::get('cart_session');

            $subtotal = 0;
            $total = 0;
            $total_quantity = 0;

            foreach ($session_data as $item_id => $sdvalue) {
                $this_item = Inventory::find($item_id);
                $this_item_options = Inventory::PrepareInventoryOptions($item_id);
                $this_item_base_price = $this_item['unit_price'];

                foreach ($sdvalue as $option_id => $oivalue) {
                    $quantity = $oivalue['qty'];
                    $total_quantity += $quantity;
                    $this_option_title = $this_item_options[$option_id]['text']?$this_item_options[$option_id]['text']:null;
                    $this_options_price = $this_item_options[$option_id]['price']?$this_item_options[$option_id]['price']:null;
                    $base_price_and_extra = $this_item_base_price + $this_options_price;
                    $base_price_and_extra_view = number_format($base_price_and_extra,0);
                    $this_row_total = $base_price_and_extra * $quantity;
                    $this_row_total_view = number_format($this_row_total,0);
                    $subtotal += $this_row_total;

                    $output_array['cart'][$item_id][$option_id]['qty'] = $quantity;
                    $output_array['cart'][$item_id][$option_id]['option_id'] = $option_id;
                    $output_array['cart'][$item_id][$option_id]['title'] = $this_option_title;
                    $output_array['cart'][$item_id][$option_id]['option_price'] = $this_options_price;
                    $output_array['cart'][$item_id][$option_id]['row_total'] = $this_row_total;
                }
            }
            $new_subtotal = $subtotal;
            $output_array['prices']['base_price'] = $this_item_base_price;
            $output_array['prices']['subtotal'] = $subtotal;
            $output_array['prices']['total'] = $subtotal;
            $output_array['prices']['total_qty'] = $total_quantity;
        }
        // Job::dump($output_array);
        return $output_array;
    }


    static public function PrepareCheckoutTable($session_data) {
        $table_html = '';
        if(isset($session_data)) {
            $table_html .= '    <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <td><strong>Item Name</strong></td>
                                                <td class="text-center"><strong>Item Price</strong></td>
                                                <td class="text-center"><strong>Item Quantity</strong></td>
                                                <td class="text-right"><strong>Total</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>';
            $subtotal = 0;
            $total = 0;

            foreach ($session_data as $item_id => $sdvalue) {
                $this_item = Inventory::find($item_id);
                $this_item_options = Inventory::PrepareInventoryOptions($item_id);
                $this_item_base_price = $this_item['unit_price'];
                foreach ($sdvalue as $option_id => $oivalue) {
                    $quantity = $oivalue['qty'];
                    $this_option_title = $this_item_options[$option_id]['text']?$this_item_options[$option_id]['text']:null;
                    $this_options_price = $this_item_options[$option_id]['price']?$this_item_options[$option_id]['price']:null;
                        
                    $base_price_and_extra = $this_item_base_price + $this_options_price;
                    $base_price_and_extra_view = number_format($base_price_and_extra,0);
                    $this_row_total = $base_price_and_extra * $quantity;
                    $this_row_total_view = number_format($this_row_total,0);

                    $subtotal += $this_row_total;
                    $table_html .= ' <tr class="item-row">
                                        <td class="item-name">'.$this_option_title.'</td>
                                        <td class="text-center item-price">'.$base_price_and_extra_view.'원</td>
                                        <td class="text-center item-quantity" single-price="'.$base_price_and_extra.'">
                                          <div class="center">
                                              <div class="input-group">
                                                  <span class="input-group-btn">
                                                      <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                                                        <span class="glyphicon glyphicon-minus"></span>
                                                      </button>
                                                  </span>
                                                  <input type="text" name="items['.$item_id.']['.$option_id.'][qty]" class="form-control input-number " readonly value="'.$quantity.'" min="1" max="100">
                                                  <span class="input-group-btn">
                                                      <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                                          <span class="glyphicon glyphicon-plus"></span>
                                                      </button>
                                                  </span>
                                              </div>
                                        </div>
                                        </td>
                                        <td class="text-right item-row-total" this-total="'.$this_row_total.'">'.$this_row_total_view.'원</td>
                                    </tr>';
                }
            }

            $new_subtotal = number_format($subtotal,0);
            $total = number_format($subtotal + 0);
                $table_html .=  '<tr>
                        <td class="highrow"></td>
                        <td class="highrow"></td>
                        <td class="highrow text-center"><strong>Subtotal</strong></td>
                        <td class="highrow text-right subtotal-text">'.$new_subtotal.'원</td>
                    </tr>
                    <tr>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow text-center"><strong>Shipping</strong></td>
                        <td class="emptyrow text-right shipping-text" this-shipping="0">0</td>
                    </tr>
                    <tr>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow text-center"><strong>Total</strong></td>
                        <td class="emptyrow text-right total-text">'.$total.'원</td>
                    </tr>';

                $table_html .= '                </tbody>
                                        </table>
                                    </div>';

        }

        return $table_html;
    }
    static public function PrepareAdminCheckoutTable($session_data) {
        $table_html = '';

        if(isset($session_data)) {
            $new_array = [];
            //transform
            foreach ($session_data as $nakey => $navalue) {
                for ($i=1; $i <= $navalue['qty']; $i++) { 
                    array_push($new_array,$navalue['id']);
                }
                
            }
            $new_array_count = array_count_values($new_array);
            //CREATE NEW ARRAY
            $table_html .= '    <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <td><strong>Item Name</strong></td>
                                                <td class="text-center"><strong>Item Price</strong></td>
                                                <td class="text-center"><strong>Item Quantity</strong></td>
                                                <td class="text-right"><strong>Total</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>';
            $subtotal = 0;
            $total = 0;
            foreach ($new_array_count as $sdkey => $sdvalue) {

                $this_invoice = Inventory::find($sdkey);

                if (isset($this_invoice)) {
                    $total_real_number = $this_invoice->unit_price * $sdvalue;
                    $this_total =  number_format($this_invoice->unit_price * $sdvalue,0);
                    $new_price =  number_format($this_invoice->unit_price,0);
                    $subtotal += $this_invoice->unit_price * $sdvalue;
                    
                    $table_html .= ' <tr class="item-row">
                                        <td class="item-name">'.$this_invoice->title.'</td>
                                        <td class="text-center item-price">'.$new_price.'원</td>
                                        <td class="text-center item-quantity" single-price="'.$this_invoice->unit_price.'">
                                          <div class="center">
                                              <div class="input-group">
                                                  <span class="input-group-btn">
                                                      <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                                                        <span class="glyphicon glyphicon-minus"></span>
                                                      </button>
                                                  </span>
                                                  <input type="text" name="items['.$this_invoice->id.']" class="form-control input-number " readonly value="'.$sdvalue.'" min="1" max="100">
                                                  <span class="input-group-btn">
                                                      <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                                          <span class="glyphicon glyphicon-plus"></span>
                                                      </button>
                                                  </span>
                                              </div>
                                        </div>
                                        </td>
                                        <td class="text-right item-row-total" this-total="'.$total_real_number.'">'.$this_total.'원</td>
                                    </tr>';

                }
            }

            $new_subtotal = number_format($subtotal,0);


            $total = number_format($subtotal + 0);
                $table_html .=  '<tr>
                        <td class="highrow"></td>
                        <td class="highrow"></td>
                        <td class="highrow text-center"><strong>Subtotal</strong></td>
                        <td class="highrow text-right subtotal-text">'.$new_subtotal.'원</td>
                    </tr>
                    <tr>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow text-center"><strong>Shipping</strong></td>
                        <td class="emptyrow text-right shipping-text" this-shipping="0">0</td>
                    </tr>
                    <tr>
                        <td class="emptyrow"></td>
                        <td class="emptyrow"></td>
                        <td class="emptyrow text-center"><strong>Total</strong></td>
                        <td class="emptyrow text-right total-text">'.$total.'</td>
                    </tr>';



                $table_html .= '                </tbody>
                                        </table>
                                    </div>';

        }

        return $table_html;
    }

   	static public function PrepareSingleInvoice($inv) {

    	if(isset($inv)) {
				if(isset($inv['created_at'])) {
					$inv['created_at_html'] = date ( 'Y/n/d g:ia',  strtotime($inv['created_at']) );
				}    		
				if(isset($inv['status'])) {
					switch ($inv['status']) {
						case 1: // Set but not paid
							$inv['status_message']= '<span class="label label-success">Active</span>';
							break;
						case 2: // Recieved payment & success
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

				if (isset($inv['payment_merchant'])) {
					switch ($inv['payment_merchant']) {
						case 1: 
							$inv['payment_merchant_html']= '<span class="label label-success">Naver Pay</span>';
							break;
						case 2: 
							$inv['payment_merchant_html']= '<span class="label label-success">Direct Transaction</span>';
							break;
						}
				}
    	}
    	return $inv;
    }

    public static function PaymentSelect() {
        $cats = array(
                        ''=>'Select Payment Type',
                        '1' => 'Naver Pay',
                        '2' => 'Direct Payment'
                    );
        return $cats;
    }

    public static function ClearAllSessions() {
        Session::forget('sales_session');
        Session::forget('user_address');
        return 1;
    }





    public static function SaveInvoiceAndInvoiceItems($address,$session) {
        if (isset($address,$session)) {



            $new_items_array = [];
            $subtotal = 0;
            $total = 0;
            $total_qty = 0;
            foreach ($session as $itkey => $itvalue) {
                $this_item = Inventory::find($itkey);
                $this_qty = $itvalue['qty'];
                $this_total = $this_item->unit_price * $this_qty;
                $subtotal += $this_total;
                $total_qty += $itvalue['qty'];

                $new_items_array[$itkey]['item_id'] = $itkey;
                $new_items_array[$itkey]['item_title'] = $this_item->title;
                $new_items_array[$itkey]['item_price'] = $this_item->unit_price;
                $new_items_array[$itkey]['qty'] = $itvalue['qty'];
                $new_items_array[$itkey]['item_total_price'] = $this_item->unit_price * $itvalue['qty'];
            }
            $total = 0 + $subtotal;

            $tax_percentage = 10;
            $percentage_real_price = Job::GetPercentage($tax_percentage,$total);
            $percentage = Job::GetPercentage($tax_percentage,$total);
            $total_after_tax = $total + $percentage_real_price;


            $invoices = new Invoice;
            $invoices->name = $address['name'];
            $invoices->email = $address['email'];
            $invoices->phone = $address['phone'];
            $invoices->country = 'KR';
            $invoices->address_array = json_encode($address);
            $invoices->quantity = $total_qty;
            $invoices->subtotal = $subtotal;
            $invoices->total = $total_after_tax;
            $invoices->status = 1;
            if ($invoices->save()) {
                foreach ($new_items_array as $nakey => $navalue) {
                    $invoice_items = new InvoiceItem;
                    $invoice_items->invoice_id = $invoices->id;
                    $invoice_items->inventory_id = $navalue['item_id'];
                    $invoice_items->quantity = $navalue['qty'];
                    $invoice_items->total = $navalue['item_total_price'];
                    $invoice_items->status = 1;
                    $invoice_items->save();
                }
            }
            
        }
        return 1;
    }


    public static function CreateReceipt($address_session,$session_data) {
       
        $html = '';
        if (isset($address_session,$session_data)) {
                # code...
            $new_items_array = [];
            $subtotal = 0;
            $total = 0;
            $total_qty = 0;
            foreach ($session_data as $itkey => $itvalue) {
                $this_item = Inventory::find($itkey);
                $this_qty = $itvalue['qty'];
                $this_total = $this_item->unit_price * $this_qty;
                $subtotal += $this_total;
                $total_qty += $itvalue['qty'];

                $new_items_array[$itkey]['item_id'] = $itkey;
                $new_items_array[$itkey]['item_title'] = $this_item->title;
                $new_items_array[$itkey]['item_price'] = number_format($this_item->unit_price, 0, '', ',');
                $new_items_array[$itkey]['qty'] = $itvalue['qty'];
                $new_items_array[$itkey]['item_total_price'] = number_format($this_item->unit_price * $itvalue['qty'], 0, '', ',');
            }
            $total = 0 + $subtotal;

            $tax_percentage = 10;
            $percentage_real_price = Job::GetPercentage($tax_percentage,$total);
            $percentage = number_format(Job::GetPercentage($tax_percentage,$total), 0, '', ',');
            $total_after_tax = number_format($total + $percentage_real_price, 0, '', ',');


            $formatted_number = Job::MakePhoneFormat($address_session['phone']);


            $html = '
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- ----- -->
                            <hr style="border-top: 3px solid #387DA0;margin-bottom: 5px;">
                            <p style="color:#387DA0">금장사</p>
                            <div class="col-md-3" style="padding-left: 0;margin-top: 60px;">
                                <h4 style="margin-top:0">영수증 (고객용)</h4>
                                <h5 style="color:#387DA0">02-482-8900</h5>
                                <p>사울시 강동구 올림픽로 647 로석빌딩 긍장</p>
                            </div>

                            <div class="col-md-9" style="padding-right:0;">
                                <div class="col-md-5" style="padding-right:0;padding-left:0;margin-bottom: 20px;margin-top: 60px;">
                                    <p style="font-size: 12px;margin: 0 0 2px;">수신자 : '.$address_session['name'].'</p>
                                    <p style="font-size: 12px;margin: 0 0 2px;">연락처 : '.$formatted_number.'</p>
                                    <p style="font-size: 12px;margin: 0 0 2px;">주문일 : 2015. 10. 25.</p>
                                    <p style="font-size: 12px;margin: 0 0 2px;">완료일 : 2015. 10. 31.</p>
                                </div>
                                <div class="col-md-7 pull-right text-center" style="padding-right:0;padding-left:0;margin-bottom: 20px;">
                                    <div id="image" style="height: 130px;border-radius: 4px;border: 1px black dashed;">
                                        <span style="line-height:130px">image</span>
                                    </div>
                                </div>
                                    <style>
                                    table { border: none !important }
                                    th { border: 1px dashed #A3A2A2 !important;border-left: none !important;border-bottom: none !important; }
                                    tr { border: 1px dashed #A3A2A2 !important;border-left: none !important;border-right: none !important;border-bottom: none !important; }
                                    td { border: 1px dashed #A3A2A2 !important; border-right: none !important;border-bottom: none !important;}
                                    </style>
                                    <table class="table table-bordered">
                                     <thead> 
                                        <tr style="background-color: #4B9CC5;color: white;border-bottom: #A3A2A2 2px solid !important;"> 
                                            <th style="border-right: #A3A2A2 2px solid !important;">설명</th> 
                                            <th style="border-right: #A3A2A2 2px solid !important;">수량</th> 
                                            <th style="border-right: #A3A2A2 2px solid !important;">단가</th> 
                                            <th style="border-right: none !important;">비</th> 
                                        </tr> </thead> 
                                        <tbody>';

                                        foreach ($new_items_array as $niakey => $niavalue) {
                                            $html .= '
                                                <tr> 
                                                    <th scope="row"> '.$niavalue['item_title'].' (설명:  )</th> 
                                                    <td>'.$niavalue['qty'].'</td> <td>₩ '.$niavalue['item_price'].'</td>
                                                     <td>₩ '.$niavalue['item_total_price'].'</td> 
                                                </tr>
                                            ';
                                        }


                            $html .=        ' 
                                            <tr style="border-top: solid #878686 2px !important;">
                                                <th scope="row"></th> 
                                                    <td></td> 
                                                    <td>소계</td> 
                                                    <td>₩ '.number_format($total, 0, '', ',').'</td> 
                                            </tr> 
                                            <tr> <th scope="row"></th> <td>세금</td> <td>'.$tax_percentage.'.00%</td> <td>₩ '.$percentage.'</td> 
                                            </tr> 
                                            <tr style="border-top: solid #878686 2px !important;border-bottom: solid #878686 2px !important;"> <th scope="row"></th> <td></td> <td>전체</td> <td>₩ '.$total_after_tax.'</td> 
                                            </tr> 
                                        </tbody> 
                                    </table> 

                                    <p style="font-size: 12px;color: gray;">거래해 주셔서 감사합니다. 공휴일 및 주문물량 따른 제품출고가 지연되는 경우가 있습니다. 양해바랍니다.</p>
                                    <p style="font-size: 12px;color: gray;">1.&nbsp&nbsp대리 수령시 반드시 영수증 지참 바랍니다. (미지참시 대리수령 불가)</p>
                                    <p style="font-size: 12px;color: gray;">2.&nbsp&nbsp주문 및 수리는 출고일로 부터 6개월간 보관되며, 이후 보관에 따른 분실의 책임을 지지않습니다.</p>

                            </div>
                        <!-- ----- -->
                        </div>


                        <!-- ---------------------------- -->
                        <!-- ---------------------------- -->
                        <!-- ---------------------------- -->
                        <!-- ---------------------------- -->
                        <!-- ---------------------------- -->





                        <div class="col-md-6">
                            <!-- ----- -->
                            <hr style="border-top: 3px solid #387DA0;margin-bottom: 5px;">
                            <p style="color:#387DA0">금장사</p>
                            <div class="col-md-3" style="padding-left: 0;margin-top: 60px;">
                                <h4 style="margin-top:0">영수증 (고객용)</h4>
                                <h5 style="color:#387DA0">02-482-8900</h5>
                                <p>사울시 강동구 올림픽로 647 로석빌딩 긍장</p>
                            </div>

                            <div class="col-md-9" style="padding-right:0;">
                                <div class="col-md-5" style="padding-right:0;padding-left:0;margin-bottom: 20px;margin-top: 60px;">
                                    <p style="font-size: 12px;margin: 0 0 2px;">수신자 : '.$address_session['name'].'</p>
                                    <p style="font-size: 12px;margin: 0 0 2px;">연락처 : '.$formatted_number.'</p>
                                    <p style="font-size: 12px;margin: 0 0 2px;">주문일 : 2015. 10. 25.</p>
                                    <p style="font-size: 12px;margin: 0 0 2px;">완료일 : 2015. 10. 31.</p>
                                </div>
                                <div class="col-md-7 pull-right text-center" style="padding-right:0;padding-left:0;margin-bottom: 20px;">
                                    <div id="image" style="height: 130px;border-radius: 4px;border: 1px black dashed;">
                                        <span style="line-height:130px">image</span>
                                    </div>
                                </div>
                                    <style>
                                    table { border: none !important }
                                    th { border: 1px dashed #A3A2A2 !important;border-left: none !important;border-bottom: none !important; }
                                    tr { border: 1px dashed #A3A2A2 !important;border-left: none !important;border-right: none !important;border-bottom: none !important; }
                                    td { white-space: nowrap;border: 1px dashed #A3A2A2 !important; border-right: none !important;border-bottom: none !important;}
                                    </style>
                                    <table class="table table-bordered">
                                     <thead> 
                                        <tr style="background-color: #4B9CC5;color: white;border-bottom: #A3A2A2 2px solid !important;"> 
                                            <th style="border-right: #A3A2A2 2px solid !important;">설명</th> 
                                            <th style="border-right: #A3A2A2 2px solid !important;">수량</th> 
                                            <th style="border-right: #A3A2A2 2px solid !important;">단가</th> 
                                            <th style="border-right: none !important;">비</th> 
                                        </tr> </thead> 
                                        <tbody>';


                                        foreach ($new_items_array as $niakey => $niavalue) {
                                            $html .= '
                                                <tr> 
                                                    <th scope="row"> '.$niavalue['item_title'].' (설명:  )</th> 
                                                    <td>'.$niavalue['qty'].'</td> <td>₩ '.$niavalue['item_price'].'</td>
                                                     <td>₩ '.$niavalue['item_total_price'].'</td> 
                                                </tr>
                                            ';
                                        }

                            $html .=       '<tr style="border-top: solid #878686 2px !important;"> 
                                            <th scope="row"></th> 
                                            <td></td> 
                                            <td>소계</td>
                                             <td>₩ '.number_format($total, 0, '', ',').'</td> 
                                            </tr> 
                                            <tr> 
                                            <th scope="row"></th>
                                             <td>세금</td>
                                            <td>'.$tax_percentage.'.00%</td>
                                            <td>₩ '.$percentage.'</td> 
                                            </tr> 
                                            <tr style="border-top: solid #878686 2px !important;border-bottom: solid #878686 2px !important;"> 
                                            <th scope="row"></th> <td></td> <td>전체</td> <td>₩ '.$total_after_tax.'</td> 
                                            </tr> 
                                        </tbody> 
                                    </table> 

                                    <p style="font-size: 12px;color: gray;">거래해 주셔서 감사합니다. 공휴일 및 주문물량 따른 제품출고가 지연되는 경우가 있습니다. 양해바랍니다.</p>
                                    <p style="font-size: 12px;color: gray;">1.&nbsp&nbsp대리 수령시 반드시 영수증 지참 바랍니다. (미지참시 대리수령 불가)</p>
                                    <p style="font-size: 12px;color: gray;">2.&nbsp&nbsp주문 및 수리는 출고일로 부터 6개월간 보관되며, 이후 보관에 따른 분실의 책임을 지지않습니다.</p>
                            <div class="col-md-6" style="padding-left:0;margin-top: 20px;">
                                <p style="font-size: 13px;color: gray;">그 밖에 기록사항</p> 
                            </div>
                            <div class="col-md-6" style="margin-top: 20px;"> 
                                <p style="font-size: 13px;color: gray;">담당자 : </p>
                            </div>
                            
                            <div class="col-md-12" style="padding-left:0;padding-right:0">
                                <div class="well well-lg" style="height: 100px;
                                border-top: 1px dashed #B6B5B5;
                                border-top-left-radius: 0;
                                border-top-right-radius: 0;
                                "></div>
                            </div>   
                            

                            </div>

                            <!-- ----- -->
                        </div>

                    </div>
                </div>
            ';
        }
        return $html;
    }
    
    public static function SumUpSalesSession($data) {
        $ordering_array = [];
        if (isset($data)) {
            foreach ($data as $newdata => $newvalue) {
                $prev_qty = 0;
                if (isset($ordering_array[$newvalue['id']]['qty'])) {
                    $prev_qty = $ordering_array[$newvalue['id']]['qty'];
                } else {
                    $r_key = Job::generateRandomString(10);
                    $ordering_array[$newvalue['id']]['id'] = $newvalue['id'];
                    $ordering_array[$newvalue['id']]['order_id'] = $r_key;
                }
                $ordering_array[$newvalue['id']]['qty'] = $prev_qty + $newvalue['qty'];
            }   
            Session::forget('sales_session');
            Session::put('sales_session',$ordering_array);
        }
        return $ordering_array;
    }

    public static function PrepareCheckoutTableFromSession($data) {
        $html = '';
        if (isset($data)) {
            
            $ordering_array = Invoice::SumUpSalesSession($data);

            //GET TOTAL
            $total = 0;
            if (Session::get('sales_session')) {
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
            }
            foreach ($ordering_array as $key => $value) {
                $this_item = Inventory::find($value['id']);
                $qty = $value['qty'];
                $random_str = $value['order_id'];
                if (isset($this_item)) {
                    $primary_image_srcs = json_decode($this_item->primary_image);
                    $html .='<div class="row col-md-12 col-sm-12 col-xs-12 '.$random_str.'" style="margin-top:0">
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
                $html .= '
                    <div class="row col-md-12 col-sm-12 col-xs-12" style="margin-top:0" >
                        <h3>Total: <small id="total_text">'.$new_total.'원</small></h3>
                    </div>
                ';
        }
        return $html;
    }



}
