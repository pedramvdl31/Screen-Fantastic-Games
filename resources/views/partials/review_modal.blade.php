<div class="modal fade" tabindex="-1" role="dialog" id="review-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add Your Review</h4>
      </div>
      <div class="modal-body">
        <label style="margin-left: 1px !important;" class="control-label" for="inventory-title">From: {{Auth::user()->username}}</label>
        <div class="form-group">
            <input type="text" id="review_title" class="form-control"  placeholder="Title">
        </div>
        <div class="form-group">
            <textarea  class="form-control" id="review_description"  placeholder="Description" style="resize: vertical;"></textarea>
        </div>
         <div class="alert alert-success hide" id="successfully_posted_review" role="alert">successfully Posted!</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="review-modal-post-btn" class="btn btn-primary" inventory-id="" >Post</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->