<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ManageProjectController extends Controller
{
    public $data_rekomendasi = array();
    public $data_review = array();
    public $data;
    public $data_;
    public $token_auth;
    public $checks;

    public function index()
    {
        return redirect('manageproject/review');
    }

    public function review()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageproject/review');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            Log::info("INPOH PROJECT ", [$hasil]);
            // dd($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $this->data = $hasil->data->bahan;
                    $sync_es = $hasil->data->sync_es;
                    $projects= [];
                    $projeks = [];

                    // divisi
                    foreach ($this->data as $proj) {
                        $projects[$proj->divisi->id] = $proj->divisi->divisi;
                        foreach ($proj->consultant as $cons) {
                            $projeks[$cons->id] = $cons->nama;
                        }
                    }
                    $divisi_unik = array_unique($projects);
                    // nama project
                    $nama_unik = array_unique($projeks);
                }else{
                    $sync_es = 0;
                    $this->data = [];
                    session()->flash('error',$hasil->data->message);
                    return back();
                }
            }else{
                $sync_es = 0;
                $this->data = [];
                session()->flash('error',$hasil->data->message);
                return back();
            }
            $token_auth = $this->token_auth;
            // $data = $this->data;
            // $data = $this->paginate($data);
            // $data->withPath('/manageproject/review');
            // dd($nama_unik);
            // dd($data);

            // return view('admin.manageproject.review', compact(['data', 'token_auth', 'divisi_unik', 'nama_unik']));
            return view('admin.manageproject.review', compact(['token_auth', 'divisi_unik', 'nama_unik']));
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

    public function rekomendasi()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageproject/rekomendasi');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $this->data = $hasil->data->data;
                $this->data_ = $hasil->data->data_not_recomended;
            }else{
                $this->data = [];
                $this->data_ = [];
                session()->flash('error',$hasil->data->message);
            }
            $token_auth = $this->token_auth;
            $data = $this->data;
            $data_ = $this->data_;
            $data = $this->paginate($data);
            $data->withPath('/manageproject/rekomendasi');
            // dd($data);

            return view('admin.manageproject.rekomendasi', compact(['data', 'data_', 'token_auth']));
        }catch (\Throwable $th) {
            if (isset($hasil->message)) {
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error', 'Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
        }
    }

    public function sort($by)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageproject/sort/'.$by);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $this->data = $hasil->data->data;
                $token_auth = $this->token_auth;
                $data = $this->data;
                $data = $this->paginate($data);
                $data->withPath('/manageproject/review/sort/'.$by);
            }else{
                $this->data = [];
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
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
        }

        if (request()->ajax()) {
            $data    = $this->data;
            $data = $this->paginate($data);
            $data->withPath('/manageproject/review/sort/'.$by);
            $view = view('admin.manageproject.review-data',compact('data'))->render();
            $paginator = view('admin.manageproject.review-paginator',compact('data'))->render();
            return response()->json([
                'html'=>$view,
                'paginator'=>$paginator,
            ]);
        }

        return view('admin.manageproject.review', compact(['data', 'token_auth']));
    }

    public function sortpass($by) //experiment (untested)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageproject/sortpass/'.$by);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $this->data = $hasil->data->data;
                $token_auth = $this->token_auth;
                $data = $this->data;
                $data = $this->paginate($data);
                $data->withPath('/manageproject/review/p/sort'.$by);
            }else{
                $this->data = [];
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
            session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
        }

        if (request()->ajax()) {
            $data    = $this->data;
            $data = $this->paginate($data);
            $data->withPath('/manageproject/review/p/sort'.$by);
            $view = view('admin.manageproject.review-data',compact('data'))->render();
            $paginator = view('admin.manageproject.review-paginator',compact('data'))->render();
            return response()->json([
                'html'=>$view,
                'paginator'=>$paginator,
            ]);
        }

        return view('admin.manageproject.review', compact(['data', 'token_auth']));
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function review_content($fil_div="*",$fil_kon="*",$search="*")
    {
        $this->token_auth = session()->get('token');
        $page             = request()->page??1;
        $search           = str_replace(" ","_",urldecode($search));

        try {
            $fil_div    =   urldecode($fil_div);
            $fil_kon    =   urldecode($fil_kon);
            $search     =   urldecode($search);

            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageproject/review/$fil_div/$fil_kon/$search?page=$page");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
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

    public function unpublish($id){
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageproject/review/unpublish/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'Unpublish Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Unpublish Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'Unpublish Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function publish($id){
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageproject/review/publish/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'Unpublish Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Unpublish Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'Unpublish Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function hapus($id){
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageproject/review/destroy/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
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
        } catch (\Throwable $th) {
            $data['message']    =   'Delete Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function hapusContentByProject($id){
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageproject/strategic/destroy/$id");
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
                    $data['message']    =   'Delete Konten Project Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Delete Konten Project Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'Delete Konten Project Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function add($id){
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageproject/rekomendasi/add/$id");
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "post");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'Merekomendasikan Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Merekomendasikan Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'Merekomendasikan Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function hapus_rekomendasi($id){
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageproject/rekomendasi/remove/$id");
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "post");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'Delete Rekomendasi Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Delete Rekomendasi Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'Delete Rekomendasi Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }
}
