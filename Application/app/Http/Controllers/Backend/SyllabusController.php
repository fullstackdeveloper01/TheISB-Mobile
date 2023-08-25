<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\UserLog;
use App\Models\Syllabus;
use App\Models\UserNotification;
use App\Models\UserNotificationLogs;

use Illuminate\Http\Request;

use Validator;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $syllabusList = Syllabus::where('type', 0)->orderby('id', 'asc')->get();
        return view('backend.syllabus.index', [
            'syllabusList' => $syllabusList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.syllabus.create');
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
            'student_id' => ['required', 'array'],
			'class_name' => ['required', 'array'],
            'section' => ['required', 'array'],
			'image' => ['required', 'mimes:pdf,PDF', 'max:7128'],
		],
        ['image.max'=> 'Syllabus must not be greater than 7MB']
        );
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
        }
        $shift = $request->shift;
        $shift_arr = 0; 
        if(!empty($shift))
        {
            $shift_arr = implode(',',$shift);
        }
        $class_id = $request->class_name;
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
        $academic_year = '2023-24';
        $existingRecord = Syllabus::where(['class_name' => $request->class_name, 'academic_year' => $academic_year, 'campus' => $request->campus, 'shift' => $request->shift, 'section' => $request->section])->where('type', 0)->count();
        if($existingRecord == 0){
            $uploadImage = vFileUpload($request->file('image'), 'images/syllabus/');
            if ($uploadImage) {
                $create = Syllabus::create([
                    'class_name' => $class_arr,
                    'campus' => $campus_arr,
                    'shift' => $shift_arr,
                    'section' => $section_arr,
                    'academic_year' => $academic_year,
                    'student_id' => $student_ids,
                    'type' => 0,
                    'syllabus' => $uploadImage,
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
                                $messageData['message']         = 'Your syllabus is updated.';
                                $messageData['id']              = $create->id;       
                                $messageData['user_id']         = $res->user_id;
                                $messageData['notify_type']     = '4';
                                //$messageData['redirection']     = $create->id;
                                $redirection['id'] = $create->id;
                                $messageData['title']           = 'Dear Student,';
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
                                $notifyData['title']            = 'Dear Student,';
                                $notifyData['type']             = $app_name_arr;
                                $notifyData['type_for']         = 'syllabus';
                                $notifyData['message']          = 'Your syllabus is updated.';
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
                    return redirect()->route('admin.syllabus.index');
                }
            } else {
                toastr()->error(__('Upload error'));
                return back();
            }
        }
        else{
            toastr()->error(__('Syllabus is already added for this class'));
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function show(Syllabus $syllabus)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function edit($sid)
    {
        $syllabus = Syllabus::where('id', $sid)->first();
        $campus_arr = explode(',', $syllabus->campus);
        $shift_arr = explode(',', $syllabus->shift);
        if($syllabus->class_name ==0){
            $class_arr = ['Playgroup','Nursery','LKG','UKG','Class I','Class II','Class III','Class IV','Class V','Class VI','Class VII','Class VIII','Class IX','Class X', 'Class XI', 'Class XII'];
        }
        else{
            $class_arr = explode(',', $syllabus->class_name);
        }
        if($syllabus->section ==0){
            $section_arr = ['1','2','3','4','5','6'];
        }
        else{
            $section_arr = explode(',', $syllabus->section);
        }
        return view('backend.syllabus.edit', ['syllabus' => $syllabus, 'campus_arr' => $campus_arr, 'shift_arr' => $shift_arr, 'class_arr' => $class_arr, 'section_arr' => $section_arr]);
    }


    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Syllabus  $syllabus

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Syllabus $syllabuss)
    {
    	if ($request->has('image')) {
            $validator = Validator::make($request->all(), [
                'syllabus_id' => ['required'],
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'class_name' => ['required', 'array'],
                'section' => ['required', 'array'],
                'image' => ['required', 'mimes:pdf,PDF', 'max:7128'],
            ],
            ['image.max'=> 'Syllabus must not be greater than 7MB']
            );
        }else{
            $validator = Validator::make($request->all(), [
                'syllabus_id' => ['required'],
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'class_name' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'section' => ['required', 'array'],
                'image' => ['mimes:pdf,PDF', 'max:7128'],
                ],
                ['image.max'=> 'Syllabus must not be greater than 7MB']
            );
        }
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
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
        $class_id = $request->class_name;
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
        $syllabus = Syllabus::where('id', $request->syllabus_id)->first();
		if ($request->has('image')) {
			$uploadImage = vFileUpload($request->file('image'), 'images/syllabus/');
		} else {
			$uploadImage = $syllabus->syllabus;
		}
		if ($uploadImage) {
            $status = ($request->has('status')) ? 1 : 0;
			$update = $syllabus->update([
				'class_name' => $class_arr,
                'campus' => $campus_arr,
                'student_id' => $student_ids,
                'shift' => $shift_arr,
                'section' => $section_arr,
                'status' => $status,
                'syllabus' => $uploadImage,
			]);
			if ($update) {
				toastr()->success(__('Updated Successfully'));
				return redirect()->route('admin.syllabus.index');
			}
		} else {
			toastr()->error(__('Upload error'));
			return back();
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) 
    {
        $syllabus_id = $request->syllabus_id;
        $syllabus = Syllabus::where('id', $syllabus_id)->first();
        if($syllabus)
        {
            removeFile($syllabus->syllabus);			
            $syllabus->delete();
            UserNotification::where(['notification_id' => $syllabus->id, 'type_for' => 'syllabus'])->delete();
            UserNotificationLogs::where(['notification_id' => $syllabus->id, 'type_for' => 'syllabus'])->delete();
            toastr()->success(__('Deleted Successfully'));
        }else{ 
            toastr()->error(__('Data Not Found'));
        }
        return back();
    }
}

