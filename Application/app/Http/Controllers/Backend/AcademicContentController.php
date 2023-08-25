<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Syllabus;

use Illuminate\Http\Request;

use Validator;

use Illuminate\Support\Facades\DB;

class AcademicContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $syllabusList = Syllabus::where('type', 2)->orderby('id', 'asc')->get();
        return view('backend.academic-content.index', [
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
        return view('backend.academic-content.create');
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
            'section' => ['required','array'],
            'image' => ['required', 'mimes:pdf,PDF', 'max:7128'],
        ],
        ['image.max'=> 'Content must not be greater than 7MB']
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
        $existingRecord = Syllabus::where(['class_name' => $request->class_name, 'academic_year' => $academic_year, 'campus' => $request->campus, 'shift' => $request->shift])->where('type', 2)->count();
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
                    'type' => 2,
                    'syllabus' => $uploadImage,
                ]);
                if ($create) {
                    toastr()->success(__('Created Successfully'));
                    return redirect()->route('admin.academicContent.index');
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
        return view('backend.academic-content.academic_content', [
            'syllabusList' => $syllabusList
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function show(Syllabus $academicContent)
    {
        return abort(404);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function edit(Syllabus $academicContent)
    {
        $campus_arr = explode(',', $academicContent->campus);
        $shift_arr = explode(',', $academicContent->shift);
        if($academicContent->class_name ==0){
            $class_arr = ['Playgroup','Nursery','LKG','UKG','Class I','Class II','Class III','Class IV','Class V','Class VI','Class VII','Class VIII','Class IX','Class X', 'Class XI', 'Class XII'];
        }
        else{
            $class_arr = explode(',', $academicContent->class_name);
        }
        if($academicContent->section ==0){
            $section_arr = ['1','2','3','4','5','6'];
        }
        else{
            $section_arr = explode(',', $academicContent->section);
        }
        return view('backend.academic-content.edit', ['syllabus' => $academicContent, 'campus_arr' => $campus_arr, 'shift_arr' => $shift_arr, 'class_arr' => $class_arr, 'section_arr' => $section_arr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Syllabus $academicContent)
    {
        $syllabus = $academicContent;
		if ($request->has('image')) {
            $validator = Validator::make($request->all(), [
                'campus' => ['required', 'array'],
                'shift' => ['required', 'array'],
                'student_id' => ['required', 'array'],
                'class_name' => ['required', 'array'],
                'image' => ['required', 'mimes:pdf,PDF', 'max:7128'],
                'section' => ['required', 'array'],
            ],
            ['image.max'=> 'Content must not be greater than 7MB']
            );
        }else{
            $validator = Validator::make($request->all(), [
                'campus' => ['required'],
                'shift' => ['required'],
                'class_name' => ['required'],
                'image' => ['mimes:pdf,PDF', 'max:7128'],
                ],
                ['image.max'=> 'Content must not be greater than 7MB']
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
                return redirect()->route('admin.academicContent.index');
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
    public function destroy(Syllabus $academicContent)
    { 
		removeFile($academicContent->syllabus);			
        $academicContent->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}

