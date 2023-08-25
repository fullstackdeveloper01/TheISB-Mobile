<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\UserLog;
use App\Models\UserNotification;
use App\Models\UserNotificationLogs;
use Illuminate\Http\Request;
use Validator;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventList = Event::orderbyDesc('id')->get();
        return view('backend.events.index', [
            'events' => $eventList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.events.create');
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
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'content' => ['required'],
            'event_type' => ['required'],
            'event_date' => ['required'],
            'short_description' => ['required', 'string', 'max:200', 'min:2'],
            'campus' => ['required', 'array'],
            'shift' => ['required', 'array'], 
            'student_id' => ['required', 'array'],
            'class_id' => ['required', 'array'],
            'section' => ['required', 'array'],
        ]);
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

        $uploadImage = vImageUpload($request->file('image'), 'images/events/', null);
        if ($uploadImage) {
            $create = Event::create([
                'title' => $request->title,
                'image' => $uploadImage,
                'content' => $request->content,
                'event_type' => $request->event_type,
                'event_date' => $request->event_date,
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
                            $messageData['message']         = 'Checkout upcoming event.';
                            $messageData['id']              = $create->id;       
                            $messageData['user_id']         = $res->student_id;
                            $messageData['notify_type']     = '2';
                            
                            $redirection['id']              = $create->id;
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
                            $notifyData['type_for']         = 'upcoming event';
                            $notifyData['message']          = 'Checkout upcoming event.';
                            $notifyData['image']            = @$uploadImage;
        
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
                return redirect()->route('admin.events.index');
            }
        } else {
            toastr()->error(__('Upload error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Highlighter  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Highlighter  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $campus_arr = explode(',', $event->campus);
        $shift_arr = explode(',', $event->shift);
        if($event->class_id ==0){
            $class_arr = ['Playgroup','Nursery','LKG','UKG','Class I','Class II','Class III','Class IV','Class V','Class VI','Class VII','Class VIII','Class IX','Class X', 'Class XI', 'Class XII'];
        }
        else{
            $class_arr = explode(',', $event->class_id);
        }
        if($event->section ==0){
            $section_arr = ['1','2','3','4','5','6'];
        }
        else{
            $section_arr = explode(',', $event->section);
        }
        return view('backend.events.edit', ['event' => $event, 'campus_arr' => $campus_arr, 'shift_arr' => $shift_arr, 'class_arr' => $class_arr, 'section_arr' => $section_arr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Highlighter  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255', 'min:2'],
            'image' => ['mimes:png,jpg,jpeg', 'max:2048'],
            'content' => ['required'],
            'event_type' => ['required'],
            'short_description' => ['required', 'string', 'max:200', 'min:2'],
            'campus' => ['required', 'array'],
            'shift' => ['required', 'array'], 
            'event_date' => ['required'], 
            'student_id' => ['required', 'array'],
            'class_id' => ['required', 'array'],
            'section' => ['required', 'array'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if ($request->has('image')) {
            $uploadImage = vImageUpload($request->file('image'), 'images/events/', null, null, $event->image);
        } else {
            $uploadImage = $event->image;
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
        
        if ($uploadImage) {
            $update = $event->update([
                'title' => $request->title,
                'image' => $uploadImage,
                'content' => $request->content,
                'event_type' => $request->event_type,
                'event_date' => $request->event_date,
                'short_description' => $request->short_description,
                'campus' => $campus_arr, 
                'shift' => $shift_arr,
                'class_id' => $class_arr,
                'section' => $section_arr, 
                'student_id' => $student_ids,
                'status' => $status,
            ]);
            if ($update) {
                toastr()->success(__('Updated Successfully'));
                return redirect()->route('admin.events.index');
            }
        } else {
            toastr()->error(__('Upload error'));
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        removeFile($event->image);
        $event->delete();
        UserNotification::where(['notification_id' => $event->id, 'type_for' => 'upcoming event'])->delete();
        UserNotificationLogs::where(['notification_id' => $event->id, 'type_for' => 'upcoming event'])->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}
