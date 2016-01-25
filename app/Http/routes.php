<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'beforeFilter'], function () {

	// WEBSITE PUBLIC PAGES
	Route::get('/articles',  ['as'=>'articles_page', 'uses' => 'HomeController@getArticles']);
	Route::get('/videos',  ['as'=>'videos_page', 'uses' => 'HomeController@getVideos']);

	Route::get('/admins',  ['as'=>'admins_index', 'uses' => 'AdminsController@getIndex']);
	Route::get('/admins-simple',  ['as'=>'simple_admin_index', 'uses' => 'AdminsController@getSimpleIndex']);
	Route::get('registration', ['as'=>'registration_view','uses'=>'UsersController@getRegistration']);
	Route::post('registration', ['uses'=>'UsersController@postRegistration']);
	Route::post('users/return-users',  ['uses' => 'UsersController@postReturnUsers', 'middleware' => ['acl:admins/acl/view']]);
	Route::post('users/invoice-users',  ['uses' => 'UsersController@postInvoiceUsers', 'middleware' => ['acl:admins/acl/view']]);
	Route::post('users/user-info',  ['uses' => 'UsersController@postUserInfo', 'middleware' => ['acl:admins/acl/view']]);

	Route::group(['prefix' => 'users'], function () {
		Route::get('login', ['as'=>'users_login','uses'=>'UsersController@getLogin']);
		Route::post('login',['uses'=>'UsersController@postLogin']);
		Route::post('login-invoices',['uses'=>'InvoicesController@postLoginInvoices']);
		Route::post('login-modal', ['uses'=>'UsersController@postLoginModal']);
		Route::get('profile/{username}',  ['as'=>'users_profile','uses' => 'UsersController@getProfile', function ($username) {}]);
		Route::post('profile',  ['as'=>'users_profile_post','uses' => 'UsersController@postProfile']);
		Route::post('user-auth', ['uses'=>'UsersController@postUserAuth']);
		Route::post('send-file', ['uses'=>'UsersController@postSendFile']);
		Route::post('validate', ['uses'=>'UsersController@postValidate']);
		Route::post('validate-sales', ['uses'=>'UsersController@postValidateSales']);
		Route::post('send-file-temp', ['uses'=>'UsersController@postSendFileTemp']);
		Route::get('logout', ['as'=>'users_logout','uses'=>'UsersController@getLogout']);
		Route::post('auth-check', ['as'=>'users_ac','uses'=>'UsersController@postUsersAuthCheck']);
		Route::post('auth-check-review', ['as'=>'users_ac_review','uses'=>'UsersController@postUsersAuthCheckReview']);
	});	
	Route::group(['prefix' => 'admins'], function () {
		Route::get('login', ['as'=>'admin_login', 'uses' => 'AdminsController@getLogin']);
		Route::post('login', 'AdminsController@postLogin');
		Route::get('logout', 'AdminsController@getLogout');			
	});


	// 	// NO ACL
	// Route::get('/admins',  ['as'=>'admins_index', 'uses' => 'AdminsController@getIndex']);
	// Route::group(['prefix' => 'admins'], function () {
	// 	Route::get('login', 'AdminsController@getLogin');
	// 	Route::post('login', 'AdminsController@postLogin');
	// 	Route::get('logout', 'AdminsController@getLogout');			
	// 	Route::get('roles',  ['as'=>'roles_index', 'uses' => 'RolesController@getIndex']);
	// 	Route::get('roles/add',  ['as'=>'roles_add', 'uses' => 'RolesController@getAdd']);
	// 	Route::post('roles/add',  ['uses' => 'RolesController@postAdd']);
	// 	Route::get('roles/edit/{id}',  ['as'=>'roles_edit', 'uses' => 'RolesController@getEdit']);
	// 	Route::post('roles/edit',  ['as'=>'roles_update','uses' => 'RolesController@postEdit']);
	// 	Route::get('roles/delete-data/{id}',  ['as'=>'roles_delete', 'uses' => 'RolesController@getDelete']);

	// 	Route::get('permissions',  ['as'=>'permissions_index', 'uses' => 'PermissionsController@getIndex']);
	// 	Route::get('permissions/add',  ['as'=>'permissions_add','uses' => 'PermissionsController@getAdd']);
	// 	Route::post('permissions/add',  ['uses' => 'PermissionsController@postAdd']);
	// 	Route::get('permissions/edit/{id}',  ['as'=>'permissions_edit','uses' => 'PermissionsController@getEdit']);
	// 	Route::post('permissions/edit',  ['uses' => 'PermissionsController@postEdit']);
	// 	Route::get('permissions/delete-data/{id}',  ['as'=>'permissions_delete','uses' => 'PermissionsController@getDelete']);

	// 	Route::get('permission-roles',  ['as'=>'permission_roles_index', 'uses' => 'PermissionRolesController@getIndex']);
	// 	Route::get('permission-roles/add',  ['as'=>'permission_roles_add', 'uses' => 'PermissionRolesController@getAdd']);
	// 	Route::post('permission-roles/add',  ['uses' => 'PermissionRolesController@postAdd']);
	// 	Route::get('permission-roles/edit/{id}',  ['as'=>'permission_roles_edit', 'uses' => 'PermissionRolesController@getEdit']);
	// 	Route::post('permission-roles/edit',  ['uses' => 'PermissionRolesController@postEdit']);
	// 	Route::get('permission-roles/delete-data/{id}',  ['as'=>'permission_roles_delete', 'uses' => 'PermissionRolesController@getDelete']);

	// 	Route::get('flags',  ['as'=>'flags_index', 'uses' => 'FlagsController@getIndex']);
	// 	Route::get('flags/view/{id}',  ['as'=>'flag_view', 'uses' => 'FlagsController@getView']);
	// 	Route::post('flags/view',  ['uses' => 'FlagsController@postView']);
	// 	Route::get('flags/approved',  ['as'=>'flags_app', 'uses' => 'FlagsController@getApproved']);
	// 	Route::get('flags/rejected',  ['as'=>'flags_rej', 'uses' => 'FlagsController@getRejected']);
	// 	Route::get('flags/re-flagged',  ['as'=>'flags_re', 'uses' => 'FlagsController@getReflagged']);
	// 	Route::get('flags/final-approved',  ['as'=>'flags_f_app', 'uses' => 'FlagsController@getFinalApproved']);
	// 	Route::get('flags/final-reject',  ['as'=>'flags_f_rej', 'uses' => 'FlagsController@getFinalRejected']);
	// 	Route::get('flags/banned',  ['as'=>'flags_banned', 'uses' => 'FlagsController@getBanned']);

	// 	Route::get('acl/view',  ['as' => 'acl_view','uses' => 'AdminsController@getViewAcl']);
	// 	Route::get('categories/view',  ['as'=>'category_view', 'uses' => 'AdminsController@getViewCategory']);
	// 	Route::get('categories/add',  ['as'=>'category_add', 'uses' => 'CategoriesController@getAdd']);
	// 	Route::post('categories/add',  ['uses' => 'CategoriesController@postAdd']);
	// 	Route::get('categories/edit',  ['as'=>'category_edit','uses' => 'CategoriesController@getEdit']);
	// 	Route::post('categories/edit',  ['uses' => 'CategoriesController@postEdit']);
	// 	Route::get('users/index',  ['as' => 'users_index','uses' => 'AdminsController@getUsersIndex']);
	// 	Route::get('users/add',  ['as' => 'users_add','uses' => 'AdminsController@getUsersAdd']);
	// 	Route::post('users/add',  ['uses' => 'AdminsController@postUsersAdd']);
	// 	Route::get('users/edit/{id}',  ['as' => 'users_edit','uses' => 'AdminsController@getUsersEdit']);
	// 	Route::post('users/edit',  ['uses' => 'AdminsController@postUsersEdit']);
	// });


			/** ADMINS ACL GROUP **/
	Route::group(['middleware' => ['auth']], function(){
		Route::get('admins',  ['as'=>'admins_index', 'uses' => 'AdminsController@getIndex', 'middleware' => ['acl:admins']]);
			
		Route::group(['prefix' => 'admins'], function () {
			$prefix = 'admins';	
			Route::get('roles',  ['as'=>'roles_index', 'uses' => 'RolesController@getIndex', 'middleware' => ['acl:'.$prefix.'/roles']]);
			Route::get('roles/add',  ['as'=>'roles_add', 'uses' => 'RolesController@getAdd','middleware' => ['acl:'.$prefix.'/roles/add']]);
			Route::post('roles/add',  ['uses' => 'RolesController@postAdd', 'middleware' => ['acl:'.$prefix.'/roles/add']]);
			Route::get('roles/edit/{id}',  ['as'=>'roles_edit', 'uses' => 'RolesController@getEdit', 'middleware' => ['acl:'.$prefix.'/roles/edit/{id}'], function ($id) {}]);
			Route::post('roles/edit',  ['as'=>'roles_update','uses' => 'RolesController@postEdit', 'middleware' => ['acl:'.$prefix.'/roles/edit']]);
			Route::get('roles/delete-data/{id}',  ['as'=>'roles_delete', 'uses' => 'RolesController@getDelete', 'middleware' => ['acl:'.$prefix.'/roles/delete-data{id}'], function ($id) {}]);

			Route::get('permissions',  ['as'=>'permissions_index', 'uses' => 'PermissionsController@getIndex', 'middleware' => ['acl:'.$prefix.'/permissions']]);
			Route::get('permissions/add',  ['as'=>'permissions_add','uses' => 'PermissionsController@getAdd', 'middleware' => ['acl:'.$prefix.'/permissions/add']]);
			Route::post('permissions/add',  ['uses' => 'PermissionsController@postAdd', 'middleware' => ['acl:'.$prefix.'/permissions/add']]);
			Route::get('permissions/edit/{id}', ['as' => 'permissions_edit', 'uses' => 'PermissionsController@getEdit','middleware' => ['acl:'.$prefix.'/permissions/edit/{id}'], function ($id) {}]);
			Route::post('permissions/edit',  ['uses' => 'PermissionsController@postEdit', 'middleware' => ['acl:'.$prefix.'/permissions/edit']]);
			Route::get('permissions/delete-data/{id}',  ['as'=>'permissions_delete','uses' => 'PermissionsController@getDelete', 'middleware' => ['acl:'.$prefix.'/permissions/delete-data{id}'], function ($id) {}]);

			Route::get('permission-roles',  ['as'=>'permission_roles_index', 'uses' => 'PermissionRolesController@getIndex', 'middleware' => ['acl:'.$prefix.'/permission-roles']]);
			Route::get('permission-roles/add',  ['as'=>'permission_roles_add', 'uses' => 'PermissionRolesController@getAdd', 'middleware' => ['acl:'.$prefix.'/permission-roles/add']]);
			Route::post('permission-roles/add',  ['uses' => 'PermissionRolesController@postAdd', 'middleware' => ['acl:'.$prefix.'/permission-roles/add']]);
			Route::get('permission-roles/edit/{id}',  ['as'=>'permission_roles_edit', 'uses' => 'PermissionRolesController@getEdit', 'middleware' => ['acl:'.$prefix.'/permission-roles/edit/{id}'], function ($id) {}]);
			Route::post('permission-roles/edit',  ['uses' => 'PermissionRolesController@postEdit', 'middleware' => ['acl:'.$prefix.'/permission-roles/edit']]);
			Route::get('permission-roles/delete-data/{id}',  ['as'=>'permission_roles_delete', 'uses' => 'PermissionRolesController@getDelete', 'middleware' => ['acl:'.$prefix.'/permission-roles/delete-data/{id}'], function ($id) {}]);

			//WEBSITE BRAND
			Route::get('website-brand/index',  ['as' => 'website_brand_index','uses' => 'WebsiteBrandController@getIndex', 'middleware' => ['acl:'.$prefix.'/website-brand/index']]);
			Route::post('website-brand/index',  ['uses' => 'WebsiteBrandController@postIndex', 'middleware' => ['acl:'.$prefix.'/website-brand/index']]);
			Route::post('website-brand/upload',  ['uses' => 'WebsiteBrandController@postUpload', 'middleware' => ['acl:'.$prefix.'/website-brand/upload']]);

			Route::get('articles',  ['as' => 'articles_index','uses' => 'ArticlesController@getIndex', 'middleware' => ['acl:'.$prefix.'/articles']]);
			Route::get('articles/add',  ['as' => 'articles_add','uses' => 'ArticlesController@getAdd', 'middleware' => ['acl:'.$prefix.'/articles/add']]);
			Route::post('articles/add',  ['uses' => 'ArticlesController@postAdd', 'middleware' => ['acl:'.$prefix.'/articles/add']]);
			Route::get('articles/edit/{id}',  ['as' => 'articles_edit','uses' => 'ArticlesController@getEdit', 'middleware' => ['acl:'.$prefix.'/articles/edit'], function ($id) {}]);
			Route::post('articles/edit',  ['uses' => 'ArticlesController@postEdit', 'middleware' => ['acl:'.$prefix.'/articles/edit']]);
			Route::get('articles/remove/{id}',  ['uses' => 'ArticlesController@getRemove', 'middleware' => ['acl:'.$prefix.'/articles/remove'], function ($id) {}]);
			
			Route::get('videos',  ['as' => 'videos_index','uses' => 'VideosController@getIndex', 'middleware' => ['acl:'.$prefix.'/videos']]);
			Route::get('videos/add',  ['as' => 'videos_add','uses' => 'VideosController@getAdd', 'middleware' => ['acl:'.$prefix.'/videos/add']]);
			Route::post('videos/add',  ['uses' => 'VideosController@postAdd', 'middleware' => ['acl:'.$prefix.'/videos/add']]);
			Route::get('videos/edit/{id}',  ['as' => 'videos_edit','uses' => 'VideosController@getEdit', 'middleware' => ['acl:'.$prefix.'/videos/edit'], function ($id) {}]);
			Route::post('videos/edit',  ['uses' => 'VideosController@postEdit', 'middleware' => ['acl:'.$prefix.'/videos/edit']]);
			Route::get('videos/remove/{id}',  ['uses' => 'VideosController@getRemove', 'middleware' => ['acl:'.$prefix.'/videos/remove'], function ($id) {}]);

			Route::get('users/index',  ['as' => 'users_index','uses' => 'AdminsController@getUsersIndex', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
			Route::get('users/add',  ['as' => 'users_add','uses' => 'AdminsController@getUsersAdd', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
			Route::post('users/add',  ['uses' => 'AdminsController@postUsersAdd', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
			Route::get('users/edit/{id}',  ['as' => 'users_edit','uses' => 'AdminsController@getUsersEdit', 'middleware' => ['acl:'.$prefix.'/acl/view'], function ($id) {}]);
			Route::post('users/edit',  ['uses' => 'AdminsController@postUsersEdit', 'middleware' => ['acl:'.$prefix.'/acl/view']]);

		});
	});



	//PERMISSIONS ROUTE
	Route::group(['prefix' => 'permissions'], function () {
		Route::get('auto-update', ['uses'=>'PermissionsController@getAutoUpdate']);
	});
	Route::post('inventories/inv-liked',  ['uses' => 'InventoriesController@postItemLiked']);
	Route::post('inventories/like-removed',  ['uses' => 'InventoriesController@postLikeRemoved']);
	//ITEMS
	Route::get('items/{id}', ['as' => 'view_this_item','uses'=>'InventoriesController@getViewItem']);
	//CHECKOUT
	Route::post('invoices/add-to-cart', ['uses'=>'InvoicesController@postAddToCart']);
	Route::get('invoices/reset-cart', ['as' => 'reset-cart', 'uses'=>'InvoicesController@getRestCart']);
	Route::get('invoices/reset-liked', ['as' => 'reset-liked', 'uses'=>'InvoicesController@getRestLiked']);
	Route::get('invoices/delete-item-cart/{id}', ['as' => 'delete-item-cart', 'uses'=>'InvoicesController@getDeleteItemCart']);
	Route::get('invoices/delete-item-liked/{id}', ['as' => 'delete-item-liked', 'uses'=>'InvoicesController@getDeleteItemLiked']);
	Route::get('invoices/checkout', ['as'=>'invoice_checkout','uses'=>'InvoicesController@getCheckout']);
	Route::post('invoices/checkout/add-to-cart-and-proceed', ['as'=>'add_to_cart_and_payment','uses'=>'InvoicesController@postAddAndProceed']);
	Route::get('invoices/checkout/guest', ['as'=>'invoice_checkout_guest','uses'=>'InvoicesController@getCheckoutAsGuest']);
	Route::get('invoices/checkout/reset-address-guest', ['as'=>'reset-address-guest','uses'=>'InvoicesController@getResetAddressGuest']);
	Route::post('invoices/checkout-confirmation', ['uses'=>'InvoicesController@postCheckoutConfirmation']);
	Route::post('invoices/checkout', ['uses'=>'InvoicesController@postCheckout']);

	Route::get('invoices/user-login/{id}', ['as'=>'invoice_user_login','uses'=>'InvoicesController@getUserLoginPage']);
	
	//PAGES
	Route::get('/{param1}','PagesController@getPage');

	//HOME ROUTE
	Route::get('/', ['as'=>'home_index', 'uses' => 'HomeController@getHomepage']);
	Route::get('/{prefered_layout}/{id}', ['as'=>'set_layout', 'uses' => 'HomeController@getSetPreferedLayoutSession']);
});