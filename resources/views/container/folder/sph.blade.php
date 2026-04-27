<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPH</title>
</head>
<body>
    <div class="sph">
        <div class="home">
        <div class="title mb-2">                                
                <table style="widht: 100%; margin: 0">
                    <tr>
                        <td style="border: none; margin: 0">
                            <div style="border: 2px solid black; height: 100px;">
                                <div style="border: 2px solid black; text-align:center; height: 92px; margin: 2px">
                                    <h1 style="font-size: 75px; margin-top: 5px">DP</h1>
                                </div>
                            </div>
                        </td>
                        <td style="border: none; margin: 0;">
                            <div class="center text-center">
                                <h1 style="font-size: 45px; margin: 0;">CV. DATA PRINT</h1>
                                <h4 style=""><strong>Jl. Cemara Raya No.4 Ruko Harapan Jaya</strong></h4>
                                <h4 style=""><strong>dataprint2012@yahoo.co.id</strong></h4>
                                <h4 style="">Advance : Computer, Printer, Monitor, Accessories, Sparepart, Sales & Services</h4>
                            </div>
                        </td>
                    </tr>
                </table>             
            </div>
            <div class="line"></div>
            <div class="titles">
                <h3><strong>SURAT JALAN</strong></h3>
            </div>
            <div class="serv">
                <table style="width: 100%;">
                    <tr>
                        @foreach($transaksi as $data)
                            <td>Service {{$data->id}}</td>
                        @endforeach
                        <td></td>
                    </tr>
                    <tr>
                        <td style="float:left;">
                            <table class="ttds">
                                <tr>
                                    <td>Kepada</td>
                                    <td>:</td>
                                    <td>CV.DATA PRINT</td>
                                </tr>
                                <tr>
                                    <td>Dari</td>
                                    <td>:</td>
                                    <td>GA</td>
                                </tr>
                            </table>
                        </td>
                        <td style="float: right;">
                            <table>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>:</td>
                                    @foreach($transaksi as $data)
                                        <td>{{\Carbon\Carbon::parse($data->tanggalnow)->format('d M Y')}}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Nomor</td>
                                    <td>:</td>
                                    @foreach($transaksi as $data)
                                        <td>{{$data->no_invoice}} </td>
                                    @endforeach
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Serial Number</th>
                            <th>Jumlah KG/ Roll/ pcs</th>
                            <th>Status</th>
                            <th>Customer</th>
                        </tr>
                    <thead>
                    <tbody>
                        @foreach($nama_barang as $data)
                            <tr>
                                <td>1</td>
                                <td style="font-size: 20px; text-align: center;"> {{$data->nama_barang}} </td>
                                <td style="text-align: center; font-size: 20px">{{$data->SN}}</td>
                                <td style="text-align: center; font-size: 20px;">1 units</td>
                                <td style="font-size: 20px;">
                                    {{$data->status}}
                                </td>
                                <td style="font-size: 20px;">
                                    @foreach($transaksi as $tr)
                                        {{$tr->nama_toko}}
                                    @endforeach
                                </td>
                            </tr>                            
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="ttd">
                <table class="ttds">
                    <tr>
                        <td>
                            <p>Penerima</p>
                            <br>
                            <p style="margin: 0;">(.............................................)</p>
                            <p style="margin: 0;">Nama, T.Tangan, Stempel</p>
                        </td>
                        <td>
                            <p>Hormat Kami</p>
                            <br>
                            <p style="margin: 0;">(.............................................)</p>
                            <p style="margin: 0;">Nama, T.Tangan, Stempel</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
<style>
    @page{
        size: a4 landscape;
    }
    .home{
        font-size: 22px;
        padding: 20px;               
    }
    .title{
        text-align: center;
    }
    .styled-table{
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }


    /* Table Borders */
    .styled-table th, .styled-table td {
        border: 1px solid black; /* Light gray borders */
        padding: 12px 15px; /* Add padding inside cells */
    }  
    .ttds{
        width: 100%;
        text-align: center; 
        
        th{
            border: 1px solid transparent;
        }
        td{
            border: 1px solid transparent;
        }
    }
    h3{
        margin: 0;
    }
    .title{
        text-align: center;
    }
    .titles{
        text-align: center;
    }
    .center{
        text-align: center;
        margin-left: 20px;             
    }
    .line{
        border: 1px solid gray;
    }
    h4{
        margin: 0;        
    }
</style>
</html>