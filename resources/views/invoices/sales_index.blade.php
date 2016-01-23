@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Sales Index</h1>
    <ol class="breadcrumb">
      <li><a href="{!!route('sales_add')!!}">Sales Add</a></li>
      <li class="active">Sales Overview</li>
    </ol>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-bordered" style="font-size:18px">
            <thead>
              <tr>
                <th>Invoice Id</th>
                <th>Email</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($all_invs as $ackey => $cat)
                <tr>
                  <th scope="row">{{$cat['id']}}</th>
                  <td>{{$cat['email']}}</td>
                  <td>{{$cat['quantity']}}</td>
                  <td>{!!$cat['status_message']!!}</td>
                  <td>{{$cat['created_at_html']}}</td>
                  <td>
                    <a href="{!! route('invoice_view',$cat->id) !!}">View</a>&nbsp|&nbsp<a href="{!! route('invoice_edit',$cat->id) !!}">Edit</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
  </div>

</div>
@stop