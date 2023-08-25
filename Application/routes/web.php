<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['notInstalled'], 'prefix' => 'admin', 'namespace' => 'Backend'], function () {
    Route::name('admin.')->namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@redirectToLogin')->name('index');
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('login.store');
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset.link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.reset.change');
        Route::post('logout', 'LoginController@logout')->name('logout');
    });
    Route::group(['middleware' => 'admin'], function () {
        Route::name('admin.')->middleware('demo')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('dashboard');            
            Route::get('dashboard/charts/users', 'DashboardController@usersChartData')->middleware('ajax.only');
            Route::get('dashboard/charts/earnings', 'DashboardController@earningsChartData')->middleware('ajax.only');
            Route::get('dashboard/charts/transfers', 'DashboardController@transfersChartData')->middleware('ajax.only');
            Route::name('notifications.')->prefix('notifications')->group(function () {
                Route::get('/', 'NotificationController@index')->name('index');
                Route::get('view/{id}', 'NotificationController@view')->name('view');
                Route::get('readall', 'NotificationController@readAll')->name('readall');
                Route::delete('deleteallread', 'NotificationController@deleteAllRead')->name('deleteallread');
            });

            Route::get('users-export', 'DashboardController@export')->name('export');
			
			Route::get('students', 'StudentsController@index')->name('students');
			
            Route::name('users.')->prefix('users')->group(function () {
                Route::post('{id}/edit/change/avatar', 'UserController@changeAvatar');
                Route::delete('{id}/edit/delete/avatar', 'UserController@deleteAvatar')->name('deleteAvatar');
                Route::get('{id}/edit/logs', 'UserController@logs')->name('logs');
                Route::get('{id}/edit/boat', 'UserController@boat')->name('boat');
                Route::get('{id}/edit/bookings', 'UserController@bookings')->name('bookings');
                Route::get('{id}/edit/logs/get/{log_id}', 'UserController@getLogs')->middleware('ajax.only');
                Route::post('{id}/edit/sentmail', 'UserController@sendMail')->name('sendmail');
                Route::get('logs/{ip}', 'UserController@logsByIp')->name('logsbyip');
            });
            Route::resource('users', 'UserController');
            Route::resource('subscriptions', 'SubscriptionController');
            Route::name('transfers.')->namespace('Transfers')->prefix('transfers')->group(function () {
                Route::name('users.')->prefix('users')->group(function () {
                    Route::get('/', 'UserTransfersController@index')->name('index');
                    Route::get('{unique_id}/edit', 'UserTransfersController@edit')->name('edit');
                    Route::post('{unique_id}', 'UserTransfersController@update')->name('update');
                    Route::delete('{unique_id}', 'UserTransfersController@destroy')->name('destroy');
                    Route::get('{unique_id}/download/{id}', 'UserTransfersController@download')->name('download');
                    Route::delete('{unique_id}/delete/{id}', 'UserTransfersController@deleteFile')->name('deleteFile');
                });
                Route::name('guests.')->prefix('guests')->group(function () {
                    Route::get('/', 'GuestTransferController@index')->name('index');
                    Route::get('{unique_id}/edit', 'GuestTransferController@edit')->name('edit');
                    Route::post('{unique_id}', 'GuestTransferController@update')->name('update');
                    Route::delete('{unique_id}', 'GuestTransferController@destroy')->name('destroy');
                    Route::get('{unique_id}/download/{id}', 'GuestTransferController@download')->name('download');
                    Route::delete('{unique_id}/delete/{id}', 'GuestTransferController@deleteFile')->name('deleteFile');
                });
            });
            Route::resource('transactions', 'TransactionController');
            Route::resource('plans', 'PlanController');
            Route::resource('coupons', 'CouponController');
            Route::get('advertisements', 'AdvertisementController@index')->name('advertisements.index');
            Route::get('advertisements/{id}/edit', 'AdvertisementController@edit')->name('advertisements.edit');
            Route::post('advertisements/{id}', 'AdvertisementController@update')->name('advertisements.update');

            Route::name('categories')->prefix('categories')->group(function () {
                Route::get('getSubCategory', 'CategoryController@getSubCategory')->name('getSubCategory');
            });
            Route::resource('categories', 'CategoryController');
            Route::resource('highlighters', 'HighlightersController');
            Route::resource('sliders', 'SlidersController');
            Route::resource('pushNotification', 'PushNotificationController');
            Route::resource('notificationTemplate', 'NotificationTemplateController');
            Route::resource('announcements', 'AnnouncementsController');
            Route::resource('announcements', 'AnnouncementsController');
            Route::resource('noticeBoard', 'NoticeBoardController');
            Route::resource('knowledgeBase', 'KnowledgeBaseController');
            Route::resource('events', 'EventsController');
            Route::resource('syllabus', 'SyllabusController');
            Route::resource('popup-notice', 'PopupNoticeController');
            Route::resource('academicTimeTable', 'AcademicTimeTableController');
            Route::resource('academicContent', 'AcademicContentController');
            Route::resource('homework', 'AssignmentsController');
            Route::post('get-homework-user', 'AssignmentsController@getIsbUserList')->name('assignments.userlist');
            Route::post('get-all-student', 'AssignmentsController@allStudentList')->name('assignments.allStudentList');
            /*Route::get('academicContent', 'AcademicTimeTableController@academicContentList')->name('academicContentList');
            Route::post('academicContent', 'AcademicTimeTableController@academicContenSave')->name('academicContentSave');*/
            Route::get('changeStatus', 'AcademicTimeTableController@changeStatus');
            Route::resource('services', 'ServicesController');
            Route::resource('cities', 'CitiesController');
            Route::resource('queries', 'QueriesController');
            Route::resource('galleries', 'GalleriesController');
            Route::get('setFeaturedImage', 'GalleriesController@setFeaturedImage')->name('setFeaturedImage');
            Route::resource('amenities', 'AmenitiesController');
            Route::resource('redirection', 'RedirectionController');
            Route::resource('advertisement', 'AdvertisementsController');
            Route::resource('bookings', 'BookingsController');
            Route::resource('splashScreen', 'SplashScreenController');
            Route::resource('busRoute', 'BusRouteController');
            Route::resource('introScreens', 'IntroScreensController');
            Route::resource('complaintType', 'ComplaintTypeController');
            Route::post('getAdminComment', 'ComplaintListController@getAdminComment')->name('getAdminComment');
            Route::post('adminCommentSubmit', 'ComplaintListController@adminCommentSubmit')->name('adminCommentSubmit');
            Route::get('transportqueries', 'ComplaintListController@transportList')->name('transportList');
            Route::get('academicqueries', 'ComplaintListController@academicList')->name('academicList');
            Route::delete('complaintRemove/{id}', 'ComplaintListController@complaintRemove')->name('complaint.complaintRemove');
            Route::post('complaints-query-ajax', 'ComplaintListController@complaintsQueryAjax')->name('complaintsQueryAjax');

            Route::get('leaveApplication', 'LeaveApplicationController@index')->name('leaveReques.index');
            Route::post('leaveStatusUpdate', 'LeaveApplicationController@leaveStatusUpdate')->name('leaveReques.leaveStatusUpdate');
            Route::delete('leaveReques/{id}', 'LeaveApplicationController@destroy')->name('leaveReques.destroy');

            Route::post('sections/sort', 'SectionsController@sort')->name('sections.sort');
            Route::resource('sections', 'SectionsController');
            Route::get('deleteOtherSection', 'SectionsController@deleteOtherSection')->name('deleteOtherSection');
            Route::controller(TimeTablesController::class)->group(function(){
                Route::get('timeTable', 'index');
                Route::post('timeTableAjax', 'ajax');
            });
            Route::get('student-report', 'ReportController@usersReport')->name('studentReport');
            Route::post('student-report-ajax', 'ReportController@usersReportAjax')->name('studentReportAjax');


        });
        Route::prefix('navigation')->namespace('Navigation')->name('admin.')->middleware('demo')->group(function () {
            Route::post('navbarMenu/sort', 'NavbarMenuController@sort')->name('navbarMenu.sort');
            Route::resource('navbarMenu', 'NavbarMenuController');
            Route::post('footerMenu/sort', 'FooterMenuController@sort')->name('footerMenu.sort');
            Route::resource('footerMenu', 'FooterMenuController');
        });
        Route::group(['prefix' => 'blog', 'namespace' => 'Blog', 'middleware' => ['demo', 'disable.blog']], function () {
            /*
            Route::get('categories/slug', 'CategoryController@slug')->name('categories.slug');
            Route::resource('categories', 'CategoryController');
            */
            Route::get('articles/slug', 'ArticleController@slug')->name('articles.slug');
            Route::get('articles/categories/{lang}', 'ArticleController@getCategories')->middleware('ajax.only');
            Route::resource('articles', 'ArticleController');
            Route::get('comments', 'CommentController@index')->name('comments.index');
            Route::get('comments/{id}/view', 'CommentController@viewComment')->middleware('ajax.only');
            Route::post('comments/{id}/update', 'CommentController@updateComment')->name('comments.update');
            Route::delete('comments/{id}', 'CommentController@destroy')->name('comments.destroy');
        });
        Route::middleware('disable.tickets')->group(function () {
            Route::name('tickets.')->prefix('tickets')->group(function () {
                Route::get('create/get/user', 'TicketController@getUser');
                Route::get('status/{status}', 'TicketController@index')->name('status');
                Route::get('{ticket_number}/close', 'TicketController@closeTicket')->name('close');
                Route::post('{ticket_number}/reply', 'TicketController@ticketReply')->name('reply');
                Route::get('download/{ticket_number}/{id}', 'TicketController@downloadAttachments')->name('download');
            });
            Route::resource('tickets', 'TicketController');
        });
        Route::group(['prefix' => 'settings', 'namespace' => 'Settings', 'middleware' => 'demo'], function () {
            Route::name('admin.settings.')->group(function () {
                Route::view('/', 'backend.settings.index')->name('index');
                Route::get('general', 'GeneralController@index')->name('general');
                Route::post('general/update', 'GeneralController@update')->name('general.update');
                Route::name('storage.')->prefix('storage')->group(function () {
                    Route::get('/', 'StorageController@index')->name('index');
                    Route::post('settings/update', 'StorageController@updateSettings')->name('updateSettings');
                    Route::get('edit/{id}', 'StorageController@edit')->name('edit');
                    Route::post('edit/{id}', 'StorageController@update')->name('update');
                    Route::post('connect/{provider}', 'StorageController@storageTest')->name('test');
                    Route::post('default/{id}', 'StorageController@setDefault')->name('default');
                });
                Route::name('smtp.')->prefix('smtp')->group(function () {
                    Route::get('/', 'SmtpController@index')->name('index');
                    Route::post('update', 'SmtpController@update')->name('update');
                    Route::post('test', 'SmtpController@test')->name('test');
                });
                Route::resource('extensions', 'ExtensionController', ['only' => ['index', 'edit', 'update']]);
                Route::resource('gateways', 'GatewayController', ['only' => ['index', 'edit', 'update']]);
                Route::name('mailtemplates.')->prefix('mailtemplates')->group(function () {
                    Route::get('/', 'MailTemplateController@redirect')->name('index');
                    Route::post('settings/update', 'MailTemplateController@updateSettings')->name('settings.update');
                    Route::get('{lang}', 'MailTemplateController@index')->name('show');
                    Route::get('{lang}/{group}', 'MailTemplateController@index')->name('show.group');
                    Route::post('{lang}/{group}', 'MailTemplateController@update')->name('update');
                });
                Route::resource('taxes', 'TaxController');
            });
            Route::get('pages/slug', 'PageController@slug')->name('pages.slug');
            Route::resource('pages', 'PageController');
            Route::resource('admins', 'AdminController');
            Route::prefix('languages')->group(function () {
                Route::post('{id}/default', 'LanguageController@setDefault')->name('language.default');
                Route::post('{id}/update', 'LanguageController@translateUpdate')->name('translates.update');
                Route::get('translate/{code}', 'LanguageController@translate')->name('language.translate');
                Route::get('translate/{code}/{group}', 'LanguageController@translate')->name('language.translate.group');
            });
            Route::resource('languages', 'LanguageController');
            Route::resource('seo', 'SeoController');
        });
        Route::name('admin.additional.')->prefix('additional')->namespace('Additional')->middleware('demo')->group(function () {
            Route::get('cache', 'CacheController@index')->name('cache');
            Route::get('custom-css', 'CustomCssController@index')->name('css');
            Route::post('custom-css/update', 'CustomCssController@update')->name('css.update');
            //Route::get('popup-notice', 'PopupNoticeController@index')->name('notice');
            //Route::post('popup-notice/update', 'PopupNoticeController@update')->name('notice.update');
        });
        Route::name('admin.')->prefix('others')->namespace('Others')->middleware('demo')->group(function () {
            Route::resource('slideshow', 'SlideShowController');
            Route::resource('features', 'FeatureController');
            Route::resource('faq', 'FaqController');
        });
        Route::name('admin.')->prefix('account')->namespace('Account')->middleware('demo')->group(function () {
            Route::get('details', 'SettingsController@detailsForm')->name('account.details');
            Route::get('security', 'SettingsController@securityForm')->name('account.security');
            Route::post('details/update', 'SettingsController@detailsUpdate')->name('account.details.update');
            Route::post('security/update', 'SettingsController@securityUpdate')->name('account.security.update');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Frontend Routs With Laravel Localization
|--------------------------------------------------------------------------
 */
Route::prefix('user')->namespace('Frontend\User')->middleware(['UserStatusCheck', 'notInstalled', 'auth', 'verified', 'disable.tickets'])->group(function () {
    Route::get('tickets/download/{ticket_number}/{id}', 'TicketController@downloadAttachments')->name('user.tickets.download');
});
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localizationRedirect', 'localeSessionRedirect', 'UserStatusCheck', 'notInstalled']], function () {
    Route::namespace ('Frontend\Gateways')->prefix('ipn')->name('ipn.')->group(function () {
        Route::get('paypal_express', 'PaypalExpressController@ipn')->name('paypal_express');
        Route::get('stripe_checkout', 'StripeCheckoutController@ipn')->name('stripe_checkout');
    });
    Auth::routes(['verify' => true]);
    Route::group(['namespace' => 'Frontend\User\Auth'], function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('login/{provider}', 'LoginController@redirectToProvider')->name('provider.login');
        Route::get('login/{provider}/callback', 'LoginController@handleProviderCallback')->name('provider.callback');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::middleware(['disable.registration'])->group(function () {
            Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register')->middleware('check.registration');
            Route::get('register/complete/{token}', 'RegisterController@showCompleteForm')->name('complete.registration');
            Route::post('register/complete/{token}', 'RegisterController@complete')->middleware('check.registration');
            
        });
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
        Route::get('password/confirm', 'ConfirmPasswordController@showConfirmForm')->name('password.confirm');
        Route::post('password/confirm', 'ConfirmPasswordController@confirm');
        Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
        Route::post('email/verify/email/change', 'VerificationController@changeEmail')->name('change.email');
        Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
        Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
    });
    Route::group(['namespace' => 'Frontend\User\Auth', 'middleware' => ['auth', 'verified']], function () {
        Route::get('checkpoint/2fa/verify', 'CheckpointController@show2FaVerifyForm')->name('2fa.verify');
        Route::post('checkpoint/2fa/verify', 'CheckpointController@verify2fa');
    });
    Route::group(['prefix' => 'user', 'namespace' => 'Frontend\User', 'middleware' => ['auth', 'verified', '2fa.verify']], function () {
        Route::name('user.')->group(function () {
            Route::get('plans', 'PlanController@index')->name('plans');
            Route::get('checkout/{checkout_id}', 'CheckoutController@index')->name('checkout.index');
            Route::post('checkout/{checkout_id}/coupon/apply', 'CheckoutController@applyCoupon')->name('checkout.coupon.apply');
            Route::post('checkout/{checkout_id}/coupon/remove', 'CheckoutController@removeCoupon')->name('checkout.coupon.remove');
            Route::post('checkout/{checkout_id}/proccess', 'CheckoutController@proccess')->name('checkout.proccess');

            Route::get('berthSpace', 'ShipBerthController@index')->name('berthSpace');
            Route::get('berthSpace/create', 'ShipBerthController@create')->name('berthSpace.create');
            Route::post('berthSpace/store', 'ShipBerthController@store')->name('berthSpace.store');
            Route::get('berthSpace/edit/{id}', 'ShipBerthController@edit')->name('berthSpace.edit');
            Route::post('berthSpace/update', 'ShipBerthController@update')->name('berthSpace.update');
            Route::get('berthSpace/delete/{id}', 'ShipBerthController@destroy')->name('berthSpace.delete');

            Route::get('operators', 'OperatorsController@index')->name('operators');
            Route::get('operator/create', 'OperatorsController@create')->name('operator.create');
            Route::post('operator/store', 'OperatorsController@store')->name('operator.store');
            Route::get('operator/edit/{id}', 'OperatorsController@edit')->name('operator.edit');
            Route::post('operator/update', 'OperatorsController@update')->name('operator.update');
        });
        Route::middleware('isSubscribed')->group(function () {
            Route::get('/', 'DashboardController@redirectToDashboard')->name('user');
            Route::name('user.')->group(function () {
                Route::get('dashboard', 'DashboardController@index')->name('dashboard');
                Route::name('transfers.')->prefix('transfers')->group(function () {
                    Route::get('/', 'TransferController@index')->name('index');
                    Route::get('{unique_id}', 'TransferController@show')->name('show');
                    Route::post('{unique_id}', 'TransferController@update')->name('update');
                    Route::get('{unique_id}/file/{id}', 'TransferController@downloadFiles')->name('downloadFiles');
                    Route::delete('{unique_id}/file/{id}', 'TransferController@deleteFiles')->name('deletefiles');
                });
                Route::prefix('notifications')->group(function () {
                    Route::get('/', 'NotificationController@index')->name('notifications');
                    Route::get('view/{id}', 'NotificationController@view')->name('notifications.view');
                    Route::get('readall', 'NotificationController@readAll')->name('notifications.readall');
                });
                Route::get('subscription', 'SubscriptionController@index')->name('subscription');
                Route::get('subscription/transaction/{transaction_id}', 'SubscriptionController@transaction')->name('transaction');
                Route::prefix('tickets')->middleware('disable.tickets')->group(function () {
                    Route::get('/', 'TicketController@index')->name('tickets');
                    Route::get('create', 'TicketController@create')->name('tickets.create');
                    Route::post('create/store', 'TicketController@store')->name('tickets.store');
                    Route::get('{ticket_number}', 'TicketController@view')->name('tickets.view');
                    Route::post('{ticket_number}/reply', 'TicketController@ticketReply')->name('tickets.reply');
                    Route::get('status/{status}', 'TicketController@index')->name('tickets.status');
                });
                Route::prefix('settings')->group(function () {
                    Route::get('/', 'SettingsController@index')->name('settings');
                    Route::post('details/update', 'SettingsController@detailsUpdate')->name('settings.details.update');
                    Route::post('details/mobile/update', 'SettingsController@mobileUpdate')->name('settings.details.mobile.update');
                    Route::get('password', 'SettingsController@password')->name('settings.password');
                    Route::post('password/update', 'SettingsController@passwordUpdate')->name('settings.password.update');
                    Route::get('2fa', 'SettingsController@towFactor')->name('settings.2fa');
                    Route::post('2fa/enable', 'SettingsController@towFactorEnable')->name('settings.2fa.enable');
                    Route::post('2fa/disabled', 'SettingsController@towFactorDisable')->name('settings.2fa.disable');
                });

                Route::get('marinasProfile', 'DashboardController@marinasProfile')->name('marinasProfile');
                Route::post('marinasProfileUpdate', 'DashboardController@marinasProfileUpdate')->name('marinasProfileUpdate');
                Route::get('marinasBerthSpaces', 'DashboardController@marinasBerthSpaces')->name('marinasBerthSpaces');
                Route::get('marinasAmenities', 'DashboardController@marinasAmenities')->name('marinasAmenities');
                Route::get('marinasPhotos', 'DashboardController@marinasPhotos')->name('marinasPhotos');
                Route::get('marinasPhotosAdd', 'DashboardController@marinasPhotosAdd')->name('marinasPhotosAdd');
                Route::post('photosAdd', 'DashboardController@photosAdd')->name('photosAdd');
                Route::get('marinasPhotosDelete/{id}', 'DashboardController@marinasPhotosDelete')->name('marinasPhotosDelete');
                Route::post('marinasAmenitiesUpdate', 'DashboardController@marinasAmenitiesUpdate');
                Route::post('marinasFeaturedAmenitiesUpdate', 'DashboardController@marinasFeaturedAmenitiesUpdate');
                Route::get('loginLogs', 'DashboardController@loginLogs')->name('loginLogs');
            });
        });
    });
    Route::group(['namespace' => 'Frontend', 'middleware' => ['verified', '2fa.verify']], function () {
        Route::post('plan/{id}/{type}', 'SubscribeController@subscribe')->name('subscribe');
        Route::get('cookie/accept', 'ExtraController@cookie')->middleware('ajax.only');
        Route::get('popup/close', 'ExtraController@popup')->middleware('ajax.only');
        Route::middleware('isSubscribed')->group(function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::post('requestForm', 'HomeController@requestForm');
            Route::post('rate', 'HomeController@rate');
            Route::post('upload', 'UploadController@upload');
            Route::post('uploads/delete', 'UploadController@destroy');
            Route::name('transfer.')->namespace('Transfer')->group(function () {
                Route::get('d/{link}', 'DownloadController@index')->name('download.index');
                Route::get('d/{link}/password', 'DownloadController@showPasswordForm')->name('download.password');
                Route::post('d/{link}/password', 'DownloadController@unlockTransfer')->name('download.password.unlock');
                Route::post('d/{link}/single/request', 'DownloadController@requestDownloadLink');
                Route::get('d/{link}/single/{file_id}/download', 'DownloadController@download')->name('download.single.file');
                Route::get('d/{link}/all/request', 'DownloadController@requestDownloadAllLink');
                Route::get('d/{link}/all/download', 'DownloadController@downloadAll')->name('download.all');
                Route::prefix('transfer')->group(function () {
                    Route::post('sendfiles', 'SendFilesController@process')->name('sendfiles');
                    Route::post('createlink', 'CreateLinkController@process')->name('createlink');
                });
            });
            Route::get('faq', 'PageController@faq')->name('faq');
            Route::get('contact', 'PageController@contact')->name('contact');
            Route::post('contact/send', 'PageController@contactSend');
            Route::name('blog.')->prefix('blog')->middleware('disable.blog')->group(function () {
                Route::get('/', 'BlogController@index')->name('index');
                Route::get('category/{slug}', 'BlogController@index')->name('category');
                Route::get('article/{slug}', 'BlogController@article')->name('article');
                Route::post('article/{slug}/comment', 'BlogController@comment')->name('article.comment');
            });
            Route::get('{slug}', 'PageController@pages')->name('page');
        });
    });
});
