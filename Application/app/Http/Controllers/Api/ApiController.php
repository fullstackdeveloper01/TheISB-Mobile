<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Models\User;
use App\Models\Staff;
use App\Models\Event;
use App\Models\Query;
use App\Models\Slider;
use App\Models\UserLog;
use App\Models\Gallery;
use App\Models\Section;
use App\Models\TimeTable;
use App\Models\Assignment;
use App\Models\LeaveRequest;
use App\Models\SectionOther;
use App\Models\PopupNotice;
use App\Models\GalleryItem;
use App\Models\NoticeBoard;
use App\Models\Highlighter;
use App\Models\MainSection;
use App\Models\IntroScreen;
use App\Models\SplashScreen;
use App\Models\Announcement;
use App\Models\KnowledgeBase;
use App\Models\Syllabus;
use App\Models\BusRoute;
use App\Models\ComplaintType;
use App\Models\ComplaintsRaise;
use App\Models\UserNotification;
use App\Models\StaffNotification;
use App\Exports\ExportUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use Log;
//use Jenssegers\Agent\Agent;
use Jenssegers\Agent\Facades\Agent;

use Maatwebsite\Excel\Facades\Excel;

class ApiController extends Controller
{
    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required',
                'password' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }

        $client = new \GuzzleHttp\Client();
//Log::debug('-----------------------------------------------------------------------------------------------------------');
//Log::info($request->all());
        $response = $client->post('https://www.theisb.in/students/api/apiController/signIn/', [
                'form_params' => [
                    'email' => (string)$request->email,
                    'password' => (string)$request->password
                ]
            ]
        );
        $result = $response->getBody()->getContents();
        $result = json_decode($result);        
        if($result->status == false){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $result->message,
            ], 200);
        }
        if($result->user_type == 'management'){
            $management = $result->result;
            $response_[] = $management;
            $this->staffLogin($request, $management);
            return response()->json([
                'status' => true,
                'message' => $result->message,
                'user_type' => $result->user_type,
                'token' => $management->id,
                'data' => $response_
            ], 200);
        }
        $user = $result->result;
        $resp[] = $user;
        /*$ntoken = '';*/
