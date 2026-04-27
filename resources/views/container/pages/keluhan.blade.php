@extends('container.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
    <div class="car p-3">                        
        <div class="table-responsive shadow p-3 mb-5 bg-white rounded">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Nama Barang</th>
                        <th>SN</th>     
                        <th>garansi</th>
                        <th>Tanggal</th>                                               
                        <th>keluhan</th>
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
                                @foreach($data->barang->slice(0,1) as $barang)
                                    {{$barang->nama_barang}}
                                @endforeach                            
                        </td>
                        <td>
                                @foreach($data->barang->slice(0,1) as $barang)
                                    {{$barang->SN}}
                                @endforeach    
                        </td>                           
                        <td>{{ $data->garansi == 0 ? "Tidak Garansi" : "Garansi" }}</td>
                        <td>{{ $data->created_at->format('d-M-Y') }}</td>                        
                        <td>                            
                            <a class="btn btn-primary" href="{{ route('tampil.id', ['id' => $data->id])}}">Tambah</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection