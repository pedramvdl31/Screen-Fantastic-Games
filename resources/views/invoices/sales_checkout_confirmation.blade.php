@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/layouts/general.css') !!}
{!! Html::style('/assets/css/invoices/checkout.css') !!}
@stop
@section('scripts')
<script type="text/javascript" src="/packages/popupwindow/jquery.popupwindow.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.postcodify/3.3.0/search.min.js"></script>
<script type="text/javascript" src="/assets/js/invoices/sales_confirmation.js"></script>
@stop
@section('content')
{!! Form::open(array('action' => 'InvoicesController@postSalesAdd', 'id'=>'invoice_form', 'class'=>'','role'=>"form")) !!}
    <div class="container" style="color:black">


        <div class="panel panel-default">
          <div class="panel-body">

            <div id="print-area">
                <div class="row " style="margin-top:0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h2>Client Details :</h2>
                        <h4><strong>
                            @if(isset($checkout_data['address']['name']))
                                {{$checkout_data['address']['name']}}
                            @else
                                -
                            @endif
                        </strong></h4>
                        <h4>
                            @if(isset($checkout_data['address']['korean_new_address']))
                                {{$checkout_data['address']['korean_new_address']}}
                                @if(isset($checkout_data['address']['details']))
                                    {{$checkout_data['address']['details']}}
                                @endif
                            @else
                                -
                            @endif
                        </h4>
                        <h4>Korea - 
                            @if(isset($checkout_data['address']['postcode']))
                                {{$checkout_data['address']['postcode']}}
                            @endif
                        </h4>
                        <h4><strong>Email: </strong>
                            @if(isset($checkout_data['address']['email']))
                                {{$checkout_data['address']['email']}}
                            @else
                                -
                            @endif
                        </h4>
                        <h4><strong>Call: </strong>
                            @if(isset($checkout_data['address']['phone']))
                                {{$checkout_data['address']['phone']}}
                            @else
                                -
                            @endif
                        </h4>
                    </div>
                </div>
                <hr>
                <br>
                <div class="row"  style="margin-top:0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Particulars</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($checkout_data['items']))
                                        @foreach($checkout_data['items'] as $item)
                                            <tr>
                                                <td>{{$item['item_id']}}</td>
                                                <td>{{$item['item_title']}}</td>
                                                <td>{{$item['qty']}}</td>
                                                <td>{{$item['item_price']}}</td>
                                                <td>{{$item['item_total_price']}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row"  style="margin-top:0">
                    <div class="col-lg-9 col-md-9 col-sm-9" style="text-align: right; padding-right: 30px;">
                        Subtotal : 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                        <strong>{{$checkout_data['subtotal']}}</strong>
                    </div>
                    <br>
                    <div class="col-lg-9 col-md-9 col-sm-9" style="text-align: right; padding-right: 30px;">
                        Shipping Cost : 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                        <strong>{{$checkout_data['shipping_cost']}}</strong>
                    </div>
                    <hr>
                    <div class="col-lg-9 col-md-9 col-sm-9" style="text-align: right; padding-right: 30px;">
                        Total : 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                        <strong>{{$checkout_data['total']}}</strong>
                    </div>
                </div>
                <hr>
                <div class="row"  style="margin-top:0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <strong>IMPORTANT INSTRUCTIONS :
                        </strong>
                        <h5># This is an electronic receipt so doesn't require any signature.</h5>
                        <h5># All perticulars are listed with 10.50 % taxes , so if any issue please contact us immediately.</h5>
                        <h5># You can contact us between 10:am to 6:00 pm on all working days.</h5>
                    </div>
                </div>
            </div>

          </div>
          <div class="panel-footer clearfix">
              <a href="/admins/invoices/view-receipt" rel="window800" class="btn btn-primary pull-right popupwindow" id="view-receipt">View Receipt and Save</a>
              <button class="btn btn-primary pull-right" type="submit" id="submit-btn">Save</button>
          </div>
        </div>


    </div>
{!! Form::close() !!}
@stop