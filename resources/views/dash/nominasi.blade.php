@extends('layout.master')
@section('konten')
<link rel="icon" type="image/png" href="img/logo.png">

<div class="container">
    <h3 class="mb-4">Daftar Murid Baru yang Mendaftar per Jurusan</h3>

    {{-- Filter Jurusan --}}
    <form method="GET" action="{{ route('nominasi2Pendaftar') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group"> <label> Pilih Jurusan</label>
                    <select name="jurusan" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach ($semuaJurusan as $jurusan)
                        <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>
                            {{ $jurusan }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>

    {{-- Tabel Data --}}
    @if($selectedJurusan && isset($pendaftarPerJurusan[$selectedJurusan]))
    @php
    $data = $pendaftarPerJurusan[$selectedJurusan];
    @endphp
    <div class="card mb-5">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h5 class="mb-1">{{ $selectedJurusan }}</h5>
                <small>
                    <strong>Total Pendaftar:</strong> {{ $data['jumlah'] }} |
                    <strong>Pilihan 1:</strong> {{ $data['pilihan1'] }} |
                    <strong>Pilihan 2:</strong> {{ $data['pilihan2'] }}
                </small>
            </div>
            <form action="{{ route('nominasi2Pendaftar') }}" method="GET" class="d-flex mt-3 mt-md-0" role="search">
                <input type="hidden" name="jurusan" value="{{ $selectedJurusan }}">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau no formulir..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Pendaftaran</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Asal Sekolah</th>
                        <th>Nilai Rata-rata</th>
                        <th>Jurusan 1</th>
                        <th>Jurusan 2</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['list'] as $i => $siswa)
                    <tr>
                        <td>{{ $data['list']->firstItem() + $i }}</td>
                        <td>{{ $siswa->kodependaftaran }}</td>
                        <td>{{ $siswa->nisn }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->asalsekolah }}</td>
                        <td>{{ number_format($siswa->nilairata, 2) }}</td>
                        <td>{{ $siswa->jurusan1 }}</td>
                        <td>{{ $siswa->jurusan2 }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada pendaftar untuk jurusan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <nav class="mt-3">
        <ul class="pagination pagination-sm justify-content-end">
            {{ $data['list']->links('pagination::bootstrap-5') }}
        </ul>
    </nav>
    @elseif($selectedJurusan)
    <div class="alert alert-warning">Data jurusan tidak ditemukan.</div>
    @endif
</div>
@endsection