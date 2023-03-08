<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ManageLessonLearned extends Controller
{
    public function index()
    {
        return redirect('managelesson/review');
    }

    public function review()
    {
        $this->token_auth = session()->get('token');
        $ch = curl_init();
        $chDiv = curl_init();

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            "Authorization: Bearer $this->token_auth",
        ];
        curl_setopt($ch, CURLOPT_URL, config('app.url_be') . 'api/managelessonlearned');
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $hasil = json_decode($result);
        $dataLesson = [];

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

        if (isset($hasil->status)) {
            if ($hasil->status == 1) {
                $sync_es = 0;
                $dataLesson = $hasil->data;

            } else {
                $sync_es = 0;
                $this->data = [];
                session()->flash('error', $hasil->data->message);
                return back();
            }
        } else {
            $sync_es = 0;
            $this->data = [];
            session()->flash('error', $hasil->data->message);
            return back();
        }
        $token_auth = $this->token_auth;
        $data = $dataLesson;
        return view('admin.managelessonlearned.review-lesson', compact(['token_auth', 'data', 'sync_es', 'direktorat', 'divisiRes']));
    }
}
