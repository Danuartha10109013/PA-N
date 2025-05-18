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
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reimbursments_id')->nullable();
            $table->string('title')->nullable();
            $table->string('value')->nullable();
            $table->string('status')->nullable();
            $table->string('pengirim')->nullable();
            $table->timestamps();

            $table->foreign('reimbursments_id')->references('id')->on('reimbursment')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
