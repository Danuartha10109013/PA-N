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
        Schema::create('reimbursment', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->bigInteger('nominal');
            $table->text('deskripsi')->nullable();
            $table->string('bukti');
            $table->string('surat_jalan');
            $table->foreignId('kategori_id')->constrained('kategori');
            $table->integer('status_pengajuan')->default(0);
            $table->foreignId('keuangan_user_id')->nullable()->constrained('users');
            $table->date('tanggal_persetujuan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reimbursment');
    }
};
