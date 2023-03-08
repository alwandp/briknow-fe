<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ViewProjectController extends Controller
{
    public function index($slug){
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/projectpreview/'.$slug);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // $test = \Carbon\Carbon::create($hasil->data->data->tanggal_mulai)->format('d F Y');
            // $x = \Carbon\Carbon::parse($hasil->data->data->tanggal_mulai)
            // ->addSeconds(1)
            // ->format('H:i:s');
            // dd($x);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;

                    if (session()->get('role') <> 3) {
                        $role = 0;
                        if ($data->user_maker == session()->get('personal_number') && ($data->flag_mcs == 0)) {
                            $role = 0;
                        }elseif($data->user_checker == session()->get('personal_number') && ($data->flag_mcs == 1)){
                            $role = 1;
                        }elseif($data->user_signer == session()->get('personal_number') && ($data->flag_mcs == 2)){
                            $role = 2;
                        }
                    }else{
                        $role = 3;
                    }

                    if(request()->ajax()) {
                        if (file_exists(public_path('storage/'.$data->thumbnail))) {
                            $data->thumbnail = config('app.FE').'storage/'.$data->thumbnail;
                        }else{
                            $data->thumbnail = config('app.FE').'assets/img/boxdefault.svg';
                        }
                    }
                    return view('project.view_project',compact(['data','role']));
                }else{
                    return response()->json([
                        'html' => 'Gagal memuat Proyek',
                    ]);
                }
            }else{
                return response()->json([
                    'html' => 'Gagal memuat Proyek',
                ]);
            }
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            return response()->json([
                'html'=> 'Something Problem, Gagal memuat Proyek'.$th,
            ]);
        }
    }
}
