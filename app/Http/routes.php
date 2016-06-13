<?php
#Region Non-localized Routes
Route::get('auth/auto-login-id/{id}', 'Auth\AuthController@getAutoLogin');
//Home
Route::get('/', 'Pages\HomeController@index');
Route::get('/tin-tuc', 'Pages\BlogController@listBlog');

#Endregion Non-localized Routes




//==============================================
#Region API Routes
Route::group(['prefix' => 'api/v1','middleware' => 'apiForceLocalizing'], function () {
    ##region Anonymous Routes
    Route::get('user/badge', 'APIV1\UserController@getBadge');
    Route::get('user-current-auth', 'APIV1\UserController@getUserCurrentAuth');
    Route::get('supporters', 'APIV1\SupporterController@jsonList');
    Route::post('realtime/send/light/lr-conversation', 'APIV1\LightRealtimeController@sendLRConversation');
    Route::post('realtime/send/light/sp-conversation/visitor', 'APIV1\LightRealtimeController@sendSPConversationFromVisitor');
    Route::post('upload/recordmp3js', 'APIV1\JsRecordMp3Controller@upload');
    ##endregion Anonymous Routes

    ##region API Login/Register 
    Route::post('login-user', 'Auth\AuthApiController@postLoginApi');
    Route::post('login-user-social', 'Auth\AuthApiController@postLoginSocialApi');
    Route::post('register-user', 'Auth\AuthApiController@postRegisterApi');
    Route::post('send-mail-welcome', 'Auth\AuthApiController@postSendMailWelcomeApi');
    Route::post('send-mail-forget-pass', 'Auth\PasswordController@postEmailApi');
    ##endregion API Login/Register 

    ##region User Routes
    Route::group(['middleware' => 'auth'], function () {
        Route::post('upload/closify', 'APIV1\ClosifyController@upload');
        Route::post('upload/js-cropper/profile-picture', 'APIV1\JsCropperController@updateUserProfilePicture');
        Route::get('notification/for-full', 'APIV1\NotificationController@jsonListForFull');

        ###region Admin Permisstion
        Route::group(['middleware' => 'entrust:,access-admin'], function () {
            ####region Admin Role
            Route::group(['middleware' => 'entrust:admin'], function () {
                Route::post('upload/js-cropper/profile-picture/cms/{id}', 'APIV1\JsCropperController@updateUserProfilePicture');
                Route::post('widgets/updateOrder', 'APIV1\WidgetController@updateOrder');
                Route::post('link/items/updateOrder', 'APIV1\LinkItemController@updateOrder');
            });
            ####endregion Admin Role
        });
        ###endregion Admin Permisstion

        ###region Supporter Role
        Route::group(['middleware' => 'entrust:supporter'], function () {
            Route::get('support-channels', 'APIV1\SupportChannelController@jsonList');
            Route::post('realtime/send/light/sp-conversation/supporter', 'APIV1\LightRealtimeController@sendSPConversationFromSupporter');
        });
        ###endregion Supporter Role
    });
    ##endregion User Routes
});
#EndregionAPI Routes

