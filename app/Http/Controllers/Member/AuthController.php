<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Member\MemberSignup;
use App\Http\Requests\Member\MemberLogin;
use App\Models\Member;
use App\Models\Hirarchy;
use App\Models\DownlineMember;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('member');
    }

    public function showLoginForm(){
        return view('members.auth.login');
    }

    public function showSignupForm($id='CAP1001'){
        $member  = NULL;
        if(!empty($id)){
            $member = Member::where('member_id', $id)->first();
        }
        return view('members.auth.register', compact('id', 'member'));
    }

    public function register(MemberSignup $request)
    {

        if(isModuleBlocked('registration')){
            return response()->json(['success' => false, 'message' => 'Oops! Something went wrong. Please try again later.'], 422);
        }

        $member_id = $this->generateMemberID();
        $password = rand(1000, 9999);

        //$placement_id = $request->placement ? $request->placement : location_finder($request->sponsor, $request->position);

        $member             = new Member;
        $member->member_id  = $member_id;
        $member->fname      = $request->fname;
        $member->lname      = $request->lname;
        $member->full_name  = $request->fname . ' ' . $request->lname;
        $member->email      = $request->email;
        $member->mobile     = $request->mobile;
        $member->password   = \Hash::make($password);
        $member->plain_pwd  = $password;
        $member->save();
        
        $hirarchy               = new Hirarchy;
        $hirarchy->member_id    = $member_id;
        $hirarchy->sponsor_id   = $request->sponsor;
        $hirarchy->save();

        $this->downlineUtil($member_id, $request->sponsor, 1);

        return response()->json(['status' => true, 'message' => 'Member registered successfully', 'username' => $member_id, 'password' => $password], 200);
    }


    protected function downlineUtil($member_id, $sponsor_id, $level)
    {
        $downline               = new DownlineMember;
        $downline->member_id    = $sponsor_id;
        $downline->location_id  = $member_id;
        $downline->level        = $level;
        $downline->save();

        //Check Downline of Sponsor
        $downline_sponsor = Hirarchy::select('sponsor_id')->where('member_id', $sponsor_id)->first();
        if(!empty($downline_sponsor->sponsor_id)){
            return $this->downlineUtil($member_id, $downline_sponsor->sponsor_id, $level + 1);
        }

        return true;
    }


    protected function generateMemberID()
    {
        $rand = rand(100000,999999);
        $prefix = env('MEMBER_ID_PREFIX');

        $member_id = $prefix.$rand;

        if(Member::where('member_id', $member_id)->exists()){
            return $this->generateMemberID();
        }

        return $member_id;
    }

    public function login(MemberLogin $request){
        $data = $request->only('username', 'password');

        $credentials = [
            'member_id' => $data['username'],
            'password'  => $data['password']
        ];
        $credentials['status'] = 1;

        if(isModuleBlocked('login')){
            $errors = ['username' => 'Invalid username or password'];
            return response()->json([ 'status' => false, 'errors' => $errors], 401);
        }

        if(Auth::guard('member')->attempt($credentials)){
            return response()->json([ 'status' => true, 'message' => 'Login Successfull'], 200);
        }else{
            $errors = ['username' => 'Invalid username or password'];
            return response()->json([ 'status' => false, 'errors' => $errors], 401);
        }

    }

    public function logout(Request $request){
        Auth::guard('member')->logout();
        $request->session()->invalidate();
        return redirect('/member/login');
    }

}
