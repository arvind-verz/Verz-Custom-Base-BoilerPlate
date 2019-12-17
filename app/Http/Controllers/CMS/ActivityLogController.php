<?php

namespace App\Http\Controllers\CMS;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    use SystemSettingTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.ACTIVITYLOG');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = $this->title;
        $activity_log = ActivityLog::join('admins', 'activity_log.causer_id', '=', 'admins.id')->select('activity_log.updated_at as activity_log_updated', 'activity_log.id as acid', 'admins.id as aid', 'activity_log.*', 'admins.*')->paginate($this->systemSetting()->pagination);

        return view('admin.activity_log.index', compact('title', 'activity_log'));
    }
}
