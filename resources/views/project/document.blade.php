<?php $no = 1;?>
@forelse ($data as $doc)
    <tr class="rowdoc">
        <td id="td-attachment" class="d-flex align-items-center">
        <input type="checkbox" name="file" class="mr-1 file" onchange='klik(this);' value="{{$doc->url_file}}">
        <small class='mr-1'>
            <svg class="w-6 h-6 me-1" width="15px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </small>
        <small>
            @if($doc->jenis_file == 'pdf' or $doc->jenis_file == 'jpg' or $doc->jenis_file == 'jpeg' or $doc->jenis_file == 'png' or $doc->jenis_file == 'gif' or $doc->jenis_file == 'txt')        
                <button type="button" class="btn p-0 text-primary" data-toggle="modal" data-target="#preview-{{$doc->id}}">{{$doc->nama}}</button>
            @else
                <a class="btn p-0 text-primary" href="{{Config::get('app.url').'storage/'.$doc->url_file}}" download="{{$doc->nama}}">{{$doc->nama}}</a>
            @endif
        </small>
        </td>
        @php
            $old = strtotime($doc->updated_at);
            $tgl_dok = date('d F Y', $old);
        @endphp
        <td id="td-attachment" class="py-1"><small>{{$tgl_dok}}</small></td>
        <td id="td-attachment" class="py-1"><small>{{formatBytes($doc->size)}}</small></td>
    </tr>
    <?php $no++;?>
@empty
    <tr class="rowdoc">
        <td id="td-attachment" class="d-flex align-items-center">
        <input type="checkbox" name="" class="mr-1" id="">
        <small>
            -
        </small>
        </td>
        <td id="td-attachment">-</td>
        <td id="td-attachment">-</td>
    </tr>
@endforelse