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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reimbursment_id')->constrained('reimbursment')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->bigInteger('jumlah_dibayarkan');
            $table->string('metode_pembayaran', 50);
            $table->string('nomor_rekening')->nullable();
            $table->string('pemilik')->nullable();
            $table->enum('status_pembayaran', ['Lunas', 'Pending', 'Gagal'])->default('Pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
