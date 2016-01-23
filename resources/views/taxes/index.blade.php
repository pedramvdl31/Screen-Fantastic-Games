@extends($layout)
@section('stylesheets')

@stop
@section('scripts')

@stop

@section('content')
<div class="jumbotron">
  <h1>Taxes Index</h1>
</div>
<div class="panel panel-default">
  <div class="panel-body">
    <div class="table-responsive">
      <table class="table table-bordered" style="font-size:18px">
            <thead>
              <tr>
                <th>Title</th>
                <th>City</th>
                <th>Country</th>
                <th>Rate</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($taxes as $taxkey => $tax)
                
                <tr>
                  <th scope="row">{{$tax['title']}}</th>
                  <td>{{$tax['city_txt']}}</td>
                  <td>{{$tax['country']}}</td>
                  <td>{{$tax['rate']}}</td>
                  <td>{!!$tax['status_message']!!}</td>
                  <td>{{$tax['created_at_html']}}</td>
                  <td>
                    <a href="">View</a> / 
                    <a href="{!! route('taxes_edit',$tax['id']) !!}">Edit</a>
                  </td>
                </tr>
                
              @endforeach
            </tbody>
          </table>
        </div>
  </div>
  <div class="panel-footer clearfix">
      
  </div>
</div>
@stop