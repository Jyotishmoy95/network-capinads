<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Member\Settings\ChangePassword;
use App\Models\MemberBankDetail;
use App\Models\Member;
use App\Http\Requests\Member\Settings\UpdateBankDetails;
use App\Http\Requests\Member\Settings\ChangeProfilePicture;
use App\Models\MemberDocument;
use App\Http\Requests\Member\Settings\UploadDocuments;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:member');
    }

    public function index()
    {
        $bank_detail = MemberBankDetail::where('member_id', auth()->user()->member_id)->first();
        $document_types = ['aadhar', 'pan', 'passport', 'driving_license', 'other'];
        $document_details = MemberDocument::where('member_id', auth()->user()->member_id)->first();
        return view('members.pages.settings.settings', compact('bank_detail', 'document_types', 'document_details'));
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

    public function updateBankDetails(UpdateBankDetails $request)
    {
        $user = auth()->user();

        $bank_detail = MemberBankDetail::where('member_id', $user->member_id)->first();

        if (!$bank_detail) {
            $bank_detail = new MemberBankDetail();
            $bank_detail->member_id = $user->member_id;
        }

        $bank_detail->bank_name         = $request->bank_name;
        $bank_detail->account_name      = $request->account_name;
        $bank_detail->account_number    = $request->account_number;
        $bank_detail->ifsc_code         = $request->ifsc_code;
        $bank_detail->save();

        return response()->json(['success' => true, 'message' => 'Bank details updated successfully.']);
    }

    public function saveDocuments(UploadDocuments $request)
    {
        $validated = $request->validated();

        //Store uploaded image
        $file = $request->file('document_photo');
        $adImage = $file->getRealPath(); //get the path of image
        $imageExt = $file->getClientOriginalExtension(); // file extension
        $imageNameToSave = auth()->user()->member_id.'_'.$validated['document_type'].'.'.$imageExt; // rename image

        $img = Image::make($adImage);
        $img->save(public_path('uploads/documents/').$imageNameToSave, 60);

        MemberDocument::updateOrCreate(
            ['member_id' => auth()->user()->member_id],
            [  
                'member_id'         => auth()->user()->member_id,
                'document_type'     => $validated['document_type'],
                'document_photo'    => $imageNameToSave,
                'document_number'   => $validated['document_number'],
                'status'            => 0
            ]
        );
        
        return response()->json(['success' => true, 'message' => 'Document uploaded successfully.']);
    }

    public function updateProfilePicture(ChangeProfilePicture $request)
    {
        //Store uploaded image
        $file = $request->file('photo');
        $adImage = $file->getRealPath(); //get the path of image
        $imageExt = $file->getClientOriginalExtension(); // file extension
        $imageNameToSave = auth()->user()->member_id.'_'.time().'.'.$imageExt; // rename image
        $img = Image::make($adImage);
        $img->fit(250);
        $img->save(public_path('uploads/profile-pictures/').$imageNameToSave, 60);

        $member = Member::find(auth()->user()->id);

        //delete old photo
        if($member->photo !== 'blank-user.webp'){
            $oldImage = public_path('uploads/profile-pictures/').$member->photo;
            if(file_exists($oldImage)){
                unlink($oldImage);
            }
        }

        $member->photo = $imageNameToSave;
        $member->save();

        return response()->json(['success' => true, 'message' => 'Profile picture updated successfully.']);

    }

}
