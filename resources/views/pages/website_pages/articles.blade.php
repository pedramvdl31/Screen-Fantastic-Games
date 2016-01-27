@extends($layout)
@section('stylesheets')
  {!! Html::style('/assets/css/pages/website_pages/general.css') !!}
@stop
@section('scripts')

@stop

@section('content')

<div class="" style="margin-top:10px;margin-bottom:30px;">
  <div class="jumbotron my-jumbotron">
    <h1>Articles</h1>
  </div>

      @if(isset($articles))
        @foreach($articles as $single_item)
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading" style="">
                <h3 class="panel-title" >
                {!!$single_item['title']!!} &nbsp <small>{!!$single_item['created_at_html']!!}</small>
                </h3>
            </div>
            <div class="panel-body">

              {!!$single_item['description']!!}

            </div>

          </div>
        </div>
        @endforeach
      @endif



</div>




@stop