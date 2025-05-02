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
        Schema::table('notification', function (Blueprint $table) {
            $table->unsignedBigInteger('reimbursments_id')->nullable()->after('id'); // sesuaikan posisi jika perlu

            // Jika kamu ingin membuat foreign key:
            $table->foreign('reimbursments_id')->references('id')->on('reimbursments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropForeign(['reimbursments_id']);
            $table->dropColumn('reimbursments_id');
        });
    }
};
