@extends('layout.master')
@section('konten')
<link rel="icon" type="image/png" href="img/logo.png">
<div class="container">
    <h3 class="mb-4">Daftar Murid Baru yang Diterima per Jurusan</h3>

    @foreach ($diterima as $jurusan => $siswaList)
    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <strong>Jurusan: {{ $jurusan }}</strong>
            <small>
                Diterima: {{ $siswaList->count() }} /
                @php
                    $kuota = in_array($jurusan, ['TITL', 'TP']) ? 36 : 72;
                @endphp
                Sisa Kuota: {{ $kuota - $siswaList->count() }}
            </small>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Kode Pendaftaran</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Nilai</th>
                        <th>Asal Sekolah</th>
                        <th>Diterima di</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswaList as $i => $siswa)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $siswa->kodependaftaran }}</td>
                        <td>{{ $siswa->nisn }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->nilairata }}</td>
                        <td>{{ $siswa->asalsekolah }}</td>
                        <td>{{ $siswa->diterima_di }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada siswa diterima di jurusan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection