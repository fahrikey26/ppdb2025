<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use Session;

class RegisterCon extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function actionregister(Request $request)
    {
        $request->validate([
            'password' => [
            'required',
            'confirmed',
            Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(), // Ini akan cek apakah password pernah bocor secara publik
            ],
        ], [
            'password.confirmed' => 'Password tidak sama.',
        ]);

        $request->validate([
            'nilairata' => 'required|numeric|between:0,100',
        ], [
            'nilairata.numeric' => 'Nilai rata-rata harus berupa angka.',
            'nilairata.between' => 'Nilai harus antara 0 sampai 100.',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ]);

            $count = Pendaftar::count() + 1;
            $kodependaftaran = 'TKMT/2025/' . str_pad($count, 3, '0', STR_PAD_LEFT);

            // Simpan ke tabel pendaftar
            Pendaftar::create([
                'user_id' => $user->id,
                'nisn' => $request->nisn,
                'nama' => $request->nama,
                'tempatlahir' => $request->tempatlahir,
                'tanggallahir' => $request->tanggallahir,
                'jeniskelamin' => $request->jeniskelamin,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'nilairata' => $request->nilairata,
                'asalsekolah' => $request->asalsekolah,
                'jurusan1' => $request->jurusan1,
                'jurusan2' => $request->jurusan2,
                //'kodependaftaran' => $kodependaftaran,
                'kodependaftaran' => $request->kodependaftaran,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ]);
            
            DB::commit();
            return redirect()->back()->with('message', 'Pendaftaran berhasil! Anda pendaftar ke -'.$count);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Pendaftaran gagal! Silakan coba lagi.')->withInput();
        }
    }
}
