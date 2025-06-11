@extends('layout.master')
@section('konten')
<link rel="icon" type="image/png" href="img/logo.png">
<div class="container">
    <h3>Status Pendaftaran</h3>

    @if ($pendaftar)
        <div class="card">
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $pendaftar->nama }}</p>
                <p><strong>NISN:</strong> {{ $pendaftar->nisn }}</p>
                <p><strong>Nilai Rata-rata:</strong> {{ $pendaftar->nilairata }}</p>
                <p><strong>Pilihan 1:</strong> {{ $pendaftar->jurusan1 }}</p>
                <p><strong>Pilihan 2:</strong> {{ $pendaftar->jurusan2 }}</p>

                @if ($hasilSiswa)
                    <div class="alert alert-success">
                        🎉 Selamat! Anda <strong>DITERIMA</strong> di jurusan <strong>{{ $hasilSiswa }}</strong><br>
                        Anda berada pada urutan ke-<strong>{{ $urutan }}</strong> dalam kuota penerimaan.
                    </div>
                @else
                    <div class="alert alert-danger">
                        Maaf, Anda <strong>belum masuk</strong> dalam kuota penerimaan pada kedua jurusan pilihan.
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Data pendaftaran tidak ditemukan.
        </div>
    @endif
</div>
@endsection
