<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Download</title>
</head>
<body>
    <div class="container">
        @foreach($transaksi as $tr)
            <div class="home">
                <div class="title">
                    <h1 style="margin: 0;">CV. DATA PRINT</h1>
                    <h4 style="margin: 0;"><strong>jl. Cemara Raya No.4 Ruko Harapan Jaya Telp: 88951487</strong></h4>
                    <h4 style="margin: 0;">Advance: Computer, Printer, Monitor, Accessories, Sparepart, Sales & Service</h4>            
                </div>
                <div class="line"></div>
                <div class="body">
                    <div class="top">
                        <h3 style="margin: 0;"><strong>INVOICE PEMBAYARAN</strong></h3>
                    </div>
                    <table style="width : 100%;">
                        <tr>
                            <td style="border: white solid; text-align: left;">
                                <h3 style="margin: 0;">Nama Customer: </h3>
                                <h3><strong>{{$tr->nama_toko}}</strong></h3>
                                <h3><strong>{{$tr->pic}}</strong></h3>
                            </td>
                            <td style="border: white solid; text-align:right;">
                                <h3>order date: {{\Carbon\Carbon::parse($tr->tanggalnow)->format('Y-m-d')}} </h3>
                                <h3><strong>rek BCA : 0661827132</strong></h3>
                                <h3><strong>a/n: CV.Data Print</strong></h3>
                                <h3 style="font-size: 15px;"><strong>No.Nota : {{$tr->no_invoice}}</strong></h3>
                            </td>
                        </tr>
                    </table>
                </div>
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>                            
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @foreach($namber->groupBy('nama_barang') as $barang => $groupedNambar)
                            @foreach($groupedNambar as $index => $nambar)                                                                
                                <tr>
                                    @php
                                        $count = 1;
                                    @endphp
                                    @if($index == 0)
                                        <td rowspan="{{ count($groupedNambar)}}">{{$count++}} </td>                                                                            
                                        <td rowspan="{{ count($groupedNambar)}}">                                            
                                            <ul>
                                                <li>
                                                {{$nambar->nama_barang}}                                                                                                                        
                                                </li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>Rp. {{ number_format($nambar->cost, '0',',','.')}}</li>
                                            </ul>
                                        </td>
                                    @endif                                                                             
                                    <!-- <td>Rp. {{ number_format($nambar->biaya_keluhan, '0',',','.')}}</td>                                                             -->
                                </tr>                            

                            @endforeach
                        @endforeach                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>
                                <ul>
                                    <li>Jasa Service</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>
                                        Rp. {{number_format($tr->jasa_service, 0, ',', '.')}}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ul>
                                    <li>SubTotal</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>
                                        Rp. {{number_format($tr->totalbiaya, 0, ',', '.')}}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ul>
                                    <li>PPN 11%</li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>
                                        Rp. {{number_format($tr->ppn, 0, ',', '.')}}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black"></td>
                            <td style="border: 1px solid black">
                                <ul>
                                    <li>Total</li>
                                </ul>
                            </td>
                            <td style="border: 1px solid black">
                                <ul>
                                    <li>
                                        Rp. {{number_format($tr->totalbiaya + $tr->ppn, 0, ',', '.')}}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td style="border: white solid; text-align: left;">
                            <h3>Hormat Kami</h3>
                            <div class="lines"></div>
                        </td>
                        <td style="border: white solid; text-align:right;">
                            <h3>Diterima Oleh</h3>
                            <div class="lines" style="float:right;"></div>
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>
</body>
<style>
    @page{
        size: a4 landscape;
    }
    .styled-table{        
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    }
    .home{
        margin-top: 60px;
    }
    ul{
        list-style-type: none;                
        margin-bottom : 10px
    }
    .ttd{
        display: flex;
        justify-content : space-between;
    }
    th{
        border : 1px solid black;
    }
    td{
        border : 1px solid black;
        border-width: 0 1px 0 1px;        
    }
    h3{
        margin: 0;
    }
    ul{
        margin: 0;
        li{
            font-size: 12px;
        }
    }
    td{
        border : 1px solid black;
        border-width: 0 1px 0 1px;        
    }
    .container{      
        padding: 20px;    
        height: 100vh;          
    }
    .title{
        text-align: center;
    }
    .line{
        border: 1px solid gray;
    }
    .lines{
        border: 1px solid gray;
        width: 80px;
        margin-top: 10px;
    }
    .top{
        text-align: center;
    }
    .desc{
        display: flex;
        justify-content: space-between;
    }
</style>
</html>