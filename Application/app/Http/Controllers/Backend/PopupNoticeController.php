<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\PopupNotice;

use Illuminate\Http\Request;

use Validator;

class PopupNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $noticeList = PopupNotice::orderbyDesc('id')->get();
        return view('backend.popup-notice.index', [
            'noticeList' => $noticeList
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.popup-notice.create');
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
			'image' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:7128'],
		],
        ['image.max'=> 'Image must not be greater than 7MB']
        );
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $student_id = $request->student_id;
        $student_ids = 0; 

        if(!empty($student_id))
        {
            if(!in_array('all', $student_id))
            {
                $student_ids = implode(',',$student_id);
            } 
        }
        $existingRecord = PopupNotice::where(['campus' => $request->campus])->count();
        if($existingRecord == 0){
            $uploadImage = vImageUpload($request->file('image'), 'images/popup-notice/');
            if ($uploadImage) {
                $create = PopupNotice::create([
                    'class_id' => $request->class_id,
                    'campus' => $request->campus,
                    'shift' => $request->shift,
                    'section' => $request->section,
                    'student_id' => $student_ids,
                    'image' => $uploadImage,
                ]);
                if ($create) {
                    toastr()->success(__('Created Successfully'));
                    return redirect()->route('admin.popup-notice.index');
                }
            } else {
                toastr()->error(__('Upload error'));
                return back();
            }
        }
        else{
            toastr()->error(__('Notice is already added for this campus'));
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PopupNotice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(PopupNotice $notice)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PopupNotice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit($sid)
    {
        $notice = PopupNotice::where('id', $sid)->first();
        return view('backend.popup-notice.edit', ['notice' => $notice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PopupNotice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PopupNotice $popupNotice)
    {
        $validator = Validator::make($request->all(), [
            'campus' => ['required'],
            'shift' => ['required'],
            'student_id' => ['required', 'array'],
            'class_id' => ['required'],
            'image' => ['mimes:png,jpg,jpeg', 'max:7128'],
        ],
        ['image.max'=> 'Image must not be greater than 7MB']
        );
        $student_id = $request->student_id; 
        
        $student_ids = 0; 
        if(!empty($student_id))
        {
            if(!in_array('all', $student_id))
            {
                $student_ids = implode(',',$student_id);
            } 
        }  
        if ($request->has('image')) {
            $uploadImage = vImageUpload($request->file('image'), 'images/popup-notice/', null, null, $popupNotice->image);
        } else {
            $uploadImage = $popupNotice->image;
        }
		if ($uploadImage) {
            $status = ($request->has('status')) ? 1 : 0;
			$update = $popupNotice->update([
				'class_id' => $request->class_id,
                'campus' => $request->campus,
                'student_id' => $student_ids,
                'shift' => $request->shift,
                'section' => $request->section,
                'status' => $status,
                'image' => $uploadImage,
			]);
			if ($update) {
				toastr()->success(__('Updated Successfully'));
				return redirect()->route('admin.popup-notice.index');
			}
		} else {
			toastr()->error(__('Upload error'));
			return back();
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PopupNotice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) 
    {
        $notice_id = $request->notice_id;
        $notice = PopupNotice::where('id', $notice_id)->first();
        if($notice)
        {
            removeFile($notice->image);			
            $notice->delete();
            toastr()->success(__('Deleted Successfully'));
        }else{ 
            toastr()->error(__('Data Not Found'));
        }
        return back();
    }
}

