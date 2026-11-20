<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shortcuts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('ชื่อทางลัดข้อมูลที่น่าสนใจ');
            $table->string('description')->nullable()->comment('คำอธิบายสั้นๆ');
            $table->string('url')->comment('ลิงก์ปลายทาง (URL หรือ Route)');
            $table->string('icon')->default('fa-solid fa-link')->comment('คลาสไอคอน Font Awesome');
            $table->string('color_theme')->default('indigo')->comment('โทนสีการ์ด เช่น indigo, emerald, blue, amber');
            $table->boolean('open_new_tab')->default(true)->comment('เปิดในแท็บใหม่หรือไม่');
            $table->integer('sort_order')->default(0)->comment('ลำดับการแสดงผล');
            $table->boolean('is_active')->default(true)->comment('สถานะการเผยแพร่');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shortcuts');
    }
};
