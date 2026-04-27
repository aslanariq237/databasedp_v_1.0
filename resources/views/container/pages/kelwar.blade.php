<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/pages/addKeluhan.css">
    <title>Finance View</title>
</head>
<body>
    <div class="container mt-5 mb-5">
        <a href="{{ route('DataKel')}}" class="text-black"><strong>Back</strong></a>
        <div class="box">
            <div class="form">
                <h3>Tambah Tanda Terima</h3>                  
                <table class="styled-table">
                    <thead class="bg-danger">
                        <tr>
                            <th>ID</th> 
                            <th>Nama Usaha</th>                               
                            <th>Nama Barang</th>
                            <th>SN</th>                                 
                            <th>Keluhan</th>  
                            <th>Harga</th>                                                                                        
                        </tr>
                    </thead>                                                           
                    <tbody> 
                        @foreach($tandater as $data)
                            <tr>    
                                <td>{{$data->id_tandater}}</td>                                
                                <td>
                                    @foreach($customer as $cust)
                                        {{$cust->nama_toko}}
                                    @endforeach
                                </td>  
                                <td>{{$data->nama_barang}}</td>
                                <td>{{$data->SN}}</td>   
                                <td> {{$data->nama_keluhan}} </td>                                                             
                                <td> Rp. {{number_format($data->biaya_keluhan, 0, ',', '.')}} </td>                                
                            </tr>
                        @endforeach
                    </tbody>                    
                </table>              
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<style>
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

/* Table Borders */
.styled-table th, .styled-table td {
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