<div class="modal fade" id="ask_modal">
  {!! Form::open(array('action' => 'ThreadsController@postAdd', 'class'=>'','role'=>"form",'id'=>'question_add')) !!}
  <div class="modal-dialog ask-dialog">
    <div class="modal-content question-modal-content">
      <div class="modal-header ask-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Your Question</h4>
      </div>
      <div class="modal-body">
        <!-- STEP 1 -->
        <div class="step-1 step" step="1" state="active">
          <div class="left-modal-inner col-sm-8">
            <textarea placeholder="Title of your question"
            id="comment_text" cols="40"
            class="ui-autocomplete-input" autocomplete="off" role="textbox"
            aria-autocomplete="list" aria-haspopup="true" name="question[title]"></textarea>
          </div>
          <div class="right-modal-inner col-sm-4">
            <span>Did you search first to make sure your question is unique?</span>
          </div>
          <div class="col-md-12 col-xs-12">
           <div class="alert alert-warning hide" id="no-title-alert-step-1" style="" role="alert">You must add title before continuing</div>
          </div>
           
        </div>
        <!-- STEP 1 END -->

        <!-- STEP 2 -->
        <div class="step-2 step hide" step="2">
          <div class="model-inner-2 col-sm-12">
            <span class="inner-title">You Asked:</span>
            <div class="alert alert-success alert-dark-1 alert-top-margin" id="you-asked" role="alert"></div>
            <hr>
            <span class="inner-title">Existing Questions:</span>
            <div class="alert alert-success alert-dark-2 alert-top-margin existing-query" role="alert">
            </div>
            <hr>
          </div>
        </div>
        <!-- STEP 2 END -->

        <!-- STEP 3 -->
        <div class="step-3 step hide" step="3">
          <div class="left-modal-inner-3 col-sm-8">
            <textarea placeholder="Title of your question"
            name="question[title_2]" id="question-title"
            class="ui-autocomplete-input textarea-title" autocomplete="off" role="textbox"
            aria-autocomplete="list" aria-haspopup="true"></textarea>
            <textarea autofocus placeholder="Description of your question"
            name="question[description]" id="question-description" cols="40"
            class="ui-autocomplete-input textarea-description" autocomplete="off" role="textbox"
            aria-autocomplete="list" aria-haspopup="true"></textarea>
          </div>
          <div class="right-modal-inner-3 col-sm-4">
            <div class="module secondary-module">
              <div class="secondary-heading">
                <h4>Notifications</h4>
              </div>
              <ul class="options-list">
                <li class="options-list-item"> 
                  <input checked="checked" id="notify-me" name="notify-me" type="checkbox" value="1" class="placeholder-processed">
                  <label for="notify-me" class="notify-me">Email me when someone replies to this discussion</label>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-12 col-xs-12"> 
            <div class="alert alert-warning hide" id="no-description-alert" style="" role="alert">You must add description before continuing</div>
            <div class="alert alert-warning hide" id="no-title-alert" style="" role="alert">You must add title before continuing</div>
          </div>        
        </div>
        <!-- STEP 3 END -->
        <!-- STEP 4 -->
        <div class="step-4 step hide" step="4">
          <div class="form-group padding-categories">
            <span class="custom-dropdown custom-dropdown--white">
              <select class="custom-dropdown__select custom-dropdown__select--white">
                @foreach($categories_for_select as $ckey => $category)
                  <option value={{$ckey}}>{!!$category!!}</option>
                @endforeach
              </select>
            </span>
          </div>
          <span id="duplicate-error" class="hide">Category has been selected!</span>
          <div class="cat-wrapper col-md-12 col-xs-12"> 
            <h3 id="h3-wrapper">
            </h3>
            <div class="alert alert-warning hide" id="no-category-alert" style="" role="alert">You must select a category before continuing</div>
          </div>
        </div>
        <!-- STEP 4 END -->
      </div>
      <div class="modal-footer clearfix ask-footer">
        <button type="button" id="question-modal-back-btn" class="btn btn-default pull-left back-btn hide">Back</button>
        <button type="button" id="nxt-btn" class="btn btn-primary pull-right next-btn qst-modal">Next</button>
        <button type="button" id="qst-submit" class="btn btn-primary pull-right next-btn hide">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  {!! Form::close() !!}
</div><!-- /.modal -->