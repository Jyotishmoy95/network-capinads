<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Member;
use App\Models\AdLevelIncome;
use App\Http\Requests\Admin\Ads\IncomeSettings;
use App\Http\Requests\Admin\Settings\ChangePassword;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        $settings = Setting::find(1);
        $ad_levels = env('AD_LEVELS');
        $ad_level_incomes = AdLevelIncome::all();
        return view('admin.pages.settings.settings', compact('settings', 'ad_levels', 'ad_level_incomes'));
    }

    public function updateWelcomeLetter(Request $request)
    {
        $this->validate($request, [
            'welcome_letter' => 'required',
        ]);

        $welcome_letter = $request->welcome_letter;

        $setting = Setting::find(1);
        $setting->welcome_letter = $welcome_letter;
        $setting->save();

        return response()->json(['success' => true, 'message' => 'Welcome letter updated successfully.']);
    }

    public function updateBlockedModules(Request $request)
    {
        $this->validate($request, [
            'id'        => 'required|string',
            'status'    => 'required|numeric',
        ]);

        $setting = Setting::where('id',1)->update([
            $request->id.'_blocked' => $request->status,
        ]);

        $msg_status = $request->status ? 'blocked' : 'unblocked';

        return response()->json(['success' => true, 'message' => ucfirst($request->id).' module successfully '.$msg_status]);
    }

    public function updateWithdrawDeduction(Request $request)
    {
        $this->validate($request, [
            'minimum_withdraw'  => 'nullable|numeric|min:1',
            'maximum_withdraw'  => 'nullable|numeric|min:1',
            'deductions'        => 'required|numeric|min:0',
        ]);

        $setting = Setting::find(1);
        $setting->minimum_withdrawal = !empty($request->minimum_withdraw) ? $request->minimum_withdraw : null;
        $setting->maximum_withdrawal = !empty($request->maximum_withdraw) ? $request->maximum_withdraw : null;
        $setting->admin_charges      = $request->deductions;
        $setting->save();

        return response()->json(['success' => true, 'message' => 'Withdraw & Deduction settings updated successfully.']);
    }

    public function updateAdIncomes(IncomeSettings $request)
    {
        // Save the income settings
        $settings = Setting::find(1);
        //$settings->self_income = $request->self_income;
        $settings->income_credit_type = $request->credit_type;
        $settings->save();

        // // Delete all previous ad level income rows
        // AdLevelIncome::truncate();
        // // Insert new ad level income rows
        // foreach ($request->levels as $key => $value) {
        //     $ad_level_income = new AdLevelIncome;
        //     $ad_level_income->level = $key+1;
        //     $ad_level_income->amount = $value;
        //     $ad_level_income->save();
        // }

        return response()->json(['success' => true, 'message' => 'Ad level income settings updated successfully.']);
    }

    public function updateProfilePassword(ChangePassword $request)
    {
        $user = auth()->user();

        //check old password
        if (!\Hash::check($request->old_password, $user->password)) {
            $errors = ['old_password' => 'Old password is incorrect.'];
            return response()->json(['success' => false, 'errors' => $errors], 400);
        }

        $user->password = \Hash::make($request->password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Profile password updated successfully.']);
    }

}
