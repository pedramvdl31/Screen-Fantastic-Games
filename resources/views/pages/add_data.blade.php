@extends($layout)
@section('stylesheets')
{!! Html::style('assets/css/users/registration.css') !!}
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
{!! Html::style('packages/jQuery-File-Upload-9.11.2/css/jquery.fileupload.css') !!}
{!! Html::style('packages/jQuery-File-Upload-9.11.2/css/jquery.fileupload-ui.css') !!}
<noscript>{!! Html::style('packages/jQuery-File-Upload-9.11.2/css/jquery.fileupload-noscript.css') !!}</noscript>
<noscript>{!! Html::style('packages/jQuery-File-Upload-9.11.2/css/jquery.fileupload-ui-noscript.css') !!}</noscript>
{!! Html::style('/assets/css/pages/add_data.css') !!}
{!! Html::style('/assets/css/design_tools/stepy.css') !!}
@stop
@section('scripts')
{!! Html::script('/packages/tinymce2/js/tinymce/tinymce.min.js') !!}
<script src="/assets/js/pages/add_data.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/vendor/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.fileupload-process.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.fileupload-image.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.fileupload-audio.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.fileupload-video.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.fileupload-validate.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.fileupload-jquery-ui.js"></script>
<script type="text/javascript" src="/packages/jQuery-File-Upload-9.11.2/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-upload fade">
<td>
<span class="preview"></span>
</td>
<td>
<p class="name">{%=file.name%}</p>
<strong class="error text-danger"></strong>
</td>
<td>
<p class="size">Processing...</p>

</td>
<td>
{% if (!i) { %}
<button class="btn btn-warning cancel">
<i class="glyphicon glyphicon-ban-circle"></i>
<span>Cancel</span>
</button>
<button type="button" class="btn btn-danger remove hide" imgSrc="">
<i class="glyphicon glyphicon-trash"></i>
<span>Delete</span>
</button>
{% } %}
</td>
</tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<tr class="template-download fade">
<td>
<span class="preview">
{% if (file.thumbnailUrl) { %}
<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
{% } %}
</span>
</td>
<td>
<p class="name">
{% if (file.url) { %}
<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
{% } else { %}
<span>{%=file.name%}</span>
{% } %}
</p>
{% if (file.error) { %}
<div><span class="label label-danger">Error</span> {%=file.error%}</div>
{% } %}
</td>
<td>
<span class="size">{%=o.formatFileSize(file.size)%}</span>
</td>
<td>
{% if (file.deleteUrl) { %}
<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
<i class="glyphicon glyphicon-trash"></i>
<span>Delete</span>
</button>
{% } else { %}
<button class="btn btn-warning cancel">
<i class="glyphicon glyphicon-ban-circle"></i>
<span>Cancel</span>
</button>
{% } %}
</td>
</tr>
{% } %}
</script>
@stop

@section('content')

<div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">

