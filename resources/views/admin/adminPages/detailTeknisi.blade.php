@extends('container.dashboard')

@section('content')
<!-- seharusnya pada konten ini data yang ditampilkan adalah data akhir -->
    <div class="car p-3"> 
        <div class="cardus">
            <div class="between shadow p-3 mb-2 bg-white rounded" >
                <div class=""></div>
                <div class="data">
                    <form action="{{ route('tekn.do')}}" method="GET" style="dislay: flex;">
                        @csrf
                            <input type="date" name="start_date" id="">
                            <input type="date" name="end_date" id="">
                        <button class="btn btn-sm btn-success" style="height: 40px; margin-left: 10px;">Cetak</button>
                    </form>
                </div>
            </div>
        </div>                        
        <div class="table-responsive shadow p-3 mb-2 bg-white rounded">
            <table class="table">
                <thead>
                    <tr>                        
                        <th>ID</th>
                        <th>Nama Teknisi</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teknisi as $data)
                        <tr>
                            <td>{{$data->id_teknisi}}</td>
                            <td>{{$data->nama_teknisi}}</td>
                            <td>{{$data->status == 0 ? "Tidak Aktif" : "Aktif"}}</td>
                            <td>
                                <a class="btn btn-primary" href="{{ route('list.teknisis', ['id' => $data->id_teknisi])}}">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection