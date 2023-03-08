<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use stdClass;

class MyFavoriteController extends Controller
{
    public $token_auth;
    public $data;
    public $favs;

    public function index()
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
                curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/myfavorite');
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result     = curl_exec ($ch);
                $hasil      = json_decode($result);
                // dd($hasil);
                if (isset($hasil->status)) {
                    if ($hasil->status == 1) {
                        $this->data = $hasil->data->data;
                        $this->favs = $hasil->data->favs;
                        $data = $this->data;
                        $favs = $this->favs;
                        return view('myfavorite', compact(['data', 'favs']));
                    }else{
                        session()->flash('error',$hasil->data->message);
                    }
                }else{
                    session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
                    $data= [];
                    return back();
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

    public function fav_project($sort = "asc"){
        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/favorite_proj/".$sort);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if ($hasil->status == 1) {
                $data   = $hasil->data->data->favorite_project;
            }else{
                $data   = [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        if (!empty($data)) {
            $tampung = [];
            foreach ($data as $item) {
                $tampung[] = $item->project;
            }
            $temp = [];
            if ($sort == 'asc') {
                $temp = collect($tampung)->sortBy('nama');
            }else{
                $temp = collect($tampung)->sortByDesc('nama');
            }
            // kembalikan pada data
            $data = [];
            $data = $temp->values()->all();
        }

        $view = view('favorite.list',compact('data'))->render();
        return response()->json([
            'html'=>$view,
        ]);
    }

    public function fav_consultant($sort = "asc"){
        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/favorite_cons/".$sort);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if ($hasil->status == 1) {
                $data   = $hasil->data->data->favorite_consultant;
            }else{
                $data   = [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        if (!empty($data)) {
            $tampung = [];
            foreach ($data as $item) {
                $tampung[] = $item->consultant;
            }
            $temp = [];
            if ($sort == 'asc') {
                $temp = collect($tampung)->sortBy('nama');
            }else{
                $temp = collect($tampung)->sortByDesc('nama');
            }
            // kembalikan pada data
            $data = [];
            $data = $temp->values()->all();
        }

        $view = view('favorite.list2',compact('data'))->render();
        return response()->json([
            'html'=>$view,
        ]);
    }

    public function fav_com($sort = "asc"){
        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/favorite_com/".$sort);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if ($hasil->status == 1) {
                $data   = $hasil->data;
            }else{
                $data   = [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        $data = $data->data;
        $view = view('favorite.list3',compact('data'))->render();
        return response()->json([
            'html'=>$view,
            'data'=>$data,
        ]);
    }
}
