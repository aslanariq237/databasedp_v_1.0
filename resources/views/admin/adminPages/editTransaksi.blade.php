<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/pages/addKeluhan.css">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
        <div class="car">                       
            <div class="line"></div>
            @foreach($transaksi as $data)
                <div class="table">
                    <table class="styled-table">
                        <thead>
                            <tr>                        
                                <th>ID</th>
                                <th>Keluhan</th>                                                                                              
                                <th>Biaya Keluhan</th>
                                <th>Action</th>                        
                            </tr>
                        </thead>
                        <tbody>
                            <div class="d-flex justify-content-between">
                                @foreach($keluhan->splice(0,1) as $data)
                                    <p class="font-weight-bold">{{$data->nama_barang}} - {{$data->SN}}  </p>                                  
                                @endforeach             
                                <input type="text" name="id_transaksi" id="id_date" hidden>
                                <h3>Edit Transaksi</h3>
                            </div>
                            @foreach($keluhan as $index => $data)
                            <tr>                           
                                <td>{{$data->id_transaksi}} </td>               
                                <td>{{$data->nama_keluhan}}</td>                                
                                <td>Rp. {{$data->biaya_keluhan}} </td>
                                <td>
                                    <button type="button" data-bs-toggle="modal" data-id1="{{ $data->id_barang }}" data-id2="{{$data->id_brg}}" data-bs-target="#finModal" required readonly class="btn btn-warning">Edit</button>                                            
                                            <div class="modal fade" id="finModal" tabindex="-1" aria-labelledby="soModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">                                                           
                                                    <form action="{{ route('edit.status')}}" method="POST">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">                                                                
                                                                <h3>Edit Status</h3>
                                                                <button type="button" class="btn btn-red btn-close" data-bs-dismiss="modal"></button>                                                                                                                                    
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="d-flex flex-column">                                                                  
                                                                    <div class="harga mb-2 d-flex flex-column">
                                                                        <label for="">Harga</label>
                                                                        <input name="id_detkel" class="id_detkel" id="kel_data" hidden>                                                                        
                                                                        <input name="id_detbar" class="id_detbar" id="bar_data" hidden>                                                                        
                                                                        <input type="text" name="biaya_keluhan" placeholder="Masukkan Harga">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit">Submit</button>
                                                            </div>
                                                        </div>  
                                                    </form>                                           
                                                </div>
                                            </div>
                                    <form action="{{ route('delete.keluhan', ['id' => $data->id_kels]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="text" name="id_detbar" value="{{$data->id_brg}}" hidden>
                                        <input type="text" name="id_transaksi" value="{{$data->id_transaksi}}" hidden>                    
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>                                                        
                            @endforeach
                        </tbody>
                    </table>
                    <form action="{{ route('edit.all') }}" method="post" class="mt-2 d-flex justify-content-between">
                        @csrf
                        <input type="date" name="date" id="date">                        
                        <input type="text" name="id_transaksi" value="{{$data->id_transaksi}}" hidden>                        
                        <input type="text" name="totalbiaya" value="{{$total}}" hidden>
                        <input type="text" name="jasa_service" value="{{$data->jasa_service}}" hidden>
                        <button class="btn btn-success">Save</button>
                    </form>
                </div>
            @endforeach
        </div>    
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const finModal = document.getElementById('finModal');
        const idKel = document.getElementById('kel_data');
        const idBar = document.getElementById('bar_data');

        // Add event listener to all buttons
        document.querySelectorAll('.btn-warning').forEach(button => {
            button.addEventListener('click', function () {
                const idkeluhan = this.getAttribute('data-id1');
                const idBarang = this.getAttribute('data-id2');
                idKel.value = idkeluhan;
                idBar.value = idBarang;
            });
        });        
    });

</script>
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
