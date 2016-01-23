@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Questions And Answers</h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><h3>Q&A</h3></div>
  <div class="panel-body">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
	    <li role="presentation" class="active"><a href="#new" aria-controls="new" role="tab" data-toggle="tab">New</a></li>
	    <li role="presentation"><a href="#answered" aria-controls="answered" role="tab" data-toggle="tab">Answered</a></li>
	    <li role="presentation"><a href="#deleted" aria-controls="deleted" role="tab" data-toggle="tab">Deleted</a></li>
	    <li role="presentation"><a href="#rp" aria-controls="rp" role="tab" data-toggle="tab">All Replies</a></li>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="new">
			<table class="table table-bordered" style="font-size:18px">
	            <thead>
	              <tr>
	                <th>Q&A Id</th>
	                <th>Title</th>
	                <th>Username</th>
	                <th>Item name</th>
	                <th>Status</th>
	                <th>Created at</th>
	                <th>Action</th>
	              </tr>
	            </thead>
	            <tbody>
	              	@foreach ($qnas as $ackey => $qa)
		              	@if(isset($qa['status']))
							@if($qa['status'] == 1 && $qa['type'] == 1)
			                <tr>
			                  <th scope="row">{{$qa['id']}}</th>
			                  <td>{{$qa['title']}}</td>
			                  <td>{{$qa['username']}}</td>
			                  <td>{{$qa['item_name']}}</td>
			                  <td>{!!$qa['status_message']!!}</td>
			                  <td>{{$qa['created_at_html']}}</td>
			                  <td>
			                    <a href="{!! route('qna_view',$qa->id) !!}">View</a>
			                  </td>
			                </tr>
	              			@endif
						@endif
			        @endforeach
	            </tbody>
	    	</table>
	    </div>
	    <div role="tabpanel" class="tab-pane" id="answered">
			<table class="table table-bordered" style="font-size:18px">
		            <thead>
		              <tr>
		                <th>Q&A Id</th>
		                <th>Title</th>
		                <th>Username</th>
		                <th>Item name</th>
		                <th>Status</th>
		                <th>Created at</th>
		                <th>Action</th>
		              </tr>
		            </thead>
		            <tbody>
		              	@foreach ($qnas as $ackey => $qa)
			              	@if(isset($qa['status']))
								@if($qa['status'] == 2)
				                <tr>
				                  <th scope="row">{{$qa['id']}}</th>
				                  <td>{{$qa['title']}}</td>
				                  <td>{{$qa['username']}}</td>
				                  <td>{{$qa['item_name']}}</td>
				                  <td>{!!$qa['status_message']!!}</td>
				                  <td>{{$qa['created_at_html']}}</td>
				                  <td>
				                    <a href="{!! route('qna_view',$qa->id) !!}">View</a>
				                  </td>
				                </tr>
		              			@endif
							@endif
				        @endforeach
		            </tbody>
		      </table>
	    </div>
	    <div role="tabpanel" class="tab-pane" id="deleted">
	    	@foreach($qnas as $qa)
	    		@if(isset($qa['status']))
	    			@if($qa['status'] == 3)
	    			
	    			@endif
			 	@endif
			@endforeach
	    </div>
	    <div role="tabpanel" class="tab-pane" id="rp">
			<table class="table table-bordered" style="font-size:18px">
		            <thead>
		              <tr>
		                <th>Q&A Id</th>
		                <th>Title</th>
		                <th>Username</th>
		                <th>Item name</th>
		                <th>Status</th>
		                <th>Created at</th>
		                <th>Action</th>
		              </tr>
		            </thead>
		            <tbody>
		              	@foreach ($qnas as $ackey => $qa)
			              	@if(isset($qa['status']))
								@if($qa['type'] == 2)
				                <tr>
				                  <th scope="row">{{$qa['id']}}</th>
				                  <td>{{$qa['title']}}</td>
				                  <td>{{$qa['username']}}</td>
				                  <td>{{$qa['item_name']}}</td>
				                  <td>{!!$qa['status_message']!!}</td>
				                  <td>{{$qa['created_at_html']}}</td>
				                  <td>
				                    <a href="{!! route('qna_view',$qa->id) !!}">View</a>
				                  </td>
				                </tr>
		              			@endif
							@endif
				        @endforeach
		            </tbody>
		    </table>
	    </div>
	  </div>
  </div>
</div>




@stop