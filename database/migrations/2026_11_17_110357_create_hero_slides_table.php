<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable()->comment('ป้ายกำกับหมวดหมู่ เช่น สุขภาพชุมชน');
            $table->string('title')->comment('หัวข้อหลักบนสไลด์');
            $table->string('subtitle')->nullable()->comment('คำอธิบายย่อย');
            $table->string('image_path')->comment('ที่อยู่ไฟล์รูปภาพ');
            $table->integer('sort_order')->default(0)->comment('ลำดับการแสดงผล');
            $table->boolean('is_active')->default(true)->comment('สถานะการเผยแพร่');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
