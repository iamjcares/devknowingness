<?php

Route::group([], function() {
    /*
      |--------------------------------------------------------------------------
      | Home Page Routes
      |--------------------------------------------------------------------------
     */

    Route::get('/', 'ThemeHomeController@index');

    /*
      |--------------------------------------------------------------------------
      | Course Page Routes
      |--------------------------------------------------------------------------
     */

    Route::get('courses', array('uses' => 'ThemeCourseController@courses', 'as' => 'courses'));
    Route::get('courses/category/{category}', 'ThemeCourseController@category');
    Route::get('courses/tag/{tag}', 'ThemeCourseController@tag');
    Route::get('course/{id}', 'ThemeCourseController@index');

    /*
      |--------------------------------------------------------------------------
      | Post Page Routes
      |--------------------------------------------------------------------------
     */

    Route::get('posts', array('uses' => 'ThemePostController@posts', 'as' => 'posts'));
    Route::get('posts/category/{category}', 'ThemePostController@category');
    Route::get('post/{slug}', 'ThemePostController@index');


    /*
      |--------------------------------------------------------------------------
      | Page Routes
      |--------------------------------------------------------------------------
     */

    Route::get('pages', 'ThemePageController@pages');
    Route::get('page/{slug}', 'ThemePageController@index');


    /*
      |--------------------------------------------------------------------------
      | Search Routes
      |--------------------------------------------------------------------------
     */

    Route::get('search', 'ThemeSearchController@index');


    /*
      |--------------------------------------------------------------------------
      | Auth and Password Reset Routes
      |--------------------------------------------------------------------------
     */

    Route::get('login', 'ThemeAuthController@social_form');
    Route::get('mlogin', 'ThemeAuthController@login_form');
    Route::get('signup', 'ThemeAuthController@signup_form');
    Route::get('social/login/redirect/{provider}', ['uses' => 'ThemeAuthController@redirectToProvider', 'as' => 'social.login'])
            ->where('provider', 'facebook|twitter|google');
    Route::get('social/login/{provider}', 'ThemeAuthController@handleProviderCallback')
            ->where('provider', 'facebook|twitter|google');
    Route::post('login', 'ThemeAuthController@login');
    Route::post('signup', 'ThemeAuthController@signup');

    Route::get('password/reset', array('before' => 'demo', 'uses' => 'ThemeAuthController@password_reset', 'as' => 'password.remind'));
    Route::post('password/reset', array('before' => 'demo', 'uses' => 'ThemeAuthController@password_request', 'as' => 'password.request'));
    Route::get('password/reset/{token}', array('before' => 'demo', 'uses' => 'ThemeAuthController@password_reset_token', 'as' => 'password.reset'));
    Route::post('password/reset/{token}', array('before' => 'demo', 'uses' => 'ThemeAuthController@password_reset_post', 'as' => 'password.update'));
});

Route::group([], function() {

});



Route::group(['middleware' => ['role:user']], function() {
    /*
      |--------------------------------------------------------------------------
      | Favorite Routes
      |--------------------------------------------------------------------------
     */

    Route::post('favorite', 'ThemeFavoriteController@favorite');
    Route::get('favorites', 'ThemeFavoriteController@show_favorites');

    /*
      |--------------------------------------------------------------------------
      | User and User Edit Routes
      |--------------------------------------------------------------------------
     */

    Route::get('user/{username}', 'ThemeUserController@index');
    Route::get('user/{username}/edit', 'ThemeUserController@edit');
    Route::post('user/{username}/update', 'ThemeUserController@update');
    Route::get('user/{username}/cancel', 'ThemeUserController@cancel_account');
    Route::get('user/{username}/resume', 'ThemeUserController@resume_account');
    Route::get('user/{username}/update_cc', 'ThemeUserController@update_cc');
});


Route::get('logout', 'ThemeAuthController@logout');

Route::get('upgrade', 'UpgradeController@upgrade');


