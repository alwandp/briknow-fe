<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use stdClass;

class AllDataExport implements FromView
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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/allData');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $dataVisit = $hasil->data->dataVisit;
                    $dataVendor = $hasil->data->dataVendor;
                    $dataDiv = $hasil->data->dataDiv;
                    $dataYear = $hasil->data->dataYear;
                }else{
                    $dataVisit = [];
                    $dataVendor = [];
                    $dataDiv = [];
                    $dataYear = [];
                }
            }else{
                $dataVisit = [];
                $dataVendor = [];
                $dataDiv = [];
                $dataYear = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $dataVisit = [];
            $dataVendor = [];
            $dataDiv = [];
            $dataYear = [];
        }

        return view('export.alldataexport', compact(['dataVisit', 'dataVendor', 'dataDiv', 'dataYear']));
    }
}
