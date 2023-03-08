<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CommunicationController extends Controller
{
    public $dataInitiative;
    public $dataStrategic;
    public $dataImplementation;
    public $direktorat;
    public $divisi;

    public function index()
    {
        return redirect('mycomsupport/initiative');
    }

    public function communicationInitiativePublic()
    {
        return redirect('mycomsupport/initiative/article');
    }

    public function comInitTypePublic($type)
    {
        $type_list = (object)array(
            array("id" => "article", "name" => "Articles", "path" => "mycomsupport/initiative/article"),
            array("id" => "logo", "name" => "Icon, Logo, Maskot BRIVO", "path" => "mycomsupport/initiative/logo"),
            array("id" => "infographics", "name" => "Infographics", "path" => "mycomsupport/initiative/infographics"),
            array("id" => "transformation", "name" => "Transformation Journey", "path" => "mycomsupport/initiative/transformation"),
            array("id" => "podcast", "name" => "Podcast", "path" => "mycomsupport/initiative/podcast"),
            array("id" => "video", "name" => "Video Content", "path" => "mycomsupport/initiative/video"),
            array("id" => "instagram", "name" => "Instagram Content", "path" => "mycomsupport/initiative/instagram"),
        );
        $type_array = array("article", "logo", "infographics", "transformation", "podcast", "video", "instagram");
        if (!in_array($type, $type_array)) {
            session()->flash('error', 'Halaman tidak ditemukan');
            return back();
        }
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;
        try {
            $ch = curl_init();
            $chDiv = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . 'api/get/communicationinitiative/publish/' . $type);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);

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

            if ($hasil->status == 1) {
                $this->dataInitiative = $hasil->data->data;
                $data = $this->dataInitiative;
                return view('communication_initiative', compact(['type', 'type_list', 'sync_es', 'token_auth', 'data', 'direktorat', 'divisiRes']));
            } else {
                session()->flash('error', $hasil->data->message);
            }
        } catch (\Throwable $th) {
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

    public function getAllComInitPublish(Request $request, $type) {
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;

        $page = intval($request->get('page', 1));
        $query = "?limit=$page";
        if($request->get('sort')) {
            $query = $query."&sort=".$request->get('sort');
        }
        if($request->get('year')) {
            $query = $query."&year=".$request->get('year');
        }
        if($request->get('month')) {
            $query = $query."&month=".$request->get('month');
        }
        if($request->get('divisi')) {
            $query = $query."&divisi=".$request->get('divisi');
        }
        if($request->get('search')) {
            $query = $query."&search=".$request->get('search');
        }

        try {
            $ch = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . "api/get/communicationinitiative/publish/$type$query");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);

            if ($hasil->status == 1) {
                $this->dataInitiative = $hasil->data->data;
                $initiative = $this->dataInitiative;
                $data = $this->dataInitiative;
//                $prev = view('preview-initiative',compact('data'))->render();
//                dd($data);
//                return view('communication_initiative', compact(['type', 'type_list', 'sync_es', 'token_auth', 'data', 'direktorat', 'divisiRes']));
                return response()->json([
                    "status"    => 1,
                    "data"      => $initiative,
//                    "prev"      => $prev
                ],200);
            } else {
                session()->flash('error', $hasil->data->message);
            }
        } catch (\Throwable $th) {
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

    // page public strategic initiative
    public function strategicInit()
    {
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;
        try {
            $ch = curl_init();
            $chDiv = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . 'api/get/strategic/publish');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);

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

            if ($hasil->status == 1) {
                $this->dataStrategic = $hasil->data;
                $data = $this->dataStrategic;
                return view('strategic_initiative', compact(['sync_es', 'token_auth', 'data', 'direktorat', 'divisiRes']));
            } else {
                session()->flash('error', $hasil->data->message);
            }
        } catch (\Throwable $th) {
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

    public function strategicByProjectPublic($slug)
    {
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;
        try{
            $ch = curl_init();
            $chDiv = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . 'api/get/strategic/publish/'.$slug);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);

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

            if ($hasil->status == 1) {
                $content = $hasil->data->content;
                $piloting = $hasil->data->piloting;
                $rollOut = $hasil->data->roll_out;
                $sosialisasi = $hasil->data->sosialisasi;
                $data = $hasil->data->project;
//                dd($content);
                return view('strategic_by_project', compact(['sync_es', 'token_auth', 'slug', 'data', 'direktorat', 'content', 'divisiRes', 'piloting', 'rollOut', 'sosialisasi']));
            } else {
                session()->flash('error', $hasil->data->message);
            }
        }catch (\Throwable $throwable){
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

    public function strategicByProjectType($slug, $type)
    {
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;
        try{
            $ch = curl_init();
            $chDiv = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . 'api/get/strategic/publish/'.$slug.'/'.$type);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);

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

            if ($hasil->status == 1) {
                $data = $hasil->data;
                $project_nama = head($data)->project->nama;

                return view('strategic_by_content', compact(['sync_es', 'token_auth', 'slug', 'data', 'type', 'direktorat', 'divisiRes', 'project_nama']));
            } else {
                session()->flash('error', $hasil->data->message);
            }
        }catch (\Throwable $throwable){
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

    // page public implementation
    public function implementationInit()
    {
        return redirect('mycomsupport/implementation/piloting');
    }

    //set type implementation

    public function setTypeImplementationInit($type)
    {
        $type_list = (object)array(
            array("id" => "piloting", "name" => "Piloting", "path" => "mycomsupport/implementation/piloting"),
            array("id" => "roll-out", "name" => "Roll-Out", "path" => "mycomsupport/implementation/roll-out"),
            array("id" => "sosialisasi", "name" => "Sosialisasi", "path" => "mycomsupport/implementation/sosialisasi"),
        );
        $type_array = array("piloting", "roll-out", "sosialisasi");
        if (!in_array($type, $type_array)) {
            session()->flash('error', 'Halaman tidak ditemukan');
            return back();
        }
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;
        try {
            $ch = curl_init();
            $chDiv = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . 'api/get/implementation/all/publish/' . $type);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);

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

            if ($hasil->status == 1) {
                $this->dataInitiative = $hasil->data->data;
                $data = $this->dataInitiative;
                return view('implementation', compact(['type', 'type_list', 'sync_es', 'token_auth', 'data', 'direktorat', 'divisiRes']));
            } else {
                session()->flash('error', $hasil->data->message);
            }
        } catch (\Throwable $th) {
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

    public function getOneImplementation($slug)
    {
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;
        $ch = curl_init();
        $chDiv = curl_init();
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            "Authorization: Bearer $this->token_auth",
        ];
        curl_setopt($ch, CURLOPT_URL, config('app.url_be') . 'api/get/implementation/publish/' . $slug);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $hasil = json_decode($result);

        if ($hasil->status == 1) {
            $this->dataImplementation = $hasil->data;
            $data = $this->dataImplementation;
            $favorite = $data->favorite;
            
            return view('view_implementation', compact(['sync_es', 'token_auth', 'data', 'favorite']));
        } else {
            session()->flash('error', $hasil->data->message);
        }

    }

}
