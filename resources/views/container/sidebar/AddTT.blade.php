<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/tandaterima.css">
    <title>Tambah Tanda Terima</title>
</head>
<body>
    <div class="contain">
        <a href="{{ route('DataCust')}}" class="text-black"><strong>Back</strong></a>
        <div class="box">
            <form action="{{ route('AddTT') }}" method="POST">
                @csrf
                <div class="form">
                    <div class="tandater">
                        <div class="head">
                            <div class="title">
                                <h3>Tambah Tanda Terima</h3>                                
                            </div>
                            <div class=" d-flex justify-content-between">
                                <div class="customer w-50">
                                    <label for="">Customer</label>
                                    <input type="text" class="m-0 w-100" name="customer">
                                </div>                            
                                <button type="button" onclick="tambahInput()" class="w-25">Tambah</button>                            
                            </div>
                        </div>
                        <div class="input" id="contain" style="max-height: 500px; overflow-y: auto; padding: 10px; margin-top: 10px;">
                            <div class="d-flex justify-content-between" id="input">
                                <div class="baran">
                                    <label for="">Nama Barang</label>
                                    <input type="text" name="nama_barang[]" placeholder="Enter the Nama barang" id="">
                                </div>
                                <div class="sn">
                                    <label for="">Serial Number</label>
                                    <input type="text" name="sn[]" placeholder="Enter the SN">                                                                                                                    
                                </div>
                                <div class="customer">
                                    <label for="">Customer</label>
                                    <input type="text" name="id_customer[]" id="search_customer" placeholder="Masukkan nama atau kode toko..." autocomplete="off">
                                    <div id="customer_list"></div>
                                </div>
                                <div class="garansi">                                    
                                    <label for="">Garansi</label>
                                    <select name="garansi" id="">
                                        <option value="">-- Pilih Garansi -- </option>
                                        @foreach($garansi as $data => $value)
                                            <option value="{{$data}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
                <button type="submit">Submit</button>   
            </form>
        </div>
    </div>
</body>
<script>   
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

    let counter = 2;        
    function tambahInput(){
        const container = document.getElementById('contain');
        const newInput = document.createElement('div');
        const uniqueId = `search_custom_${counter}`;
        const uniqueListId = `custom_list_${counter}`;

        newInput.innerHTML = `            
            <div class="d-flex justify-content-between" id="input"> 
                <p class="mt-2">${counter}</p>               
                <input class="mx-2" type="text" name="nama_barang[]" placeholder="Enter the Nama barang" id="">                                
                <input type="text" class="mx-2" name="sn[]" placeholder="Enter the SN">                                                                                                                                                                      
                <div class="w-100 position-relative mx-2">
                    <input name="id_customer[]" type="text" id="${uniqueId}" class="mt-2 w-100" placeholder="Masukkan nama atau kode toko..." autocomplete="off">
                    <div id="${uniqueListId}" style="border: 1px solid #ddd; overflow-y: auto; position: absolute; background: white;z-index: 1000;"></div>
                </div>
                <select name="garansi" class="mx-2">
                    <option value="">-- Pilih Customer -- </option>
                    @foreach($garansi as $data => $value)
                        <option value="{{$data}}">{{$value}}</option>
                    @endforeach
                </select>  
                <button class="btn btn-sm btn-danger" onclick="hapusInput(this)">Delete</button>    
            </div>
        `;
        container.appendChild(newInput);

        const searchInput = document.getElementById(uniqueId);
        const customerList = document.getElementById(uniqueListId);

        searchInput.addEventListener('input', function() {
            const query = this.value;

            // Kosongkan hasil jika input kosong
            if (query === '') {
                customerList.innerHTML = '';
                return;
            }

            // Kirim permintaan AJAX ke server
            fetch(`/search-customer?query=${query}`)
                .then(response => response.json())
                .then(data => {                    
                    customerList.innerHTML = ''; // Kosongkan daftar sebelum diisi ulang

                    if (data.length > 0) {
                        data.forEach(customer => {
                            const option = document.createElement('div');
                            option.className = 'customer-option';
                            option.style.padding = '8px';
                            option.style.cursor = 'pointer';                            
                            option.textContent = `${customer.nama_toko} - ${customer.kode_toko}`;
                            option.setAttribute('data-id', customer.id);

                            // Tambahkan event listener untuk klik
                            option.addEventListener('click', function() {                        
                                customerList.innerHTML = ''; // Kosongkan daftar setelah dipilih
                                searchInput.value = customer.id;
                            });

                            customerList.appendChild(option);
                        });
                    } else {
                        customerList.innerHTML = '<div>Tidak ada hasil</div>';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
        counter++;
    }

    function hapusInput(button){
        const keluhan = button.parentElement;
        keluhan.remove();
    }          
</script>
<style>
    #customer_list {
    border: 1px solid #ddd;    
    overflow-y: auto;
    position: absolute;
    background: white;    
    z-index: 1000;
}

.customer-option {
    padding: 8px;
    cursor: pointer;
}

.customer-option:hover {
    background: #f0f0f0;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>