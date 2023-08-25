<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\UserLog;

use App\Models\Assignment;
use App\Models\UserNotification;
use App\Models\UserNotificationLogs;

use Illuminate\Http\Request;

use Validator;

class AssignmentsController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $section_arr = [];

        $assignmentList = Assignment::orderByDesc('id')->get();

        return view('backend.assignment.index', [

            'assignmentList' => $assignmentList,

            'section_arr' => $section_arr

        ]);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('backend.assignment.create');

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {
        if($request->homework_type == 'file'){ 
    		$validator = Validator::make($request->all(), [
    			'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'section' => ['required', 'array'],
                'homework_type' => ['required'],
                'title' => ['required'],
    			'assignment' => ['required', 'mimes:pdf,PDF', 'max:20480'],
    		],
            ['assignment.max'=> 'Homework file must not be greater than 20MB']
            );
        }
        elseif($request->homework_type == 'image'){ 
    		$validator = Validator::make($request->all(), [
    			'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'section' => ['required', 'array'],
                'homework_type' => ['required'],
                'title' => ['required'],
    			'image' => ['required', 'mimes:png,jpeg,jpg', 'max:20480'],
    		],
            ['image.max'=> 'Homework file must not be greater than 20MB']
            );
        }
        else{
            $validator = Validator::make($request->all(), [
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'section' => ['required', 'array'],
                'title' => ['required'],
                'homework_type' => ['required'],
                'content' => 'required',
            ]
            );
        }

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $campus = $request->campus;

        $campus_arr = 0; 

        if(!empty($campus))

        {

            $campus_arr = implode(',',$campus);

            if(!in_array('all', $campus))

            {

            } 

        }  

        $shift = $request->shift;

        $shift_arr = 0; 

        if(!empty($shift))

        {

            $shift_arr = implode(',',$shift);

            if(!in_array('all', $shift))

            {

            } 

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



        $assignment = ''; 

        if($request->homework_type == 'file'){

            $uploadImage = vFileUpload($request->file('assignment'), 'images/assignment/');

            if ($uploadImage) {

                $assignment = $uploadImage; 

            } else {

                toastr()->error(__('File Upload error'));

                return back();

            }

        }

        elseif($request->homework_type == 'image'){

            $uploadImage = vImageUpload($request->file('image'), 'images/assignment/', null);

            if ($uploadImage) {

                $assignment = $uploadImage; 

            } else {

                toastr()->error(__('File Upload error'));

                return back();

            }

        }

        else{

            $assignment = $request->content;

        }



        $create = Assignment::create([

            'campus' => $campus_arr, 

            'shift' => $shift_arr,

            'class_id' => $class_arr,

            'section' => $section_arr, 

            'student_id' => $student_ids,

            'title' => $request->title,

            'homework_type' => $request->homework_type,

            'academic_year' => '2023-24',

            'assignment' => $assignment,

        ]); 

        if ($create) {

            $studentListQuery = UserLog::where('status', 1);
            $studentListQuery->where('app_type', 'Mobile');
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
            $app_name_arr = 'Mobile';
            $studentList = $studentListQuery->whereNotNull('device_id')->get();
            $uploadImage = '';
            if(count($studentList) > 0){
                foreach($studentList as $res){
                    if(!empty($res->device_id)){
                        $redirection = [];
                        $arr = $res->device_id;
                        $title = $request->title;
                        $messageData["message"]         = 'Your homework is updated.';
                        $messageData["id"]              = $create->id;       
                        $messageData["user_id"]         = $res->student_id;
                        $messageData["notify_type"]     = '3';
                        //$messageData["redirection"]   = $create->id;
                        $redirection["id"] = $create->id;
                        $redirection["homework_type"] = $request->homework_type;
                        $redirection["title"] = $request->title;
                        $redirection["assignment"] = $assignment;
                        $messageData["redirection"]     = $redirection;
                        $messageData["title"]           = 'Dear Student,';
                        if($uploadImage != ''){
                            $messageData["image"]       = $uploadImage;
                        }
                        else{
                            $messageData["image"]       = '';
                        }
                        if(!in_array($arr,$studentDeviceArr))
                        {
                            $studentDeviceArr[] = $arr;
                            sendNotification($arr, $title, $messageData); 
                        }
                        $notifyData['notification_id']  = $create->id;
                        $notifyData['device_id']        = $res->device_id;
                        $notifyData['user_id']          = '4';
                        $notifyData['student_id']       = $res->student_id;
                        $notifyData['title']            = 'Dear Student,';
                        $notifyData['type']             = $app_name_arr;
                        $notifyData['type_for']         = 'homework';
                        $notifyData['message']          = 'Your homework is updated.';
                        $notifyData['image']            = '';

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
            return redirect()->route('admin.homework.index');
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

    public function show(Assignment $assignment)

    {

        return abort(404);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Assignment  $assignment

     * @return \Illuminate\Http\Response

     */

    public function edit(Assignment $homework)

    { 

        $campus_arr = explode(',', $homework->campus);

        $shift_arr = explode(',', $homework->shift);

        if($homework->class_id ==0){

            $class_arr = ['Playgroup','Nursery','LKG','UKG','Class I','Class II','Class III','Class IV','Class V','Class VI','Class VII','Class VIII','Class IX','Class X', 'Class XI', 'Class XII'];

        }

        else{

            $class_arr = explode(',', $homework->class_id);

        }

        if($homework->section ==0){

            $section_arr = ['1','2','3','4','5','6'];

        }

        else{

            $section_arr = explode(',', $homework->section);

        }

        return view('backend.assignment.edit', ['homework' => $homework, 'campus_arr' => $campus_arr, 'shift_arr' => $shift_arr, 'class_arr' => $class_arr, 'section_arr' => $section_arr]);

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Assignment  $assignment

     * @return \Illuminate\Http\Response

     */



    public function update(Request $request, Assignment $homework)
    { 
        if($request->homework_type == 'file'){ 

            if ($request->has('assignment')) {

                $validator = Validator::make($request->all(), [

                    'campus' => ['required', 'array'],

                    'shift' => ['required', 'array'],

                    'homework_type' => ['required'],

                    'student_id' => ['required', 'array'],

                    'class_id' => ['required', 'array'],

                    'title' => ['required'],

                    'assignment' => ['required', 'mimes:pdf,PDF', 'max:20480'],

                ],

                ['assignment.max'=> 'Homework file must not be greater than 20MB']

                );

            }else{

                $validator = Validator::make($request->all(), [

                    'campus' => ['required', 'array'],

                    'shift' => ['required', 'array'],

                    'homework_type' => ['required'],

                    'student_id' => ['required', 'array'],

                    'class_id' => ['required', 'array'],

                    'title' => ['required'], 

                ]

                ); 

            }

        }
        elseif($request->homework_type == 'image'){ 
            $validator = Validator::make($request->all(), [
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'section' => ['required', 'array'],
                'homework_type' => ['required'],
                'title' => ['required'],
                'image' => ['mimes:png,jpeg,jpg', 'max:20480'],
            ],
            ['image.max'=> 'Homework file must not be greater than 20MB']
            );
        }
        else{

            $validator = Validator::make($request->all(), [

                    'campus' => ['required', 'array'],

                    'shift' => ['required', 'array'],

                    'class_id' => ['required', 'array'], 

                    'student_id' => ['required', 'array'],

                    'title' => ['required'],

                    'homework_type' => ['required'],

                    'content' => 'required',

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

        unset($data['student_id']);

        unset($data['assignment']);

        $campus = $request->campus;

        $campus_arr = 0; 

        if(!empty($campus))

        {

            $campus_arr = implode(',',$campus);

            if(!in_array('all', $campus))

            {

            } 

        }  

        $shift = $request->shift;

        $shift_arr = 0; 

        if(!empty($shift))

        {

            $shift_arr = implode(',',$shift);

            if(!in_array('all', $shift))

            {

            } 

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



        $assignment = ''; 

        $postData['campus'] = $campus_arr;

        $postData['shift'] = $shift_arr;

        $postData['class_id'] = $class_arr;

        $postData['section'] = $section_arr;

        $postData['student_id'] = $student_ids;

        $postData['title'] = $request->title;

        $postData['homework_type'] = $request->homework_type;

        if($request->homework_type == 'file'){

            if($request->has('assignment'))
            {
                $uploadImage = vFileUpload($request->file('assignment'), 'images/assignment/');

                if ($uploadImage) {

                    $data['assignment'] = $uploadImage; 

                    $postData['assignment'] = $uploadImage; 

                } else {

                    toastr()->error(__('File Upload error'));

                    return back();

                }

            }

        }
        elseif($request->homework_type == 'image'){
            if($request->has('image')){
                $uploadImage = vImageUpload($request->file('image'), 'images/assignment/', null);
                if ($uploadImage) {
                    $assignment = $uploadImage; 
                    $data['assignment'] = $uploadImage; 
                    $postData['assignment'] = $uploadImage; 
                } else {
                    toastr()->error(__('File Upload error'));
                    return back();
                }                
            }

        }
        else{

            $data['assignment'] = $request->content;

            $postData['assignment'] = $request->content;

        } 

        if(array_key_exists('status', $data))

        {

            if($data['status'] == 'on')

            {

                $data['status'] = 1;

                $postData['status'] = 1;

            }else{

                $data['status'] = 0;

                $postData['status'] = 0;

            }

        }else{

            $data['status'] = 0;

            $postData['status'] = 0;

        }



        $update = $homework->update($postData); 

        

        if ($update) {



            toastr()->success(__('Updated Successfully'));



            return redirect()->route('admin.homework.index');



        }else {

            toastr()->error(__('Updating error'));

            return back();

        } 

		 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Assignment  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $homework) 
    {
        if($homework)
        {
            removeFile($homework->assignment);			
            $homework->delete();
            UserNotification::where(['notification_id' => $homework->id, 'type_for' => 'homework'])->delete();
            UserNotificationLogs::where(['notification_id' => $homework->id, 'type_for' => 'homework'])->delete();
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



