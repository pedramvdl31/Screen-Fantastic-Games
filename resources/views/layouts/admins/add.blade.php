@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Layouts Add</h1>
</div>
<div class="panel panel-default">

  <div class="panel-body">
  {!! Form::open(array('action' => 'LayoutsController@postAdd', 'class'=>'','role'=>"form")) !!}
    
    <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
      <label class="control-label" for="title">Title</label>
      {!! Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Title')) !!}
        @foreach($errors->get('title') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

    <div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
      <label class="control-label" for="description">Description</label>
      {!! Form::text('description', null, array('class'=>'form-control', 'placeholder'=>'Description')) !!}
        @foreach($errors->get('description') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

  </div>
  <div class="panel-footer clearfix">
    <a href="{!! route('layouts_index') !!} " class="btn btn-info">Back</a>
    <button class="btn btn-primary pull-right">Add</button>
  </div>
    {!! Form::close() !!}
</div>
@stop