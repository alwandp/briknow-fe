<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('is_user_online')) {
    function is_user_online($user_id){
        if (Cache::has('user-is-online-'.$user_id)) {
            return true;
        }else{
            return false;
        }
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($size){
        $base = log($size) / log(1024);
        $suffix = array("", "KB", "MB", "GB", "TB");
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }
}

if (!function_exists('phone')) {
    function phone($angka){
        return '+62'.$angka;
    }
}

function asset_app($path, $secure = null)
{
    return app('url')->asset("".$path, $secure);
}
