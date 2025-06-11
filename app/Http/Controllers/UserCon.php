<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Session;

class UserCon extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role == 'Admin') {
            //$user = User::all();
            $search = $request->input('search');

        $user = User::where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('role', 'like', "%$search%");
        })->paginate(5);

        //return view('dash.user', compact('user', 'search'));
        } else {
            $user = User::find(Auth::user());
        }
        return view('dash.user', ['user' => $user]);
    }

    public function input()
    {
        return view('dash.tambahUser');
    }

    public function storeinput(Request $request)
    {
        // insert data ke table tbuser
        DB::beginTransaction();

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'created_at' => now()->format('Y-m-d H:i:s'),
            ]);
            DB::commit();
            return redirect()->back()->with('message', 'Input data berhasil!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Input gagal! Silakan coba lagi.')->withInput();
        }
    }

    public function update($id)
    {
        // mengambil data user berdasarkan id yang dipilih
        User::where('id', $id)->first();
        // passing data user yang didapat ke view edit.blade.php
        return redirect('/user/tampil');
    }

    public function storeupdate(Request $request)
    {
        // update data user
        DB::beginTransaction();

        try {
            $user = User::find($request->id);
            if (!empty($request->password)) {
                if ($user) {
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->password = Hash::make($request->password);
                    $user->role = $request->role;
                    $user->updated_at = now()->format('Y-m-d H:i:s');
                    $user->save();
                }
            } else {
                if ($user) {
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->role = $request->role;
                    $user->updated_at = now()->format('Y-m-d H:i:s');
                    $user->save();
                }
            }
            // alihkan halaman ke halaman user
            DB::commit();
            return redirect('/user/tampil')->with('message', 'Update data berhasil!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Update gagal! Silakan coba lagi.')->withInput();
        }
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Hapus pendaftar yang terkait, jika ada
        Pendaftar::where('user_id', $id)->delete();

        // Hapus pendaftar
        $user->delete();

        return redirect('/user/tampil')->with('message', 'Hapus data berhasil!');
    }
}
