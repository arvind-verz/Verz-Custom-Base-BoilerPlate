<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SystemSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SYSTEM_SETTING');
        $this->module = 'SYSTEM_SETTING';
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function edit()
    {
        $title = $this->title;
        $system_setting = SystemSetting::first();

        return view('admin.account.system_setting.edit', compact('title', 'system_setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_title' =>  'required',
            'logo'  =>  'nullable|file|mimes:jpg,png,gif,jpeg|max:5000',
            'favicon'  =>  'nullable|file|mimes:ico|max:1000',
            'email_sender_name' =>  'required',
            'from_email'    =>  'required|email',
            'to_email'  =>  'required|email',
            'pagination'    =>  'required|numeric|min:20|max:200',
        ]);

        $system_setting = new SystemSetting;
        if($request->id)
        {
            $system_setting = SystemSetting::findorfail($request->id);
            $system_setting->updated_at = Carbon::now();
        }
        $system_setting->site_title = $request->site_title;
        $system_setting->site_description = $request->site_description;
        $system_setting->site_keywords = $request->site_keywords;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $logo->getClientOriginalName();
            $filepath = 'storage/logo/';
            Storage::putFileAs(
                'public/logo', $logo, $filename
            );
            $path_logo = $filepath . $filename;
            $system_setting->logo = $path_logo;
        }
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $favicon->getClientOriginalName();
            $filepath = 'storage/favicon/';
            Storage::putFileAs(
                'public/favicon', $favicon, $filename
            );
            $path_favicon = $filepath . $filename;
            $system_setting->favicon = $path_favicon;
        }
        if($request->notification_emails)
        {
            $notification_emails = explode(',', $request->notification_emails);
            if(count($notification_emails)>5)
            {
                return redirect()->back()->with('error', 'Max 5 email can be inputed.');
            }
            foreach($notification_emails as $email)
            {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return redirect()->back()->with('error', 'Invalid email format for notification emails');
                }
            }
            $system_setting->notification_emails = $request->notification_emails;
        }
        $system_setting->email_sender_name = $request->email_sender_name;
        $system_setting->from_email = $request->from_email;
        $system_setting->to_email = $request->to_email;
        $system_setting->pagination = $request->pagination;
        $system_setting->google_analytics_code = $request->google_analytics_code;
        $system_setting->save();

        return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }
}
