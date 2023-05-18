<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Ad;
use App\Models\AdReport;
use App\Models\News;
use Illuminate\Support\Carbon;
use App\Models\Hirarchy;
use App\Models\Download;
use DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function index(){
        $boxType = 'boxes2'; //boxes2, boxes3, boxes1

        // month wise earnings
        $current_year_earnings = Wallet::select(DB::raw('SUM(net) as total'), DB::raw('MONTH(created_at) as month'))
         ->groupBy('month')
         ->whereYear('created_at', Carbon::now()->year)
         ->where('type', 'credit')
         ->where('member_id', auth()->user()->id)
         ->get();
        $monthly_earnings = [0,0,0,0,0,0,0,0,0,0,0,0];//initialize all months to 0
        foreach($current_year_earnings as $key){
           $monthly_earnings[$key->month-1] = (int)$key->total;//update each month with the total value
        }
        $month_wise_earnings = $monthly_earnings;

        // month wise withdrawals
        $current_year_withdrawals = Wallet::select(DB::raw('SUM(amount) as total'), DB::raw('MONTH(created_at) as month'))
         ->groupBy('month')
         ->whereYear('created_at', Carbon::now()->year)
         ->where('type', 'debit')
         ->where('member_id', auth()->user()->id)
         ->get();
        $monthly_withdrawals = [0,0,0,0,0,0,0,0,0,0,0,0];//initialize all months to 0
        foreach($current_year_withdrawals as $key){
           $monthly_withdrawals[$key->month-1] = (int)$key->total;//update each month with the total value
        }
        $month_wise_withdrawals = $monthly_withdrawals;

        //total downline
        $total_members = Hirarchy::where('sponsor_id', auth()->user()->member_id)->count();

        // Recent 5 Transactions from wallet table
        $recentTransactions = Wallet::orderBy('id', 'desc')->where('username', auth()->user()->member_id)->limit(5)->get();

        //total revenue & wallet balance
        $hirarchyRow = Hirarchy::select('total_income', 'wallet_1', 'wallet_3')->where('member_id', auth()->user()->member_id)->first();

        //Ads to view
        $total_ads = Ad::where('status', 1)->count();
        $viewed_ads = AdReport::where('member_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->count();
        $remaining_ads = $total_ads - $viewed_ads;

        //News & Notifications
        $news = News::where('status', 1)->orderBy('created_at', 'desc')->get();

        return view('members.pages.dashboard.dashboard', compact('boxType', 'month_wise_earnings', 'month_wise_withdrawals', 'total_members', 'recentTransactions', 'hirarchyRow', 'remaining_ads', 'viewed_ads', 'total_ads', 'news'));
    }

    public function downloads()
    {
        $downloads = Download::all();
        return view('members.pages.downloads.index', compact('downloads'));
    }
}
