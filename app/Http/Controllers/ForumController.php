<?php

namespace App\Http\Controllers;

use Embed\Embed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use stdClass;

class ForumController extends Controller
{
    public $token_auth;

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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/forum');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);

            if (isset($hasil->status)) {
                // $data   = $hasil->data->data;
                $temp = $hasil->data->myData;
                $datas = [];
                foreach ($temp as $item) {
                    // try {
                    //     if($item->kategori == 1){
                    //         $embed = new Embed();
                    //         $info = $embed->get($item->content);
                    //         $previewlink = $info->image;
                    //     }else{
                    //         $previewlink = config('app.FE_url').'assets/img/default-forum-link.png';
                    //     }
                    // } catch (\Throwable $th) {
                    //     $previewlink = config('app.FE_url').'assets/img/default-forum-link.png';
                    // }

                    
                    if($item->kategori == 1){
                        $previewlink = config('app.FE_url').'/assets/img/default-forum-link.png';
                        $link        = $item->content;
                    }else{
                        $previewlink = "assets/img/default-forum.png";
                        $link        = "";
                    }
                    
                    $object = new stdClass;
                    $object->link       = $link;
                    $object->slug       = $item->slug;
                    $object->judul      = $item->judul;
                    $object->content    = $item->content;
                    $object->thumbnail  = $previewlink;
                    $object->kategori   = $item->kategori;
                    $object->id         = $item->id;
                    $object->updated_at = $item->updated_at;
                    $object->restriction= $item->restriction;
                    $datas[]            =   $object;
                }
                $myData = $datas;
                $draft  = $hasil->data->draft;
                return view('Forum.index', compact(['myData','draft']));
            }else{
                session()->flash('error','Get Data Failed');
                return redirect()->back();
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
            return redirect()->back();
        }
        return view('Forum.index');
    }

    public function create()
    {
        return view('Forum.create');
    }
    
    public function createproses()
    {
        // dd(request()->all());
        // VALIDASI
        request()->validate([
            'title'             => "required",
            'hakakses'          => "required",
            'tipe'              => "required",
            'status'            => "required|numeric",
        ]);

        if (request()->tipe == 'post') {
            request()->validate([
                'editorpost'        => "required",
            ]);
            $content = request()->editorpost;
        } elseif (request()->tipe == 'url') {
            request()->validate([
                'editorlink'        => "required|url",
            ]);
            $content = request()->editorlink;
        }

        if (request()->hakakses == 1) {
            request()->validate([
                'user'        => "required",
            ]);
            $listuser = request()->user;
        }else{
            $listuser = [];
        }

        //ketika post belum punya id berarti prosesnya create
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                // userid di be aja
                'judul'         => request()->title,
                'content'       => $content,
                'hakakses'      => request()->hakakses,
                'listuser'      => $listuser,
                'kategori'      => request()->tipe,
                'status'        => request()->status, //1 = PUBLISH || 0 = DRAFT
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/forum/create'); //CREATE
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
                    if (request()->status == 1) {
                        Session::flash('success','Berhasil membuat post');
                        return redirect('/forum');
                    } else {
                        Session::flash('success','Berhasil menyimpan draft');
                        return redirect('/forum');
                    }
                }else{
                    Session::flash('error',$hasil->data->message);
                    return redirect('/forum/create')->withInput();
                }
            }else{
                Session::flash('error','Something Problem');
                return redirect('/forum/create')->withInput();
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Please Try Again");
            return redirect('/forum/create')->withInput();
        }
    }

    public function draft($id)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/forum/draft/$id");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                    if ($data == null) {
                        session()->flash('error', 'Tidak ada draft tersimpan.');
                        return back();
                    }
                    return view('Forum.draft', compact(['data']));
                }else{
                    Session::flash('error',$hasil->data->message);
                    return back();
                }
            }else{
                session()->flash('error','Get Data Failed');
                return redirect()->back();
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
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/forum/draft/$id");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                    if ($data == null) {    
                        session()->flash('error', 'Tidak ada draft tersimpan.');
                        return back();
                    }
                    $mode = 'edit';
                    return view('Forum.draft', compact(['data','mode']));
                }else{
                    Session::flash('error',$hasil->data->message);
                    return back();
                }
            }else{
                session()->flash('error','Get Data Failed');
                return redirect()->back();
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
            return redirect()->back();
        }
    }

    public function update($id){
        // VALIDASI
        request()->validate([
            'title'             => "required",
            'hakakses'          => "required",
            'tipe'              => "required",
            'status'            => "required|numeric",
        ]);

        if (request()->tipe == 'post') {
            request()->validate([
                'editorpost'        => "required",
            ]);
            $content = request()->editorpost;
        } elseif (request()->tipe == 'url') {
            request()->validate([
                'editorlink'        => "required|url",
            ]);
            $content = request()->editorlink;
        }

        if (request()->hakakses == 1) {
            request()->validate([
                'user'        => "required",
            ]);
            $listuser = request()->user;
        }else{
            $listuser = [];
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
                'id'            => $id,
                'judul'         => request()->title,
                'content'       => $content,
                'listuser'      => $listuser,
                'hakakses'      => request()->hakakses,
                'kategori'      => request()->tipe,
                'status'        => request()->status, //1 = PUBLISH || 0 = DRAFT
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/forum/draft/save'); //UPDATE
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
                    if (request()->status == 1) {
                        Session::flash('success','Berhasil Memposting Forum');
                        return redirect('/forum');
                    } else {
                        Session::flash('success','Forum Berhasil Disimpan');
                        return redirect('/forum');
                    }
                }else{
                    Session::flash('error',$hasil->data->message);
                    // Session::flash('error',$hasil->data->message.$hasil->data->message->errornya->errorInfo[2]);
                    return redirect('/forum/create')->withInput();
                }
            }else{
                Session::flash('error','Something Problem');
                return redirect('/forum/create')->withInput();
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Please Try Again");
            return redirect('/forum/create')->withInput();
        }
    }

    public function detail($slug)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/forum/detail/'.$slug);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                $data = $hasil->data->data;
                $level = $hasil->data->level;
                if ($data == null) {
                    session()->flash('error', 'Tidak ada draft tersimpan.');
                    return back();
                }
                return view('Forum.detail', compact(['data','level']));
            }else{
                session()->flash('error','Get Data Failed');
                return redirect()->back();
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
            return redirect()->back();
        }
    }

    public function comment(){
        $validator = Validator::make(request()->all(), [
            'komentar'      => "required",
            'parent_form'   => 'nullable|numeric',
            'project_form'  => 'required|numeric',
            'reply_form'    => 'nullable|numeric',
        ]);

        // handle jika tidak terpenuhi
        if ($validator->fails()) {
            $data_error['message'] = $validator->errors();
            $data_error['error_code'] = 1; //error
            return response()->json([
                'status' => 0,
                'data'  => $data_error
            ], 200);            
        }

        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            $commentdata   = (string)request()->komentar; 
            $postData = [
                'komentar'      => $commentdata,
                'parent_form'   => request()->parent_form,
                'forum_form'  => request()->forum_form,
                'reply_form'    => request()->reply_form,
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/forum/comment/create");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));           
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if ($hasil->status == 1) {
                $data   = $hasil->data->data;
            }else{
                return response()->json([
                    'status'    => 0,
                    'data'      => 'Add Comment Failed'
                ], 200);  
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status'    => 0,
                'data'      => 'Add Comment Failed'
            ], 200);  
        }

        $view = view('Forum.Comment.item',compact('data'))->render();
        return response()->json([
            'status' => 1,
            'html'=>$view
        ]);
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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/forum/destroy/$id");
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

    public function getDataList($search)
    {
        $this->token_auth = session()->get('token');
        $page             = request()->page??1;
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/forum/$search?page=$page");
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
}
