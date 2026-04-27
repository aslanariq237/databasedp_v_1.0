<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Berita Acara Pelaksanaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    
</head>
<body>
    <div class="contain">
        @foreach($transaksi as $tr)
        <div class="bap">
            <div class="title d-flex justify-content-center">
                <table style="width: 100%; margin: 0">
                    <tr>
                        <td style="text-align: center;">
                            <h4>BERITA ACARA PELAKSANAAN</h4>
                            <h4>(BAP)</h4>
                            <h4>NO. BAP:  {{$tr->kode_toko}} - {{$tr->nama_toko}} {{\Carbon\Carbon::parse($tr->tanggalnow)->format('Y/m/d')}}</h4>
                            <h4>BAB 1</h4>
                            <h4>(PERBAIKAN @foreach($nambar as $data){{$data->nama_barang}}@endforeach)</h4>
                            <h4>DESKRIPSI</h4>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="desc">
                <div class="up" style="margin-top: 20px;">
                    <p>Yang Bertanda tangan dibawah ini : </p>
                    <p>Nama : Diknas Pradana</p>
                    <p>NIK  : -</p>
                    <p>Dept : admin</p>
                    Dengan ini kami informasikan pada tanggal {{\Carbon\Carbon::parse($tr->tanggalnow)->format('d M')}} dilakukan perbaikan                
                        @foreach($nambar as $data)
                            <label for="">{{$data->nama_barang}}</label>
                        @endforeach
                        oleh pihak DATA PRINT, adapun perbaikan part yang diganti yaitu sebagai berikut:
                    </p>
                    @foreach($namber as $index => $data)
                        <p>{{$index+1}}. {{$data->nama_keluhan}}</p>                        
                    @endforeach
                </div>                
                <div class="down" style="margin-top: 10px">
                    <p></p>
                    <p>Demikian BAP ini saya buat dengan sebenar-benarnya. Atas perhatian dan kerjasamanya,</p>
                    <p>Saya ucapkan terimakasih.</p>
                </div>
                <table style="width: 100%">
                    <tr>
                        <td style="text-align:left; width: 70%"></td>
                        <td style="">
                            <div class=""></div>
                            <div class="ttd" style="text-align: center">
                                <p>Bekasi, {{\Carbon\Carbon::parse($tr->tanggalnow)->format('Y M d')}}</p>
                                <p>Dibuat</p>
                                <p></p>
                                <p style="margin-top: 20px">(Diknas Pradana)</p>
                                <p>DATA PRINT</p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</body>
<style>
    @page{
        size: a4 landscape;
    }    

    p{
        margin: 0
    }
    h4{
        margin: 0
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>