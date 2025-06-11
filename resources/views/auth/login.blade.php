<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login – PPDB 2025</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
    <div class="container"><br>
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center"><b>PPDB 2025</b><br>SMK TAMANSISWA 2 JAKARTA</h3>
                <hr>
                @if(session('error'))
                <div class="alert alert-danger"> <b>Opps!</b> {{session('error')}}
                </div>
                @endif
                <form action="{{ route('actionlogin') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label><i class="fa fa-user"></i> Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required="">
                    </div>
                    <div class="form-group position-relative">
                        <label><i class="fa fa-key"></i> Password</label>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
                            <span class="input-group-text bg-white" style="cursor: pointer;" onclick="togglePassword()">
                                <i class="fa fa-eye" id="togglePasswordIcon"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
                    <a href="/"><button type="button" class="btn btn-success btn-block">Kembali</button></a>
                    <hr>
                    <p class="text-center">Belum punya akun? <a href="/register"><button type="button" class="btn btn-info">Daftar</button></a> sekarang!</p>
                </form>
        </div>
    </div>
</body>
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
</script>

</html>