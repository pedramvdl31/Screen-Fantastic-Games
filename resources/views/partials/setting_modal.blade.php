<div class="modal fade" id="thread_setting">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Thread Setting</h4>
      </div>
      <hr>
      <div class="modal-body">
        {!! Form::open(array('action' => 'ThreadsController@postSettingFrom', 'class'=>'','role'=>"form",'id'=>'login-form-1')) !!}
        <div class="checkbox">
          <label>
            <input value="1" type="checkbox" name="notify_me" id="notify_me_checkbox" {{$checked}}> Notify Me
          </label>
          <span id="setting_saved" class="label label-success hide pull-right">Saved!</span>
        </div>
          <div class="form-horizontal clearfix">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-4 control-label" style="text-align: left;">Thread Status</label>
              <div class="col-sm-8">
                {!! Form::select('thread_status', $selects, $status_prepared ,array('id'=>'thread_status','class'=>'form-control')) !!}
              </div>
            </div>
            <button type="submit" class="btn btn-primary pull-right">Save</button>
          </div>
          <input type="hidden" name="thread_id" value="{{$thread_id}}">
        {!! Form::close() !!}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->