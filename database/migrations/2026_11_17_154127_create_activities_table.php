<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('general')->comment('หมวดหมู่: general=ข่าวทั่วไป, recruitment=ข่าวรับสมัครงาน, procurement=ข่าวจัดซื้อจัดจ้าง');
            $table->string('title')->comment('หัวข้อข่าวประชาสัมพันธ์');
            $table->string('summary')->nullable()->comment('สรุปย่อ / คำโปรย');
            $table->longText('content')->nullable()->comment('รายละเอียดเนื้อหาข่าว');
            $table->string('cover_image')->nullable()->comment('รูปภาพหน้าปกข่าว');
            $table->string('attachment_path')->nullable()->comment('ไฟล์เอกสารแนบ (PDF/DOCX)');
            $table->date('published_date')->nullable()->comment('วันที่เผยแพร่ข่าว');
            $table->unsignedInteger('views')->default(0)->comment('จำนวนผู้เข้าชม');
            $table->boolean('is_pinned')->default(false)->comment('ปักหมุดข่าวเด่น');
            $table->boolean('is_active')->default(true)->comment('สถานะการเผยแพร่');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
