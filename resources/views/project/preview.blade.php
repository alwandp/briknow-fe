@forelse ($data as $doc)
    @if($doc->jenis_file == 'pdf' or $doc->jenis_file == 'jpg' or $doc->jenis_file == 'jpeg' or $doc->jenis_file == 'png' or $doc->jenis_file == 'gif' or $doc->jenis_file == 'txt')        
        <div class="modal fade bd-example-modal-lg modal-preview" id="preview-{{$doc->id}}" tabindex="-1" role="dialog" aria-labelledby="preview-{{$doc->id}}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered dialog-preview" role="document">
                <div class="modal-content content-preview bg-transparent">
                    <button type="button" class="close d-inline bg-transparent" data-dismiss="modal" aria-label="Close" style="width:10px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center" id="content-preview">
                        @if($doc->jenis_file == 'pdf' or $doc->jenis_file == 'txt')        
                            <iframe src="{{Config::get('app.url').'storage/'.$doc->url_file}}" allow="fullscreen" frameborder="0" class="w-100 h-100 bg-light text-dark"></iframe>
                        @elseif($doc->jenis_file == 'jpg' or $doc->jenis_file == 'jpeg' or $doc->jenis_file == 'png' or $doc->jenis_file == 'gif')
                            <div>
                                <img src="{{Config::get('app.url').'storage/'.$doc->url_file}}" class="max-600" width="100%" alt="">
                            </div>
                        @else
                            <div>
                                File Tidak Di Dukung
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@empty
@endforelse