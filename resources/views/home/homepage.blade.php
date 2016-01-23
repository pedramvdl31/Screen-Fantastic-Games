@extends($layout)
@section('stylesheets')
      {!! Html::style('/assets/css/home/homepage.css') !!}
@stop
@section('scripts')
      <script src="/assets/js/homepage.js"></script>
@stop

@section('content')


 <div class="slider-wrapper">
      @if($slider_option == true)
             {!! View::make('partials.homepage.slider')
                  ->with('slider_images',$slider_images)
                  ->with('param1_lowered',$param1_lowered)
                  ->__toString()
             !!}
      @endif
 </div>


@stop