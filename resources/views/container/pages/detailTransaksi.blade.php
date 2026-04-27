@extends('container.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
    <div class="car p-3">        
            @csrf
            <div class="shadow p-3 mb-2 bg-white rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="left">
                    <p class="fs-5.6 fw-semibold">! Jika mengubah Data di bawah tolong pencet submit terlebih dahulu sebelum cetak</p>
                    </div>
                    @foreach($transbtn as $index => $data)
                    <div class="d-flex gap-2">                        
                        <button type="button" data-bs-toggle="modal" class="btn btn-success" data-id="{{ $data->id_transaksi }}" data-bs-target="#traModal" required readonly class="">Cetak</button>
                            <div class="modal fade" id="traModal" tabindex="-1" aria-labelledby="soModalLabel" aria-hidden="true">
                                <div class="modal-dialog">                                                
                                    <form action="{{ route('downPdf')}}" id="editForm" method="POST">
                                    @csrf
                                    <div class="modal-content">                                            
                                        <div class="modal-body"> 
                                            <div class="pdf d-flex flex-column align-items-start">
                                                <input type="text" name="ids" id="idkiw" value="{{$data->id_transaksi}}" hidden>
                                                <div class="kwitansi">
                                                    <input type="checkbox" name="kwitansi" id="kwit"> 
                                                    <label for="">Kwitansi</label>
                                                </div>
                                                <div class="sph">
                                                    <input type="checkbox" name="sph" id="sph"> 
                                                    <label for="">Surat Jalan</label>
                                                </div>
                                                <div class="inv">
                                                    <input type="checkbox" name="invoice" id="inv"> 
                                                    <label for="">Invoice</label>
                                                </div>
                                                <div class="pen">
                                                    <input type="checkbox" name="penawaran" id="pen"> 
                                                    <label for="">Penawaran Barang</label>
                                                </div>                                                   
                                            </div>                                                                                                           
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit">Cetak</button>
                                        </div>
                                    </div>

                                    </form>                                                
                                </div>
                            </div> 
                    </div>
                    @endforeach
                </div>
            </div>       
        <form action=" {{ route('check')}}" method="post">   
        @csrf   
            @foreach($transaksi->splice(0,1) as $data)
            <div class="row">
                <div class="col-md-10">
                <div class="shadow p-5 mb-3 bg-white rounded">
                <div class="customer">   
                        <input type="text" hidden value="{{$data->id_transaksi}}" name="id_transaksi">
                        <input type="text" hidden value="{{$data->id_customer}}" name="id_customer">                    
                        <p><label class="fw-semibold">No Invoice : </label> {{$data->no_invoice}} </p>                 
                        <p><label class="fw-semibold">Id Customer : </label> {{$data->id_customer}} </p>                 
                        @if($data->nama_toko != null)
                            <div class="client row justify-content-between">
                                <div class="col-md-4">
                                    <label for="">Tanggal Cetak</label>
                                    <input type="date" id="tanggalnow" name="tanggalnow" 
                                    class="form-control"
                                    value="{{ old('tanggalnow', $data->tanggalnow ? \Carbon\Carbon::parse($data->created_at)->format('Y-m-d') : '') }}" required>
                                </div> 
                                <div class="col-md-4">
                                    <label for="">Customer</label>
                                    <input type="text" id="customer_name" name="customer" 
                                    class="form-control"
                                    value="{{ old('customer_name', $data->customer) }}" required>                                
                                </div>  
                                <div class="col-md-4">
                                    <label for="">Toko</label>
                                    <input type="text" name="Toko"
                                    class="form-control"
                                    value="{{ old('Toko', $data->Toko)}}">
                                </div>                                                          
                            </div>
                            <div class="client row justify-content-between mt-3">                                
                                <div class="col-md-6">
                                    <label for="">Nama Toko</label>
                                    <input type="text" id="customer_name" name="nama_toko" 
                                    class="form-control"
                                    value="{{ old('customer_name', $data->nama_toko) }}" required>                                
                                </div>  
                                <div class="col-md-6">
                                    <label for="">Kode Toko</label>
                                    <input type="text" name="kode_toko"
                                    class="form-control"
                                    value="{{ old('kode_toko', $data->kode_toko)}}">
                                </div>                                                          
                            </div> 
                        @else
                            <div class="client row justify-content-between">
                                <div class="col-md-4">
                                    <label for="">Tanggal Cetak</label>
                                    <input type="date" id="tanggalnow" name="tanggalnow" 
                                    class="form-control"
                                    value="{{ old('tanggalnow', $data->tanggalnow ? \Carbon\Carbon::parse($data->created_at)->format('Y-m-d') : '') }}" required>
                                </div> 
                                <div class="col-md-4">
                                    <label for="">Customer</label>
                                    <input type="text" id="customer_name" name="customer" 
                                    class="form-control"
                                    value="{{ old('customer_name', $data->customer) }}" required>                                
                                </div>  
                                <div class="col-md-4">
                                    <label for="">Toko</label>
                                    <input type="text" name="Toko"
                                    class="form-control text-secondary"
                                    readonly
                                    value="null">
                                </div>                                                          
                            </div>
                            <div class="client row justify-content-between mt-3">
                                <div class="col-md-6">
                                    <label for="">Nama Toko</label>
                                    <input type="text" id="customer_name" name="id_customer" 
                                    class="form-control"
                                    value="{{ old('customer_name', $data->id_customer) }}" required>                                
                                </div>  
                                <div class="col-md-6">
                                    <label for="">Kode Toko</label>
                                    <input type="text" name="nama_toko"
                                    class="form-control text-secondary"
                                    readonly
                                    value="null">
                                </div>                                                          
                            </div>                            
                        @endif                    
                </div>
                <div class="cost">
                    <div class="row justify-content-between mt-3">
                        <div class="col-md-6">
                            <label for="">Sub Total</label>
                            <input type="text" id="customer_name" name="total_biaya" 
                                    class="form-control"
                                    value="{{ old('total_biaya', $data->totalbiaya, 0, ',','.') }}" required>                                
                        </div>
                        <div class="col-md-6">
                            <label for="">Jasa Service</label>
                            <input type="text" id="customer_name" name="jasa_service" 
                                    class="form-control"
                                    value="{{ old('jasa_service', $data->jasa_service, 0, ',','.') }}" required>                                
                        </div>
                    </div>
                    <div class="row justify-content-between mt-3">
                        <div class="col-md-6">
                            <label for="">PPN</label>
                            <input type="text" id="ppn" name="ppn" 
                                    class="form-control"
                                    value="{{ old('ppn', $data->ppn, 0, ',','.') }}" required>                                
                        </div>
                        <div class="col-md-6">
                            <label for="">Total</label>
                            <input type="text" id="total" name="total" 
                                    class="form-control"
                                    value="{{ old('total', $data->totalbiaya + $data->ppn, 0, ',','.') }}" >                                
                        </div>
                    </div>                    
                </div>
                <div class="barang mt-5">
                    <div class="table-responsive">                        
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Nama Barang</td>
                                        <td>Serial Number</td>
                                        <td>Status</td>
                                        <td>harga</td>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($barang as $index => $bar)
                                    <tr>
                                        <td>{{$index+1}} </td>
                                        <td>
                                            <input type="text" id="nama_barang" name="nama_barang" 
                                            class="form-control"
                                            value="{{ old('nama_barang', $bar->nama_barang) }}" required readonly>                                              
                                        </td>
                                        <td>
                                            <input type="text" id="nama_barang" name="nama_barang" 
                                            class="form-control"
                                            value="{{ old('sn', $bar->SN) }}" required readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="status" name="status" 
                                            class="form-control"
                                            value="{{ old('status', $bar->status) }}" required readonly>
                                        </td>
                                        <td>
                                            <input type="text" id="cost" name="cost" 
                                            class="form-control"
                                            value="{{ old('cost', $bar->cost) }}" required readonly>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>                        
                    </div>
                </div>
            </div>            
                </div>                
                <div class="col-md-2">
                    <div class="shadow p-3 mb-2 bg-white rounded">
                        <div class="">                            
                            <div class="d-flex flex-column gap-2">
                                <a class="btn btn-primary" href="{{ route('cetak.list')}}">Back</a>          
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>  
            @endforeach
        </form>                                  
    </div>    
@endsection