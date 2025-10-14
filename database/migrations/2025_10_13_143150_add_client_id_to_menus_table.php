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
    Schema::table('menus', function (Blueprint $table) {
        $table->unsignedBigInteger('client_id')->after('menu_name'); // sesuaikan posisi
        // Jika ingin foreign key ke clients
        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('menus', function (Blueprint $table) {
        $table->dropForeign(['client_id']);
        $table->dropColumn('client_id');
    });
}

};
