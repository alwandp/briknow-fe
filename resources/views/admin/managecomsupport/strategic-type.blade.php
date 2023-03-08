@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
<!--<link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">-->
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
<!--<link rel="stylesheet" href="{{ asset_app('assets/css/fa-proj.css') }}">-->
<link rel="stylesheet" href="{{ asset_app('assets/css/comsupport.css') }}">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.css">
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
            </div>
        </div>

        <div class="mb-2 mt-4 d-flex align-content-between">
            <div class="d-flex mr-auto ml-2 flex-wrap" style="font-size: 18px">
                <a href="{{route('manage_com.strategic')}}" class="badge-str mt-2 mr-3" id="strategic_text">Strategic Initiative</a>
                <a class="badge-str mt-2 mr-3 disabled">/</a>
                <a href="{{route('manage_com.strategicbyproject', ['slug'=>$slug])}}" class="badge-str mt-2 mr-3">Project</a>
                <a class="badge-str mt-2 mr-3 disabled">/</a>
                <a class="badge-str mt-2 mr-3 disabled">{{$tipe['name']}}</a>
            </div>
            <div class="mr-4 d-flex align-items-center" style="margin-top: auto">
                <div>
                    <a href="{{route('manage_com.upload_form', ['type'=>'content'])}}" type="button" style="border-radius: 12px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success d-flex align-items-center"><i class="fa fa-plus mr-3"></i>Upload</a>
                </div>
            </div>
        </div>

        @php ($type_name = $tipe['id'])
        @include('layouts.alert')

        <div id="project"></div>
        <input type="hidden" value="{{ $slug }}" id="projectSlug">
        <div class="table-responsive" style="border-radius: 12px; background: white; padding-bottom: 3rem" id="review">
            <div class="p-3">
                <div class="col-auto" style="width: 35%">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <div class="input-group mb-2">
                        <input type="text" style="border-radius: 8px 0 0 8px;" class="form-control" id="inlineFormInputGroup" onchange="searchContent()" placeholder="Cari {{$tipe['name']}}">
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
                    data-ajax="ajaxRequest"
                    data-response-handler="responseHandler">
            </table> --}}
        </div>
    </div>
</div>
@endsection
@section('popup')
<div class="modal fade bd-example-modal-lg modal-preview" id="modal-preview-1" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
        <div class="modal-content content-preview bg-transparent">
            <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                <div class="bg-white bg-white w-100" id="content-preview-desc">
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
<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/bootstrap-table.min.js"></script>
<script src="{{asset_app('assets/js/plugin/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{asset_app('assets/js/page/strategic-type.js')}}"></script>

<script>
    function ajaxRequest(params) {
        const type = "{{$type_name}}"
        const slug = "{{$slug}}";
        const url = `${uri}/get/strategicinitiative/project/${slug}/${type}`

        $.ajax({
            url: url + '?' + $.param(params.data),
            type: "get",
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                $('.senddataloader').show();
            },
            success: function(data){
                let $project = $('#project')
                $project.empty()
                $project.removeClass('mb-3')
                let href = `${uri}/project/${data.project.slug}`
                let html = `<a href="${href}" class="badge-str mt-2 ml-2"
                    style="font-size: 22px; font-weight: 600; text-decoration: underline from-font">${data.project.nama}</a>`
                $project.append(html)
                $project.addClass('mb-3')
                let pagination_height = data.totalRow === data.total ? 0 : 54
                const height = data.totalRow === 0 ? 105 : 51 + (data.totalRow * 108) + pagination_height
                $table.bootstrapTable( 'resetView' , {height: height} );
                $('.senddataloader').hide();
                params.success(data)
            },
            error : function(e){
                $('.senddataloader').hide();
                alert(e);
            }
        });
    }
</script>

@endpush
