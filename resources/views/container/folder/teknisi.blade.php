<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Tambah Tanda Terima</title>
</head>
<body>
    <div class="container mt-5 mb-5">        
        <div class="box">
            <div class="form" style="margin: 0;">
                <h3 stylee="margin: 0;">Pekerjaan Teknisi</h3>
                @foreach($nama as $data)
                    <h2 style="margin: 0;"> {{$data->nama_teknisi}}</h2>
                @endforeach                                                             
                    <div class="table-responsive">
                    <table class="styled-table">
                        <thead class="bg-danger">
                            <tr>
                                <th>No</th>
                                <th>ID</th> 
                                <th>Toko</th>
                                <th>customer</th>                               
                                <th>Nama Barang</th>
                                <th>Serial Number</th>                                
                                <th>Status</th>  
                                <th>Tanggal</th>                                                                                                                                                       
                            </tr>
                        </thead>                                                           
                        <tbody> 
                            <?php
                                $count = 1  ;
                            ?>
                            @foreach($teknisi as $toko_name => $tekn)                                                                    
                                <tr>                                                                                    
                                    <td>{{ $count++}} </td>
                                    <td>{{$tekn->id_tandater}} </td>
                                    <td>{{$tekn->customer}} </td>
                                    @if($tekn->nama_toko === null)
                                        <td>{{$tekn->id_customer}}</td>
                                    @else
                                        <td>{{$tekn->nama_toko}}</td>
                                    @endif                                    
                                    <td>{{$tekn->nama_barang}}</td>
                                    <td>{{$tekn->SN}} </td>
                                    <td>{{$tekn->status != 1 ? "Garansi" : "Tidak Garansi"}}</td>
                                    <td>{{\Carbon\Carbon::parse($tekn->created_at)->format('d M Y')}}</td>                                          
                                </tr>                                                                   
                            @endforeach                           
                        </tbody>
                    </table>
                    </div>                                   
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<style>
    @page {
        margin-top: 100px;
    }
    .styled-table {
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

/* Table Borders */
.styled-table th, .styled-table td {
    border: 1px solid #dddddd; /* Light gray borders */
    max-width: 80px;
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