@extends($layout)
@section('stylesheets')
  {!! Html::style('/assets/css/layouts/general.css') !!}
  {!! Html::style('/assets/css/home/main.css') !!}
  {!! Html::style('/assets/css/pages/preview.css') !!}
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
@stop
@section('scripts')
  <script src="/assets/js/layouts/general.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="/assets/js/pages/preview_edit.js"></script>
@stop

@section('content')

{!! Form::open(array('action' => 'PagesController@postEdit', 'class'=>'','role'=>"form")) !!}
<input type="hidden" name="page_id" value="{!!$page_id!!}">
@if($issorted == true)
  <div class="sorted-inputs">
      @foreach($sorted_data as $sdkey => $sorted_data_value)
        <input type="hidden" name="sorted[{{$sdkey}}][title]" value="{{$sorted_data_value['title']}}">
      @endforeach
  </div>
<!-- %%%%%%%%%%%%%%%%%%$$$$$$$$$#################!!!!!!!!!! -->
 <div class="panel panel-default grid2" style="border: none;">

    @foreach($sorted_data as $sdkey => $s_d)
      
      @if($s_d['title'] == 'header')
        @if($data['page_header_option'] == 1)
          <div class="header-wrapper text-center margin-bottom-20 span2 parent-div" id="header">
            <div class="drag-icon" ></div>
            <img src="" class="drag-icon">
            @if(isset($data_array['header_text']))
              <h2>{{$data_array['header_text']}}</h2>
            @else
              <h2>Page Header</h2>
            @endif
            
          </div>
        @endif
      @elseif($s_d['title'] == 'slider')
        <!-- ########### -->
        @if($data['page_slider_option'] == 1)
        <div class="panel-bodyX "  style="padding:0" id="slider">
          <div class="slider-wrapper parent-div" style="margin:0;" >
            <img src="" class="drag-icon">

              @if(isset($data_array['files']))
                 {!! View::make('partials.pages.slider')
                      ->with('files',$data_array['files'])
                      ->__toString()
                 !!}
              @else
                 {!! View::make('partials.pages.slider')
                      ->__toString()
                 !!}
              @endif

          </div>
        @endif
        <!-- ########### -->
      @elseif($s_d['title'] == 'section')
        <!-- ########### -->
        @if($data['page_section_number'] > 0)
          <div class="container parent-div" id="section">
            <img src="" class="drag-icon">
             @for ($i = 0; $i < $data['page_section_number']; $i++)
              <section>
                @if(isset($data_array['section'][$i]))
                  <h3>{!!$data_array['section'][$i]['title']!!}</h3>
                  <p>{!!$data_array['section'][$i]['description']!!}</p>
                @else
                  <h3>Section Title</h3>
                  <p>Sed posuere consectetur est at lobortis. Aenean eu leo quam. 
                    Pellentesque ornare sem lacinia quam venenatis vestibulum.Sed posuere consectetur est at lobortis.
                   Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.
                 </p>
                @endif

              </section>
            @endfor 
          </div>
        @endif
        <!-- ########### -->
      @elseif($s_d['title'] == 'image')
      <!-- ########### -->
        @if($data['page_image_option'] == 1)
          <div class="container margin-top-20 parent-div" id="image">
            <img src="" class="drag-icon">
            <div class="row text-center">
              <div class="col-sm-12 col-md-12">
                @if(isset($data_array['file-single'][0]['path']))
                  <img src="{!!$data_array['file-single'][0]['path']!!}"
                    style="margin: 0 auto 0 auto;" class="img-responsive" alt="Responsive image">
                @else
                  <img src="/assets/images/image_placeholder_1uHSH093k.jpg"
                     class="img-responsive" alt="Responsive image">
                @endif
              </div>
            </div>
          </div>
        @endif
      <!-- ########### -->
      @endif

    @endforeach

    </div>
    <div class="panel-footer clearfix">
      {!! Form::close() !!}
        {!! Form::open(array('action' => 'PagesController@postEditDataStep', 'class'=>'','role'=>"form")) !!}
        <input type="hidden" name="page_id" value="{!!$page_id!!}">
          <div class="sorted-inputs">
              @foreach($sorted_data as $sdkey => $sorted_data_value)
                <input type="hidden" name="sorted[{{$sdkey}}][title]" value="{{$sorted_data_value['title']}}">
              @endforeach
          </div>
              <input type="hidden" name="back-btn" value="true">
              <button class="btn btn-primary pull-left" type="submit">Back</button>
        {!! Form::close() !!}

      <button class="btn btn-success pull-right"> Continue </button>
       
    </div>
  </div>

