@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/layouts/general.css') !!}
{!! Html::style('/assets/css/invoices/checkout.css') !!}
{!! Html::style('/assets/css/design_tools/postcodify.css') !!}
@stop
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.postcodify/3.3.0/search.min.js"></script>
<script src="/assets/js/design_tools/postcodify.js"></script>
<script src="/assets/js/admins/sales/checkout.js"></script>
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
    $(function() { 
        $("#postcodify_2").postcodify({
        insertPostcode5 : ".postcode",
        insertAddress : ".korean_new_address",
        insertJibeonAddress: ".korean_old_address",
        insertDetails : ".details",
        insertExtraInfo : ".extra_info",
        insertEnglishAddress: ".english_address",
        hideOldAddresses : false
    }); 
    });
</script>

<script src="/assets/js/invoices/checkout.js"></script>
@stop
@section('content')
{!! Form::open(array('action' => 'InvoicesController@postAdminCheckoutConfirmation', 'class'=>'my_form','role'=>"form")) !!}
    <div class="container">
        <div class="row" style="margin-top:0">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="text-center panel-title"><strong>Order summary</strong></h3>
                    </div>
                    <div class="panel-body" style="color:black">
                        {!! $checkout_html !!}
                    </div>
                
                </div>
            </div>
        </div>


        <div class="row" style="margin-top:0;color:black;padding-left: 20px;padding-right: 20px;margin-bottom:10px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-center panel-title"><strong>Address Book</strong></h3>
                </div>
                <div class="panel-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active tabs_title" this-title="by_user"><a href="#by_user" aria-controls="by_user" role="tab" data-toggle="tab">Find User</a></li>
                        <li role="presentation" class="tabs_title" this-title="by_search"><a href="#by_search" aria-controls="by_search" role="tab" data-toggle="tab">Find Address</a></li>
                        <li role="presentation" class="tabs_title" this-title="add_user"><a href="#add_user" aria-controls="add_user" role="tab" data-toggle="tab">Add New User</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="by_user">
                            <div class="container" style="padding:10px;border:1px solid #ddd;border-top:none">
                                <div class="form-group">
                                    <label class="control-label" for="id">Find By:</label>
                                    {!! Form::select('search',$search_by ,'phone', ['id'=>'searchBy','class'=>'form-control','status'=>false]) !!}
                                    @foreach($errors->get('id') as $message)
                                    <span class='help-block'>{!! $message !!}</span>
                                    @endforeach
                                </div>
                                <div id="searchBy-id" class="searchByFormGroup form-group {!! $errors->has('id') ? 'has-error' : false !!} well hide well-sm">
                                    <label class="control-label" for="id">User Id</label>
                                    <div class="input-group">
                                        {!! Form::text('id', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'user id','status'=>false)) !!}
                                        <a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
                                    </div>
                                    @foreach($errors->get('id') as $message)
                                    <span class='help-block'>{!! $message !!}</span>
                                    @endforeach


                                </div>  
                                <div id="searchBy-username" class="searchByFormGroup hide form-group {!! $errors->has('username') ? 'has-error' : false !!} well well-sm">
                                    <label class="control-label" for="username">Username</label>
                                    <div class="input-group">
                                        {!! Form::text('username', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'username','status'=>false)) !!}
                                        <a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
                                    </div>
                                    @foreach($errors->get('email') as $message)
                                    <span class='help-block'>{!! $message !!}</span>
                                    @endforeach
                                </div>  
                                <div id="searchBy-phone" class="searchByFormGroup form-group well well-sm">
                                    <label class="control-label" for="phone">Phone</label>
                                    <div class="input-group">
                                        {!! Form::text('phone', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'phone','status'=>false)) !!}
                                        <a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
                                    </div>
                                </div>  
                                <div id="searchBy-email" class="searchByFormGroup form-group {!! $errors->has('email') ? 'has-error' : false !!} well well-sm hide">
                                    <label class="control-label" for="email">Email</label>
                                    <div class="input-group">
                                        {!! Form::text('email', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'(ex: example@example.com)','status'=>false)) !!}
                                        <a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
                                    </div>
                                    @foreach($errors->get('email') as $message)
                                    <span class='help-block'>{!! $message !!}</span>
                                    @endforeach
                                </div>  
                                <div id="searchBy-name" class="searchByFormGroup well well-sm hide">
                                    <div class="form-group {!! $errors->has('firstname') ? 'has-error' : false !!}">
                                        <label class="control-label" for="firstname">First Name</label>
                                        {!! Form::text('first_name', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'First Name')) !!}
                                        @foreach($errors->get('firstname') as $message)
                                        <span class='help-block'>{!! $message !!}</span>
                                        @endforeach
                                    </div>  
                                    <div class="form-group {!! $errors->has('last_name') ? 'has-error' : false !!}">
                                        <label class="control-label" for="last_name">Last Name</label>
                                        {!! Form::text('last_name', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'Last Name')) !!}
                                        @foreach($errors->get('last_name') as $message)
                                        <span class='help-block'>{!! $message !!}</span>
                                        @endforeach
                                    </div>  
                                    <div class="form-group">
                                        <button type="button" class="searchByButton btn btn-info"><i class="glyphicon glyphicon-search"></i> Search</button>
                                    </div>          
                                </div>
                                <table id="userSearchTable" class="table table-hover hide" style="margin-bottom:20px;">
                                <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Username</th>
                                            <th>First</th>
                                            <th>Last</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div id="addresses_input" class="hide">
                                    <input type="hidden" name="user_id" id="user_id" value="">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control user_name" name="address_by_user[name]" id="name_user_search" placeholder="Name of Recipient" >
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Email</label>
                                        <input type="email" class="form-control user_email" name="address_by_user[email]" id="email_user_search" placeholder="Email of Recipient" >
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Phone Number</label>
                                        <input type="text" class="form-control user_phone" name="address_by_user[phone]" id="phone_user_search" placeholder="Phone Number of Recipient" >
                                    </div>
                                    <div class="form-group">
                                        <label for="postcode">우편번호</label>
                                        <input type="text" class="form-control rd-only user_postcode" name="address_by_user[postcode]" id="postcode_user_search" placeholder="우편번호"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="postcode">도로명주소</label>
                                        <input type="text" class="form-control rd-only user_korean_new_address" name="address_by_user[korean_new_address]" id="korean_new_address_user_search" placeholder="도로명주소"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="postcode">지번주소</label>
                                        <input type="text" class="form-control rd-only user_korean_old_address" name="address_by_user[korean_old_address]" id="korean_old_address_user_search" placeholder="지번주소"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="postcode">영문주소</label>
                                        <input type="text" class="form-control rd-only user_english_address_address" name="address_by_user[english_address_address]" id="english_address_user_search" placeholder="영문주소" >
                                    </div>
                                    <div class="form-group">
                                        <label for="postcode">상세주소</label>
                                        <input type="text" class="form-control user_details" name="address_by_user[details]" id="details_user_search" placeholder="상세주소를 입력하시오 예)00동00호">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="by_search">
                            <div class="container" style="padding:10px;border:1px solid #ddd;border-top:none">
                                @if(false)
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
                                @else
                                    <!-- 검색 기능을 표시할 <div>를 생성한다 -->
                                    <i class="glyphicon glyphicon-question-sign qt-sgn"></i>
                                    <span class="qn_text">도움말</span>
                                    <div id="postcodify" style="margin:0"></div>
                                    <div class="form-group my-input  hide">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="address_by_search[name]" id="name" placeholder="Name of Recipient" >
                                    </div>
                                    <div class="form-group my-input  hide">
                                        <label for="name">Email</label>
                                        <input type="email" class="form-control" name="address_by_search[email]" id="email" placeholder="Email of Recipient" >
                                    </div>
                                    <div class="form-group my-input  hide">
                                        <label for="name">Phone Number</label>
                                        <input type="text" class="form-control" name="address_by_search[phone]" id="phone" placeholder="Phone Number of Recipient" >
                                    </div>
                                    <div class="form-group my-input hide">
                                        <label for="postcode">우편번호</label>
                                        <input type="text" class="form-control rd-only" name="address_by_search[postcode]" id="postcode" placeholder="우편번호"  >
                                    </div>
                                    <div class="form-group my-input hide">
                                        <label for="postcode">도로명주소</label>
                                        <input type="text" class="form-control rd-only" name="address_by_search[korean_new_address]" id="korean_new_address" placeholder="도로명주소"  >
                                    </div>
                                    <div class="form-group my-input hide">
                                        <label for="postcode">지번주소</label>
                                        <input type="text" class="form-control rd-only" name="address_by_search[korean_old_address]" id="korean_old_address" placeholder="지번주소"  >
                                    </div>
                                    <div class="form-group my-input  hide">
                                        <label for="postcode">영문주소</label>
                                        <input type="text" class="form-control rd-only" name="address_by_search[english_address_address]" id="english_address" placeholder="영문주소" >
                                    </div>
                                    <div class="form-group my-input hide">
                                        <label for="postcode">상세주소</label>
                                        <input type="text" class="form-control" name="address_by_search[details]" id="details" placeholder="상세주소를 입력하시오 예)00동00호">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="add_user">
                            <div class="container" id="reg-form" style="padding:10px;border:1px solid #ddd;border-top:none">
                                <div class="form-group">
                                    <label for="name">First Name</label>
                                    <input type="text" class="form-control" name="address_add_user[first_name]" placeholder="First name *" id="first_name" aria-describedby="sizing-addon2" >
                                    <div class="error-wrapper-fname">
                                        <div class="error-first_name hide error" style="color: #d44950;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Last Name</label>
                                    <input type="text" class="form-control" name="address_add_user[last_name]" id="last_name" placeholder="Last name *" aria-describedby="sizing-addon2">
                                    <div class="error-wrapper-lname">
                                        <div class="error-last_name hide error" style="color: #d44950;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Age</label>
                                    <select class="form-control" name="address_add_user[age]" id="age">
                                        <option >Age</option>
                                        <option value="1">Below 18</option>
                                        <option value="2">18 or older</option>
                                    </select>
                                    <div class="error-wrapper-age">
                                        <div class="error-age hide error " style="color: #d44950;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="text" class="form-control" name="address_add_user[email]" id="email" name="email" placeholder="Email *">
                                    <div class="error-wrapper">
                                        <div class="error-email hide error" style="color: #d44950;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="address_add_user[phone]" placeholder="Phone Number * (000-0000-0000)" aria-describedby="sizing-addon2">
                                    <div class="error-wrapper">
                                        <div class="error-phone hide error" style="color: #d44950;"></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input type="text" class="form-control" name="address_add_user[username]" id="username" placeholder="Username *" aria-describedby="sizing-addon2">
                                    <div class="error-wrapper">
                                        <div class="error-username hide error" style="color: #d44950;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Password</label>
                                    <input type="password" class="form-control" name="address_add_user[password]" id="password" placeholder="Password" aria-describedby="sizing-addon2">
                                    <div class="error-wrapper">
                                        <div class="error-username hide error" style="color: #d44950;"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Re-Enter Password</label>
                                    <input type="password" class="form-control" name="address_add_user[password_again]" id="password_again" placeholder="Re-Enter Password" aria-describedby="sizing-addon2">
                                    <div class="error-wrapper">
                                        <div class="error-username hide error" style="color: #d44950;"></div>
                                    </div>
                                </div>
                                <hr>
                                <!-- 검색 기능을 표시할 <div>를 생성한다 -->
                                <i class="glyphicon glyphicon-question-sign qt-sgn"></i>
                                <span class="qn_text">도움말</span>
                                <div id="postcodify_2" style="margin:0"></div>
                                <div class="form-group my-input hide">
                                    <label for="postcode">우편번호</label>
                                    <input type="text" class="form-control rd-only postcode" name="address_add_user[arr][postcode]" id="postcode_add_user" placeholder="우편번호"  >
                                </div>
                                <div class="form-group my-input hide">
                                    <label for="postcode">도로명주소</label>
                                    <input type="text" class="form-control rd-only korean_new_address" name="address_add_user[arr][korean_new_address]" id="korean_new_address_add_user" placeholder="도로명주소"  >
                                </div>
                                <div class="form-group my-input hide">
                                    <label for="postcode">지번주소</label>
                                    <input type="text" class="form-control rd-only korean_old_address" name="address_add_user[arr][korean_old_address]" id="korean_old_address_add_user" placeholder="지번주소"  >
                                </div>
                                <div class="form-group my-input  hide">
                                    <label for="postcode">영문주소</label>
                                    <input type="text" class="form-control rd-only english_address" name="address_add_user[arr][english_address_address]" id="english_address_add_user" placeholder="영문주소" >
                                </div>
                                <div class="form-group my-input hide">
                                    <label for="postcode">상세주소</label>
                                    <input type="text" class="form-control details" name="address_add_user[arr][details]" id="details_add_user" placeholder="상세주소를 입력하시오 예)00동00호">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer clearfix">
                    <a class="btn btn-primary pull-right" id="submit-btn">Process to Confirmation</a>
                </div>
            </div>


        </div>
    </div>
    <input type="hidden" name="address_type" id="address_type" value="by_user">
{!! Form::close() !!}
@stop