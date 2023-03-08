<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KatalogController extends Controller
{
    public $data;
    public $count;
    public $token_auth;

    public function default(){
        $this->data   = [];
        $this->count   = "";
    }

    public function index(){
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
                $divisi = $hasil->data->divisi;
                $consultant = $hasil->data->consultant;
                $tahun = $hasil->data->tahun;
                $lessonlearn = $hasil->data->lessonlearn;
                $keywords = $hasil->data->keywords;
            }else{
                $divisi     = [];
                $consultant = [];
                $tahun      = [];
                $lessonlearn    = [];
                $keywords   = [];
            }
        } catch (\Throwable $th) {
            $divisi     = [];
            $consultant = [];
            $tahun      = [];
            $lessonlearn    = [];
            $keywords   = [];
        }
        // dd($tahun);
        return view('Katalog',compact(['divisi','consultant','tahun','lessonlearn','keywords']));
    }

    public function pencarian($key){
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
            // dd($hasil);
            if ($hasil->status == 1) {
                $divisi = $hasil->data->divisi;
                $consultant = $hasil->data->consultant;
                $tahun = $hasil->data->tahun;
                $keywords = $hasil->data->keywords;
            }else{
                $divisi     = [];
                $consultant = [];
                $tahun      = [];
                $keywords   = [];
            }
        } catch (\Throwable $th) {
            $divisi     = [];
            $consultant = [];
            $tahun      = [];
            $keywords   = [];
        }

        $kunci = $key;
        return view('Katalog',compact(['kunci','divisi','consultant','tahun','keywords']));
    }

    public function cari(){
        $tampung = request()->search;
        if ($tampung == '') {
            return Redirect()->to('/katalog');
        }else{
            return Redirect()->to('/katalog/'.$tampung);
        }
    }

    public function filterisasi()
    {
        $sort       =   request()->sort??"disabled";
        $sort2      =   request()->sort2??"disabled";
        $from       =   request()->from??1;
        $search     =   request()->search??'*';
        $divisi     =   request()->f_divisi??"";
        $consultant =   request()->f_konsultant??"";
        $tahun      =   request()->f_tahun??"";

        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            $postData = [
                            "sort"       => $sort,
                            "sort2"      => $sort2,
                            "from"       => $from,
                            "search"     => $search,
                            "divisi"     => $divisi,
                            // "konsultant" => str_replace(' ', '-', $consultant),
                            "konsultant" => $consultant,
                            "tahun"      => $tahun
                        ];
            // return response()->json(['cek' => $postData]);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/fit");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if ($hasil->status == 1) {
                $this->data         = $hasil->data->data;
                $this->count        = $hasil->data->count;
            }else{
                $this->default();
            }
        }catch (\Throwable $th) {
            $this->default();
        }
        $data    = $this->data;
        $count   = $this->count;
        if (request()->ajax()) {
    		$view = view('Katalog_list',compact('data','count'))->render();
            return response()->json([
                'html'=>$view,
                'all'=>$count
            ]);
        }

        return view('Katalog',compact('data','count'));
    }
}