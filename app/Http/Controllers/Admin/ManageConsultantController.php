<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ManageConsultantController extends Controller
{
    public $token_auth;
    public $data;

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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageconsultant');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil->data->bahan);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $this->data = $hasil->data->bahan;
                }else{
                    $this->data = [];
                    session()->flash('error',$hasil->data->message);
                    // return back();
                }
            }else{
                $this->data = [];
                session()->flash('error',$hasil->data->message);
                // return back();
            }
            $token_auth = $this->token_auth;
            $data = $this->data;
            return view('admin.manageconsultant.manage_consultant', compact(['token_auth', 'data']));
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
            return redirect('/');
        }
    }

    public function create_proses()
    {   
        $validator = Validator::make(request()->all(), [
            'nama'         => "required",
            'bidang'       => "required",
            'website'      => "required",
            'telepon'      => "required|numeric|digits_between:10,15",
            'email'        => "required|email",
            'tentang'      => "required",
            'lokasi'       => "required",
        ]);

        
        // handle jika tidak terpenuhi
        if ($validator->fails()) {
            Session::flash('error', 'Mohon periksa kembali data Anda');
            return back()->withErrors($validator->errors())->withInput();
        }
        
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                'nama'         => request()->nama,
                'bidang'       => request()->bidang,
                'website'      => request()->website,
                'telepon'      => request()->telepon,
                'email'        => request()->email,
                'instagram'    => request()->instagram,
                'facebook'     => request()->facebook??"",
                'tentang'      => request()->tentang??"",
                'lokasi'       => request()->lokasi,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageconsultant/create');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                        Session::flash('success','Berhasil menambahkan Consultant');
                        return redirect('/manageconsultant');
                }else{
                    Session::flash('error','Gagal menambahkan Consultant');
                    Session::flash('error',$hasil->data->message); //biar tau errornya dari BE
                    return back()->withErrors($hasil->data->message)->withInput();
                }
            }else{
                Session::flash('error','Something Problem');
                return redirect('/manageconsultant')->withInput();
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Please Try Again");
            return redirect('/manageconsultant')->withInput();
        }
    }

    public function edit($id)
    {
        $validator = Validator::make(request()->all(), [
            'nama_edit'         => "required",
            'bidang_edit'       => "required",
            'website_edit'      => "required",
            'telepon_edit'      => "required|numeric|digits_between:10,15",
            'email_edit'        => "required|email",
            'tentang_edit'      => "required",
            'lokasi_edit'       => "required",
        ]);

        // handle jika tidak terpenuhi
        if ($validator->fails()) {
            Session::flash('error', 'Mohon periksa kembali data Anda');
            return back()->withErrors($validator->errors())->withInput();
        }

        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            
            $postData = [
                'nama_edit'         => request()->nama_edit,
                'bidang_edit'       => request()->bidang_edit,
                'website_edit'      => request()->website_edit,
                'telepon_edit'      => request()->telepon_edit,
                'email_edit'        => request()->email_edit,
                'instagram_edit'    => request()->instagram_edit,
                'facebook_edit'     => request()->facebook_edit??"",
                'tentang_edit'      => request()->tentang_edit??"",
                'lokasi_edit'       => request()->lokasi_edit,
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageconsultant/edit/'.$id);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)){
                if ($hasil->status == 1) {
                    Session::flash('success','Update Consultant berhasil');
                    return redirect('/manageconsultant');
                }else{
                    Session::flash('error',$hasil->data->message);
                    return back('/manageconsultant')->withInput();
                }
            }else{
                Session::flash('error','Something Problem');
                return redirect('/manageconsultant')->withInput();
            }
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            Session::flash('error','Gagal menyimpan, silakan coba lagi');
            return redirect('/manageconsultant')->withInput();
        }
    }

    public function index_content($sort="*", $sort2="*", $search="*")
    {
        $this->token_auth = session()->get('token');
        $page             = request()->page??1;
        $search           = str_replace(" ","_",urldecode($search));
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageconsultant/$sort/$sort2/$search?page=$page");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
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

    public function detail($id)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageconsultant/detail/'.$id);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                return response()->json([
                    "status"    => 1,
                    "data"      => $hasil->data,
                ],200);
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
    
    public function destroy($id)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageconsultant/delete/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
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
