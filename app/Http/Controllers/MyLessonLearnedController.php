<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyLessonLearnedController extends Controller
{
    public function toMyLessonPath($type){
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $chDiv = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/mylessonlearned/all');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            curl_setopt($chDiv, CURLOPT_URL, config('app.url_be') . 'api/divisi/all');
            curl_setopt($chDiv, CURLOPT_HTTPGET, 1);
            curl_setopt($chDiv, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($chDiv, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($chDiv, CURLOPT_HTTPHEADER, $headers);
            $resultDivisi = curl_exec($chDiv);
            $hasilDivisi = json_decode($resultDivisi);
            $direktorat = [];
            $divisiRes = [];

            if ($hasilDivisi->status == 1) {
                $this->direktorat = $hasilDivisi->data->direktorat;
                $divisiRes = $hasilDivisi->data->divisi;
                $direktorat = $this->direktorat;
            } else {
                session()->flash('error', $hasilDivisi->data->message);
            }

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data;

                    return view('mylessonlearned', compact(['data', 'direktorat', 'divisiRes', 'type']));
                }else{
                    session()->flash('error',$hasil->data->message);
                    $data= [];

                    return view('mylessonlearned', compact(['data', 'direktorat', 'divisiRes', 'type']));
                }
            }else{
                session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
                $data= [];
                return back();
            }
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
            $data= [];

            return view('mylessonlearned', compact(['data']));
        }
    }

    public function index()
    {
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $chDiv = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/mylessonlearned');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            curl_setopt($chDiv, CURLOPT_URL, config('app.url_be') . 'api/divisi/all');
            curl_setopt($chDiv, CURLOPT_HTTPGET, 1);
            curl_setopt($chDiv, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($chDiv, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($chDiv, CURLOPT_HTTPHEADER, $headers);
            $resultDivisi = curl_exec($chDiv);
            $hasilDivisi = json_decode($resultDivisi);
            $direktorat = [];
            $divisiRes = [];

            if ($hasilDivisi->status == 1) {
                $this->direktorat = $hasilDivisi->data->direktorat;
                $divisiRes = $hasilDivisi->data->divisi;
                $direktorat = $this->direktorat;
            } else {
                session()->flash('error', $hasilDivisi->data->message);
            }

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data;

                    return view('mylessonlearned', compact(['data', 'direktorat', 'divisiRes']));
                }else{
                    session()->flash('error',$hasil->data->message);
                    $data= [];

                    return view('mylessonlearned', compact(['data', 'direktorat', 'divisiRes']));
                }
            }else{
                session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
                $data= [];
                return back();
            }
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
            $data= [];

            return view('mylessonlearned', compact(['data']));
        }
    }

    public function public()
    {
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $chDiv = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/mylessonlearned/all');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            curl_setopt($chDiv, CURLOPT_URL, config('app.url_be') . 'api/divisi/all');
            curl_setopt($chDiv, CURLOPT_HTTPGET, 1);
            curl_setopt($chDiv, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($chDiv, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($chDiv, CURLOPT_HTTPHEADER, $headers);
            $resultDivisi = curl_exec($chDiv);
            $hasilDivisi = json_decode($resultDivisi);
            $direktorat = [];
            $divisiRes = [];

            if ($hasilDivisi->status == 1) {
                $this->direktorat = $hasilDivisi->data->direktorat;
                $divisiRes = $hasilDivisi->data->divisi;
                $direktorat = $this->direktorat;
            } else {
                session()->flash('error', $hasilDivisi->data->message);
            }

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data;

                    return view('lessonlearned', compact(['data', 'direktorat', 'divisiRes']));
                }else{
                    session()->flash('error',$hasil->data->message);
                    $data= [];

                    return view('lessonlearned', compact(['data', 'direktorat', 'divisiRes']));
                }
            }else{
                session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
                $data= [];
                return back();
            }
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
            $data= [];

            return view('lessonlearned', compact(['data']));
        }
    }
}
