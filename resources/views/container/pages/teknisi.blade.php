@extends('container.dashboard')

@section('content')
    <div class="car p-3">                                        
        <div class="table">
            <div class="shadow p-3 mb-2 bg-white rounded">
                <h3>Table Teknisi</h3>
                <button>Tambah Teknisi</button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Teknisi</th>
                            <th>Status</th>                      
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teknisi as $data)
                        <tr>
                            <td>{{ $data->nama_teknisi }}</td>
                            <td>{{ $data->status == 1 ? "Aktif" : "Tidak Aktif" }}</td>                        
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection