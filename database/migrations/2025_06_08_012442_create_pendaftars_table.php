<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->string('nama');
            $table->string('tempatlahir');
            $table->date('tanggallahir');
            $table->enum('jeniskelamin', ['L', 'P']);
            $table->string('asalsekolah');
            $table->string('email');
            $table->string('alamat');
            $table->string('nohp');
            $table->string('kodependaftaran');
            $table->enum('jurusan1', ['TITL', 'TP', 'TKR', 'TKJ', 'RPL', 'TBSM']);
            $table->enum('jurusan2', ['TITL', 'TP', 'TKR', 'TKJ', 'RPL', 'TBSM']);
            $table->float('nilairata', precision: 4);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
