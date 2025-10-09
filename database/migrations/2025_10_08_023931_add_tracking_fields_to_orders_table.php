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
        Schema::table('orders', function (Blueprint $table) {
            // Tambah client_id setelah user_id
            if (!Schema::hasColumn('orders', 'client_id')) {
                $table->unsignedBigInteger('client_id')->nullable()->after('user_id');
            }

            // Tambah tracking_no setelah invoice_no
            if (!Schema::hasColumn('orders', 'tracking_no')) {
                $table->string('tracking_no')->nullable()->after('invoice_no');
            }

            // Tambah delivery fields setelah delivered_date
            if (!Schema::hasColumn('orders', 'delivery_notes')) {
                $table->text('delivery_notes')->nullable()->after('delivered_date');
            }

            if (!Schema::hasColumn('orders', 'courier_name')) {
                $table->string('courier_name')->nullable()->after('delivery_notes');
            }

            if (!Schema::hasColumn('orders', 'courier_phone')) {
                $table->string('courier_phone')->nullable()->after('courier_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = [
                'client_id',
                'tracking_no',
                'delivery_notes',
                'courier_name',
                'courier_phone'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
