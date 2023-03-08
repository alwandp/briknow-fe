<?php

namespace App\Http\Controllers;

use App\favorite_consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FavoriteConsultantController extends Controller
{
    public function index()
    {
        //
    }

    public function save($id)
    {
        try {
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/bookmark_consultant/".$id);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            return response()->json($hasil);
        }catch (\Throwable $th) {
            return response()->json([
                "status"    =>  0,
                "message"   =>  "Data gagal diproses",
            ],500);
        }
    }
}
