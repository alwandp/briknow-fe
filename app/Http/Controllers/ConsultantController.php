<?php

namespace App\Http\Controllers;

use App\consultant;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public $token_auth;
    public $data;
    public $is_favorit;
    
    public function index($id)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/consultant/'.$id);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $this->data = $hasil->data->data;
                $this->is_favorit = $hasil->data->is_favorit;
                $data = $this->data;
                $is_favorit = $this->is_favorit;
                $tahun = $hasil->data->tahun;
                // dd($data);
                return view('consultant', compact(['data', 'tahun', 'is_favorit']));
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
            return back();
        }
    }

    public function all(){ //persiapan integrasi search
        try {
            // $get            = Project::search('')->get();
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.ES_url').'/consultant/_search?pretty=true&q=*&size=10000&sort=created_at:desc');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if (isset($hasil->hits->hits)) {
                    $data['data']         = $hasil->hits->hits;
                    $data['count']        = $hasil->hits->total->value;
            }else{
                $data['data']         = [];
                $data['count']        = 0;
            }
            // $data['data']    =   $get;
            // $data['count']    =   $get->count();
            return response()->json([
                "status"    => '1',
                "data"      => $data
            ]);
        } catch (\Throwable $th) {
            $data['message']    =   "Terjadi Kesalahan, Coba Sesaat lagi";
            return response()->json([
                "status"    => '0',
                "data"      => $data
            ]);
        }
    }

    public function proj_consultant($kunci = "",$search="*",$sort = "desc"){
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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/project_consultant/".$kunci."/".$search."/".$sort);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json(['hasil' => $hasil]);
            if ($hasil->status == 1) {
                $data   = $hasil->data;
            }else{
                $data   = [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        $view = view('consultant.list',compact('data'))->render();
        return response()->json([
            'html'=>$view,
        ]);
    }

    public function getConsultant(){
        try {
            $data       = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/getconsultant");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data   = $hasil->data->data;
                }else{
                    $data   = [];
                }
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        return response()->json([
            'data'=>$data,
        ]);
    }
}
