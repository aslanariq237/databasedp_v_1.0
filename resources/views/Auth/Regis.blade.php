<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Auth/login.css">
    <title>Registrasi ManageTem</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h3>Regis ManageTem</h3>
            <p>Welcome! Please Log In with your Account</p>
            <div class="form">
                <form action="{{ route('AddReg')}}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Enter your Username">
                    <input type="email" name="email" placeholder="Enter your Email">
                    <input type="password" name="password" placeholder="Enter your Password">
                    <button>Sign Up</button>
                    <a href="{{ route('tampil.login')}}">Already have an Account?<span>Sign In</span></a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>