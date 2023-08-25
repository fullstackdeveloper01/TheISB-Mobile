<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\UserLog;
use App\Models\Syllabus;
use App\Models\UserNotification;
use App\Models\UserNotificationLogs;

use Illuminate\Http\Request;

use Validator;

use Illuminate\Support\Facades\DB;

class AcademicTimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $syllabusList = Syllabus::where('type', 1)->orderby('id', 'asc')->get();
        return view('backend.academic-time-table.index', [
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
        return view('backend.academic-time-table.create');
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
            'class_name' => ['required', 'array'],
            'student_id' => ['required', 'array'],
            'image' => ['required', 'mimes:pdf,PDF', 'max:7128'],
            'section' => ['required', 'array'],
        ],
        ['image.max'=> 'Syllabus must not be greater than 7MB']
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $academic_year = '2023-24';
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
            $class_arr = implode(',',$class_name);
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
        $existingRecord = Syllabus::where(['class_name' => $request->class_name, 'academic_year' => $academic_year, 'campus' => $request->campus, 'shift' => $request->shift, 'section' => $request->section])->where('type', 1)->count();
        if($existingRecord == 0){
            $uploadImage = vFileUpload($request->file('image'), 'images/syllabus/');
            if ($uploadImage) {
                $create = Syllabus::create([
                    'class_name' => $class_arr,
                    'campus' => $campus_arr,
                    'shift' => $shift_arr,
                    'section' => $section_arr,
                    'student_id' => $student_ids,
                    'academic_year' => $academic_year,
                    'type' => 1,
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
                    if(count($studentList) > 0){
                        foreach($studentList as $res){
                            if(!empty($res->device_id)){
                                $redirection = [];
                                $arr = $res->device_id;
                                $title = $request->title;
                                $messageData['message']         = 'Your exam time table is updated.';
                                $messageData['id']              = $create->id;       
                                $messageData['user_id']         = $res->student_id;
                                $messageData['notify_type']     = '6';
                                
                                $redirection['id']              = $create->id;
                                $redirection['notice_type']     = $request->notice_type;
                                $redirection['title']           = $request->title;
                                $redirection['content']         = $uploadImage;
                                $messageData['redirection']     = $redirection;
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
                                $notifyData['type_for']         = 'time-table';
                                $notifyData['message']          = 'Your exam time table is updated.';
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
                    return redirect()->route('admin.academicTimeTable.index');
                }
            } else {
                toastr()->error(__('Upload error'));
                return back();
            }
        }
        else{
            toastr()->error(__('Time Table is already added for this class'));
            return back()->withInput();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function academicContentList(Request $request)
    {
        $syllabusList = Syllabus::where('type', 2)->orderby('id', 'asc')->get();
        return view('backend.academic-time-table.academic_content', [
            'syllabusList' => $syllabusList
        ]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function academicContenSave(Request $request)
    {

		$validator = Validator::make($request->all(), [

			'class_name' => ['required'],
            'academic_year' => ['required'],
			'image' => ['required', 'mimes:pdf,PDF', 'max:5120'],

		],
        ['image.max'=> 'Academic Content must not be greater than 5MB']
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $existingRecord = Syllabus::where(['class_name' => $request->class_name, 'academic_year' => $request->academic_year])->where('type', 2)->count();
        if($existingRecord == 0){
            $uploadImage = vFileUpload($request->file('image'), 'images/syllabus/');
            if ($uploadImage) {
                $create = Syllabus::create([
                    'class_name' => $request->class_name,
                    'academic_year' => $request->academic_year,
                    'syllabus' => $uploadImage,
                    'type' => 2,
                ]);
                if ($create) {
                    toastr()->success(__('Created Successfully'));
                    return redirect()->route('admin.academicContentList');
                }
            } else {
                toastr()->error(__('Upload error'));
                return back();
            }
        }
        else{
            toastr()->error(__('Time Table is already added for this class'));
            return back()->withInput();
        }
    }

    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Syllabus  $syllabus

     * @return \Illuminate\Http\Response

     */

    public function show(Syllabus $academicTimeTable)

    {

        return abort(404);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Syllabus  $syllabus

     * @return \Illuminate\Http\Response

     */

    public function edit(Syllabus $academicTimeTable)
    {
        $campus_arr = explode(',', $academicTimeTable->campus);
        $shift_arr = explode(',', $academicTimeTable->shift);
        if($academicTimeTable->class_name ==0){
            $class_arr = ['Playgroup','Nursery','LKG','UKG','Class I','Class II','Class III','Class IV','Class V','Class VI','Class VII','Class VIII','Class IX','Class X', 'Class XI', 'Class XII'];
        }
        else{
            $class_arr = explode(',', $academicTimeTable->class_name);
        }
        if($academicTimeTable->section ==0){
            $section_arr = ['1','2','3','4','5','6'];
        }
        else{
            $section_arr = explode(',', $academicTimeTable->section);
        }
        return view('backend.academic-time-table.edit', ['syllabus' => $academicTimeTable, 'campus_arr' => $campus_arr, 'shift_arr' => $shift_arr, 'class_arr' => $class_arr, 'section_arr' => $section_arr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Syllabus $academicTimeTable)
    {
        $syllabus = $academicTimeTable;
		if ($request->has('image')) {
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
        }else{
            $validator = Validator::make($request->all(), [
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
                return redirect()->route('admin.academicTimeTable.index');
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
    public function destroy(Syllabus $academicTimeTable)
    { 
		removeFile($academicTimeTable->syllabus);		
        $academicTimeTable->delete();
        UserNotification::where(['notification_id' => $academicTimeTable->id, 'type_for' => 'time-table'])->delete();
        UserNotificationLogs::where(['notification_id' => $academicTimeTable->id, 'type_for' => 'time-table'])->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }

    /*********************************************
     * @Change status
     * ********************************************/
    public function changeStatus(Request $request){
        $id = $request->id;
        $status = $request->status;
        $table = $request->table;
        $result = DB::table($table)->where('id', $id)->first();
        if(!is_null($result)){
            DB::table($table)->where('id', $id)->update(['status' => $status]);
            return response()->json = [
               'status' => true,
               'message' => trans('Status Chanaged Successfully'),
            ];
        }
        else{
            return response()->json = [
               'status' => false,
               'message' => trans('Status Not Changed Successfully'),
            ];
        }
    }

}

