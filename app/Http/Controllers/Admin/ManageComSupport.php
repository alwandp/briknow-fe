<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ManageComSupport extends Controller
{
    public function index()
    {
        return redirect('managecommunication/communicationinitiative');
    }

    public function communicationInitiative()
    {
        return redirect('managecommunication/communicationinitiative/article');
    }

    public function implementation()
    {
        return redirect('managecommunication/implementation/piloting');
    }

    public function comInitType($type)
    {
        $type_list = (object) array(
            array("id" => "article", "name" => "Articles", "path" => "managecommunication/communicationinitiative/article"),
            array("id" => "logo", "name" => "Icon, Logo, Maskot BRIVO", "path" => "managecommunication/communicationinitiative/logo"),
            array("id" => "infographics", "name" => "Infographics", "path" => "managecommunication/communicationinitiative/infographics"),
            array("id" => "transformation", "name" => "Transformation Journey", "path" => "managecommunication/communicationinitiative/transformation"),
            array("id" => "podcast", "name" => "Podcast", "path" => "managecommunication/communicationinitiative/podcast"),
            array("id" => "video", "name" => "Video Content", "path" => "managecommunication/communicationinitiative/video"),
            array("id" => "instagram", "name" => "Instagram Content", "path" => "managecommunication/communicationinitiative/instagram"),
        );

        $type_array = array("article", "logo", "infographics", "transformation", "podcast", "video", "instagram");
        if (!in_array($type, $type_array)) {
            abort(404);
        }
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;

        return view('admin.managecomsupport.communication-initiative', compact(['type', 'type_list', 'sync_es', 'token_auth']));
    }

    public function strategic() {
        $this->token_auth = session()->get('token');
        $token_auth = $this->token_auth;

        return view('admin.managecomsupport.strategic', compact(['token_auth']));
    }

    public function strategicByType($slug, $type) {
        $this->token_auth = session()->get('token');
        $token_auth = $this->token_auth;

        $type_list = [
            ["id" => "article", "name" => "Articles"],
            ["id" => "logo", "name" => "Icon, Logo, Maskot BRIVO"],
            ["id" => "infographics", "name" => "Infographics"],
            ["id" => "transformation", "name" => "Transformation Journey"],
            ["id" => "podcast", "name" => "Podcast"],
            ["id" => "video", "name" => "Video Content"],
            ["id" => "instagram", "name" => "Instagram Content"],
        ];
        $key = array_search($type, array_column($type_list, 'id'));
        $tipe = $type_list[$key];

        return view('admin.managecomsupport.strategic-type', compact(['token_auth', 'slug', 'tipe']));
    }

    public function getAllComInitiative(Request $request, $type) {
        $this->token_auth = session()->get('token');
        try {
            $limit = intval($request->get('limit', 10));
            $offset = intval($request->get('offset', 0));
            $query = "?limit=$limit&offset=$offset";
            $order = 'asc';
            if($request->get('order')) {
                $query = $query."&order=".$request->get('order');
            }
            if($request->get('sort')) {
                $query = $query."&sort=".$request->get('sort');
            }

            if($request->get('search')) {
                $query = $query."&search=".$request->get('search');
            }

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/communicationinitiative/$type$query");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"            => 1,
                        'total'             =>  $hasil->total,
                        'totalNotFiltered'  => $hasil->totalData,
                        "rows"              => $hasil->data,
                        "totalRow"          => $hasil->totalRow
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'status'            =>  0,
                        'total'             =>  0,
                        'totalNotFiltered'  => $hasil,
                        'rows'              =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 2';
                return response()->json([
                    'status'            =>  0,
                    'total'             =>  0,
                    'totalNotFiltered'  => 0,
                    'rows'              =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 3';
            return response()->json([
                'total'             =>  0,
                'totalNotFiltered'  => 0,
                'rows'              =>  $data
            ],200);
        }
    }

    public function setStatusComInit($status, $id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/communicationinitiative/status/$status/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   $status.' Gagal';
                    $data['toast']      =   $status == 'Publish' ? 'Project gagal diterbitkan!' : $status.' Proyek Gagal.';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   $status.' Gagal';
                $data['toast']      =   $status == 'Publish' ? 'Project gagal diterbitkan!' : $status.' Proyek Gagal.';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            Session::flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function deleteComInit($id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/communicationinitiative/delete/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

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
            Session::flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function getAllStrategicInitiative(Request $request) {
        $this->token_auth = session()->get('token');
        try {
            $limit = intval($request->get('limit', 10));
            $offset = intval($request->get('offset', 0));
            $query = "?limit=$limit&offset=$offset";

            if($request->get('order')) {
                $query = $query."&order=".$request->get('order');
            }
            if($request->get('sort')) {
                $query = $query."&sort=".$request->get('sort');
            }

            if($request->get('search')) {
                $query = $query."&search=".$request->get('search');
            }

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/strategicinitiative$query");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"            => 1,
                        'total'             =>  $hasil->total,
                        'totalNotFiltered'  => $hasil->totalData,
                        "rows"              => $hasil->data,
                        "totalRow"          => $hasil->totalRow
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'status'            =>  0,
                        'total'             =>  0,
                        'totalNotFiltered'  => $hasil,
                        'rows'              =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 2';
                return response()->json([
                    'status'            =>  0,
                    'total'             =>  0,
                    'totalNotFiltered'  => 0,
                    'rows'              =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 3';
            return response()->json([
                'total'             =>  0,
                'totalNotFiltered'  => 0,
                'rows'              =>  $data
            ],200);
        }
    }

    public function strategicByProject(Request $request, $slug) {
        $this->token_auth = session()->get('token');
        try {

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/strategicinitiative/project/$slug");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data   = $hasil->data;
                }else{
                    $data   = [];
                }
            }else{
                $data   = [];
            }
        } catch (\Throwable $th) {
            $data   = [];
        }

        return view('admin.managecomsupport.strategic-byproject', compact(['data', 'slug']));
    }

    public function getAllStrategicByProject(Request $request, $slug) {
        $this->token_auth = session()->get('token');
        try {
            $sort = 'created_at';
            $order = 'desc';
            if($request->get('sort')) {
                $sort = $request->get('sort');
            }
            if($request->get('order')) {
                $order = $request->get('order');
            }

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/strategicinitiative/project/$slug?sort=$sort&order=$order");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"            => 1,
                        "data"              => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'status'            =>  0,
                        'data'              =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 1';
                return response()->json([
                    'status'            =>  0,
                    'data'              =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 1';
            return response()->json([
                'status'            =>  0,
                'data'              =>  $data
            ],200);
        }
    }

    public function getAllStrategicInitiativeByProjectAndType(Request $request, $slug, $type) {
        $this->token_auth = session()->get('token');
        try {
            $limit = intval($request->get('limit', 10));
            $offset = intval($request->get('offset', 0));
            $query = "?limit=$limit&offset=$offset";

            if($request->get('order')) {
                $query = $query."&order=".$request->get('order');
            }
            if($request->get('sort')) {
                $query = $query."&sort=".$request->get('sort');
            }

            if($request->get('search')) {
                $query = $query."&search=".$request->get('search');
            }

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/strategicinitiative/project/$slug/$type$query");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"            => 1,
                        'total'             =>  $hasil->total,
                        'totalNotFiltered'  => $hasil->totalData,
                        "rows"              => $hasil->data,
                        "totalRow"          => $hasil->totalRow,
                        "project"           => $hasil->project
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'status'            =>  0,
                        'total'             =>  0,
                        'totalNotFiltered'  => $hasil,
                        'rows'              =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 2';
                return response()->json([
                    'status'            =>  0,
                    'total'             =>  0,
                    'totalNotFiltered'  => 0,
                    'rows'              =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 3';
            return response()->json([
                'total'             =>  0,
                'totalNotFiltered'  => 0,
                'rows'              =>  $data
            ],200);
        }
    }

    public function implementationStepTus($step)
    {
        $step_list = (object) array(
            array("id" => "piloting", "name"    => "Piloting", "path" => "managecommunication/implementation/piloting"),
            array("id" => "roll-out", "name"    => "Roll-Out", "path" => "managecommunication/implementation/roll-out"),
            array("id" => "sosialisasi", "name" => "Sosialisasi", "path" => "managecommunication/implementation/sosialisasi")
        );
    
    
        $step_array = array("piloting", "roll-out", "sosialisasi");
        if (!in_array($step, $step_array)) {
            session()->flash('error', 'Halaman tidak ditemukan');
            return back();
        }
        $this->token_auth = session()->get('token');
        $sync_es = 0;
        $token_auth = $this->token_auth;

        return view('admin.managecomsupport.implementation', compact(['step', 'step_list', 'sync_es', 'token_auth']));
    }

    public function getAllImplementation(Request $request, $step) {
        $this->token_auth = session()->get('token');
        try {
            $limit = intval($request->get('limit', 10));
            $offset = intval($request->get('offset', 0));
            $query = "?limit=$limit&offset=$offset";
            $order = 'asc';
            if($request->get('order')) {
                $query = $query."&order=".$request->get('order');
            }
            if($request->get('sort')) {
                $query = $query."&sort=".$request->get('sort');
            }

            if($request->get('search')) {
                $query = $query."&search=".$request->get('search');
            }

            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $this->token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/implementation/$step$query");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"            => 1,
                        'total'             =>  $hasil->total,
                        'totalNotFiltered'  => $hasil->totalData,
                        "rows"              => $hasil->data,
                        "totalRow"          => $hasil->totalRow
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'status'            =>  0,
                        'total'             =>  0,
                        'totalNotFiltered'  => 0,
                        'rows'              =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 2';
                return response()->json([
                    'status'            =>  0,
                    'total'             =>  0,
                    'totalNotFiltered'  => 0,
                    'rows'              =>  $data
                ],200);
            }
        } catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 3';
            return response()->json([
                'total'             =>  0,
                'totalNotFiltered'  => 0,
                'rows'              =>  $data
            ],200);
        }
    }

    public $data;

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getMyImplementation() {
        $token_auth = session()->get('token');
        try {
            $ch = curl_init();
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token_auth",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/myimplementation");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $this->data = $hasil->data;
                    $data = $this->paginate($this->data);
                    $data->withPath('/myimplementation');

                    return view('myimplementation', compact(['data']));
                }else{
                    session()->flash('error',$hasil->data->message);
                    $data= [];

                    return view('myimplementation', compact(['data']));
                }
            }else{
                session()->flash('error', 'Get Data Bermasalah , Silahkan Coba Lagi');
                $data= [];
                return back();
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
            $data= [];

            return view('myimplementation', compact(['data']));
        }
    }

    function previewImplementation(Request $request, $id) {
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/myimplementation/preview/$id");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data;
                    $document = $data->attach_file;
                    if (session()->get('role') <> 3) {
                        $role = 0;
                        if ($data->user_maker == session()->get('personal_number') && ($data->status == 'draft')) {
                            $role = 0;
                        }elseif($data->user_checker == session()->get('personal_number') && ($data->status == 'review')){
                            $role = 1;
                        }elseif($data->user_signer == session()->get('personal_number') && ($data->status == 'checked')){
                            $role = 2;
                        }
                    }else{
                        $role = 3;
                    }
                    
                    $view = view('admin.managecomsupport.preview-myimplementation',compact(['data', 'role']))->render();
                    $col = null;
                    if ($data->piloting) {
                        $document = $data->piloting;
                        $step = 'piloting';
                        $col['piloting'] = view('doc.document-imp',compact('document', 'step'))->render();
                    }
                    if ($data->rollout) {
                        $document = $data->rollout;
                        $step = 'rollout';
                        $col['rollout'] = view('doc.document-imp',compact('document', 'step'))->render();
                    }
                    if ($data->sosialisasi) {
                        $document = $data->sosialisasi;
                        $step = 'sosialisasi';
                        $col['sosialisasi'] = view('doc.document-imp',compact('document', 'step'))->render();
                    }
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                        "html"      => $view,
                        'col'       => $col,
                    ],200);
                }else{
                    $data['message']    =   'Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $hasil,
                        'error'     => $data
                    ],400);
                }
            }else{
                $data['message']    =   'Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $hasil,
                    'error'     => $data
                ],400);
            }
        } catch (\Throwable $th) {
            session()->flash('error',"Something Error, Try Again Please");
            return back()->withInput();
        }
    }

    public function setStatusImplementation($status, $id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/implementation/status/$status/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "status"    => 1,
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   $status.' Gagal';
                    $data['toast']    =   $status == 'Publish' ? 'Project gagal diterbitkan!' : $status.' Proyek Gagal.';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $data
                    ],400);
                }
            }else{
                $data['message']    =   $status.' Gagal';
                $data['toast']      =   $status == 'Publish' ? 'Project gagal diterbitkan!' : $status.' Proyek Gagal.';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $data
                ],400);
            }
        } catch (\Throwable $th) {
            Session::flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function deleteImplementation($id) {
        try {

            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/implementation/delete/$id");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);

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
            Session::flash('error',"Something Error, Try Again Please");
            return back();
        }
    }

    public function uploadForm($type, $slug="*") {

        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/form_upload/$type/$slug");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            $tgl_mulai = Carbon::now();
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data   = $hasil->data;
                }else{
                    $data   = [];
                }
            }else{
                $data  =  [];
            }
        }catch (\Throwable $th) {
            $data   = [];
        }

        if ($type == 'content') {
            return view('admin.managecomsupport.content-upload',compact(['data']));
        } else if($type == 'implementation') {
            return view('admin.managecomsupport.implementation-upload',compact(['data']));
        }  else {
            abort(404);
            return null;
        }
    }

    public function getDataUpdateImplementation($slug) {

        try {
            $data        = [];
            $token      = session()->get('token');
            $ch         = curl_init();
            $headers    = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/form_upload/implementation/$slug");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil      = json_decode($result);
            $tgl_mulai = Carbon::now();
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    return response()->json([
                        "data"      => $hasil->data,
                    ],200);
                }else{
                    $data['message']    =   'GET Gagal 1';
                    return response()->json([
                        'data'      =>  $data
                    ],200);
                }
            }else{
                $data['message']    =   'GET Gagal 2';
                return response()->json([
                    'data'      =>  $data
                ],200);
            }
        }catch (\Throwable $th) {
            $data['message']    =   'GET Gagal 1';
            return response()->json([
                'data'      =>  $data
            ],200);
        }
    }

    public function createImplementation() {
        request()->validate([
            'thumbnail'     => "required",
            'direktorat'    => "required",
            'divisi'        => 'required',
            'project'       => 'required',
            'title'         => 'required',
            'tgl_mulai'     => 'required',
            'pm'            => 'required',
            'emailpm'       => 'required',
            'restricted'    => 'required',
            'piloting'      => 'required',
            'rollout'       => 'required',
            'sosialisasi'   => 'required',
            'checker'       => 'required',
            'signer'        => 'required',
        ]);
        if (isset(request()->id)) {
            $id = request()->id;
        } else {
            $id = "*";
        }
        if (request()->piloting == 1) {
            request()->validate([
                'deskripsi_piloting'    => 'required',
                'attach_piloting'       => 'required',
            ]);
            $desc_pilot     = request()->deskripsi_piloting;
            $attach_pilot   = request()->attach_piloting;
            $piloting       = 1;
        }else{
            $desc_pilot     = null;
            $attach_pilot   = null;
            $piloting       = 0;
        }

        if (request()->rollout == 1) {
            request()->validate([
                'deskripsi_rollout'     => 'required',
                'attach_rollout'        => 'required',
            ]);
            $desc_rollout       = request()->deskripsi_rollout;
            $attach_rollout     = request()->attach_rollout;
            $rollout            = 1;
        }else{
            $desc_rollout       = null;
            $attach_rollout     = null;
            $rollout            = 0;
        }

        if (request()->sosialisasi == 1) {
            request()->validate([
                'deskripsi_sosialisasi'     => 'required',
                'attach_sosialisasi'        => 'required',
            ]);
            $desc_sosialisasi       = request()->deskripsi_sosialisasi;
            $attach_sosialisasi     = request()->attach_sosialisasi;
            $sosialisasi            = 1;
        }else{
            $desc_sosialisasi       = null;
            $attach_sosialisasi     = null;
            $sosialisasi            = 0;
        }

        if (isset(request()->status)) {
            request()->validate([
                'tgl_selesai'    => 'required',
            ]);
            $tgl_selesai    = request()->tgl_selesai;
            $status         = 1;
        }else{
            $tgl_selesai    = null;
            $status         = 0;
        }

        if (request()->restricted == 1) {
            request()->validate([
                'user'          => 'required',
            ]);
            $user           = request()->user;
        }else{
            $user           = '-';
        }

        $temp_delete = null;
        if (isset(request()->temp_delete)) {
            foreach (request()->temp_delete as $path) {
                if(File::exists(public_path("storage/".$path))){
                    File::delete(public_path("storage/".$path));
                    File::deleteDirectory(dirname(public_path("storage/".$path)));
                }
            }
            $temp_delete = request()->temp_delete;
        }

        try {
            $ch = curl_init();
            $token    = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            $postData = [
                'thumbnail'                 => request()->thumbnail,
                'direktorat'                => request()->direktorat,
                'divisi'                    => request()->divisi,
                'project'                   => request()->project,
                'title'                     => request()->title,
                'status'                    => $status,
                'tgl_mulai'                 => request()->tgl_mulai,
                'tgl_selesai'               => $tgl_selesai,
                'pm'                        => request()->pm,
                'emailpm'                   => request()->emailpm,
                'restricted'                => request()->restricted,
                'piloting'                  => $piloting,
                'rollout'                   => $rollout,
                'sosialisasi'               => $sosialisasi,
                'deskripsi_pilot'           => $desc_pilot,
                'attach_pilot'              => $attach_pilot,
                'deskripsi_rollout'         => $desc_rollout,
                'attach_rollout'            => $attach_rollout,
                'deskripsi_sosialisasi'     => $desc_sosialisasi,
                'attach_sosialisasi'        => $attach_sosialisasi,
                'is_new_project'            => request()->is_new,
                'temp_delete'               => $temp_delete,
                'user'                      => $user,
                'checker'                   => request()->checker,
                'signer'                    => request()->signer,
                'token_bri'                 => session()->get('token_bri'),
            ];
            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/managecommunication/implementation/upload/$id");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    Session::flash('success','Implementasi Berhasil di Simpan');
                    return redirect('/managecommunication/implementation');
                }else{
                    if (isset($hasil->data->error_code)) {
                        if ($hasil->data->error_code == 0) {
                            Session::flash('error',$hasil->data->message);
                            return back()->withInput();
                        }else{
                            return back()->withErrors($hasil->data->message)->withInput();
                        }
                    }else{
                        Session::flash('error',$hasil->data->message);
                        return back()->withInput();
                    }
                }
            }else{
                Session::flash('error','Something Problem');
                return back()->withInput();
            }
        }catch (\Throwable $th) {
            Session::flash('error',"Something Error, Try Again Please");
            return back()->withInput();
        }
    }

    public function createComInit(){
        // VALIDASI
        request()->validate([
            'thumbnail'         => "required",
            'title'             => "required",
            'file_type'         => 'required',
            'deskripsi'         => 'required',
            'attach'            => 'required',
            'tgl_upload'         => 'required',
        ]);

        if (isset(request()->id)) {
            $id = request()->id;
        } else {
            $id = "*";
        }
        if (request()->parent == 1) {
            request()->validate([
                'project_nama'  => 'required',
                'project'       => 'required',
                'divisi'        => 'required',
            ]);
            $divisi         = request()->divisi;
            $project        = request()->project;
            $project_nama   = request()->project_nama;
            $is_new         = request()->is_new;
        }else{
            $divisi         = null;
            $project        = null;
            $project_nama   = null;
            $is_new         = 0;
        }

        $temp_delete = null;
        if (isset(request()->temp_delete)) {
            foreach (request()->temp_delete as $path) {
                if(File::exists(public_path("storage/".$path))){
                    File::delete(public_path("storage/".$path));
                    File::deleteDirectory(dirname(public_path("storage/".$path)));
                }
            }
            $temp_delete = request()->temp_delete;
        }

        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            $postData = [
                'thumbnail'         => request()->thumbnail,
                'title'             => request()->title,
                'file_type'         => request()->file_type,
                'deskripsi'         => request()->deskripsi,
                'is_new_project'    => $is_new,
                'project'           => $project,
                'project_nama'      => $project_nama,
                'divisi'            => $divisi,
                'tgl_upload'        => request()->tgl_upload,
                'attach'            => request()->attach,
                'temp_delete'       => $temp_delete,
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/managecommunication/content/upload/$id");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);
            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    Session::flash('success','Content Berhasil di Simpan');
                    return redirect('/managecommunication');
                }else{
                    if (isset($hasil->data->error_code)) {
                        if ($hasil->data->error_code == 0) {
                            session()->flash('error',$hasil->data->message);
                            return back()->withInput();
                        }else{
                            return back()->withErrors($hasil->data->message)->withInput();
                        }
                    }else{
                        session()->flash('error',$hasil->data->message);
                        return back()->withInput();
                    }
                }
            }else{
                session()->flash('error','Something Problem');
                return back()->withInput();
            }
        }catch (\Throwable $th) {
            session()->flash('error',"Something Error, Try Again Please");
            return back()->withInput();
        }
    }

    function viewsContent(Request $request, $table, $id) {
        try {
            $ch = curl_init();
            $token      = session()->get('token');
            $headers  = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];

            curl_setopt($ch, CURLOPT_URL,config('app.url_be')."api/communication/views/$table/$id");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result     = curl_exec ($ch);
            $hasil = json_decode($result);

            if (isset($hasil->status)) {
                if ($hasil->status == 1) {
                    $data = $hasil->data;
                    $document = $data->attach_file;
                    if ($table == 'content') {
                        if($request->get('public')) {
                            $prev = view('preview-initiative',compact('data'))->render();
                            return response()->json([
                                "status"    => 1,
                                "data"      => $hasil->data,
                                "prev"      => $prev,
                            ],200);
                        }
                        $view = view('admin.managecomsupport.preview-content',compact(['data']))->render();
                        $col = view('doc.document',compact('document'))->render();
                        return response()->json([
                            "status"    => 1,
                            "data"      => $hasil->data,
                            "html"      => $view,
                            'col'       => $col,
                        ],200);
                    } else {
                        $view = view('admin.managecomsupport.preview-implementation',compact(['data']))->render();
                        $col = null;
                        if ($data->piloting) {
                            $document = $data->piloting;
                            $step = 'piloting';
                            $col['piloting'] = view('doc.document-imp',compact('document', 'step'))->render();
                        }
                        if ($data->rollout) {
                            $document = $data->rollout;
                            $step = 'rollout';
                            $col['rollout'] = view('doc.document-imp',compact('document', 'step'))->render();
                        }
                        if ($data->sosialisasi) {
                            $document = $data->sosialisasi;
                            $step = 'sosialisasi';
                            $col['sosialisasi'] = view('doc.document-imp',compact('document', 'step'))->render();
                        }
                        return response()->json([
                            "status"    => 1,
                            "data"      => $hasil->data,
                            "html"      => $view,
                            'col'       => $col,
                        ],200);
                    }
                }else{
                    $data['message']    =   'Gagal';
                    return response()->json([
                        'status'    =>  0,
                        'data'      =>  $hasil,
                        'error'     => $data
                    ],400);
                }
            }else{
                $data['message']    =   'Gagal';
                return response()->json([
                    'status'    =>  0,
                    'data'      =>  $hasil,
                    'error'     => $data
                ],400);
            }
        } catch (\Throwable $th) {
            session()->flash('error',"Something Error, Try Again Please");
            return back()->withInput();
        }
    }

    function downloadFile($table, $id) {
        try {
            $token = session()->get('token');
            $ch = curl_init();
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
                "Authorization: Bearer $token",
            ];
            curl_setopt($ch, CURLOPT_URL, config('app.url_be') . "api/download/attach/$table/$id");
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            $hasil = json_decode($result);

            return response()->json([
                "status"    => 1,
                "data"      => $hasil->data,
            ],200);
        } catch (\Throwable $th) {
            session()->flash('error', "Something Error, Try Again Please");
            return back();
        }
    }
}
