@extends('layouts.master')
@section('title', 'BRIKNOW')
@section('csrf',csrf_token())

@push('style')

<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-oth.css')}}">
    <link rel="stylesheet" href="{{asset_app('assets/css/fa-forum-post.css')}}">
    <script src="{{asset_app('assets/js/plugin/ckeditor/ckeditor.js')}}"></script>
@endpush

@if(isset($mode))
    @section('breadcumb', 'Forum / Edit')
@else
    @section('breadcumb', 'Forum / Draft')
@endif
@section('back', route('forum.index'))

@section('content')
    <div class="row judul">        
        <form action="{{route('forum.update', $data->id??null)}}" id="form"  method="post" enctype="multipart/form-data" class="w-100">
            @csrf
            <div class="col-md-12 px-0 header-detail">
                <div class="row px-2">
                    <div class="col-md-12 mb-2">
                        <div>
                            <h3>Edit Forum</h3>
                        </div>
                    </div>

                    @include('layouts.alert')

                    <div class="col-md-10 col-sm-12">
                        <input type="text" name="title" id="title" placeholder="Title" class="form-control h-40 mb-2" value="{{isset($data->judul) ? $data->judul : ''}}">
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <select name="hakakses" id="hakakses" placeholder="Dapat dilihat oleh..." class="form-control h-40 mb-2">
                            <option value="" selected disabled>Dapat dilihat oleh...</option>
                            <option value="0"{{isset($data->restriction) ? ($data->restriction == '0' ? 'selected' : '') : ''}}>Public</option>
                            <option value="1"{{isset($data->restriction) ? ($data->restriction == '1' ? 'selected' : '') : ''}}>Private</option>
                        </select>
                    </div>
                    <div class="col-md-12" id="restricted" {!!isset($data->restriction) ? ($data->restriction == "0" ? "style='display:none;'" : '') : ''!!}>
                        <select class="select2 form-control h-40 w-100 mb-2" id="user_private" name="user[]" multiple required>
                            @forelse($data->forum_user as $item)
                                <option value='{{$item->user_id}}' data-value='{{$item->user_id}}' selected>{{$item->user_id}}{{isset($item->user->name) ? '-'.$item->user->name : ''}}</option>
                            @empty                                            
                            @endforelse
                        </select>
                    </div>
                    <div class="col-md-12 mt-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item w-50 text-center" role="presentation">
                                <a class="nav-link active" id="post-tab" data-toggle="tab" href="#post-isi" role="tab" aria-controls="post-isi" aria-selected="true">
                                    <svg width="18" height="18" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path class="a0" d="M15 10C14.45 10 14 10.45 14 11V16.22C14 16.77 13.55 17.22 13 17.22H3C2.45 17.22 2 16.77 2 16.22V6C2 5.45 2.45 5 3 5H8C8.55 5 9 4.55 9 4C9 3.45 8.55 3 8 3H2C0.9 3 0 3.9 0 5V17C0 18.1 0.9 19 2 19H14C15.1 19 16 18.1 16 17V11C16 10.45 15.55 10 15 10ZM18.02 3H16V0.98C16 0.44 15.56 0 15.02 0H14.99C14.44 0 14 0.44 14 0.98V3H11.99C11.45 3 11.01 3.44 11 3.98V4.01C11 4.56 11.44 5 11.99 5H14V7.01C14 7.55 14.44 8 14.99 7.99H15.02C15.56 7.99 16 7.55 16 7.01V5H18.02C18.56 5 19 4.56 19 4.02V3.98C19 3.44 18.56 3 18.02 3Z" fill="#0E3984"/>
                                        <path class="a1" d="M11 7H5C4.45 7 4 7.45 4 8C4 8.55 4.45 9 5 9H11C11.55 9 12 8.55 12 8C12 7.45 11.55 7 11 7ZM11 10H5C4.45 10 4 10.45 4 11C4 11.55 4.45 12 5 12H11C11.55 12 12 11.55 12 11C12 10.45 11.55 10 11 10ZM11 13H5C4.45 13 4 13.45 4 14C4 14.55 4.45 15 5 15H11C11.55 15 12 14.55 12 14C12 13.45 11.55 13 11 13Z" fill="#0E3984"/>
                                    </svg>                                  
                                    Post
                                </a>
                            </li>
                            <li class="nav-item w-50 text-center" role="presentation">
                                <a class="nav-link" id="link-tab" data-toggle="tab" href="#link-isi" role="tab" aria-controls="link-isi" aria-selected="false">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path class="b0" d="M5.46588 8.29306C6.59888 7.16006 8.57488 7.16006 9.70788 8.29306L10.4149 9.00006L11.8289 7.58606L11.1219 6.87906C10.1789 5.93506 8.92288 5.41406 7.58688 5.41406C6.25088 5.41406 4.99488 5.93506 4.05188 6.87906L1.92988 9.00006C0.994172 9.93878 0.46875 11.2101 0.46875 12.5356C0.46875 13.861 0.994172 15.1323 1.92988 16.0711C2.39375 16.5356 2.94484 16.9039 3.55149 17.1548C4.15814 17.4057 4.80839 17.5342 5.46488 17.5331C6.12154 17.5344 6.77199 17.406 7.37883 17.1551C7.98567 16.9042 8.53692 16.5358 9.00088 16.0711L9.70788 15.3641L8.29388 13.9501L7.58688 14.6571C7.02335 15.2181 6.26055 15.533 5.46538 15.533C4.67021 15.533 3.90741 15.2181 3.34388 14.6571C2.78238 14.0938 2.46708 13.3309 2.46708 12.5356C2.46708 11.7402 2.78238 10.9773 3.34388 10.4141L5.46588 8.29306Z" fill="#757575"/>
                                        <path class="b1" d="M9.00183 1.92924L8.29483 2.63624L9.70883 4.05024L10.4158 3.34324C10.9794 2.78223 11.7422 2.46727 12.5373 2.46727C13.3325 2.46727 14.0953 2.78223 14.6588 3.34324C15.2203 3.90651 15.5356 4.66941 15.5356 5.46474C15.5356 6.26007 15.2203 7.02297 14.6588 7.58624L12.5368 9.70724C11.4038 10.8402 9.42783 10.8402 8.29483 9.70724L7.58783 9.00024L6.17383 10.4142L6.88083 11.1212C7.82383 12.0652 9.07983 12.5862 10.4158 12.5862C11.7518 12.5862 13.0078 12.0652 13.9508 11.1212L16.0728 9.00024C17.0085 8.06152 17.534 6.79016 17.534 5.46474C17.534 4.13932 17.0085 2.86795 16.0728 1.92924C15.1344 0.993043 13.8629 0.467285 12.5373 0.467285C11.2117 0.467285 9.94029 0.993043 9.00183 1.92924Z" fill="#757575"/>
                                    </svg>
                                    Link                                    
                                </a>
                            </li>
                        </ul>
    
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="post-isi" role="tabpanel" aria-labelledby="post-isi">
                                <textarea name="editorpost" id="editorpost" class="form-control"></textarea>
                            </div>
                            <div class="tab-pane fade" id="link-isi" role="tabpanel" aria-labelledby="link-isi">
                                <textarea name="editorlink" id="editorlink" class="form-control" placeholder="Contoh: http://example.com atau https://example.com"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="d-flex justify-content-end">
                    <input type="hidden" name="tipe" id="tipe" value="post">
                    <input type="hidden" name="status" id="status" value="0">
                    @if(isset($data->user_id))
                        @if($data->user_id == session('personal_number'))
                            <button class="btn btn-sm btn-outline-primary mx-1" type="button" id="btn-draft"><i class="fa fa-file mr-1" aria-hidden="true"></i>Draft</button>
                        @endif
                    @else
                        <button class="btn btn-sm btn-outline-primary mx-1" type="button" id="btn-draft"><i class="fa fa-file mr-1" aria-hidden="true"></i>Draft</button>
                    @endif
                    <button class="btn btn-sm btn-primary mx-1" type="button" id="btn-submit"><i class="fa fa-paper-plane mr-1" aria-hidden="true"></i>Posting</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('page-script')
    <script src="{{asset_app('assets/js/page/forum-create.js')}}"></script>
    <script src="{{asset_app('assets/js/select2.min.js')}}"></script>
    <script>
        // set select2
        $("#user_private").select2({
            minimumInputLength: 8,
            maximumInputLength: 8,
            placeholder: 'Masukan Personal Number',
            ajax: {
                url: `{{url('')}}/searchuser`,
                type: "get",
                headers: {'X-CSRF-TOKEN': csrf},
                data: function (params) {
                    var query = {
                        pn: params.term,
                        mode: 11
                    }
                    // Query parameters will be ?pn=[term]
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data.items
                    };
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // 1 = URL
            // 0 = POST
            let is_active = '{{$data->kategori}}';

            //Auto Switch Tab berdasarkan Jenis Post yg tersimpan (POST/URL) + Load Isinya:
            if (is_active == 1) {
                $('#editorlink').val(`{!! $data->content !!}`);
                $('#link-tab').click();
            } else {
                CKEDITOR.instances.editorpost.setData( `{!! $data->content !!}`);
                $('#post-tab').click();
            }

            //Load Dapat dilihat oleh (Hak Akses):
            $('#hakakses').val('{{$data->restriction}}');
        });
        //SWITCH TAB
        $('form').submit(function (e) { 
            // e.preventDefault();
            const checkTabPost = document.querySelector('#post-tab');
            const checkTabLink = document.querySelector('#link-tab');
            if (checkTabPost.classList.contains('active')) {
                $('#tipe').val('post');
            } else if (checkTabLink.classList.contains('active')) {
                $('#tipe').val('url');
            }
        });
        $('#post-tab').click(function (e) { 
            e.preventDefault();
            $("svg").each(function(){
                $(this).find(".a0").css({ fill: '#0E3984' });
                $(this).find(".a1").css({ fill: '#0E3984' });
                $(this).find(".b0").css({ fill: '#757575' });
                $(this).find(".b1").css({ fill: '#757575' });
            });
        });
        $('#link-tab').click(function (e) { 
            e.preventDefault();
            $("svg").each(function(){
                $(this).find(".b0").css({ fill: '#0E3984' });
                $(this).find(".b1").css({ fill: '#0E3984' });
                $(this).find(".a0").css({ fill: '#757575' });
                $(this).find(".a1").css({ fill: '#757575' });
            });
        });

        //CKEDITOR
        let tok = '{{csrf_token()}}';
        CKEDITOR.replace('editorpost', {
            filebrowserUploadUrl: `{{config('app.url_be')}}api/upimgcontent`,
            filebrowserUploadMethod: 'xhr',             
            fileTools_requestHeaders: {
                'X-Requested-With': 'XMLHttpRequest',
                'csrftoken': tok 
            }
        });
        CKEDITOR.config.toolbar = [
            { name: 'styles', items: [ 'Styles', 'Format', 'FontSize' ] },
            { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
            { name: 'document', items: [ 'Source', 'Preview', 'Print' ] },
            { name: 'insert', items: [ 'Image', 'Table', 'Smiley' ] },
            { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: [ 'Link', 'Unlink' ] },
            { name: 'colors', items: [ 'BGColor' ] },
        ];
        CKEDITOR.config.height = '300px';
        CKEDITOR.config.allowedContent = true;
        // CKEDITOR.config.resize_enabled = false;
    </script>
@endpush
