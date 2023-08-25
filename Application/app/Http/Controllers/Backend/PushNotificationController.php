<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UserLog;
use App\Models\Redirection;
use App\Models\UserNotification;
use App\Models\UserNotificationLogs;
use App\Models\NotificationTemplate;
use App\Models\SendPushNotification;

use Illuminate\Http\Request;

use Validator;

class PushNotificationController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        $notificationList = SendPushNotification::orderByDesc('id')->get();
        return view('backend.push-notification.index', [
            'notificationList' => $notificationList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notificationList = NotificationTemplate::where('status', 1)->get();
        $redirectionList = Redirection::where('status', 1)->get();
        return view('backend.push-notification.create', ['notificationList' => $notificationList, 'redirectionList' => $redirectionList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'campus' => ['required', 'array'],
            'shift' => ['required', 'array'],
            'class_id' => ['required', 'array'],
            'section' => ['required', 'array'],
            'student_id' => ['required', 'array'],
            'title' => ['required'],
            'image' => ['mimes:png,PNG,jpg,JPG,jpeg,JPEG', 'max:10240'],
		],
        ['image.max'=> 'Image must not be greater than 10MB']
        );        
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $app_name = $request->app_name;
        $app_name_arr = 0; 
        if(!empty($app_name))
        {
            $app_name_arr = implode(',',$app_name);
        }  
        $campus = $request->campus;
        $campus_arr = 0; 
        if(!empty($campus))
        {
            $campus_arr = implode(',',$campus);
        }  
        $shift = $request->shift;
        $shift_arr = 0; 
        if(!empty($shift))
        {
            $shift_arr = implode(',',$shift);
        }   
        $class_id = $request->class_id;
        $class_arr = 0; 
        if(!empty($class_id))
        {
            $class_arr = implode(',',$class_id);
        }  
        $student_id = $request->student_id;
        $student_ids = 0;
        if(!empty($student_id))
        {
            if(!in_array('all', $student_id))
            {
                $student_ids = implode(',',$student_id);
            }
            else{
                $student_ids = '0';
            }
        } 
        $section = $request->section;
        $section_arr = 0; 
        if(!empty($section))
        {            
            if(!in_array('all', $section))
            {
                $section_arr = implode(',',$section);
            }
            else{
                $section_arr = '0';
            } 
        }  
        $uploadImage = '';
        if ($request->has('image')) {
            $uploadImage = vImageUpload($request->file('image'), 'images/notification/', null, null);
        }
        $template_id = 0;
        if($request->template_id != ''){
            $template_id = $request->template_id;
        }
        $create = SendPushNotification::create([
            'app_name' => $app_name_arr, 
            'campus' => $campus_arr, 
            'shift' => $shift_arr,
            'class_id' => $class_arr,
            'section' => $section_arr, 
            'student_id' => $student_ids,
            'title' => $request->title,
            'template_id' => $template_id,
            'message' => $request->message,
            'redirection' => $request->redirection,
            'academic_year' => '2023-24',
            'image' => $uploadImage,
        ]); 
        if ($create) {
            $studentListQuery = UserLog::where('status', 1);
            if($app_name_arr == 'Mobile'){
                $studentListQuery->where('app_type', 'Mobile');
            }
            elseif($app_name_arr == 'Both'){
                $studentListQuery->where('app_type', '<>', 'Mobile');
            }
            else{
                $studentListQuery->where('app_type', '<>', 'Mobile');
            }
            if(!empty($campus))
            {
                $studentListQuery->whereIn('campus', $campus);
            }
            if(!empty($shift))
            {
                $studentListQuery->whereIn('shift', $shift);
            }
            if(!in_array('all', $section))
            {
                $studentListQuery->whereIn('section', $section);
            }
            if(!in_array('all', $student_id))
            {
                $studentListQuery->whereIn('student_id', $student_id);
            }
            $studentCheckArr =[];
            $studentDeviceArr =[];
            $studentList = $studentListQuery->whereNotNull('device_id')->get();
            if(count($studentList) > 0){
                foreach($studentList as $res){
                    if(!empty($res->device_id)){
                        $arr = $res->device_id;
                        $title = $request->title;
                        $messageData['message']         = $request->message;
                        $messageData['id']              = $create->id;       
                        $messageData['user_id']         = $res->user_id;
                        $messageData['notify_type']     = '7';
                        $messageData['redirection']     = $request->redirection;
                        $messageData['title']           = $request->title;
                        if($uploadImage != ''){
                            $messageData['image']       = $uploadImage;
                        }
                        else{
                            $messageData['image']       = '';
                        }
                        if(!in_array($arr,$studentDeviceArr))
                        {
                            $studentDeviceArr[] = $arr;
                            sendNotification($arr, $title, $messageData); 
                        }
                        $notifyData['notification_id']  = $create->id;
                        $notifyData['device_id']        = $res->device_id;
                        $notifyData['user_id']          = $res->user_id;
                        $notifyData['student_id']       = $res->student_id;
                        $notifyData['title']            = $create->title;
                        $notifyData['type']             = $app_name_arr;
                        $notifyData['message']          = $create->message;
                        $notifyData['image']            = $create->image;

                        if(!in_array($res->student_id,$studentCheckArr))
                        {
                            $studentCheckArr[] = $res->student_id;
                            notificationStore($notifyData, 1);
                        }else{
                            notificationStore($notifyData, 2);
                        }
                    }
                }
            }

            toastr()->success(__('Created Successfully'));
            return redirect()->route('admin.pushNotification.index');
        }else {
            toastr()->error(__('Creating error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(SendPushNotification $notification)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(SendPushNotification $pushNotification)
    { 
        $campus_arr = explode(',', $pushNotification->campus);
        $shift_arr = explode(',', $pushNotification->shift);
        $app_name_arr = explode(',', $pushNotification->app_name);
        $notificationList = NotificationTemplate::where('status', 1)->get();
        $redirectionList = Redirection::where('status', 1)->get();
        if($pushNotification->class_id ==0){
            $class_arr = ['Playgroup','Nursery','LKG','UKG','Class I','Class II','Class III','Class IV','Class V','Class VI','Class VII','Class VIII','Class IX','Class X', 'Class XI', 'Class XII'];
        }
        else{
            $class_arr = explode(',', $pushNotification->class_id);
        }
        if($pushNotification->section ==0){
            $section_arr = ['1','2','3','4','5','6'];
        }
        else{
            $section_arr = explode(',', $pushNotification->section);
        }
        return view('backend.push-notification.edit', ['notification' => $pushNotification, 'campus_arr' => $campus_arr, 'shift_arr' => $shift_arr, 'class_arr' => $class_arr, 'section_arr' => $section_arr, 'app_name_arr' => $app_name_arr, 'notificationList' => $notificationList, 'redirectionList' => $redirectionList]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, SendPushNotification $pushNotification)
    { 
        if ($request->has('image')) {
            $validator = Validator::make($request->all(), [
                'app_name' => ['required', 'array'],
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'title' => ['required'],
                'image' => ['required', 'mimes:png,PNG,jpg,JPG,jpeg,JPEG', 'max:10240'],
            ],
            ['image.max'=> 'Image must not be greater than 10MB']
            );
        }else{
            $validator = Validator::make($request->all(), [
                'app_name' => ['required', 'array'],
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'title' => ['required'], 
            ]
            ); 
        }	 
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $data = $request->all();
        $app_name = $request->app_name;
        $app_name_arr = 0;
        if(!empty($app_name))
        {
            $app_name_arr = implode(',',$app_name);
        }  
        $campus = $request->campus;
        $campus_arr = 0; 
        if(!empty($campus))
        {
            $campus_arr = implode(',',$campus);
        }  
        $shift = $request->shift;
        $shift_arr = 0; 
        if(!empty($shift))
        {
            $shift_arr = implode(',',$shift);
        }   
        $class_id = $request->class_id;
        $class_arr = 0; 
        if(!empty($class_id))
        {
            $class_arr = implode(',',$class_id);
            if(!in_array('all', $class_id))
            {
            } 
        }  
        $student_id = $request->student_id;
        $student_ids = 0; 
        if(!empty($student_id))
        {
            if(!in_array('all', $student_id))
            {
                $student_ids = implode(',',$student_id);
            }
            else{
                $student_ids = '0';
            }
        } 
        $section = $request->section;
        $section_arr = 0; 
        if(!empty($section))
        {
            if(!in_array('all', $section))
            {
                $section_arr = implode(',',$section);
            }
            else{
                $section_arr = '0';
            } 
        } 
        $template_id = 0;
        if($request->template_id != ''){
            $template_id = $request->template_id;
        }
        $postData['app_name'] = $app_name_arr;
        $postData['campus'] = $campus_arr;
        $postData['shift'] = $shift_arr;
        $postData['class_id'] = $class_arr;
        $postData['section'] = $section_arr;
        $postData['student_id'] = $student_ids;
        $postData['title'] = $request->title;
        $postData['template_id'] = $template_id;
        $postData['message'] = $request->message;
        $postData['redirection'] = $request->redirection;
        $uploadImage ='';
        if($request->has('image'))
        {
            $uploadImage = vImageUpload($request->file('image'), 'images/notification/', null, null, $pushNotification->image);
            if ($uploadImage) {
                $postData['image'] = $uploadImage; 
            }
        }
        //$arr = 'dsF_dUy6QIicpDEggaJzay:APA91bGiWLXtt1xI1HK0fKlv19kLElXOeJq1ylUOAKor8Ax_p8UBu9rv4HWtMmjTqxLQnYCvmXHv6yLnXiC-_fPDCGEdnxl8Rc7yxzbZRLTc9L4KGqRUFoHgayFVkIppxzwEqI_orqKC'; // Chandres
        //$arr = 'fL_OTl1rQPuaAxsbBseUBE:APA91bEMmEhyytkTfh0Yy5Y2idZlumEPQOlpq7ddw2r3zuLfvtbk6G3AvMN5egW0Eek67sKDBhAPSSFtYRji0oWR4-vg9-xN0PUAE-9CXN144So0G9g7J85TNetFsLtndnw3uQYywwkt';
        $userData = User::where('student_id', '3835')->first();
        $arr = $userData->device_id;
        $title = $request->title;
        $messageData['id']              = $pushNotification->id;       
        $messageData['user_id']         = 1;
        $messageData['title']           = $request->title;
        $messageData['message']         = $request->message;
        $messageData['notify_type']     = 1;
        $messageData['redirection']     = $request->redirection;
        if($uploadImage != ''){
            $messageData['image']       = 'https://mobile.theisb.in/'.$uploadImage;
        }
        else{
            $messageData['image']       = '';
        }
        sendNotification($arr, $title, $messageData);
        if(array_key_exists('status', $data))
        {
            if($data['status'] == 'on')
            {
                $postData['status'] = 1;
            }else{
                $postData['status'] = 0;
            }
        }else{
            $postData['status'] = 0;
        }
        $update = $pushNotification->update($postData); 
        if ($update) {
            toastr()->success(__('Updated Successfully'));
        }
        return redirect()->route('admin.pushNotification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(SendPushNotification $pushNotification) 
    {
        if($pushNotification)
        {
            removeFile($pushNotification->image);			
            $pushNotification->delete();
            UserNotification::where('notification_id', $pushNotification->id)->delete();
            UserNotificationLogs::where('notification_id', $pushNotification->id)->delete();
            toastr()->success(__('Deleted Successfully'));
        }else{ 
            toastr()->error(__('Data Not Found'));
        } 
        return back();
    }

    /***************************************************************
     * @ Get ISB User List
     * *************************************************************/
    public function getIsbUserList(Request $request)
    { 
        $client = new \GuzzleHttp\Client();
        $select_all = '';
        if(isset($request->select_all))
        {
            $select_all = 1;
        }

        $request = $client->post('https://www.theisb.in/students/api/apiController/getHomeworkAllStudentList/', [
                'form_params' => [
                    'cumpus' => (string)$request->cumpus,
                    'shift' => (string)$request->shift,
                    'class_id' => (string)$request->class_id,
                    'section' => (string)$request->section,
                    'select_all' => $select_all
                ]
            ]
        );
        
        $response = $request->getBody()->getContents();
        $studentList = json_decode($response);
       
        if($studentList->status == 1)
        { 
            $studentRecord = $studentList->result; 
            return response()->json([
                'status' => 1, 
                'message' => $studentList->message, 
                'studentList' => $studentRecord,
            ], 200); 

        }else{
            return response()->json([
                'status' => 0, 
                'message' => $studentList->message, 
                'studentList' => [],
            ], 200); 
        }        
    }

    /***************************************************************
     * @ All Student list
     * *************************************************************/
    public function allStudentList(Request $request)
    { 
        $client = new \GuzzleHttp\Client();
        $select_all = '';
        if(isset($request->select_all))
        {
            $select_all = 1;
        }

        $request = $client->post('https://www.theisb.in/students/api/apiController/getAllStudentList/', [
                'form_params' => [
                    'cumpus' => $request->cumpus,
                    'shift' => $request->shift,
                    'class_id' => $request->class_id,
                    'section' => $request->section,
                    'select_all' => $select_all
                ]
            ]
        );
        
        $response = $request->getBody()->getContents();
        $studentList = json_decode($response);
       
        if($studentList->status == 1)
        { 
            $studentRecord = $studentList->result; 
            return response()->json([
                'status' => 1, 
                'message' => $studentList->message, 
                'studentList' => $studentRecord,
            ], 200); 

        }else{
            return response()->json([
                'status' => 0, 
                'message' => $studentList->message, 
                'studentList' => [],
            ], 200); 
        }        
    }
}

