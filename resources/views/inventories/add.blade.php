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
@stop
@section('scripts')
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
<script type="text/javascript" src="/packages/priceformat/priceformat.min.js"></script>
<script type="text/javascript" src="/assets/js/inventories/add.js"></script>
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
<div class="jumbotron">
	<h1>Inventories Add</h1>
</div>
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Information</h3>
	  </div>
	  <div class="panel-body">
    		{!! Form::open(array('action' => 'InventoriesController@postAdd', 'id'=>'fileupload', 'class'=>'','role'=>"form")) !!}
		  	<div class="form-group {{ $errors->has('inventory-title') ? 'has-error' : false }}">
		    	<label class="control-label" for="inventory-title">Inventory title</label>
		    	{!! Form::text('inventory-title', null, array('class'=>'form-control', 'placeholder'=>'inventory Title')) !!}
		        @foreach($errors->get('inventory-title') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
		  	<div class="form-group {{ $errors->has('inventory-serial-number') ? 'has-error' : false }}">
		    	<label class="control-label" for="inventory-serial-number">Inventory Serial Number</label>
		    	{!! Form::text('inventory-serial-number', null, array('class'=>'form-control', 'placeholder'=>'inventory Serial Number')) !!}
		        @foreach($errors->get('inventory-serial-number') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
		  	<div class="form-group {{ $errors->has('inventory-description') ? 'has-error' : false }}">
		    	<label class="control-label" for="inventory-description">Inventory Description</label>
		    	{!! Form::textarea('inventory-description', null, array('class'=>'form-control', 'placeholder'=>'Inventory Description')) !!}
		        @foreach($errors->get('inventory-description') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
			<div class="form-group">
			  	<label class="control-label" for="base-price">Base price</label>
			  	<div class="input-group   {{ $errors->has('price') ? 'has-error' : false }}">
				  <span class="input-group-addon">₩</span>
						{!! Form::text('price', null, array('class'=>'form-control number','id'=>'price', 'placeholder'=>'Base Price')) !!}
				</div>
			</div>

			<hr>
			<label class="control-label" for="base-price">Options</label>
			<div class="row" style="margin-top:0">
				<div class="form-group col-md-5 pull-left  {{ $errors->has('option') ? 'has-error' : false }}" id="option-form" style="padding-left:0">
		    	{!! Form::text('code', null, array('class'=>'form-control col-md-6','id'=>'option-text', 'placeholder'=>'options','style'=>'border-radius:3px')) !!}
			  	</div>
				<div class="input-group col-md-5 pull-left {{ $errors->has('price') ? 'has-error' : false }}">
				  <span class="input-group-addon">Extra Charge</span>
						{!! Form::text('extra-charge', 0, array('class'=>'form-control number','id'=>'option-price', 'placeholder'=>'Extra Charge')) !!}
				</div>
				<div class="form-group col-md-2 {{ $errors->has('option') ? 'has-error' : false }}" style="padding-right:0">
					<a class="btn btn-primary btn-block" id="add-option">Add</a>
			  	</div>
			</div>
		  	<div class="well well-sm clearfix" id="options-container"></div>
			<hr>





		  	<div class="form-group {{ $errors->has('categories') ? 'has-error' : false }}">
		    	<label class="control-label" for="categories">Categories</label>
		  		{!! Form::select('categories',$categories ,null, ['class'=>'form-control','status'=>false]) !!}
		        @foreach($errors->get('categories') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
			


		  	<div class="form-group {{ $errors->has('tag_text') ? 'has-error' : false }}">
		    	<label class="control-label" for="tag_text">Tag</label>
		  		{!! Form::select('tags-list',$tags_for_select ,null, ['class'=>'form-control','id'=>'tag_select','status'=>false]) !!}
		        @foreach($errors->get('tag_text') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>	
		  	<div class="alert alert-danger tag_dup hide" role="alert">Tag has been selected!</div>
		  	<div class="well well-sm clearfix" id="tags-container"></div>
	
		  	<div class="form-group {{ $errors->has('layout') ? 'has-error' : false }}">
		    	<label class="control-label" for="layout">Layouts</label>
					@if(isset($pages_checkboxes_html))
						{!! $pages_checkboxes_html !!}
					@endif
		  	</div>

		  	<div class="form-group">
		    	<label class="control-label" for=""><h3>Image Upload</h3></label>
		  	</div>



		  	<!-- #####	 -->
			<div class="panel panel-default">
				
				<div class="panel-heading"><h4>Main Image</h4></div>
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
			        <table id="displayImagesTable-main" kind="main" role="presentation" class="table table-striped top"><tbody class="files"></tbody></table>
				</div>
				<div class="panel-footer clearfix">
					<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
			        <div class="fileupload-buttonbar">
			            <div class="col-lg-7">
			                <!-- The fileinput-button span is used to style the file input field as button -->
			                <span class="btn btn-success fileinput-button">
			                    <i class="glyphicon glyphicon-plus"></i>
			                    <span>Add Main Image</span>
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
			<!-- ###### -->

			<div id="imageDiv-main" class="hide"></div>
			<div id="imageDiv-extra" class="hide"></div>
			<div id="imageDiv-description" class="hide"></div>


			{!! Form::close() !!}

	    	{!! Form::open(array('action' => 'InventoriesController@postAdd', 'id'=>'fileupload-extra', 'class'=>'','role'=>"form")) !!}

		  	<!-- #####	 -->
			<div class="panel panel-default">
				
				<div class="panel-heading"><h4>Extra Images</h4></div>
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
			        <table id="displayImagesTable-extra" kind="extra" role="presentation" class="table table-striped top"><tbody class="files"></tbody></table>
				</div>
				<div class="panel-footer clearfix">
					<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
			        <div class="fileupload-buttonbar">
			            <div class="col-lg-7">
			                <!-- The fileinput-button span is used to style the file input field as button -->
			                <span class="btn btn-success fileinput-button">
			                    <i class="glyphicon glyphicon-plus"></i>
			                    <span>Add Extra Images</span>
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
			<!-- ###### -->
			{!! Form::close() !!}


			{!! Form::open(array('action' => 'InventoriesController@postAdd', 'id'=>'fileupload-description', 'class'=>'','role'=>"form")) !!}

		  	<!-- #####	 -->
			<div class="panel panel-default">
				
				<div class="panel-heading"><h4>Description Image</h4></div>
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
			        <table id="displayImagesTable-des" kind="description" role="presentation" class="table table-striped  top"><tbody class="files"></tbody></table>
				</div>
				<div class="panel-footer clearfix">
					<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
			        <div class="fileupload-buttonbar">
			            <div class="col-lg-7">
			                <!-- The fileinput-button span is used to style the file input field as button -->
			                <span class="btn btn-success fileinput-button">
			                    <i class="glyphicon glyphicon-plus"></i>
			                    <span>Add Image</span>
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
			<!-- ###### -->
			{!! Form::close() !!}


			
	  		</div>
	  		<div class="panel-footer clearfix">
	  			<a href="{!! route('inventory_index') !!} " class="btn btn-info">Back</a>
				<button class="btn btn-primary pull-right" id="submit-form" type="submite">Add</button>
			</div>
			
	</div>
@stop