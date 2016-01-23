@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Reviews</h1>
</div>
<div class="panel panel-default">
  <div class="panel-heading"><h3>All Review</h3></div>
  <div class="panel-body">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
	    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
	    <li role="presentation"><a href="#deleted" aria-controls="deleted" role="tab" data-toggle="tab">Deleted</a></li>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
	    <div role="tabpanel" class="tab-pane active" id="all">
			<table class="table table-bordered" style="font-size:18px">
	            <thead>
	              <tr>
	                <th>Review Id</th>
	                <th>Title</th>
	                <th>Username</th>
	                <th>Item name</th>
	                <th>Status</th>
	                <th>Created at</th>
	                <th>Action</th>
	              </tr>
	            </thead>
	            <tbody>
	              	@foreach ($review as $ackey => $qa)
		              	@if(isset($qa['status']))
							@if($qa['status'] == 1)
			                <tr>
			                  <th scope="row">{{$qa['id']}}</th>
			                  <td>{{$qa['title']}}</td>
			                  <td>{{$qa['username']}}</td>
			                  <td>{{$qa['item_name']}}</td>
			                  <td>{!!$qa['status_message']!!}</td>
			                  <td>{{$qa['created_at_html']}}</td>
			                  <td>
			                    <a href="{!! route('review_view',$qa->id) !!}">View</a>
			                  </td>
			                </tr>
	              			@endif
						@endif
			        @endforeach
	            </tbody>
	    	</table>
	    </div>

	    <div role="tabpanel" class="tab-pane" id="deleted">
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
	              	@foreach ($review as $ackey => $qa)
		              	@if(isset($qa['status']))
							@if($qa['status'] == 3)
			                <tr>
			                  <th scope="row">{{$qa['id']}}</th>
			                  <td>{{$qa['title']}}</td>
			                  <td>{{$qa['username']}}</td>
			                  <td>{{$qa['item_name']}}</td>
			                  <td>{!!$qa['status_message']!!}</td>
			                  <td>{{$qa['created_at_html']}}</td>
			                  <td>
			                    <a href="{!! route('review_view',$qa->id) !!}">View</a>
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