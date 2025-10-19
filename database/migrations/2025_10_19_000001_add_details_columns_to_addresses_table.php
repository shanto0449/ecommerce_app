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
            // Add columns only if they don't already exist to be idempotent
            if (!Schema::hasColumn('addresses', 'name')) {
                $table->string('name')->after('isdefault');
            }
            if (!Schema::hasColumn('addresses', 'phone')) {
                $table->string('phone', 20)->after('name');
            }
            if (!Schema::hasColumn('addresses', 'zip')) {
                $table->string('zip', 20)->after('phone');
            }
            if (!Schema::hasColumn('addresses', 'state')) {
                $table->string('state')->after('zip');
            }
            if (!Schema::hasColumn('addresses', 'city')) {
                $table->string('city')->after('state');
            }
            if (!Schema::hasColumn('addresses', 'address')) {
                $table->string('address')->after('city');
            }
            if (!Schema::hasColumn('addresses', 'locality')) {
                $table->string('locality')->after('address');
            }
            if (!Schema::hasColumn('addresses', 'landmark')) {
                $table->string('landmark')->nullable()->after('locality');
            }
            if (!Schema::hasColumn('addresses', 'country')) {
                $table->string('country')->after('landmark');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('addresses', 'country')) {
                $table->dropColumn('country');
            }
            if (Schema::hasColumn('addresses', 'landmark')) {
                $table->dropColumn('landmark');
            }
            if (Schema::hasColumn('addresses', 'locality')) {
                $table->dropColumn('locality');
            }
            if (Schema::hasColumn('addresses', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('addresses', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('addresses', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('addresses', 'zip')) {
                $table->dropColumn('zip');
            }
            if (Schema::hasColumn('addresses', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('addresses', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};
