<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop foreign key dulu
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        
        // Ubah user_id jadi nullable
        DB::statement('ALTER TABLE categories MODIFY user_id BIGINT UNSIGNED NULL');
        
        // Tambah foreign key lagi
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
        
        // Tambah kolom is_default (cek dulu apakah sudah ada)
        if (!Schema::hasColumn('categories', 'is_default')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->boolean('is_default')->default(false)->after('color');
            });
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'is_default')) {
                $table->dropColumn('is_default');
            }
            
            $table->dropForeign(['user_id']);
        });
        
        DB::statement('ALTER TABLE categories MODIFY user_id BIGINT UNSIGNED NOT NULL');
        
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }
};