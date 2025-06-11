<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;

class PendaftarCon extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Petugas') {
            $search = $request->input('search');

            $pendaftar = Pendaftar::where(function ($query) use ($search) {
                $query->where('nama', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('asalsekolah', 'like', "%$search%")
                    ->orWhere('jeniskelamin', 'like', "%$search%")
                    ->orWhere('jurusan1', 'like', "%$search%")
                    ->orWhere('jurusan2', 'like', "%$search%");
            })->paginate(5);

            //return view('dash.pendaftar', compact('pendaftar', 'search'));
        } else {
            //$pendaftar = Pendaftar::where('user_id', Auth::user()->id);
            //dd($pendaftar);
            $pendaftar = Pendaftar::where(function ($query) {
                $query->where('user_id', 'like', Auth::user()->id);
            })->paginate(1);
        }

        return view('dash.pendaftar', ['pendaftar' => $pendaftar]);
    }

    public function nominasi()
    {
        $jurusanList = ['TITL', 'TP', 'TKR', 'TKJ', 'RPL', 'TBSM'];

        $pendaftarPerJurusan = [];

        foreach ($jurusanList as $jurusan) {
            $pendaftar = \App\Models\Pendaftar::where('jurusan1', $jurusan)
                ->orWhere('jurusan2', $jurusan)
                ->orderByDesc('nilairata')
                ->get();

            $jumlahPilihan1 = \App\Models\Pendaftar::where('jurusan1', $jurusan)->count();
            $jumlahPilihan2 = \App\Models\Pendaftar::where('jurusan2', $jurusan)->count();

            $pendaftarPerJurusan[$jurusan] = [
                'list' => $pendaftar,
                'jumlah' => $pendaftar->count(),
                'pilihan1' => $jumlahPilihan1,
                'pilihan2' => $jumlahPilihan2,
            ];
        }

        return view('dash.nominasi', compact('pendaftarPerJurusan'));
    }

    public function diterima()
    {
        $jurusanList = ['TITL', 'TP', 'TKR', 'TKJ', 'RPL', 'TBSM'];

        $diterima = []; // Hasil akhir siswa per jurusan
        $kuotaTerpakai = [];
        $sudahMasuk = [];

        // Inisialisasi struktur data
        foreach ($jurusanList as $jurusan) {
            $diterima[$jurusan] = collect();
            $kuotaTerpakai[$jurusan] = 0;
        }


        // Ambil semua siswa, urut nilai dari tinggi ke rendah
        $semua = \App\Models\Pendaftar::orderByDesc('nilairata')->get();


        foreach ($semua as $siswa) {
            if (in_array($siswa->id, $sudahMasuk)) {
                continue;
            }

            $j1 = $siswa->jurusan1;
            $j2 = $siswa->jurusan2;

            if ($j1 == 'TITL' || $j1 == 'TP' || $j2 == 'TITL' || $j2 == 'TP') {
                $kapasitasPerJurusan = 36;
            } elseif ($j1 == 'TKR' || $j1 == 'TKJ' || $j1 == 'RPL' || $j1 == 'TBSM' || $j2 == 'TKR' || $j2 == 'TKJ' || $j2 == 'RPL' || $j2 == 'TBSM') {
                $kapasitasPerJurusan = 72;
            }

            // Cek jurusan 1
            if ($kuotaTerpakai[$j1] < $kapasitasPerJurusan) {
                $siswa->diterima_di = $j1 . ' (Pilihan 1)';
                $diterima[$j1]->push($siswa);
                $kuotaTerpakai[$j1]++;
                $sudahMasuk[] = $siswa->id;
                continue;
            }

            // Cek jurusan 2 jika belum diterima
            if ($kuotaTerpakai[$j2] < $kapasitasPerJurusan) {
                $siswa->diterima_di = $j2 . ' (Pilihan 2)';
                $diterima[$j2]->push($siswa);
                $kuotaTerpakai[$j2]++;
                $sudahMasuk[] = $siswa->id;
            }
        }

        return view('dash.diterima', compact('diterima'));
    }

    public function jurusan(Request $request)
    {
        $semuaJurusan = Pendaftar::select('jurusan1')->distinct()->pluck('jurusan1')->toArray();
        $selectedJurusan = $request->jurusan ?? $semuaJurusan[0] ?? null;
        $search = $request->search;

        // Query dasar untuk paginate
        $queryPaginate = Pendaftar::where(function ($q) use ($selectedJurusan) {
            $q->where('jurusan1', $selectedJurusan)
                ->orWhere('jurusan2', $selectedJurusan);
        });

        if ($search) {
            $queryPaginate->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('kodependaftaran', 'like', "%$search%")
                    ->orWhere('asalsekolah', 'like', "%$search%");
            });
        }

        $list = $queryPaginate->orderByDesc('nilairata')->paginate(10)->withQueryString();

        // Hitung jumlah total, pilihan1, pilihan2 secara terpisah dari awal tanpa paginasi
        $queryCount = Pendaftar::query()->where(function ($q) use ($selectedJurusan) {
            $q->where('jurusan1', $selectedJurusan)
                ->orWhere('jurusan2', $selectedJurusan);
        });

        $jumlah = (clone $queryCount)->count();
        $pilihan1 = (clone $queryCount)->where('jurusan1', $selectedJurusan)->count();
        $pilihan2 = (clone $queryCount)->where('jurusan2', $selectedJurusan)->count();

        $pendaftarPerJurusan[$selectedJurusan] = [
            'jumlah' => $jumlah,
            'pilihan1' => $pilihan1,
            'pilihan2' => $pilihan2,
            'list' => $list
        ];

        return view('dash.nominasi', [
            'semuaJurusan' => $semuaJurusan,
            'selectedJurusan' => $selectedJurusan,
            'pendaftarPerJurusan' => $pendaftarPerJurusan
        ]);
    }


    public function statusPenerimaan()
    {
        $jurusanList = ['TITL', 'TP', 'TKR', 'TKJ', 'RPL', 'TBSM'];

        $diterima = []; // Hasil akhir siswa per jurusan
        $kuotaTerpakai = [];
        $sudahMasuk = [];

        // Inisialisasi struktur data
        foreach ($jurusanList as $jurusan) {
            $diterima[$jurusan] = collect();
            $kuotaTerpakai[$jurusan] = 0;
        }


        // Ambil semua siswa, urut nilai dari tinggi ke rendah
        $semua = \App\Models\Pendaftar::orderByDesc('nilairata')->get();


        foreach ($semua as $siswa) {
            if (in_array($siswa->id, $sudahMasuk)) {
                continue;
            }

            $j1 = $siswa->jurusan1;
            $j2 = $siswa->jurusan2;

            if ($j1 == 'TITL' || $j1 == 'TP' || $j2 == 'TITL' || $j2 == 'TP') {
                $kapasitasPerJurusan = 36;
            } elseif ($j1 == 'TKR' || $j1 == 'TKJ' || $j1 == 'RPL' || $j1 == 'TBSM' || $j2 == 'TKR' || $j2 == 'TKJ' || $j2 == 'RPL' || $j2 == 'TBSM') {
                $kapasitasPerJurusan = 72;
            }

            // Cek jurusan 1
            if ($kuotaTerpakai[$j1] < $kapasitasPerJurusan) {
                $siswa->diterima_di = $j1 . ' (Pilihan 1)';
                $diterima[$j1]->push($siswa);
                $kuotaTerpakai[$j1]++;
                $sudahMasuk[] = $siswa->id;
                continue;
            }

            // Cek jurusan 2 jika belum diterima
            if ($kuotaTerpakai[$j2] < $kapasitasPerJurusan) {
                $siswa->diterima_di = $j2 . ' (Pilihan 2)';
                $diterima[$j2]->push($siswa);
                $kuotaTerpakai[$j2]++;
                $sudahMasuk[] = $siswa->id;
            }
        }

        // 🔍 Ambil data user yang sedang login
        $userId = Auth::id();
        $pendaftar = \App\Models\Pendaftar::where('user_id', $userId)->first();

        $hasilSiswa = null;
        $urutan = null;

        if ($pendaftar) {
            $jurusanPendaftar = $pendaftar->jurusan1;
            $ranking = $diterima[$jurusanPendaftar];

            // Cek apakah dia diterima di jurusan 1
            $ranking1 = $diterima[$pendaftar->jurusan1] ?? collect();
            $pos1 = $ranking1->search(fn($item) => $item->id == $pendaftar->id);

            if ($pos1 !== false) {
                $hasilSiswa = $pendaftar->jurusan1 . ' (Pilihan 1)';
                $urutan = $pos1 + 1;
            } else {
                $ranking2 = $diterima[$pendaftar->jurusan2] ?? collect();
                $pos2 = $ranking2->search(fn($item) => $item->id == $pendaftar->id);

                if ($pos2 !== false) {
                    $hasilSiswa = $pendaftar->jurusan2 . ' (Pilihan 2)';
                    $urutan = $pos2 + 1;
                }
            }
        }

        return view('dash.status', compact('pendaftar', 'hasilSiswa', 'urutan'));
    }


    public function update($id)
    {
        // mengambil data user berdasarkan id yang dipilih
        Pendaftar::where('id', $id)->first();
        // passing data user yang didapat ke view edit.blade.php
        return redirect('/pendaftar/tampil');
    }

    public function storeupdate(Request $request)
    {
        $request->validate([
            'nilairata' => 'required|numeric|between:0,100',
        ], [
            'nilairata.numeric' => 'Nilai rata-rata harus berupa angka.',
            'nilairata.between' => 'Nilai harus antara 0 sampai 100.',
        ]);
        // update data user
        DB::beginTransaction();

        try {
            $pendaftar = Pendaftar::find($request->id);
            if ($pendaftar) {
                $pendaftar->nama = $request->nama;
                $pendaftar->tempatlahir = $request->tempatlahir;
                $pendaftar->tanggallahir = $request->tanggallahir;
                $pendaftar->jeniskelamin = $request->jeniskelamin;
                $pendaftar->email = $request->email;
                $pendaftar->nohp = $request->nohp;
                $pendaftar->alamat = $request->alamat;
                $pendaftar->asalsekolah = $request->asalsekolah;
                $pendaftar->nilairata = $request->nilairata;
                $pendaftar->jurusan1 = $request->jurusan1;
                $pendaftar->jurusan2 = $request->jurusan2;
                $pendaftar->updated_at = now()->format('Y-m-d H:i:s');
                $pendaftar->save();
            }
            // alihkan halaman ke halaman user
            DB::commit();
            return redirect('/pendaftar/tampil')->with('message', 'Update data berhasil!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Update gagal! Silakan coba lagi.')->withInput();
        }
    }

    public function delete($id)
    {
        $pendaftar = Pendaftar::findOrFail($id);

        // Hapus pendaftar
        $pendaftar->delete();

        // Hapus user yang terkait, jika ada
        User::where('id', $pendaftar->user_id)->delete();

        return redirect('/pendaftar/tampil')->with('message', 'Hapus data berhasil!');
    }
}
