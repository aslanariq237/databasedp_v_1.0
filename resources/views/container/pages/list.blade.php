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
        <a href="{{ route('DataCust')}}" class="text-black"><strong>Back</strong></a>
        <div class="box">
            <div class="form">
                <h3>Tambah Tanda Terima</h3>
                @foreach($tandater as $index => $data)
                <form action="{{ route('edited.name')}}" method="POST">
                    @csrf
                    <input type="text" id="customer_name" name="customer_name" 
                    value="{{ old('customer_name', $data->customer) }}" required>
                    <input type="text" name="id_tandater" value="{{$data->id_tandater}}" hidden>
                    <button type="submit">edit</button>
                </form>     
                <p style="margin: 0;">Bekasi, {{\Carbon\Carbon::parse($data->tanggalnow)->format('d M Y')}}</p>            
                    <table class="styled-table">
                        <thead class="bg-danger">
                            <tr>
                                <th>ID</th>                                
                                <th>Nama Barang</th>
                                <th>Serial Number</th>                                 
                                <th>Status</th>    
                                <th>Customer</th>                           
                                <th>Action</th>                                
                            </tr>
                        </thead>                                                           
                        <tbody> 
                            @php
                                $count = 1;
                            @endphp
                            @foreach($barang as $index => $barang)                                                       
                                <tr>
                                    <td>{{$index+1}}</td>  
                                    <td>{{$barang->nama_barang}}</td>                                  
                                    <td>{{$barang->SN}}</td>                                                                                                          
                                    <td>{{$barang->status_barang}}</td>                                                                    
                                    <td>
                                        @if(!$barang->nama_toko)
                                            <p>Toko null</p>                                            
                                        @else                           
                                            {{$barang->nama_toko}}                  
                                        @endif                                                                       
                                    </td>                                     
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-id="{{$barang->id_barang}}" data-bs-target="#barModal" required readonly>Edit</button>
                                        {{-- MODAL --}}
                                        <div class="modal fade" id="barModal" tabindex="-1" aria-labelledby="barModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('edit.barang')}}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3>Edit Barang</h3>
                                                            <button type="button" class="btn btn-red btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                                                            
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="content">
                                                                <div class="barang">
                                                                    <label for="">Nama Barang</label>
                                                                    <input type="text" class="w-100" name="nama_barang" placeholder="Masukkan nama Barang">
                                                                    <input type="text" id="barang_modal_id" name="id_barang" hidden>
                                                                </div>
                                                                <div class="serial mt-2">
                                                                    <label for="">Serial Number</label>
                                                                    <input type="text" class="w-100" name="sn" placeholder="Masukkan Serial Number">
                                                                </div>
                                                                <div class="customer mt-2">
                                                                    <label for="">Customer</label>
                                                                    <input type="text" class="w-100" name="id_customer" id="search_customer" placeholder="Masukkan nama atau kode toko..." autocomplete="off">
                                                                    <div id="customer_list"></div>
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
                                    </td>                                                                                                                                            
                                </tr>                            
                            @endforeach
                        </tbody>
                    </table> 
                @endforeach                   
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const idBarang = document.getElementById('barang_modal_id');

        document.querySelectorAll('.btn-warning').forEach(button=>{
            button.addEventListener('click', function(){
                const id_barang = this.getAttribute('data-id');
                idBarang.value = id_barang;
            })
        })
    });

    document.getElementById('search_customer').addEventListener('input', function() {
        const query = this.value;

        // Kosongkan hasil jika input kosong
        if (query === '') {
            document.getElementById('customer_list').innerHTML = '';
            return;
        }

        // Kirim permintaan AJAX ke server
        fetch(`/search-customer?query=${query}`)
            .then(response => response.json())
            .then(data => {
                const customerList = document.getElementById('customer_list');
                customerList.innerHTML = ''; // Kosongkan daftar sebelum diisi ulang

                if (data.length > 0) {
                    data.forEach(customer => {
                        const option = document.createElement('div');
                        option.className = 'customer-option';
                        option.textContent = `${customer.nama_toko} - ${customer.kode_toko}`;
                        option.setAttribute('data-id', customer.id);

                        // Tambahkan event listener untuk klik
                        option.addEventListener('click', function() {                        
                            customerList.innerHTML = ''; // Kosongkan daftar setelah dipilih
                            document.getElementById('search_customer').value = customer.id;
                        });

                        customerList.appendChild(option);
                    });
                } else {
                    customerList.innerHTML = '<div>Tidak ada hasil</div>';
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>
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