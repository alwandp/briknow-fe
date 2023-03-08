<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use stdClass;

class AllPerformanceExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                        'Content-Type: application/json',
                        'Accept: application/json',
                        "Authorization: Bearer $token_auth",
                    ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/allPerformance');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $dataProject = $hasil->data->dataProject;
                    $dataVendor = $hasil->data->dataVendor;
                    $dataLesson = $hasil->data->dataLesson;
                    $dataCom = $hasil->data->dataCom;
                    $dataStr = $hasil->data->dataStr;
                    $dataImp = $hasil->data->dataImp;
//                    $dataTag = $hasil->data->dataTag;
                    $dataTag =   [];
                    foreach ($hasil->data->dataTag->tags as $item) {
                        $obj        =   new stdClass;
                        $obj->nama  =   $item->nama;
                        $obj->keyword_log_count  =   $item->keyword_log_count;
                        $temp       =   "";

                        foreach ($hasil->data->dataTag->relateds as $related) {
                            if ($related->nama == $item->nama){
                                if($temp == ""){
                                    $temp = $related->nama_project;
                                }else{
                                    $temp .= ", ".$related->nama_project;
                                }
                            }
                        }
                        $obj->related   =  $temp;
                        $dataTag[]       =  $obj;
                    }
                }else{
                    $dataProject = [];
                    $dataVendor = [];
                    $dataLesson = [];
                    $dataCom = [];
                    $dataStr = [];
                    $dataImp = [];
                    $dataTag = [];
                }
            }else{
                $dataProject = [];
                $dataVendor = [];
                $dataLesson = [];
                $dataCom = [];
                $dataStr = [];
                $dataImp = [];
                $dataTag = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $dataProject = [];
            $dataVendor = [];
            $dataLesson = [];
            $dataCom = [];
            $dataStr = [];
            $dataImp = [];
            $dataTag = [];
        }

        return view('export.allperformanceexport', compact(['dataProject', 'dataVendor', 'dataLesson', 'dataCom', 'dataStr', 'dataImp', 'dataTag']));
    }
}
