<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('executives', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ชื่อ-นามสกุลผู้บริหาร');
            $table->string('position')->comment('ตำแหน่ง เช่น สาธารณสุขอำเภอ');
            $table->string('image_path')->nullable()->comment('รูปโปรไฟล์ผู้บริหาร');
            $table->integer('sort_order')->default(0)->comment('ลำดับการแสดงผล');
            $table->boolean('is_active')->default(true)->comment('สถานะการแสดงผล');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('executives');
    }
};
