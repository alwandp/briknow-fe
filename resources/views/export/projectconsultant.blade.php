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
        <td colspan="8" style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef;width=120px;">
            Data Consultant Beserta Project Per Tanggal {{now()->format('d F Y')}}
        </td>
    </tr>
    <tr>
        <td colspan="9"></td>
    </tr>
    <thead>
        <tr>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Vendor</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Bidang</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:5px;font-size:10px;border:1px solid black;">Website</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Telepon</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Email</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Facebook</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:10px;font-size:10px;border:1px solid black;">Instagram</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:5px;font-size:10px;border:1px solid black;">Jumlah Project</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;font-size:10px;border:1px solid black;">Project</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
            <tr>
                <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->nama_consultant}}</td>
                <td style='font-size:8px;border:1px solid black;text-align:center;'>{{$item->bidang??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->website??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;text-align:center;'>{{phone($item->telepon)??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->email??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->facebook??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->instagram??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;text-align:center;'>{{$item->jumlah_project??'-'}}</td>
                <td style='font-size:8px;border:1px solid black;text-align:left;'>{{$item->list_project??'-'}}</td>
            </tr>
        @empty
            <tr>
                <td style='border:1px solid black;text-align:center;'>-</td>
                <td style='border:1px solid black;text-align:left;'>-</td>
                <td style='border:1px solid black;text-align:center;'>-</td>
                <td style='border:1px solid black;text-align:left;'>-</td>
                <td style='border:1px solid black;text-align:left;'>-</td>
                <td style='border:1px solid black;text-align:left;'>-</td>
                <td style='border:1px solid black;text-align:left;'>-</td>
                <td style='border:1px solid black;text-align:center;'>-</td>
                <td style='border:1px solid black;text-align:left;'>-</td>
            </tr>
        @endforelse
    </tbody>
</table>