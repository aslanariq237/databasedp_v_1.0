<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
</head>
<body>
    <div class="kwitansi">
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
            @foreach($transaksi as $data)
                <div class="body">
                    <div class="tbody">
                        <div class="dalam">
                            <h3>KWITANSI</h3>
                            <div class="lines"></div>
                            <h4>No : {{$data->no_invoice}}</h4>
                        </div>
                    </div>
                    <div class="bbody" style="margin-top: 10px;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="font-size: 22px">Sudah Terima Dari</td>
                                <td>:</td>
                                <td style="font-size: 22px; border: solid black; border-width: 0 0 1px 0;">
                                    @if($data->nama_toko === null)
                                        {{$data->customer}}
                                    @else
                                        {{$data->Toko}} 
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 22px">Banyaknya Uang  </td>
                                <td>:</td>
                                <td style="font-size: 22px; border: solid black; border-width: 0 0 1px 0;">{{$data->total_biaya}}                                    
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 22px">Uang Pembayaran </td>
                                <td>:</td>                            
                                    <td style="border: solid black; border-width: 0 0 1px 0; font-size: 22px;">
                                        @foreach($nama_barang as $nabar)
                                            {{$nabar->nama_barang}}, 
                                        @endforeach
                                    </td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td>  </td>
                                <td style="border: solid black; border-width: 0 0 1px 0;"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="border: solid black; border-width: 0 0 1px 0; font-size: 22px;">Tanda Terima Barang</td>
                            </tr>
                        </table>
                    </div>
                    <div class="fbody">
                        <table style="width: 100%;">
                            <tr>
                                <td>
                                    <table style="width: 100%; border:solid black; border-width: 1px 0 1px 0; padding: 5px;">
                                        <tr>
                                            <td style="font-size: 22px">Jumlah</td>
                                            <td style="border: solid black; border-width: 1px 0 1px 0; font-size: 22px">Rp. {{$data->totalbiaya + $data->ppn}}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="float: right; text-align: center; font-size: 22px">
                                    <p>Bekasi, {{\Carbon\Carbon::parse($data->tanggalnow)->format('d M Y')}}</p>                                
                                    <p style="font-weight: 600; margin-top: 20px;">Cv. Data Print</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
<style>
    @page{
        size: a4 landscape;
    }
    body{
        margin-top: 60px;
    }
    h1{
        margin: 0;
    }
    table{
        ul{
            list-style-type: none;
        }        
    }
    h4{
        margin: 0;
    }
    .kwitansi{        
        padding: 20px;
    }
    .line{
        border: 1px solid black;
    }
    .title{
        text-align: center;
    }
    .center{
        text-align: center;
        margin-left: 140px;     
        margin-bottom: 20px
    }
    .tbody{
        text-align: center;
        h3{
            margin: 0;
        }
        p{
            margin: 0;
        }
        .lines{
            border: 1px solid black;
        }
    }
</style>
</html>