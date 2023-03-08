<?php

namespace App\Http\Controllers;

use App\divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DivisiController extends Controller
{
    public $token_auth;
    public $data;
    public $data_com_init;
    public $data_stra;
    public $data_impl;

    public function index($id)
    {
        {
            $this->token_auth = session()->get('token');
            try {
                $ch = curl_init();
                $headers  = [
                            'Content-Type: application/json',
                            'Accept: application/json',
                            "Authorization: Bearer $this->token_auth",
                        ];
                curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/divisi/'.$id);
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result     = curl_exec ($ch);
                $hasil      = json_decode($result);
                // dd($hasil);
                if ($hasil->status == 1) {
                    $this->data = $hasil->data->data;
                    $data = $this->data;
                    $tahun = $hasil->data->tahun;
                    return view('divisi', compact(['data', 'tahun']));
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


    public function indexDivisiComsup($from, $id)
    {
        {
            $this->token_auth = session()->get('token');
            try {
                $ch = curl_init();
                $headers  = [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "Authorization: Bearer $this->token_auth",
                ];
                curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/divisi/'.$id);
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result     = curl_exec ($ch);
                $hasil      = json_decode($result);
                // dd($hasil);
                if ($hasil->status == 1) {
                    $this->data = $hasil->data->data;
                    $this->data_com_init = $hasil->data->data_cominit;
                    $this->data_stra = $hasil->data->data_stra;
                    $this->data_impl = $hasil->data->data_impl;
                    $data = $this->data;
                    $dataComInit = $this->data_com_init;
                    $dataStra = $this->data_stra;
                    $dataImpl = $this->data_impl;
                    $tahun = $hasil->data->tahun;
                    return view('divisi-comsup', compact(['data', 'dataComInit', 'dataStra', 'dataImpl', 'tahun', 'from']));
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

    public function proj_divisi($kunci = "",$search="*"){
        try {
            $search = str_replace(' ', '_', $search);

            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/proj_divisi/".$kunci."/".$search);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if ($hasil->status == 1) {
                $data   = $hasil->data;
            }else{
                $data   = [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        $view = view('divisi.list',compact('data'))->render();
        return response()->json([
            'html'=>$view,
        ]);
    }

    public function riwayat($tahun){
        try {
            $this->token_auth = session()->get('token');

            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/bahan_katalog');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if ($hasil->status == 1) {
                $tahun = $hasil->data->tahun;
            }else{
                $tahun      = [];
            }
        } catch (\Throwable $th) {
            $tahun      = [];
        }
        return response()->json([
            'data'  =>  $tahun
        ]);
    }
}
