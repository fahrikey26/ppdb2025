@extends('layout.master')
@section('konten')
<link rel="icon" type="image/png" href="img/logo.png">
<div class="container">
    <h3 class="mb-4">Daftar Murid Baru yang Diterima per Jurusan</h3>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <select name="jurusan" class="form-control" onchange="this.form.submit()">
                <option value="">-- Pilih Jurusan --</option>
                @foreach(array_keys($diterima) as $key)
                    <option value="{{ $key }}" {{ request('jurusan') == $key ? 'selected' : '' }}>{{ $key }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 offset-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode pendaftaran" value="{{ request('search') }}">
        </div>
    </form>

    @php
        $jurusan = request('jurusan');
        $search = request('search');
        $siswaList = collect();

        if ($jurusan && isset($diterima[$jurusan])) {
            $siswaList = $diterima[$jurusan];

            if ($search) {
                $siswaList = $siswaList->filter(function($item) use ($search) {
                    return str_contains(strtolower($item->nama), strtolower($search)) || str_contains(strtolower($item->kodependaftaran), strtolower($search));
                });
            }

            $perPage = 10;
            $currentPage = request()->get('page', 1);
            $pagedData = $siswaList->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginator = new Illuminate\Pagination\LengthAwarePaginator($pagedData, $siswaList->count(), $perPage, $currentPage, [
                'path' => request()->url(),
                'query' => request()->query()
            ]);
        }
    @endphp

    @if ($jurusan && isset($diterima[$jurusan]))
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
                    @forelse ($paginator as $i => $siswa)
                    <tr>
                        <td>{{ ($paginator->currentPage() - 1) * $paginator->perPage() + $i + 1 }}</td>
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
            <div class="d-flex justify-content-center">
                {{ $paginator->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @elseif($jurusan)
        <div class="alert alert-warning">Tidak ada data untuk jurusan yang dipilih.</div>
    @endif
</div>
@endsection
