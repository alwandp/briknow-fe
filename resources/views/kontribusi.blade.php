@extends('layouts.master')
@section('title', 'BRIKNOW')
@push('style')
<link rel="stylesheet" href="{{asset_app('assets/css/select2-bootstrap.min.css')}}">
<!-- Filepond stylesheet -->
<link rel="stylesheet" href="{{asset_app('assets/css/filepond.css')}}">
<link href="{{asset_app('assets/css/filepond-preview.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset_app('assets/css/fa.css')}}">
<link rel="stylesheet" href="{{ asset_app('assets/css/fa-oth.css') }}" />
<link rel="stylesheet" href="{{ asset_app('assets/css/kontribusi.css') }}" />
<script src="{{asset_app('assets/js/plugin/ckeditor/ckeditor.js')}}"></script>
@endpush

@section('breadcumb', 'Kontribusi')
@section('pages', asset_app(''))
@section('token', session()->get('token'))

@section('content')
<div class="row judul mb-4">
    <div class="stepwizard align-items-center mb-4">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step s2 stepwizard-step-garis">
                <a href="#step-1" id="s-1" class="btn bunderan btn-warning btn-circle reguler">1</a>
                <p class="ket"><strong>Data Project</strong></p>
            </div>
            <div class="stepwizard-step s3 stepwizard-step-garis">
                <a href="#step-2" id="s-2" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">2</a>
                <p class="ket"><strong>Detail Project</strong></p>
            </div>
            <div class="stepwizard-step s4">
                <a href="#step-3" id="s-3" class="btn bunderan btn-default btn-circle disable" style="pointer-events: none">3</a>
                <p class="ket"><strong>Upload Dokumen</strong></p>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                <span class="font-weight-bold d-block">Mohon Dilengkapi :</span>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible show fade pb-1">
            <div class="alert-body mb-2">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                <small>
                    {!!session()->get('error')!!}
                </small>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-12">
        <form action="{{route('kontribusi.create')}}" id="form"  method="post" enctype="multipart/form-data">
            @csrf
            {{-- STEP 1 --}}
            <div class="mb-5 setup-content" id="step-1">
                <input type="text" id="url" name="url">
                <div class="mb-4">
                    <h4>Data Project</h4>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12 col-md-2 d-flex align-items-end pb-2">
                        <label for="" class="col-form-label font-weight-600">Thumbnail Project<span class="text-danger ml-1">*</span></label>
                    </div>
                    <div class="col-sm-12 col-md-10">
                        <input type="file" class="filepond filepond-font thumbnail-input col-thumbnail" id="photo" name="photo" value="{{old('photo')}}" required/>
                        <input type="hidden" class="form-control" id="project" name="project"/>
                        @isset($data->data->thumbnail)
                        <input value="{{$data->data->thumbnail}}" name="old_photo" id="old_photo" type="hidden"/>
                        @endisset
                        @if(old('photo') <> null)
                        <input value="{{old('photo')}}" name="old_photo" id="old_photo" type="hidden"/>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Direktorat<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select name="direktorat" id="direktorat" class="form-control text-black select2" value="{{old('direktorat')}}" required>
                            <option value="" disabled selected>Pilih Direktorat</option>
                            @foreach ($data->direktorat == NULL ? 'Lainnya' : $data->direktorat as $item)
                            @isset($data->data->divisi)
                            @if($data->data->divisi->direktorat == $item->direktorat)
                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}" selected>{{ $item->direktorat }}</option>
                            @else
                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                            @endif
                            @elseif(old('direktorat') <> null)
                            @if(old('direktorat') == $item->direktorat)
                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}" selected>{{ $item->direktorat }}</option>
                            @else
                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                            @endif
                            @else
                            <option value="{{$item->direktorat }}" data-value="{{ $item->direktorat }}">{{ $item->direktorat }}</option>
                            @endisset
                            @endforeach
                            <option value="NULL">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Unit Kerja<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select  id="divisi" class="form-control select2" value="{{old('divisi')}}" name="divisi" required>
                            <option value="" selected disabled>Pilih Unit Kerja</option>
                            @isset($data->data->divisi)
                            <option value="{{$data->data->divisi->id }}" data-value="{{ $data->data->divisi->divisi }}" selected>{{ $data->data->divisi->divisi }}</option>
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Nama Proyek<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <input type="text" name="nama_project" id="nama_project" class="form-control" value="{{$data->data->nama ?? old('nama_project')}}" placeholder="Nama Proyek" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-2 col-sm-12"></div>
                    <div class="col-md-5 col-sm-12">
                        <input type="checkbox" name="status" class="box-shadow-none d-inline mr-2 h-50" id="stat_project" {{(isset($data->data->status_finish)) ? ($data->data->status_finish == '1' ? 'checked' : '') : (old('status') <> '' ? 'checked' : '')}}>Project telah selesai
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tgl_mulai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Tanggal Mulai<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-5 col-sm-12">
                        <input type="date" data-provide="datepicker" class="form-control" value="{{(isset($data->data->tanggal_mulai)) ? \Carbon\carbon::create($data->data->tanggal_mulai)->format('Y-m-d') : old('tgl_mulai')}}" id="tgl_mulai" name="tgl_mulai" placeholder="Tanggal mulai" max="{{\Carbon\carbon::now()->format('Y-m-d')}}" required>
                    </div>
                </div>
                @if(old('tgl_selesai') <> '')
                <div class="form-group row content-selesai">
                    <label for="tgl_selesai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center content-selesai">Tanggal Selesai<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-5 col-sm-12 content-selesai">
                        <input type="date" data-provide="datepicker" class="form-control" id="tgl_selesai" name="tgl_selesai" value="{{old('tgl_selesai')}}" placeholder="Tanggal selesai" required>
                    </div>
                </div>
                @elseif(isset($data->data->status_finish))
                @if($data->data->status_finish == '1')
                <div class="form-group row content-selesai">
                    <label for="tgl_selesai" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center content-selesai">Tanggal Selesai<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-5 col-sm-12 content-selesai">
                        <input type="date" data-provide="datepicker" class="form-control" id="tgl_selesai" name="tgl_selesai" value="{{(isset($data->data->tanggal_selesai)) ? \Carbon\carbon::create($data->data->tanggal_selesai)->format('Y-m-d') : old('tgl_selesai')}}" placeholder="Tanggal selesai" required>
                    </div>
                </div>
                @endif
                @endif
                <div class="w-100" id="form_tgl_selesai">
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Nama Project Manager<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <input type="text" class="form-control" id="projectmanager" value="{{$data->data->project_managers->nama ?? old('pm')}}" placeholder="Nama Project Manager" name="pm" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Email Project Manager<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <input type="email" class="form-control" id="email" value="{{$data->data->project_managers->email ?? old('emailpm')}}" placeholder="example@domain.com" name="emailpm" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Konsultan/Vendor<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-3 col-sm-12">
                        <select class="form-control" id="jenispekerja" name="jenispekerja" value="{{old('jenispekerja')}}" required>
                            <option value="" selected disabled>Pilih Konsultan/Vendor</option>
                            @if(old('jenispekerja') <> '')
                            <option value="1" {{old('jenispekerja') == '1' ? 'selected' : ''}}>Vendor</option>
                            <option value="0" {{old('jenispekerja') == '0' ? 'selected' : ''}}>Internal</option>
                            @else
                            <option value="1" {{(isset($data->data->consultant)) ? ($data->data->consultant == [] ? '' : 'selected') : ''}}>Vendor</option>
                            <option value="0" {{(isset($data->data->consultant)) ? ($data->data->consultant == [] ? 'selected' : '') : ''}}>Internal</option>
                            @endif
                        </select>
                    </div>
                </div>
                @if(old('konsultant') <> '')
                @if(old('konsultant') <> [])
                <div class="form-group row content-worker">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Konsultan/Vendor 1<span class='text-danger'>*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select class="select2 form-control" id="konsultant" name="konsultant[]" multiple required data-select2-tags="true">
                            @forelse($data->consultant as $item)
                            @php
                            $sudah = 0;
                            @endphp
                            @for($i = 0; $i < count(old('konsultant')); $i++)
                            @if(old('konsultant')[$i] == $item->id)
                            <option value='{{$item->id}}' data-value='{{$item->nama}}' selected>{{$item->nama}}</option>
                            @php
                            $sudah = 1;
                            @endphp
                            @endif
                            @endfor
                            @if($sudah !== 1)
                            <option value='{{$item->id}}' data-value='{{$item->nama}}'>{{$item->nama}}</option>
                            @endif
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                @endif
                @elseif(isset($data->data->consultant))
                @if($data->data->consultant !== [])
                <div class="form-group row content-worker">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Konsultan/Vendor 2<span class='text-danger'>*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select class="select2 form-control" id="konsultant" name="konsultant[]" multiple required data-select2-tags="true" data-live-search="true">
                            @forelse($data->consultant as $item)
                            @php
                            $sudah = 0;
                            @endphp
                            @forelse($data->data->consultant as $item2)
                            @if($item2->id == $item->id)
                            <option value='{{$item->id}}' data-value='{{$item->nama}}' selected>{{$item->nama}}</option>
                            @php
                            $sudah = 1;
                            @endphp
                            @endif
                            @empty
                            @endforelse

                            @if($sudah !== 1)
                            <option value='{{$item->id}}' data-value='{{$item->nama}}'>{{$item->nama}}</option>
                            @endif
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
                @endif
                @endisset
                <div class="w-100" id="worker"></div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Restricted Page<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-3 col-sm-12">
                        <select class="form-control" id="restricted" value="{{old('restricted')}}" name="restricted" required>
                            <option value="" selected disabled>Pilih Opsi</option>
                            @if(old('restricted') <> '')
                            <option value="1" {{old('restricted') == '1' ? 'selected' : ''}}>Ya</option>
                            <option value="0" {{old('restricted') == '0' ? 'selected' : ''}}>Tidak</option>
                            @else
                            <option value="1" {{(isset($data->data->is_restricted)) ? ($data->data->is_restricted == 1 ? 'selected' : '') : ''}}>Ya</option>
                            <option value="0" {{(isset($data->data->is_restricted)) ? ($data->data->is_restricted == 1 ? '' : 'selected') : ''}}>Tidak</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div id="restricted_content">
                    @if(old('user') <> '')
                    @if(old('user') <> [])
                    <div class="form-group w-100 d-flex justify-content-start content-restricted">
                        <div>
                            <label for="" class="col-form-label font-weight-600">User yang mendapatkan Hak Akses<span class='text-danger'>*</span></label>
                        </div>
                    </div>
                    <div class="form-group row content-restricted">
                        <div class="col-md-12 col-sm-12">
                            <select name="user[]" id="restricted-user" class="restricted-user select2 form-control @error('user') is-invalid @enderror" placeholder='Masukan Personal Number' multiple required>
                                @for($i = 0; $i < count(old('user')); $i++)
                                <option value='{{old('user')[$i]}}' data-value='{{old('user')[$i]}}' selected>{{old('user')[$i]}}</option>
                                @endfor
                            </select>
                            @error('user')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    @endif
                    @elseif(isset($data->data->user_restrict))
                    @if($data->data->is_restricted == 1)
                    <div class="form-group w-100 d-flex justify-content-start content-restricted">
                        <div>
                            <label for="" class="col-form-label font-weight-600">User yang mendapatkan Hak Akses<span class='text-danger'>*</span></label>
                        </div>
                    </div>
                    <div class="form-group row content-restricted">
                        <div class="col-md-12 col-sm-12">
                            <select name="user[]" id="restricted-user" class="restricted-user select2 form-control @error('user') is-invalid @enderror" placeholder='Masukan Personal Number' multiple required>
                                @isset($data->data->user_restrict)
                                @forelse($data->data->user_restrict as $item)
                                <option value='{{$item->user_id}}' data-value='{{$item->user_id}}' selected>{{isset($item->user->name) ? $item->user_id.' - '.$item->user->name : $item->user_id}}</option>
                                @empty
                                @endforelse
                                @endisset
                            </select>
                            @error('user')
                            {{$message}}
                            @enderror
                        </div>
                    </div>
                    @endif
                    @endisset
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <div>
                            <a href="{{route('myproject')}}" class="btn btn-outline-primary btn-sm mr-2">Previous</a>
                            <button class="btn btn-primary text-white nextBtn btn-sm pull-right" type="button" >Next</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END STEP 1 --}}

            {{-- STEP 2 --}}
            <div class="mb-5 setup-content" style="display:none;" id="step-2">
                <div class="mb-4">
                    <h4>Detail Project</h4>
                </div>
                <div class="form-group row ">
                    <label for="" class="col-sm-12 col-form-label font-weight-600">Deskripsi Project<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-12">
                        <textarea name="deskripsi" class="w-100" name="deskripsi" value="{{$data->data->deskripsi ?? old('deskripsi')}}" id="editor-deskripsi">{{$data->data->deskripsi ?? old('deskripsi')}}</textarea>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="" class="col-sm-12 col-form-label font-weight-600">Metodologi<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-12">
                        <textarea name="metodologi" class="w-100" name="metodologi" id="editor-metodologi" value="{{$data->data->metodologi ?? old('metodologi')}}">{{$data->data->metodologi ?? old('metodologi')}}</textarea>
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="" class="col-sm-12 col-form-label font-weight-600">Tags<span class="text-danger ml-1">*</span></label>
                    <div class="col-sm-12 mb-1">
                        <div class="input-group">
                            <select id="tags" class="form-control select2" name="keyword[]" required multiple="multiple" data-select2-tags="true">
                                @forelse($data->tags as $item)
                                @php
                                $sudah = 0;
                                @endphp

                                @if(old('keyword') <> '')
                                @if(old('keyword') <> [])
                                @for($i = 0; $i < count(old('keyword')); $i++)
                                @if(old('keyword')[$i] === $item->nama)
                                <option value="{{$item->nama}}" name="keyword[]" data-value="{{$item->nama}}" selected>{{$item->nama}}</option>
                                @php
                                $sudah = 1;
                                @endphp
                                @endif
                                @endfor
                                @endif
                                @elseif(isset($data->data->keywords))
                                @forelse($data->data->keywords as $item2)
                                @if($item2->nama === $item->nama)
                                <option value="{{$item->nama}}" name="keyword[]" data-value="{{$item->nama}}" selected>{{$item->nama}}</option>
                                @php
                                $sudah = 1;
                                @endphp
                                @endif
                                @empty
                                @endforelse
                                @endif

                                @if($sudah !== 1)
                                <option value="{{$item->nama}}" name="keyword[]" data-value="{{$item->nama}}">{{$item->nama}}</option>
                                @endif
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-sm-12 d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <label class="p-0 col-sm-12 col-form-label font-weight-600">Lesson Learned<span class="text-danger ml-1">*</span></label>
                        </div>
                        <div>
                            <button type="button" id="add_lesson" class="btn btn-success btn-sm"><i class="fas fa-plus px-1"></i><span class="px-1">Tambah Kolom</span></button>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                <th style="min-width: 20px;">No</th>
                                <th style="min-width: 480px;">Lesson Learned</th>
                                <th style="min-width: 60px;">Tahap</th>
                                <th style="min-width: 480px;">Detail Keterangan</th>
                                <th style="min-width: 50px;">Aksi</th>
                                </thead>
                                <tbody class="text-center content_lesson">
                                @php
                                    $awal = 1;
                                @endphp
                                @if(old('lesson') <> '' && old('lesson_keterangan') <> '')
                                    @if(old('lesson') <> [] && old('lesson_keterangan') <> [])
                                        @php
                                            $itung = count(old('lesson'));
                                        @endphp
                                        <input type="hidden" id="urut" value="{{$itung}}">
                                        @for($i = 0; $i < count(old('lesson')); $i++)
                                            <tr class='ll_field'>
                                                <td class="bg-white attr_input" style="vertical-align: text-top"><span
                                                            class='control_ll'> {{$awal++}}</span></td>
                                                <td>
                                                    <textarea class="w-100 lesson_field lesson" id="lesson_learn" name="lesson[]" rows="5"
                                                              placeholder="..."
                                                              required>{{old('lesson')[$i]}}</textarea>
                                                </td>
                                                <td style="vertical-align: text-top">
                                                    <select name="tahap[]" class="w-100 lesson_field tahap"
                                                            required value="{{old('tahap')[$i]}}">
                                                        <option value="Plan" {{old('tahap')[$i] == 'Plan' ? 'selected' : ''}}>Plan</option>
                                                        <option value="Pilot Run" {{old('tahap')[$i] == 'Pilot Run' ? 'selected' : ''}}>Pilot Run</option>
                                                        <option value="Procurement" {{old('tahap')[$i] == 'Procurement' ? 'selected' : ''}}>Procurement</option>
                                                        <option value="Development" {{old('tahap')[$i] == 'Development' ? 'selected' : ''}}>Development</option>
                                                        <option value="Implementation" {{old('tahap')[$i] == 'Implementation' ? 'selected' : ''}}>Implementation</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <textarea class="w-100 lesson_field lesson_keterangan"
                                                              id="lesson_keterangan"
                                                              name="lesson_keterangan[]" placeholder="..."
                                                              required rows="5">{{old('lesson_keterangan')[$i]}}</textarea>
                                                </td>
                                                <td><img class='ll_min'
                                                         src='{{ asset('assets/img/datatables/ic_trash.png') }}'/></td>
                                            </tr>
                                        @endfor
                                    @endif
                                @elseif(isset($data->data->lesson_learned))
                                    @php
                                        $itung = count($data->data->lesson_learned);
                                    @endphp
                                    <input type="hidden" id="urut" value="{{$itung}}">
                                    @forelse($data->data->lesson_learned as $item)
                                        <tr class='ll_field'>
                                            <td class="bg-white attr_input" style="vertical-align: text-top"><span class='control_ll'> {{$awal++}}</span>
                                            </td>
                                            <td>
                                                <textarea name="lesson[]" class="w-100 lesson_field lesson" rows="5"
                                                          placeholder="..."
                                                          required>{{$item->lesson_learned}}</textarea>
                                            </td>
                                            <td style="vertical-align: text-top">
                                                <select name="tahap[]" class="w-100 lesson_field tahap"
                                                          required value="{{$item->tahap}}">
                                                    <option value="Plan" {{$item->tahap == 'Plan' ? 'selected' : ''}}>Plan</option>
                                                    <option value="Pilot Run" {{$item->tahap == 'Pilot Run' ? 'selected' : ''}}>Pilot Run</option>
                                                    <option value="Procurement" {{$item->tahap == 'Procurement' ? 'selected' : ''}}>Procurement</option>
                                                    <option value="Development" {{$item->tahap == 'Development' ? 'selected' : ''}}>Development</option>
                                                    <option value="Implementation" {{$item->tahap == 'Implementation' ? 'selected' : ''}}>Implementation</option>
                                                </select>
                                            </td>
                                            <td>
                                                <textarea name="lesson_keterangan[]"
                                                          class="w-100 lesson_field lesson_keterangan" rows="5"
                                                          required>{{$item->detail}}</textarea>
                                            </td>
                                            <td><img class='ll_min'
                                                     src='{{ asset('assets/img/datatables/ic_trash.png') }}'/></td>
                                        </tr>
                                    @empty
                                        <tr class='ll_field'>
                                            <td class="bg-white attr_input" style="vertical-align: text-top"><span class='control_ll'> 1</span></td>
                                            <td>
                                                <textarea class="w-100 lesson_field lesson"
                                                          name="lesson[]" placeholder="..." required rows="5"></textarea>
                                            </td>
                                            <td style="vertical-align: text-top">
                                                <select name="tahap[]" class="w-100 lesson_field tahap"
                                                        required value="">
                                                    <option value="Plan" {{'Plan' == 'Plan' ? 'selected' : ''}}>Plan</option>
                                                    <option value="Pilot Run" {{'Pilot Run' == 'Pilot Run' ? 'selected' : ''}}>Pilot Run</option>
                                                    <option value="Procurement" {{'Procurement' == 'Procurement' ? 'selected' : ''}}>Procurement</option>
                                                    <option value="Development" {{'Development' == 'Development' ? 'selected' : ''}}>Development</option>
                                                    <option value="Implementation" {{'Implementation' == 'Implementation' ? 'selected' : ''}}>Implementation</option>
                                                </select>
                                            </td>
                                            <td><textarea class="w-100 lesson_field lesson_keterangan"
                                                       name="lesson_keterangan[]" placeholder="..." required rows="5"></textarea>
                                            </td>
                                            <td><img class='ll_min'
                                                     src='{{ asset('assets/img/datatables/ic_trash.png') }}'/></td>
                                        </tr>
                                    @endforelse
                                @else
                                    <input type="hidden" id="urut" value="{{$awal}}">
                                    <tr class='ll_field'>
                                        <td class="bg-white attr_input" style="vertical-align: text-top"><span class='control_ll'> 1</span></td>
                                        <td><textarea class="w-100 lesson_field lesson" name="lesson[]"
                                                     placeholder="..." required rows="5"></textarea>
                                        </td>
                                        <td style="vertical-align: text-top">
                                            <select name="tahap[]" class="w-100 lesson_field tahap"
                                                    required value="">
                                                <option value="Plan" {{'Plan' == 'Plan' ? 'selected' : ''}}>Plan</option>
                                                <option value="Pilot Run" {{'Pilot Run' == 'Pilot Run' ? 'selected' : ''}}>Pilot Run</option>
                                                <option value="Procurement" {{'Procurement' == 'Procurement' ? 'selected' : ''}}>Procurement</option>
                                                <option value="Development" {{'Development' == 'Development' ? 'selected' : ''}}>Development</option>
                                                <option value="Implementation" {{'Implementation' == 'Implementation' ? 'selected' : ''}}>Implementation</option>
                                            </select>
                                        </td>
                                        <td><textarea class="w-100 lesson_field lesson_keterangan"
                                                      name="lesson_keterangan[]" placeholder="..." required rows="5"></textarea>
                                        </td>
                                        <td><img class='ll_min'
                                                 src='{{ asset('assets/img/datatables/ic_trash.png') }}'/></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button class="btn btn-outline-primary prevBtn btn-sm mr-2" type="button">Previous</button>
                        <button class="btn btn-primary text-white nextBtn btn-sm pull-right" type="button" >Next</button>
                    </div>
                </div>
            </div>
            {{-- END STEP 2 --}}

            {{-- STEP 3 --}}
            <div class="mb-5 setup-content" style="display:none;" id="step-3">
                <div class="form-group row mb-4">
                    <div class="col-sm-12">
                        <h5>Upload Dokumen Project<span class="text-danger ml-1">*</span></h5>
                        <div id="attach-wrap" class="dropzones-wrapper d-flex align-items-center justify-content-center">
                            <div class="dropzones-desc d-flex align-items-center justify-content-center">
                                <i class="fa fa-file mr-3" style="font-size: 24px"></i>
                                <p style="text-align:left;cursor:default;margin-bottom: 0">Drag file here<br>or <span class="choose-file">choose your file</span></p>
                            </div>
                            @isset($data->data->document)
                                <input type="file" name="file[]" class="dropzones form-control" id="file" onchange="validate()" multiple>
                            @else
                                <input type="file" name="file[]" class="dropzones form-control" id="file" onchange="validate()" multiple required>
                            @endisset
                            @isset($data->data->id)
                                <input value="{{$data->data->id}}" name="id" id="id" class="old_attach_type" type="hidden"/>
                            @endisset
                        </div>
                        {{--<div>
                            @isset($data->data->document)
                            @forelse($data->data->document as $item)
                            <input value="{{$item->nama}}" name="old_attach[]" class="old_attach" type="hidden"/>
                            <input value="{{$item->size}}" name="old_attach_size[]" class="old_attach_size" type="hidden"/>
                            <input value="{{$item->jenis_file}}" name="old_attach_type[]" class="old_attach_type" type="hidden"/>
                            @empty
                            @endforelse
                            @endisset

                            @isset($data->data->id)
                            <input value="{{$data->data->id}}" name="id" id="id" class="old_attach_type" type="hidden"/>
                            @endisset
                            <input type="file" name="attach[]" id="attach" class="filepond" multiple data-allow-reorder="true" data-max-file-size="10MB">
                        </div>--}}
                        <p style="margin-bottom: 0;line-height: 18px;font-size: 12px;font-style: italic;">* 1 file maks. 100 mb.</p>
                        <p class="mb-2" style="margin-bottom: 0;line-height: 18px;font-size: 12px;font-style: italic;">* Upload sesuai dengan jenis file</p>

                        <div class="preview-zone mt-3" id="preview_zone">
                            @isset($data->data->document)
                                @forelse($data->data->document as $item)
                                    <div id="prev{{$item->id}}" class="d-flex align-items-center mb-3" style=" width: 50%; height: 40px;">
                                        <div class="d-flex align-items-center justify-content-start px-3 mr-3 prev-item">
                                            <div class="d-flex align-items-center justify-content-between detail-prev" style="width: 100%">
                                                <div class="align-items-center text-elip">
                                                    <i class="fas fa-file mr-3"></i>{{$item->nama}}
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center" style="cursor:pointer;" title="Delete" onclick="removePreview(this, 'delete')">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="attach[]" value="{{$item->nama}}">
                                    </div>
                                @empty
                                @endforelse
                            @endisset
                        </div>

                        <div id="temp_delete"></div>
                    </div>
                </div>
                @if(session()->get('role') == 3)
                @isset($data->data->user_maker)
                @if($data->data->user_maker <> session()->get('personal_number'))
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Checker<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select name="checker" id="checker" class="checker select2 form-control @error('checker') is-invalid @enderror" placeholder='Masukan Personal Number' required>
                            @isset($data->data->userchecker)
                            <option value="{{$data->data->user_checker}}" data-value="{{$data->data->user_checker}}" selected>{{$data->data->user_checker}} - {{$data->data->userchecker->name}}</option>
                            @endisset
                        </select>
                        @error('checker')
                        {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Signer<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select name="signer" id="signer" class="signer select2 form-control @error('signer') is-invalid @enderror" placeholder='Masukan Personal Number' required>
                            @isset($data->data->usersigner)
                            <option value="{{$data->data->user_signer}}" data-value="{{$data->data->user_signer}}" selected>{{$data->data->user_signer}} - {{$data->data->usersigner->name}}</option>
                            @endisset
                        </select>
                        @error('signer')
                        {{$message}}
                        @enderror
                    </div>
                </div>
                @else
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Checker<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select class="select2 form-control" id="checker" name="checker" required>
                            <option value="{{session()->get('personal_number')}}" data-value="{{session()->get('name')}}" selected>{{session()->get('name')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Signer<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select class="select2 form-control" id="signer" name="signer" required>
                            <option value="{{session()->get('personal_number')}}" data-value="{{session()->get('name')}}" selected>{{session()->get('name')}}</option>
                        </select>
                    </div>
                </div>
                @endif
                @else
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Checker<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select class="select2 form-control" id="checker" name="checker">
                            <option value="{{session()->get('personal_number')}}" data-value="{{session()->get('name')}}" selected>{{session()->get('name')}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Signer<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select class="select2 form-control" id="signer" name="signer" required>
                            <option value="{{session()->get('personal_number')}}" data-value="{{session()->get('name')}}" selected>{{session()->get('name')}}</option>
                        </select>
                    </div>
                </div>
                @endisset
                @else
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Checker<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select name="checker" id="checker" class="checker select2 form-control @error('checker') is-invalid @enderror" placeholder='Masukan Personal Number' required>
                            @if(old('checker'))
                            <option value="{{old('checker')}}" data-value="{{old('checker')}}" selected>{{old('checker')}}</option>
                            @elseif(isset($data->data->user_checker))
                            <option value="{{$data->data->user_checker}}" data-value="{{$data->data->user_checker}}" selected>{{isset($data->data->userchecker->name) ? $data->data->user_checker.' - '.$data->data->userchecker->name : $data->data->user_checker}}</option>
                            @endif
                        </select>
                        <small class='text-black font-italic'>* Pastikan <b>Personal Number</b> yang di Isi Bukan Anda Atau Admin</small>
                        @error('checker')
                        {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-md-2 col-sm-12 col-form-label d-flex align-items-center">Signer<span class="text-danger ml-1">*</span></label>
                    <div class="col-md-10 col-sm-12">
                        <select name="signer" id="signer" class="signer select2 form-control @error('signer') is-invalid @enderror" placeholder='Masukan Personal Number' required>
                            @if(old('signer'))
                            <option value="{{old('signer')}}" data-value="{{old('signer')}}" selected>{{old('signer')}}</option>
                            @elseif(isset($data->data->user_signer))
                            <option value="{{$data->data->user_signer}}" data-value="{{$data->data->user_signer}}" selected>{{isset($data->data->usersigner->name) ? $data->data->user_signer.' - '.$data->data->usersigner->name : $data->data->user_signer}}</option>
                            @endisset
                        </select>
                        <small class='text-black font-italic'>* Pastikan <b>Personal Number</b> yang di Isi Bukan Anda Atau Admin</small>
                        @error('signer')
                        {{$message}}
                        @enderror
                    </div>
                </div>
                @endif
                <div class="row mt-4">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button class="btn btn-outline-primary prevBtn btn-sm mr-2" type="button">Previous</button>
                        <button class="btn btn-primary text-white nextBtn btn-sm pull-right" id="preview" type="button">Preview</button>
                    </div>
                </div>
            </div>
            {{-- END STEP 3 --}}
        </form>
    </div>
    <div class="modal fade bd-example-modal-lg modal-preview" id="modalpreview" tabindex="-1" role="dialog" aria-labelledby="preview" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
            <div class="modal-content content-preview bg-transparent">
                <div class="w-100 d-flex justify-content-center align-items-center" id="content-preview">
                    <div class="bg-white bg-white w-100">
                        @include('kontribusi.preview')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-script')
<script src="{{asset_app('assets/js/filepond.js')}}"></script>
<script src="{{asset_app('assets/js/filepond-plugin-file-encode.js')}}"></script>
<script src="{{asset_app('assets/js/filepond-plugin-file-validate-size.js')}}"></script>
<script src="{{asset_app('assets/js/filepond-plugin-file-validate-type.js')}}"></script>
<script src="{{asset_app('assets/js/filepond-plugin-image-exif-orientation.js')}}"></script>
<script src="{{asset_app('assets/js/filepond-preview.js')}}"></script>
<!-- Load FilePond library -->
<script src="{{asset_app('assets/js/select2.min.js')}}"></script>
<script src="{{asset_app('assets/js/page/kontribusi.js')}}"></script>
<script>
    let tok = '{{csrf_token()}}';
    CKEDITOR.replace('editor-deskripsi', {
        filebrowserUploadUrl: `{{config('app.url')}}upimgcontent`,
        filebrowserUploadMethod: 'xhr',
        fileTools_requestHeaders: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': tok
        }
    });

    CKEDITOR.replace('editor-metodologi', {
        filebrowserUploadUrl: `{{config('app.url')}}upimgcontent`,
        filebrowserUploadMethod: 'xhr',
        fileTools_requestHeaders: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': tok
        }
    });

    // CKEDITOR.replace('lesson-name', {
    //     toolbar: [
    //         { name: 'styles', items: [ 'Styles', 'Format', 'FontSize' ] },
    //         { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
    //         { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
    //     ],
    //     height : '100px',
    //     allowedContent : true,
    //     resize_enabled : false
    // });

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
    CKEDITOR.config.resize_enabled = false;
</script>
{{-- <script>
    $(document).ready(function(){
        // meta url
        const meta = document.getElementsByTagName('meta');
        for (let i = 0; i < meta.length; i++) {
            if (meta[i].getAttribute('name') === "pages") {
                uri = meta[i].getAttribute('content');
            }
            if (meta[i].getAttribute('name') === "BE") {
                be = meta[i].getAttribute('content');
            }
            if (meta[i].getAttribute('name') === "csrf") {
                csrf = meta[i].getAttribute('content');
            }
        }
    });
</script> --}}
@isset($data->data->consultant)
@if($data->data->consultant !== [])
<script>
    // set select2
    $('#konsultant').select2({
        placeholder : 'Pilih Konsultan/Vendor'
    });
</script>
@endif
@endisset
@isset($data->data->user_restrict)
@if($data->data->is_restricted == 1)
<script>
    // set select2
    $('#user').select2({
        placeholder : 'Pilih User'
    });
</script>
@endif
@endisset
@endpush
