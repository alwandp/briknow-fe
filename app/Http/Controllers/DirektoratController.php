<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DirektoratController extends Controller
{
    public $token_auth;
    public $data;
    public $data_com_init;
    public $data_stra;
    public $data_impl;

    public function indexDirComsup($dir, $from)
    {
        {
            $this->token_auth = session()->get('token');
            $dir = str_replace(' ', '%20', $dir);

            try {
                $ch = curl_init();
                $headers  = [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "Authorization: Bearer $this->token_auth",
                ];
                curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/divisi/direktorat/'.$dir);
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result     = curl_exec ($ch);
                $hasil      = json_decode($result);
                // dd($hasil);

                if ($hasil->status == 1) {
                    $this->data = $hasil->data->data_divisi;
                    $this->data_com_init = $hasil->data->data_init;
                    $this->data_stra = $hasil->data->data_stra;
                    $this->data_impl = $hasil->data->data_impl;
                    $data = $this->data;
                    $dataComInit = $this->data_com_init;
                    $dataStra = $this->data_stra;
                    $dataImpl = $this->data_impl;
                    return view('direktorat-comsup', compact(['data', 'dataComInit', 'dataStra', 'dataImpl', 'from']));
                }else{
                    session()->flash('error',$hasil->data->message);
                }
            }catch (\Throwable $th) {
                if(isset($hasil->message)){
                    if ($hasil->message == "Unauthenticated.") {
                        session()->flush();
                        session()->flash('error','Session Time Out');
                        return redirect('/login');
                    }
                }
                session()->flash('error','Get Data Bermasalah , Silahkan Coba Lagi');
            }
        }
    }

}
