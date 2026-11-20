<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('executives', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('position')->comment('วันที่เข้ารับตำแหน่ง');
            $table->date('end_date')->nullable()->after('start_date')->comment('วันที่สิ้นสุดการดำรงตำแหน่ง');
        });
    }

    public function down(): void
    {
        Schema::table('executives', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'end_date']);
        });
    }
};
