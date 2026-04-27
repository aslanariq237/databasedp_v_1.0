<div class="px-3">
    @if(Auth::check())
        <div class="d-flex justify-content-between items-center gap-4">
            <div class="nama_employee">
                <p class="fw-semibold">Hola, {{Auth::user()->name}}</p>
            </div>
            <div class="button">
                <form action="{{ route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger ">LogOut</button>
                </form>
            </div>
        </div>
    @else
        <a href="{{route('tampil.login')}}">Login</a>
    @endif
</div>