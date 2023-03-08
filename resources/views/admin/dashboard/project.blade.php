<div class="table-responsive-sm">
    <table class="table table-condensed table-borderless" style="
    background-color: #ffe;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;">
        <thead style="border-bottom: 4px solid #e5e5e5; font-size: 0.7em;
        padding: 1px !important;
        height: 15px;">
            <tr>
                <th scope="col" style="border-top-left-radius: 20px;">#</th>
                <th scope="col">Judul Dokumen</th>
                <th scope="col">ID User Penerbit</th>
                <th scope="col">Uker Penerbit</th>
                <th scope="col">Waktu Upload</th>
                <th scope="col" style="border-top-right-radius: 20px;">Jumlah User</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                $first = reset($dataProject);
                $second = $dataProject[1];
                $last = end($dataProject);
            @endphp
            @forelse($dataProject as $item)
                @php
                    $old = strtotime($item->created_at);
                    // $waktu = date('Y-m-d H:i:s', $old);
                    $tgl = date('Y/m/d', $old);
                    $waktu = date('h:i A', $old);
                @endphp
                @if($item->search_log_count > 0)
                    @if($item == $first)
                        <tr class="py-2"
                            style="border-top: 3px solid #e5e5e5; box-shadow: 0 0 0px 2px #e5e5e5; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <th scope="row">{{ $i++ }}</th>
                            <td class="py-2">
                                <img src="{{ asset_app('assets/img/boxdefault.svg') }}" alt=""
                                    class="img-table">
                                <span>{{ $item->nama }}</span>
                            </td>
                            <td>00213344111</td>
                            <td>{{ $item->divisi->direktorat }}</td>
                            <td>{{ $tgl }}<br>Pukul {{ $waktu }}</td>
                            <td>
                                <i style="font-size: 0.7em;" class="fas fa-user-friends fa-sm"></i>
                                <span>{{ $item->search_log_count }}</span>
                            </td>
                        </tr>
                        @continue
                    @elseif($item == $second)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td class="py-2">
                                <img src="{{ asset_app('assets/img/boxdefault.svg') }}" alt=""
                                    class="img-table">
                                <span>{{ $item->nama }}</span>
                            </td>
                            <td>00213344111</td>
                            <td>{{ $item->divisi->direktorat }}</td>
                            <td>{{ $tgl }}<br>Pukul {{ $waktu }}</td>
                            <td>
                                <i style="font-size: 0.7em;" class="fas fa-user-friends fa-sm"></i>
                                <span>{{ $item->search_log_count }}</span>
                            </td>
                        </tr>
                    @else
                        <tr style="border-top: 2px solid #e5e5e5;">
                            <th scope="row">{{ $i++ }}</th>
                            <td class="py-2">
                                <img src="{{ asset_app('assets/img/boxdefault.svg') }}" alt=""
                                    class="img-table">
                                <span>{{ $item->nama }}</span>
                            </td>
                            <td>00213344111</td>
                            <td>{{ $item->divisi->direktorat }}</td>
                            <td>{{ $tgl }}<br>Pukul {{ $waktu }}</td>
                            <td>
                                <i style="font-size: 0.7em;" class="fas fa-user-friends fa-sm"></i>
                                <span>{{ $item->search_log_count }}</span>
                            </td>
                        </tr>
                    @endif
                @endif
            @empty
                EMPTY
            @endforelse
        </tbody>
    </table>
</div>
