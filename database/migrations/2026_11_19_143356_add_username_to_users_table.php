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
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username', 100)->unique()->nullable()->after('name');
            }
        });

        // กำหนด username เริ่มต้นให้บัญชีผู้ใช้งานเดิมที่ยังไม่มี username
        $users = DB::table('users')->whereNull('username')->get();
        foreach ($users as $user) {
            $baseUsername = $user->id === 1
                ? 'admin'
                : (explode('@', (string) $user->email)[0] ?: 'user' . $user->id);

            $username = $baseUsername;
            $suffix = 1;
            while (DB::table('users')->where('username', $username)->where('id', '!=', $user->id)->exists()) {
                $username = $baseUsername . $suffix++;
            }

            DB::table('users')->where('id', $user->id)->update([
                'username' => $username,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
