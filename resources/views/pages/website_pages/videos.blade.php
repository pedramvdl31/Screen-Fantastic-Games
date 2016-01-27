@extends($layout)
@section('stylesheets')
  {!! Html::style('/assets/css/pages/website_pages/general.css') !!}
@stop
@section('scripts')

@stop

@section('content')

<div class="" style="margin-top:10px;margin-bottom:30px;">
  <div class="jumbotron my-jumbotron">
    <h1>Videos</h1>
  </div>

      @if(isset($videos))
        @foreach($videos as $single_item)
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="panel panel-default">
            <div class="panel-heading" style="height:50px;overflow:auto">
                <h3 class="panel-title" >
                {!!$single_item['title']!!}
                </h3>
            </div>
            <div class="panel-body">
                <div class="embed-responsive embed-responsive-4by3">
                  <iframe class="embed-responsive-item" src="{!!$single_item['url']!!}"></iframe>
                </div>
            </div>
            <div class="panel-footer" style="height:100px;overflow:auto">
            {!!$single_item['description']!!}
            </div>
          </div>
        </div>
        @endforeach
      @endif



</div>




@stop