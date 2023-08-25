<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BlogArticle;
use App\Models\Coupon;
use App\Models\Page;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\User;
use Carbon\Carbon;

class StudentsController extends Controller
{
    public function index()
    {
		$client = new \GuzzleHttp\Client();
        $request = $client->get('https://www.theisb.in/students/api/apiController/allStudentList');
        $response = $request->getBody()->getContents();
        $studentList = json_decode($response);
        $studentRecord = $studentList->result;
        $totalActiveStudent = $studentList->totalActiveStudent;
        $totalInactiveStudent = $studentList->totalInactiveStudent;
        return view('backend.students.index', [
            'studentList' => $studentRecord,
            'totalActiveStudent' => $totalActiveStudent,
            'totalInactiveStudent' => $totalInactiveStudent,
        ]);
    }
}
