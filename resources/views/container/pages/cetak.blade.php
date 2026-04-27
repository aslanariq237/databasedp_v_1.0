<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/pages/addKeluhan.css">
    <title>Tambah Tanda Terima</title>
</head>
<body>
    <div class="container mt-5 mb-5">
        <a href="{{ route('DataFin')}}" class="text-black"><strong>Back</strong></a>
        <div class="box">
            <div class="form">
                <form action="{{ route('post.barang')}}" method="post">   
                    @csrf             
                    <h3>Tambah Tanda Terima</h3>            
                    @foreach($tandater as $index => $data)                                        
                        <p>{{$data->created_at}}</p>
                        <p>{{$data->customer}} </p>
                        <p>Pilih barang di bawah ini yang ingin di cetak</p>                        
                        <div class="table-responsive shadow p-3 mb-2 bg-white rounded">
                            <table class="table">
                            <thead class="bg-danger">
                                <tr>
                                    <th>ID</th>                                
                                    <th>Nama Barang</th>
                                    <th>Serial Number</th>                                
                                    <th>Status</th>  
                                    <th>Harga</th>                                                            
                                    <th>Details</th>                                    
                                </tr>
                            </thead>                                                           
                            <tbody>                                 
                                    @foreach($costbarang as $index => $barang)                                                       
                                        <tr>
                                            <td>{{$index+1}}</td>                                       
                                            <td>{{$barang->nama_barang}}</td>                                  
                                            <td>{{$barang->SN}}</td>                                                                                                            
                                            <td>{{$barang->status == null ? 'Pending' : $barang->status}}</td>                                    
                                            <td>                                        
                                                Rp. {{number_format($barang->total, 0, ',', '.')}}                                          
                                            </td>                                                                                                                                                                  
                                            <td>    
                                                <input type="text" name="id_final" value="{{$data->id_final}}" hidden>
                                                <input type="text" name="id_tandater" value="{{$data->id_tandater}}" hidden>                                                                                             
                                                <input type="text" name="id_customer[]" value="{{$barang->customerid}}" hidden>
                                                <input type="checkbox" name="id_barang[]" value="{{$barang->id_barang}}">                                 
                                            </td>
                                        </tr>                            
                                    @endforeach                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td class="border-0 border-bottom">Jasa Service</td>
                                    <td class="border-0 border-bottom"></td>
                                    <td class="border-0 border-bottom"></td>                                
                                    <td>
                                        <input type="text" value="{{ old('jasa_service', number_format($data->jasa_service, 0, ',', '.'))}}" name="jasa_service">
                                    </td>
                                    <td></td>
                                </tr>                                
                                </tr>
                            </tfoot>
                        </table>
                        </div>
                        <p class="text-black-20 mt-2">Press The Cetak Button to Download The PDF or Word
                        <div class="d-flex justify-content-between mt-3">                            
                            <div class="p"></div>
                            @if($data->has_created != 1)
                                <div class="button">
                                    <button class="btn btn-success" type="submit">Cetak</button>
                                </div>
                            @else
                                <div class="button">
                                    <button class="btn btn-success" disabled type="submit">Cetak</button>
                                </div>
                            @endif
                        </div>
                    @endforeach                  
                </form>  
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
    margin: 0;    
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