@extends('layouts.admin_dashboard')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-admin.css') }}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}">
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
                <a class="badge-str mt-2 mr-3 disabled">Project</a>
            </div>
            <div class="mr-4 d-flex align-items-center" style="margin-top: auto">
                <!--<select style="border-radius: 8px; margin-right: 1rem;font-size: 12px;padding: 4px 15px;" class="form-control" id="select-sort" name="select-sort">
                    <option value="" selected disabled>Sort by</option>
                    <option value="tipe">Tipe File</option>
                    <option value="total">Total File</option>
                </select>-->
                <a href="#" class="btn btn-outline-primary mt-2 mr-3" id="dropdownMenuLink" style="text-decoration: none;border-radius: 12px;padding: 0.1rem 1rem;margin-top: 0 !important;background: white;"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort by<i class="fa fa-caret-down" style="margin-left: 0.5rem !important;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width:160px !important;">
                    <div onclick="getData(this, 'title-asc')" class="btn dropdown-item dd-cus">Judul</div>
                    <div onclick="getData(this, 'created_at-desc')" class="btn dropdown-item dd-cus">Tanggal</div>
                    <div onclick="getData(this, 'views-desc')" class="btn dropdown-item dd-cus">View</div>
                </div>
                <div>
                    <a href="{{route('manage_com.upload_form', ['type'=>'content'])}}" type="button" style="border-radius: 12px; line-height: 2; padding: 0.1rem 1rem" class="btn btn-success d-flex align-items-center"><i class="fa fa-plus mr-3"></i>Upload</a>
                </div>
            </div>
        </div>

        <!-- NAVIGASI -->
        <!-- NAVIGASI -->
        @include('layouts.alert')
        <div>
            <a href="{{route('project.index',$data->project->slug)}}" class="badge-str mt-2 ml-2" style="font-size: 22px; font-weight: 600; text-decoration: underline from-font">{{$data->project->nama}}</a>
        </div>

        <div class="content-file mt-4 ml-2" id="content-file">
            @forelse ($data->cominit as $value)
                    @foreach($data->type as $item)
                        <div class="mb-4">
                            <div style="font-size: 22px;font-weight: 700;">{{ $item->name }}</div>
                            <div style="font-weight: 500" class="mb-2">{{ $item->total_content }} files</div>
                            <div class="d-flex justify-content-between pr-5">
                                <div class="d-flex align-items-center">
                                    @forelse($item->content as $content)
                                        <div class="container-img mr-3">
                                            <div class="d-none">{{ json_encode($content) }}</div>
                                            <img src="{{ config('app.url') . 'storage/' . $content->thumbnail }}"
                                                onclick="view(this)" onerror="imgError(this)" alt="{{ $content->title }}"
                                                title="{{ $content->title }}" width="150" height="150"
                                                class="img-com">
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                                <div class="d-flex flex-column justify-content-center align-items-center"
                                    onclick="showMore('{{ $item->id }}', '{{ $slug }}')"
                                    style="margin: auto 4px; font-size: 18px; color: #2f80ed; cursor:pointer;">
                                    <i class="fas fa-chevron-right mr-3"
                                        style="font-size: 26px;padding: 4px 9px;border: 3px solid #2f80ed;border-radius: 50%;background: #f4f6f9;color: #2f80ed;"></i>Lihat
                                    Semua
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                @empty
                @endforelse
                @forelse($data->piloting as $item)
                    <div class="mb-4">
                        <div style="font-size: 22px;font-weight: 700;">Piloting</div>
                        <div style="font-weight: 500" class="mb-2">{{ count($data->piloting) }} files</div>
                        <div class="d-flex justify-content-between pr-5">
                            <div class="d-flex align-items-center">
                                <div class="container-img mr-3">
                                    <img src="{{ config('app.url') . 'storage/' . $item->thumbnail }}" onclick="view(this)"
                                        onerror="imgError(this)" alt="{{ $item->title }}" title="{{ $item->title }}"
                                        width="150" height="150" class="img-com">
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                onclick="showMore('{{ $item->id }}', '{{ $slug }}')"
                                style="margin: auto 4px; font-size: 18px; color: #2f80ed; cursor:pointer;">
                                <i class="fas fa-chevron-right mr-3"
                                    style="font-size: 26px;padding: 4px 9px;border: 3px solid #2f80ed;border-radius: 50%;background: #f4f6f9;color: #2f80ed;"></i>Lihat
                                Semua
                            </div>
                        </div>
                    </div>
                    <hr>
                @empty
                @endforelse
                @forelse($data->roll_out as $item)
                    <div class="mb-4">
                        <div style="font-size: 22px;font-weight: 700;">Roll Out</div>
                        <div style="font-weight: 500" class="mb-2">{{ count($data->roll_out) }} files</div>
                        <div class="d-flex justify-content-between pr-5">
                            <div class="d-flex align-items-center">
                                <div class="container-img mr-3">
                                    <img src="{{ config('app.url') . 'storage/' . $item->thumbnail }}"
                                        onclick="view(this)" onerror="imgError(this)" alt="{{ $item->title }}"
                                        title="{{ $item->title }}" width="150" height="150" class="img-com">
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                onclick="showMore('{{ $item->id }}', '{{ $slug }}')"
                                style="margin: auto 4px; font-size: 18px; color: #2f80ed; cursor:pointer;">
                                <i class="fas fa-chevron-right mr-3"
                                    style="font-size: 26px;padding: 4px 9px;border: 3px solid #2f80ed;border-radius: 50%;background: #f4f6f9;color: #2f80ed;"></i>Lihat
                                Semua
                            </div>
                        </div>
                    </div>
                    <hr>
                @empty
                @endforelse
                @forelse($data->sosialisasi as $item)
                    <div class="mb-4">
                        <div style="font-size: 22px;font-weight: 700;">Sosialisasi</div>
                        <div style="font-weight: 500" class="mb-2">{{ count($data->sosialisasi) }} files</div>
                        <div class="d-flex justify-content-between pr-5">
                            <div class="d-flex align-items-center">
                                <div class="container-img mr-3">
                                    <img src="{{ config('app.url') . 'storage/' . $item->thumbnail }}"
                                        onclick="view(this)" onerror="imgError(this)" alt="{{ $item->title }}"
                                        title="{{ $item->title }}" width="150" height="150" class="img-com">
                                </div>
                            </div>
                            <div class="d-flex flex-column justify-content-center align-items-center"
                                onclick="showMore('{{ $item->id }}', '{{ $slug }}')"
                                style="margin: auto 4px; font-size: 18px; color: #2f80ed; cursor:pointer;">
                                <i class="fas fa-chevron-right mr-3"
                                    style="font-size: 26px;padding: 4px 9px;border: 3px solid #2f80ed;border-radius: 50%;background: #f4f6f9;color: #2f80ed;"></i>Lihat
                                Semua
                            </div>
                        </div>
                    </div>
                    <hr>
                @empty
                @endforelse
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
<script>
    let uri;
    let csrf = '';
    let be      = '';
    const slug = '{{$slug}}'

    const months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    const type = [
        {'id': 'article', 'name': 'Articles'},
        {"id": "logo", "name": "Icon, Logo, Maskot BRIVO"},
        {"id": "infographics", "name": "Infographics"},
        {"id": "transformation", "name": "Transformation Journey"},
        {"id": "podcast", "name": "Podcast"},
        {"id": "video", "name": "Video Content"},
        {"id": "instagram", "name": "Instagram Content"}
    ]

    const metas = document.getElementsByTagName('meta');
    for (let i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute('name') === "pages") {
            uri = metas[i].getAttribute('content');
        }

        if (metas[i].getAttribute('name') === "BE") {
            be = metas[i].getAttribute('content');
        }

        if (metas[i].getAttribute('name') === "csrf") {
            csrf = metas[i].getAttribute('content');
        }
    }
    function showMore(type, slug) {
        window.location.href = uri+`/managecommunication/strategicinitiative/project/${slug}/${type}`;
    }

    function imgError(image) {
        let r = Math.floor(Math.random() * 9) + 1
        image.onerror = "";
        image.src = `${uri}/assets/img/news/img0${r}.jpg`;
        return true;
    }

    function view(e) {
        let row = JSON.parse($(e).parent().children().first().text())

        let attach = row.attach_file
        const url = `${uri}/communication/views/content/${row.id}`

        $.ajax({
            url: url,
            data: {data: attach},
            type: 'post',
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                $('.senddataloader').show();
                $('#content-preview-desc').empty();
            },
            success: function (data) {
                $('.senddataloader').hide();
                $('#content-preview-desc').append(data.html);
                $('#coloumnrow').append(data.col);
                $('#modal-preview-1').modal({
                    show : true
                });
            },
            error: function () {
                $('.senddataloader').hide();
                Toast2.fire({icon: 'error',title: 'Gagal'});
            },
        })
    }

    function dateFormat(date) {
        return date.getDate()+" "+ months[date.getMonth()]+" "+date.getFullYear();
    }

    function getData(e, dataSort) {
        const [sort, order] = dataSort.split('-')
        const url = `${uri}/get/strategicinitiative/project/${slug}?sort=${sort}&order=${order}`
        $.ajax({
            url: url,
            type: "get",
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                $('.senddataloader').show();
            },
            success: function(res){
                const data = res.data.type
                $('.senddataloader').hide();
                $("#content-file").empty();
                if (data.length !== 0){
                    for (let i=0; i < data.length; i++){
                        let content = `
                            <div class="mb-4">
                                <div style="font-size: 22px;font-weight: 700;">${data[i].name}</div>
                                <div style="font-weight: 500" class="mb-2">${data[i].total_content} files</div>
                                <div class="d-flex justify-content-between pr-5">
                                    <div class="d-flex align-items-center">
                                        ${render(data[i].content)}
                                    </div>
                                    <div class="d-flex flex-column justify-content-center align-items-center" onclick="showMore('${data[i].id}', '${slug}')" style="margin: auto 4px; font-size: 18px; color: #2f80ed; cursor:pointer;">
                                        <i class="fas fa-chevron-right mr-3"
                                           style="font-size: 26px;padding: 4px 9px;border: 3px solid #2f80ed;border-radius: 50%;background: #f4f6f9;color: #2f80ed;"></i>Lihat Semua</div>
                                </div>
                            </div>
                            <hr>`
                        $('#content-file').append(content);
                    }
                }else{
                    $('#content-file').append(`
                    <div class="p-2 w-100 pt-5 text-center">
                        <img src="${uri}/assets/img/forum_kosong_1.png" style="width: 25%; height: fit-content">
                        <h5 class="font-weight-bold mt-5 mb-1">Oops.. Project tidak ditemukan</h5>
                        <p class="w-100 text-center font-weight-bold">Coba cari project lain</p>
                    </div>`);
                }
                if (e) {
                    $('#dropdownMenuLink').empty()
                    $('#dropdownMenuLink').append(`${$(e).text()}<i class="fa fa-caret-down" style="margin-left: 0.5rem !important;"></i>`)
                }
            },
            error : function(e){
                alert(e);
            }
        });
        
        function render(content) {
            let html = ''
            for (let i=0; i < content.length; i++){
                html += `
                <div class="container-img mr-3">
                    <div class="d-none">${JSON.stringify(content[i])}</div>
                    <img src="${uri}/storage/${content[i].thumbnail}" onclick="view(this)" onerror="imgError(this)"
                         alt="${content[i].title}" title="${content[i].title}" width="150" height="150" class="img-com">
                </div>`
            }
            return html;
        }
    }
</script>

@endpush