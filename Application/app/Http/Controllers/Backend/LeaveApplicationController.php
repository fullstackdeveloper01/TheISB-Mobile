<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\LeaveRequest;

use Illuminate\Http\Request;

use Validator;

class LeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $leaveRequestList = LeaveRequest::orderbyDesc('id')->get();
        return view('backend.leave-request.index', [
            'leaveRequestList' => $leaveRequestList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.leave-request.create');
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

     * @param  \App\Models\Syllabus  $leaveRequest

     * @return \Illuminate\Http\Response

     */

    public function show(LeaveRequest $leaveRequest)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Syllabus  $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        return view('backend.leave-request.edit', ['leaveRequest' => $leaveRequest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Syllabus  $leaveRequest
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, LeaveRequest $leaveRequest)
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
		$update = $leaveRequest->update([
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
     * @param  \App\Models\Syllabus  $leaveRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($lid) 
    {
        $leaveRequest = LeaveRequest::where('id', $lid)->first();
        if(!is_null($leaveRequest)){
    		$leaveRequest->delete();
    		toastr()->success(__('Deleted Successfully'));
        }
        return back();
    }    
}