//Log::debug('---------------------------------------$user--------------------------------------------------------------------');
//Log::info(json_encode($user));
        $app_type = @$request->app_type;
        $studentRecord = User::where('student_id', $user->id)->first();
        if(!is_null($studentRecord)){
            $studentRecord->device_id = $request->device_id;
            $studentRecord->device_type = $request->device_type;
            $studentRecord->password = Hash::make($request->password);
            $studentRecord->save();
            /*$ntoken = $studentRecord->createToken("API TOKEN")->plainTextToken;*/
        }
        else{
            $studentRecord = User::create([
                    'student_id' => $user->id,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'mobile' => $user->mobile,
                    'campus' => $user->campus,
                    'shift' => $user->shift,
                    'class_id' => $user->class,
                    'section' => $user->section_id,
                    'device_id' => $request->device_id,
                    'device_type' => $request->device_type,
                    'avatar' => 'images/avatars/default.png',
                    'email' => $user->username,
                    'password' => Hash::make($request->password)
                ]);
            /*$ntoken = $studentRecord->createToken("API TOKEN")->plainTextToken;*/
        }
        if(!is_null(@$studentRecord->device_id)){
            $this->setLog($studentRecord, $app_type);
        }
        return response()->json([
            'status' => true,
            'message' => $result->message,
            'user_type' => $result->user_type,
            'token' => $user->id,
            'data' => $resp
            /*'token' => $user->createToken("API TOKEN")->plainTextToken*/
        ], 200);
    }

    /************************************************************************************
    *
    * @ Staff login details
    ************************************************************************************/
    public function staffLogin($request, $staff){
        $staffDetails = Staff::where('staff_id', $staff->id)->first();
        if(!is_null($staffDetails)){
            $staffDetails->device_id = $request->device_id;
            $staffDetails->device_type = $request->device_type;
            $staffDetails->save();
        }
        else{
            $staffDetails = new Staff;
            $staffDetails->staff_id = $staff->id;
            $staffDetails->firstname = $staff->firstname;
            $staffDetails->lastname = $staff->lastname;
            $staffDetails->email = $request->email;
            $staffDetails->password = Hash::make($request->password);
            $staffDetails->mobile = $staff->phone;
            $staffDetails->device_id = $request->device_id;
            $staffDetails->device_type = $request->device_type;
            $staffDetails->save();
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function updateDeviceDetails(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'id' => 'required',
                'name' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'mobile' => 'required',
                'username' => 'required',
                'app_type' => 'required',
                'campus' => 'required',
                'shift' => 'required',
                'class_id' => 'required',
                'section' => 'required',
                'device_id' => 'required',
                'device_type' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
Log::debug('-----------------------------------------------------------------------------------------------------------');
Log::info($request->all());
        /*$ntoken = '';*/
        $app_type = @$request->app_type;
        $studentRecord = User::where('student_id', $request->id)->first();
        if(!is_null($studentRecord)){
            $studentRecord->device_id = $request->device_id;
            $studentRecord->device_type = $request->device_type;
            $studentRecord->firstname = $request->firstname;
            $studentRecord->lastname = $request->lastname;
            $studentRecord->campus = $request->campus;
            $studentRecord->shift = $request->shift;
            $studentRecord->class_id = $request->class_id;
            $studentRecord->section = str_replace('A','',@$request->section);
            $studentRecord->save();
            /*$ntoken = $studentRecord->createToken("API TOKEN")->plainTextToken;*/
        }
        else{
            $studentRecord = User::create([
                    'student_id' => $request->id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'mobile' => $request->mobile,
                    'device_id' => $request->device_id,
                    'device_type' => $request->device_type,
                    'campus' => $request->campus,
                    'shift' => $request->shift,
                    'class_id' => $request->class_id,
                    'section' => str_replace('A','',@$request->section),
                    'avatar' => 'images/avatars/default.png',
                    'email' => $request->username
                ]);
            /*$ntoken = $studentRecord->createToken("API TOKEN")->plainTextToken;*/
        }
        if(!is_null($studentRecord->device_id)){
            $this->setLog($studentRecord, $app_type);
        }
        return response()->json([
            'status' => true,
            'message' => 'Device details update successfully',
            'token' => $studentRecord->student_id
        ], 200);
    }
	
    /**
     * Function@ set log
     * 
     **/
    public function setLog($user, $app_type)
    {
        //$agent = new Agent();
        $platform = Agent::platform();
        $browser = Agent::browser();
        $ip = vIpInfo()->ip;
        $userLog = UserLog::where([['student_id', $user->student_id], ['device_id', $user->device_id]])->first();
        if(!is_null($userLog)){
            $userLog->ip = vIpInfo()->ip;
            $userLog->country = vIpInfo()->country;
            $userLog->country_code = vIpInfo()->country_code;
            $userLog->timezone = vIpInfo()->timezone;
            $userLog->location = vIpInfo()->location;
            $userLog->latitude = vIpInfo()->latitude;
            $userLog->longitude = vIpInfo()->longitude;
            $userLog->browser = vBrowser();
            $userLog->app_type = $app_type;
            $userLog->device_type = $user->device_type;
            $userLog->campus = $user->campus;
            $userLog->shift = $user->shift;
            $userLog->class_id = $user->class_id;
            $userLog->section = str_replace('A','',@$user->section);
            $userLog->os = vPlatform();
            $userLog->status = 1;
            $userLog->update();
        }
        else{
            if(!is_null($user->device_id)){
                $log = new UserLog();
                $log->user_id = $user->id;
                $log->student_id = $user->student_id;
                $log->ip = vIpInfo()->ip;
                $log->country = vIpInfo()->country;
                $log->country_code = vIpInfo()->country_code;
                $log->timezone = vIpInfo()->timezone;
                $log->location = vIpInfo()->location;
                $log->latitude = vIpInfo()->latitude;
                $log->longitude = vIpInfo()->longitude;
                $log->browser = vBrowser();
                $log->app_type = $app_type;
                $log->device_id = $user->device_id;
                $log->device_type = $user->device_type;
                $log->campus = $user->campus;
                $log->shift = $user->shift;
                $log->class_id = $user->class_id;
                $log->section = str_replace('A','',@$user->section);
                $log->os = vPlatform();
                $log->status = 1;
                $log->save();                
            }
        }
    }

	/**
	*	Get Orders
	*/
	public function getProfile(Request $request){   
		//$user = $request->user();
        $validateUser = Validator::make($request->all(), 
            [
                'token' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://www.theisb.in/students/api/apiController/getProfile', [
                'form_params' => [
                    'userid' => $request->token
                ]
            ]
        );
        $result = $response->getBody()->getContents();
        $result = json_decode($result);   
        if($result->status == false){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $result->message,
            ], 200);
        }
        else{
            $responseData = $result->result;
            $resp = [];
            foreach($responseData as $res){
                $user = User::where('student_id', $res->id)->first();
                $post['id'] = $res->id;
                $full_name = preg_replace('/\s+/', ' ', $res->full_name);
                $post['full_name'] = trim(@$full_name);
                $post['firstname'] = trim(@$res->firstname);
                $post['lastname'] = trim(@$res->lastname);
                $post['email'] = @$res->email;
                $post['class'] = @$res->class;
                $post['shift'] = @$res->shift;
                $post['father_name'] = @$res->father_name;
                $post['mother_name'] = @$res->mother_name;
                $post['father_mobile'] = @$res->father_mobile;
                $post['section'] = @$res->section;
                $post['campus'] = @$res->campus;
                $post['app_type'] = "";
                if(!is_null($user)){
                    $post['profile_image'] = @$user->avatar;
                }
                else{
                    $post['profile_image'] = 'images/avatars/default.png';
                }
                $resp[] = $post;
            }
            return response()->json([
                'status' => true,
                'message' => $result->message,
                'token' => $request->token,
                'data' => $resp
                /*'token' => $user->createToken("API TOKEN")->plainTextToken*/
            ], 200);

        }
	}

    /********************************************************************************************
     * @Function: Get notification list
    ********************************************************************************************/
    public function notificationList(Request $request){
        $validateUser = Validator::make($request->all(), 
            [
                'token' => 'required',
                'type' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        if($request->type == 'Both'){
            $notifyList = UserNotification::select('id','notification_id', 'title', 'message', 'image', 'type', 'created_at as date_time')->where('student_id', $request->token)->where('type', '<>', 'Mobile')->orderByDesc('id')->get();
        }
        else{            
            $notifyList = UserNotification::select('id','notification_id', 'title', 'message', 'image', 'type', 'created_at as date_time')->where('student_id', $request->token)->where('type', $request->type)->orderByDesc('id')->get();
        }
        if(count($notifyList) > 0){
            //$notifictionsList = $notifyList->toArray();
            $response = [];
            foreach($notifyList as $res){
                $post['id'] = $res->id;
                $post['notification_id'] = $res->notification_id;
                $post['title'] = $res->title;
                $post['message'] = $res->message;
                $post['image'] = $res->image;
                $post['type'] = $res->type;
                $post['date_time'] = vDate($res->date_time);

                $response[] = $post;
            }
            return response()->json([
                    'status' => true,
                    'message' => 'Notification list',
                    'data' => $response
                ], 200);
        }
        else{
            return response()->json([
                    'status' => false,
                    'message' => 'Record not found.',
                ], 200);
        }
    }

    /********************************************************************************************
     * @Function: Get notification details
    ********************************************************************************************/
    public function notificationDetails(Request $request){
        $validateUser = Validator::make($request->all(), 
            [
                'id' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $notifyList = UserNotification::select('id','notification_id', 'title', 'message', 'image', 'type', 'created_at')->where('id', $request->id)->get();
        if(count($notifyList) > 0){
            $response = [];
            foreach($notifyList as $res){
                $post['id'] = $res->id;
                $post['notification_id'] = $res->notification_id;
                $post['title'] = $res->title;
                $post['message'] = $res->message;
                $post['image'] = $res->image;
                $post['type'] = $res->type;
                $post['date_time'] = vDate($res->created_at);

                $response[] = $post;
            }
            $notifictionsList = $notifyList->toArray();
            return response()->json([
                    'status' => true,
                    'message' => 'Notification details',
                    'data' => $response
                ], 200);
        }
        else{
            return response()->json([
                    'status' => false,
                    'message' => 'Record not found.',
                ], 200);
        }
    }

    /**
    *   Get Orders
    */
    public function siblingsList(Request $request){   
        //$user = $request->user();
        $validateUser = Validator::make($request->all(), 
            [
                'mobile' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }

        $client = new \GuzzleHttp\Client();

        $response = $client->post('https://www.theisb.in/students/api/apiController/studentSiblings', [
                'form_params' => [
                    'mobile' => $request->mobile
                ]
            ]
        );
        $result = $response->getBody()->getContents();
        $result = json_decode($result);   

        if($result->status == false){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $result->message,
            ], 200);
        }
        else{
            if(count($result->result) > 1){
                return response()->json([
                    'status' => true,
                    'message' => $result->message,
                    'data' => $result->result
                    /*'token' => $user->createToken("API TOKEN")->plainTextToken*/
                ], 200);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'Record not found.',
                ], 200);
            }
        }
    }

    /**
     * @Function: Update profile 
     **/
    public function updateProfile(Request $request){
        $user = $request->user();
        $validateUser = Validator::make($request->all(), 
        [
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile' => 'required|min:10|max:15|unique:users,mobile,'.$user->id,
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 200);
        }

        $rowAffected = $user->update([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'mobile' => $request->mobile
                    ]);
        return response()->json([
                'status' => true,
                'message' => 'Profile update successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
    }

    /**
     * @Function: Update profile 
     **/
    public function updateProfileImage(Request $request){
        $validateUser = Validator::make($request->all(), 
        [
            'token' => 'required',
            'avatar' => 'mimes:png,jpg,jpeg|max:3072'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $user = User::where('student_id',$request->token)->first();
        if ($request->has('avatar')) {
            if ($user == null) {
                $uploadAvatar = vImageUpload($request->file('avatar'), 'images/avatars/users/', null);
                $update = User::create([
                    'student_id' => $request->token,
                    'avatar' => $uploadAvatar,
                ]); 
            }
            else{
                $uploadAvatar = vImageUpload($request->file('avatar'), 'images/avatars/users/', null, null, $user->avatar);
                $update = $user->update([
                    'avatar' => $uploadAvatar,
                ]);            
            }
        } 
        return response()->json([
                'status' => true,
                'message' => 'Profile update successfully'
            ], 200);
    }

    /*-------------------------------------------------------------------
    *@function: student profile
    *-------------------------------------------------------------------*/
    public function dashboardSection(Request $request){
        $result = MainSection::select('id','heading','icon','file_type','file_value','line_color')->where(['id' => 1])->get(); 
        if (!empty($result)) {
            $response =  [];
            $response['id'] =   $result[0]->id;
            $response['heading'] =   $result[0]->heading;
            $response['icon'] =   $result[0]->icon;
            $response['file_type'] =   $result[0]->file_type;
            if($result[0]->file_type == "color"){
                $response['file_value'] =   str_replace('#', '', $result[0]->file_value);
            }
            else{
                $response['file_value'] =   $result[0]->file_value;
            }
            $response['line_color'] =   str_replace('#', '', $result[0]->line_color);
            return response()->json([
                'status' => true,
                'message' => 'Dashboard section',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }  
    }

    /*-------------------------------------------------------------------
    *@function: Slider list
    *-------------------------------------------------------------------*/
    public function slider(Request $request){
        $result = Highlighter::select('id','title','image','short_description')->orderBy('id', 'desc')->get(); 
        if (!empty($result)) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['image'] = $res->image;
                $data['short_description'] = $res->short_description;
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Slider list',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Slider list
    *-------------------------------------------------------------------*/
    public function sliderDetails(Request $request){
        $validateUser = Validator::make($request->all(), 
            [
                'id' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $result = Highlighter::where('id', $request->id)->get(); 
        if (!empty($result)) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['image'] = $res->image;
                $data['short_description'] = $res->short_description;
                $data['content'] = $res->content;
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Slider details',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Knowledge Base list
    *-------------------------------------------------------------------*/
    public function knowledgeBaseList(Request $request){
        $result = KnowledgeBase::select('id','title','image','short_description')->orderBy('id', 'desc')->get(); 
        if (count($result) > 0) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['image'] = $res->image;
                $data['short_description'] = $res->short_description;
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Knowledge base list',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Knowledge Base Details
    *-------------------------------------------------------------------*/
    public function knowledgeBaseDetails(Request $request){
        $validateUser = Validator::make($request->all(), 
            [
                'id' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $result = KnowledgeBase::where('id', $request->id)->get(); 
        if (!empty($result)) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['image'] = $res->image;
                $data['short_description'] = $res->short_description;
                $data['content'] = $res->content;
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Knowledge-base details',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Events list
    *-------------------------------------------------------------------*/
    public function eventsList(Request $request){
        $validateUser = Validator::make($request->all(), 
        [
            'event_type' => 'required',
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required'
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $token = $request->token;
        $class_id = $request->class_id;
        $shift = $request->shift;
        $campus = $request->campus;
        $sectionId = $this->studentSectionName($request->section); 

        $eventResult = Event::select('id','title','image','short_description', 'event_date','campus', 'shift', 'class_id', 'section', 'student_id', 'created_at', 'updated_at')
        ->where(function($query) use ($token){
            $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
            $query->orWhere('student_id', '=', '0');
        })
        ->where(function($query) use ($campus){
            $query->orWhereRaw('FIND_IN_SET(?, campus)', [$campus]);
            //$query->orWhere('campus', '=', '0');
        })
        ->where(function($query) use ($shift){
            $query->orWhereRaw('FIND_IN_SET(?, shift)', [$shift]);
            //$query->orWhere('shift', '=', '0');
        })
        ->where(function($query) use ($class_id){
            $query->orWhereRaw('FIND_IN_SET(?, class_id)', [$class_id]);
            //$query->orWhere('class_id', '=', '0');
        })
        ->where(function($query) use ($sectionId){
            $query->orWhereRaw('FIND_IN_SET(?, section)', [$sectionId]);
            $query->orWhere('section', '=', '0');
        });
        if($request->event_type == 2){
            $eventResult->whereDate('event_date', '>=', date('Y-m-d'));
            $result = $eventResult->orderBy('event_date', 'asc')->get();
        }
        else{
            $eventResult->whereDate('event_date', '<', date('Y-m-d'));
            $result = $eventResult->orderBy('event_date', 'desc')->get();
        }
        if (count($result) > 0) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift;
                $data['class_id'] = $res->class_id;
                //$data['student_id'] = $res->student_id;
                $data['section'] = $this->studentSection($res->section); 
                $data['image'] = $res->image;
                $data['event_date'] = date('d M Y', strtotime($res->event_date));
                $data['short_description'] = $res->short_description;
                $data['created_at'] = date('d M Y', strtotime($res->event_date));
                $data['date'] = date('d F', strtotime($res->updated_at));
                $data['time'] = date('H:i', strtotime($res->updated_at));
                $data['year'] = date('Y', strtotime($res->updated_at));
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Event list',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Event Details
    *-------------------------------------------------------------------*/
    public function eventDetails(Request $request){
        $validateUser = Validator::make($request->all(), 
            [
                'id' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $result = Event::where('id', $request->id)->get(); 
        if (!empty($result)) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['image'] = $res->image;
                $data['event_date'] = date('d M Y', strtotime($res->event_date));
                $data['short_description'] = $res->short_description;
                $data['content'] = $res->content;
                $data['date'] = date('d F', strtotime($res->created_at));
                $data['time'] = date('H:i', strtotime($res->created_at));
                $data['year'] = date('Y', strtotime($res->created_at));
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Event details',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Galleries list
    *-------------------------------------------------------------------*/
    public function galleries(Request $request){
        $validateUser = Validator::make($request->all(), 
        [
            'item_type' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $result = Gallery::where('item_type', $request->item_type)->select('id','title','item_type')->orderBy('id', 'desc')->get(); 
        if (count($result) > 0) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['item_type'] = $res->item_type;
                $data['item_value'] = $this->galleryThumbnail($res->id, $res->item_type);
                if($request->item_type == 2){
                    $youtube_code = $this->galleryThumbnail($res->id, $res->item_type);
                    $data['video_thumb'] = 'https://img.youtube.com/vi/'.$youtube_code.'/0.jpg';
                    $data['channel_thumb'] = 'https://img.youtube.com/vi/'.$youtube_code.'/3.jpg';
                }
                else{
                    $data['video_thumb'] = '';
                    $data['channel_thumb'] = '';
                }
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Gallery list',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Gallery image
    *-------------------------------------------------------------------*/
    public function galleryThumbnail($gid, $gtype){
        $image = '';
        if($gtype == 1){
            $galleryData = GalleryItem::where(['gallery_id' => $gid, 'featured_status' => 1])->get();
            if(count($galleryData) > 0){
                $image = $galleryData[0]->item_value;
            }
            else{
                $galleryData = GalleryItem::where(['gallery_id' => $gid])->orderBy('id', 'asc')->first();
                $image = $galleryData->item_value;
            }
        }
        else{
            $galleryData = GalleryItem::where(['gallery_id' => $gid])->first();
            $image = $galleryData->item_value;
        }
        return @$image;
    }

    /*-------------------------------------------------------------------
    *@function: Galleries details
    *-------------------------------------------------------------------*/
    public function galleryDetails(Request $request){
        $validateUser = Validator::make($request->all(), 
        [
            'gallery_id' => 'required',
            'page' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $pages = $request->page;
        $length = 16;

        if(empty($page))
        {
            $page = 1;
        } 
        $page = $pages - 1;
        $start = $page*$length;
        $galleryData = GalleryItem::where('gallery_id', $request->gallery_id);
        $galleryData->skip($start);
        $galleryData->take($length);
        $result = $galleryData->orderBy('id', 'desc')->get();
        if (count($result) > 0) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->gallery->title;
                $data['item_type'] = $res->gallery->item_type;
                $data['item_value'] = $res->item_value;
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Gallery details',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Section list
    *-------------------------------------------------------------------*/
    public function sectionList(Request $request){
        $result = Section::select('id','title', 'bg_type', 'bg_value')->where('status', 1)->orderBy('sort_id', 'asc')->get(); 
        if (count($result) > 0) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['bg_type'] = $res->bg_type;
                $data['bg_value'] = $res->bg_value;
                if($res->id == 9){
                    $sectionRecord = Section::where('id', $res->id)->first(); 
                    $data['title_color'] = $sectionRecord->title_color;
                    $data['sub_title'] = $sectionRecord->sub_title;
                    $data['sub_title_color'] = $sectionRecord->sub_title_color;
                    $data['extra'] = $this->sectionExtraData($res->id);
                    $response[] = $data;
                    $data = array();
                }
                else{
                    $data['extra'] = $this->sectionExtraData($res->id);
                    $response[] = $data;
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Section list',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Section details
    *-------------------------------------------------------------------*/
    public function sectionData(Request $request){
        $validateUser = Validator::make($request->all(), 
        [
            'section_id' => 'required'
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $response = [];
        $sectionRecord = Section::where('id', $request->section_id)->first(); 
        $response['id'] = $sectionRecord->id;
        $response['title'] = $sectionRecord->title;
        $response['bg_type'] = $sectionRecord->bg_type;
        $response['bg_value'] = $sectionRecord->bg_value;
        $result = SectionOther::where('section_id', $request->section_id)->get(); 
        $responseOther = [];
        if($request->section_id == 2){
            $data['line_color'] = $sectionRecord->line_color;
            $data['app_icon'] = $sectionRecord->app_icon;
            $responseOther[] = $data;
        }
        elseif($request->section_id == 3){
            $data['title_color'] = $sectionRecord->title_color;
            $data['sub_title'] = $sectionRecord->sub_title;
            $data['sub_title_color'] = $sectionRecord->sub_title_color;
            $responseOther[] = $data;
        }
        elseif($request->section_id == 5){
            $data['btn_text_color'] = $sectionRecord->btn_text_color;
            $data['btn_color'] = $sectionRecord->btn_color;
            $responseOther[] = $data;
        }
        elseif($request->section_id == 7){
            $data['title_color'] = $sectionRecord->title_color;
            $data['sub_title'] = $sectionRecord->sub_title;
            $data['sub_title_color'] = $sectionRecord->sub_title_color;
            $responseOther[] = $data;
        }
        elseif($request->section_id == 9){
            $data['title_color'] = $sectionRecord->title_color;
            $data['sub_title'] = $sectionRecord->sub_title;
            $data['sub_title_color'] = $sectionRecord->sub_title_color;
            $responseOther[] = $data;
        }
        if (count($result) > 0) {            
            if($request->section_id == 4){
                foreach($result as $res){
                    $data['id'] = $res->id;
                    $data['title'] = $res->title;
                    $data['title_color'] = $res->title_color;
                    $data['redirection'] = $res->redirection;
                    $data['icon'] = $res->icon;
                    $responseOther[] = $data;
                }
            }            
            elseif($request->section_id == 6){
                foreach($result as $res){
                    $data['id'] = $res->id;
                    $data['title'] = $res->title;
                    $data['title_color'] = $res->title_color;
                    $data['sub_title'] = $res->sub_title;
                    $data['sub_title_color'] = $res->sub_title_color;
                    $data['icon'] = $res->icon;
                    $data['btn_color'] = $res->btn_color;
                    $responseOther[] = $data;
                }
            }
        }
        $response['extra'] = $responseOther;
        if (count($response) > 0) {
            return response()->json([
                'status' => true,
                'message' => 'Section details',
                'data' => $response
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

     /*-------------------------------------------------------------------
    *@function: Section Other data
    *-------------------------------------------------------------------*/
    public function sectionExtraData($sid){
        $result = SectionOther::where('section_id', $sid)->get(); 
        $responseOther = [];
        $sectionRecord = Section::where('id', $sid)->first(); 
        if($sid == 2){
            $data['line_color'] = $sectionRecord->line_color;
            $data['app_icon'] = $sectionRecord->app_icon;
            $responseOther[] = $data;
        }
        elseif($sid == 3){
            $highlighterResult = Highlighter::select('id','title','image','short_description')->orderBy('id', 'desc')->get(); 
            if(count($highlighterResult)){
                $data['title_color'] = $sectionRecord->title_color;
                $data['sub_title'] = $sectionRecord->sub_title;
                $data['sub_title_color'] = $sectionRecord->sub_title_color;
                foreach($highlighterResult as $res){
                    $data['id'] = $res->id;
                    $data['title'] = $res->title;
                    $data['image'] = $res->image;
                    $data['short_description'] = $res->short_description;
                    $responseOther[] = $data;
                }
            }
        }
        elseif($sid == 5){
            $knowledgeBaseResult = KnowledgeBase::select('id','title','image','short_description')->orderBy('id', 'desc')->get(); 
            if(count($knowledgeBaseResult) > 0){
                $data['btn_text_color'] = $sectionRecord->btn_text_color;
                $data['btn_color'] = $sectionRecord->btn_color;
                foreach($knowledgeBaseResult as $res){
                    $data['id'] = $res->id;
                    $data['title'] = $res->title;
                    $data['image'] = $res->image;
                    $data['short_description'] = $res->short_description;
                    $responseOther[] = $data;
                }
            }
        }
        elseif($sid == 7){
            $eventResult = Event::select('id','title','image','short_description', 'created_at')->where('event_type', 1)->orderBy('id', 'desc')->get(); 
            if(count($eventResult) > 0){
                foreach($eventResult as $res){
                    $data['title_color'] = $sectionRecord->title_color;
                    $data['sub_title'] = $sectionRecord->sub_title;
                    $data['sub_title_color'] = $sectionRecord->sub_title_color;
                    $data['id'] = $res->id;
                    $data['title'] = $res->title;
                    $data['image'] = $res->image;
                    $data['short_description'] = $res->short_description;
                    $data['date'] = date('d F', strtotime($res->created_at));
                    $data['time'] = date('H:i', strtotime($res->created_at));
                    $data['year'] = date('Y', strtotime($res->created_at));
                    $responseOther[] = $data;
                }
            }
        }
        elseif($sid == 9){
            // $data['title_color'] = $sectionRecord->title_color;
            // $data['sub_title'] = $sectionRecord->sub_title;
            // $data['sub_title_color'] = $sectionRecord->sub_title_color;
            // $responseOther[] = $data;
            $eventResult = Slider::select('id','title','image','redirection', 'created_at')->orderBy('id', 'desc')->get(); 
            if(count($eventResult) > 0){
                foreach($eventResult as $res){
                    $data['id'] = $res->id;
                    $data['title'] = $res->title;
                    $data['image'] = $res->image;
                    $data['redirection'] = $res->redirection;
                    $responseOther[] = $data;
                }
            }
        }
        if (count($result) > 0) {            
            if($sid == 4){
                foreach($result as $res){
                    $data['id'] = $res->id;
                    $data['title'] = $res->title;
                    $data['box_color'] = $res->box_color;
                    $data['title_color'] = $res->title_color;
                    $data['redirection'] = $res->redirection;
                    $data['icon'] = $res->icon;
                    $responseOther[] = $data;
                }
            }            
            elseif($sid == 6){
                foreach($result as $res){
                    $data['id'] = $res->id;
                    $data['title'] = $res->title;
                    $data['title_color'] = $res->title_color;
                    $data['sub_title'] = $res->sub_title;
                    $data['sub_title_color'] = $res->sub_title_color;
                    $data['icon'] = $res->icon;
                    $data['icon_color'] = $res->icon_color;
                    $data['btn_color'] = $res->btn_color;
                    $responseOther[] = $data;
                }
            }
            else{
                foreach($result as $res){
                    $data['id'] = $res->id;
                    if($sectionRecord->section_type == 0){
                        $data['image'] = $res->icon;
                        $data['redirection'] = $res->redirection;
                        $data['redirection_url'] = $res->redirection_url;
                    }
                    else{
                        $data['thumbnail'] = $res->icon;
                        $data['redirection_url'] = $res->redirection_url;
                    }
                    $responseOther[] = $data;
                }
            }
        }
        return @$responseOther;
    }

    /*-------------------------------------------------------------------
    *@function: Advertisement list
    *-------------------------------------------------------------------*/
    public function advertisement(Request $request){
       
        $response = [];
        $data['id'] = "1";
        $data['image'] = 'images/advertisement/advertisement.png';
        $data['link'] = 'https://theisb.in/contact-us';
        $response[] = $data;
        
        return response()->json([
            'status' => true,
            'message' => 'Advertisement list',
            'data' => $response
        ], 200);        
    }

    /*-------------------------------------------------------------------
    *@function: Announcement list
    *-------------------------------------------------------------------*/
    public function announcementList(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 

        $token = $request->token;
        $campus = $request->campus;
        $shift = $request->shift;
        $class_id = $request->class_id;
        $sectionId = $this->studentSectionName($request->section);
        $response = []; 
       // DB::enableQueryLog();

        $result = Announcement::select('id','title','content', 'campus', 'shift', 'class_id', 'section', 'student_id', 'created_at', 'updated_at')
            ->where(function($query) use ($token){
                $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                $query->orWhere('student_id', '=', '0');
            })
            ->where(function($query) use ($sectionId){
                $query->orWhere('section', '=', '0');
                $query->orWhere('section', '=', $sectionId);
            }) 
            ->where(function($query) use ($campus){
                $query->orWhere('campus', '=', 'All');
                $query->orWhere('campus', '=', $campus);
            })
            ->where(function($query) use ($shift){
                $query->orWhere('shift', '=', 'All');
                $query->orWhere('shift', '=', $shift);
            })
            ->where(function($query) use ($class_id){
                $query->orWhere('class_id', '=', $class_id);
                $query->orWhere('class_id', '=', 'All');
            })
            ->orderByDesc('id')->get(); 
            //dd(DB::getQueryLog());

        if (count($result) > 0) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['content'] = $res->content;
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift;
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Announcement list',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Notice board list
    *-------------------------------------------------------------------*/
    public function noticeBoardList(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        }
        $token = $request->token;
        $class_id = $request->class_id;
        $campus = $request->campus;
        $shift = $request->shift;
        $sectionId = $this->studentSectionName($request->section);
        $response = []; 

        $result = NoticeBoard::select('id','title','notice_type','image','content', 'notice_date', 'campus', 'shift', 'class_id', 'section', 'student_id', 'created_at', 'updated_at')->where('notice_date', '>=', date('Y-m-d'))->where('status', 1)
            ->where(function($query) use ($token){
                $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                $query->orWhere('student_id', '=', '0');
            })
            ->where(function($query) use ($campus){
                $query->orWhereRaw('FIND_IN_SET(?, campus)', [$campus]);
            })
            ->where(function($query) use ($shift){
                $query->orWhereRaw('FIND_IN_SET(?, shift)', [$shift]);
            })
            ->where(function($query) use ($class_id){
                $query->orWhereRaw('FIND_IN_SET(?, class_id)', [$class_id]);
            })
            ->where(function($query) use ($sectionId){
                $query->orWhereRaw('FIND_IN_SET(?, section)', [$sectionId]);
                $query->orWhere('section', '=', '0');
            })
            ->orderBy('notice_date', 'asc')->get(); 

        if (count($result) > 0) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift;
                $data['class_id'] = $res->class_id;
                //$data['student_id'] = $res->student_id;
                $data['section'] = $this->studentSection($res->section);
                if($res->notice_type == 0){
                    $data['content'] = $res->content;
                }
                elseif($res->notice_type == 1){
                    $data['content'] = $res->image;
                }
                elseif($res->notice_type == 2){
                    $data['content'] = $res->image;
                }
                else{                    
                    $data['content'] = ""; 
                }
                $data['notice_type'] = $res->notice_type;
                $data['notice_date'] = date('d M, Y', strtotime($res->notice_date));
                $data['date'] = date('d F', strtotime($res->updated_at));
                $data['created_at'] = vDate($res->updated_at);
                $data['time'] = date('H:i', strtotime($res->updated_at));
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Notice board list',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Notice Board Details
    *-------------------------------------------------------------------*/
    public function noticeBoardDetails(Request $request){
        $validateUser = Validator::make($request->all(), 
            [
                'id' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $result = NoticeBoard::where('id', $request->id)->get(); 
        if (count($result) > 0) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['notice_type'] = $res->notice_type;
                $data['notice_date'] = date('d M, Y', strtotime($res->notice_date));
                $data['image'] = $res->image;
                $data['content'] = $res->content;
                $data['date'] = date('d F', strtotime($res->created_at));
                $data['time'] = date('H:i', strtotime($res->created_at));
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Notice board details',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /**
     * @Function: Submit Query
     **/
    public function submitQuery(Request $request){
        $validateUser = Validator::make($request->all(), 
            [
                'student_id'    => 'required',
                'full_name'     => 'required',
                'class'         => 'required',
                'query_for'     => 'required',
                'phone_number'  => 'required|min:10|max:11',
                'your_query'    => 'required',
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'authenticate' => true,
                'message' => $validateUser->messages()->first()
            ], 200);
        }

        $create = Query::create([
                'student_id' => $request->student_id,
                'full_name' => $request->full_name,
                'class' => $request->class,
                'query_for' => $request->query_for,
                'phone_number' => $request->phone_number,
                'your_query' => $request->your_query,
            ]);
        if (!empty($create)) {
            return response()->json([
                'status' => true,
                'message' => 'Query submited successfully'
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Query not submited successfully',
            ], 200);
        } 
    }

    /******************************************************************
     * @function: Logout
     *******************************************************************/
    public function logout(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'device_id'    => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        if(@$request->user_type == 'management'){
            $staffDetails = Staff::where('device_id', $request->device_id)->first();
            if(!is_null($staffDetails)){
                $staffDetails->device_id = '';
                $staffDetails->device_type = '';
                $staffDetails->save();
            }
        }
        else{            
            $userLog = UserLog::where('device_id', $request->device_id)->first();
            if(!is_null($userLog)){
                $userLog->delete();
            }
        }
        return response()->json([
                'status' => true,
                'message' => 'Logged out successfully'
            ], 200);
    }

    /******************************************************************
     *@Function: Splace Screen     * 
     ******************************************************************/
    public function splashScreen(Request $request)
    {   
        $result = SplashScreen::where(['id' => 1])->first();        
        if (!empty($result)) {
            $resp['splash_screen'] = $result->image;
            return response()->json([
                'status' => true,
                'data' => $resp,
                'message' => 'Splash screen'
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }              
    }

    /**
     *@Function: About Us     * 
     */
    public function aboutUs(Request $request)
    {   
        $result = Page::where(['id' => 1])->first();        
        if (!empty($result)) {
            $response = [];
            $response['title'] = $result->title;
            $response['content'] = $result->content;
            return response()->json([
                'status' => true,
                'message' => 'About Us Content',
                'data' => $response,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }              
    }

    /**
     *@Function: About Us     * 
     */
    public function termsAndCondition(Request $request)
    {   
        $result = Page::where(['id' => 4])->first();        
        if (!empty($result)) {
            $response = [];
            $response['title'] = $result->title;
            $response['content'] = $result->content;
            return response()->json([
                'status' => true,
                'message' => 'Terms and condition',
                'data' => $response,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }              
    }

    /**
     *@Function: Our Philosophers    * 
     */
    public function ourPhilosopher(Request $request)
    {   
        $result = Page::where(['id' => 2])->first();        
        if (!empty($result)) {
            $response = [];
            $response['title'] = $result->title;
            $response['content'] = $result->content;
            return response()->json([
                'status' => true,
                'message' => 'Our Philosopher',
                'data' => $response,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }              
    }

    /**
     *@Function: School Rules   * 
     */
    public function schoolRules(Request $request)
    {   
        $result = Page::where(['id' => 3])->first();        
        if (!empty($result)) {
            $response = [];
            $response['title'] = $result->title;
            $response['content'] = $result->content;
            return response()->json([
                'status' => true,
                'message' => 'School rules',
                'data' => $response,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }              
    }

    /**********************************************************
     *@Function: About Us     * 
    **********************************************************/
    public function alertNotice(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        //$result = PopupNotice::where(['id' => 1, 'status' => 1])->get();    
        $token = $request->token;
        $sectionId = $this->studentSectionName($request->section); 
        $result = PopupNotice::select('id','campus', 'image','shift', 'class_id', 'section', 'student_id', 'created_at', 'updated_at')
                    // ->where(['class_id' => $request->class_id, 'campus' => $request->campus, 'shift' => $request->shift])
                    ->where(function($query) use ($token){
                        $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                        $query->orWhere('student_id', '=', '0');
                    })
                    ->where(function($query) use ($sectionId){
                        $query->orWhere('section', '=', '0');
                        $query->orWhere('section', '=', $sectionId);
                    })
                    ->get();    
        if (!is_null($result)) {
            $response = [];
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift;
                $data['image'] = $res->image;
                $data['section'] = $this->studentSection($res->section);                 
                $data['created_at'] = vDate($res->updated_at);
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'message' => 'Alert notification',
                'data' => $response,
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }              
    }

    /**
     *@Function: Intro Screen     * 
     */
    public function introScreen(Request $request)
    {   
        $response = [];
        $result = IntroScreen::where(['status' => 1])->orderBy('id', 'desc')->get();        
        if (count($result) > 0) {
            foreach($result as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['screen'] = $res->screen;
                $response[] = $data;
            }
            return response()->json([
                'status' => true,
                'data' => $response,
                'message' => 'Into screen list'
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }              
    }

    /**
     * @Function: Forgot password 
     **/
    public function forgotPassword(Request $request)
    {
        $data = $request->only('email');
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        }
        $user = User::where(['email'=>$request->email])->first();
        if (!empty($user)) {
            $password['password']= Str::random(12);
            $user->password= Hash::make($password['password']);
            $user->bc_id= md5($password['password']);
            $user->save();
            $email=$user->email;
            $password['email']=$email;
            $password['user_name']=ucfirst($user->firstname);
            $html= view('mail.forgot_password',$password);
         
            $this->send_email($email,'Forgot Password',$html);
            return response()->json([
                'status' => true,
                'message' => "Password Send To Register Email Id",
            ]);
        }else {
            return response()->json([
                'status' => false,
                'message' =>"This email is not registered",
            ], 500);
        }
    }

    /******************************************
     * @Events Data
     * *************************************************/
    public function eventsData(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 

        $response = [];
        $todaydays = date('Y-m-d'); 
        // $eventResult = TimeTable::whereDate('start', '>=', $todaydays)->orderBy('start', 'asc')->get();
        // $eventResult = TimeTable::all();
        $resp = []; 
        $token = $request->token;
        $campus = $request->campus;
        $shift = $request->shift;
        $class_id = $request->class_id;
        $sectionId = $this->studentSectionName($request->section);
        $syllabuss = TimeTable::select('*')
                    /*->where(function($query) use ($token){
                        $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                        $query->orWhere('student_id', '=', '0');
                    })
                    ->where(function($query) use ($sectionId){
                        $query->orWhere('section', '=', '0');
                        $query->orWhere('section', '=', $sectionId);
                    }) 
                    ->where(function($query) use ($campus){
                        $query->orWhere('campus', '=', 'All');
                        $query->orWhere('campus', '=', $campus);
                    })
                    ->where(function($query) use ($shift){
                        $query->orWhere('shift', '=', 'All');
                        $query->orWhere('shift', '=', $shift);
                    })
                    ->where(function($query) use ($class_id){
                        $query->orWhere('student_class', '=', $class_id);
                        $query->orWhere('student_class', '=', 'All');
                    })*/
                    ->orderByDesc('id')->get();
          
        if(count($syllabuss) > 0){
           
            foreach($syllabuss as $res){

                $response[$res->start][] = $res->title;

                $data['id'] = $res->id; 
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift; 
                $data['date'] = $res->start;
                $data['title'] = $res->title; 
                $data['description'] = $res->description; 
                $data['section'] = $this->studentSection($res->section);                 
                $data['created_at'] = vDate($res->created_at);

                $resp[] = $data; 
            }
            return response()->json([
                'status' => true,
                'event' => $resp,
                'data' => $response,
                'message' => 'Events list'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        } 
    }

    /******************************************
     * @Class Syllabus
     * *************************************************/
    public function classSyllabus(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 

        $response = []; 
        $token = $request->token;
        $campus = $request->campus;
        $shift = $request->shift;
        $class_id = $request->class_id;
        $sectionId = $this->studentSectionName($request->section); 
        $syllabuss = Syllabus::select('id','syllabus','campus', 'shift', 'class_name', 'section', 'student_id', 'created_at', 'updated_at')->where('type', '=', 0)
                    ->where(function($query) use ($token){
                        $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                        $query->orWhere('student_id', '=', '0');
                    })
                    ->where(function($query) use ($campus){
                        $query->orWhereRaw('FIND_IN_SET(?, campus)', [$campus]);
                        //$query->orWhere('campus', '=', '0');
                    })
                    ->where(function($query) use ($shift){
                        $query->orWhereRaw('FIND_IN_SET(?, shift)', [$shift]);
                        //$query->orWhere('shift', '=', '0');
                    })
                    ->where(function($query) use ($class_id){
                        $query->orWhereRaw('FIND_IN_SET(?, class_name)', [$class_id]);
                        //$query->orWhere('class_id', '=', '0');
                    })
                    ->where(function($query) use ($sectionId){
                        $query->orWhereRaw('FIND_IN_SET(?, section)', [$sectionId]);
                        $query->orWhere('section', '=', '0');
                    })
                    ->orderBy('class_name', 'asc')->get();
          
        if(count($syllabuss) > 0){
            $response = [];
            foreach($syllabuss as $res){
                $data['id'] = $res->id;
                $data['syllabus'] = $res->syllabus;
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift;
                //$data['class_id'] = $res->class_name;
                $data['section'] = $this->studentSection($res->section);                 
                $data['created_at'] = vDate($res->updated_at);
                $response[] = $data;
            }
            return response()->json([
                'status' => true, 
                'data' => $response,
                'message' => $request->class_id.' Syllabus'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /******************************************
     * @Class Time Table
     * *************************************************/
    public function classTimeTable(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $response = []; 
        $token = $request->token;
        $campus = $request->campus;
        $shift = $request->shift;
        $class_id = $request->class_id;
        $sectionId = $this->studentSectionName($request->section); 
        $syllabuss = Syllabus::select('id','syllabus as timetable','campus', 'shift', 'class_name', 'section', 'student_id', 'created_at', 'updated_at')->where('type', '=', 1)
                    ->where(function($query) use ($token){
                        $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                        $query->orWhere('student_id', '=', '0');
                    })
                    ->where(function($query) use ($campus){
                        $query->orWhereRaw('FIND_IN_SET(?, campus)', [$campus]);
                        //$query->orWhere('campus', '=', '0');
                    })
                    ->where(function($query) use ($shift){
                        $query->orWhereRaw('FIND_IN_SET(?, shift)', [$shift]);
                        //$query->orWhere('shift', '=', '0');
                    })
                    ->where(function($query) use ($class_id){
                        $query->orWhereRaw('FIND_IN_SET(?, class_name)', [$class_id]);
                        //$query->orWhere('class_id', '=', '0');
                    })
                    ->where(function($query) use ($sectionId){
                        $query->orWhereRaw('FIND_IN_SET(?, section)', [$sectionId]);
                        $query->orWhere('section', '=', '0');
                    })
                    ->orderBy('class_name', 'asc')->get();
          
        if(count($syllabuss) > 0){
            $response = [];
            foreach($syllabuss as $res){
                $data['id'] = $res->id;
                $data['timetable'] = $res->timetable;
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift;
                //$data['class_id'] = $res->class_name;
                $data['section'] = $this->studentSection($res->section);                 
                $data['created_at'] = vDate($res->updated_at);
                $response[] = $data;
            }
            return response()->json([
                'status' => true, 
                'data' => $response,
                'message' => $request->class_id.' timetable'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /******************************************
     * @Class Academic Content
     * *************************************************/
    public function academicContent(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 

        $response = []; 
        $token = $request->token;
        $campus = $request->campus;
        $shift = $request->shift;
        $class_id = $request->class_id;
        $sectionId = $this->studentSectionName($request->section); 
        $syllabuss = Syllabus::select('id','syllabus as content','campus', 'shift', 'class_name', 'section', 'student_id', 'created_at', 'updated_at')->where('type', '=', 2)
                    ->where(function($query) use ($token){
                        $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                        $query->orWhere('student_id', '=', '0');
                    })
                    ->where(function($query) use ($campus){
                        $query->orWhereRaw('FIND_IN_SET(?, campus)', [$campus]);
                        //$query->orWhere('campus', '=', '0');
                    })
                    ->where(function($query) use ($shift){
                        $query->orWhereRaw('FIND_IN_SET(?, shift)', [$shift]);
                        //$query->orWhere('shift', '=', '0');
                    })
                    ->where(function($query) use ($class_id){
                        $query->orWhereRaw('FIND_IN_SET(?, class_name)', [$class_id]);
                        //$query->orWhere('class_id', '=', '0');
                    })
                    ->where(function($query) use ($sectionId){
                        $query->orWhereRaw('FIND_IN_SET(?, section)', [$sectionId]);
                        $query->orWhere('section', '=', '0');
                    })
                    ->orderBy('class_name', 'asc')->get();
          
        if(count($syllabuss) > 0){
            $response = [];
            foreach($syllabuss as $res){
                $data['id'] = $res->id;
                $data['content'] = $res->content;
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift;
                //$data['class_id'] = $res->class_name;
                $data['section'] = $this->studentSection($res->section);                 
                $data['created_at'] = vDate($res->updated_at);
                $response[] = $data;
            }
            return response()->json([
                'status' => true, 
                'data' => $response,
                'message' => $request->class_id.' academic content'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /******************************************
     * @Class assignments Content
     * *************************************************/
    public function assignments(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required', 
            'campus' => 'required', 
            'shift' => 'required', 
            'class_id' => 'required', 
            'section' => 'required', 
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $token = $request->token;
        $class_id = $request->class_id;
        $campus = $request->campus;
        $shift = $request->shift;
        $sectionId = $this->studentSectionName($request->section);
        $response = []; 
        $assignmentsList = Assignment::select('id','title', 'assignment', 'campus', 'shift', 'homework_type','class_id', 'section', 'created_at', 'updated_at')
            /*
            ->where(function($query) use ($token){
                $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                $query->orWhere('student_id', '=', '0');
            })
            ->where(function($query) use ($sectionId){
                $query->orWhere('section', '=', '0');
                $query->orWhere('section', '=', $sectionId);
            })*/
            ->where('status', 1)
            ->where(function($query) use ($token){
                $query->orWhereRaw('FIND_IN_SET(?, student_id)', [$token]);
                $query->orWhere('student_id', '=', '0');
            })
            ->where(function($query) use ($campus){
                $query->orWhereRaw('FIND_IN_SET(?, campus)', [$campus]);
                //$query->orWhere('campus', '=', '0');
            })
            ->where(function($query) use ($shift){
                $query->orWhereRaw('FIND_IN_SET(?, shift)', [$shift]);
                //$query->orWhere('shift', '=', '0');
            })
            ->where(function($query) use ($class_id){
                $query->orWhereRaw('FIND_IN_SET(?, class_id)', [$class_id]);
                //$query->orWhere('class_id', '=', '0');
            })
            ->where(function($query) use ($sectionId){
                $query->orWhereRaw('FIND_IN_SET(?, section)', [$sectionId]);
                $query->orWhere('section', '=', '0');
            })
            ->orderByDesc('id')->get();
        if(count($assignmentsList) > 0){
            //$result = $assignmentsList->toArray();
            $response = [];
            foreach($assignmentsList as $res){
                $data['id'] = $res->id;
                $data['title'] = $res->title;
                $data['campus'] = $res->campus;
                $data['shift'] = $res->shift;
                $data['class_id'] = $res->class_id;
                //$data['student_id'] = $res->student_id;
                $data['section'] = $this->studentSection($res->section);
                $data['homework_type'] = $res->homework_type;
                $data['assignment'] = $res->assignment;   
                $data['date'] = date('d F', strtotime($res->updated_at));
                $data['created_at'] = vDate($res->updated_at);
                $data['time'] = date('H:i', strtotime($res->updated_at));
                $response[] = $data;
            }            
            return response()->json([
                'status' => true, 
                'data' => $response,
                'message' => $request->class_id.' assignments'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /******************************************
     * @Class assignments Content
     * *************************************************/
    public function busRoute(Request $request){

        $data = $request->only('class_id');
        $validator = Validator::make($data, [
            'class_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 

        $response = []; 
        $busRoute = BusRoute::where(['status' => 1, 'id' => 2])->first();
        if(!is_null($busRoute)){
            $resp['id'] = $busRoute->id;
            $resp['file'] = $busRoute->image;
            $response[] = $resp;
            return response()->json([
                'status' => true, 
                'data' => $response,
                'message' => $request->class_id.' Bus route'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Found some error',
            ], 200);
        }
    }

    /**
     * @Function: Request for leave
     **/
    public function applyForLeave(Request $request){
        $validator = Validator::make($request->all(), 
        [
            'student_id' => 'required',
            'student_name' => 'required',
            'father_name' => 'required',
            'class_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason_for_leave' => 'required',
            'other_reason' => 'required',
            /*'application' => 'mimes:png,jpg,jpeg,pdf|max:3072',*/
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        if (!empty($request->file('application'))){
            $extension = $request->file('application')->extension();
            $allowExtention = array('png','jpg','jpeg');
            if(in_array($extension, $allowExtention)){
                $application = vImageUpload($request->file('application'), 'images/application/', null);
            }
            else{
                $application = vFileUpload($request->file('application'), 'images/application/');
            }
        }
        else{
            $extension = '-';
            $application = '-';
        }
        $rowAffected = LeaveRequest::create([
                        'student_id' => $request->student_id,
                        'student_name' => $request->student_name,
                        'father_name' => $request->father_name,
                        'class_id' => $request->class_id,
                        'start_date' => date('Y-m-d', strtotime($request->start_date)),
                        'end_date' => date('Y-m-d',strtotime($request->end_date)),
                        'reason_for_leave' => $request->reason_for_leave,
                        'other_reason' => $request->other_reason,
                        'application' => $application,
                        'extension' => $extension
                    ]);
        if(!is_null($rowAffected)){
            return response()->json([
                'status' => true, 
                'message' => 'Leave apply successfully'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Found some error',
            ], 200);
        }
    }

    /***************************************************
     * @Class Leave request list
     * *************************************************/
    public function leaveRequestList(Request $request){
        $data = $request->only('token');
        $validator = Validator::make($data, [
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $result = LeaveRequest::select('id','student_name','father_name','class_id','start_date','end_date','reason_for_leave', 'other_reason', 'application', 'extension', 'status')->where('student_id', $request->token)->orderBy('start_date', 'asc')->get();
        if(count($result) > 0){
            $resultList = $result->toArray();
            return response()->json([
                'status' => true, 
                'data' => $resultList,
                'message' => 'Leave request link'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Complaint List
    *-------------------------------------------------------------------*/
    public function complaintList(Request $request){
        $todayData = date('Y-m-d');
        $totalTransport = ComplaintsRaise::where(['type' => 'Transport'])->whereDate('created_at', '=', $todayData)->count(); 
        $transport_pending = ComplaintsRaise::where(['status' => '0','type' => 'Transport'])->whereDate('created_at', '=', $todayData)->count(); 
        $transport_process = ComplaintsRaise::where(['status' => '1','type' => 'Transport'])->whereDate('created_at', '=', $todayData)->count(); 
        $transport_resolved = ComplaintsRaise::where(['status' => '2','type' => 'Transport'])->whereDate('created_at', '=', $todayData)->count(); 
        $transport_rejected = ComplaintsRaise::where(['status' => '3','type' => 'Transport'])->whereDate('created_at', '=', $todayData)->count(); 
        $totalAcademic = ComplaintsRaise::where(['type' => 'Academic'])->whereDate('created_at', '=', $todayData)->count(); 
        $academic_pending = ComplaintsRaise::where(['status' => '0','type' => 'Academic'])->whereDate('created_at', '=', $todayData)->count(); 
        $academic_process = ComplaintsRaise::where(['status' => '1','type' => 'Academic'])->whereDate('created_at', '=', $todayData)->count(); 
        $academic_resolved = ComplaintsRaise::where(['status' => '2','type' => 'Academic'])->whereDate('created_at', '=', $todayData)->count(); 
        $academic_rejected = ComplaintsRaise::where(['status' => '3','type' => 'Academic'])->whereDate('created_at', '=', $todayData)->count(); 
              
        return response()->json([
            'status' => true,
            'message' => 'Complaint List',
            'totalTransport' => $totalTransport,
            'transport_resolved' => $transport_resolved,
            'transport_process' => $transport_process,
            'transport_pending' => $transport_pending,
            'transport_rejected' => $transport_rejected,
            'academic_process' => $academic_process,
            'academic_resolved' => $academic_resolved,
            'academic_pending' => $academic_pending,
            'academic_rejected' => $academic_rejected,
            'totalAcademic' => $totalAcademic
        ], 200);
    }

    /*-------------------------------------------------------------------
    *@function: Complaint Type
    *-------------------------------------------------------------------*/
    public function complaintType(Request $request){
        $result = ComplaintType::select('id','title')->where(['status' => 1, 'type' => 'Transport'])->orderBy('title', 'asc')->get(); 
        if (count($result) > 0) {
            $response = $result->toArray();   
            $data['id'] = 0;         
            $data['title'] = "Other";  
            $response[] = $data;       
            return response()->json([
                'status' => true,
                'message' => 'Complaint Type List',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Raise Complaints
    *-------------------------------------------------------------------*/
    public function raiseComplaint(Request $request){
        $validator = Validator::make($request->all(), 
        [
            'student_id' => 'required',
            'student_name' => 'required',
            'student_class' => 'required',
            // 'student_section' => 'required',
            'student_shift' => 'required',
            'student_mobile' => 'required',
            'student_complaint' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $todayRecord = ComplaintsRaise::where(['student_id' => $request->student_id, 'type' => 'Transport'])->whereDate('created_at', '=', date('Y-m-d'))->count();
        if($todayRecord == 0){
            $rowAffected = ComplaintsRaise::create([
                            'type' => 'Transport',
                            'student_id' => $request->student_id,
                            'student_name' => $request->student_name,
                            'father_name' => $request->father_name,
                            'mother_name' => $request->mother_name,
                            'student_class' => $request->student_class,
                            'student_section' => $request->student_section,
                            'student_shift' => $request->student_shift,
                            'student_mobile' => $request->student_mobile,
                            'student_complaint' => $request->student_complaint,
                            'student_other_complaint' => $request->student_other_complaint
                        ]);
            if(!is_null($rowAffected)){
                $temp = [];
                $subject = 'Transport Complaint - #'.$rowAffected->id.', '.$request->student_name;
                $temp['subject'] = $subject;
                $temp['student_name'] = $request->student_name;
                $temp['father_name'] = $request->father_name;
                $temp['mother_name'] = $request->mother_name;
                $temp['student_mobile'] = $request->student_mobile;
                $temp['student_class'] = $request->student_class;
                $temp['student_shift'] = $request->student_shift;
                if($request->student_complaint == 0){
                    $temp['message'] = $request->student_other_complaint;
                }
                else{
                    $complaintMsg = DB::table('complaint_types')->where('id', $request->student_complaint)->first();
                    $temp['message'] = @$complaintMsg->title;
                }
                $html = view('mail.complaint-template',$temp);
                sendEmail('tanmay@immersiveinfotech.com', $subject, $html);
                sendEmail('theisb.in@gmail.com', $subject, $html);

                $staffList = Staff::select('device_id', 'staff_id')->where('status', '1')->get();
                if(count($staffList) > 0){
                    foreach($staffList as $staff){
                        if(!empty($staff->device_id)){
                            $title = 'New Transport Complaint';
                            $messageData['title']           = $title;
                            $messageData['message']         = $request->student_name.' #'.$rowAffected->id;
                            $messageData['id']              = $rowAffected->id;       
                            $messageData['user_id']         = $staff->staff_id;
                            $messageData['notify_type']     = 8;
                            $messageData['redirection']     = $rowAffected->id;
                            $messageData['image']           = '';
                            sendNotification($staff->device_id, $title, $messageData);
                            $staffNotify['staff_id'] = $staff->staff_id;
                            $staffNotify['notification_id'] = $rowAffected->id;
                            $staffNotify['device_id'] = $staff->device_id;
                            $staffNotify['title'] = $title;
                            $staffNotify['message'] = $request->student_name.' #'.$rowAffected->id;
                            $staffNotify['image'] = '';
                            $staffNotify['type'] = 2;
                            $this->staffNotificationStore($staffNotify);
                        }
                    }
                }

                return response()->json([
                    'status' => true, 
                    'message' => 'Raise complaint successfully'
                ], 200);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'Found some error',
                ], 200);
            }
        }
        else{
            return response()->json([
                    'status' => false, 
                    'message' => 'Dear Parents, You can raise only one complaint in a day. Thanks'
                ], 200);
        }
    }

    /***************************************************
     * @Class Raise complaint list
     * *************************************************/
    public function raiseComplaintList(Request $request){
        $data = $request->only('token');
        $validator = Validator::make($data, [
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $result = ComplaintsRaise::select('id','student_name','father_name','mother_name','student_class','student_section','student_shift', 'student_mobile', 'student_complaint', 'student_other_complaint', 'status', 'updated_at', 'admin_comment')->where(['student_id' => $request->token, 'type' => 'Transport'])->orderByDesc('id')->get();
        if(count($result) > 0){
            $resultList = [];
            foreach($result as $res){
                $postdata['id'] = $res->id;
                $postdata['student_name'] = $res->student_name;
                $postdata['father_name'] = $res->father_name;
                $postdata['mother_name'] = $res->mother_name;
                $postdata['student_class'] = $res->student_class;
                $postdata['student_section'] = $res->student_section;
                $postdata['student_shift'] = $res->student_shift;
                $postdata['student_mobile'] = $res->student_mobile;
                if($res->student_complaint == 0){
                    $postdata['student_complaint'] = 'Other';
                    $postdata['student_other_complaint'] = $res->student_other_complaint;
                }
                else{
                    $postdata['student_complaint'] = @$res->complaintType->title;
                    $postdata['student_other_complaint'] = "";
                }
                $postdata['status'] = $res->status;
                $postdata['admin_comment'] = (is_null($res->admin_comment))?"":$res->admin_comment;
                $postdata['created_at'] = vDate($res->updated_at);
                $resultList[] = $postdata;
            }
            return response()->json([
                'status' => true, 
                'data' => $resultList,
                'message' => 'Transport complaint list'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Complaint Type List
    *-------------------------------------------------------------------*/
    public function complaintTypeList(Request $request){
        $validator = Validator::make($request->all(), 
        [
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        }
        $result = ComplaintType::select('id','title')->where(['status' => 1, 'type' => $request->type])->orderBy('title', 'asc')->get(); 
        if (count($result) > 0) {
            $response = $result->toArray();   
            $data['id'] = 0;         
            $data['title'] = "Other";  
            $response[] = $data;       
            return response()->json([
                'status' => true,
                'message' => 'Complaint Type List',
                'data' => $response
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function: Raise Complaints
    *-------------------------------------------------------------------*/
    public function raiseComplaintType(Request $request){
        $validator = Validator::make($request->all(), 
        [
            'type' => 'required',
            'student_id' => 'required',
            'student_name' => 'required',
            'student_class' => 'required',
            // 'student_section' => 'required',
            'student_shift' => 'required',
            'student_mobile' => 'required|min:10|max:10',
            'student_complaint' => 'required',
            'student_other_complaint' => 'max:900',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        }
        $todayRecord = ComplaintsRaise::where(['student_id' => $request->student_id, 'type' => $request->type])->whereDate('created_at', '=', date('Y-m-d'))->count();
        if($todayRecord == 0){
            $rowAffected = ComplaintsRaise::create([
                            'type' => $request->type,
                            'student_id' => $request->student_id,
                            'student_name' => $request->student_name,
                            'father_name' => $request->father_name,
                            'mother_name' => $request->mother_name,
                            'student_mobile' => $request->student_mobile,
                            'student_class' => $request->student_class,
                            'student_section' => $request->student_section,
                            'student_shift' => $request->student_shift,
                            'student_complaint' => $request->student_complaint,
                            'student_other_complaint' => $request->student_other_complaint
                        ]);
            if(!is_null($rowAffected)){
                $temp = [];
                $subject = $request->type.' Complaint - #'.$rowAffected->id.', '.$request->student_name;
                $temp['subject'] = $subject;
                $temp['student_name'] = $request->student_name;
                $temp['father_name'] = $request->father_name;
                $temp['mother_name'] = $request->mother_name;
                $temp['student_mobile'] = $request->student_mobile;
                $temp['student_class'] = $request->student_class;
                $temp['student_shift'] = $request->student_shift;
                if($request->student_complaint == 0){
                    $temp['message'] = $request->student_other_complaint;
                }
                else{
                    $complaintMsg = DB::table('complaint_types')->where('id', $request->student_complaint)->first();
                    $temp['message'] = @$complaintMsg->title;
                }
                $html = view('mail.complaint-template',$temp);
                sendEmail('tanmay@immersiveinfotech.com', $subject, $html);
                sendEmail('theisb.in@gmail.com', $subject, $html);

                $staffList = Staff::select('device_id', 'staff_id')->where('status', '1')->get();
                if(count($staffList) > 0){
                    foreach($staffList as $staff){
                        if(!empty($staff->device_id)){
                            $title = 'New '.$request->type.' Complaint';
                            $messageData['title']           = $title;
                            $messageData['message']         = $request->student_name.' #'.$rowAffected->id;
                            $messageData['id']              = $rowAffected->id;       
                            $messageData['user_id']         = $staff->staff_id;
                            $messageData['notify_type']     = 8;
                            $messageData['redirection']     = $rowAffected->id;
                            $messageData['image']           = '';
                            sendNotification($staff->device_id, $title, $messageData);

                            $staffNotify['staff_id'] = $staff->staff_id;
                            $staffNotify['notification_id'] = $rowAffected->id;
                            $staffNotify['device_id'] = $staff->device_id;
                            $staffNotify['title'] = $title;
                            $staffNotify['message'] = $request->student_name.' #'.$rowAffected->id;
                            $staffNotify['image'] = '';
                            if($request->type == 'Transport'){
                                $staffNotify['type'] = 2;    
                            }
                            else{
                                $staffNotify['type'] = 1;        
                            }
                            $this->staffNotificationStore($staffNotify);
                        }
                    }
                }

                return response()->json([
                    'status' => true, 
                    'message' => 'Raise complaint successfully'
                ], 200);
            }
            else{
                return response()->json([
                    'status' => false,
                    'message' => 'Found some error',
                ], 200);
            }
        }
        else{
            return response()->json([
                    'status' => false, 
                    'message' => 'Dear Parents, You can raise only one complaint in a day. Thanks'
                ], 200);
        }
    }

    /***************************************************
     * @Class Raise complaint list
     * *************************************************/
    public function raiseComplaintTypeList(Request $request){
        $data = $request->only('token', 'type');
        $validator = Validator::make($data, [
            'type' => 'required',
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $result = ComplaintsRaise::select('id','student_name','father_name','mother_name','student_class','student_section','student_shift', 'student_mobile', 'student_complaint', 'student_other_complaint', 'status', 'created_at', 'updated_at', 'admin_comment')->where(['student_id' => $request->token, 'type' => $request->type])->orderByDesc('id')->get();
        if(count($result) > 0){
            $resultList = [];
            foreach($result as $res){
                $postdata['id'] = $res->id;
                $postdata['student_name'] = $res->student_name;
                $postdata['father_name'] = $res->father_name;
                $postdata['mother_name'] = $res->mother_name;
                $postdata['student_class'] = $res->student_class;
                $postdata['student_section'] = $res->student_section;
                $postdata['student_shift'] = $res->student_shift;
                $postdata['student_mobile'] = $res->student_mobile;
                if($res->student_complaint == 0){
                    $postdata['student_complaint'] = 'Other';
                    $postdata['student_other_complaint'] = $res->student_other_complaint;
                }
                else{
                    $postdata['student_complaint'] = @$res->complaintType->title;
                    $postdata['student_other_complaint'] = "";
                }
                $postdata['status'] = $res->status;
                $postdata['admin_comment'] = (is_null($res->admin_comment))?"":$res->admin_comment;
                $postdata['created_at'] = vDate($res->updated_at);
                $resultList[] = $postdata;
            }
            return response()->json([
                'status' => true, 
                'data' => $resultList,
                'message' => $request->type.' complaint list'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 200);
        }
    }

    /***************************************************
     * @Complaint Count
     * *************************************************/
    public function complaintCount(Request $request){
        $validator = Validator::make($request->all(), [
            'complaint_type' => 'required',
            'complaint_status' => 'required',
            'complaint_record' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $result = ComplaintsRaise::where(['type' => $request->complaint_type]);
        if($request->complaint_record == 'today'){
            $result->whereDate('created_at', '=', date('Y-m-d'));
        }
        if($request->complaint_status != 'all'){
            $result->where('status', '=', $request->complaint_status);
        }        
        $data['total'] = $result->count();
        $response[] = $data;
        return response()->json([
            'status' => true, 
            'data' => $response,
            'type' => $request->complaint_type,
            'message' => $request->complaint_type.' complaint count'
        ], 200);
    }

    /***************************************************
     * @Complaint result
     * *************************************************/
    public function complaintsResult(Request $request){
        $validator = Validator::make($request->all(), [
            'complaint_type' => 'required',
            'complaint_status' => 'required',
            'complaint_record' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $result = ComplaintsRaise::select('id','student_name','father_name','mother_name','student_class','student_section','student_shift', 'student_mobile', 'student_complaint', 'student_other_complaint', 'status', 'type', 'created_at', 'updated_at', 'admin_comment')->whereNotNull('student_id');
        if($request->complaint_by){
            $result->where('student_name', 'LIKE', '%'.$request->complaint_by.'%');
        }
        if($request->complaint_date){
            $result->whereDate('created_at', '=', date('Y-m-d', strtotime($request->complaint_date)));
        }
        if($request->complaint_type != 'all'){
            $result->where(['type' => $request->complaint_type]);
        }
        if($request->complaint_record == 'today'){
            $result->whereDate('created_at', '=', date('Y-m-d'));
        }
        if($request->complaint_status != 'all'){
            $result->where('status', '=', $request->complaint_status);
        }        
        $recordList = $result->orderByDesc('id')->get();
        if(count($recordList) > 0){
            $response = [];
            foreach($recordList as $res){
                $postdata['id'] = $res->id;
                $postdata['student_name'] = $res->student_name;
                $postdata['father_name'] = $res->father_name;
                $postdata['mother_name'] = $res->mother_name;
                $postdata['student_class'] = $res->student_class;
                $postdata['student_section'] = $res->student_section;
                $postdata['student_shift'] = $res->student_shift;
                $postdata['student_mobile'] = $res->student_mobile;
                if($res->student_complaint == 0){
                    $postdata['student_complaint'] = 'Other';
                    $postdata['student_other_complaint'] = strip_tags($res->student_other_complaint);
                }
                else{
                    $postdata['student_complaint'] = strip_tags(@$res->complaintType->title);
                    $postdata['student_other_complaint'] = "";
                }
                $postdata['status'] = complaintStatus($res->status);
                $postdata['admin_comment'] = (is_null($res->admin_comment))?"":$res->admin_comment;
                $postdata['created_at'] = vDate($res->updated_at);
                $postdata['complaint_type'] = $res->type;
                $postdata['complaint_status'] = $request->complaint_status;
                $postdata['complaint_record'] = $request->complaint_record;
                $response[] = $postdata;
            }
            return response()->json([
                'status' => true, 
                'data' => $response,
                'type' => $request->complaint_type,
                'message' => $request->complaint_type.' complaint list'
            ], 200);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
                'data' => array(),
            ], 200);
        }
    }

    /***************************************************
     * @Complaint Export
     * *************************************************/
    public function complaintExport(Request $request){
        $validator = Validator::make($request->all(), [
            'complaint_type' => 'required',
            'complaint_status' => 'required',
            'complaint_record' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $file =  Excel::download(new ExportUser, 'users.xlsx');

        return response()->json([
                'status' => true, 
                'data' => $file,
                'message' => 'Complaint exports'
            ], 200);
    }

    /*-------------------------------------------------------------------
    *@function: Class list
    *-------------------------------------------------------------------*/
    public function classesList(Request $request){
        $response = [];
        $data['class_id'] = 'Playgroup';
        $response[] = $data;
        $data['class_id'] = 'Nursery';
        $response[] = $data;
        $data['class_id'] = 'LKG';
        $response[] = $data;
        $data['class_id'] = 'UKG';
        $response[] = $data;
        $data['class_id'] = 'Class I';
        $response[] = $data;
        $data['class_id'] = 'Class II';
        $response[] = $data;
        $data['class_id'] = 'Class III';
        $response[] = $data;
        $data['class_id'] = 'Class IV';
        $response[] = $data;
        $data['class_id'] = 'Class V';
        $response[] = $data;
        $data['class_id'] = 'Class VI';
        $response[] = $data;
        $data['class_id'] = 'Class VII';
        $response[] = $data;
        $data['class_id'] = 'Class VIII';
        $response[] = $data;
        $data['class_id'] = 'Class IX';
        $response[] = $data;
        $data['class_id'] = 'Class X';
        $response[] = $data;
        $data['class_id'] = 'Class XI';
        $response[] = $data;
        $data['class_id'] = 'Class XII';
        $response[] = $data;

        return response()->json([
            'status' => true,
            'message' => 'Classes List',
            'data' => $response
        ], 200);
    }

    /*-------------------------------------------------------------------
    *@function Student login section
    *-------------------------------------------------------------------*/
    public function transportComplaintList(){
        $transportComplaint =  ComplaintsRaise::select('id','student_name','father_name','mother_name','student_class','student_section','student_shift', 'student_mobile', 'student_complaint', 'student_other_complaint', 'status', 'created_at', 'updated_at', 'admin_comment', 'type')->where(['type' => 'Transport'])->orderByDesc('id')->get();
        if(count($transportComplaint) > 0)
        { 
            $response = [];
            $count =0;
            foreach ($transportComplaint as $key => $user) { 
                $userArr = [];
                $count++;
                $userArr['sn'] = $count;
                $userArr['id'] = $user->id;
                $userArr['student_name'] = $user->student_name;
                $userArr['father_name'] = $user->father_name;
                $userArr['mother_name'] = $user->mother_name;
                $userArr['student_mobile'] = $user->student_mobile; 
                $userArr['student_shift'] = $user->student_shift; 
                $userArr['student_class'] = $user->student_class;   
                if($user->student_complaint == 0){
                    $userArr['student_complaint'] = $user->student_other_complaint;
                }
                else{
                    $userArr['student_complaint'] = @$user->complaintType->title;
                }           
                $userArr['status'] = $user->status;
                $userArr['admin_comment'] = str_replace("'","`",$user->admin_comment);
                $userArr['created_at'] = vDate($user->created_at);
                $response[] =$userArr;
            }
            return response()->json([
                'status' => true, 
                'message' => 'Transport complaint list', 
                'data' => $response,
            ], 200); 

        }else{
            return response()->json([
                'status' => false, 
                'message' => 'Record not found', 
                'data' => [],
            ], 200); 
        }
    }
    /*-------------------------------------------------------------------
    *@function Student login section
    *-------------------------------------------------------------------*/
    public function academicComplaintList(){
        $transportComplaint =  ComplaintsRaise::select('id','student_name','father_name','mother_name','student_class','student_section','student_shift', 'student_mobile', 'student_complaint', 'student_other_complaint', 'status', 'created_at', 'updated_at', 'admin_comment')->where(['type' => 'Academic'])->orderByDesc('id')->get();
        if(count($transportComplaint) > 0)
        { 
            $response = [];
            $count =0;
            foreach ($transportComplaint as $key => $user) { 
                $userArr = [];
                $count++;
                $userArr['sn'] = $count;
                $userArr['id'] = $user->id;
                $userArr['student_name'] = $user->student_name;
                $userArr['father_name'] = $user->father_name;
                $userArr['mother_name'] = $user->mother_name;
                $userArr['student_mobile'] = $user->student_mobile; 
                $userArr['student_shift'] = $user->student_shift; 
                $userArr['student_class'] = $user->student_class;   
                if($user->student_complaint == 0){
                    $userArr['student_complaint'] = $user->student_other_complaint;
                }
                else{
                    $userArr['student_complaint'] = @$user->complaintType->title;
                }           
                $userArr['status'] = $user->status;
                $userArr['admin_comment'] = str_replace("'","`",$user->admin_comment);
                $userArr['created_at'] = vDate($user->created_at);
                $response[] =$userArr;
            }
            return response()->json([
                'status' => true, 
                'message' => 'Academic complaint list', 
                'data' => $response,
            ], 200); 

        }else{
            return response()->json([
                'status' => false, 
                'message' => 'Record not found', 
                'data' => [],
            ], 200); 
        }
    }

    /*-------------------------------------------------------------------
    *@function Student login section
    *-------------------------------------------------------------------*/
    public function complaintStatusUpdate(Request $request){
        $status                 = $request->status;
        $complaint_id           = $request->complaint_id;
        $complaint_comment      = $request->complaint_comment;
        $complaintData = ComplaintsRaise::where('id', $complaint_id)->first();
        if(!is_null($complaintData)){
            $complaintData->status = $status;
            $complaintData->admin_comment = $complaint_comment;
            $complaintData->save();
            return response()->json([
                    'status' => true, 
                    'success' => 'success', 
                    'message' => 'Complaint status update successfully', 
                    'data' => array(),
                ], 200);   
        }
        else{
            return response()->json([
                    'status' => true, 
                    'success' => 'danger', 
                    'message' => 'Complaint not found', 
                    'data' => array(),
                ], 200);             
        }
    }

    /*-------------------------------------------------------------------
    *@function Student login section
    *-------------------------------------------------------------------*/
    public function appVersion(Request $request){
        $validator = Validator::make($request->all(), [
            'app_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message' => $validator->messages()->first()], 200);
        } 
        $version = '1.0';
        /* TheISB - Mobile App (iOS) */
        if($request->app_name == '1'){
            $appData = MainSection::where('id', 2)->first();
            $version = $appData->app_version;
        }
        /* TheISB - Mobile App (Android) */
        elseif($request->app_name == '2'){
            $appData = MainSection::where('id', 3)->first();
            $version = $appData->app_version;
        }
        /* TheISB - Helpline App (iOS) */
        elseif($request->app_name == '3'){
            $appData = MainSection::where('id', 4)->first();
            $version = $appData->app_version;
        }
        /* TheISB - Transport Helpline App (Android) */
        elseif($request->app_name == '4'){
            $appData = MainSection::where('id', 5)->first();
            $version = $appData->app_version;
        }
        /* TheISB - Academic Helpline App (Android) */
        elseif($request->app_name == '5'){
            $appData = MainSection::where('id', 6)->first();
            $version = $appData->app_version;
        }

        return response()->json([
                'status' => true, 
                'message' => 'Current app version', 
                'version' => $version,
            ], 200); 
    }

    /***************************************************
     * @Staff notification store
     * *************************************************/
    public function staffNotificationStore($postData){
        $notify = new StaffNotification;
        $notify->staff_id = $postData['staff_id'];
        $notify->notification_id = $postData['notification_id'];
        $notify->device_id = $postData['device_id'];
        $notify->title = $postData['title'];
        $notify->message = $postData['message'];
        $notify->image = $postData['image'];
        $notify->type = $postData['type'];
        $notify->save();
    }

    /********************************************************************************************
     * @Function: Get notification list
    ********************************************************************************************/
    public function staffNotificationList(Request $request){
        $validateUser = Validator::make($request->all(), 
            [
                'token' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => $validateUser->messages()->first()
            ], 200);
        }
        $notifyList = StaffNotification::where('staff_id', $request->token)->orderByDesc('id')->get();
        if(count($notifyList) > 0){
            $response = [];
            foreach($notifyList as $res){
                $post['id'] = $res->id;
                $post['notification_id'] = $res->notification_id;
                $post['title'] = $res->title;
                $post['message'] = $res->message;
                $post['image'] = $res->image;
                $post['type'] = $res->type;
                $post['date_time'] = vDate($res->created_at);
                $response[] = $post;
            }
            return response()->json([
                    'status' => true,
                    'message' => 'Notification list',
                    'data' => $response
                ], 200);
        }
        else{
            return response()->json([
                    'status' => false,
                    'message' => 'Record not found.',
                ], 200);
        }
    }

    /*-------------------------------------------------------------------
    *@function Student login section
    *-------------------------------------------------------------------*/
    public function testNotification(Request $request){
        $userData = User::where('student_id', '3835')->first();
        $title = 'Test';
        $messageData['title']           = $title;
        $messageData['message']         = 'Test notify_msg';
        $messageData['id']              = 1;       
        $messageData['user_id']         = 1;
        $messageData['notify_type']     = 1;
        $messageData['redirection']     = 1;
        $messageData['image']           = '';
        if(!is_null($userData)){
            sendNotification('chy9isygQbe42-DuHNJ036:APA91bFj1TczvhZWqzD6GdERNtITBl9mCeaLvgC4n8vB-DqYDCdfKcJ26V88v4qTxx5AhdFBbN_UvHkWDQL0lDLva0PKWJss86b-BIk5lIMz4kZlA9hlmOvhs2Sxts4eCB7VgobohCLm', $title, $messageData);

        }
        return true;
    }

    /*-------------------------------------------------------------------
    *@function Student login section
    *-------------------------------------------------------------------*/
    public function studentSection($section){
        if($section == 0){
            $result = 'All';
        }
        elseif($section == 1){
            $result = 'A1';
        }
        elseif($section == 2){
            $result = 'A2';
        }
        elseif($section == 3){
            $result = 'A3';
        }
        elseif($section == 4){
            $result = 'A4';
        }
        elseif($section == 5){
            $result = 'A5';
        }
        elseif($section == 6){
            $result = 'A6';
        }
        return @$result;
    }

    /*-------------------------------------------------------------------
    *@function Student login section
    *-------------------------------------------------------------------*/
    public function studentSectionName($section){
        if($section == 'All'){
            $result = 0;
        }
        elseif($section == 'A1'){
            $result = 1;
        }
        elseif($section == 'A2'){
            $result = 2;
        }
        elseif($section == 'A3'){
            $result = 3;
        }
        elseif($section == 'A4'){
            $result = 4;
        }
        elseif($section == 'A5'){
            $result = 5;
        }
        elseif($section == 'A6'){
            $result = 6;
        }
        return @$result;
    }

    /* Send Email */
    public static function send_email($email,$subject,$message)
    {   
        $params = array(

            'to'        => $email,   

            'subject'   => $subject,

            'html'      => $message,

            'from'      => 'support@html.manageprojects.in',
            
            'fromname'  => 'The ISB'

        );

        $request =  'https://api.sendgrid.com/api/mail.send.json';

        $headr = array();

        $pass = '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';

        $headr[] = 'Authorization: Bearer '.$pass;
    
        $session = curl_init($request);

        curl_setopt ($session, CURLOPT_POST, true);

        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

        curl_setopt($session, CURLOPT_HEADER, false);

        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        // add authorization header

        curl_setopt($session, CURLOPT_HTTPHEADER,$headr);

        $response = curl_exec($session);

        curl_close($session);

        return true;
    }
}