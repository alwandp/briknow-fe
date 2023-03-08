<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function create(){
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
                'project_form'  => request()->project_form,
                'reply_form'    => request()->reply_form,
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/comment/create");
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

        $view = view('comment.item',compact('data'))->render();
        return response()->json([
            'status' => 1,
            'html'=>$view
        ]);
    }

    public function createforum(){
        $validator = Validator::make(request()->all(), [
            'komentar'      => "required",
            'parent_form'   => 'nullable|numeric',
            'forum_form'    => 'required|numeric',
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
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/commentforum/create");
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
        // return response()->json($data);
        $view = view('comment.itemforum',compact('data'))->render();
        return response()->json([
            'status' => 1,
            'html'=>$view
        ]);
    }
}
