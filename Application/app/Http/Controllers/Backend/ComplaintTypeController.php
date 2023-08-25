<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\ComplaintType;

use Illuminate\Http\Request;

use Validator;

class ComplaintTypeController extends Controller
{
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
}

