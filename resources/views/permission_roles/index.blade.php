@extends($layout)
@section('stylesheets')
@stop
@section('scripts')
@stop
@section('content')
<div class="jumbotron">
  <h1>Permission Roles Index</h1>
</div>
<div class="panel panel-default" style="font-size:18px">
  <div class="panel-body">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" >
      {{--*/ $num = 1 /*--}}
      @foreach($roles_array as $keyrole => $role)
      <li class="{{$num==1?'active':''}}">
        <a href="#{{$role}}" role="tab" data-toggle="tab">
          {{$role}}
        </a>
      </li>
      {{--*/ $num++ /*--}}
      @endforeach
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <spc style="margin:10px;"></spc>
      {{--*/ $num_2 = 1 /*--}}
      @foreach($output as $output_s => $value)
      <div class="tab-pane fade {{$num_2==1?'active in':''}}" id="{{$output_s}}">
        <table class="table table-bordered">
          <tbody>
            @foreach($value as $kslugs => $slugs)
            <tr>
              <th scope="row">{{$slugs}}</th>
              <td>
                <a href="{!! route('permission_roles_edit',$kslugs) !!}">Edit</a>
                  |
                <a href="{!! route('permission_roles_delete',$kslugs) !!}" style="color:#d9534f">Delete</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{--*/ $num_2++ /*--}}
      @endforeach
    </div>
  </div>
  <div class="panel-footer clearfix">
   <a class="btn btn-primary pull-right" href="{!! route('permission_roles_add') !!}"> Add New Role </a>
 </div>
</div>

@stop