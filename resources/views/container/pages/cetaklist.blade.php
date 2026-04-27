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
        <div class="table-responsive shadow p-3 mb-5 bg-white rounded">
            <table class="table">
                <thead>
                    <tr>                        
                        <th>ID</th>                        
                        <th>Toko</th>                        
                        <th>Customer</th>  
                        <th>Sub Total</th>  
                        <th>ppn</th>    
                        <th>Total</th>
                        <th>Payment</th>                                                                                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tandater as $index => $data)
                    <tr>                                          
                        <td>{{ $data->id_transaksi }}</td>                    
                        <td>{{ $data->customer }}</td>                    
                        @if($data->nama_toko === null)
                            <td>{{ $data->id_customer}}</td>
                        @else
                            <td>{{ $data->nama_toko}}-{{$data->kode_toko}}</td>
                        @endif                        
                        <td>Rp. {{number_format($data->totalbiaya, 0, ',','.')}} </td>
                        <td>Rp. {{number_format($data->ppn, 0, ',', '.')}}</td>
                        <td>Rp. {{number_format($data->ppn + $data->totalbiaya, 0, ',', '.')}}</td>
                        <td> {{$data->status_pay == 1 ? "Sudah di Bayar" : "Belum di Bayar"}} </td>                        
                        <td class="d-flex gap-2">
                            <form action="{{ url('/AllGet', ['id' => $data->id_transaksi])}}">
                                @csrf
                                <button class="btn btn-primary" type="submit">View</button>
                            </form>
                            <a class="btn btn-warning" href="{{ url('/edit-tr', ['id'=> $data->id_transaksi])}}">Edit</a>                                                    
                            <form action="{{ route('delete.tras', ['id' => $data->id_transaksi])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                Belum ada data Transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-white px-6 py-4 border-t border-gray-200">
            {{ $tandater->links('pagination::bootstrap-5') }}        
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const idkwit = document.getElementById('kwit');
            const idsph = document.getElementById('sph');
            const idinv= document.getElementById('inv');
            const idpen = document.getElementById('pen');        
            const id = document.getElementById('idkiw'); 
            const id_tran = document.getElementById('id_date')       

            // Add event listener to all buttons
            document.querySelectorAll('.btn-wuek').forEach(button => {
                button.addEventListener('click', function () {
                    const idkeluhan = this.getAttribute('data-id');                
                    
                    idkwit.value = idkeluhan;
                    idsph.value = idkeluhan;
                    idinv.value = idkeluhan;
                    idpen.value = idkeluhan;
                    id.value = idkeluhan;
                });
            });            
        });
        document.addEventListener('DOMContentLoaded', function () {            
            const id_tran = document.getElementById('id_date')                   

            document.querySelectorAll('.btn-date').forEach(button => {
                button.addEventListener('click', function () {
                    const id_transaksi = this.getAttribute('data-id');
                    
                    id_tran.value = id_transaksi;
                });
            }); 
        });
    </script>
@endsection

@section('script')    
@endsection