@extends($layout)
@section('stylesheets')

@stop
@section('scripts')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="/assets/js/articles/add.js"></script>
@stop

@section('content')
<div class="jumbotron">
  <h1>Articles Add</h1>
</div>
<div class="panel panel-default">

  <div class="panel-body">
  {!! Form::open(array('action' => 'ArticlesController@postAdd', 'class'=>'','role'=>"form")) !!}
    
    <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
      <label class="control-label" for="title">Title</label>
      {!! Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'Title')) !!}
        @foreach($errors->get('title') as $message)
            <span class='help-block'>{{ $message }}</span>
        @endforeach
    </div>

    <div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
      <label class="control-label" for="description">Description</label>
          {!! Form::textarea('content', null, ['class' => 'des field form-control','size' => '30x8', 'placeholder'=>'Description']) !!}
    </div>


  </div>
  <div class="panel-footer clearfix">
    <a href="{!! route('articles_index') !!} " class="btn btn-info">Back</a>
    <button class="btn btn-primary pull-right">Add</button>
  </div>
    {!! Form::close() !!}
</div>
@stop