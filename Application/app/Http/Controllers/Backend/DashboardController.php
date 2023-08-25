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

use App\Exports\ExportUser;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index()
    {
		$client = new \GuzzleHttp\Client();
        $request = $client->get('https://www.theisb.in/students/api/apiController/totalRecord');
        $totalRecord = $request->getBody()->getContents();
        $totalResult = json_decode($totalRecord);
        return view('backend.dashboard.index', [
            'totalStudents' => $totalResult->totalStudent,            
        ]);
    }

    public function export() 
    {
        return Excel::download(new ExportUser, 'users.xlsx');
    }

    public function usersChartData()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        $dates = chartDates($startDate, $endDate);
        $usersRecord = User::where('created_at', '>=', Carbon::now()->startOfWeek())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $usersRecordData = $dates->merge($usersRecord);
        $usersChartLabels = [];
        $usersChartData = [];
        foreach ($usersRecordData as $key => $value) {
            $usersChartLabels[] = Carbon::parse($key)->format('d F');
            $usersChartData[] = $value;
        }
        $suggestedMax = (max($usersChartData) > 10) ? max($usersChartData) + 2 : 10;
        return ['usersChartLabels' => $usersChartLabels, 'usersChartData' => $usersChartData, 'suggestedMax' => $suggestedMax];
    }

    public function earningsChartData()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        $dates = chartDates($startDate, $endDate);
        $getWeekEarnings = Transaction::where([['status', 2], ['created_at', '>=', Carbon::now()->startOfWeek()]])
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as sum')
            ->groupBy('date')
            ->pluck('sum', 'date');
        $getEarningsData = $dates->merge($getWeekEarnings);
        $earningsChartLabels = [];
        $earningsChartData = [];
        foreach ($getEarningsData as $key => $value) {
            $earningsChartLabels[] = Carbon::parse($key)->format('d F');
            $earningsChartData[] = $value;
        }
        $suggestedMax = (max($earningsChartData) > 10) ? max($earningsChartData) + 2 : 10;
        return ['earningsChartLabels' => $earningsChartLabels, 'earningsChartData' => $earningsChartData, 'suggestedMax' => $suggestedMax];
    }

    public function transfersChartData()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);
        $monthlyTransfers = Transfer::where([['status', 1], ['created_at', '>=', Carbon::now()->startOfMonth()]])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $monthlyTransfersData = $dates->merge($monthlyTransfers);
        $transfersChartLabels = [];
        $transfersChartData = [];
        foreach ($monthlyTransfersData as $key => $value) {
            $transfersChartLabels[] = Carbon::parse($key)->format('d F');
            $transfersChartData[] = $value;
        }
        $suggestedMax = (max($transfersChartData) > 10) ? max($transfersChartData) + 2 : 10;
        return ['transfersChartLabels' => $transfersChartLabels, 'transfersChartData' => $transfersChartData, 'suggestedMax' => $suggestedMax];
    }
}
