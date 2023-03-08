<?php

namespace App\Http\Controllers;

use App\project;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ProjectController extends Controller
{
    public $token_auth;
    public $data;
    public $tgl_mulai;
    public $tgl_selesai;
    public $is_allowed;
    public $is_favorit;

    public function index($slug)
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/project/'.$slug);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    if ($hasil->data->data->flag_mcs == 5) {
                        $this->data = $hasil->data->data;
                        $this->tgl_mulai = $hasil->data->tgl_mulai;
                        $this->tgl_selesai = $hasil->data->tgl_selesai;
                        $this->is_allowed = $hasil->data->is_allowed;
                        $this->is_favorit = $hasil->data->is_favorit;
                        $data = $this->data;
                        $tgl_mulai = $this->tgl_mulai;
                        $tgl_selesai = $this->tgl_selesai;
                        $is_allowed = $this->is_allowed;
                        $is_favorit = $this->is_favorit;

                        return view('project', compact(['data', 'tgl_mulai', 'tgl_selesai', 'is_allowed', 'is_favorit']));
                    }else{
                        session()->flash('error','Project Belum Terpublish');
                        return redirect()->back();
                    }
                }else{
                    session()->flash('error',$hasil->data->message);
                    return redirect()->back();
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

    public function search() {
        $search         =   request()->input('search')??'*';
        $impl           =   request()->input('impl')??'*';
        $nonpublic      =   request()->input('nonpublic')??'*';

        $token_auth = session()->get('token');

        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];

            $postData = [
                'searchTerm'    => $search,
                'impl'          => $impl,
                'nonpublic'     => $nonpublic,
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
            return response()->json([
                'status'    =>  1,
                'items'     =>  $hasil
            ]);
        }catch (\Throwable $th) {
            $data['message']    =   'Get Data Gagal, Mohon Reload Page';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }

        // TODO : search project using elastic search, if needed
        /*try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            $postData = [
                "search"     => $search,
            ];
            // return response()->json(['cek' => $postData]);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/fit");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // return response()->json($hasil);
            if ($hasil->status == 1) {
                $data = array();
                foreach ($hasil->data->data as $key) {
                    $data[]         = array("id"=>$key->_source->id, "text"=>$key->_source->nama);
                }

                return response()->json([
                    'status'    =>  1,
                    'items'     =>  $data
                ]);
            }else{
                return response()->json([
                    'status'    =>  0,
                    'items'     =>  '',
                    'cek'       => $hasil //cek jika ada error
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status'    =>  0,
                'items'     =>  ''
            ]);
        }*/
    }



    public function getProject($id) {
        $token      = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/projectbyid/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
//            dd($hasil);
            return response()->json([
                'data'      =>  $hasil->data,
            ],200);
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 3';
            return response()->json([
                'data'      =>  $data
            ],200);
        }
    }

    public function doc_project($kunci = "",$search="*",$sort = "desc"){
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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/document_proj/".$kunci."/".$search."/".$sort);
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

        $view = view('project.document',compact('data'))->render();
        $view_preview = view('project.preview',compact('data'))->render();
        return response()->json([
            'html'=>$view,
            'preview'=>$view_preview,
        ]);
    }

    public function archive(Request $request){
        if($request->has('data')) {
            try {
                $tampung = request()->data;
                $zipFileName = 'download.zip';
                $token      = session()->get('token');
                $ch         = curl_init();
                $headers    = [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "Authorization: Bearer $token",
                ];
                curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/documents");
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result     = curl_exec ($ch);
                $hasil      = json_decode($result);
                $path_zip = public_path('temp_download/'.session()->get('personal_number').'/ex');
                FacadesFile::deleteDirectory($path_zip);
                FacadesFile::makeDirectory($path_zip, 0777, true, true);
                chdir( sys_get_temp_dir() ); 
                $zip = new ZipArchive;
                $tmp_zipname = 'download_lampiran.zip';
                if ( true === $zip->open( $tmp_zipname, ZipArchive::CREATE ) ) {
                    foreach($hasil as $document){
                        if (in_array($document->url_file, $tampung)) {
                            $file = storage_path("app/public/".$document->url_file);
                            $relativename = $document->nama;
                            $zip->addFile($file, $relativename);
                        }

                    }
                    $zip->close();

                    // permission
                    chmod(sys_get_temp_dir(). '/' .$tmp_zipname, 0777);
                    chmod(public_path('temp_download/'.session()->get('personal_number').'/ex'), 0777);

                    // move to folder public
                    copy(
                        sys_get_temp_dir(). '/' .$tmp_zipname,
                        public_path('temp_download/'.session()->get('personal_number').'/ex/'.$zipFileName));

                    // tutup
                    chmod(public_path('temp_download/'.session()->get('personal_number').'/ex'), 0755);
                    unlink( sys_get_temp_dir(). '/' .$tmp_zipname );

                    $data   = config('app.url').'temp_download/'.session()->get('personal_number').'/ex'."/".$zipFileName;
                }else{
                    $data   = false;
                }

                return response()->json($data);
            } catch (\Throwable $th) {
                $data   = false;
                return response()->json($data);
            }
        }
    }

    public function archiveimp(Request $request){
        if($request->has('data')) {
            try {
                $tampung = request()->data;
                $zipFileName = 'download.zip';
                $token      = session()->get('token');
                $ch         = curl_init();
                $headers    = [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    "Authorization: Bearer $token",
                ];
                curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/imp");
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result     = curl_exec ($ch);
                $hasil      = json_decode($result);
                $path_zip = public_path('temp_download/'.session()->get('personal_number').'/ex');
                FacadesFile::deleteDirectory($path_zip);
                FacadesFile::makeDirectory($path_zip, 0777, true, true);
                chdir( sys_get_temp_dir() ); 
                $zip = new ZipArchive;
                $tmp_zipname = 'download_lampiran.zip';
                if ( true === $zip->open( $tmp_zipname, ZipArchive::CREATE ) ) {
                    foreach($hasil as $imp){
                        if (in_array($imp->url_file, $tampung)) {
                            $file = storage_path("app/public/".$imp->url_file);
                            $relativename = $imp->nama;
                            $zip->addFile($file, $relativename);
                        }

                    }
                    $zip->close();

                    // permission
                    chmod(sys_get_temp_dir(). '/' .$tmp_zipname, 0777);
                    chmod(public_path('temp_download/'.session()->get('personal_number').'/ex'), 0777);

                    // move to folder public
                    copy(
                        sys_get_temp_dir(). '/' .$tmp_zipname,
                        public_path('temp_download/'.session()->get('personal_number').'/ex/'.$zipFileName));

                    // tutup
                    chmod(public_path('temp_download/'.session()->get('personal_number').'/ex'), 0755);
                    unlink( sys_get_temp_dir(). '/' .$tmp_zipname );

                    $data   = config('app.url').'temp_download/'.session()->get('personal_number').'/ex'."/".$zipFileName;
                }else{
                    $data   = false;
                }

                return response()->json($data);
            } catch (\Throwable $th) {
                $data   = false;
                return response()->json($data);
            }
        }
    }
}
