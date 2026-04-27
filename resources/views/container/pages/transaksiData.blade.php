@extends('container.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
<div class="contain">  
    <form action="{{ route('trans.do') }}" method="GET" class="shadow p-3 mb-2 bg-white rounded">
        @csrf   <!-- wajib kalau method="POST", tapi di sini kita pakai GET biar lebih sederhana untuk export -->

        <div class="date d-flex justify-content-end align-items-center mx-2 gap-2">
            <div>
                <label for="start_date" class="form-label small">Dari</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div>
                <label for="end_date" class="form-label small">Sampai</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>

            <div class="align-self-end">
                <button type="submit" class="btn btn-primary">Export Excel</button>
            </div>
        </div>
    </form>      
        <div class="table-responsive shadow p-3 mb-2 bg-white rounded">
            <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>id Transaksi</th>                    
                    <th>id invoice</th>
                    <th>Customer</th>
                    <th>Barang</th>
                    <th>Serial Number</th>
                    <th>Sub Barang</th>
                    <th>Sub Service</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>Payment</th>   
                    <th>Date</th>             
                </tr>
            </thead>            
            @forelse($transaksi as $index => $data)
                <tbody>
                    <tr>     
                        <td>{{ $loop->iteration + ($transaksi->currentPage() - 1) * $transaksi->perPage() }}</td>       
                        <td>{{$data->id_transaksi}} </td>                        
                        <td>{{$data->no_invoice}} </td>                        
                        <td>
                            @if($data->nama_toko != null)
                                {{$data->nama_toko}}
                            @else
                                {{$data->id_customer}}
                            @endif
                        </td>
                        <td>{{$data->nama_barang}} </td>
                        <td>{{ $data->SN}}</td>
                        <td>Rp.{{number_format($data->total_biaya, 0, ',','.')}}</td>
                        <td>Rp.{{number_format($data->jasa_service, 0, ',','.')}}</td>
                        <td>Rp.{{number_format($data->ppn, 0, ',','.')}}</td>
                        <td>Rp.{{number_format($data->total_biaya + $data->ppn, 0, ',','.')}}</td>
                        <td>{{ $data->status_pay != 0 ? "Sudah Bayar" : "Belum Bayar"}}</td>                  
                        <td>{{\Carbon\Carbon::parse($data->created_at)->format('y M d')}} </td>
                    </tr>
                </tbody>
            @empty
                    <td colspan="11" class="px-6 py-12 text-center text-gray-500">
                        Belum ada data transaksi.
                    </td>
            @endforelse              
        </table>
        </div>
        <div class="card-footer bg-white border-0">
            {{ $transaksi->links('pagination::bootstrap-5') }}
        </div>
    </div>    
@endsection

@section('script')    
@endsection