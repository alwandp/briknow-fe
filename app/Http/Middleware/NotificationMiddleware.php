<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class NotificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token_auth = session('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/notif');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $allnotification    = $hasil->data->data;
                    $unread             = $hasil->data->unread;
                    $congrats           = $hasil->data->congrats;
                    // numpang ngambil data divisi buat edit profile
                    // kalo buat middeware lagi takut makan waktu execute :(
                    $divisi             = $hasil->data->divisi;
                    $direktorat             = $hasil->data->direktorat;
                }else{
                    $allnotification    = [];
                    $unread             = 0;
                    $congrats           = [];
                    $divisi             = [];
                    $direktorat         = [];
                }
            }else{
                $allnotification    = [];
                $unread             = 0;
                $congrats           = [];
                $divisi             = [];
                $direktorat         = [];
            }
        }catch (\Throwable $th) {
            $allnotification    = [];
            $unread             = 0;
            $congrats           = [];
            $divisi             = [];
            $direktorat         = [];
        }

        View::share('allnotification', $allnotification);
        View::share('count_unread', $unread);
        View::share('congrats', $congrats);
        View::share('divisi_edit_profile', $divisi);
        View::share('direktorat_edit_profile', $direktorat);
        return $next($request);
    }
}
