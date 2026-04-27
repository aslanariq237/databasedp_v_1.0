@extends('container.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
    <div class="car p-3"> 
        <form action="" method="post">
            <div class="d-flex justify-content-between">
                <div class="left"></div>
                <div class="search d-flex">
                    <input type="text" class="px-2 form-control rounded-none" placeholder="Cari sesuai SN">
                    <button>Search</button>
                </div>            
            </div>
        </form>                                
        <div class="table-responsive shadow p-3 mb-2 bg-white rounded">
            <table class="table">
                <thead>
                    <tr>                        
                        <th>ID</th>                   
                        <th>Toko</th>                   
                        <th>Customer</th>
                        <th>Barang</th>  
                        <th>Sub Total</th>  
                        <th>ppn</th>    
                        <th>Total</th>
                        <th>Payment</th>                                                                
                        <th>Action</th>                                          
                        <th>Bayar</th>                    
                    </tr>
                </thead>
                <tbody>
                    @foreach($tandater as $index => $data)
                    <tr>                                          
                        <td>{{ $data->id_transaksi }}</td>                    
                        <td>{{ $data->customer}}</td>                  
                        @if( !$data->nama_toko)
                            <td>{{ $data->id_customer}}</td>                        
                        @else
                            <td>{{ $data->nama_toko}}-{{$data->kode_toko}}</td>    
                        @endif  
                        <td>{{ $data->nama_barang}} - {{$data->SN}}</td>                     
                        <td>Rp. {{number_format($data->totalbiaya, 0, ',','.')}} </td>
                        <td>Rp. {{number_format($data->ppn, 0, ',', '.')}}</td>
                        <td>Rp. {{number_format($data->ppn + $data->totalbiaya, 0, ',', '.')}}</td>
                        <td> {{$data->status_pay == 0 ? "Belum di Bayar" : "Sudah di Bayar"}} </td>
                        <td>                            
                            <button type="button" data-bs-toggle="modal" class="btn btn-wuek" data-id="{{ $data->id_transaksi }}" data-bs-target="#traModal" required readonly class="">Cetak</button>
                            <div class="modal fade" id="traModal" tabindex="-1" aria-labelledby="soModalLabel" aria-hidden="true">
                                <div class="modal-dialog">                                                
                                    <form action="{{ route('downPdf')}}" id="editForm" method="POST">
                                    @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">   
                                                <h3>Pilih PDF</h3>                                                                
                                                <button type="button" class="btn btn-red btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body"> 
                                                <div class="pdf d-flex flex-column align-items-start">
                                                    <input type="text" name="ids" id="idkiw" hidden>
                                                    <div class="kwitansi">
                                                        <input type="checkbox" name="kwitansi" id="kwit"> 
                                                        <label for="">Kwitansi</label>
                                                    </div>                                                    
                                                    <div class="inv">
                                                        <input type="checkbox" name="invoice" id="inv"> 
                                                        <label for="">Invoice</label>
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
                        </td>
                        <td>
                            <form action="{{ route('paid', ['id' => $data->id_transaksi])}}" method="post">
                                @csrf
                                <button class="btn btn-success" type="submit">Paid</button>
                            </form>
                        </td>                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                    idinv.value = idkeluhan;
                    id.value = idkeluhan;
                });
            });            
        });
        document.addEventListener('DOMContentLoaded', function () {            
            const id_tran = document.getElementById('id_date')                   

            document.querySelectorAll('.btn-wue').forEach(button => {
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