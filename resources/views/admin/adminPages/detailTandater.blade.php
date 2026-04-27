@extends('admin.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
        <div class="line"></div>
        <div class="table">
            <table class="styled-table">
                <thead>
                    <tr>                        
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Nama Barang</th>
                        <th>SN</th>                             
                        <th>Status</th>                        
                        <th>Tanggal</th>                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tandater as $index => $data)
                    <tr>                                          
                        <td>{{ $data->id_tandater }}</td>
                        <td>
                            {{$data->customer}}
                        </td> 
                        <td>
                            @foreach($data->barang->splice(0,1) as $barang)
                                    {{$barang->nama_barang}}                    
                            @endforeach                                                                   
                        </td>
                        <td>
                            @foreach($data->barang->splice(0,1) as $barang)
                                    {{$barang->SN}}                    
                            @endforeach   
                        </td>  
                        <td>
                            {{$data->garansi == 0? "Tidak Garansi" : "Garansi"}} 
                        </td>        
                        <td>
                            {{$data->created_at->format('Y-m-d')}}
                        </td>          
                        <td>
                            <a href="{{ route('TampilId', ['id' => $data->id])}}">Lihat</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection