<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManageUserController extends Controller
{
    public $token_auth;
    public $data;
    public $role;

    public function index()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageuser');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            //dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $token_auth = $this->token_auth;
                    $data = $hasil->data->data;
                    $self = $hasil->data->self;
    
                    // perbarui session
                    session::forget('role');
                    session::put('role', $self->role);
    
                    if ($self->role <> 3) {
                        session()->flash('error', 'Akses Ditolak');
                        return redirect('/');
                    }
    
                    return view('admin.manageuser.manage_user', compact(['data', 'token_auth']));
                }else{
                    session()->flash('error',$hasil->data->message);
                    return back();
                }
            }else{
                session()->flash('error','Get Data Failed');
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
            return back();
        }
    }

    public function list_admin($search, $page){
        $this->token_auth = session()->get('token');
        $search           = str_replace(" ","_",urldecode($search));
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageuser/$search?page=$page");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                      'status'	=>	1,
                      'data'		=>	$hasil->data
                    ]);
                }else{
                    $data['message']    =   'GET Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],200);
            }
        }catch (\Throwable $th) {
            $data['message']    =   'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],200);
        }
    }

    public function validasi()
    {
        return request()->validate([
            'role' => "required",
        ]);
    }

    public function edit($id)
    {
        // dd(request('role'));
        $this->validasi();
        $this->role = request('role');
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            
            $postData = [
                'role' => $this->role
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageuser/edit/'.$id);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if ($hasil->status == 1) {
                return redirect('/manageuser');
                // session()->flash('success','Edit user berhasil');
            }else{
                return redirect('/manageuser');
                session()->flash('error',$hasil->data->message);
            }
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error', 'Post Data Bermasalah , Silahkan Coba Lagi');
            return back();
        }
    }

    public function listuser($search="*",$page=1){
        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageuser/".$search."?page=".$page);
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
        // return response()->json($data);
        $view = view('admin.manageuser.list',compact('data'))->render();
        return response()->json([
            'html'=>$view,
        ]);
    }

    public function searchuser(){
        $pn                 = request()->input('pn')??NULL;
        $mode               = (int)request()->input('mode')??NULL;
        $this->token_auth   = session()->get('token');
        $this->token_bri    = session()->get('token_bri');
        try {
            if ($pn <> null) {
                
                // -------------handle mode
                // mode 11 = bebas
                // mode 33 = engga boleh admin yang udah existing 
                // mode 66 = engga boleh dirinya dan admin (buat kontribusi checker signer)
                if ($mode == 11) {
                    $uri    =   'searchpn';
                }elseif($mode == 33){
                    $uri    =   'searchma';
                }elseif($mode == 66){
                    $uri    =   'searchkcs';
                }
                // -------------

                $ch = curl_init();
                $headers  = [
                            'Content-Type: application/json',
                            'Accept: application/json',
                            "Authorization: Bearer $this->token_auth",
                        ];
                
                $postData = [
                            'pn'        => $pn,
                            'token_bri' => $this->token_bri
                        ];
    
                curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageuser/'.$uri);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result     = curl_exec ($ch);
                $hasil      = json_decode($result);
		            //dd($hasil);
                if (isset($hasil->status)) {
                    if ($hasil->status == 1) {
                        $response['id']                 = (int)$hasil->data->personalnumber;
                        $response['text']               = $hasil->data->personalnumber. " - ". $hasil->data->nama;

                        return response()->json([
                            'status'    =>  1,
                            'items'     =>  array($response)
                        ]);
                    }
                }
            }
            
            return response()->json([
                'status'    =>  0,
                'items'     =>  '',
                'cek'       => $hasil //cek jika ada error
            ]);
        }catch (\Throwable $th) {
            return response()->json([
                'status'    =>  0,
                'items'     =>  ''
            ]);
        }
    }

    public function admin_create(){
        try {
            $this->token_auth   = session()->get('token');
            $this->token_bri    = session()->get('token_bri');
            $pn                 = request()->pn;

            if ($pn <> null) {
                $ch = curl_init();
                $headers  = [
                            'Content-Type: application/json',
                            'Accept: application/json',
                            "Authorization: Bearer $this->token_auth",
                        ];
                
                $postData = [
                            'pn'        => $pn,
                            'token_bri' => $this->token_bri
                        ];
    
                curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageuser/admin/create');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result     = curl_exec ($ch);
                $hasil      = json_decode($result);
                //dd($hasil);
                
                if (isset($hasil->status)) {
                    if ($hasil->status == 1) {
                        session()->flash('success','User Berhasil Dijadikan Admin');
                        return back();                
                    }
                }

                session()->flash('error','User Gagal Dijadikan Admin');
                return back();                
            }else{
                session()->flash('error','Personal Number Tidak Boleh Kosong');
                return back();
            }
        }catch (\Throwable $th) {
            session()->flash('error','Something Problem');
            return back();
        }
    }

    public function hapus($id)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageuser/destroy/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'Delete Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Delete Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        }catch (\Throwable $th) {
            $data['message']    =   'Delete Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }
}
