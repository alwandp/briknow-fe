<!-- KOMENTAR 2 -->
<div class="card shadow">
    <div class="card-body">
        <div class="row pb-2">
            <div class="col-md-2 justify-content-center align-items-center text-center pb-3">
                <img alt="image" src="{{asset_app('assets/img/avatar/avatar-1.png')}}" class="rounded-circle p-2 detail-ava">
            </div>
            <div class="col-md-10 justify-content-left align-items-center text-left pt-2">
                <div>
                    <div>
                        <span id="nama-kanan">{{$data->user->name}}</span> 
                        <small id="date-detail-comment">06/08/2021</small>
                    </div>
                    <div>
                        <a href="{{url()->current()}}./divisi/.{{$data->user->divisis->id}}" id="divisi-kanan" style="text-decoration: none;">{{$data->user->divisis->divisi}}</a>
                    </div>
                </div>
                <div class="py-3 text-justify">
                    <span>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam quo dicta nobis earum non delectus fuga? Reprehenderit repellat aperiam maiores perferendis velit? Suscipit id consectetur qui et obcaecati esse ipsa?
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam quo dicta nobis earum non delectus fuga? Reprehenderit repellat aperiam maiores perferendis velit? Suscipit id consectetur qui et obcaecati esse ipsa?
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <a data-toggle="collapse" href="#toggle-all-replies"><i class="fas fa-comment-alt mr-1"></i>1 Reply</a>
                    </div>
                    <div>
                        <a href="#">Reply</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- REPLY ALL -->
            <div class="collapse" id="toggle-all-replies">
                <!-- REPLY 1 -->
                    <div class="row nest-1 pb-2">
                        <div class="col-md-2 justify-content-center align-items-center text-center py-2">
                            <img alt="image" src="{{asset_app('assets/img/avatar/avatar-1.png')}}" class="rounded-circle p-2 detail-ava">
                        </div>
                        <div class="col-md-10 justify-content-left align-items-center text-left pt-2">
                            <div>
                                <div>
                                    <span id="nama-kanan">Admin</span> 
                                    <small id="date-detail-comment">06/08/2021</small>
                                </div>
                                <div>
                                    <a href="{{url()->current()}}./divisi/.{{$data->user->divisis->id}}" id="divisi-kanan" style="text-decoration: none;">{{$data->user->divisis->divisi}}</a>
                                </div>
                            </div>
                            <div class="py-3 text-justify">
                                <p>
                                    <span class="badge badge-light mr-1">{{$data->user->name}}</span>Ko gitu ?
                                </p>
                            </div>
                            {{-- <div class="d-flex justify-content-between"> --}}
                            <div class="d-flex justify-content-end">
                                {{-- <div>
                                    <i class="fas fa-comment-alt mr-1"></i>5 Replies
                                </div> --}}
                                <div>
                                    <a href="#">Reply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- END -->
                <!-- REPLY 2 -->
                    <div class="row nest-1 pb-2">
                        <div class="col-md-2 justify-content-center align-items-center text-center py-2">
                            <img alt="image" src="{{asset_app('assets/img/avatar/avatar-1.png')}}" class="rounded-circle p-2 detail-ava">
                        </div>
                        <div class="col-md-10 justify-content-left align-items-center text-left pt-2">
                            <div>
                                <div>
                                    <span id="nama-kanan">{{$data->user->name}}</span> 
                                    <small id="date-detail-comment">06/08/2021</small>
                                </div>
                                <div>
                                    <a href="{{url()->current()}}./divisi/.{{$data->user->divisis->id}}" id="divisi-kanan" style="text-decoration: none;">{{$data->user->divisis->divisi}}</a>
                                </div>
                            </div>
                            <div class="py-3 text-justify">
                                <p>
                                    <span class="badge badge-light mr-1">Admin</span>Waduh ?
                                </p>
                            </div>
                            {{-- <div class="d-flex justify-content-between"> --}}
                            <div class="d-flex justify-content-end">
                                {{-- <div>
                                    <i class="fas fa-comment-alt mr-1"></i>5 Replies
                                </div> --}}
                                <div>
                                    <a data-toggle="collapse" href="#toggle-sub-reply">Reply</a>
                                </div>
                            </div>
                            <div class="collapse" id="toggle-sub-reply">
                                <div class="d-flex flex-column py-4">
                                    <div class="px-0 py-0 shadow">
                                        <textarea class="w-100" name="sub-reply" id="editor-sub-reply" value="" placeholder="Tulis komentar"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- END -->
            </div>
        <!-- END -->
    </div>
</div>
<!-- END -->