/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
    // Admin Dashboard
    Route::get('/', 'AdminController@index');

    // Admin Course Functionality
    Route::get('courses', 'AdminCoursesController@index');
    Route::get('courses/edit/{id}', 'AdminCoursesController@edit');
    Route::post('courses/update', array('before' => 'demo', 'uses' => 'AdminCoursesController@update'));
    Route::get('courses/delete/{id}', array('before' => 'demo', 'uses' => 'AdminCoursesController@destroy'));
    Route::get('courses/create', 'AdminCoursesController@create');
    Route::post('courses/store', array('before' => 'demo', 'uses' => 'AdminCoursesController@store'));
    Route::get('courses/categories', 'AdminCourseCategoriesController@index');
    Route::post('courses/categories/store', array('before' => 'demo', 'uses' => 'AdminCourseCategoriesController@store'));
    Route::post('courses/categories/order', array('before' => 'demo', 'uses' => 'AdminCourseCategoriesController@order'));
    Route::get('courses/categories/edit/{id}', 'AdminCourseCategoriesController@edit');
    Route::post('courses/categories/update', array('before' => 'demo', 'uses' => 'AdminCourseCategoriesController@update'));
    Route::get('courses/categories/delete/{id}', array('before' => 'demo', 'uses' => 'AdminCourseCategoriesController@destroy'));

    Route::get('posts', 'AdminPostController@index');
    Route::get('posts/create', 'AdminPostController@create');
    Route::post('posts/store', array('before' => 'demo', 'uses' => 'AdminPostController@store'));
    Route::get('posts/edit/{id}', 'AdminPostController@edit');
    Route::post('posts/update', array('before' => 'demo', 'uses' => 'AdminPostController@update'));
    Route::get('posts/delete/{id}', array('before' => 'demo', 'uses' => 'AdminPostController@destroy'));
    Route::get('posts/categories', 'AdminPostCategoriesController@index');
    Route::post('posts/categories/store', array('before' => 'demo', 'uses' => 'AdminPostCategoriesController@store'));
    Route::post('posts/categories/order', array('before' => 'demo', 'uses' => 'AdminPostCategoriesController@order'));
    Route::get('posts/categories/edit/{id}', 'AdminPostCategoriesController@edit');
    Route::get('posts/categories/delete/{id}', array('before' => 'demo', 'uses' => 'AdminPostCategoriesController@destroy'));
    Route::post('posts/categories/update', array('before' => 'demo', 'uses' => 'AdminPostCategoriesController@update'));

    Route::get('pages', 'AdminPageController@index');
    Route::get('pages/create', 'AdminPageController@create');
    Route::post('pages/store', array('before' => 'demo', 'uses' => 'AdminPageController@store'));
    Route::get('pages/edit/{id}', 'AdminPageController@edit');
    Route::post('pages/update', array('before' => 'demo', 'uses' => 'AdminPageController@update'));
    Route::get('pages/delete/{id}', array('before' => 'demo', 'uses' => 'AdminPageController@destroy'));


    Route::get('users', 'AdminUsersController@index');
    Route::get('user/create', 'AdminUsersController@create');
    Route::post('user/store', array('before' => 'demo', 'uses' => 'AdminUsersController@store'));
    Route::get('user/edit/{id}', 'AdminUsersController@edit');
    Route::post('user/update', array('before' => 'demo', 'uses' => 'AdminUsersController@update'));
    Route::get('user/delete/{id}', array('before' => 'demo', 'uses' => 'AdminUsersController@destroy'));

    Route::get('roles', 'AdminRolePermissionsController@index');
    Route::post('role/store', 'AdminRolePermissionsController@storeRole');
    Route::get('role/edit/{id}', 'AdminRolePermissionsController@editRole');
    Route::post('role/update', array('before' => 'demo', 'uses' => 'AdminRolePermissionsController@updateRole'));
    Route::get('role/delete/{id}', array('before' => 'demo', 'uses' => 'AdminRolePermissionsController@destroyRole'));

    Route::get('permissions', 'AdminRolePermissionsController@permission');
    Route::post('permission/store', 'AdminRolePermissionsController@storePermission');
    Route::get('permission/edit/{id}', 'AdminRolePermissionsController@editPermission');
    Route::post('permission/update', array('before' => 'demo', 'uses' => 'AdminRolePermissionsController@updatePermission'));
    Route::get('permission/delete/{id}', array('before' => 'demo', 'uses' => 'AdminRolePermissionsController@destroyPermission'));
    Route::get('permission/role', 'AdminRolePermissionsController@permission_role');
    Route::post('permission/role/store', 'AdminRolePermissionsController@savePermission');

    Route::get('menu', 'AdminMenuController@index');
    Route::post('menu/store', array('before' => 'demo', 'uses' => 'AdminMenuController@store'));
    Route::get('menu/edit/{id}', 'AdminMenuController@edit');
    Route::post('menu/update', array('before' => 'demo', 'uses' => 'AdminMenuController@update'));
    Route::post('menu/order', array('before' => 'demo', 'uses' => 'AdminMenuController@order'));
    Route::get('menu/delete/{id}', array('before' => 'demo', 'uses' => 'AdminMenuController@destroy'));

    Route::get('plugins', 'AdminPluginsController@index');

    Route::get('themes', 'AdminThemesController@index');
    Route::get('theme/activate/{slug}', array('before' => 'demo', 'uses' => 'AdminThemesController@activate'));

    Route::get('settings', 'AdminSettingsController@index');
    Route::post('settings', array('before' => 'demo', 'uses' => 'AdminSettingsController@save_settings'));

    Route::get('payment_settings', 'AdminPaymentSettingsController@index');
    Route::post('payment_settings', array('before' => 'demo', 'uses' => 'AdminPaymentSettingsController@save_payment_settings'));

    Route::get('social_settings', 'AdminSocialSettingsController@index');
    Route::post('social_settings', array('before' => 'demo', 'uses' => 'AdminSocialSettingsController@save_social_settings'));

    Route::get('theme_settings_form', 'AdminThemeSettingsController@theme_settings_form');
    Route::get('theme_settings', 'AdminThemeSettingsController@theme_settings');
    Route::post('theme_settings', array('before' => 'demo', 'uses' => 'AdminThemeSettingsController@update_theme_settings'));
});

/*
  |--------------------------------------------------------------------------
  | Payment Webhooks
  |--------------------------------------------------------------------------
 */

Route::post('stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route::group(array('prefix' => 'api/v1'), function()
// {
//     Route::get('/', 'Api\v1\DocumentationController@index');
//     Route::resource('videos', 'Api\v1\VideosController');
// });


