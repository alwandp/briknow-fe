<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\User_log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function long_many_time_login(){
        if (session::has('l_e_num')) {
            $count = session::pull('l_e_num');
            $count++;
            if ($count < 3) {
                session::put('l_e_num',$count);
            }else{
                // clear
                session::flush();
                // 1 menit suspense
                $time = Carbon::now()->addMinutes(1);
                session::put('l_e_suspend',$time);
                return true;
            }
        }else{
            session::put('l_e_num',1);
        }
        return false;
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'personal_number'       =>  'required|numeric|digits:8',
            'katasandi'             =>  'required',
            // 'captcha'               =>  'required|captcha'
        ]);

            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                    ];
            $postData = [
                'personal_number' => $request->personal_number,
                'katasandi' => $request->katasandi,
                'ip' => $_SERVER['REMOTE_ADDR'],
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/login_web');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);

            Log::info("DATA FE LOGIN", [$hasil]);


        //    dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    // refresh session
                    Session::flush();
                    $temp['id']                 = $hasil->data->id;
                    $temp['avatar_id']          = $hasil->data->avatar_id;
                    $temp['exp']                = $hasil->data->exp;
//                    $temp['level_id']           = $hasil->data->level_id;
//                    $temp['level_name']         = $hasil->data->level_name;
                    $temp['name']               = $hasil->data->name;
                    $temp['personal_number']    = $hasil->data->personal_number;
                    $temp['username']           = $hasil->data->username;
                    $temp['email']              = $hasil->data->email;
                    $temp['direktorat']         = $hasil->data->direktorat;
                    $temp['divisi']             = $hasil->data->divisi;
                    $temp['last_login_at']      = $hasil->data->last_login_at;
                    $temp['login_at']           = $hasil->data->login_at;
                    $temp['token_bri']          = $hasil->data->token_bri;
                    //$temp['token_bri']          = 'dummy';
                    $temp['token']              = $hasil->data->token;
                    $temp['role']               = $hasil->data->role;
                    session($temp);
                    session(['logged_in' => true]);
                    Session::flash('term', true);
                    setcookie('token', $temp['token'], 0, "/", "");
                    setcookie('url_be', config('app.url_be'), 0, "/", "");
                    return redirect('/');
                }else{
                    if ($hasil->status == 0 && isset($hasil->data->validator)) {
                        $validasi = '<ul>';
                        foreach ($hasil->data->validator as $key => $value) {
                            $validasi .= "<li>$value[0]</li>";
                        }
                        $validasi .= '</ul>';

                        Session::flash('error', $validasi);
                    }elseif ($this->long_many_time_login() == true) {
                        Session::flash('error', 'Terlalu Sering Melakukan Kesalahan Saat Login');
                    }else{
                        Session::flash('error', $hasil->data->message);
                    }

                    return back();
                }
            }else{
                Session::flash('error','Something Problemo');
                return back();
            }
    }

    public function logout(Request $request)
    {
        $token = $request->session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/logout');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if ($hasil->status == 1) {
                Cache::put('user-is-online-'.session('id'), true, 0);
                $request->session()->flush();
                return redirect('/login');
            }else{
                session()->flash('error',$hasil->data->message);
                return back();
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    $request->session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error','Mengirim Data Bermasalah , Silahkan Coba Lagi');
            return back();
        }
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img('flat')]);
    }
}
