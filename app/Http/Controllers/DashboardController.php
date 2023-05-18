<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Epin;
use App\Models\Hirarchy;
use App\Models\Wallet;
use App\Models\Incentive;
use Illuminate\Support\Carbon;
use DB, DateInterval, DatePeriod, DateTime;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(){
        $boxType = 'boxes1'; //boxes1, boxes2, boxes3
        // Calculate Launch Days
        $launchDate = env('LAUNCH_DATE');
        $today = date('d-m-Y');
        $launchDays = dateDiffInDays($today, $launchDate);

        // Total & Today Users
        $totalUsers = Member::count();
        $todayUsers = Member::whereDate('created_at', date('Y-m-d'))->count();

        // Total & Today Activations
        $totalActivations = Hirarchy::where('activation_amount', '>', 0)->count();
        $todayActivations = Hirarchy::where('activation_amount', '>', 0)->whereDate('activation_time', date('Y-m-d'))->count();

        // Total & Today Revenues
        $totalRevenues = Hirarchy::where('activation_amount', '>', 0)->sum('activation_amount');
        $todayRevenues = Hirarchy::where('activation_amount', '>', 0)->whereDate('activation_time', date('Y-m-d'))->sum('activation_amount');

        // Month Wise Joinings
        $current_year_joinings = Hirarchy::select(DB::raw('count(id) as total'), DB::raw('sum(activation_amount) as activation_total'), DB::raw('MONTH(created_at) as month'))
         ->groupBy('month')
         ->whereYear('created_at', Carbon::now()->year)
         ->get();
        $monthly_joinings = [0,0,0,0,0,0,0,0,0,0,0,0];//initialize all months to 0
        $monthly_revenue = [0,0,0,0,0,0,0,0,0,0,0,0];//initialize all months to 0
        foreach($current_year_joinings as $key){
            $monthly_joinings[$key->month-1] = (int)$key->total;//update each month with the total value
            
        }
        $month_wise_joinings = $monthly_joinings;

        // Month Wise Activations
        $current_year_activations = Hirarchy::select(DB::raw('sum(activation_amount) as total'), DB::raw('MONTH(activation_time) as month'))
         ->groupBy('month')
         ->whereYear('activation_time', Carbon::now()->year)
         ->where('activation_amount', '>', 0)
         ->get();

        $monthly_activations = [0,0,0,0,0,0,0,0,0,0,0,0]; //initialize all months to 0
        foreach($current_year_activations as $key){
           $monthly_activations[$key->month-1] = (int)$key->total;//update each month with the total value
           $monthly_revenue[$key->month-1] = (int)$key->total;//update each month with the total value
        }
        $month_wise_activations = $monthly_activations;

        // Month Wise Incentives
        $current_year_incentives = Incentive::select(DB::raw('sum(net) as total'), DB::raw('MONTH(created_at) as month'))
         ->groupBy('month')
         ->whereYear('created_at', Carbon::now()->year)
         ->get();
        $monthly_incentives = [0,0,0,0,0,0,0,0,0,0,0,0]; //initialize all months to 0
        foreach($current_year_incentives as $key){
           $monthly_incentives[$key->month-1] = (int)$key->total;//update each month with the total value
        }

        // Total Active Users
        $totalActiveUsers = Hirarchy::where('activation_amount', '>', 0)->count();

        // Total Inactive Users
        $totalInactiveUsers = Hirarchy::where('activation_amount', 0)->count();

        // Recent 5 Transactions from wallet table
        $recentTransactions = Wallet::orderBy('id', 'desc')->limit(5)->get();

        //Recent 6 Joinings from hirarchy table
        $recentJoinings = Hirarchy::select('id', 'member_id', 'activation_amount', 'created_at')
        ->with(['member' => function($query){
            $query->select('id', 'member_id', 'full_name');
        }])
        ->orderBy('created_at', 'desc')
        ->limit(6)->get();

        //Epins
        $epinsCreatedToday = Epin::whereDate('created_at', date('Y-m-d'))->count();
        $totalEpins = Epin::count();
        $usedEpins = Epin::where('status', 1)->count();
        $epinsUsedToday = Epin::whereDate('updated_at', date('Y-m-d'))->where('status', 1)->count();

        //TOtal Withdrawals
        $totalWithdrawals = Wallet::where('type', 'debit')->where('wallet_type', 1)->sum('amount');
        $todayWithdrawals = Wallet::where('type', 'debit')->where('wallet_type', 1)->whereDate('created_at', date('Y-m-d'))->sum('amount');

    	return view('admin.pages.dashboard', compact('boxType', 'launchDate', 'launchDays', 'totalUsers', 'todayUsers', 'totalActivations', 'todayActivations', 'totalRevenues', 'todayRevenues', 'month_wise_joinings', 'month_wise_activations', 'totalActiveUsers', 'totalInactiveUsers', 'recentTransactions', 'monthly_incentives', 'monthly_revenue', 'recentJoinings', 'epinsCreatedToday', 'totalEpins', 'usedEpins', 'epinsUsedToday', 'totalWithdrawals', 'todayWithdrawals'));
    }

    public function filterJoiningActivationChart(Request $request)
    {
        $sdate = $request->start;
        $edate = $request->end;

        $dateRange = $this->getDatesFromRange($sdate, $edate);

        $range_joinings = [];
        $range_activations = [];

        foreach($dateRange as $date){
            $joinings = Hirarchy::whereDate('created_at', $date)->count();
            $range_joinings[] = $joinings;

            $activations = Hirarchy::whereDate('activation_time', $date)->where('activation_amount', '>', 0)->count();
            $range_activations[] = $activations;
        }

        return response()->json(['range' => $dateRange, 'joinings' => $range_joinings, 'activations' => $range_activations]);

    }

    public function filterRevenueIncentiveChart(Request $request)
    {
        $sdate = $request->start;
        $edate = $request->end;

        $dateRange = $this->getDatesFromRange($sdate, $edate);

        $range_revenue = [];
        $range_incentives = [];

        foreach($dateRange as $date){
            $revenue = Hirarchy::whereDate('activation_time', $date)->where('activation_amount', '>', 0)->sum('activation_amount');
            $range_revenue[] = $revenue;

            $incentives = Incentive::whereDate('created_at', $date)->sum('net');
            $range_incentives[] = $incentives;
        }

        return response()->json(['range' => $dateRange, 'revenue' => $range_revenue, 'incentives' => $range_incentives]);

    }

    protected function getDatesFromRange($start, $end, $format = 'Y-m-d') {
        // Declare an empty array
        $array = array();
          
        // Variable that store the date interval
        // of period 1 day
        $interval = new DateInterval('P1D');
      
        $realEnd = new DateTime($end);
        $realEnd->add($interval);
      
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
      
        // Use loop to store date into array
        foreach($period as $date) {                 
            $array[] = $date->format($format); 
        }
      
        // Return the array elements
        return $array;
    }
    
}
