<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('healthoffice', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ชื่อ');
            $table->string('hospcode9_new', 9)->unique()->comment('รหัส 9 หลักใหม่');
            $table->string('hospcode9', 9)->nullable()->index()->comment('รหัส 9 หลัก');
            $table->string('hospcode5', 5)->nullable()->index()->comment('รหัส 5 หลัก');
            $table->string('license_no', 15)->nullable()->comment('เลขอนุญาตให้ประกอบสถานบริการสุขภาพ 11 หลัก');
            $table->string('org_type', 50)->nullable()->comment('ประเภทองค์กร');
            $table->string('service_unit_type', 150)->nullable()->comment('ประเภทหน่วยบริการสุขภาพ');
            $table->string('ministry', 150)->nullable()->comment('สังกัด');
            $table->string('department', 150)->nullable()->comment('แผนก/กรม');
            $table->string('hospital_level', 100)->nullable()->comment('ระดับโรงพยาบาล');
            $table->string('network_node_type', 100)->nullable()->comment('ประเภทลูกข่าย');
            $table->unsignedInteger('actual_beds')->nullable()->default(0)->comment('เตียงที่ใช้จริง');
            $table->string('usage_status', 50)->nullable()->comment('สถานะการใช้งาน');
            $table->string('health_region', 50)->nullable()->comment('เขตบริการ');
            $table->text('address')->nullable()->comment('ที่อยู่');
            $table->string('province_code', 2)->nullable()->index()->comment('รหัสจังหวัด');
            $table->string('province_name', 100)->nullable()->comment('จังหวัด');
            $table->string('district_code', 4)->nullable()->index()->comment('รหัสอำเภอ');
            $table->string('district_name', 100)->nullable()->comment('อำเภอ/เขต');
            $table->string('subdistrict_code', 6)->nullable()->index()->comment('รหัสตำบล');
            $table->string('subdistrict_name', 100)->nullable()->comment('ตำบล/แขวง');
            $table->string('moo', 10)->nullable()->comment('หมู่');
            $table->string('zipcode', 5)->nullable()->comment('รหัสไปรษณีย์');
            $table->string('parent_hospital')->nullable()->comment('แม่ข่าย');
            $table->date('established_date')->nullable()->comment('วันที่ก่อตั้ง');
            $table->date('closed_date')->nullable()->comment('วันที่ปิดบริการ');
            $table->dateTime('source_updated_at')->nullable()->comment('อัพเดตล่าสุด(เริ่ม 05/09/2566)');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('healthoffice');
    }
};
