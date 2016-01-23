@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/inventories/view-items.css') !!}
{!! Html::style('/assets/css/layouts/general.css') !!}
{!! Html::style('/assets/css/design_tools/my_spinner.css') !!}
{!! Html::style('/packages/bootstrap-touchspin-master/src/jquery.bootstrap-touchspin.css') !!}
@stop
@section('scripts')
<script src="/packages/bootstrap-touchspin-master/src/jquery.bootstrap-touchspin.js"></script>
<script src="/packages/jquery_lazyload/jquery.lazyload.min.js"></script>
<script src="/assets/js/inventories/item-view.js"></script>
@stop

@section('content')
<div class="container ">
  <div class="col-md-12">
    <div class="panel panel-default" style="">
      <div class="panel-body padding-none">

        <div class="col-md-6">
          <div class="panel panel-default image-panel" style="box-shadow: none;">
            <div class="panel-body" >
              @if(isset($item))
              <div class="col-xs-12 col-md-12">
                <div  class="thumbnail banner-item thumbnail-borderless">
                  @if(isset($item['primary_image']))
                  <img src="{{$item['primary_image']}}" alt="..." class="big-image">
                  @endif
                </div>
              </div>
              @if(isset($item['primary_image']))
              <div class="col-xs-5 col-sm-3 col-md-3">
                  <div class="thumbnail active-item child-item ">
                      <img src="{{$item['primary_image']}}" alt="..." style="height: 90px; width: 100%; display: block;">
                  </div>
              </div>
              @endif
              @if(isset($item['image_srcs']))
                @foreach($item['image_srcs'] as $srcs => $vals)
                <div class="col-xs-6 col-sm-3 col-md-3">
                  <div class="thumbnail child-item ">
                    <img src="{{$vals}}" alt="..." style="height: 90px; width: 100%; display: block;">
                  </div>
                </div>
                  @endforeach    
                @endif 
              </div>         
              @endif
            </div>

          </div>

          <div class="col-md-6 padding-right-none padding-left-none" id="right-data-col" style="">
            {!! Form::open(array('action' => 'InvoicesController@postAddAndProceed', 'id'=>'proceed-form', 'class'=>'','role'=>"form")) !!}
              <div class="panel panel-default margin-bottom-none" style="border:0;box-shadow:none;">
                <div class="panel-body" style="">
                  <div class="well clearfix">
                    <span id="well-title-t" class="">Price:</span>
                    <span id="well-price-t" class="pull-right">{{ $item->formated_unit_price }}<small>원</small></span>
                    <input type="hidden" id="base_price" value="{{ $item->formated_unit_price }}">
                  </div>
                  <dl class="dl-horizontal in-line item-info">
                  <dt class="font-oswald">Item Title:
                  </dt>
                  <dd>
                  <small>{{ $item->title }}</small>
                  </dd>
                  </br>
                  <dt class="font-oswald">
                  Item Description:
                  </dt>
                  <dd>
                  <small>{{ $item->description }}</small>
                  </dd>
                  </br>
                  <dt class="font-oswald">
                  Item Status:
                  </dt>
                  <dd>
                  <small>{!! $item->status_message !!}</small>
                  </dd>
                  </br>
                  <dt class="font-oswald">
                  Item Added On:
                  </dt>
                  <dd>
                  <small> {!! $item->human_time !!} ({!! $item->created_at_html !!})</small>
                  </dd>
                  </br>
                    <dt class="font-oswald">
                    Select Item:
                    </dt>
                    <dd>
                      <div class="form-group {{ $errors->has('status') ? 'has-error' : false }} " id="all_options_form">
                        <select class="form-control" id="all_options">
                          <option >Select Item</option>
                          @foreach($options as $optionskey => $op)
                            <option value="{{$op['price']}}" option-id="{{$optionskey}}">{{$op['text']}}
                              @if($op['price']>0)
                                &nbsp(+₩{{$op['price']}})
                              @endif
                            </option>
                          @endforeach
                        </select>
                        <span class='help-block hide' id="options-help">You must select an Item *</span>
                      </div>
                    </dd>
                  </dl>



                  <div class="well well-sm clearfix" id="options-container">
                    <p>Selected list:</p>
                    <div id="">
                      <hr>
                      <div id="selected_items_container" class="row " style="margin:0"> 
                        <p id="non-selected">-</p>
                      </div>
                      <hr>
                      <h3  class="pull-right">Total Amount: ₩<span id="total_price">0</span></h3>
                    </div>
                  </div>



                </div>
                <div class="panel-footer clearfix" >
                  <div class="btn-group btn-block" role="group" aria-label="...">
                  <button type="button" id="add-to-cart-onpage" class="btn btn-default btn-primary col-lg-4 col-md-4 col-xs-12 btn-group-1" this-item="{{ $item->id }}">Add To Cart&nbsp&nbsp<i class="glyphicon glyphicon-shopping-cart"></i></button>
                  <button   type="button" id="proceed-to-payment" class="btn btn-default btn-success col-lg-4 col-md-4 col-xs-12 btn-group-1">Proceed To Payment&nbsp&nbsp<i class="glyphicon glyphicon-credit-card"></i></a>
                  <button type="button" id="add-to-wishlist" item-id="{{$item->id}}" class="btn btn-default btn-info col-lg-4 col-md-4 col-xs-12 btn-group-1">Add To Interest List&nbsp&nbsp<i class="glyphicon glyphicon-heart-empty"></i></button>
                  </div>
                </div>
              </div>
              <input type="hidden" id="this_item_id" name="item_id" value="{{ $item->id }}">
              {!! Form::close() !!}
