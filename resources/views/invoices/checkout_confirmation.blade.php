@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/layouts/general.css') !!}
{!! Html::style('/assets/css/invoices/checkout.css') !!}
@stop
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.postcodify/3.3.0/search.min.js"></script>
@stop
@section('content')
    {!! Form::open(array('action' => 'InvoicesController@postCheckout', 'id'=>'fileupload', 'class'=>'','role'=>"form")) !!}
        <div class="container">
            <div class="panel panel-default">
              <div class="panel-body">

                <div id="print-area">
                    <div class="row ">
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
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>S. No.</th>
                                            <th>Particulars</th>
                                            <th>Quantity</th>
                                            <th>Item</th>
                                            <th>Option Extra Price</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($checkout_data['items']))
                                            @foreach($checkout_data['items']['cart'] as $carts)
                                                @foreach($carts as $items)
                                                    <tr>
                                                        <td>{{$items['option_id']}}</td>
                                                        <td>{{$items['title']}}</td>
                                                        <td>{{$items['qty']}}</td>
                                                        <td>{{number_format($checkout_data['items']['prices']['base_price'],0)}}원</td>
                                                        <td>{{number_format($items['option_price'],0)}}원</td>
                                                        <td>{{number_format($items['row_total'],0)}}원</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-9 col-md-9 col-sm-9" style="text-align: right; padding-right: 30px;">
                            Subtotal : 
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            <strong>{{number_format($checkout_data['items']['prices']['subtotal'],0)}}원</strong>
                        </div>
                        <br>
                        <div class="col-lg-9 col-md-9 col-sm-9" style="text-align: right; padding-right: 30px;">
                            Shipping Cost : 
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            <strong>0</strong>
                        </div>
                        <hr>
                        <div class="col-lg-9 col-md-9 col-sm-9" style="text-align: right; padding-right: 30px;">
                            Total : 
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right">
                            <strong>{{number_format($checkout_data['items']['prices']['subtotal'],0)}}원</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
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
                  <a class="btn btn-info" href="{{route('invoice_checkout')}}">Back</a>
                  <button class="btn btn-primary pull-right">Proceed To Payment</button>
              </div>
            </div>
        </div>
    {!! Form::close() !!}
@stop