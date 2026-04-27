<div class="sidebar fs-5 py-2 px-3">  
    <div class="d-flex align-items-center text-center justify-content-center">
        <h3 class="m-0 mb-3">
            <a       
                class="text-decoration-none text-black fw-bold"              
                href="{{route('DataCust')}}"
            >
                DatabaseDP
            </a>
        </h3> 
    </div> 
    <ul>        
        <li class="text-xl text-secondary font-bold border-top pt-3">
            <p class="mb-1">Dashboard</p>
            <ul class="ms-5">
                <li class="text-secondary fs-5 fw-semibold">
                    <a href="{{ route('DataCust')}}">Home</a>
                </li>                                
            </ul>
        </li>
        <li class="text-xl text-secondary font-bold mt-2">
            <p class="mb-1">Master Data</p>
            <ul class="ms-5 fw-semibold">
                <li class="text-secondary fs-5">
                    <a href="">Teknisi</a>
                </li>
                <li class="text-secondary fs-5">
                    <a href="{{ route('DataMer')}}">Customer</a>
                </li>                
            </ul>
        </li>        
        <li class="text-xl text-secondary font-bold mt-2">
            <p class="mb-1">Operation</p>
            <ul class="ms-5 fw-semibold">
                <li class="text-secondary fs-5">
                    <a href="{{ route('DataKel')}}">Keluhan</a>
                </li>
                <li class="text-secondary fs-5">
                    <a href="{{ route('DataFin')}}">Admin</a>
                </li>
                <li class="text-secondary fs-5">
                    <a href="{{ route('cetak.list')}}">Cetak</a>
                </li>                                                                
            </ul>
        </li>                
        <li class="text-xl text-secondary font-bold mt-2">
            <p class="mb-1">Finance Tools</p>
            <ul class="ms-5 fw-semibold">
                <li class="text-secondary fs-5">
                    <a href="{{ route('listTak')}}">Transaction</a>
                </li>                     
            </ul>
        </li>   
        <li class="text-xl text-secondary font-bold mt-2">
            <p class="mb-1">Laporan Bulanan</p>
            <ul class="ms-5 fw-semibold">
                <li class="text-secondary fs-5">
                    <a href="{{ route('tampil.teknisi')}}">Teknisi</a>
                </li>
                <li class="text-secondary fs-5">
                    <a href="{{ route('ExportTransaksiData')}}">Transaksi</a>
                </li>                
            </ul>
        </li>        
    </ul>
</div>
<style>
    .sidebar{                        
        border-radius : 10px;    
        background-color: ;
    }
    ul{
        margin: 0;
        padding: 0;
    }
    li{
        list-style: none;
        margin-bottom: 10px;
    }
    a{
        text-decoration: none; 
        color: black;
        margin: 0;  
    }
</style>