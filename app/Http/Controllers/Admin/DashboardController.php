<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public $most;
    public $raw;
    public $dataProject;

    public function redirect() {
        return redirect('/dashboard/performance');
    }

    public function alldata(){
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/dashboard/visitor');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $raw = $hasil->data;
                    $most = $hasil->data->most;
                    $mostUk = $hasil->data->mostUK;

                    return view('dashboard_alldata', compact(['most', 'mostUk', 'raw']));
                }else{
                    session()->flash('error',$hasil->data->message);
                    return back();
                }
            }else{
                session()->flash('error','Get Data Failed');
                return back();
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error','Get Data Bermasalah , Silahkan Coba Lagi');
            return back();
        }
    }

    public function getproject()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/dashboard/project');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $this->dataProject = $hasil->data->data; //ngambil data variabel public buat di compact
            }else{
                session()->flash('error',$hasil->data->message);
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error','Get Data Bermasalah , Silahkan Coba Lagi');
        }
    }

    public function getalldata(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/dashboard/getalldatagrafik");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function getProjectVisitor(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/dashboard/getprojectvisitor");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function getProjectConsultant(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/dashboard/getprojectconsultant");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function getProjectDivisi(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/dashboard/getprojectdivisi");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function getProjectTahun(){
        try {
            $out = [];
            $token = session()->get('token');
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/dashboard/getprojecttahun");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $out=$hasil->data;
            }else{
                $out=[];
            }
        }catch (\Throwable $th) {
            $out=[];
        }

        if (request()->ajax()) {
            return compact('out');
        }
    }

    public function performance()
    {
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/dashboard/getprojecttags');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if ($hasil->status == 1) {
                $this->raw = $hasil->data;
                $this->getproject();
            }else{
                session()->flash('error',$hasil->data->message);
            }
        }catch (\Throwable $th) {

            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            session()->flash('error','Get Data Bermasalah , Silahkan Coba Lagi');
        }

        $raw = $this->raw;
        $data = $this->raw->data;
        $most = [];
        // dd($data);
        $dataProject = $this->dataProject;
        // dd($raw);
        // dd($raw->data->relateds[0]->project->keywords);
        return view('dashboard_performance', compact(['data', 'dataProject', 'most', 'raw']));
    }

    public function managegamification()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/managegamification');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                $data = $hasil->data->data;
                return view('managegamification.index', compact(['data']));
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

    public function managegamification_edit()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/managegamification');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                $data = $hasil->data->data;
                return view('managegamification.edit', compact(['data']));
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

    public function manageforum()
    {
        return redirect('/manageforum/all');
    }

    public function manageforum_all()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageforum/all');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                $data = $hasil->data->data;
                $token_auth = session()->get('token');
                return view('manageforum.manageforum_all', compact(['data', 'token_auth']));
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

    public function manageforum_removed()
    {
        $this->token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/manageforum/removed');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                $data = $hasil->data->data;
                $token_auth = session()->get('token');
                return view('manageforum.manageforum_removed', compact(['data', 'token_auth']));
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

    public function gamificationsave_level()
    {
        // dd(request()->all());
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                'id'                  => request()->level_id,
                'level_name'          => request()->level_name,
                'level_xp'            => request()->level_xp,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/managegamification/save/level');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            //dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    Session::flash('success','Berhasil menyimpan perubahan');
                    return redirect('/managegamification');
                }else{
                    Session::flash('error',$hasil->data->message);
                    return redirect('/managegamification')->withInput();
                }
            }else{
                Session::flash('error','Something Problem');
                return redirect('/managegamification')->withInput();
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Please Try Again");
            return redirect('/managegamification')->withInput();
        }
    }

    public function gamificationsave_activity()
    {
        // dd(request()->all());
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                'id'                  => request()->act_id,
                'activity_name'       => request()->activity,
                'activity_xp'         => request()->xp_earned,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/managegamification/save/activity');
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
                    Session::flash('success','Berhasil menyimpan perubahan');
                    return redirect('/managegamification#activity-config');
                }else{
                    Session::flash('error',$hasil->data->message);
                    return redirect('/managegamification#activity-config')->withInput();
                }
            }else{
                Session::flash('error','Something Problem');
                return redirect('/managegamification#activity-config')->withInput();
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Please Try Again");
            return redirect('/managegamification#activity-config')->withInput();
        }
    }

    public function gamificationsave_achievement()
    {
        // dd(request()->all());
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token",
                    ];
            $postData = [
                'id'                  => request()->ach_id,
                'name'                => request()->achievement,
                'value'               => request()->reward_value,
            ];
            // dd($postData);
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/managegamification/save/achievement');
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
                    Session::flash('success','Berhasil menyimpan perubahan');
                    return redirect('/managegamification#achievement-config');
                }else{
                    Session::flash('error',$hasil->data->message);
                    return redirect('/managegamification#achievement-config')->withInput();
                }
            }else{
                Session::flash('error','Something Problem');
                return redirect('/managegamification#achievement-config')->withInput();
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Please Try Again");
            return redirect('/managegamification#achievement-config')->withInput();
        }
    }

    public function listall($search = '*'){
        try {
            $this->token_auth = session()->get('token');
            $search           = str_replace(" ","_",urldecode($search));
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageforum/all/$search");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
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
                    ],400);
                }
            }else{
                $data['message']    =   'GET Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function listremoved($search = '*'){
        try {
            $this->token_auth = session()->get('token');
            $search           = str_replace(" ","_",urldecode($search));
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageforum/removed/$search");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "get");
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
                    ],400);
                }
            }else{
                $data['message']    =   'GET Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function remove($id){
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageforum/all/remove/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "post");
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

    public function sortPublic($search = '*'){
        try {
            $this->token_auth = session()->get('token');
            $search           = str_replace(" ","_",urldecode($search));
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageforum/all/sort/public/$search");
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
                    ],400);
                }
            }else{
                $data['message']    =   'GET Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function sortPrivate($search = '*'){
        try {
            $this->token_auth = session()->get('token');
            $search           = str_replace(" ","_",urldecode($search));
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageforum/all/sort/private/$search");
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
                    ],400);
                }
            }else{
                $data['message']    =   'GET Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function sortPublicRemoved($search = '*'){
        try {
            $this->token_auth = session()->get('token');
            $search           = str_replace(" ","_",urldecode($search));
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageforum/removed/sort/public/$search");
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
                    ],400);
                }
            }else{
                $data['message']    =   'GET Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function sortPrivateRemoved($search = '*'){
        try {
            $this->token_auth = session()->get('token');
            $search           = str_replace(" ","_",urldecode($search));
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageforum/removed/sort/private/$search");
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
                    ],400);
                }
            }else{
                $data['message']    =   'GET Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function restore($id){
        try {
            $this->token_auth = session()->get('token');
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $this->token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/manageforum/removed/restore/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "post");
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
                    $data['message']    =   'Restore Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   'Restore Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'Restore Gagal';
            return response()->json([
                'status'    =>  0,
                'data'      =>  $data
            ],400);
        }
    }

    public function dashboard_comsuport(){
        $token_auth = session()->get('token');
        return view('dashboard_comsuport', compact(['token_auth',]));
    }
}
