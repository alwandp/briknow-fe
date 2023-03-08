<style>
    th{
        background-color:#cccdd0;
        font-weight:bold;
    }
     td{
        word-wrap: break-word;
    }
</style>
<table>
    <tr style="height:5px;">
        <td colspan="2" style="background-color:#b9c3ef;border:1px solid #b9c3ef;">
            <img src="{{public_path("assets/img/logo-bri.png")}}" style="width:120px;" alt="">
        </td>
        <td style="background-color:#b9c3ef;font-size:20px;font-weight:bold;text-align:center;border:1px solid #b9c3ef;width=120px;">
            TOP 10 Keyword Terpopuler {{now()->format('d F Y')}}
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>
    <thead>
        <tr>
            <th style="background-color:#cccdd0;font-weight:bold;width:10px;">Jumlah Pencarian</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:20px;">Keyword</th>
            <th style="background-color:#cccdd0;font-weight:bold;width:50px;">Project Terkait</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataEX as $item)
            <tr>
                <td>{{$item->keyword_log_count}}</td>
                <td>{{$item->nama}}</td>
                <td>{{$item->related}}</td>
            </tr>
        @endforeach
    </tbody>
</table>