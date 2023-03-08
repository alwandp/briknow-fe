<style>
    th{
        font-weight:bold;
    }
    .table{
        border-collapse: separate;
        border-spacing: 0;
        text-align:center;
    }
    .sub-content{
        border:1px solid black;
    }
    td{
        word-wrap: break-word;
    }
</style>
<table style="max-width:400px;width:100%;table-layout: fixed;border-collapse: collapse;">
    <tr style="height:5px;">
        <td style="width:400px;">
            <img src="{{public_path("assets/icon-32.png")}}" style="width:20px;margin-top:5px;" alt="">
            List Project Per Tahun
        </td>
    </tr>
</table>
<br>
<table class="sub-content table" style="font-size:10px;width:100%;table-layout: fixed;border-collapse: collapse;">
    <thead>
        <tr>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:10px;width:5px;">Tanggal</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Nama Project</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Direktorat</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Divisi</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Consultant</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Status</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Tanggal Mulai</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Tanggal Selesai</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Restriction</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Maker</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Checker</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Signer</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Maker_at</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Checker_at</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">Signer_at</th>
            <th class="sub-content" style="background-color:#cccdd0;font-weight:bold;width:20px;">pm</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td class='sub-content' style="width:5px;">{{\Carbon\carbon::create($item->tanggal_mulai)->format('d M Y')}}</td>
                <td class='sub-content'>{{$item->nama}}</td>
                <td class='sub-content'>{{$item->divisi->direktorat}}</td>
                <td class='sub-content'>{{$item->divisi->divisi}}</td>
                @php
                    $temp = "INTERNAL";
                    if($item->consultant !== []){
                        foreach ($item->consultant as $item2) {
                            if ($temp === "INTERNAL") {
                                $temp          = $item2->nama;
                            }else{
                                $temp          = $temp.", ".$item2->nama;
                            }
                        }
                    }
                    echo "<td class='sub-content'>$temp</td>";
                @endphp
                @php
                    if ($item->status_finish === 0) {
                        $temp          = 'on progress';
                    }else{
                        $temp          = 'Finish';
                    }
                    echo "<td class='sub-content'>$temp</td>";
                @endphp
                <td class='sub-content'>{{\Carbon\carbon::create($item->tanggal_mulai)->format('d F Y')}}</td>
                <td class='sub-content'>{{$item->status_finish === 0 ? '-' : \Carbon\carbon::create($item->tanggal_selesai)->format('d F Y')}}</td>
                @php
                    if ($item->is_restricted === 0) {
                        $temp          = 'RESTRICTION';
                    }else{
                        $temp          = 'NON RESTRICTION';
                    }
                    echo "<td class='sub-content'>$temp</td>";
                @endphp
                <td class='sub-content'>{{$item->user_maker}}</td>
                <td class='sub-content'>{{$item->user_checker}}</td>
                <td class='sub-content'>{{$item->user_signer}}</td>
                <td class='sub-content'>{{\Carbon\carbon::create($item->created_at)->format('d F Y')}}</td>
                <td class='sub-content'>{{\Carbon\carbon::create($item->checker_at)->format('d F Y')}}</td>
                <td class='sub-content'>{{\Carbon\carbon::create($item->signer_at)->format('d F Y')}}</td>
                <td class='sub-content'>{{$item->project_managers->nama}}</td>
            </tr>
        @endforeach
    </tbody>
</table>