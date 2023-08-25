<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\UserLog;
use App\Models\NoticeBoard;
use App\Models\UserNotification;
use App\Models\UserNotificationLogs;
use Illuminate\Http\Request;
use Validator;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $noticeBoardList = NoticeBoard::orderbyDesc('id')->get();
        return view('backend.notice-board.index', [
            'noticeBoardList' => $noticeBoardList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.notice-board.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if($request->notice_type == 1){
			$validator = Validator::make($request->all(), [
				'title' => ['required', 'string', 'max:255', 'min:2'],
                'notice_type' => ['required'],
                'notice_date' => ['required'],
				'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:7168'],
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'], 
                'student_id' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'section' => ['required', 'array'],
			]);
		}
        if($request->notice_type == 2){
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'notice_type' => ['required'],
                'notice_date' => ['required'],
                'image' => ['required', 'mimes:pdf', 'max:7168'],
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'], 
                'student_id' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'section' => ['required', 'array'],
            ]);
        }
		else{
			$validator = Validator::make($request->all(), [
				'title' => ['required', 'string', 'max:255', 'min:2'],
				'notice_type' => ['required'],
                'notice_date' => ['required'],
                'content' => ['required'],
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'], 
                'student_id' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'section' => ['required', 'array'],
			]);			
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
        try {            
            if($request->notice_type == 1){
                $uploadImage = vImageUpload($request->file('image'), 'images/notice-board/', null);
                if ($uploadImage) {
                    $create = NoticeBoard::create([
                        'title' => $request->title,
                        'notice_type' => $request->notice_type,
                        'notice_date' => $request->notice_date,
                        'image' => $uploadImage,
                        'content' => '',
                        'short_description' => $request->short_description,
                        'campus' => $campus_arr, 
                        'shift' => $shift_arr,
                        'class_id' => $class_arr,
                        'section' => $section_arr, 
                        'student_id' => $student_ids,
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
                                $redirection = [];
                                $arr = $res->device_id;
                                $title = $request->title;
                                $messageData['message']         = 'Here is the new notice for you.';
                                $messageData['id']              = $create->id;       
                                $messageData['user_id']         = $res->user_id;
                                $messageData['notify_type']     = '1';
                                //$messageData['redirection']     = $create->id;
                                $redirection['id'] = $create->id;
                                $redirection['notice_type'] = $request->notice_type;
                                $redirection['title'] = $request->title;
                                $redirection['content'] = $uploadImage;
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
                                $notifyData['type_for']         = 'notice-board';
                                $notifyData['message']          = 'Here is the new notice for you.';
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
                        
                        toastr()->success(__('Created Successfully'));
                        return redirect()->route('admin.noticeBoard.index');
                    }
                } else {
                    toastr()->error(__('Find some error'));
                    return back();
                }
            }
            elseif($request->notice_type == 2){
                $uploadImage = vFileUpload($request->file('image'), 'images/notice-board/');
                if ($uploadImage) {
                    $create = NoticeBoard::create([
                        'title' => $request->title,
                        'notice_type' => $request->notice_type,
                        'notice_date' => $request->notice_date,
                        'image' => $uploadImage,
                        'content' => '',
                        'short_description' => $request->short_description,
                        'campus' => $campus_arr, 
                        'shift' => $shift_arr,
                        'class_id' => $class_arr,
                        'section' => $section_arr, 
                        'student_id' => $student_ids,
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
                                    $messageData['message']         = 'Here is the new notice for you.';
                                    $messageData['id']              = $create->id;       
                                    $messageData['user_id']         = $res->student_id;
                                    $messageData['notify_type']     = '1';
                                    //$messageData['redirection']     = $create->id;
                                    $redirection['id'] = $create->id;
                                    $redirection['notice_type'] = $request->notice_type;
                                    $redirection['title'] = $request->title;
                                    $redirection['content'] = $uploadImage;
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
                                    $notifyData['type_for']         = 'notice-board';
                                    $notifyData['message']          = 'Here is the new notice for you.';
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
                        return redirect()->route('admin.noticeBoard.index');
                    }
                } else {
                    toastr()->error(__('Find some error'));
                    return back();
                }
            }
            else{
                $create = NoticeBoard::create([
                    'title' => $request->title,
                    'notice_type' => $request->notice_type,
                    'notice_date' => $request->notice_date,
                    'image' => '',
                    'content' => $request->content,
                    'short_description' => $request->short_description,
                    'campus' => $campus_arr, 
                    'shift' => $shift_arr,
                    'class_id' => $class_arr,
                    'section' => $section_arr, 
                    'student_id' => $student_ids,
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
                                $redirection = [];
                                $arr = $res->device_id;
                                $title = $request->title;
                                $messageData['message']         = 'Here is the new notice for you.';
                                $messageData['id']              = $create->id;       
                                $messageData['user_id']         = $res->student_id;
                                $messageData['notify_type']     = '1';
                                //$messageData['redirection']     = $create->id;
                                $redirection['id'] = $create->id;
                                $redirection['notice_type'] = $request->notice_type;
                                $redirection['title'] = $request->title;
                                $redirection['content'] = $request->content;
                                $messageData['redirection']     = $redirection;
                                $messageData['title']           = 'Dear Student,';
                                
                                $messageData['image']       = '';
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
                                $notifyData['type_for']         = 'notice-board';
                                $notifyData['message']          = 'Here is the new notice for you.';
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
                    toastr()->success(__('Created Successfully'));
                    return redirect()->route('admin.noticeBoard.index');
                }
                else{
                    toastr()->error(__('Find some error'));
                    return back();
                }
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\Response
     */
    public function show(NoticeBoard $noticeBoard)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\Response
     */
    public function edit(NoticeBoard $noticeBoard)
    {
        $campus_arr = explode(',', $noticeBoard->campus);
        $shift_arr = explode(',', $noticeBoard->shift);
        if($noticeBoard->class_id ==0){
            $class_arr = ['Playgroup','Nursery','LKG','UKG','Class I','Class II','Class III','Class IV','Class V','Class VI','Class VII','Class VIII','Class IX','Class X', 'Class XI', 'Class XII'];
        }
        else{
            $class_arr = explode(',', $noticeBoard->class_id);
        }
        if($noticeBoard->section ==0){
            $section_arr = ['1','2','3','4','5','6'];
        }
        else{
            $section_arr = explode(',', $noticeBoard->section);
        }
        return view('backend.notice-board.edit', ['noticeBoard' => $noticeBoard, 'campus_arr' => $campus_arr, 'shift_arr' => $shift_arr, 'class_arr' => $class_arr, 'section_arr' => $section_arr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoticeBoard $noticeBoard)
    {
		if($request->notice_type == 1){
			if(!empty($noticeBoard->image)){
				$validator = Validator::make($request->all(), [
					'title' => ['required', 'string', 'max:255', 'min:2'],
					'image' => ['image', 'mimes:png,jpg,jpeg', 'max:2048'],
				    'notice_type' => ['required'],
                    'campus' => ['required', 'array'],
                    'shift' => ['required', 'array'], 
                    'student_id' => ['required', 'array'],
                    'class_id' => ['required', 'array'],
                    'section' => ['required', 'array'],
				]);				
			}
			else{
				$validator = Validator::make($request->all(), [
					'title' => ['required', 'string', 'max:255', 'min:2'],
					'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                    'notice_type' => ['required'],
                    'campus' => ['required', 'array'],
                    'shift' => ['required', 'array'], 
                    'student_id' => ['required', 'array'],
                    'class_id' => ['required', 'array'],
                    'section' => ['required', 'array'],
				]);
			}
		}
        elseif($request->notice_type == 2){
            if(!empty($noticeBoard->image)){
                $validator = Validator::make($request->all(), [
                    'title' => ['required', 'string', 'max:255', 'min:2'],
                    'image' => ['mimes:pdf', 'max:7168'],
                    'notice_type' => ['required'],
                    'campus' => ['required', 'array'],
                    'shift' => ['required', 'array'], 
                    'student_id' => ['required', 'array'],
                    'class_id' => ['required', 'array'],
                    'section' => ['required', 'array'],
                ]);             
            }
            else{
                $validator = Validator::make($request->all(), [
                    'title' => ['required', 'string', 'max:255', 'min:2'],
                    'image' => ['required', 'mimes:pdf', 'max:7168'],
                    'notice_type' => ['required'],
                    'campus' => ['required','array'],
                    'shift' => ['required', 'array'], 
                    'student_id' => ['required', 'array'],
                    'class_id' => ['required', 'array'],
                    'section' => ['required', 'array'],
                ]);
            }
        }
		else{
			$validator = Validator::make($request->all(), [
				'title' => ['required', 'string', 'max:255', 'min:2'],
                'notice_type' => ['required'],
                'content' => ['required'],
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'], 
                'student_id' => ['required', 'array'],
                'class_id' => ['required', 'array'],
                'section' => ['required','array'],
			]);			
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
        $status = ($request->has('status')) ? 1 : 0;
        
		try {
            if($request->notice_type == 1){
                if ($request->has('image')) {
                    $uploadImage = vImageUpload($request->file('image'), 'images/notice-board/', null, null, $noticeBoard->image);
                } else {
                    $uploadImage = $noticeBoard->image;
                }
                if ($uploadImage) {
                    $update = $noticeBoard->update([
                        'title' => $request->title,
                        'notice_type' => $request->notice_type,
                        'notice_date' => $request->notice_date,
                        'image' => $uploadImage,
                        'content' => '',
                        'campus' => $campus_arr, 
                        'shift' => $shift_arr,
                        'class_id' => $class_arr,
                        'section' => $section_arr, 
                        'student_id' => $student_ids,
                        'status' => $status,
                    ]);
                    if ($update) {
                        toastr()->success(__('Updated Successfully'));
                        return redirect()->route('admin.noticeBoard.index');
                    }
                } else {
                    toastr()->error(__('Upload error'));
                    return back();
                }
            }
            elseif($request->notice_type == 2){
                if ($request->has('image')) {
                    $uploadImage = vFileUpload($request->file('image'), 'images/notice-board/', null, null, $noticeBoard->image);
                } else {
                    $uploadImage = $noticeBoard->image;
                }
                if ($uploadImage) {
                    $update = $noticeBoard->update([
                        'title' => $request->title,
                        'notice_type' => $request->notice_type,
                        'notice_date' => $request->notice_date,
                        'image' => $uploadImage,
                        'content' => '',
                        'campus' => $campus_arr, 
                        'shift' => $shift_arr,
                        'class_id' => $class_arr,
                        'section' => $section_arr, 
                        'student_id' => $student_ids,
                        'status' => $status,
                    ]);
                    if ($update) {
                        toastr()->success(__('Updated Successfully'));
                        return redirect()->route('admin.noticeBoard.index');
                    }
                } else {
                    toastr()->error(__('Upload error'));
                    return back();
                }
            }
            else{
                $update = $noticeBoard->update([
                    'title' => $request->title,
                    'notice_type' => $request->notice_type,
                    'notice_date' => $request->notice_date,
                    'image' => '',
                    'content' => $request->content,
                    'campus' => $campus_arr, 
                    'shift' => $shift_arr,
                    'class_id' => $class_arr,
                    'section' => $section_arr, 
                    'student_id' => $student_ids,
                    'status' => $status,
                ]);
                if ($update) {
                    toastr()->success(__('Updated Successfully'));
                }
                return back();
            }
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NoticeBoard  $noticeBoard
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoticeBoard $noticeBoard)
    {
		if($noticeBoard->notice_type == '1'){
			removeFile($noticeBoard->image);			
		}
        $noticeBoard->delete();
        UserNotification::where(['notification_id' => $noticeBoard->id, 'type_for' => 'notice-board'])->delete();
        UserNotificationLogs::where(['notification_id' => $noticeBoard->id, 'type_for' => 'notice-board'])->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}
