<?php

namespace App\Http\Controllers\Admin;

use App\Exports\KeywordPopulerExport;
use App\Exports\KonsultantExport;
use App\Exports\PertahunExport;
use App\Exports\ProjectConsultantExport;
use App\Exports\ProjectDivisiExport;
use App\Exports\ProjectVisitorExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use stdClass;

class LaporanController extends Controller
{
    public function exxltagspopuler(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new KeywordPopulerExport(), 'Keyword_Populer_'.$date.'.xlsx');
    }

    public function expdftagspopuler(){
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
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }

        $dataEX =   [];
        foreach ($data->tags as $item) {
            $obj        =   new stdClass;
            $obj->nama  =   $item->nama;
            $obj->keyword_log_count  =   $item->keyword_log_count;
            $temp       =   "";
            foreach ($data->relateds as $related) {
                if ($related->nama == $item->nama){
                    if($temp == ""){
                        $temp = $related->nama_project;
                    }else{
                        $temp .= ", ".$related->nama_project;
                    }
                }
            }
            $obj->related   =  $temp;
            $dataEX[]       =  $obj;
        }
        
        // dd($dataEX);

        $pdf = PDF::loadview('export.keywordpopulerpdf', compact(['dataEX']))->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function exxlpertahun(){
        $date   =   Carbon::now()->format('Y');
        return Excel::download(new PertahunExport(), 'proyek_per_tahun_'.$date.'.xlsx');
    }

    public function expdfpertahun(){
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/dashboard/getprojectpertahun');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            //dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }
        
        // dd($dataEX);

        $pdf = PDF::loadview('export.projectpertahunpdf', compact(['data']))->setPaper('A4','landscape');
        return $pdf->stream();
    }

    public function getProjectVisitor(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new ProjectVisitorExport(), 'proyek_per_'.$date.'.xlsx');
    }

    public function getpdfProjectVisitor(){
        $token_auth = session()->get('token');
        $data = [];
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/getProjectVisitor');
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
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }
        
        $pdf = PDF::loadview('export.projectoverview', compact(['data']))->setPaper('A4','potrait');
        return $pdf->stream();
    }

    public function getProjectKonsultant(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new ProjectConsultantExport(), 'Project_Per_Consultant_per_'.$date.'.xlsx');
    }

    public function getpdfProjectKonsultant(){
        $token_auth = session()->get('token');
        $data = [];
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/getProjectConsultant');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            //dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data->data;
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }
        
        $pdf = PDF::loadview('export.projectconsultant', compact(['data']))->setPaper('A4','landscape');
        return $pdf->stream();
    }

    public function getProjectDivisi(){
        $date   =   Carbon::now()->format('d F Y');
        return Excel::download(new ProjectDivisiExport(), 'Project_Per_Divisi_per_'.$date.'.xlsx');
    }

    public function getpdfProjectDivisi(){
        $token_auth = session()->get('token');
        $data = [];
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/getprojectdivisi');
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
                }else{
                    $data = [];
                }
            }else{
                $data = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $data = [];
        }
        // dd($data);
        $pdf = PDF::loadview('export.projectdivisi', compact(['data']))->setPaper('A4','potrait');
        return $pdf->stream();
    }
}