<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
<!-- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%% -->
@elseif($issorted == false)
{!! Form::open(array('action' => 'PagesController@postEdit', 'class'=>'','role'=>"form")) !!}
  <div class="sorted-inputs">
    @if($data['page_header_option'] == 1)
    <input type="hidden" name="sorted[0][title]" value="header">
    @endif
    @if($data['page_slider_option'] == 1) 
    <input type="hidden" name="sorted[1][title]" value="slider">
    @endif
    @if($data['page_section_number'] > 0)
    <input type="hidden" name="sorted[2][title]" value="section">
    @endif
    @if($data['page_image_option'] == 1)
    <input type="hidden" name="sorted[3][title]" value="image">
    @endif
  </div>
  <input type="hidden" name="page_id" value="{!!$page_id!!}">


   <div class="panel panel-default grid2" style="border: none;">

    @foreach($sorting_order as $sdkey => $s_d)
      
      @if($s_d['title'] == 'header')
        @if($data['page_header_option'] == 1)
          <div class="header-wrapper text-center margin-bottom-20 span2 parent-div" id="header">
            <div class="drag-icon" ></div>
            <img src="" class="drag-icon">
            @if(isset($data_array['header_text']))
              <h2>{{$data_array['header_text']}}</h2>
            @else
              <h2>Page Header</h2>
            @endif
            
          </div>
        @endif
      @elseif($s_d['title'] == 'slider')
        <!-- ########### -->
      @if($data['page_slider_option'] == 1)
        <div class="panel-bodyX "  style="padding:0" id="slider">
        <div class="slider-wrapper parent-div" style="margin:0;" >
          <img src="" class="drag-icon">

            @if(isset($data_array['files']))
               {!! View::make('partials.pages.slider')
                    ->with('files',$data_array['files'])
                    ->__toString()
               !!}
            @else
               {!! View::make('partials.pages.slider')
                    ->__toString()
               !!}
            @endif

        </div>
        @endif
        <!-- ########### -->
      @elseif($s_d['title'] == 'section')
        <!-- ########### -->
        @if($data['page_section_number'] > 0)
          <div class="container parent-div" id="section">
            <img src="" class="drag-icon">
             @for ($i = 0; $i < $data['page_section_number']; $i++)
              <section>
                @if(isset($data_array['section'][$i]))
                  <h3>{!!$data_array['section'][$i]['title']!!}</h3>
                  <p>{!!$data_array['section'][$i]['description']!!}</p>
                @else
                  <h3>Section Title</h3>
                  <p>Sed posuere consectetur est at lobortis. Aenean eu leo quam. 
                    Pellentesque ornare sem lacinia quam venenatis vestibulum.Sed posuere consectetur est at lobortis.
                   Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.
                 </p>
                @endif

              </section>
            @endfor 
          </div>
        @endif
        <!-- ########### -->
      @elseif($s_d['title'] == 'image')
      <!-- ########### -->
        @if($data['page_image_option'] == 1)
          <div class="container margin-top-20 parent-div" id="image">
            <img src="" class="drag-icon">
            <div class="row text-center">
              <div class="col-sm-12 col-md-12">
                @if(isset($data_array['file-single'][0]['path']))
                  <img src="{!!$data_array['file-single'][0]['path']!!}"
                    style="margin: 0 auto 0 auto;" class="img-responsive" alt="Responsive image">
                @else
                  <img src="/assets/images/image_placeholder_1uHSH093k.jpg"
                     class="img-responsive" alt="Responsive image">
                @endif
              </div>
            </div>
          </div>
        @endif
      <!-- ########### -->
      @endif

    @endforeach

    </div>
    <div class="panel-footer clearfix">
      {!! Form::close() !!}
        {!! Form::open(array('action' => 'PagesController@postEditDataStep', 'class'=>'','role'=>"form")) !!}
        <input type="hidden" name="page_id" value="{!!$page_id!!}">
          <div class="sorted-inputs">
              @foreach($sorting_order as $sdkey => $sorted_data_value)
                <input type="hidden" name="sorted[{{$sdkey}}][title]" value="{{$sorted_data_value['title']}}">
              @endforeach
          </div>
              <input type="hidden" name="back-btn" value="true">
              <button class="btn btn-primary pull-left" type="submit">Back</button>
        {!! Form::close() !!}

      <button class="btn btn-success pull-right"> Continue </button>
       
    </div>
  </div>

@endif
@stop