</div>
</div>
</div>


</div>
<!-- END OF PANEL -->
</div>

<hr class="description-hr">
<div class="panel panel-default panel-primary" style="border-radius:0;border-right:none;border-left:none;border-bottom:1px solid #ddd;">
  <div class="panel-heading" style="border-radius:0">
    <h3 class="panel-title" style="padding:10px">Item Detailes</h3>
  </div>
  <div class="panel-body text-center ">
    @if(isset($item['description_image']))
      @foreach($item['description_image'] as $dsrcs => $dvals)
        <img class="lazy" data-original="{!! $dvals !!}">
      @endforeach    
    @endif 
  </div>
  <div class="panel-footer">
    <div class="tab-container">

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#comment" aria-controls="comment" role="tab" data-toggle="tab">Reviews</a></li>
        <li role="presentation"><a href="#q_n_a" aria-controls="q_n_a" role="tab" data-toggle="tab">Q & A</a></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content" style="background-color: white;">
        <div role="tabpanel" class="tab-pane active review-container" id="comment" style="max-height: 500px;overflow-y: auto;">
          <a id="review-btn" class="" inventory-id="{!!$item->id!!}">Add your Review <i class="glyphicon glyphicon-plus"></i></a>
          @if(isset($review_html))
            {!!$review_html!!}
          @endif
        </div>
        <div role="tabpanel" class="tab-pane clearfix qna-container" id="q_n_a" style="max-height: 500px;overflow-y: auto;">
          <a id="qna-btn" class="" inventory-id="{!!$item->id!!}">Ask a Question <i class="glyphicon glyphicon-plus"></i></a>
          @if(isset($qna_html))
            {!!$qna_html!!}
          @endif
        </div>
      </div>

    </div>
  </div>
</div>
@if(Auth::check())
  {!! View::make('partials.qna_modal') !!}
  {!! View::make('partials.review_modal') !!}
  {!! View::make('partials.review_edit_modal') !!}
  <input type="hidden" id="this_username" value="{!!Auth::user()->username!!}">
@endif
{!! View::make('partials.has_reviewed_modal') !!}
<input type="hidden" id="this-inventory" value="{!!$item->id!!}">
@stop