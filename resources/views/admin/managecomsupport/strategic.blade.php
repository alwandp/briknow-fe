@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/bootstrap-table.min.css') }}">
@endpush

@section('breadcumb', 'Admin')
@section('back', route('home'))

@section('content')
<div class="row">
    <div class="col-md-12" id="konten">
        <h3 class="pl-2 pt-5">Manage Communication Support</h3>

        <div class="my-4 d-flex align-content-between">
            <div class="d-flex mr-auto ml-2 flex-wrap">
                <a href="{{route('manage_com.com_init')}}" class="btn-com mt-2 mr-3" id="communication" role="button">Communication Initiative</a>
                <a class="btn-com mt-2 mr-3 active disabled" id="strategic" role="button">Strategic Initiative</a>
                <a href="{{route('manage_com.implementation')}}" class="btn-com mt-2 mr-3" id="implementation" role="button">Implementation</a>
            </div>
            <div class="mr-2" style="margin-top: auto">
                <a href="{{route('manage_com.upload_form', ['type'=>'content'])}}" type="button" style="border-radius: 12px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success"><i class="fa fa-plus mr-3"></i>Upload</a>
            </div>
        </div>

        <!-- NAVIGASI -->
        <div class="d-flex bd-highlight">
            <div class="mr-auto p-2 bd-highlight">
            </div>
        </div>
        <!-- NAVIGASI -->
        @include('layouts.alert')

        <div class="table-responsive" style="border-radius: 12px; background: white; padding-bottom: 3rem" id="review">
            <div class="p-3">
                <div class="col-auto" style="width: 35%">
                    <label class="sr-only" for="inlineFormInputGroup">Cari Project</label>
                    <div class="input-group mb-2">
                        <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control" id="inlineFormInputGroup" onchange="searchProject()" placeholder="Cari project">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background: #f0f0f0; border-radius: 0 8px 8px 0;"><i class="fa fa-search fa-sm" aria-hidden="true"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive" id="review">
                <table class="table" id="table-init">
                    <thead class="thead-light text-left justify-content-start align-content-start">
                        <tr>
                            <th class="text-center" id="th-line" width="20%">Judul</th>
                            <th class="text-center" id="th-line">Views</th>
                            <th class="text-center" id="th-line">Tanggal</th>
                            <th class="text-center" id="th-line">Status</th>
                            <th class="text-center" id="th-line">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-left justify-content-start align-content-start" id="content-table-body">
                    </tbody>
                </table>
                <div class="d-flex justify-content-sm-end content-pagination" id="pag">
                </div>
            </div>
            
            {{-- <table
                    id="table"
                    data-show-columns-toggle-all="true"
                    data-search="true"
                    data-search-selector="#inlineFormInputGroup"
                    data-click-to-select="true"
                    data-minimum-count-columns="2"
                    data-pagination="true"
                    data-id-field="id"
                    data-page-list="[10, 25, 50, 100, all]"
                    data-side-pagination="server"
                    data-ajax="ajaxRequest">
            </table> --}}
        </div>
    </div>
</div>
@endsection
@section('popup')
{{-- preview --}}
<div class="modal fade bd-example-modal-lg modal-preview" id="modalpreview" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
        <div class="modal-content content-preview bg-transparent">
            <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                <div class="bg-white bg-white w-100 content-preview">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('page-script')
<script>
    localStorage.clear();
</script>
<script src="{{ asset_app('assets/js/plugin/bootstrap-table.min.js') }}"></script>
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset_app('assets/js/page/strategic.js')}}"></script>

@endpush