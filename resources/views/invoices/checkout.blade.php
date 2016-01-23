@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/layouts/general.css') !!}
{!! Html::style('/assets/css/invoices/checkout.css') !!}
{!! Html::style('/assets/css/design_tools/postcodify.css') !!}
@stop
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.postcodify/3.3.0/search.min.js"></script>
<script src="/assets/js/design_tools/postcodify.js"></script>
<!-- 위에서 생성한 <div>에 검색 기능을 표시하고, 결과를 입력할 <input>들과 연동한다 -->
<script>
    $(function() { 
        $("#postcodify").postcodify({
        insertPostcode5 : "#postcode",
        insertAddress : "#korean_new_address",
        insertJibeonAddress: "#korean_old_address",
        insertDetails : "#details",
        insertExtraInfo : "#extra_info",
        insertEnglishAddress: "#english_address",
        hideOldAddresses : false
    }); 
    });
</script>

<script src="/assets/js/invoices/checkout.js"></script>
@stop
@section('content')
{!! Form::open(array('action' => 'InvoicesController@postCheckoutConfirmation', 'id'=>'fileupload', 'class'=>'','role'=>"form")) !!}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-center panel-title"><strong>Order summary</strong></h3>
                </div>
                <div class="panel-body">
                  {!! $checkout_html !!}
                </div>
            
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                     @if(Auth::check())
                            @if(isset($user_id))
                                <h3 class="text-center panel-title clearfix" style="margin-right:5px"><strong>Address Book</strong><a class="btn btn-default pull-right btn-sm">Add/Edit Address</a></h3>

                            @endif 
                    @elseif(isset($checkout_data))
                        <h3 class="text-center panel-title clearfix" style="margin-right:5px"><strong>Address Book</strong><a class="btn btn-default pull-right btn-sm" href="{!!route('reset-address-guest')!!}">Reset Address</a></h3>
                    @else

                        <h3 class="text-center panel-title"><strong>Address Book</strong></h3>
                    @endif
                </div>
                <div class="panel-body">
                        @if(Auth::check())
                            @if(isset($user_id))
                            <address>
                              <strong>우편번호:&nbsp</strong>{!!$address_array['postcode']?$address_array['postcode']:''!!}<br>
                              <strong>도로명주소:&nbsp</strong>{!!$address_array['korean_new_address']?$address_array['korean_new_address']:''!!}<br>
                              <strong>지번주소:&nbsp</strong>{!!$address_array['korean_old_address']?$address_array['korean_old_address']:''!!}<br>
                              <strong>영문주소:&nbsp</strong>{!!$address_array['english_address_address']?$address_array['english_address_address']:''!!}<br>
                              <strong>상세주소:&nbsp</strong>{!!$address_array['details']?$address_array['details']:''!!}<br>
                              <abbr title="Phone">P:</abbr> {!!$user_phone?$user_phone:''!!}
                            </address>
                            @endif 
                        @elseif(isset($checkout_data))
                            <address>
                              <strong>우편번호:&nbsp</strong>{!!isset($checkout_data['address']['postcode'])?$checkout_data['address']['postcode']:''!!}<br>
                              <strong>도로명주소:&nbsp</strong>{!!isset($checkout_data['address']['korean_new_address'])?$checkout_data['address']['korean_new_address']:''!!}<br>
                              <strong>지번주소:&nbsp</strong>{!!isset($checkout_data['address']['korean_old_address'])?$checkout_data['address']['korean_old_address']:''!!}<br>
                              <strong>영문주소:&nbsp</strong>{!!isset($checkout_data['address']['english_address_address'])?$checkout_data['address']['english_address_address']:''!!}<br>
                              <strong>상세주소:&nbsp</strong>{!!isset($checkout_data['address']['details'])?$checkout_data['address']['details']:''!!}<br>
                              <abbr title="Phone">P:</abbr> {!!isset($checkout_data['address']['phone'])?$checkout_data['address']['phone']:''!!}
                            </address>
                            <input type="hidden" class="form-control" name="address[name]" id="name" value="{!!isset($checkout_data['address']['name'])?$checkout_data['address']['name']:''!!}" >
                            <input type="hidden" class="form-control" name="address[email]" id="email"  value="{!!isset($checkout_data['address']['email'])?$checkout_data['address']['email']:''!!}">
                            <input type="hidden" class="form-control" name="address[phone]" id="phone" value="{!!isset($checkout_data['address']['phone'])?$checkout_data['address']['phone']:''!!}" >
                            <input type="hidden" class="form-control rd-only" name="address[postcode]" id="postcode"   value="{!!isset($checkout_data['address']['postcode'])?$checkout_data['address']['postcode']:''!!}">
                            <input type="hidden" class="form-control rd-only" name="address[korean_new_address]" id="korean_new_address"   value="{!!isset($checkout_data['address']['korean_new_address'])?$checkout_data['address']['korean_new_address']:''!!}">
                            <input type="hidden" class="form-control rd-only" name="address[korean_old_address]" id="korean_old_address" value="{!!isset($checkout_data['address']['korean_old_address'])?$checkout_data['address']['korean_old_address']:''!!}">
                            <input type="hidden" class="form-control rd-only" name="address[english_address_address]" id="english_address" value="{!!isset($checkout_data['address']['english_address_address'])?$checkout_data['address']['english_address_address']:''!!}">
                            <input type="hidden" class="form-control" name="address[details]" id="details" value="{!!isset($checkout_data['address']['details'])?$checkout_data['address']['details']:''!!}">
                        @else
                            <!-- 검색 기능을 표시할 <div>를 생성한다 -->
                            <i class="glyphicon glyphicon-question-sign qt-sgn"></i>
                            <span class="qn_text">도움말</span>
                            <div id="postcodify" style="margin:0"></div>
                            <div class="form-group my-input  hide">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="address[name]" id="name" placeholder="Name of Recipient" >
                            </div>
                            <div class="form-group my-input  hide">
                                <label for="name">Email</label>
                                <input type="email" class="form-control" name="address[email]" id="email" placeholder="Email of Recipient" >
                            </div>
                            <div class="form-group my-input  hide">
                                <label for="name">Phone Number</label>
                                <input type="text" class="form-control" name="address[phone]" id="phone" placeholder="Phone Number of Recipient" >
                            </div>
                            <div class="form-group my-input hide">
                                <label for="postcode">우편번호</label>
                                <input type="text" class="form-control rd-only" name="address[postcode]" id="postcode" placeholder="우편번호"  >
                            </div>
                            <div class="form-group my-input hide">
                                <label for="postcode">도로명주소</label>
                                <input type="text" class="form-control rd-only" name="address[korean_new_address]" id="korean_new_address" placeholder="도로명주소"  >
                            </div>
                            <div class="form-group my-input hide">
                                <label for="postcode">지번주소</label>
                                <input type="text" class="form-control rd-only" name="address[korean_old_address]" id="korean_old_address" placeholder="지번주소"  >
                            </div>
                            <div class="form-group my-input  hide">
                                <label for="postcode">영문주소</label>
                                <input type="text" class="form-control rd-only" name="address[english_address_address]" id="english_address" placeholder="영문주소" >
                            </div>
                            <div class="form-group my-input hide">
                                <label for="postcode">상세주소</label>
                                <input type="text" class="form-control" name="address[details]" id="details" placeholder="상세주소를 입력하시오 예)00동00호">
                            </div>
                        @endif
                </div>
                <div class="panel-footer clearfix" style="">
                  <button class="btn btn-primary pull-right" type="submit">Process to Payment</button>
                </div>
            </div>
        </div>
    </div>
</div>
    @if(Auth::check())
        @if(isset($user_id))
            <input type="hidden" name="user_id" value="{{$user_id}}">
        @endif
    @endif
{!! Form::close() !!}

<!-- Modal -->
<div class="modal fade" id="postcodify-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <img src="/assets/images/postcodify_help.PNG" alt="">
      </div>
    </div>
  </div>
</div>
@stop