//============================================================
#Region Localized Routes
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => ['forceLocalizing', 'localize', 'localeSessionRedirect', 'localizationRedirect']], function () {
    ##region  Authentication Routes
    Route::get(translatedPath('auth/login'), 'Auth\AuthController@getLogin');
    Route::post(translatedPath('auth/login'), 'Auth\AuthController@postLogin');
    Route::get(translatedPath('auth/logout'), 'Auth\AuthController@getLogout');
    Route::get(translatedPath('auth/register'), 'Auth\AuthController@getRegister');
    Route::post(translatedPath('auth/register'), 'Auth\AuthController@postRegister');
    Route::get(translatedPath('auth/register/social'), 'Auth\AuthController@getSocialRegister');
    Route::post(translatedPath('auth/register/social'), 'Auth\AuthController@postSocialRegister');
    // activation
    Route::get(translatedPath('auth/inactive'), 'Auth\AuthController@getInactive');
    Route::post(translatedPath('auth/inactive'), 'Auth\AuthController@postInactive');
    Route::get(translatedPath('auth/is-activate/{user_id}'), 'Auth\AuthController@getIsActivation');
    Route::get(translatedPath('verify/{id}/{activation_code}'), 'Admin\UserController@getActivation')
    ->where('id', '[0-9]+');
    Route::get(translatedPath('auth/social/{provider}'), 'Auth\AuthController@redirectToProvider');
    Route::get(translatedPath('auth/social/callback/{provider}'), 'Auth\AuthController@handleProviderCallback');
    Route::get(translatedPath('password/email'), 'Auth\PasswordController@getEmail');
    Route::post(translatedPath('password/email'), 'Auth\PasswordController@postEmail');
    Route::get(translatedPath('password/reset/{token}'), 'Auth\PasswordController@getReset');
    Route::post(translatedPath('password/reset'), 'Auth\PasswordController@postReset');
    ##endregion Authentication Routes

    ##region Anonymous Routes
    Route::get(translatedPath('localization-settings'), 'Pages\HomeController@getLocalizationSetting');
    Route::post(translatedPath('localization-settings'), 'Pages\HomeController@postLocalizationSetting');
    Route::match(['get', 'post'], translatedPath('supporter/{id?}'), 'Pages\SupporterController@layoutContactSupporters')
    ->where('id', '[0-9]+');
    Route::get(translatedPath('user/{id?}'), 'Pages\UserController@layoutSingle')
    ->where('id', '[0-9]+');
    ##region Anonymous Routes

    ##region Blog
    Route::get(translatedPath('blog'), 'Pages\BlogController@index');
    Route::get(translatedPath('blog/{slug}-{id}'), 'Pages\BlogController@viewSingle');
    Route::post(translatedPath('blog/subscribe'), 'Pages\BlogController@subscribeEmail');

    Route::get(translatedPath('blog/view/{slug}-{id}'), 'Pages\BlogController@viewSingle');
    Route::get(translatedPath('blog/category/{id}'), 'Pages\BlogController@indexByCategory')
    ->where('id', '[0-9]+');
    Route::get(translatedPath('blog/category/view/{slug}-{id}'), 'Pages\BlogController@viewByCategory');
    Route::get(translatedPath('blog/author/{id}'), 'Pages\BlogController@indexByAuthor')
    ->where('id', '[0-9]+');
    Route::get(translatedPath('blog/author/view/{slug}'), 'Pages\BlogController@viewByAuthor');

    Route::get(translatedPath('faq/{id?}'), 'Pages\FaqController@layoutCompound')
    ->where('id', '[0-9]+');
    Route::get(translatedPath('faq/terms-of-service'), 'Pages\FaqController@viewPolicy');
    Route::get(translatedPath('faq/privacy-policy'), 'Pages\FaqController@viewService');
    Route::get(translatedPath('faq/view/{slug?}-{id}'), 'Pages\FaqController@viewCompound');
    Route::get(translatedPath('faq/view/tmp/{slug}'), 'Pages\FaqController@viewTmp');
    ##endregion Blog

    ##region All User Auth
    Route::group(['middleware' => 'auth'], function () {
        //Profile
        Route::get(translatedPath('profile'), 'Pages\ProfileController@profile');
        // document
        Route::any(translatedPath('documents/connector'), 'DocumentController@getConnector');
        Route::any(translatedPath('documents/for/ckeditor'), 'DocumentController@forCkeditor');
        Route::any(translatedPath('documents/for/popup/{input_id}'), 'DocumentController@forPopup');
        // pages
        Route::get(translatedPath('notification'), 'Pages\NotificationController@index');
        Route::get(translatedPath('notification/confirm/{id}'), 'Pages\NotificationController@confirm')
        ->where('id', '[0-9]+');
        // user
        Route::get(translatedPath('user/dashboard'), 'Pages\UserController@layoutDashboard');
        Route::get(translatedPath('user/edit'), 'Pages\UserController@edit');
        Route::post(translatedPath('user/update'), 'Pages\UserController@update');
        Route::get(translatedPath('user/documents'), 'Pages\UserController@layoutDocuments');

        ###region Compose Blog Articles Permission
        Route::group(['middleware' => 'entrust:,compose-blog-articles'], function () {
            Route::get(translatedPath('blog/{id}/delete'), 'Pages\BlogController@destroy')
            ->where('id', '[0-9]+');
        });
        ###endregion Compose Blog Articles Permission

        ###region Supporter Role
        Route::group(['middleware' => 'entrust:supporter'], function () {
            Route::get(translatedPath('support-channel/{id?}'), 'Pages\SupporterController@layoutSupportChannels')
            ->where('id', '[0-9]+');
        });
        ###endregion Supporter Role

        ###region Access Admin Permission
        Route::group(['middleware' => 'entrust:,access-admin'], function () {
            Route::get(translatedPath('admin'), 'Admin\DashboardController@index');
            Route::get(translatedAdminPath('my-documents'), 'Admin\DocumentController@index');

            ####region learning-editor Role
            Route::group(['middleware' => 'entrust:learning-editor'], function () {
                //Email_subscribe
                Route::get(translatedAdminPath('subscribe'), 'Admin\EmailSubcribeController@index');
            });
            ####endregion learning-editor Role

            ####region blog-editor Role
            Route::group(['middleware' => 'entrust:blog-editor'], function () {
                //Blog Category
                Route::get(translatedAdminPath('blog/categories'), 'Admin\BlogCategoryController@index');
                Route::get(translatedAdminPath('blog/categories/add'), 'Admin\BlogCategoryController@create');
                Route::post(translatedAdminPath('blog/categories/add'), 'Admin\BlogCategoryController@store');
                Route::get(translatedAdminPath('blog/categories/{id}/edit'), 'Admin\BlogCategoryController@edit')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('blog/categories/update'), 'Admin\BlogCategoryController@update');
                Route::get(translatedAdminPath('blog/categories/{id}/delete'), 'Admin\BlogCategoryController@destroy')
                ->where('id', '[0-9]+');
                //Blog Article
                Route::get(translatedAdminPath('blog/articles'), 'Admin\BlogArticleController@index');
                Route::get(translatedAdminPath('blog/articles/add'), 'Admin\BlogArticleController@create');
                Route::post(translatedAdminPath('blog/articles/add'), 'Admin\BlogArticleController@store');
                Route::get(translatedAdminPath('blog/articles/{id}/delete'), 'Admin\BlogArticleController@destroy')
                ->where('id', '[0-9]+');
                Route::get(translatedAdminPath('blog/articles/{id}/edit'), 'Admin\BlogArticleController@edit')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('blog/articles/update'), 'Admin\BlogArticleController@update');
            });
            ####endregion blog-editor Role

            ####region Admin Role
            Route::group(['middleware' => 'entrust:admin'], function () {
                //App Options
                Route::get(translatedAdminPath('app-options'), 'Admin\AppOptionController@index');
                Route::get(translatedAdminPath('app-options/homepage'), 'Admin\AppOptionController@editHomepage');
                Route::post(translatedAdminPath('app-options/homepage'), 'Admin\AppOptionController@updateHomepage');
                //Extensions
                Route::get(translatedAdminPath('extensions'), 'Admin\ExtensionController@index');
                Route::get(translatedAdminPath('extensions/{name}/edit'), 'Admin\ExtensionController@edit');
                Route::post(translatedAdminPath('extensions/update'), 'Admin\ExtensionController@update');
                Route::get(translatedAdminPath('extensions/{name}/deactivate'), 'Admin\ExtensionController@deactivate');
                Route::get(translatedAdminPath('extensions/{name}/activate'), 'Admin\ExtensionController@activate');
                //Widgets
                Route::get(translatedAdminPath('widgets'), 'Admin\WidgetController@index');
                Route::post(translatedAdminPath('widgets'), 'Admin\WidgetController@create');
                Route::get(translatedAdminPath('widgets/{id}/edit'), 'Admin\WidgetController@edit')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('widgets/update'), 'Admin\WidgetController@update');
                Route::get(translatedAdminPath('widgets/{id}/deactivate'), 'Admin\WidgetController@deactivate')
                ->where('id', '[0-9]+');
                Route::get(translatedAdminPath('widgets/{id}/activate'), 'Admin\WidgetController@activate')
                ->where('id', '[0-9]+');
                Route::get(translatedAdminPath('widgets/{id}/delete'), 'Admin\WidgetController@destroy')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('widgets/clone'), 'Admin\WidgetController@copyTo')
                ->where('id', '[0-9]+');
                //Langs
                Route::get(translatedAdminPath('ui-lang/php'), 'Admin\UiLangController@editPhp');
                Route::post(translatedAdminPath('ui-lang/php'), 'Admin\UiLangController@updatePhp');
                Route::get(translatedAdminPath('ui-lang/email'), 'Admin\UiLangController@editEmail');
                Route::post(translatedAdminPath('ui-lang/email'), 'Admin\UiLangController@updateEmail');
                //Roles
                Route::get(translatedAdminPath('roles'), 'Admin\RoleController@index');
                //Users
                Route::get(translatedAdminPath('users'), 'Admin\UserController@index');
                Route::get(translatedAdminPath('users/add'), 'Admin\UserController@create');
                Route::post(translatedAdminPath('users/add'), 'Admin\UserController@store');
                Route::get(translatedAdminPath('users/{id}/edit'), 'Admin\UserController@edit')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('users/update'), 'Admin\UserController@update');
                Route::get(translatedAdminPath('users/{id}/delete'), 'Admin\UserController@destroy')
                ->where('id', '[0-9]+');
                //FAQ Category
                Route::get(translatedAdminPath('faq/categories'), 'Admin\FaqCategoryController@index');
                Route::get(translatedAdminPath('faq/categories/add'), 'Admin\FaqCategoryController@create');
                Route::post(translatedAdminPath('faq/categories/add'), 'Admin\FaqCategoryController@store');
                Route::get(translatedAdminPath('faq/categories/{id}/edit'), 'Admin\FaqCategoryController@edit')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('faq/categories/update'), 'Admin\FaqCategoryController@update');
                Route::get(translatedAdminPath('faq/categories/{id}/delete'), 'Admin\FaqCategoryController@destroy')
                ->where('id', '[0-9]+');
                //FAQ Article
                Route::get(translatedAdminPath('faq/articles'), 'Admin\FaqArticleController@index');
                Route::get(translatedAdminPath('faq/articles/add'), 'Admin\FaqArticleController@create');
                Route::post(translatedAdminPath('faq/articles/add'), 'Admin\FaqArticleController@store');
                Route::get(translatedAdminPath('faq/articles/{id}/delete'), 'Admin\FaqArticleController@destroy')
                ->where('id', '[0-9]+');
                Route::get(translatedAdminPath('faq/articles/{id}/edit'), 'Admin\FaqArticleController@edit')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('faq/articles/update'), 'Admin\FaqArticleController@update');
                //Link Categories
                Route::get(translatedAdminPath('link/categories'), 'Admin\LinkCategoryController@index');
                Route::get(translatedAdminPath('link/categories/add'), 'Admin\LinkCategoryController@create');
                Route::post(translatedAdminPath('link/categories/add'), 'Admin\LinkCategoryController@store');
                Route::get(translatedAdminPath('link/categories/{id}/edit'), 'Admin\LinkCategoryController@edit')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('link/categories/update'), 'Admin\LinkCategoryController@update');
                Route::get(translatedAdminPath('link/categories/{id}/delete'), 'Admin\LinkCategoryController@destroy')
                ->where('id', '[0-9]+');
                Route::get(translatedAdminPath('link/categories/{id}/sort'), 'Admin\LinkCategoryController@layoutSort')
                ->where('id', '[0-9]+');
                //Link Items
                Route::get(translatedAdminPath('link/items'), 'Admin\LinkItemController@index');
                Route::get(translatedAdminPath('link/items/{id}/delete'), 'Admin\LinkItemController@destroy')
                ->where('id', '[0-9]+');
                Route::get(translatedAdminPath('link/items/add'), 'Admin\LinkItemController@create');
                Route::post(translatedAdminPath('link/items/add'), 'Admin\LinkItemController@store');
                Route::get(translatedAdminPath('link/items/{id}/edit'), 'Admin\LinkItemController@edit')
                ->where('id', '[0-9]+');
                Route::post(translatedAdminPath('link/items/update'), 'Admin\LinkItemController@update');
                //Category Product Items
                Route::get(translatedAdminPath('category-product'), 'Admin\ProductCategoryController@index');
                Route::get(translatedAdminPath('category-product/add'), 'Admin\ProductCategoryController@create');
                Route::post(translatedAdminPath('category-product/add'), 'Admin\ProductCategoryController@store');
                Route::get(translatedAdminPath('category-product/{id}/edit'), 'Admin\ProductCategoryController@edit');
                Route::post(translatedAdminPath('category-product/update'), 'Admin\ProductCategoryController@update');
                Route::get(translatedAdminPath('category-product/{id}/delete'), 'Admin\ProductCategoryController@destroy');
                //Product Items
                Route::get(translatedAdminPath('product'), 'Admin\ProductController@index');
                Route::get(translatedAdminPath('product/add'), 'Admin\ProductController@create');
                Route::post(translatedAdminPath('product/add'), 'Admin\ProductController@store');
                Route::get(translatedAdminPath('product/{id}/edit'), 'Admin\ProductController@edit');
                Route::post(translatedAdminPath('product/update'), 'Admin\ProductController@update');
                Route::get(translatedAdminPath('product/{id}/delete'), 'Admin\ProductController@destroy');
            });
            ####endregion Admin Role

});
        ###endregion Access Admin Permission
});
    ##endregion All User Auth
});
#Endregion Localized Routes
