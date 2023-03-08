<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use stdClass;

class AllComSupportExport implements FromView
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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be').'api/allComSupport');
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            // dd($hasil);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $dataInitiative = $hasil->data->dataInitiative;
                    $dataStrategic = $hasil->data->dataStrategic;
                    $dataImp = $hasil->data->dataImp;
                }else{
                    $dataInitiative = [];
                    $dataStrategic = [];
                    $dataImp = [];
                }
            }else{
                $dataInitiative = [];
                $dataStrategic = [];
                $dataImp = [];
            }
        }catch (\Throwable $th) {
            if(isset($hasil->message)){
                if ($hasil->message == "Unauthenticated.") {
                    session()->flush();
                    session()->flash('error','Session Time Out');
                    return redirect('/login');
                }
            }
            $dataInitiative = [];
            $dataStrategic = [];
            $dataImp = [];
        }

        return view('export.allcomsupportexport', compact(['dataInitiative', 'dataStrategic', 'dataImp']));
    }
}
