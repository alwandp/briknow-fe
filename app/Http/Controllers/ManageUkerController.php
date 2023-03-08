<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManageUkerController extends Controller
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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageuker');
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
            // $data = $this->paginate($data);
            // $data->withPath('/manageproject/review');
            // dd($nama_unik);
            // dd($data);

            // return view('admin.manageproject.review', compact(['data', 'token_auth', 'divisi_unik', 'nama_unik']));
            return view('admin.manageuker.manage_uker', compact(['token_auth', 'data']));
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

    public function create()
    {
        return view('admin.manageuker.create');
    }

    public function create_proses()
    {
        // dd(request()->all());
        // VALIDASI
        request()->validate([
            'cost_center'         => "required|max:7",
            'divisi'              => "required",
            'shortname'           => "required|max:4",
        ]);

        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                'cost_center' => request()->cost_center,
                'direktorat'  => request()->direktorat??NULL,
                'divisi'      => request()->divisi,
                'shortname'   => request()->shortname,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageuker/create');
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
                        Session::flash('success','Berhasil menambahkan Divisi');
                        return redirect('/manageuker');
                }else{
                    Session::flash('error','Gagal menambahkan Divisi');
                    // Session::flash('error',$hasil->data->message); //biar tau errornya dari BE
                    return redirect('/manageuker')->withInput()->withErrors($hasil->data->message);
                }
            }else{
                Session::flash('error','Something Problem');
                return redirect('/manageuker');
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Please Try Again");
            return redirect('/manageuker');
        }
    }

    public function edit($id)
    {
        // dd(request()->all());
        request()->validate([
            'cost_center_edit'         => "required|max:7",
            // 'direktorat'          => "required", engga perlu takut ada case direktorat nya masuk ke kategori "lainnya"
            'divisi_edit'              => "required",
            'shortname_edit'           => "required|max:4",
        ]);
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];

            $postData = [
                'cost_center_edit'   => request()->cost_center_edit,
                'direktorat_edit'    => request()->direktorat_edit??NULL,
                'divisi_edit'        => request()->divisi_edit,
                'shortname_edit'     => request()->shortname_edit
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageuker/edit/'.$id);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                Session::flash('success','Update Divisi berhasil');
                return redirect('/manageuker');
            }else{
                Session::flash('error','Update Divisi Gagal');
                return redirect('/manageuker')->withInput()->withErrors($hasil->data->message);
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
            return redirect('/manageuker');
        }
    }

    public function index_content($sort="*", $sort2="*", $search="*")
    {
        try {
            $this->token_auth = session()->get('token');
            $page             = request()->page??1;
            $search           = str_replace(" ","_",urldecode($search));
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageuker/$sort/$sort2/$search?page=$page");
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
                    $data['message'] = 'GET Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],200);
                }
            }else{
                $data['message'] = 'GET Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message'] = 'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],200);
        }
    }

    public function detail($id)
    {
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageuker/detail/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
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
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],200);
        }
    }

    public function hapus($id)
    {
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageuker/delete/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            // return response()->json([
            //     "status"    => 1,
            //     "data"      => $hasil,
            // ],200);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    if ($hasil->is_changed == 1) {
                        session::forget('divisi');
                        session::forget('direktorat');
                        session::put('divisi', 11111111);
                        session::put('direktorat', 11111111);
                    }
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else if($hasil->status == -1){
                    $data['message'] = 'Gagal menghapus, divisi terhubung dengan proyek';
                    return response()->json([
                        'status'    =>  -1,
                        'data'      =>  $data
                    ],200);
                }else if($hasil->status == -2){
                    $data['message'] = 'Tidak dapat dihapus';
                    return response()->json([
                        'status'    =>  -2,
                        'data'      =>  $data
                    ],200);
                }else{
                    $data['message'] = 'Delete Divisi Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],200);
                }
            }else{
                $data['message'] = 'Delete Divisi Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message'] = 'Delete Divisi Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],200);
        }
    }
}
