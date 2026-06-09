<?php

namespace App\Helpers;

use App\Models\UserActivity;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class ActivityLogger
{
    public static function log($action, $resource, $description = null)
    {
        if (!Auth::check()) return;

        $agent = new Agent();
        $agent->setUserAgent(request()->userAgent());

        $device = '';
        if ($agent->isPhone()) $device = 'Mobile - ';
        elseif ($agent->isTablet()) $device = 'Tablet - ';
        else $device = 'Desktop - ';

        $device .= $agent->browser() . ' on ' . $agent->platform();

        UserActivity::create([
            'user_id'     => Auth::id(),
            'role'        => Auth::user()->role ?? '-',
            'action'      => $action,
            'resource'    => $resource,
            'ip_address'  => request()->ip(),
            'device_info' => $device,
            'description' => $description,
        ]);
    }
}