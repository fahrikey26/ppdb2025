<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="img/logo.png">
    <title>Register Pendaftar</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

</head>

<body style="background-color: #ded8d8;">
    <div class="container"><br>
        <div class="col-md-8 col-md-offset-2">
            <h2 class="text-center"><b>REGISTER PENDAFTAR PPDB 2025</b><br>SMK TAMANSISWA 2 JAKARTA</h3>
                <hr>
                @if(session('message'))
                <div class="alert alert-success"> {{session('message')}} </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <form action="{{route('actionregister')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"> <label> Nomor Formulir</label>
                                <input type="text" name="kodependaftaran" class="form-control" placeholder="No Formulir" value="{{ old('kodependaftaran') }}" required>
                            </div>
                            <div class="form-group"> <label> NISN</label>
                                <input type="text" name="nisn" class="form-control" placeholder="NISN" value="{{ old('nisn') }}" required>
                            </div>
                            <div class="form-group"> <label> Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama" value="{{ old('nama') }}" required>
                            </div>
                            <div class="form-group"> <label> Tempat Lahir</label>
                                <input type="text" name="tempatlahir" class="form-control" placeholder="Tempat Lahir" value="{{ old('tempatlahir') }}" required>
                            </div>
                            <div class="form-group"> <label> Tanggal Lahir</label>
                                <input type="date" name="tanggallahir" class="form-control" placeholder="Tanggal Lahir" value="{{ old('tanggallahir') }}" required>
                            </div>
                            <div class="form-group"> <label> Jenis Kelamin</label>
                                <select name="jeniskelamin" id="jeniskelamin" class="form-control">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group"> <label> Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat" cols="50" rows="5" required>{{ old('alamat') }}</textarea>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group"> <label> No HP (Bisa WA)</label>
                                <input type="text" name="nohp" class="form-control" placeholder="No HP" value="{{ old('nohp') }}" required>
                            </div>
                            <div class="form-group"> <label> Asal Sekolah</label>
                                <input type="text" name="asalsekolah" class="form-control" placeholder="Asal Sekolah" value="{{ old('asalsekolah') }}" required>
                            </div>

                            <div class="form-group"> <label> Nilai Rerata (Misal : 88.88)</label>
                                <input type="number" name="nilairata" class="form-control @error('nilairata') is-invalid @enderror" placeholder="Nilai Rata" value="{{ old('nilairata') }}" required step="0.01" required oninvalid="this.setCustomValidity('Harap masukkan nilai angka desimal')" oninput="setCustomValidity('')">
                            </div>
                            <div class="form-group"> <label> Pilihan Jurusan Ke-1</label>
                                <select name="jurusan1" id="jurusan1" class="form-control">
                                    <option value="TITL" {{ old('jurusan1') == 'TITL' ? 'selected' : '' }}>Teknik Instalasi Tenaga Listrik</option>
                                    <option value="TP" {{ old('jurusan1') == 'TP' ? 'selected' : '' }}>Teknik Pemesinan</option>
                                    <option value="TKR" {{ old('jurusan1') == 'TKR' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                                    <option value="TKJ" {{ old('jurusan1') == 'TKJ' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                                    <option value="RPL" {{ old('jurusan1') == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                    <option value="TBSM" {{ old('jurusan1') == 'TBSM' ? 'selected' : '' }}>Teknik Bisnis Sepeda Motor</option>
                                </select>
                            </div>
                            <div class="form-group"> <label> Pilihan Jurusan Ke-2</label>
                                <select name="jurusan2" id="jurusan2" class="form-control">
                                    <option value="TITL" {{ old('jurusan2') == 'TITL' ? 'selected' : '' }}>Teknik Instalasi Tenaga Listrik</option>
                                    <option value="TP" {{ old('jurusan2') == 'TP' ? 'selected' : '' }}>Teknik Pemesinan</option>
                                    <option value="TKR" {{ old('jurusan2') == 'TKR' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                                    <option value="TKJ" {{ old('jurusan2') == 'TKJ' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                                    <option value="RPL" {{ old('jurusan2') == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                    <option value="TBSM" {{ old('jurusan2') == 'TBSM' ? 'selected' : '' }}>Teknik Bisnis Sepeda Motor</option>
                                </select>
                            </div>
                            <div class="form-group position-relative">
                                <label><i class="fa fa-key"></i> Password</label>
                                <div class="form-group">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}" required>
                                    <span class="input-group-text bg-white" style="cursor: pointer;" onclick="togglePassword()">
                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                    </span>
                                    <small class="form-text text-muted" style="color: red;">
                                        Password minimal 8 karakter, dan harus mengandung huruf besar, huruf kecil, angka, dan simbol.
                                    </small>
                                </div>
                            </div>
                            <div class="form-group position-relative">
                                <label><i class="fa fa-key"></i> Ulangi Password</label>
                                <div class="form-group">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Password" value="{{ old('password_confirmation') }}" required>
                                    <span class="input-group-text bg-white" style="cursor: pointer;" onclick="togglePassword2()">
                                        <i class="fa fa-eye" id="togglePasswordIcon2"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group"> <label> Role</label>
                                <input type="text" name="role" class="form-control" value="Pendaftar" readonly>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                        <a href="/"><button type="button" class="btn btn-success btn-block">Kembali</button></a>
                        <hr>
                        <p class="text-center">Sudah punya akun silahkan <a href="/login"><button type="button" class="btn btn-info">Login Disini!</button></a></p>

                    </div>
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

    function togglePassword2() {
        const input = document.getElementById('password_confirmation');
        const icon = document.getElementById('togglePasswordIcon2');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
</script>
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const pw = document.getElementById('password').value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^])[A-Za-z\d@$!%*?&#^]{8,}$/;

        if (!regex.test(pw)) {
            e.preventDefault();
            alert('Password tidak memenuhi syarat keamanan. Harus terdiri dari huruf besar, kecil, angka, dan simbol, minimal 8 karakter.');
        }
    });
</script>

</html>