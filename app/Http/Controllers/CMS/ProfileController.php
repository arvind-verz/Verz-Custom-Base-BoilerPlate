<?php

namespace App\Http\Controllers\CMS;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.PROFILE');
        $this->module = 'PROFILE';
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function edit()
    {
        $title = $this->title;
        $admin = Admin::findorfail($this->user->id);

        return view('admin.account.profile.edit', compact('title', 'admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'firstname'  =>  'required',
            'lastname'  =>  'required',
            'email' =>  'required|email',
            'password'  =>  'nullable|required_with:old_password|confirmed|min:8',
        ]);

        $admin = Admin::findorfail($this->user->id);
		if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/profile')) {
            mkdir('uploads/profile');
        }
        $destinationPath = 'uploads/profile'; // upload path
        $profile_image = '';
        $profilePath = null;
        if ($request->hasFile('profile')) {
       // dd($request);
            // Get filename with the extension
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('profile')->getClientOriginalExtension();
            // Filename to store
            $profile_image = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('profile')->move($destinationPath, $profile_image);
        }
        if ($request->hasFile('profile')) {
            if ($admin->profile) {
                File::delete($admin->profile);
            }
            $profilePath = $destinationPath . '/' . $profile_image;
            $admin->profile = $profilePath;
        }
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->email = $request->email;
        if($request->old_password)
        {
            if(!Hash::check($request->old_password, $admin->password))
            {
                return redirect()->back()->with('error', 'Old password does not match.');
            }
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }
}
