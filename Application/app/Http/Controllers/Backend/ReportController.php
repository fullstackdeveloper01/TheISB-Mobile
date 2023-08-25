<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;

use Validator;

class ReportController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     */ 
    
    public function index(Request $request)

    {

        $assignmentList = Assignment::orderByDesc('id')->get();

        return view('backend.assignment.index', [

            'assignmentList' => $assignmentList

        ]); 
    }

    public function usersReport(Request $request)
    {

        return view('backend.report.users');
    }

    public function usersReportAjax(Request $request)
    {
        //$filterParams = $request->filterParams;

        $filterParams = $request->all();
 
        $client = new \GuzzleHttp\Client();
        
        $select_all = 1;

        if(empty($filterParams['campus']))
        {
            // return response()->json([
            //     'status' => 0, 
            //     'message' => '', 
            //     'data' => [],
            // ], 200); 
        }
         

       // $request = $client->get('https://www.theisb.in/students/api/apiController/getHomeworkAllStudentList?pp=1');
        $request = $client->post('https://www.theisb.in/students/api/apiController/getHomeworkAllStudentList/', [
                'form_params' => [
                    'cumpus' => (string) $filterParams['campus'],
                    'shift' => (string) $filterParams['shift'],
                    'class_id' => (string) $filterParams['class_id'],
                    'section' => (string) $filterParams['section'],
                    'select_all' => (string) $select_all
                ]
            ]
        );
        
        $response = $request->getBody()->getContents();
        $studentList = json_decode($response);
        $users = [];
        if($studentList->status == 1)
        { 
            $studentRecord = $studentList->result;  

            if(!empty($studentRecord))
            {
               $count =0;
                foreach ($studentRecord as $key => $user) { 
                    $userArr = [];
                    $count++;
                    $userArr[] = $count;
                    $userArr[] = $user->firstname.' '.$user->middlename.' '.$user->lastname;
                    $userArr[] = $user->Father_Name;
                    $userArr[] = $user->Father_Mobile; 
                    $userArr[] = $user->Campus; 
                    $userArr[] = $user->Shift; 
                    $userArr[] = $user->Class; 
                   

                    if($user->payment_status == 1){
                         $userArr[] = 'A1';
                    }else if($user->payment_status == 2){
                         $userArr[] = 'A2'; 
                    }else if($user->payment_status == 3){
                         $userArr[] = 'A3'; 
                    }else if($user->payment_status == 4){
                         $userArr[] = 'A4';
                    }else if($user->payment_status == 5){
                         $userArr[] = 'A5';
                    }else if($user->payment_status == 6){
                         $userArr[] = 'A6';
                    }else{
                        $userArr[] = '';
                    }
                    $userArr[] = userStatus($user->active);
                    $userArr[] = $user->Date_of_Admission; 

                    $users[] =$userArr;
                }
            }

            return response()->json([
                'status' => 1, 
                'message' => $studentList->message, 
                'data' => $users,
            ], 200); 

        }else{
            return response()->json([
                'status' => 0, 
                'message' => $studentList->message, 
                'data' => [],
            ], 200); 
        }  
    }

}