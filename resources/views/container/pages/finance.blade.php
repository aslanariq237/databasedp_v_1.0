@extends('container.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
    <div class="car p-3"> 
        <div class="car-baru p-3 mb- bg-white rounded">
            <div class="d-flex justify-content-between shadow p-3 mb-1 bg-white rounded">                
                <div class="search-input">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / kode..."
                            class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">            

                        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900">
                            Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>                        
        <div class="table-responsive shadow p-3 mb-2 bg-white rounded">
            <table class="table">
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
                    @forelse($tandater as $index => $data)
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
                        <td>{{ $data->created_at->format('Y-m-d') }}</td>
                        <td class="d-flex gap-2">
                            @if($data->has_created != 1)
                                <a class="btn btn-primary" href="{{ route('list.finance', ['id' => $data->id])}}">Lihat</a>
                            @else
                                <a class="btn btn-primary disabled" href="{{ route('list.finance', ['id' => $data->id])}}">Lihat</a>
                            @endif
                            <a class="btn btn-success" href="{{ route('tampil.cetak', ['id' => $data->id_tandater])}}">Cetak</a>
                        </td>  
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Belum ada data Tandater.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0">
            {{ $tandater->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection