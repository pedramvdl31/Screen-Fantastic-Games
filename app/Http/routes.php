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
	Route::get('/events',  ['as'=>'events', 'uses' => 'HomeController@getEvents']);
	Route::get('/schedule-and-register/ubu-calendar',  ['as'=>'get-calendar', 'uses' => 'HomeController@getCalendar']);
	// WEBSITE PUBLIC PAGES END
	Route::post('/questions-and-answers/ajax-add',  ['uses' => 'QnAController@postAjaxqnaAdd']);
	Route::post('/reviews/ajax-add',  ['uses' => 'ReviewsController@postAjaxReviewAdd']);
	Route::post('/reviews/ajax-edit',  ['uses' => 'ReviewsController@postAjaxReviewEdit']);

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

						//EVENTS
			Route::get('events',  ['as' => 'events_index','uses' => 'EventsController@getIndex', 'middleware' => ['acl:'.$prefix.'/events']]);
			Route::get('events/add',  ['as' => 'events_add','uses' => 'EventsController@getAdd', 'middleware' => ['acl:'.$prefix.'/events/add']]);
			Route::post('events/add',  ['uses' => 'EventsController@postAdd', 'middleware' => ['acl:'.$prefix.'/events/add']]);
			Route::get('events/edit/{id}',  ['as' => 'events_edit','uses' => 'EventsController@getEdit', 'middleware' => ['acl:'.$prefix.'/events/edit'], function ($id) {}]);
			Route::post('events/edit',  ['uses' => 'EventsController@postEdit', 'middleware' => ['acl:'.$prefix.'/events/edit']]);
			Route::post('events/remove',  ['uses' => 'EventsController@postRemove', 'middleware' => ['acl:'.$prefix.'/events/remove']]);
			Route::get('events/view/{id}',  ['as' => 'events_view','uses' => 'EventsController@getView', 'middleware' => ['acl:'.$prefix.'/events/view'], function ($id) {}]);
			Route::post('events/view',  ['uses' => 'EventsController@postView', 'middleware' => ['acl:'.$prefix.'/events/view']]);
			Route::get('events/remove/{id}',  ['as' => 'events_remove','uses' => 'EventsController@getRemove', 'middleware' => ['acl:'.$prefix.'/events/remove'], function ($id) {}]);

			
			Route::get('flags',  ['as'=>'flags_index', 'uses' => 'FlagsController@getIndex', 'middleware' => ['acl:'.$prefix.'/flags']]);
			Route::get('flags/view/{id}',  ['as'=>'flag_view', 'uses' => 'FlagsController@getView', 'middleware' => ['acl:'.$prefix.'/flags/view/{id}'], function ($id) {}]);
			Route::post('flags/view',  ['uses' => 'FlagsController@postView', 'middleware' => ['acl:'.$prefix.'/flags/view']]);
			Route::get('flags/approved',  ['as'=>'flags_app', 'uses' => 'FlagsController@getApproved', 'middleware' => ['acl:'.$prefix.'/flags/approved']]);
			Route::get('flags/rejected',  ['as'=>'flags_rej', 'uses' => 'FlagsController@getRejected', 'middleware' => ['acl:'.$prefix.'/flags/rejected']]);
			Route::get('flags/re-flagged',  ['as'=>'flags_re', 'uses' => 'FlagsController@getReflagged', 'middleware' => ['acl:'.$prefix.'/flags/re-flagged']]);
			Route::get('flags/final-approved',  ['as'=>'flags_f_app', 'uses' => 'FlagsController@getFinalApproved', 'middleware' => ['acl:'.$prefix.'/flags/final-approved']]);
			Route::get('flags/final-reject',  ['as'=>'flags_f_rej', 'uses' => 'FlagsController@getFinalRejected', 'middleware' => ['acl:'.$prefix.'/flags/final-reject']]);
			Route::get('flags/banned',  ['as'=>'flags_banned', 'uses' => 'FlagsController@getBanned', 'middleware' => ['acl:'.$prefix.'/flags/banned']]);

			Route::get('acl/view',  ['as' => 'acl_view','uses' => 'AdminsController@getViewAcl', 'middleware' => ['acl:'.$prefix.'/acl/view']]);
			Route::get('categories/index',  ['as'=>'category_index', 'uses' => 'CategoriesController@getIndex', 'middleware' => ['acl:'.$prefix.'/categories/index']]);
			Route::get('categories/add',  ['as'=>'category_add', 'uses' => 'CategoriesController@getAdd', 'middleware' => ['acl:'.$prefix.'/categories/add']]);
			Route::post('categories/add',  ['uses' => 'CategoriesController@postAdd', 'middleware' => ['acl:'.$prefix.'/categories/add']]);
			
			Route::get('categories/view/{id}',  ['as' => 'category_view','uses' => 'CategoriesController@getView', 'middleware' => ['acl:'.$prefix.'/categories/view'], function ($id) {}]);
			
			Route::get('categories/edit/{id}',  ['as'=>'category_edit','uses' => 'CategoriesController@getEdit', 'middleware' => ['acl:'.$prefix.'/categories/edit'], function ($id) {}]);
			Route::post('categories/edit',  ['uses' => 'CategoriesController@postEdit', 'middleware' => ['acl:'.$prefix.'/categories/edit']]);
			
			Route::get('inventories/index',  ['as'=>'inventory_index', 'uses' => 'InventoriesController@getIndex', 'middleware' => ['acl:'.$prefix.'/inventories/index']]);
			Route::get('inventories/order',  ['as'=>'inventory_order', 'uses' => 'InventoriesController@getOrder', 'middleware' => ['acl:'.$prefix.'/inventories/order']]);
			Route::post('inventories/order',  ['uses' => 'InventoriesController@postOrder', 'middleware' => ['acl:'.$prefix.'/inventories/order']]);
			Route::get('inventories/add',  ['as'=>'inventory_add', 'uses' => 'InventoriesController@getAdd', 'middleware' => ['acl:'.$prefix.'/inventories/add']]);
			Route::post('inventories/add',  ['uses' => 'InventoriesController@postAdd', 'middleware' => ['acl:'.$prefix.'/inventories/add']]);
			Route::get('inventories/view/{id}',  ['as' => 'inventory_view','uses' => 'InventoriesController@getView', 'middleware' => ['acl:'.$prefix.'/inventories/view'], function ($id) {}]);
			Route::get('inventories/edit/{id}',  ['as'=>'inventory_edit','uses' => 'InventoriesController@getEdit', 'middleware' => ['acl:'.$prefix.'/inventories/edit'], function ($id) {}]);
			Route::post('inventories/upload',  ['uses' => 'InventoriesController@postUpload', 'middleware' => ['acl:'.$prefix.'/inventories/upload']]);
			Route::post('inventories/return-item',  ['uses' => 'InventoriesController@postReturnItem', 'middleware' => ['acl:'.$prefix.'/inventories/return-item']]);
			Route::post('inventories/item-selected',  ['uses' => 'InventoriesController@postItemSelected', 'middleware' => ['acl:'.$prefix.'/inventories/item-selected']]);
			Route::post('inventories/view-all-items',  ['uses' => 'InventoriesController@postViewAllItems', 'middleware' => ['acl:'.$prefix.'/inventories/view-all-items']]);
			Route::post('inventories/item-removed',  ['uses' => 'InventoriesController@postItemRemoved', 'middleware' => ['acl:'.$prefix.'/inventories/item-removed']]);
			Route::post('inventories/edit',  ['uses' => 'InventoriesController@postEdit', 'middleware' => ['acl:'.$prefix.'/inventories/edit']]);
			Route::post('inventories/delete',  ['uses' => 'InventoriesController@postDelete', 'middleware' => ['acl:'.$prefix.'/inventories/delete']]);
			
			Route::get('invoices/index',  ['as'=>'invoice_index', 'uses' => 'InvoicesController@getIndex', 'middleware' => ['acl:'.$prefix.'/invoices/index']]);
			Route::get('invoices/add',  ['as'=>'invoice_add', 'uses' => 'InvoicesController@getAdd', 'middleware' => ['acl:'.$prefix.'/invoices/add']]);
			Route::post('invoices/add',  ['uses' => 'InvoicesController@postAdd', 'middleware' => ['acl:'.$prefix.'/invoices/add']]);
			Route::post('invoices/admin-checkout',  ['uses' => 'InvoicesController@postAdminCheckout', 'middleware' => ['acl:'.$prefix.'/invoices/admin-checkout']]);
			Route::post('invoices/admin-checkout-confirmation',  ['uses' => 'InvoicesController@postAdminCheckoutConfirmation', 'middleware' => ['acl:'.$prefix.'/invoices/admin-checkout-confirmation']]);
			Route::get('invoices/view/{id}',  ['as' => 'invoice_view','uses' => 'InvoicesController@getView', 'middleware' => ['acl:'.$prefix.'/invoices/view'], function ($id) {}]);
			Route::get('invoices/edit/{id}',  ['as'=>'invoice_edit','uses' => 'InvoicesController@getEdit', 'middleware' => ['acl:'.$prefix.'/invoices/edit'], function ($id) {}]);
			Route::get('invoices/view-receipt',  ['as'=>'invoice_view_receipt','uses' => 'InvoicesController@getViewReceipt', 'middleware' => ['acl:'.$prefix.'/invoices/view-receipt']]);
			Route::post('invoices/upload',  ['uses' => 'InvoicesController@postUpload', 'middleware' => ['acl:'.$prefix.'/invoices/upload']]);
			Route::post('invoices/edit',  ['uses' => 'InvoicesController@postEdit', 'middleware' => ['acl:'.$prefix.'/invoices/edit']]);
			Route::post('invoices/delete',  ['uses' => 'InvoicesController@postDelete', 'middleware' => ['acl:'.$prefix.'/invoices/delete']]);

			//LAYOUTS
			Route::get('layouts',  ['as' => 'layouts_index','uses' => 'LayoutsController@getIndex', 'middleware' => ['acl:'.$prefix.'/layouts']]);
			Route::get('layouts/add',  ['as' => 'layouts_add','uses' => 'LayoutsController@getAdd', 'middleware' => ['acl:'.$prefix.'/layouts/add']]);
			Route::post('layouts/add',  ['uses' => 'LayoutsController@postAdd', 'middleware' => ['acl:'.$prefix.'/layouts/add']]);
			Route::get('layouts/edit/{id}',  ['as' => 'layouts_edit','uses' => 'LayoutsController@getEdit', 'middleware' => ['acl:'.$prefix.'/layouts/edit'], function ($id) {}]);
			Route::post('layouts/edit',  ['uses' => 'LayoutsController@postEdit', 'middleware' => ['acl:'.$prefix.'/layouts/edit']]);
			Route::post('layouts/remove',  ['uses' => 'LayoutsController@postRemove', 'middleware' => ['acl:'.$prefix.'/layouts/remove']]);
			Route::get('layouts/view/{id}',  ['as' => 'layouts_view','uses' => 'LayoutsController@getView', 'middleware' => ['acl:'.$prefix.'/layouts/view'], function ($id) {}]);
			Route::post('layouts/view',  ['uses' => 'LayoutsController@postView', 'middleware' => ['acl:'.$prefix.'/layouts/view']]);
			Route::get('layouts/remove/{id}',  ['uses' => 'LayoutsController@getRemove', 'middleware' => ['acl:'.$prefix.'/layouts/remove'], function ($id) {}]);

			//PAGES
			Route::get('pages',  ['as' => 'pages_index','uses' => 'PagesController@getIndex', 'middleware' => ['acl:'.$prefix.'/pages']]);
			Route::get('pages/sliders-index',  ['as' => 'sliders_index','uses' => 'PagesController@getSlidersIndex', 'middleware' => ['acl:'.$prefix.'/pages/sliders-index']]);
			Route::get('pages/sliders-add',  ['as' => 'sliders_add','uses' => 'PagesController@getSlidersAdd', 'middleware' => ['acl:'.$prefix.'/pages/sliders-add']]);
			Route::post('pages/sliders-add',  ['uses' => 'PagesController@postSlidersAdd', 'middleware' => ['acl:'.$prefix.'/pages/sliders-add']]);
			Route::get('pages/sliders-edit/{id}',  ['as' => 'sliders_edit','uses' => 'PagesController@getSlidersEdit', 'middleware' => ['acl:'.$prefix.'/pages/sliders-edit'], function ($id) {}]);
			Route::post('pages/sliders-edit',  ['uses' => 'PagesController@postSlidersEdit', 'middleware' => ['acl:'.$prefix.'/pages/sliders-edit']]);
			Route::get('pages/add',  ['as' => 'pages_add','uses' => 'PagesController@getAdd', 'middleware' => ['acl:'.$prefix.'/pages/add']]);
			Route::post('pages/preview',  ['uses' => 'PagesController@postAddPreviewStep', 'middleware' => ['acl:'.$prefix.'/pages/preview']]);
			Route::post('pages/preview2',  ['uses' => 'PagesController@postAddPreviewStep2', 'middleware' => ['acl:'.$prefix.'/pages/preview2']]);
			Route::post('pages/edit-preview',  ['uses' => 'PagesController@postEditPreviewStep', 'middleware' => ['acl:'.$prefix.'/pages/edit-preview']]);
			Route::post('pages/sort',  ['uses' => 'PagesController@postAddSortStep', 'middleware' => ['acl:'.$prefix.'/pages/sort']]);
			Route::post('pages/data',  ['uses' => 'PagesController@postAddDataStep', 'middleware' => ['acl:'.$prefix.'/pages/data']]);
			Route::post('pages/add',  ['uses' => 'PagesController@postAdd', 'middleware' => ['acl:'.$prefix.'/pages/add']]);
			Route::post('pages/add-data',  ['uses' => 'PagesController@postAddData', 'middleware' => ['acl:'.$prefix.'/pages/add-data']]);
			Route::post('pages/data-edit',  ['uses' => 'PagesController@postEditDataStep', 'middleware' => ['acl:'.$prefix.'/pages/data-edit']]);
			Route::post('pages/add-section',  ['uses' => 'PagesController@postAddSection', 'middleware' => ['acl:'.$prefix.'/pages/add-section']]);
			Route::post('pages/add-section-edit',  ['uses' => 'PagesController@postAddSectionEdit', 'middleware' => ['acl:'.$prefix.'/pages/add-section-edit']]);
			Route::get('pages/edit/{id}',  ['as' => 'pages_edit','uses' => 'PagesController@getEdit', 'middleware' => ['acl:'.$prefix.'/pages/edit'], function ($id) {}]);
			Route::post('pages/edit',  ['uses' => 'PagesController@postEdit', 'middleware' => ['acl:'.$prefix.'/pages/edit']]);
			Route::post('pages/remove',  ['uses' => 'PagesController@postRemove', 'middleware' => ['acl:'.$prefix.'/pages/remove']]);
			Route::get('pages/remove/{id}',  ['as' => 'pages_remove','uses' => 'PagesController@getRemove', 'middleware' => ['acl:'.$prefix.'/pages/remove'], function ($id) {}]);
			Route::post('pages/sliders/upload',  ['uses' => 'PagesController@postUploadSlider', 'middleware' => ['acl:'.$prefix.'/pages/sliders/upload']]);
			Route::post('pages/pages-slider/upload',  ['uses' => 'PagesController@postUploadPagesSliderImage', 'middleware' => ['acl:'.$prefix.'/pages/pages-slider/upload']]);
			Route::post('pages/pages-image/upload',  ['uses' => 'PagesController@postUploadPagesImageSingle', 'middleware' => ['acl:'.$prefix.'/pages/pages-image/upload']]);
			Route::get('pages/view/{id}',  ['as' => 'pages_view','uses' => 'PagesController@getView', 'middleware' => ['acl:'.$prefix.'/pages/view'], function ($id) {}]);
			Route::post('pages/view',  ['uses' => 'PagesController@postView', 'middleware' => ['acl:'.$prefix.'/pages/view']]);
			
			Route::get('sales',  ['as' => 'sales_index','uses' => 'InvoicesController@getSalesIndex', 'middleware' => ['acl:'.$prefix.'/sales']]);
			Route::get('sales/add',  ['as' => 'sales_add','uses' => 'InvoicesController@getSalesAdd', 'middleware' => ['acl:'.$prefix.'/sales/add']]);
			Route::post('sales/add',  ['uses' => 'InvoicesController@postSalesAdd', 'middleware' => ['acl:'.$prefix.'/sales/add']]);
			Route::get('sales/edit/{id}',  ['as' => 'sales_edit','uses' => 'InvoicesController@getSalesEdit', 'middleware' => ['acl:'.$prefix.'/sales/edit'], function ($id) {}]);
			Route::post('sales/edit',  ['uses' => 'InvoicesController@postSalesEdit', 'middleware' => ['acl:'.$prefix.'/sales/edit']]);


			Route::get('tags',  ['as' => 'tags_index','uses' => 'TagsController@getIndex', 'middleware' => ['acl:'.$prefix.'/tags']]);
			Route::get('tags/add',  ['as' => 'tags_add','uses' => 'TagsController@getAdd', 'middleware' => ['acl:'.$prefix.'/tags/add']]);
			Route::post('tags/add',  ['uses' => 'TagsController@postAdd', 'middleware' => ['acl:'.$prefix.'/tags/add']]);
			Route::get('tags/edit/{id}',  ['as' => 'tags_edit','uses' => 'TagsController@getEdit', 'middleware' => ['acl:'.$prefix.'/tags/edit'], function ($id) {}]);
			Route::post('tags/edit',  ['uses' => 'TagsController@postEdit', 'middleware' => ['acl:'.$prefix.'/tags/edit']]);
			Route::get('tags/remove/{id}',  ['uses' => 'TagsController@getRemove', 'middleware' => ['acl:'.$prefix.'/tags/remove'], function ($id) {}]);
			
			Route::get('taxes',  ['as' => 'taxes_index','uses' => 'TaxesController@getIndex', 'middleware' => ['acl:'.$prefix.'/taxes']]);
			Route::get('taxes/add',  ['as' => 'taxes_add','uses' => 'TaxesController@getAdd', 'middleware' => ['acl:'.$prefix.'/taxes/add']]);
			Route::post('taxes/add',  ['uses' => 'TaxesController@postAdd', 'middleware' => ['acl:'.$prefix.'/taxes/add']]);
			Route::get('taxes/edit/{id}',  ['as' => 'taxes_edit','uses' => 'TaxesController@getEdit', 'middleware' => ['acl:'.$prefix.'/taxes/edit'], function ($id) {}]);
			Route::post('taxes/edit',  ['uses' => 'TaxesController@postEdit', 'middleware' => ['acl:'.$prefix.'/taxes/edit']]);
			Route::post('taxes/remove',  ['uses' => 'TaxesController@postRemove', 'middleware' => ['acl:'.$prefix.'/taxes/remove']]);
			Route::get('taxes/view/{id}',  ['as' => 'taxes_view','uses' => 'TaxesController@getView', 'middleware' => ['acl:'.$prefix.'/taxes/view'], function ($id) {}]);
			Route::post('taxes/view',  ['uses' => 'TaxesController@postView', 'middleware' => ['acl:'.$prefix.'/taxes/view']]);

			Route::get('questions-and-answers',  ['as' => 'qna_index','uses' => 'QnAController@getIndex', 'middleware' => ['acl:'.$prefix.'/questions-and-answers']]);

			Route::get('questions-and-answers/view/{id}',  ['as' => 'qna_view','uses' => 'QnAController@getView', 'middleware' => ['acl:'.$prefix.'/questions-and-answers/view'], function ($id) {}]);
			Route::post('questions-and-answers/view',  ['uses' => 'QnAController@postView', 'middleware' => ['acl:'.$prefix.'/questions-and-answers/view']]);

			Route::get('reviews',  ['as' => 'review_index','uses' => 'ReviewsController@getIndex', 'middleware' => ['acl:'.$prefix.'/reviews']]);

			Route::get('reviews/view/{id}',  ['as' => 'review_view','uses' => 'ReviewsController@getView', 'middleware' => ['acl:'.$prefix.'/reviews/view'], function ($id) {}]);
			Route::post('reviews/view',  ['uses' => 'ReviewsController@postView', 'middleware' => ['acl:'.$prefix.'/reviews/view']]);
			Route::post('reviews/delete-review',  ['uses' => 'ReviewsController@postDeleteReview', 'middleware' => ['acl:'.$prefix.'/reviews/delete-review']]);

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