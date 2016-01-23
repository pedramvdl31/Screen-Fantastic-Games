
<div class="categories-title ">

	<div>

		<img class="image-cat" u="image" src="/assets/images/layouts/categories-img.jpg" />
	</div>
</div>
<div class="panel-wrapper" style="min-height: 650px;">

	<div class="panel panel-default ">
		<div class="panel-heading ">
			<ul class="cat-ul">
				@foreach($all_categories as $all_cats)
				<li class="cat-li font-open-sans main-cat" this-cat="{{$all_cats['title']}}"><a>{!! $all_cats['title'] !!}</a></li>
				@endforeach
			</ul>
		</div>

		<?php
			$l_count = 0;
		?>
		<div class="panel-body clearfix" this-panel="">
			@foreach($all_categories as $all_cats)
				<?php
					$l_count++;
				?>	
				@if($l_count == 1)
					<div class="inv-cat-container {{$all_cats['title']}}" this-div="{{$all_cats['title']}}">
				@else
					<div class="inv-cat-container {{$all_cats['title']}} hide" this-div="{{$all_cats['title']}}">
				@endif
					@foreach($all_inventories as $all_invss)
						@foreach($all_invss as $all_invs)
							@if($all_cats['title'] == $all_invs['cat_title'])
								<div class="col-xs-6 col-md-3 thumbnail-wrapper" this-item="{{$all_invs['id']}}">

									@if(isset($liked_session))
										<?php 
										$likedd = false;
										?>
										@foreach($liked_session as $liked)
										@if($all_invs['id'] == $liked)
												<i class="glyphicon glyphicon-star-empty thumb_like_btn hide light-gray" ></i>
												<i class="glyphicon glyphicon-star thumb_like_btn_active gold" ></i>
											<?php 
											$likedd = true;
											?>
										@endif
										@endforeach

										@if($likedd == false)
											<i class="glyphicon glyphicon-star-empty thumb_like_btn hide light-gray" ></i>
											<i class="glyphicon glyphicon-star thumb_like_btn_active hide gold" ></i>
										@endif

									@else
										<i class="glyphicon glyphicon-star-empty thumb_like_btn hide light-gray" ></i>
										<i class="glyphicon glyphicon-star thumb_like_btn_active hide gold" ></i>
									@endif
									<a href="{!! route('view_this_item',$all_invs['id']) !!}"  class="thumbnail new-thumbnail cat_a_container" item-id="{{$all_invs['id']}}">
										<div class="thumb_img_wrapper">
											<img class="thumb-img" src="/assets/images/inventories/perm/{!! $all_invs['primary_0_src'] !!}" alt="...">
										</div>
										<div class="caption thumb-caption " style="color: #454545;">
											<address>
												<p><span class="under_l"><strong class="font-oswald"  id="item-title">{{$all_invs['title']}}</strong></span>
													@if(isset($all_invs['tags_title']))
														@foreach($all_invs['tags_title'] as $tagskey => $tagsvalue)
															<span class="label label-danger label-tag" style="font-size: 14px;">{{$tagsvalue}}</span>
														@endforeach
													@endif
												</p>
											</address>
											<p id="item-description" class="font-open-sans under_l">{{$all_invs['description']}}</p>
											<p id="item-price" class="font-open-sans under_l">{{$all_invs['sum_price']}}<small>원</small></p>
										</div>
									</a>
								</div>
							@endif
						@endforeach
					@endforeach
				</div>
			@endforeach
		</div>
		</div>
	</div>
</div>
