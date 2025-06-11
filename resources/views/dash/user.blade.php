@extends('layout.master')
@section('konten')
<link rel="icon" type="image/png" href="img/logo.png">
<div class="container-fluid">

    @if(session('message'))
    <div class="alert alert-success m-3"> {{session('message')}} </div>
    @endif
    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ url()->current() }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau email atau role ..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center shadow-sm px-4 py-3 border-0">
                <h5 class="mb-0 text-primary fw-semibold">
                    <i class="bi bi-people-fill me-2"></i> Data User
                </h5>
                <button class="btn btn-outline-primary btn-sm shadow rounded-pill d-flex align-items-center gap-2 px-3" data-bs-toggle="modal" data-bs-target="#ModalTambahUser">
                    <i class="bi bi-person-plus-fill fs-6"></i>
                    <span>Tambah User</span>
                </button>
            </div>

            <div class="table-responsive card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th class="text-center">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->email }}</td>
                            <td><span class="badge bg-info">{{ $p->role }}</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#ModalUpdateUser{{ $p->id }}">
                                    <i class="bi bi-pencil-square"></i> Update
                                </button>
                                @if(Auth::user()->role == 'Admin')
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#ModalDeleteUser{{ $p->id }}">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                                @endif
                            </td>
                        </tr>
                        <!-- Ini tampil form update user -->
                        <div class="modal fade" id="ModalUpdateUser{{ $p->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update User</h1>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                    </div>
                                    <div class="modal-body">
                                        <form action="/user/storeupdate" method="post" class="form-floating">
                                            @csrf
                                            <input type="hidden" name="id" class="form-control" value="{{ $p->id }}">
                                            <div class="form-floating p-1">
                                                <input type="text" name="name" required="required" class="form-control" value="{{ $p->name }}">
                                                <label for="floatingInputValue">Nama</label>
                                            </div>
                                            <div class="form-floating p-1">

                                                <input type="email" name="email" required="required" class="form-control" value="{{ $p->email }}">

                                                <label for="floatingInputValue">Email</label>
                                            </div>
                                            <div class="form-floating p-1">
                                                <input type="password" name="password" class="form-control">
                                                <label for="floatingInputValue">Password <b>(*Jika kosong maka menggunakan password lama*)</b></label>
                                            </div>
                                            <div class="form-floating p-1">
                                                <select name="role" class="form-control">
                                                    <option value="petugas" @if($p->role =='petugas') selected="selected" @endif>Petugas</option>
                                                    <option value="admin" @if($p->role =='admin') selected="selected" @endif>Admin</option>
                                                </select>

                                                <label for="floatingInputValue">Status</label>
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
                        <div class="modal fade" id="ModalDeleteUser{{$p->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus User</h1>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                    </div>
                                    <div class="modal-body">
                                        <form action="/user/delete/{{$p->id}}" method="get" class="form-floating">
                                            @csrf
                                            <div>
                                                <h3>Yakin mau menghapus data <b>{{$p->name}}</b> ?</h3>
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
            {{ $user->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <!-- Ini tampil form tambah user -->
    <div class="modal fade" id="ModalTambahUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah User</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form action="/user/storeinput" method="post" class="form-floating">
                        @csrf
                        <div class="form-floating p-1">
                            <input type="text" name="name" required="required" class="form-control">
                            <label for="floatingInputValue">Nama</label>
                        </div>
                        <div class="form-floating p-1">
                            <input type="email" name="email" required="required" class="form-control">
                            <label for="floatingInputValue">Email</label>
                        </div>
                        <div class="form-floating p-1">

                            <input type="password" name="password" required="required" class="form-control">

                            <label for="floatingInputValue">Password</label>
                        </div>
                        <div class="form-floating p-1">
                            <select name="role" class="form-control">
                                <option value="Petugas">Petugas</option>
                                <option value="Admin">Admin</option>
                            </select>
                            <label for="floatingInputValue">Status</label>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection