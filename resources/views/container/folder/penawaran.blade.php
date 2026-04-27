<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penawaran Barang</title>
</head>
<body>
    <div class="content">
        @foreach($transaksi as $data)
            <div class="head">
                <div class="title mb-2" style="text-align: center;">                                
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
                                <div class="center text-center" style="text-align:center">
                                    <h1 style="font-size: 40px; margin: 0;">CV. DATA PRINT</h1>
                                    <h4 style=""><strong>Jl. Cemara Raya No.4 Ruko Harapan Jaya</strong></h4>
                                    <h4 style=""><strong>dataprint2012@yahoo.co.id</strong></h4>
                                    <h4 style="">Advance : Computer, Printer, Monitor, Accessories, Sparepart, Sales & Services</h4>
                                </div>
                            </td>
                        </tr>
                    </table>                
                </div>
                <div class="line"></div>
                <div class="row">
                    <table class="desc">
                        <tr>
                            <td>
                                @if($data->Toko === null)
                                    <h3><strong>{{$data->customer}}</strong></h3>
                                @else                                                                    
                                    <h3><strong>{{$data->pic}}</strong></h3>
                                    <h3><strong>{{$data->Toko}}</strong></h3>
                                @endif 
                            </td>
                            <td style="text-align: right;">
                                <p>Bekasi, {{\Carbon\Carbon::parse($data->tanggalnow)->format('d M Y')}}</p>                                
                            </td>
                        </tr>
                    </table>
                </div>                        
            </div>
            <div class="middle">
                <div class="kow" style="text-align: center; background-color: gray;">
                    <p>PENAWARAN BARANG</p>
                </div>
                <div class="des" style="font-size: 12px">
                    <p>Terimakasih atas kepercayaan ibu/bapak kepada dataprint untuk mengajukan harga penawaran barang</p>
                    <p>dengan spesifikasi sbb:</p>
                </div>
            </div>
            <div class="body">
                <div class="table">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Nama Toko</th>
                                <th>spesifikasi</th>
                                <th>Qty</th>
                                <th>Jumlah</th>
                            </tr>
                        <thead>
                        <tbody>
                            @foreach($penawaran->groupBy('id_barang') as $barangName => $groupedBarang)
                                @foreach($groupedBarang as $index => $barang)                                                           
                                    <tr>      
                                        @if($index == 0)
                                            <td rowspan="{{count($groupedBarang)}}">{{$index+1}} </td>                                        
                                            <td rowspan="{{count($groupedBarang)}}">{{$barang->nama_barang}} {{$barang->SN}}</td>
                                            @if($data->nama_toko == null)
                                                <td rowspan="{{count($groupedBarang)}}">{{$data->id_customer}} </td>                                                                                            
                                            @else
                                                <td rowspan="{{count($groupedBarang)}}">{{$data->kode_toko}} {{$data->nama_toko}} </td>                                            
                                            @endif
                                        @endif
                                        <td>                                            
                                            {{$barang->nama_keluhan}}                                                                                            
                                        </td>
                                        <td>1</td>                                        
                                        <td>Rp. {{ number_format($barang->biaya_keluhan, '0',',','.')}}</td>                                
                                    </tr> 
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Jasa Services</td>
                                <td></td>
                                <td>Rp. {{ number_format($data->jasa_service, '0',',','.')}}</td>                                                                
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Sub Total</td>
                                <td></td>
                                <td>Rp. {{ number_format($data->totalbiaya, '0',',','.')}}</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>PPN 12%</td>
                                <td></td>
                                <td>Rp. {{ number_format($data->ppn, '0',',','.')}}</td>                                
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td></td>
                                <td>Rp. {{ number_format($data->totalbiaya + $data->ppn, '0',',','.')}}</td>                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</body>
<style>    
    .content{
        max-width: 760px;
        padding: 20px;
        .title p{
            margin: 0;
        }
        .desc{
            width: 100%;
            
            ul{
                padding: 0;
                margin: 0;
                list-style-type:none ;
            }
        }       
    }
    .line{
        border: 1px solid gray;
    } 
    h4{
        margin: 0;
    }
    .title{
        text-align: center;
    }
    .styled-table{
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }
    .nested-table tr {
        border: 1px solid #dddddd; /* Light gray borders */
        padding: 12px 15px; /* Add padding inside cells */
    } 

    /* Table Borders */
    .styled-table th, .styled-table td {
        border: 1px solid #dddddd; /* Light gray borders */
        padding: 12px 15px; /* Add padding inside cells */
    }  
</style>
</html>