@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
	<h1>Sliders Index</h1>
</div>

@foreach($all_sliders as $slider => $slide)

<div class="panel panel-default">
  <div class="panel-heading"><h3>{{$slider}}</h3></div>
  <div class="panel-body">
    @if(isset($slide['images']))
      @foreach($slide['images'] as $sl)
          <div class="col-xs-6 col-md-3">
            <a href="#" class="thumbnail">
              <img src="/assets/images/sliders/{{$slider}}/{!! $sl !!}" alt="...">
            </a>
          </div>
      @endforeach
    @endif
  </div>

  <div class="panel-footer clearfix">
    <a href="{!! route('sliders_edit',$slide['id']) !!}" class="btn btn-primary pull-right">Edit</a>
  </div>
  
</div>

@endforeach

@stop