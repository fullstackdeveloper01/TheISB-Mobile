<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('splashScreen', [ApiController::class, 'splashScreen']);
Route::get('introScreen', [ApiController::class, 'introScreen']);
Route::get('aboutUs', [ApiController::class, 'aboutUs']);
Route::get('terms-and-condition', [ApiController::class, 'termsAndCondition']);
Route::get('schoolRules', [ApiController::class, 'schoolRules']);
Route::get('ourPhilosopher', [ApiController::class, 'ourPhilosopher']);
Route::get('privacyPolicy', [ApiController::class, 'privacyPolicy']);
Route::get('boatTypeList', [ApiController::class, 'boatTypeList']);
Route::get('countryList', [ApiController::class, 'countryList']);
Route::post('forgotPassword', [ApiController::class, 'forgotPassword']);

Route::post('getProfile', [ApiController::class, 'getProfile']);
Route::post('updateProfileImage', [ApiController::class, 'updateProfileImage']);
Route::get('dashboardSection', [ApiController::class, 'dashboardSection']);
Route::get('slider', [ApiController::class, 'slider']);
Route::post('sliderDetails', [ApiController::class, 'sliderDetails']);
Route::post('announcementList', [ApiController::class, 'announcementList']);
Route::get('advertisement', [ApiController::class, 'advertisement']);
Route::post('noticeBoardList', [ApiController::class, 'noticeBoardList']);
Route::post('noticeBoardDetails', [ApiController::class, 'noticeBoardDetails']);
Route::get('knowledgeBaseList', [ApiController::class, 'knowledgeBaseList']);
Route::post('knowledgeBaseDetails', [ApiController::class, 'knowledgeBaseDetails']);
Route::post('siblingsList', [ApiController::class, 'siblingsList']);
Route::post('submitQuery', [ApiController::class, 'submitQuery']);
Route::post('eventsList', [ApiController::class, 'eventsList']);
Route::post('eventDetails', [ApiController::class, 'eventDetails']);
Route::post('alertNotice', [ApiController::class, 'alertNotice']);
Route::post('galleries', [ApiController::class, 'galleries']);
Route::post('galleryDetails', [ApiController::class, 'galleryDetails']);
Route::get('sectionList', [ApiController::class, 'sectionList']);
Route::post('sectionData', [ApiController::class, 'sectionData']);
Route::post('eventsData', [ApiController::class, 'eventsData']);
Route::post('classSyllabus', [ApiController::class, 'classSyllabus']);
Route::post('classTimeTable', [ApiController::class, 'classTimeTable']);
Route::post('academicContent', [ApiController::class, 'academicContent']);
Route::post('assignments', [ApiController::class, 'assignments']);
Route::post('busRoute', [ApiController::class, 'busRoute']);
Route::post('applyForLeave', [ApiController::class, 'applyForLeave']);
Route::post('leaveRequestList', [ApiController::class, 'leaveRequestList']);
Route::get('complaintType', [ApiController::class, 'complaintType']);
Route::post('raiseComplaint', [ApiController::class, 'raiseComplaint']);
Route::post('raiseComplaintList', [ApiController::class, 'raiseComplaintList']);
Route::post('complaintTypeList', [ApiController::class, 'complaintTypeList']);
Route::post('raiseComplaintType', [ApiController::class, 'raiseComplaintType']);
Route::post('raiseComplaintTypeList', [ApiController::class, 'raiseComplaintTypeList']);
Route::post('complaintCount', [ApiController::class, 'complaintCount']);
Route::post('complaintsResult', [ApiController::class, 'complaintsResult']);

Route::get('testNotification', [ApiController::class, 'testNotification']);
Route::get('classesList', [ApiController::class, 'classesList']);
Route::get('complaintList', [ApiController::class, 'complaintList']);
Route::get('transportComplaintList', [ApiController::class, 'transportComplaintList']);
Route::get('academicComplaintList', [ApiController::class, 'academicComplaintList']);
Route::post('complaintStatusUpdate', [ApiController::class, 'complaintStatusUpdate']);
Route::post('complaintExport', [ApiController::class, 'complaintExport']);

Route::post('updateDeviceDetails', [ApiController::class, 'updateDeviceDetails']);
Route::post('appVersion', [ApiController::class, 'appVersion']);
Route::post('notificationList', [ApiController::class, 'notificationList']); 
Route::post('notificationDetails', [ApiController::class, 'notificationDetails']); 

Route::post('staffNotificationList', [ApiController::class, 'staffNotificationList']); 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/auth/register', [ApiController::class, 'createUser']);
Route::post('/auth/login', [ApiController::class, 'login']);
Route::post('/auth/logout', [ApiController::class, 'logout']);

Route::middleware('auth:sanctum')->group( function () {
    //Route::get('logout','Api\ApiController@logout');
    //Route::post('/getProfile', 'Api\ApiController@getProfile');
    Route::post('/updateProfile', 'Api\ApiController@updateProfile');
    
});

Route::get('unauthorized', function () {
    return response()->json(['status' => false, 'authenticate' => false, 'message' => 'Unauthorized.'], 401);
})->name('unauthorized');


