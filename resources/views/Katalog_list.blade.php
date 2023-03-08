
<div class="col-lg-12 col-md-12 col-sm-12 mb-3 data">
    @if($count == 0)
        {!!"<div id='count'><small>0 Data Tidak Ditemukan</small></div>"!!}
    @else
        {!!"<div id='count'><small>Menampilkan <span id='first_number'></span> - <span id='last_number'></span> item dari total $count Hasil Ditemukan <span id='search_custom'></span></small></div>"!!}
    @endif
</div>

<div class="w-100 min-400 data">
    <div class="col-md-12 row mx-0 data">
    @forelse($data as $key => $value)
        <div class="col-lg-6 col-md-6 col-sm-12 data">
            <a href="{{route('project.index',$value->_source->slug)}}" class="text-decoration-none">
                <div class="card border control list-project mb-2">
                    <div class="row px-3">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 p-0 d-flex align-items-center thumb-katalog">
                            <div class="row d-flex justify-content-center">
                                <img src="{{config('app.url').'storage/'.$value->_source->thumbnail??asset_app('assets/img/boxdefault.svg')}}" width="120%" class="card-img-left border-0 rounded thumb">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 pl-1">
                            <div class="card-body content-project">
                                <span class="d-block text-dark header-list-project mb-1">{{\Str::limit($value->_source->nama,20,'..')??'-'}}</span>
                                <small>
                                    <?php $u = 0; ?>
                                    @forelse($value->_source->consultant as $item)
                                        @if($u > 0)
                                            , {{$item->nama!=='' ? \Str::limit($item->nama,22,'..'):'-'}}
                                        @else
                                            {{$item->nama!=='' ? \Str::limit($item->nama,22,'..'):'-'}}
                                        @endif
                                        <?php $u++; ?>
                                        @if($u == 2)
                                            @break
                                        @endif
                                    @empty
                                        Internal
                                    @endforelse
                                </small>
                                <small class="d-block">{{\Str::limit($value->_source->project_managers,22,'..')??'-'}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <div class="col-lg-12 text-center data">
            <em>Tidak Ada Data</em>
        </div>
    @endforelse 
    </div>
</div>
<div class="col-md-12 mt-4 d-flex justify-content-center pagination">
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination" id="pagination">
                
            </ul>
        </nav>
    </div>
</div>