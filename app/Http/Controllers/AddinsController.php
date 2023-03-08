<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddinsController extends Controller
{
    public function cek_auth() //cek auth
    {
        $token_auth = request()->data;
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];

            // $postData = [
            //     'id' => $id
            // ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/cek_auth');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => '1',
                        "data"      => $hasil->data
                    ],200);
                }else{
                    $data['message']    =   'Cek Auth gagal.';
                    return response()->json([
                        "status"    => 0,
                        "data"      => $data
                    ],400);
                }
            }else{
                $data['message']    =   'Cek Auth gagal.';
                return response()->json([
                    "status"    => 0,
                    "data"      => $data
                ],400);
            }
        }catch (\Throwable $th) {
            $data['message']    =   'Cek Auth gagal.';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function login_addin() //login
    {
        $pn = request()->personal_number;
        $pass = request()->katasandi;
        $ip = request()->ip;

        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        // "Authorization: Bearer $token_auth",
                    ];

            $postData = [
                'personal_number' => $pn,
                'katasandi' => $pass,
                'ip' => $ip
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/login');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            return response()->json($hasil); //setelah di console cocok dengan Addins yg ini
            // return response()->json([
            //     "status"    =>  1,
            //     "data"      =>  $hasil
            // ],200);
        }catch (\Throwable $th) {
            $data['message']    =   'Login gagal.';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function logout() //logout
    {
        $token_auth = request()->token;
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];

            // $postData = [
            //     'id' => $id
            // ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/logout');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            return response()->json([
                "status"    => '1',
                "data"      => $hasil
            ]);
        }catch (\Throwable $th) {
            $data['message']    =   'Logout gagal.';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function cariall($key="") //search home
    {
        $token_auth = request()->token;
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];

            $postData = [
                'key' => $key
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/search/'.$key);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            return response()->json($hasil);
            // if ($hasil->status == 1) {
            //     return response()->json([
            //         'status'    =>  1,
            //         "data"      => $hasil->data
            //     ],200);
            // }else{
            //     $data['message']    =   'Get Data Gagal, Mohon Reload Page';
            //     return response()->json([
            //         'status'    =>  0,
            //         'data'      =>  $hasil->data
            //     ],400);
            // }
        }catch (\Throwable $th) {
            $data['message']    =   'Get Data Gagal, Mohon Reload Page';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function searchproject()
    {
        $token_auth = request()->token;
        $data       = request()->searchTerm;
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];

            $postData = [
                'searchTerm' => $data
            ];
            // dd(json_encode($postData));
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/searchproject');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
            return response()->json($hasil);
        }catch (\Throwable $th) {
            $data['message']    =   'Get Data Gagal, Mohon Reload Page';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function detailproject($id) //download
    {
        $token_auth = request()->token;
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/detailproject/'.$id);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if ($hasil->status == 1) {
                return response()->json([
                    'status'    =>  1,
                    "data"      =>  $hasil->data
                ],200);
            }else{
                $data['message']    =   'Mengambil Data Project Gagal, Coba Lagi.';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        }catch (\Throwable $th) {
            $data['message']    =   'Mengambil Data Project Gagal, Coba Lagi.';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function detail($id) //detail
    {
        $token_auth = request()->token;
        // try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/detail/'.$id);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        'status'    =>  '1',
                        'data'      =>  $hasil->data,
                        'keywords'  =>  $hasil->keywords
                    ],200);
                }else{
                    $data['message']    =   'Get Data Failed.';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $hasil->data
                    ],400);
                }
            }else{
                $data['message']    =   'Get Data Failed.';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $hasil->data
                ],400);
            }
        // }catch (\Throwable $th) {
        //     $data['message']    =   'Get Data Failed.';
        //     return response()->json([
        //         'status'    =>  0,
        //         'data'      =>  $data
        //     ],400);
        // }
    }
}
