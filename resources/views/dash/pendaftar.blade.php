@extends('layout.master')
@section('konten')
<link rel="icon" type="image/png" href="img/logo.png">
<style>
    .table-fixed {
        table-layout: fixed;
        width: 100%;
    }

    .col-kode {
        width: 120px;
    }

    .col-biodata {
        max-width: 200px;
        word-wrap: break-word;
    }

    .col-kontak {
        max-width: 300px;
        word-wrap: break-word;
    }

    .col-smp {
        width: 50px;
    }

    .col-nilai {
        width: 50px;
        text-align: center;
    }

    .col-jurusan {
        width: 50px;
        text-align: center;
    }

    .col-option {
        width: 130px;
        text-align: center;
    }
</style>
<div class="container-fluid">

    @if(session('message'))
    <div class="alert alert-success m-3"> {{session('message')}} </div>
    @endif
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ url()->current() }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau jenis kelamin atau asal sekolah atau jurusan ..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center shadow-sm px-4 py-3 border-0">
                <h5 class="mb-0 text-primary fw-semibold">
                    <i class="bi bi-people-fill me-2"></i> Data Pendaftar
                </h5>
            </div>

            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="col-kode">Kode Pendaftaran</th>
                            <th class="col-biodata">Biodata</th>
                            <th class="col-kontak">Kontak</th>
                            <th class="col-smp">Asal SMP</th>
                            <th class="col-nilai">Nilai Rerata</th>
                            <th class="col-jurusan">Pilihan 1</th>
                            <th class="col-jurusan">Pilihan 2</th>
                            @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Petugas')
                            <th class="col-option">Option</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftar as $p)
                        <tr>
                            <td class="col-kode">{{ $p->kodependaftaran }}</td>
                            <td class="col-biodata">
                                <ul>
                                    <li>{{ $p->nisn }}</li>
                                    <li>{{ $p->nama }}</li>
                                    <li>{!! $p->tempatlahir ? e($p->tempatlahir) : '<span class="text-danger">Update Tempat Lahir</span>' !!}</li>
                                    <li>{!! $p->tanggallahir ? e($p->tanggallahir) : '<span class="text-danger">Update Tanggal Lahir</span>' !!}</li>
                                    <li>{{ $p->jeniskelamin == 'L' ? 'Laki-Laki' : ($p->jeniskelamin == 'P' ? 'Perempuan' : 'Silahkan update') }}</li>
                                </ul>
                            </td>
                            <td class="col-kontak">
                                <ul>
                                    <li>{{ $p->email }}</li>
                                    <li>{{ $p->nohp }}</li>
                                    <li>{!! $p->alamat ? e($p->alamat) : '<span class="text-danger">Silahkan update</span>' !!}</li>
                                </ul>
                            </td>
                            <td class="col-smp"><span class="badge bg-info">{{ $p->asalsekolah }}</span></td>
                            <td class="col-nilai">{!! $p->nilairata ? e($p->nilairata) : '<span class="text-danger">Update Nilai Rerata</span>' !!}</td>
                            <td class="col-jurusan">{!! $p->jurusan1 ? e($p->jurusan1) : '<span class="text-danger">Update Pilihan 1</span>' !!}</td>
                            <td class="col-jurusan">{!! $p->jurusan2 ? e($p->jurusan2) : '<span class="text-danger">Update Pilihan 2</span>' !!}</td>
                            @if(Auth::user()->role != 'Pendaftar')
                            <td class="col-option">

                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#ModalUpdatePendaftar{{ $p->id }}">
                                    <i class="bi bi-pencil-square"></i> Update
                                </button>
                                @if(Auth::user()->role == 'Admin')
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ModalDeletePendaftar{{ $p->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                                @endif
                            </td>
                            @endif
                        </tr>
                        <!-- Ini tampil form update pendaftar -->
                        <div class="modal fade" id="ModalUpdatePendaftar{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Pendaftar</h1>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                    </div>
                                    <div class="modal-body">
                                        <form action="/pendaftar/storeupdate" method="post" class="form-floating">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="hidden" name="id" class="form-control" value="{{ $p->id }}">
                                                    <div class="form-floating p-1">
                                                        <input type="text" name="nisn" required class="form-control" value="{{ $p->nisn }}">
                                                        <label for="floatingInputValue">NISN</label>
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <input type="text" name="nama" required class="form-control" value="{{ $p->nama }}">
                                                        <label for="floatingInputValue">Nama</label>
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <input type="text" name="tempatlahir" class="form-control" value="{{ $p->tempatlahir }}" required>
                                                        <label><i class="fa fa-user"></i> Tempat Lahir</label>
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <input type="date" name="tanggallahir" class="form-control" value="{{ $p->tanggallahir }}" required>
                                                        <label><i class="fa fa-user"></i> Tanggal Lahir</label>
                                                    </div>
                                                    <div class="form-floating p-1form-group">
                                                        <select name="jeniskelamin" id="jeniskelamin" class="form-control">
                                                            <option value="L">Laki-Laki</option>
                                                            <option value="P">Perempuan</option>
                                                        </select>
                                                        <label><i class="fa fa-user"></i> Jenis Kelamin</label>
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <input type="text" name="asalsekolah" class="form-control" value="{{ $p->asalsekolah }}" required>
                                                        <label><i class="fa fa-user"></i> Asal Sekolah</label>
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <input type="email" name="email" class="form-control" value="{{ $p->email }}" required>
                                                        <label><i class="fa fa-envelope"></i> Email</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating p-1">
                                                        <textarea name="alamat" id="alamat" class="form-control" rows="10" cols="50" required>{{ $p->alamat }}</textarea>
                                                        <label><i class="fa fa-user"></i> Alamat</label>
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <input type="text" name="nohp" class="form-control" value="{{ $p->nohp }}" required>
                                                        <label><i class="fa fa-user"></i> No HP (Bisa WA)</label>
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <input type="number" name="nilairata" class="form-control @error('nilairata') is-invalid @enderror" value="{{ $p->nilairata }}" step="0.01" required oninvalid="this.setCustomValidity('Harap masukkan nilai angka desimal')" oninput="setCustomValidity('')">
                                                        <label><i class="fa fa-user"></i> Nilai Rata (Misal : 82.75)</label>
                                                        @error('nilairata')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <select name="jurusan1" id="jurusan1" class="form-control">
                                                            <option value="TITL" {{ $p->jurusan1 == 'TITL' ? 'selected' : '' }}>Teknik Instalasi Tenaga Listrik</option>
                                                            <option value="TP" {{ $p->jurusan1 == 'TP' ? 'selected' : '' }}>Teknik Pemesinan</option>
                                                            <option value="TKR" {{ $p->jurusan1 == 'TKR' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                                                            <option value="TKJ" {{ $p->jurusan1 == 'TKJ' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                                                            <option value="RPL" {{ $p->jurusan1 == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                                            <option value="TBSM" {{ $p->jurusan1 == 'TBSM' ? 'selected' : '' }}>Teknik Bisnis Sepeda Motor</option>
                                                        </select>
                                                        <label><i class="fa fa-user"></i> Pilihan Jurusan Ke-1</label>
                                                    </div>
                                                    <div class="form-floating p-1">
                                                        <select name="jurusan2" id="jurusan2" class="form-control">
                                                            <option value="TITL" {{ $p->jurusan2 == 'TITL' ? 'selected' : '' }}>Teknik Instalasi Tenaga Listrik</option>
                                                            <option value="TP" {{ $p->jurusan2 == 'TP' ? 'selected' : '' }}>Teknik Pemesinan</option>
                                                            <option value="TKR" {{ $p->jurusan2 == 'TKR' ? 'selected' : '' }}>Teknik Kendaraan Ringan</option>
                                                            <option value="TKJ" {{ $p->jurusan2 == 'TKJ' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                                                            <option value="RPL" {{ $p->jurusan2 == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                                            <option value="TBSM" {{ $p->jurusan2 == 'TBSM' ? 'selected' : '' }}>Teknik Bisnis Sepeda Motor</option>
                                                        </select>
                                                        <label><i class="fa fa-user"></i> Pilihan Jurusan Ke-2</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                <button type="submit" class="btn btn-primary">Save Updates</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ini tampil form delete user -->
                        <div class="modal fade" id="ModalDeletePendaftar{{$p->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Pendaftar</h1>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                    </div>
                                    <div class="modal-body">
                                        <form action="/pendaftar/delete/{{$p->id}}" method="get" class="form-floating">
                                            @csrf
                                            <div>
                                                <h3>Yakin mau menghapus data <b>{{$p->nama}}</b> ?</h3>
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                                <button type="submit" class="btn btn-primary">Yes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $pendaftar->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>

        <div class="card">
            <div class="card-body">
                <div class="alert alert-success">
                    🎉 Jika ada perbedaan data, silahkan hubungi admin sekolah untuk merubah data anda.
                </div>
            </div>
        </div>

    </div>

    @endsection