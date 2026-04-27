@extends('container.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
    <div class="car p-3">                
        <div class="shadow p-3 mb-2 rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div class="back">
                    <a class="btn btn-primary" href="{{ route('DataCust')}}">Back</a>
                </div>
                <form action="{{ route('cari.barangs')}}">
                    @csrf
                    <div class="d-flex">
                        <input type="text" class="form-control" name="serial_number">
                        <button type="submit">Submit</button>
                    </div>
                </form>                                   
            </div>
        </div>
        <div class="line"></div>
        <div class="table-responsive shadow p-3 mb-2 rounded">
            <table class="table">
                <thead>
                    <tr>                        
                        <th>ID</th>
                        <th>Toko</th>
                        <th>Customer</th>
                        <th>Nama Barang</th>
                        <th>SN</th>                             
                        <th>Status</th>
                        <th>Tanggal</th>                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($tandater)
                    <tr>                                          
                        <td>{{ $tandater->id_tandater }}</td>
                        <td>{{ $tandater->Toko}}</td>
                        <td>
                            {{$tandater->customer}}
                        </td>
                        <td class="text-truncate">                            
                            {{$tandater->nama_barang}}
                        </td>
                        <td class="text-truncate">                        
                            {{$tandater->SN}}                            
                        </td>                                                   
                        <td>{{ $tandater->garansi == 0 ? "Tidak Garansi" : "Garansi" }}</td>                        
                        <td>
                            {{\Carbon\Carbon::parse($tandater->created_at)->format('d M Y')}}
                        </td>
                        <td>
                            <a class="btn btn-success" href="{{ route('TampilId', ['id' => $tandater->id_tandater])}}">Lihat</a>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection