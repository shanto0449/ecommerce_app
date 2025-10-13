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
        Schema::table('addresses', function (Blueprint $table) {
            if (! Schema::hasColumn('addresses', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('id');
            }
            if (! Schema::hasColumn('addresses', 'isdefault')) {
                $table->boolean('isdefault')->default(false)->index()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'isdefault')) {
                $table->dropColumn('isdefault');
            }
            if (Schema::hasColumn('addresses', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
