<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class KeywordPopulerExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        try {
            $token_auth = session()->get('token');
            $data = [];
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
        return view('export.keywordpopuler', compact(['dataEX']));
    }
}
