<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('ชื่ออัลบั้มกิจกรรม');
            $table->text('description')->nullable()->comment('รายละเอียดกิจกรรม');
            $table->string('location')->nullable()->comment('สถานที่จัดกิจกรรม');
            $table->date('activity_date')->nullable()->comment('วันที่จัดกิจกรรม');
            $table->string('cover_image')->nullable()->comment('รูปภาพหน้าปกอัลบั้ม');
            $table->boolean('is_active')->default(true)->comment('สถานะการเผยแพร่');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
