<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/notifproject');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $count_notification     = $hasil->data->data;
                    View::share('count_notification', $count_notification);
                }else{
                    $count_notification = 0;
                    View::share('count_notification',  $count_notification);
                }
            }else{
                $count_notification = 0;
                View::share('count_notification', $count_notification);
            }
        }catch (\Throwable $th) {
            $count_notification = 0;
            View::share('count_notification', $count_notification);
        }
    }
}
