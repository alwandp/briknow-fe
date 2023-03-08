<style>
    th{
        background-color:#cccdd0;
        font-weight:bold;
    }
    td{
        word-wrap: break-word;
    }
</style>
<table style="width:100%;table-layout: fixed;border-collapse: collapse;">
    <tr style="height:5px;">
        <td colspan="14" style="background-color:#b9c3ef;width:80px;text-align:center;font-size:18px;font-weight: bold;">
            <img src="{{public_path("assets/icon-32.png")}}" style="width:20px;" alt="">
            List Project Per Tahun
        </td>
    </tr>
    <tr>
        <td colspan="14"></td>
    </tr>
    <thead>
        <tr>
            <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Tanggal</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Nama Project</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Direktorat</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Divisi</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Consultant</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Status</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Tanggal Mulai</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Tanggal Selesai</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Maker</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Checker</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Signer</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Maker_at</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Checker_at</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Signer_at</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
            <tr>
                <td style="font-size:10px;border:1px solid black;">{{\Carbon\carbon::create($item->tanggal_mulai)->format('d M Y')}}</td>
                <td style="font-size:10px;border:1px solid black;">{{$item->nama}}</td>
                <td style="font-size:10px;border:1px solid black;">{{$item->divisi->direktorat}}</td>
                <td style="font-size:10px;border:1px solid black;">{{$item->divisi->divisi}}</td>
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
                    echo "<td style='font-size:10px;border:1px solid black;'>$temp</td>";
                @endphp
                @php
                    if ($item->status_finish === 0) {
                        $temp          = 'on progress';
                    }else{
                        $temp          = 'Finish';
                    }
                    echo "<td style='font-size:10px;border:1px solid black;'>$temp</td>";
                @endphp
                <td style="font-size:10px;border:1px solid black;">{{\Carbon\carbon::create($item->tanggal_mulai)->format('d F Y')}}</td>
                <td class='sub-content' style="font-size:10px;border:1px solid black;">{{$item->status_finish === 0 ? '-' : \Carbon\carbon::create($item->tanggal_selesai)->format('d F Y')}}</td>
                <td style="font-size:10px;border:1px solid black;">{{$item->user_maker}}</td>
                <td style="font-size:10px;border:1px solid black;">{{$item->user_checker}}</td>
                <td style="font-size:10px;border:1px solid black;">{{$item->user_signer}}</td>
                <td style="font-size:10px;border:1px solid black;">{{\Carbon\carbon::create($item->created_at)->format('d F Y')}}</td>
                <td style="font-size:10px;border:1px solid black;">{{\Carbon\carbon::create($item->checker_at)->format('d F Y')}}</td>
                <td style="font-size:10px;border:1px solid black;">{{\Carbon\carbon::create($item->signer_at)->format('d F Y')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>