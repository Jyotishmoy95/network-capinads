<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\EpinController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\FundTransferController;
use App\Http\Controllers\FundRequestController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\DownloadsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return view('welcome');
});


Route::name('admin.')->prefix('admin')->group(function(){
    Route::get('/', function () { return view('admin.auth.login'); })->name('login');
    Route::get('login', function () { return view('admin.auth.login'); });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('signin');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Dashboard
    Route::name('dashboard.')->prefix('dashboard')->group(function(){
        Route::get('filter-joining-activation-chart', [DashboardController::class, 'filterJoiningActivationChart'])->name('filter-joinings-activations');
        Route::get('filter-revenue-incentives-chart', [DashboardController::class, 'filterRevenueIncentiveChart'])->name('filter-revenue-incentives');
    });
    
    //Network
    Route::name('network.')->prefix('network')->group(function(){
    	Route::get('tree', [NetworkController::class, 'tree']);
    });

    //E-Pins
    Route::name('epins.')->prefix('epins')->group(function(){
    	Route::get('create', [EpinController::class, 'create']);
        Route::post('create', [EpinController::class, 'store'])->name('create');
        Route::get('available', [EpinController::class, 'available']);
        Route::post('available-list', [EpinController::class, 'availableList'])->name('available');
        Route::get('applied', [EpinController::class, 'used']);
        Route::post('used-list', [EpinController::class, 'usedList'])->name('used');
        Route::get('history', [EpinController::class, 'history']);
        Route::post('history-list', [EpinController::class, 'historyList'])->name('history');
        Route::post('bulk-delete', [EpinController::class, 'destroy'])->name('destroy');
    });

    //Packages
    Route::name('packages.')->prefix('packages')->group(function(){
    	Route::get('create', [PackageController::class, 'create']);
        Route::post('create', [PackageController::class, 'store'])->name('create');
        Route::get('list', [PackageController::class, 'index']);
        Route::post('list', [PackageController::class, 'list'])->name('list');
        Route::get('update-status', [PackageController::class, 'updateStatus'])->name('updateStatus');
        Route::get('edit/{id}', [PackageController::class, 'edit']);
        Route::post('edit/{id}', [PackageController::class, 'update'])->name('update');
    });

    //Activations
    Route::name('activations.')->prefix('activations')->group(function(){
        Route::get('new', [ActivationController::class, 'new']);
        Route::post('new-activation', [ActivationController::class, 'newActivation'])->name('activate');
        Route::get('report', [ActivationController::class, 'index']);
        Route::post('list', [ActivationController::class, 'list'])->name('list');
    });

    //Members
    Route::name('members.')->prefix('members')->group(function(){
        Route::get('index', [MemberController::class, 'index']);
        Route::post('all-members', [MemberController::class, 'allMembers'])->name('all');
        Route::get('working', [MemberController::class, 'working']);
        Route::post('all-working', [MemberController::class, 'allWorking'])->name('working');
        Route::get('non-working', [MemberController::class, 'nonWorking']);
        Route::post('all-non-working', [MemberController::class, 'allNonWorking'])->name('nonWorking');
        Route::get('blocked', [MemberController::class, 'blocked']);
        Route::post('all-blocked', [MemberController::class, 'allBlocked'])->name('blocked');
        Route::get('{id}', [MemberController::class, 'show']);
    });

    //Ad Details
    Route::name('ad-details.')->prefix('ad-details')->group(function(){
        Route::get('index', [AdController::class, 'index']);
        Route::get('create', [AdController::class, 'create']);
        Route::post('all-ads', [AdController::class, 'allAds'])->name('all');
        Route::get('edit/{id}', [AdController::class, 'edit']);
        Route::post('update/{id}', [AdController::class, 'update'])->name('update');
        Route::post('create', [AdController::class, 'store'])->name('store');
        Route::get('update-status', [AdController::class, 'updateStatus'])->name('updateStatus');
    });

    //Settings
    Route::name('settings.')->prefix('settings')->group(function(){
        Route::get('index', [SettingController::class, 'index']);
        Route::post('update-welcome-letter', [SettingController::class, 'updateWelcomeLetter'])->name('updateWelcomeLetter');
        Route::post('update-blocked-modules', [SettingController::class, 'updateBlockedModules'])->name('updateBlockedModules');
        Route::post('update-withdraw-deduction', [SettingController::class, 'updateWithdrawDeduction'])->name('updateWithdrawDeduction');
        Route::post('update-ad-incomes', [SettingController::class, 'updateAdIncomes'])->name('updateAdIncomes');
        Route::post('update-profile-password',[SettingController::class, 'updateProfilePassword'])->name('updateProfilePassword');
    });

    //News
    Route::name('news.')->prefix('news')->group(function(){
        Route::get('index', [NewsController::class, 'index']);
        Route::post('list', [NewsController::class, 'list'])->name('list');
        Route::get('create', [NewsController::class, 'create']);
        Route::post('create', [NewsController::class, 'store'])->name('store');
        Route::get('edit/{id}', [NewsController::class, 'edit']);
        Route::post('update/{id}', [NewsController::class, 'update'])->name('update');
        Route::get('update-status', [NewsController::class, 'updateStatus'])->name('updateStatus');
        Route::post('delete', [NewsController::class, 'destroy'])->name('destroy');
    });

    //Downloads
    Route::name('downloads.')->prefix('downloads')->group(function(){
        Route::get('index', [DownloadsController::class, 'index']);
        Route::post('list', [DownloadsController::class, 'list'])->name('list');
        Route::get('create', [DownloadsController::class, 'create']);
        Route::post('create', [DownloadsController::class, 'store'])->name('store');
        Route::get('edit/{id}', [DownloadsController::class, 'edit']);
        Route::post('update/{id}', [DownloadsController::class, 'update'])->name('update');
        Route::post('delete', [DownloadsController::class, 'destroy'])->name('destroy');
    });

    //Reports
    Route::name('reports.')->prefix('reports')->group(function(){
        Route::get('account', [ReportController::class, 'accountReport']);
        Route::post('account-report', [ReportController::class, 'accountReportList'])->name('account');
        Route::get('incentives', [ReportController::class, 'incentivesReport']);
        Route::post('incentives-report', [ReportController::class, 'incentivesReportList'])->name('incentives');
        Route::get('earnings', [ReportController::class, 'earningsReport']);
        Route::post('earnings-report', [ReportController::class, 'earningsReportList'])->name('earnings');
        Route::get('wallet', [ReportController::class, 'walletReport']);
        Route::post('wallet-report', [ReportController::class, 'walletReportList'])->name('wallet');
        Route::get('withdrawals', [ReportController::class, 'withdrawalReport']);
        Route::post('withdrawal-report', [ReportController::class, 'withdrawalReportList'])->name('withdrawals');
    });

    //Network
    Route::name('network.')->prefix('network')->group(function(){
        Route::get('referrals', [NetworkController::class, 'referrals']);
        Route::post('referrals-report', [NetworkController::class, 'referralsReportList'])->name('referrals');
        Route::get('downline-team', [NetworkController::class, 'downlineTeam']);
        Route::post('downline-team-report', [NetworkController::class, 'downlineTeamReportList'])->name('downlineTeam');
    });

    //Fund Transfer
    Route::name('fund-transfer.')->prefix('fund-transfer')->group(function(){
        Route::get('/list', [FundTransferController::class, 'index']);
        Route::post('list', [FundTransferController::class, 'transferList'])->name('list');
        Route::get('new', [FundTransferController::class, 'newTransfer']);
        Route::post('new-transfer', [FundTransferController::class, 'transfer'])->name('new');
    });

    //Fund Request
    Route::name('fund-requests.')->prefix('fund-requests')->group(function(){
        Route::get('/pending', [FundRequestController::class, 'pending']);
        Route::get('/rejected', [FundRequestController::class, 'rejected']);
        Route::get('/approved', [FundRequestController::class, 'approved']);
        Route::post('list', [FundRequestController::class, 'list'])->name('list');
        Route::post('action', [FundRequestController::class, 'action'])->name('action');
    });

});

Route::post('/member-check', [MemberController::class, 'checkMember'])->name('member.check');