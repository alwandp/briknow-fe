<?php $no = 1;?>
@forelse ($document as $doc)
    <tr class="rowdoc">
        <td id="td-attachment" class="d-flex align-items-center" style="font-size: 14px">
            <input type="checkbox" name="file" class="mr-2 file" onchange='klik(this);' value="{{$doc->url_file}}">
            <i class="fas fa-file mr-2"></i>
            <a class="btn p-0 text-primary" onmousedown="docClick({{json_encode($doc)}})"
               style="font-size: 14px;text-align:left;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" href="{{Config::get('app.url').'storage/'.$doc->url_file}}" download="{{$doc->nama}}">{{$doc->nama}}</a>
        </td>
        <td id="td-attachment" style="font-size: 14px" class="py-1"><span>{{\Carbon\carbon::create($doc->updated_at)->format('d F Y')}}</span></td>
        <td id="td-attachment" style="font-size: 14px" class="py-1"><span>{{formatBytes($doc->size)}}</span></td>
    </tr>
    <?php $no++;?>
@empty
    <tr class="rowdoc">
        <td id="td-attachment" class="d-flex align-items-center">
        <span>
            -
        </span>
        </td>
        <td id="td-attachment">-</td>
        <td id="td-attachment">-</td>
    </tr>
@endforelse