@extends($layout)
@section('stylesheets')
{!! Html::style('/assets/css/pages/add.css') !!}
@stop
@section('scripts')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="/assets/js/pages/add.js"></script>

@stop

@section('content')
<div class="jumbotron">
  <h1>Pages Add</h1>
</div>
<div class="panel panel-default">

  <div class="panel-body">
  {!! Form::open(array('action' => 'PagesController@postAdd', 'class'=>'','role'=>"form")) !!}
    <div class="section-wrapper">
    <h3 class="group-title">SEO</h3>
    <hr>
    <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
      <label class="control-label" for="title">Title</label>
      @if(isset($preview_session_data['page_title']))
        {!! Form::text('title', $preview_session_data['page_title'], array('class'=>'form-control', 'placeholder'=>'Title')) !!}
      @else
        {!! Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Title')) !!}
      @endif
        @foreach($errors->get('title') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

    <div class="third_section" id="keywordss">
      <div class="blackout wrapper">
        <label class="control-label" for="description">Keywords (Optional)</label>
        <i type="button" class="glyphicon glyphicon-info-sign" data-toggle="tooltip"
         data-placement="top" title="Keywords ..."></i>
        <div class="input-group">
          <span class="input-group-addon">Enter a keywords</span>
          <input type="text" class="form-control keyword-text">
          <span class="input-group-addon add-keyword">Add</span>
        </div>
        <div class="alert alert-danger hide" id="keyword-dup" role="alert">Duplicate data</div>
        <div class="panel panel-default">
          <div class="panel-body" id="keyword-group-wrapper">
            @if(isset($preview_session_data['page_keywords']))
              @foreach($preview_session_data['page_keywords'] as $keyskey => $keysval)
                  <span class="label label-success label-keyword new-zip {!! $keysval !!}"> 
                    <span class="this-keyword-t">{!! $keysval !!}</span> 
                    <i class="glyphicon glyphicon-trash delete-keyword"></i>
                  </span>
                  <input class="{!! $keysval !!}" type="hidden" name="keywords[{!! $keyskey !!}]" value="{!! $keysval !!}">
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
    </div>

  <!-- ##### -->
  <div class="section-wrapper">
    <h3 class="group-title">Contents</h3>
    <hr>


    {!! Form::textarea('content', null, ['class' => 'des field form-control','size' => '30x8', 'placeholder'=>'Description']) !!}




  </div>
  </div>
  <div class="panel-footer clearfix">
    <a href="{!! route('pages_index') !!} " class="btn btn-info">Back</a>
    <button class="btn btn-primary pull-right">Create Page</button>
  </div>
    {!! Form::close() !!}
</div>
@stop