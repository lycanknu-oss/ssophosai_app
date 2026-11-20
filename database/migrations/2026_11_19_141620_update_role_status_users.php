<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 20)->default('user')->after('password'); // admin, editor, user
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status', 20)->default('waiting')->after('role'); // waiting, approved, suspended
            }
        });

        // ตั้งค่าบัญชีผู้ดูแลระบบเดิมที่มีอยู่แล้วให้เป็น admin และ approved
        DB::table('users')->where('id', 1)->update([
            'role'   => 'admin',
            'status' => 'approved',
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
    }
};
