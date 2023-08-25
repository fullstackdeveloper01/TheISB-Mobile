<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UserLog;
use App\Models\ComplaintType;
use App\Models\ComplaintsRaise;

use Illuminate\Http\Request;

use Validator;

class ComplaintListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transportList(Request $request)
    {
        $complaintList = ComplaintsRaise::where('type', 'Transport')->orderBy('created_at', 'asc')->get();
        $totalResolved = ComplaintsRaise::where(['type' => 'Transport', 'status' => 2])->count();
        $totalPending  = ComplaintsRaise::where(['type' => 'Transport', 'status' => 0])->count();
        $totalOnProcessing = ComplaintsRaise::where(['type' => 'Transport', 'status' => 1])->count();
        $totalRejected = ComplaintsRaise::where(['type' => 'Transport', 'status' => 3])->count();
        return view('backend.complaint-list.index', [
            'complaintList'     => $complaintList,
            'totalResolved'     => $totalResolved,
            'totalPending'      => $totalPending,
            'totalOnProcessing' => $totalOnProcessing,
            'totalRejected'     => $totalRejected,
            'complaintType'     => 'Transport'
        ]);
    }
	
    /********************************************************
     * @Function:Admin Comment
     * *****************************************************/
    public function getAdminComment(Request $request){
        $complaint_id = $request->cid;
        $complaintData = ComplaintsRaise::where('id', $complaint_id)->first();
        if(!is_null($complaintData)){
            return response()->json([
                    'status' => true,
                    'comment_status' => $complaintData->status,
                    'result' => $complaintData->admin_comment
                ], 200);
        }
        else{
            return response()->json([
                    'status' => false,
                    'result' => ''
                ], 200);
        }
    }

    /********************************************************
     * @Function:Admin Comment Submit
     * *****************************************************/
    public function adminCommentSubmit(Request $request){
        $complaint_id = $request->complaint_id;
        $comment_status = $request->comment_status;
        $admin_comment = $request->admin_comment;
        $message = '';
        $complaintData = ComplaintsRaise::where('id', $complaint_id)->first();
        if(!is_null($complaintData)){
            if($complaintData->type == 'Mobile'){
                $studentRecord = UserLog::where(['status' => 1, 'app_type' => $complaintData->type, 'student_id' => $complaintData->student_id])->whereNotNull('device_id')->orderBy('device_id')->get();
            }
            else{                
                $studentRecord = UserLog::where(['status' => 1, 'student_id' => $complaintData->student_id])->where('app_type', '<>', 'Mobile')->whereNotNull('device_id')->orderBy('device_id')->get();
            }
            $studentData = User::where('student_id', $complaintData->student_id)->first();
            if(!is_null($studentData)){
                $title = 'Dear '.$studentData->firstname.', Complaint Id: '.$complaintData->id;
            }
            else{
                $title = 'Dear Student, Complaint Id: '.$complaintData->id;
            }
            if($comment_status == 1){
                $message = 'Your complaint status is In-process.';
            }
            elseif($comment_status == 2){
                $message = 'Your complaint is Resolved.';
            }
            elseif($comment_status == 3){
                $message = 'Your complaint has been Rejected.';
            }
            else{
                $message = 'Your complaint status is pending';
            }
            $studentCheckArr =[];
            $studentDeviceArr =[];
            if(count($studentRecord) > 0){
                foreach($studentRecord as $res){
                    $arr = $res->device_id;
                    $messageData['message']         = $message;
                    $messageData['id']              = $complaintData->id;       
                    $messageData['user_id']         = 1;
                    $messageData['notify_type']     = 2;
                    $messageData['redirection']     = 1;
                    $messageData['title']           = $title;
                    $messageData['student_id']      = $complaintData->student_id;
                    $messageData['image']           = '';
                    if(!in_array($arr,$studentDeviceArr))
                    {
                        $studentDeviceArr[] = $arr;
                        sendNotification($arr, $title, $messageData); 
                    }

                    $notifyData['notification_id']  = 0;
                    $notifyData['device_id']        = $res->device_id;
                    $notifyData['user_id']          = '4';
                    $notifyData['student_id']       = $complaintData->student_id;
                    $notifyData['title']            = $title;
                    $notifyData['type']             = $complaintData->type;
                    $notifyData['type_for']         = $complaintData->type;
                    $notifyData['message']          = $message;                    
                    $notifyData['image']            = '';
                    if(!in_array($complaintData->student_id,$studentCheckArr))
                    {
                        $studentCheckArr[] = $complaintData->student_id;
                        notificationStore($notifyData, 1);
                    }else{
                        notificationStore($notifyData, 2);
                    }
                }

            }

            $complaintData->admin_comment = $admin_comment;
            $complaintData->status = $comment_status;
            $complaintData->save();
            return response()->json([
                    'status' => true,
                    'commentstatus' => $comment_status,
                    'result' => 'Comment submit successfully'
                ], 200);
        }
        else{
            return response()->json([
                    'status' => false,
                    'result' => ''
                ], 200);
        }
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function academicList(Request $request)
    {
        $complaintList = ComplaintsRaise::where('type', 'Academic')->orderBy('created_at', 'asc')->get();
        $totalResolved = ComplaintsRaise::where(['type' => 'Academic', 'status' => 2])->count();
        $totalPending  = ComplaintsRaise::where(['type' => 'Academic', 'status' => 0])->count();
        $totalOnProcessing = ComplaintsRaise::where(['type' => 'Academic', 'status' => 1])->count();
        $totalRejected = ComplaintsRaise::where(['type' => 'Academic', 'status' => 3])->count();
        return view('backend.complaint-list.index', [
            'complaintList'     => $complaintList,
            'totalResolved'     => $totalResolved,
            'totalPending'      => $totalPending,
            'totalOnProcessing' => $totalOnProcessing,
            'totalRejected'     => $totalRejected,
            'complaintType'     => 'Academic'
        ]);
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $complaintTypeList = ComplaintType::where('status', 1)->orderby('id', 'asc')->get();
        return view('backend.complaint-type.index', [
            'complaintTypeList' => $complaintTypeList
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
		$validator = Validator::make($request->all(), [
			'title' => ['required'],
            'type' => ['required']
		]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
		$create = ComplaintType::create([

			'title' => $request->title,
            'type' => $request->type

		]);

		if ($create) {

			toastr()->success(__('Created Successfully'));
			return redirect()->route('admin.complaintType.index');

		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Syllabus  $complaintType
     * @return \Illuminate\Http\Response
     */
    public function show(ComplaintType $complaintType)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Syllabus  $complaintType
     * @return \Illuminate\Http\Response
     */
    public function edit(ComplaintType $complaintType)
    {
        return view('backend.complaint-type.edit', ['complaintType' => $complaintType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Syllabus  $complaintType
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, ComplaintType $complaintType)
    {
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255', 'min:2'],
            'type' => ['required']
		]);			
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
		$update = $complaintType->update([
			'title' => $request->title,
            'type' => $request->type
		]);
		if ($update) {
			toastr()->success(__('Updated Successfully'));
		}
		return redirect()->route('admin.complaintType.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Syllabus  $complaintType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplaintType $complaintType) 
    {
		$complaintType->delete();
		toastr()->success(__('Deleted Successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Syllabus  $complaintType
     * @return \Illuminate\Http\Response
     */
    public function complaintRemove($id) 
    {
        $complaintsRaise = ComplaintsRaise::where('id', $id)->first();
        if(!is_null($complaintsRaise)){
            $complaintsRaise->delete();
            toastr()->success(__('Deleted Successfully'));
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Syllabus  $Complaints Query Ajax
     * @return \Illuminate\Http\Response
     */
    public function complaintsQueryAjax(Request $request) 
    {
        $complaintList = ComplaintsRaise::where('type', $request->type);
        if($request->start_date != ''){
            $complaintList->whereDate('created_at', '>=', $request->start_date);
        }
        if($request->end_date != ''){
            $complaintList->whereDate('created_at', '<=', $request->end_date);
        }
        $resp = $complaintList->get();
        $response = [];        
        if(count($resp) > 0){
            $count = 0;
            foreach($resp as $complaint){
                $data = [];
                //$sn = $count++;
                $data[] = '<td data-sort="'.strtotime($complaint->created_at).'"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#adminCommentModal" onclick="getAdminComment('.$complaint->id.')">#'.$complaint->id.'</a></td>';
                $data[] = '<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#adminCommentModal" onclick="getAdminComment('.$complaint->id.')">'.$complaint->student_name.'</a>';
                $data[] = $complaint->father_name;
                $data[] = $complaint->mother_name;
                $data[] =  $complaint->student_class.' '.$complaint->student_section;
                $data[] = $complaint->student_shift;
                $data[] = $complaint->student_mobile;
                if($complaint->student_complaint == 0)
                    $data[] = @$complaint->student_other_complaint;
                else
                    $data[] = @$complaint->complaintType->title;
                $data[] = '<span id="admin_comment'.$complaint->id.'">'.$complaint->admin_comment.'</span>';
                
                $data[] = vDate($complaint->created_at);
                $status = '';
                $status .= '<div id="complaint-status'.$complaint->id.'"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#adminCommentModal" onclick="getAdminComment('.$complaint->id.')">';
                if($complaint->status == 0)
                    $status .= 'Pending';
                elseif($complaint->status == 1)
                    $status .= 'In-Process';
                elseif($complaint->status == 2)
                    $status .= 'Resolved';
                elseif($complaint->status == 3)
                    $status .= 'Rejected';
                else
                    $status .= '--';
                $status .= '</a></div>';
                $data[] = $status;

                $response[] = $data;
            }
            return response()->json([
                'status' => true, 
                'message' => $request->type.' complaint list', 
                'data' => $response,
            ], 200);
        }
        else{
            return response()->json([
                'status' => false, 
                'message' => 'Record not found', 
                'data' => [],
            ], 200); 
        }
    }
}

