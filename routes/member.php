<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\AuthController;
use App\Http\Controllers\Member\AdController;
use App\Http\Controllers\Member\EpinController;
use App\Http\Controllers\Member\ReportController;
use App\Http\Controllers\Member\ActivationController;
use App\Http\Controllers\Member\NetworkController;
use App\Http\Controllers\Member\SettingController;
use App\Http\Controllers\Member\WithdrawController;
use App\Http\Controllers\Member\FundRequestController;



Route::name('member.')->namespace('Member')->group(function(){

    //Auth Routes
    Route::get('/',[AuthController::class, 'showLoginForm'])->middleware('guest:member');
    Route::get('/login',[AuthController::class, 'showLoginForm']);
    Route::get('/register/{id?}',[AuthController::class, 'showSignupForm']);
    Route::post('/login',[AuthController::class, 'login'])->name('login');
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
    Route::get('/signup/{id?}',[AuthController::class, 'showSignupForm']);
    Route::post('/signup',[AuthController::class, 'register'])->name('signup');
   
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('downloads', [DashboardController::class, 'downloads']);

    //Ads
    Route::name('view-ads.')->prefix('view-ads')->group(function(){
        Route::get('/index', [AdController::class, 'index']);
        Route::get('/show/{id}', [AdController::class, 'show']);
        Route::post('/view-complete', [AdController::class, 'viewComplete'])->name('view-complete');
    });
    
    //Epins
    Route::name('epins.')->prefix('epins')->group(function(){
        Route::get('/available', [EpinController::class, 'availableEpins']);
        Route::post('available-list', [EpinController::class, 'availableList'])->name('available');
        Route::get('applied', [EpinController::class, 'used']);
        Route::post('used-list', [EpinController::class, 'usedList'])->name('used');
    });

    //Activations
    Route::name('activations.')->prefix('activations')->group(function(){
        Route::get('new', [ActivationController::class, 'new']);
        Route::post('new-activation', [ActivationController::class, 'newActivation'])->name('activate');
        Route::get('report', [ActivationController::class, 'index']);
        Route::post('list', [ActivationController::class, 'list'])->name('list');
    });

    //Network
    Route::name('network.')->prefix('network')->group(function(){
        Route::get('referrals', [NetworkController::class, 'referrals']);
        Route::post('referrals-report', [NetworkController::class, 'referralsReportList'])->name('referrals');
        Route::get('downline-team', [NetworkController::class, 'downlineTeam']);
        Route::post('downline-team-report', [NetworkController::class, 'downlineTeamReportList'])->name('downlineTeam');
    });

    //Settings
    Route::name('settings.')->prefix('settings')->group(function(){
        Route::get('index', [SettingController::class, 'index']);
        Route::post('update-profile-password',[SettingController::class, 'updateProfilePassword'])->name('updateProfilePassword');
        Route::post('update-bank-details',[SettingController::class, 'updateBankDetails'])->name('updateBankDetails');
        Route::get('upload-documents',  [SettingController::class, 'uploadDocuments']);
        Route::post('upload-documents',[SettingController::class, 'saveDocuments'])->name('uploadDocuments');
        Route::post('update-profile-picture',[SettingController::class, 'updateProfilePicture'])->name('updateProfilePicture');
    });

    //Reports
    Route::name('reports.')->prefix('reports')->group(function(){
        Route::get('wallet', [ReportController::class, 'walletReport']);
        Route::post('wallet-report', [ReportController::class, 'walletReportList'])->name('wallet');
        Route::get('incentives', [ReportController::class, 'incentivesReport']);
        Route::post('incentives-report', [ReportController::class, 'incentivesReportList'])->name('incentives');
    });

    //withdrawals
    Route::name('withdrawals.')->prefix('withdrawals')->group(function(){
        Route::get('/', [WithdrawController::class, 'index']);
        Route::post('list', [WithdrawController::class, 'withdrawList'])->name('list');
        Route::get('new', [WithdrawController::class, 'newWithdraw']);
        Route::post('new-withdraw', [WithdrawController::class, 'withdraw'])->name('new');
    });

    //Fund Request
    Route::name('fund-request.')->prefix('fund-request')->group(function(){
        Route::get('/list', [FundRequestController::class, 'index']);
        Route::post('list', [FundRequestController::class, 'requestList'])->name('list');
        Route::get('new', [FundRequestController::class, 'newRequest']);
        Route::post('new-request', [FundRequestController::class, 'store'])->name('new');
    });

});

