@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/admins/sales/add.css') !!}
@stop
@section('scripts')
<script src="/assets/js/admins/sales/add.js"></script>

@stop

@section('content')

<div class="jumbotron">
    <h1>Sales</h1>
    <ol class="breadcrumb">
        <li><a href="{!!route('sales_index')!!}">Sales Overview</a></li>
        <li class="active">Sales Add</li>
    </ol>
</div>


{!! Form::open(array('action' => 'InvoicesController@postAdminCheckout', 'id'=>'fileupload', 'class'=>'','role'=>"form")) !!}
<div class="container-fluid  col-md-8 col-sm-8 col-xs-8">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">SEARCH AND SELECT ( <a id="view_all_inv" style="color:#337ab7;cursor: pointer;">View All</a> )</h3>
        </div>
        <div class="panel-body">
            <div id="customerMembers" class="customerListDiv">
                <div class="form-group">
                    <label class="control-label" for="id">Find By:</label>
                    {!! Form::select('search',$search_by ,'title', ['id'=>'searchBy','class'=>'form-control','status'=>false]) !!}
                    @foreach($errors->get('id') as $message)
                    <span class='help-block'>{!! $message !!}</span>
                    @endforeach
                </div>
                <div id="searchBy-id" class="searchByFormGroup form-group {!! $errors->has('id') ? 'has-error' : false !!} well hide well-sm">
                    <label class="control-label" for="id">Item Id</label>
                    <div class="input-group">
                        {!! Form::text('id', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'item id','status'=>false)) !!}
                        <a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
                    </div>
                    @foreach($errors->get('id') as $message)
                    <span class='help-block'>{!! $message !!}</span>
                    @endforeach
                </div>  

                <div id="searchBy-title" class="searchByFormGroup  form-group {!! $errors->has('title') ? 'has-error' : false !!} well well-sm">
                    <label class="control-label" for="title">Title</label>
                    <div class="input-group">
                        {!! Form::text('title', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'title','status'=>false)) !!}
                        <a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
                    </div>
                    @foreach($errors->get('email') as $message)
                    <span class='help-block'>{!! $message !!}</span>
                    @endforeach
                </div>  
                <div id="searchBy-price_range" class="searchByFormGroup hide form-group {!! $errors->has('price_range') ? 'has-error' : false !!} well well-sm">
                    <label class="control-label" for="price_range">Price_range</label>
                    <div class="row " style="margin-top:0">
                        
                    <div class="col-md-5 col-sm-5 col-xs-5" style="padding-right:0">
                        {!! Form::text('price_range', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'Min Price','status'=>false,'id'=>'min-price')) !!}
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2 text-center">
                        <span style="font-size:25px">~</span>
                    </div>
                    <div class="input-group col-md-5 col-sm-5 col-xs-5">
                        {!! Form::text('price_range', null, array('class'=>'form-control searchInputItem', 'placeholder'=>'Max Price','status'=>false,'id'=>'max-price')) !!}
                        <a class="searchByButton input-group-addon" style="cursor:pointer"><i class="glyphicon glyphicon-search"></i></a>
                    </div>

                    </div>

                    @foreach($errors->get('email') as $message)
                    <span class='help-block'>{!! $message !!}</span>
                    @endforeach
                </div>  
            </div>


            <hr>
            <div id="item-html">
                
            </div>



        </div>
    </div>
</div>
<!-- ******************************* -->
<!-- ******************************* -->
<!-- ******************************* -->
<!-- **********NEXT DIV************* -->
<!-- ******************************* -->
<!-- ******************************* -->
<!-- ******************************* -->


<div class="container-fluid  col-md-4 col-sm-4 col-xs-4">
    <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title">CHECKOUT TABLE</h3>
          </div>
        <div class="panel-body" id="checkout_table_html">   
            {!!$ch_html!!}
            
        </div>
        <div class="panel-footer clearfix">
            <button class="btn btn-success pull-right">CHECKOUT</button> 
        </div>
    </div>  
</div>
{!! Form::close() !!}
@stop