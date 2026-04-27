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
        <a href="{{ route('DataKel')}}" class="text-black"><strong>Back</strong></a>
        <div class="box">
            <div class="form">
                <h3>Tambah Tanda Terima</h3>            
                @foreach($tandater as $index => $data)
                    <p class="font-weight-bold">{{$data->customer}}</p>                
                    <p>{{$data->created_at}}</p>
                <table class="styled-table">
                        <thead class="bg-danger">
                            <tr>
                                <th>ID</th>                                
                                <th>Nama Barang</th>
                                <th>Serial Number</th>                                
                                <th>Status</th>                              
                                <th>Keluhan</th> 
                                <th>Done</th>                               
                            </tr>
                        </thead>                                                           
                        <tbody> 
                            @foreach($data->barang as $index => $barang)                                                       
                                <tr>
                                    <td>{{$index+1}}</td>  
                                    <td>{{$barang->nama_barang}}</td>                                  
                                    <td>{{$barang->SN}}</td>                                                                                                            
                                    <td>{{$barang->status == null ? 'Pending' : $barang->status}}</td>                                                                                                         
                                    <td class="d-flex justify-content-center">
                                        <button type="button" data-bs-toggle="modal" data-id="{{ $barang->id }}" data-bs-target="#kelModal" required readonly class="btn btn-success">Tambah</button>
                                        {{-- MODAL --}}
                                        <div class="modal fade" id="kelModal" tabindex="-1" aria-labelledby="soModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">                                                
                                                    <form action="{{ route('addTeknisi')}}" id="editForm" method="POST">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">   
                                                                <h3>Pilih Keluhan</h3>                                                                
                                                                <button type="button" class="btn btn-red btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body"> 
                                                                <div class="nama-teknisi">
                                                                    <div class="keluhan" id="keluhanCont">                                                                                  
                                                                        <div class="d-flex justify-content-between mt-2">                                                                             
                                                                            <div class="p d-flex flex-column align-items-top">
                                                                                <label for="">Pilih Teknisi</label>
                                                                                <select name="id_teknisi" id="">
                                                                                    <option value="">-- Pilih Teknisi -- </option>
                                                                                    @foreach($teknisi as $tech)
                                                                                        <option value="{{ $tech->id_teknisi}}">{{$tech->nama_teknisi}}</option>                                                                                    
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <button class="btn btn-danger" type="button" onclick="tambahKel()">Tambah keluhan</button>                                                     
                                                                        </div>
                                                                        <div class="d-flex justify-content-between mt-2 align-items-end">
                                                                            <div class="left w-100 d-flex flex-column">
                                                                                <label for="">Keluhan 1</label>                                                                                 
                                                                                <input type="text" name="id_tandater" value="{{$data->id_tandater}}" hidden>
                                                                                <input type="text" name="id_barang" id="modal_id_barang" hidden>
                                                                                <select name="id_keluhan[]" id="id_keluhan" class="w-75">
                                                                                    <option value="">-- Pilih Keluhan -- </option>
                                                                                    @foreach($keluhan as $datas)
                                                                                    <option value="{{$datas->id}}">{{ $datas->keluhan }}</option>                                                                        
                                                                                    @endforeach
                                                                                </select>                                                                    
                                                                            </div>                                                                        
                                                                            <button class="btn btn-danger" type="button" onclick="hapusKel()">Hapus</button>                                                                         
                                                                        </div>                                                                         
                                                                    </div>
                                                                </div>                                                                                                             
                                                            </div>
                                                            <textarea name="keluhan" rows="4" cols="10" placeholder="Masukkan Keluhan" class="mx-3" id=""></textarea>
                                                            <div class="modal-footer">
                                                                <button type="submit">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>                                                
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($barang->id_teknisi === null)
                                            <input type="checkbox" >                                     
                                        @else
                                            <input class="form-check-input" type="checkbox" checked readonly disabled>                                            
                                        @endif                                                                             
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
    let counter = 2;
    function tambahKel(){
        const container = document.getElementById('keluhanCont');
            const newInput = document.createElement('div');
            newInput.innerHTML = `
                <div class="d-flex justify-content-between mt-2 align-items-end">
                    <div class="left w-100 d-flex flex-column">
                        <label for="">Keluhan ${counter}</label>                                                                                 
                        <input type="text" name="id_tandater" value="{{$data->id_tandater}}" hidden>
                        <select name="id_keluhan[]" id="id_keluhan" class="w-75">
                            <option value="">-- Pilih Keluhan -- </option>
                            @foreach($keluhan as $datas)
                                <option value="{{$datas->id}}">{{ $datas->keluhan }}</option>                                                                        
                            @endforeach
                        </select>                                                                    
                    </div>                                                                        
                    <button class="btn btn-danger" type="button" onclick="hapusKel(this)">Hapus</button>                                                                         
                </div> 
            `;
        container.appendChild(newInput);
        counter++;
    }
    function hapusKel(button){
        const keluhan = button.parentElement;
        keluhan.remove();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const kelModal = document.getElementById('kelModal');
        const idBarangInput = document.getElementById('modal_id_barang');

        // Add event listener to all buttons
        document.querySelectorAll('.btn-success').forEach(button => {
            button.addEventListener('click', function () {
                const idBarang = this.getAttribute('data-id');
                idBarangInput.value = idBarang; // Set the id_barang in the hidden input
            });
        });
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