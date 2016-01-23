@extends($layout)
@section('stylesheets')
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="/assets/css/inventories/add.css">
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
{!! Html::style('packages/jQuery-File-Upload-9.11.2/css/jquery.fileupload.css') !!}
{!! Html::style('packages/jQuery-File-Upload-9.11.2/css/jquery.fileupload-ui.css') !!}
<noscript>{!! Html::style('packages/jQuery-File-Upload-9.11.2/css/jquery.fileupload-noscript.css') !!}</noscript>
<noscript>{!! Html::style('packages/jQuery-File-Upload-9.11.2/css/jquery.fileupload-ui-noscript.css') !!}</noscript>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


@stop
@section('scripts')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- The main application script -->
<script type="text/javascript" src="/packages/priceformat/priceformat.min.js"></script>
<script type="text/javascript" src="/assets/js/events/add.js"></script>

@stop

@section('content')
<div class="jumbotron">
  <h1>Events Add</h1>
</div>
<div class="panel panel-default">

  <div class="panel-body">
  {!! Form::open(array('action' => 'EventsController@postAdd', 'class'=>'','role'=>"form")) !!}
    <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
      <label class="control-label" for="title">Title</label>
      {!! Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Title')) !!}
        @foreach($errors->get('title') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

    <div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
      <label class="control-label" for="description">Description</label>
      {!! Form::textarea('description', null, array('class'=>'form-control des', 'placeholder'=>'Description')) !!}
        @foreach($errors->get('description') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>


    <div class="form-group {{ $errors->has('date') ? 'has-error' : false }}">
      <label class="control-label" for="date">Event Date</label>
      {!! Form::text('date', null, array('class'=>'form-control','id'=>'datepicker', 'placeholder'=>'Click Here to Select the Date')) !!}
        @foreach($errors->get('title') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>


  </div>
  <div class="panel-footer clearfix">
    <a href="{!! route('events_index') !!} " class="btn btn-info">Back</a>
    <button class="btn btn-primary pull-right">Add</button>
  </div>
    {!! Form::close() !!}
</div>
@stop