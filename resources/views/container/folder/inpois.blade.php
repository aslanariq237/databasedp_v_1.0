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
                <div class="body">
                    <div class="top">
                        <h3 style="margin: 0;"><strong>INVOICE PEMBAYARAN</strong></h3>
                    </div>
                    <table style="width : 100%; font-size: 15px">
                        <tr>
                            <td style="border: white solid; text-align: left;">
                                <h3 style="margin: 0;">Nama Customer: </h3>                                
                                @if($tr->Toko === null)
                                    <h3><strong>{{$tr->customer}}</strong></h3>
                                @else                        
                                    <h3><strong>{{$tr->Toko}}</strong></h3>                                    
                                    <h3><strong>{{$tr->pic}}</strong></h3>                                    
                                @endif                                
                            </td>
                            <td style="border: white solid; text-align:right;">
                                <h3>order date: {{\Carbon\Carbon::parse($tr->tanggalnow)->format('Y-m-d')}} </h3>
                                <h3><strong>rek BCA : 0663070468</strong></h3>
                                <h3><strong>a/n: CV.Data Print</strong></h3>
                                <h3 style="font-size: 20px;"><strong>No.Nota : {{$tr->no_invoice}}</strong></h3>
                            </td>
                        </tr>
                    </table>
                </div>
                <table class="styled-table" style="font-size: 16px">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>                            
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>    
                        @php 
                            $count = 1;
                        @endphp                   
                        @foreach($namber->groupBy('id_barang') as $barang => $groupedNambar)
                            @foreach($groupedNambar as $index => $nambar)                                                                
                                <tr style="font-size: 17px">                                
                                    @if($index == 0)        
                                        <td rowspan="{{ count($groupedNambar) }}" style="">
                                            <p style="position: absolute; margin: 0;">{{$count++}}</p>    
                                        </td>                                                                                                            
                                        <td rowspan="{{ count($groupedNambar) }}">               
                                        {{$nambar->nama_barang}}, sn: {{$nambar->SN}} (
                                            @if($tr->nama_toko === null)
                                                {{$tr->id_customer}}
                                            @else
                                                {{$tr->nama_toko}} - {{$tr->kode_toko}}
                                            @endif
                                          )                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                                            <ul>
                                                @foreach($groupedNambar as $keluhan)                                                
                                                    <li>
                                                        {{$keluhan->nama_keluhan}}                                                                                                            
                                                    </li>
                                                @endforeach
                                            </ul>                                                                                                                                                
                                        </td>    
                                        <td rowspan="{{ count($groupedNambar)}}">                                            
                                            <ul style="margin: 0; padding: 0;">
                                            @foreach($groupedNambar as $keluhan)                                                
                                                <li>
                                                Rp. {{ number_format($keluhan->biaya_keluhan, '0',',','.')}}                                                
                                                </li>
                                            @endforeach
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
                                Jasa Service                                
                            </td>
                            <td>                                
                                Rp. {{number_format($tr->jasa_service, 0, ',', '.')}}
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                SubTotal                                
                            </td>
                            <td>                                
                                Rp. {{number_format($tr->totalbiaya, 0, ',', '.')}}
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                Sub DPP                                
                            </td>
                            <td>                                
                                Rp. {{number_format($tr->totalbiaya * 11/12 , 0, ',', '.')}}
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                PPN                                
                            </td>
                            <td>                                
                                Rp. {{number_format($tr->ppn, 0, ',', '.')}}                                    
                            </td>
                        </tr>
                        <tr style=" border: 1px solid black">
                            <td style="border: 1px solid black"></td>
                            <td style="border: 1px solid black">
                                <ul>
                                    <li>Total</li>
                                </ul>
                            </td>
                            <td style="border: 1px solid black">                                
                                Rp. {{number_format($tr->totalbiaya + $tr->ppn, 0, ',', '.')}}                                    
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td style="border: white solid; text-align: left;">
                            <h3>Hormat Kami</h3>
                            <div class="lines" style="margin-top: 10px;"></div>
                        </td>
                        <td style="border: white solid; text-align:right;">
                            <h3>Diterima Oleh</h3>
                            <div class="lines" style="float:right; margin-top: 10px"></div>
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
        width: 100%;        
        font-family: Arial, sans-serif; /* Use a clean font */
        font-size: 16px; /* Text size */
        margin-top: 20px; /* Add spacing from the heading */
        text-align: left; /* Align text to the left */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
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
        font-size: 20px;     
    }
    h3{
        margin: 0;
    }
    ul{
        margin: 0;
        font-size: 20px;        
        /* li{
            font-size: 28px;
        } */
    }    
    .container{      
        padding: 20px;    
        height: 100vh;          
    }
    .title{
        text-align: center;
    }
    .center{
        text-align: center;
        margin-left: 140px;     
        margin-bottom: 20px
    }
    .line{
        border: 1px solid gray;
    }
    h4{
        margin: 0;        
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