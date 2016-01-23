
<div id="tasks-{!! $type !!}" class="tasks-item table-responsive {!! $hide !!}">
	<hr/>
	<table class="table">
		<thead>
			<tr>
				<th>Id</th>
				<th>Issue</th>
				<th>Description</th>
				<th>Creator</th>
				<th>Assigned</th>
				<th>Project</th>
				<th>Status</th>
				<th>Created</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		@if(isset($tasks))
			@foreach($tasks as $t)
			<tr>
				<td>{!! $t->id !!}</td>
				<td>{!! $t->title !!}</td>
				<td>{!! $t->description !!}</td>
				<td>{!! $t->created_username !!}</td>
				<td>{!! $t->assigned_username !!}</td>
				<td>{!! $t->project_name !!}</td>
				<td>{!! $t->status !!}</td>
				<td>{!! $t->created_date !!}</td>
				<td>
					<a href="{!! route('tasks_view',[$t->id]) !!}">View</a>
					@if($user_id == $t->created_by)
					<a href="{!! route('tasks_edit',[$t->id]) !!}" >Edit</a>
					@endif
				</td>
			</tr>
			@endforeach
		@endif
		</tbody>
	</table>
</div>