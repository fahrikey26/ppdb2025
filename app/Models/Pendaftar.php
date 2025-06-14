<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;
    protected $fillable = ['nisn', 'nama', 'tempatlahir', 'tanggallahir', 'jeniskelamin', 'asalsekolah', 'email', 'alamat', 'nohp', 'nilairata', 'kodependaftaran', 'jurusan1', 'jurusan2', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
