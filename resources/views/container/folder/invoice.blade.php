<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        
    </style>
</head>
<body>
    <div class="conti">
        <div class="box w-75">
            <div class="head">
                <div class="title text-center">
                    <h1 class="title" style="">CV. DATA PRINT</h1>
                    <div class="detail-title">
                        <p class="customer-bold">Jln. Cemara Raya No.4 Ruko Harapan Jaya Telp: 0889514487</p>
                        <p class="customer-bold">Email : dataprint2012@yahoo.co.id</p>
                    </div>
                    <div class="cat">
                        <p>Advance : Computer, Printer, Monitor, Accesories, Sparepart, Sales & Services</p>
                    </div>                    
                </div>
            </div>
            <div class="line border-bottom border-dark"></div>
            @foreach($transaksi as $data)
            <div class="body">
                <div class="title body">
                    <h5 class="customer-bold">INVOICE PEMBAYARAN</h5>
                </div>                
                    <div class="desc">
                        <div class="left">
                            <p>Nama Customer : </p>
                            <p class="customer-bold">{{ $data->nama_toko}}</p>
                            <p class="customer-bold">Ibu Paras</p>
                        </div>
                        <div class="right">
                            <p>Order Date : {{ $data->created_at}}</p>
                            <p class="customer-bold">Rek BCA : 0663070468</p>
                            <p class="customer-bold">a/n : CV. DATA PRINT</p>
                            <p class="customer-tiny">No. Nota : {{$data->no_invoice}}</p>
                        </div>
                    </div>
                <div class="table">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>                            
                                @foreach($nama_barang as $index => $datas)
                                <tr class="none-border">
                                    <td class="first-li">
                                        <ul>
                                            <li>{{$index+1}}</li>
                                        </ul>
                                    </td>
                                    <td class="none-border">
                                        <ul>
                                            <li>SparePart</li>
                                            <li>Jasa Service</li>                                            
                                        </ul>
                                    </td>
                                    <td class="none-border">
                                        <ul>
                                            <li>
                                            Rp. {{number_format($datas->cost, 0, ',', '.')}}
                                            </li>                     
                                            <li>
                                            Rp. {{number_format($datas->jasa_service, 0, ',', '.')}}
                                            </li>                      
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach                        
                        </tbody>
                        <tfoot>                            
                               <td></td>
                               <td>
                                <ul>
                                    <li>PPN 11%</li>
                                </ul>
                               </td>
                               <td>
                                <ul>
                                    <li>Rp. {{number_format($data->ppn, 0, ',', '.')}}</li>
                                </ul>
                               </td>                                                      
                            <tr>
                                <td></td>
                                <td>
                                    <ul>
                                        <li>
                                            Total
                                        </li>
                                    </ul>
                                </td>                                
                                <td>
                                    <ul>
                                        <li> 
                                        Rp. {{number_format($data->totalbiaya + $data->ppn, 0, ',', '.')}}                                    
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tfoot>
                    </table>  
                    <h4 class="text-black-50 text-center">Dua Ratus Tiga Puluh Sembilan Tujuh Ratus Enam Puluh </h4>                  
                </div>
                <div class="ttd">
                    <div class="left">
                        <p>Hormat Kami</p>
                        <div class="lines mt-5 border-bottom border-dark"></div>
                    </div>
                    <div class="right">
                        <p>Diterima Oleh : </p>
                        <div class="line mt-5 border-bottom border-dark"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>]
<style>
    .none-border{
        border: none;
        border: 2px left solid    
    }
    /* .first-li{
        display: flex;
        justify-content: center;        
    } */
    .body{
        display: flex;
        justify-content: space-between;
        flex-flow: column;
        .title{
            text-align: center;
        }
        .desc{
            display: flex;
            justify-content: space-between;
        }
    }
    .head{
        display: flex;
        justify-content: center;        
    }
    table{
        ul{
            display:flex;
            flex-flow: column;                        
            padding: 15px;                      
            list-style-type:none ;
        }
    }
    .conti{
        margin-top: 15px;
        margin-bottom : 15px;
        display : flex;
        justify-content : center;
    }

    .num1{        
        align-items: start;        
    }
    .ttd{
        display: flex;
        justify-content: space-between;        
    }    
    p{
        margin: 0;
    }
    .customer-bold{
        font-weight: bold;
    }
    .customer-tiny{
        font-weight : 500;
        font-size: 15px;
    }
    .styled-table {
        width: 100%; /* Full width */
        border-collapse: collapse; /* Remove gaps between cells */    
        font-family: Arial, sans-serif; /* Use a clean font */
        font-size: 16px; /* Text size */
        margin-top: 20px; /* Add spacing from the heading */
        text-align: left; /* Align text to the left */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    }

    /* Header Styling */
    .styled-table thead {
        background-color: #de4b4b; /* Green header background */
        color: white; /* White text */
        font-weight: bold; /* Make text bold */
    }
    td{
        border: 1px solid black;
    }

    /* Table Borders */
    .styled-table th {
        border: 1px solid #dddddd; /* Light gray borders */
        padding: 12px 15px; /* Add padding inside cells */
    }

    /* Row Hover Effect */
    .styled-table tbody tr:hover {
        background-color: #f1f1f1; /* Light gray background when hovering */
    }

    /* Zebra Stripe Rows */
    .styled-table tbody tr:nth-child(even) {
        background-color: #f9f9f9; /* Light gray for even rows */
    }

    /* Heading Styling */
    .table h3 {
        font-family: Arial, sans-serif;
        color: #333; /* Darker gray color */
        margin-bottom: 10px;
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        .styled-table {
            font-size: 14px; /* Reduce font size on smaller screens */
        }
    }
</style>
</html>