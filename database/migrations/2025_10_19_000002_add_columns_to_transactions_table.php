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
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'user_id')) {
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->after('id');
            }
            if (!Schema::hasColumn('transactions', 'order_id')) {
                $table->foreignId('order_id')->constrained('orders')->onDelete('cascade')->after('user_id');
            }
            if (!Schema::hasColumn('transactions', 'mode')) {
                $table->enum('mode', ['cod', 'card', 'paypal'])->default('cod')->after('order_id');
            }
            if (!Schema::hasColumn('transactions', 'status')) {
                $table->enum('status', ['pending', 'approved', 'declined', 'refunded'])->default('pending')->after('mode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('transactions', 'mode')) {
                $table->dropColumn('mode');
            }
            if (Schema::hasColumn('transactions', 'order_id')) {
                $table->dropForeign(['order_id']);
                $table->dropColumn('order_id');
            }
            if (Schema::hasColumn('transactions', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
