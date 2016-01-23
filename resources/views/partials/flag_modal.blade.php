<div class="modal fade" id="flag_modal">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Flag</h4>
	      </div>
	      <div class="modal-body">
			  <div class="radio">
			    <label>
			      <input type="radio" name="optionsRadios" class="flag-radio" value="1"> Spam
			    </label>
			  </div>
			  <div class="radio">
			    <label>
			      <input type="radio" name="optionsRadios" class="flag-radio" value="2"> Inappropriate Content
			    </label>
			  </div>
			  <div class="radio">
			    <label>
			      <input type="radio" name="optionsRadios" class="flag-radio" value="3"> Abusive Behavior
			    </label>
			  </div>
			  <div class="radio">
			    <label>
			      <input type="radio" name="optionsRadios" class="flag-radio" value="4"> Violates terms of use
			    </label>
			  </div>
			  <div class="form-group">
				  <label class="">Details</label>
				  <textarea class="form-control" rows="4" id="modal-flag-reason"></textarea>
				</div>
	      </div>
	      <div class="modal-footer clearfix">
	        <button type="submit" id="modal-flag-it" class="btn btn-primary pull-right login-btn">Flag</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	    <input type="hidden" name="modal_thread_id" id="modal_thread_id">
 		<input type="hidden" name="modal_reply_id" id="modal_reply_id">
 		<input type="hidden" name="modal_this_flag" id="modal_this_flag">
 		<input type="hidden" name="modal_quote_id" id="modal_quote_id">
</div><!-- /.modal -->