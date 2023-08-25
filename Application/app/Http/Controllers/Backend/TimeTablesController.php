<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;

class TimeTablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $search = null)
    {
        if($request->ajax()) {
       
             $data = TimeTable::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end', 'description', 'student_class']);

            $dataArr = array();
            if(!empty($data))
            {
                foreach ($data as $key => $val) {
                    $val['title'] = 'Title:'.$val['title'].', Class:'.$val['student_class'];             
                    $dataArr[] = $val;
                }
            }

             return response()->json($dataArr);
        }
        $classData = array('Playgroup', 'Nursery', 'LKG', 'UKG', 'Class I', 'Class II', 'Class III', 'Class IV', 'Class V', 'Class VI', 'Class VII', 'Class VIII', 'Class XI', 'Class X', 'Class XII', 'Class XIII');
        return view('backend.timeTable.index', ['class_list' => $classData]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    { 
        switch ($request->type) {
           case 'add':
            $student_id = $request->student_id;
            $student_ids = 0; 

            if(!empty($student_id))
            {
                if(!in_array('all', $student_id))
                {
                    $student_ids = implode(',',$student_id);
                } 
            }
              $event = TimeTable::create([
                  'title' => $request->title,
                  'student_class' => $request->student_class,
                  'description' => $request->description,
                  'start' => $request->start,
                  'end' => $request->end,
                  'campus' => $request->campus, 
                  'shift' => $request->shift, 
                  'section' => $request->section, 
                  'student_id' => $student_ids,
              ]);
 
              return response()->json($event);
             break;
  
           case 'update':
              $event = TimeTable::find($request->id)->update([
                  'title' => $request->title,
                  'student_class' => $request->student_class,
                  'description' => $request->description,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);
 
              return response()->json($event);
             break;
  
           case 'delete':
              $event = TimeTable::find($request->id)->delete();
  
              return response()->json($event);
             break;
             
           default:
             # code...
             break;
        }
    }
}
