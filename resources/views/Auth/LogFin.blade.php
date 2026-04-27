<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Auth/login.css">
    <title>Login ManageTem</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="title">
                <h3>Login As Finance</h3>
            </div>
            <p>Welcome! Please Log In with your Account</p>
            <div class="form">
                <form action="{{ route('req.finance')}}" method="POST">                
                    @csrf
                    <input type="email" name="email" placeholder="Enter your Email">
                    <input type="password" name="password" placeholder="Enter your Password">
                    <button>Sign In</button>
                    <div class="r1">
                        <a href="{{ route('tamtek')}}">Login as Teknisi</a>
                        <a href=" {{ route('tampil.admin') }}">Login as Admin</a>
                    </div>
                    <a href="{{ route('tampil.regis')}}">Dont have an Account yet?<span>Sign Up</span></a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>