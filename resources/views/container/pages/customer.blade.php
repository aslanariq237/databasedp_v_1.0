@extends('container.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
    <div class="car">                
        <div class="card">
            <div class="new">
                <a href="{{ route('tampil.tandater')}}">New</a>
            </div>
            <div class="card1">
                <div class="cust">
                    <button type="button" data-bs-toggle="modala" data-id="" data-bs-target="#elekModal" required readonly>New Customer</button>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <div class="table">
            <table class="styled-table">
                <thead>
                    <tr>                        
                        <th>ID</th>
                        <th>Nama Toko</th>
                        <th>Kode Toko</th>
                        <th>Toko</th>  
                        <th>status</th>                           
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer as $index => $data)
                    <tr>                                          
                        <td>{{ $index+1 }}</td>
                        <td>
                            {{$data->nama_toko}}
                        </td>  
                        <td>
                            {{$data->kode_toko}}
                        </td>                  
                        <td>
                            {{$data->Toko}}
                        </td>  
                        <td>
                            {{$data->status != 1? "Buka" : "Tutup"}}
                        </td>                                              
                        <td>
                           <button>
                            Edit
                           </button>
                           <button>
                            Tutup
                           </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection