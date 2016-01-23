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
{!! Html::style('/assets/css/inventories/edit.css') !!}
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
<script src="/assets/js/inventories/edit.js"></script>

@stop

@section('content')
<div class="jumbotron">
	<h1>Inventories Edit</h1>
</div>
	@if(isset($message_feedback))
		<div class="alert alert-success" role="alert">
	      <strong>Well done!</strong> {!! $message_feedback !!}
	    </div>
	@endif
	<div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title">Information</h3>
	  </div>
	  <div class="panel-body">
    		{!! Form::open(array('action' => 'InventoriesController@postEdit', 'class'=>'','id'=>'fileupload','role'=>"form")) !!}
			  	<input type="hidden" name="inv_id" value="{{$inventory->id}}">
			  	<div class="form-group {{ $errors->has('inventory-title') ? 'has-error' : false }}">
			    	<label class="control-label" for="inventory-title">Inventory title</label>
			    	{!! Form::text('inventory-title', $inventory->title, array('class'=>'form-control', 'placeholder'=>'Inventory Title')) !!}
			        @foreach($errors->get('inventory-title') as $message)
			            <span class='help-block'>{{ $message }}</span>
			        @endforeach
			  	</div>
			  	<div class="form-group {{ $errors->has('inventory-serial-number') ? 'has-error' : false }}">
		    		<label class="control-label" for="inventory-serial-number">Inventory Serial Number</label>
		    		{!! Form::text('inventory-serial-number', $inventory->serial_number, array('class'=>'form-control', 'placeholder'=>'inventory Serial Number')) !!}
		        	@foreach($errors->get('inventory-serial-number') as $message)
		            	<span class='help-block'>{{ $message }}</span>
		        	@endforeach
		  		</div>
			  	<div class="form-group {{ $errors->has('inventory-description') ? 'has-error' : false }}">
			    	<label class="control-label" for="inventory-description">Inventory Description</label>
			    	{!! Form::textarea('inventory-description', $inventory->description, array('class'=>'form-control', 'placeholder'=>'Inventory Description')) !!}
			        @foreach($errors->get('inventory-description') as $message)
			            <span class='help-block'>{{ $message }}</span>
			        @endforeach
			  	</div>
				<div class="form-group {{ $errors->has('status') ? 'has-error' : false }}">
			    	<label class="control-label" for="status">Status</label>
			    	{!! Form::select('status', $select_data, $inventory->status ,array('id'=>'cats','class'=>'form-control custom-dropdown__select')) !!}
			  	</div>

			<hr>
			<div class="input-group   {{ $errors->has('price') ? 'has-error' : false }}">
			  <span class="input-group-addon">₩</span>
					{!! Form::text('price', $inventory->unit_price, array('class'=>'form-control number','id'=>'price', 'placeholder'=>'Base Price')) !!}
			</div>
			<div class="row" style="margin-top:0">
				<div class="form-group col-md-5 pull-left  {{ $errors->has('option') ? 'has-error' : false }}" id="option-form" style="padding-left:0">
		    	{!! Form::text('code', null, array('class'=>'form-control col-md-6','id'=>'option-text', 'placeholder'=>'Selectable Items','style'=>'border-radius:3px')) !!}
			  	</div>
				<div class="input-group col-md-5 pull-left {{ $errors->has('price') ? 'has-error' : false }}">
				  <span class="input-group-addon">Extra Charge</span>
						{!! Form::text('extra-charge', 0, array('class'=>'form-control number','id'=>'option-price', 'placeholder'=>'Extra Charge')) !!}
				</div>
				<div class="form-group col-md-2 {{ $errors->has('option') ? 'has-error' : false }}" style="padding-right:0">
					<a class="btn btn-primary btn-block" id="add-option">Add</a>
			  	</div>
			</div>
		  	<div class="well well-sm clearfix" id="options-container">
		  		@if(isset($inventory['decoded_options']))
		  			@foreach($inventory['decoded_options'] as $optionkey => $option)
		        		<span class="clearfix all-options label label-default col-md-12">
			        		<span class="this-count">{{$optionkey}}</span>: {{$option['text']}}
			        		@if ($option['price']>0)
			        			&nbsp(+₩{{$option['price']}})
			        		@endif
			        		<i class="glyphicon glyphicon-trash pull-right trash-i" option-id="{{$option['id']}}"></i>
		        		</span>
		  			@endforeach
		  		@endif
		  		<div id="deleted_options_container"></div>
		  	</div>
			<hr>
		  	<div class="form-group {{ $errors->has('categories') ? 'has-error' : false }}">
		    	<label class="control-label" for="categories">Categories</label>
		  		{!! Form::select('categories',$categories ,$inventory->category_id, ['class'=>'form-control','status'=>false]) !!}
		        @foreach($errors->get('categories') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>
		  	<div class="form-group {{ $errors->has('layout') ? 'has-error' : false }}">
		    	<label class="control-label" for="layout">Layouts</label>
					@if(isset($pages_checkboxes_html))
						{!! $pages_checkboxes_html !!}
					@endif
		  	</div>

			  	

			<div class="form-group {{ $errors->has('tag_text') ? 'has-error' : false }}">
		    	<label class="control-label" for="tag_text">Tag</label>
		  		{!! Form::select('tags',$tags_for_select ,null, ['class'=>'form-control','id'=>'tag_select','status'=>false]) !!}
		        @foreach($errors->get('tag_text') as $message)
		            <span class='help-block'>{{ $message }}</span>
		        @endforeach
		  	</div>	
		  	<div class="alert alert-danger tag_dup hide" role="alert">Tag has been selected!</div>
		  	<div class="well well-sm clearfix" id="tags-container">
		  		@if(isset($inventory['tags_title']))
					@foreach($inventory['tags_title'] as $tags_key => $tags_title)
						<div class="tag_div" tag_id="{{$tags_key}}" tag_text="{{$tags_title}}">
							<input type="hidden" name="tag[{{$tags_key}}]" value="1">
							<span class="label label-danger tag_label" tag_id="{{$tags_key}}">{{$tags_title}} 
								<span class="badge delete_tag">
									<i class="glyphicon glyphicon-remove"></i>
								</span>
							</span>
						</div>
					@endforeach
				@endif
		  	</div>	



		<div class="panel-heading" style="padding: 10px 0px;border-top:1px solid #ddd; border-top-left-radius:0px; border-top-right-radius:0px;">
			<h3 class="panel-title">Manage Images</h3>
		</div>
		<div class="panel-body">
			<div class="col-lg-12 col-md-12">
				@if(isset($inventory->primary_image))
					@foreach($inventory->primary_image as $pkey => $pimage_src)
					<div class="existingImagesDiv col-sm-6 col-md-4" kind="primary">
						<div class="thumbnail">
							<img class="image-url" style="max-height:140px; max-width:100%;" src="{!! $pimage_src !!}">
							<div class="caption">
								<h3>Primary Images</h3>
								<button type="button" class="viewImage btn btn-default btn-sm pull-right view-image">View</button>
								<button type="button" class="removeImage btn btn-warning btn-sm change-image">Change</button>
							</div>
						</div>
						{!! Form::hidden('pre_files_primary['.$pkey.'][path]',$pimage_src, ['class'=>'oldImages_primary','index'=>$pkey]) !!}
					</div>
					@endforeach
				@endif
				@if(isset($inventory->description_image))
					@foreach($inventory->description_image as $dkey => $dimage_src)
					<div class="existingImagesDiv col-sm-6 col-md-4 " kind="description">
						<div class="thumbnail">
							<img class="image-url" style="max-height:140px; max-width:100%;" src="{!! $dimage_src !!}">
							<div class="caption">
								<h3>Description Images</h3>
								<button type="button" class="viewImage btn btn-default btn-sm pull-right view-image">View</button>
								<button type="button" class="removeImage btn btn-warning btn-sm change-image">Change</button>
							</div>
						</div>
						{!! Form::hidden('pre_files_description['.$dkey.'][path]',$dimage_src, ['class'=>'oldImages_description','index'=>$dkey]) !!}
					</div>
					@endforeach
				@endif

				<div class="row"></div>

				@if(isset($inventory->image_srcs))
					@foreach($inventory->image_srcs as $key => $image_src)
					<div class="existingImagesDiv col-sm-6 col-md-4">
						<div class="thumbnail">
							<img class="image-url" style="max-height:140px; max-width:100%;" src="{!! $image_src !!}">
							<div class="caption">
								<h3>Extra Images</h3>
								<button type="button" class="viewImage btn btn-default btn-sm pull-right view-image">View</button>
								<button type="button" class="removeImage btn btn-danger btn-sm delete-image">Delete</button>
							</div>
						</div>
						{!! Form::hidden('pre_files['.$key.'][path]',$image_src, ['class'=>'oldImages','index'=>$key]) !!}
					</div>
					@endforeach
				@endif
			</div>
		</div>
			<hr>
			<div class="form-group">
		    	<label class="control-label" for="">Image Upload</label>
		  	</div>

			<div class="panel panel-default primary_image_container hide">
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
			{!! Form::open(array('action' => 'InventoriesController@postEdit', 'id'=>'fileupload-extra', 'class'=>'','role'=>"form")) !!}

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


			{!! Form::open(array('action' => 'InventoriesController@postEdit', 'id'=>'fileupload-description', 'class'=>'','role'=>"form")) !!}

		  	<!-- #####	 -->
			<div class="panel panel-default description_image_container hide">
				
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





			<div id="deletedImageDiv" class="hide"></div>
			

	  </div>

	   <div class="panel-footer clearfix">
			<a href="{!! route('inventory_index') !!} " class="btn btn-info col-md-1">Back</a>

			 <button class="btn btn-primary pull-right" id="submit-form">Update</button>
			 {!! Form::close() !!}
			 {!! Form::open(array('action' => 'InventoriesController@postDelete', 'class'=>'','id'=>'fileupload','role'=>"form")) !!}
			 	<button type="submite" class="btn btn-danger pull-right">Delete</button>
			 	<input type="hidden" name="inv_idd" value="{{$inventory->id}}">
			 {!! Form::close() !!}
	   </div>
	</div>
	
	{!! View::make('partials.inv_image_modal') !!}
@stop