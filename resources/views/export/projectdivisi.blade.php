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
    <tr>
        <td style="background-color:#b9c3ef;border:1px solid #b9c3ef;">
            <img src="{{public_path("assets/img/logo-bri.png")}}" style="width:120px;" alt="">
        </td>
        <td colspan="4" style="background-color:#b9c3ef;font-size:14px;font-weight:bold;text-align:center;border:1px solid #b9c3ef;width=120px;">
            Data Divisi Beserta Project Per Tanggal {{now()->format('d F Y')}}
        </td>
    </tr>
    <tr>
        <td colspan="5"></td>
    </tr>
    <thead>
        <tr>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Direktorat</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Divisi</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:5px;font-size:10px;border:1px solid black;">Shortname</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Jumlah Project</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">List Project</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
            <tr>
                <td style='font-size:8px;border:1px solid black;'>{{$item->nama_direktorat}}</td>
                <td style='font-size:8px;border:1px solid black;'>{{$item->nama_divisi??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;'>{{$item->shortname??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;'>{{$item->jumlah_project??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;'>{{$item->list_project??'-'}}</td>
            </tr>
        @empty
            <tr>
                <td style='border:1px solid black;'>-</td>
                <td style='border:1px solid black;'>-</td>
                <td style='border:1px solid black;'>-</td>
                <td style='border:1px solid black;'>-</td>
                <td style='border:1px solid black;'>-</td>
            </tr>
        @endforelse
    </tbody>
</table>