<div class="panel panel-default">
  <div class="panel-body" style="padding:0">
    <ul id="myTabs" class="nav nav-tabs my-md-tabs" role="tablist">
      @if(isset($new_array))
        @foreach($new_array as $datakey => $data)
            @if($datakey == 1)
              <li role="presentation" class="active tab-li">
                <a class="clearfix stepy-wrapper-md" href="#{{$data['title']}}" id="{{$data['title']}}-tab" role="tab" data-toggle="tab" aria-controls="{{$data['title']}}" aria-expanded="true">
            @else
              <li role="presentation" class="tab-li">
                <a class="clearfix stepy-wrapper-md" href="#{{$data['title']}}" role="tab" id="{{$data['title']}}-tab" data-toggle="tab" aria-controls="{{$data['title']}}">
            @endif
          <span class="step-no badge badge-new">{{$datakey}}</span>
          <span class="stepy-text-wrapper">
            <ol class="stepy-right-text">
              <li class="stepy-right-text-no">Step {{$datakey}}</li>
              <li class="stepy-right-text-title">{{$data['title']}}</li>     
            </ol>
          </span>
          <i class="next-icon glyphicon glyphicon-circle-arrow-right"></i>
          </a>
          </li>
        @endforeach
      @endif
    </ul>
    <ul id="myTabs" class="nav nav-tabs my-sm-tabs hide" role="tablist">
      @if(isset($new_array))
        @foreach($new_array as $datakey => $data)
            @if($datakey == 1)
              <li role="presentation" class="active col-xs-12 tab-li-sm">
              <a class="clearfix stepy-wrapper col-xs-12" href="#{{$data['title']}}" id="{{$data['title']}}-tab" role="tab" data-toggle="tab" aria-controls="{{$data['title']}}" aria-expanded="true">
            @else
              <li role="presentation" class="col-xs-12 tab-li-sm">
              <a class="clearfix stepy-wrapper col-xs-12" href="#{{$data['title']}}" role="tab" id="{{$data['title']}}-tab" data-toggle="tab" aria-controls="{{$data['title']}}">
            @endif
          <span class="step-no">{{$datakey}}</span>
          <span class="stepy-text-wrapper">
            <ol class="stepy-right-text">
              <li class="stepy-right-text-no">Step {{$datakey}}</li>
              <li class="stepy-right-text-title">{{$data['title']}}</li>     
            </ol>
          </span>
          </a>
          </li>
        @endforeach
      @endif
    </ul>
    <div id="myTabContentx" class="tab-contentx">
      <div id="form-1">
        {!! Form::open(array('action' => 'PagesController@postAddPreviewStep', 'id'=>'fileupload', 'class'=>'top-form','role'=>"form")) !!}
         
          @if(isset($preview_session_data['page_header_option']))
            @if($preview_session_data['page_header_option'] != 0)
              <div class="my-tab
              @if(!isset($is_tab_active_array,$is_tab_active_array['page_header_option']['active']))
                hide 
              @endif
              container panel panel-default" id="header" aria-labelledby="header-tab">
                <div class="panel-body">
                  <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
                    <label class="control-label" for="title">Header Text</label>
                    @if(isset($data_add_session['header_text']))
                      {!! Form::text('header_text', $data_add_session['header_text'], array('class'=>'form-control', 'placeholder'=>'Header Text')) !!}
                    @else
                      {!! Form::text('header_text', null, array('class'=>'form-control', 'placeholder'=>'Header Text')) !!}
                    @endif
                    @foreach($errors->get('title') as $message)
                      <span class='help-block'>{{ $message }}</span>
                    @endforeach
                  </div>
                </div>
                <div class="panel-footer tab-footer text-center" this-step="first">
                  <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default stepy-btn-pre" disabled="disabled"><i class="glyphicon glyphicon-chevron-left"></i> Previous Step</button>
                    <button type="button" class="btn btn-default stepy-btn-nxt">Next Step <i class="glyphicon glyphicon-chevron-right"></i></button>
                  </div>
                </div>
              </div>
            @endif
          @endif

          @if(isset($preview_session_data['page_slider_option']))
            @if($preview_session_data['page_slider_option'] != 0)
              <div class="my-tab container panel 
              @if(!isset($is_tab_active_array,$is_tab_active_array['page_slider_option']['active']))
                hide 
              @endif
              panel-default" id="slider" aria-labelledby="slider-tab">
              <div class="panel panel-default image-panel" style="margin-bottom:0;">
                <div class="panel-heading"><h4>Add Images</h4></div>
                <!-- The global progress state -->
                <div class="col-lg-12 fileupload-progress fade">
                  <!-- The global progress bar -->
                  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                  </div>
                  <!-- The extended global progress state -->
                  <div class="progress-extended">&nbsp;</div>
                </div>
                <div id="step1_panel" class="panel-body">
                  <!-- The table listing the files available for upload/download -->
                  <table id="displayImagesTable" role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                </div>
                <div class="panel-footer clearfix">
                  <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                  <div class="fileupload-buttonbar">
                    <div class="col-lg-7">
                      <!-- The fileinput-button span is used to style the file input field as button -->
                      <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Add files...</span>
                        <input type="file" name="files" multiple>
                      </span>
                      <button type="reset" class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel upload</span>
                      </button>
                      <!-- The global file processing state -->
                      <span class="fileupload-process"></span>
                    </div>
                  </div>
                </div>
              </div>  
              <div id="imageDiv" class="hide">
                @if(isset($data_add_session['files']))
                  @foreach($data_add_session['files'] as $srcskey => $srcs)
                    <input class="images" name="files[{{$srcskey}}][path]" type="hidden" value="{!!$srcs['path']!!}"/>
                  @endforeach
                @endif
              </div>
              <div id="imageDiv-single" class="hide">
                @if(isset($data_add_session['file-single'][0]['path']))
                    <input class="images-single" name="file-single[{{$srcskey}}][path]" type="hidden" value="{!!$data_add_session['file-single'][0]['path']!!}"/>
                @endif
              </div>
                @if(isset($data_add_session['files']))
                  <div class="row" style="margin-top: 20px;">
                    @foreach($data_add_session['files'] as $srcs)

                    <div class="existingImagesDiv col-sm-6 col-md-4">
                      <div class="thumbnail">
                        <img class="image-url" style="max-height:140px; max-width:100%;" src="{!!$srcs['path']!!}" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">
                        <div class="caption">
                          <h3>Options</h3>
                          <button type="button" class="viewImage btn btn-default btn-sm pull-right view-image">View</button>
                          <button type="button" class="removeImage btn btn-danger btn-sm delete-image">Delete</button>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                @endif

                <div class="panel-footer tab-footer text-center" this-step="2">
                  <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default stepy-btn-pre"><i class="glyphicon glyphicon-chevron-left"></i> Previous Step</button>
                    <button type="button" class="btn btn-default stepy-btn-nxt">Next Step <i class="glyphicon glyphicon-chevron-right"></i></button>
                  </div>
                </div>

              </div>
            @endif
          @endif

          @if(isset($preview_session_data['page_section_number']))
            @if($preview_session_data['page_section_number'] != 0)
              <div class="my-tab  container
              @if(!isset($is_tab_active_array,$is_tab_active_array['page_section_number']['active']))
                hide
              @endif
              panel panel-default" id="section" aria-labelledby="section-tab">
                <div class="panel-body section-wrapper">
                  <button id="add-more-section" class="btn btn-success pull-right btn-sm">Add More Section <i class="glyphicon glyphicon-plus"  ></i></button>
                  @for ($i = 0; $i < $preview_session_data['page_section_number']; $i++)
                    <h3>Section {{$i+1}}</h3>
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : false }}">
                      <label class="control-label" for="title">Title</label>
                      @if(isset($data_add_session['section'][$i]['title']))
                        {!! Form::text('section['.$i.'][title]', $data_add_session['section'][$i]['title'], array('class'=>'form-control', 'placeholder'=>'Title')) !!}
                      @else
                        {!! Form::text('section['.$i.'][title]', null, array('class'=>'form-control', 'placeholder'=>'Title')) !!}
                      @endif
                      @foreach($errors->get('title') as $message)
                        <span class='help-block'>{{ $message }}</span>
                      @endforeach
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : false }}">
                      <label class="control-label" for="description">Description</label>
                      @if(isset($data_add_session['section'][$i]['description']))
                        {!! Form::textarea('section['.$i.'][description]', $data_add_session['section'][$i]['description'], ['class' => 'des field form-control','size' => '30x3', 'placeholder'=>'Description']) !!}
                      @else
                        {!! Form::textarea('section['.$i.'][description]', null, ['class' => 'des field form-control','size' => '30x3', 'placeholder'=>'Description']) !!}
                      @endif
                      @foreach($errors->get('description') as $message)
                        <span class='help-block'>{{ $message }}</span>
                      @endforeach
                    </div>
                    <hr>
                  @endfor
                </div>
                <div class="panel-footer tab-footer text-center" this-step="last">
                  <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default stepy-btn-pre"><i class="glyphicon glyphicon-chevron-left"></i> Previous Step</button>
                    <button type="button" class="btn btn-default stepy-btn-nxt" disabled="disabled">Next Step <i class="glyphicon glyphicon-chevron-right"></i></button>
                  </div>
                </div>
              </div>
            @endif
          @endif
        {!! Form::close() !!}
      </div>

      <div id="form-2">
        {!! Form::open(array('action' => 'PagesController@postAddPreviewStep', 'id'=>'fileupload', 'class'=>'','role'=>"form")) !!}
          @if(isset($preview_session_data['page_image_option']))
            @if($preview_session_data['page_image_option'] != 0)
              <div class="my-tab container
                @if(!isset($is_tab_active_array,$is_tab_active_array['page_image_option']['active']))
                  hide 
                @endif
                panel panel-default" id="image" aria-labelledby="image-tab">
                <div class="panel panel-default image-panel" style="margin-bottom:0;">

                  <div class="panel-heading"><h4>Upload Single Image</h4></div>
                  <!-- The global progress state -->
                  <div class="col-lg-12 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                  </div>
                  <div id="step1_panel" class="panel-body">
                    <!-- The table listing the files available for upload/download -->
                    <table id="displayImagesTable" role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                  </div>
                  <div class="panel-footer clearfix">
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="fileupload-buttonbar">
                      <div class="col-lg-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span>Add files...</span>
                          <input type="file" name="files">
                        </span>
                        <button type="reset" class="btn btn-warning cancel">
                          <i class="glyphicon glyphicon-ban-circle"></i>
                          <span>Cancel upload</span>
                        </button>
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                      </div>
                    </div>
                  </div>
                </div>  

                  
                @if(isset($data_add_session['file-single'][0]['path']))
                <div class="row single-image-container" style="margin-top: 20px;">
                  <div class="existingImagesDiv col-sm-6 col-md-4">
                    <div class="thumbnail">
                      <img class="image-url" style="max-height:140px; max-width:100%;" src="{!!$data_add_session['file-single'][0]['path']!!}" data-holder-rendered="true" style="height: 180px; width: 100%; display: block;">
                      <div class="caption">
                        <h3>Options</h3>
                        <button type="button" class="viewImage btn btn-default btn-sm pull-right view-image">View</button>
                        <button type="button" class="removeImage btn btn-danger btn-sm delete-image-single">Delete</button>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
                <div class="panel-footer tab-footer text-center" this-step="3">
                  <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default stepy-btn-pre"><i class="glyphicon glyphicon-chevron-left"></i> Previous Step</button>
                    <button type="button" class="btn btn-default stepy-btn-nxt" >Next Step <i class="glyphicon glyphicon-chevron-right"></i></button>
                  </div>
                </div>
              </div>
            @endif
          @endif
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <div class="panel-footer clearfix">
    <button class="btn btn-primary pull-right preview-btn">Preview</button>
    <a href="{!!route('pages_add')!!}" class="btn btn-info pull-left" type="submit">Back</a>
  </div>
</div>


</div>

@stop