<div align="center">

# 🏥 เว็บไซต์สำนักงานสาธารณสุขอำเภอโพธิ์ไทร
**Pho Sai District Public Health Office (`ssophosai-app`)**

ระบบเว็บไซต์ประชาสัมพันธ์ ข่าวสาร กิจกรรม บริการด้านสาธารณสุข และระบบสารสนเทศสำหรับประชาชนและเจ้าหน้าที่  
อำเภอโพธิ์ไทร จังหวัดอุบลราชธานี

![Laravel](https://img.shields.io/badge/Laravel-11.x%20%7C%2012.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Timezone](https://img.shields.io/badge/Timezone-Asia%2FBangkok-168d83?style=for-the-badge)

</div>

---

## ✨ ฟีเจอร์หลักของระบบ (Features)

- **Hero Slideshow & Popup Alert:** สไลด์ภาพประชาสัมพันธ์หลัก พร้อมหน้าต่างแจ้งเตือนข่าวสำคัญ (Glassmorphism Popup) ที่ตั้งเวลาแสดงซ้ำอัตโนมัติ
- **ทำเนียบผู้บริหารและโครงสร้างหน่วยงาน:** แสดงรายชื่อผู้บริหาร ข้อมูลหน่วยงานในสังกัด (รพ.สต.) และบุคลากร
- **ทางลัดข้อมูลและระบบบริการ (Shortcuts & Services):** ศูนย์รวมลิงก์ระบบสารสนเทศ บริการด้านสาธารณสุข และลิงก์ภายใน
- **ข่าวประชาสัมพันธ์ (Activities & News):** แยกหมวดหมู่ชัดเจน (ข่าวทั่วไป, ข่าวรับสมัครงาน, ข่าวจัดซื้อจัดจ้าง) พร้อมระบบปักหมุดและดาวน์โหลดเอกสารแนบ
- **อัลบั้มภาพกิจกรรม (Photo Albums):** ประมวลภาพกิจกรรมพร้อมหน้าต่าง Gallery Modal สำหรับเปิดดูภาพทั้งหมดในอัลบั้ม
- **ปฏิทินกิจกรรม (Google Calendar Integration):** เชื่อมต่อข้อมูลกำหนดการประชุม/อบรมจาก Google Calendar รองรับทั้งมุมมองรายเดือนและกำหนดการ
- **ศูนย์รับเรื่องร้องเรียนและสถิติบริการ:** ระบบรับเรื่องร้องเรียน/ข้อเสนอแนะ และแสดงผลสถิติผู้เข้าชมเว็บไซต์แบบเรียลไทม์

---

## 💻 การติดตั้งบนเครื่องพัฒนา (Local Development)

### 1. โคลนโปรเจกต์และติดตั้ง Dependencies
```bash
git clone https://github.com/lycanknu-oss/ssophosai_app.git
cd ssophosai_app

composer install
npm install
```

### 2. ตั้งค่าไฟล์สภาพแวดล้อม (`.env`)
```bash
cp .env.example .env
php artisan key:generate
```
เปิดไฟล์ `.env` แล้วปรับค่าพื้นฐานให้เรียบร้อย:
```env
APP_NAME="สำนักงานสาธารณสุขอำเภอโพธิ์ไทร"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Bangkok

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ssophosai_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. สร้างฐานข้อมูลและรันเซิร์ฟเวอร์
```bash
php artisan migrate --seed
php artisan storage:link
npm run dev
php artisan serve
```

---

## 🚀 คู่มือการอัปโหลดขึ้น Shared Hosting (แบบแยกโฟลเดอร์ `public` และ `vendor`)

เพื่อความปลอดภัยสูงสุดบน Shared Hosting (เช่น DirectAdmin หรือ cPanel) **ไม่ควรวางโฟลเดอร์ `vendor`, `.env` และโค้ดหลักของ Laravel ไว้ใน `public_html` โดยตรง** แต่ให้แยกไฟล์ระบบไว้ด้านนอก `public_html` ตามโครงสร้างด้านล่างนี้ครับ

### 📁 โครงสร้างโฟลเดอร์บน Server
```text
/home/your_username/
├── ssophosai_core/          <-- โค้ดหลักทั้งหมดของ Laravel (app, config, database, resources, routes, storage, vendor, .env)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/              <-- โฟลเดอร์ vendor อยู่ตรงนี้ (ปลอดภัยจากภายนอก)
│   └── .env
│
└── public_html/             <-- นำเฉพาะไฟล์ข้างในโฟลเดอร์ public/ ของ Laravel มาวางที่นี่
    ├── build/               (ไฟล์ CSS/JS ที่ Build จาก Vite)
    ├── images/
    ├── uploads/
    ├── .htaccess
    ├── favicon.ico
    └── index.php            <-- แก้ไข Path ให้ชี้ไปหา ssophosai_core/
```

---

### ขั้นตอนที่ 1: เตรียมไฟล์จากเครื่อง Local ก่อนอัปโหลด

1. **Build ไฟล์ Frontend (CSS/JS) สำหรับ Production:**
   ```bash
   npm run build
   ```
2. **ติดตั้ง Vendor สำหรับ Production (ลดขนาดไฟล์และเพิ่มความเร็ว):**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```
3. **บีบอัดไฟล์เป็น `.zip` แยกเป็น 2 ส่วน:**
   - `ssophosai_core.zip` : บีบอัดทุกโฟลเดอร์และไฟล์ในโปรเจกต์ **ยกเว้น** โฟลเดอร์ `public/` และ `node_modules/`
   - `public_files.zip` : เข้าไปข้างในโฟลเดอร์ `public/` แล้วเลือกไฟล์ทั้งหมดข้างในบีบอัดเป็น `.zip`

---

### ขั้นตอนที่ 2: อัปโหลดไฟล์ขึ้น Hosting

1. สร้างโฟลเดอร์ชื่อ `ssophosai_core` ไว้ในระดับเดียวกับ `public_html` (เช่น `/home/username/ssophosai_core`) แล้วแตกไฟล์ `ssophosai_core.zip` ลงไป
2. เข้าไปที่โฟลเดอร์ `public_html` (ล้างไฟล์เริ่มต้นของโฮสต์ออกก่อนหากไม่ได้ใช้) แล้วแตกไฟล์ `public_files.zip` ลงไป

---

### ขั้นตอนที่ 3: แก้ไข Path ในไฟล์ `public_html/index.php`

เปิดไฟล์ `public_html/index.php` แล้วแก้ไขตำแหน่งชี้ไปยัง `ssophosai_core` ทั้งหมด **3 จุด** ดังนี้:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. ตรวจสอบ Maintenance Mode
if (file_exists($maintenance = __DIR__.'/../ssophosai_core/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. โหลด Composer Autoloader จากโฟลเดอร์ vendor ภายนอก public_html
require __DIR__.'/../ssophosai_core/vendor/autoload.php';

// 3. บูตระบบ Laravel Application
$app = require_once __DIR__.'/../ssophosai_core/bootstrap/app.php';

// (สำคัญ) กำหนดให้ public_path() ของ Laravel ชี้กลับมาที่ public_html เสมอ
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
```

> **💡 เคล็ดลับสำคัญ:** บรรทัด `$app->usePublicPath(__DIR__);` จะช่วยให้ฟังก์ชัน `public_path()` ใน Laravel (เช่น เวลาอัปโหลดรูปภาพหรือไฟล์แนบผ่านระบบหลังบ้าน) บันทึกลงใน `public_html` ได้อย่างถูกต้องโดยไม่ต้องแก้โค้ดใน Controller

---

### ขั้นตอนที่ 4: ตั้งค่า `.env` และสิทธิ์โฟลเดอร์บน Server

1. **แก้ไขไฟล์ `/home/username/ssophosai_core/.env`:**
   ```env
   APP_NAME="สำนักงานสาธารณสุขอำเภอโพธิ์ไทร"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://ssophosai.in.th
   APP_TIMEZONE=Asia/Bangkok

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=ชื่อฐานข้อมูลบนโฮสต์
   DB_USERNAME=ชื่อผู้ใช้ฐานข้อมูล
   DB_PASSWORD=รหัสผ่านฐานข้อมูล
   ```

2. **ตั้งค่า Permission (CHMOD):**
   - โฟลเดอร์ `ssophosai_core/storage` และ `ssophosai_core/bootstrap/cache` ให้ตั้ง Permission เป็น **`775`** (หรือ `777` หากโฮสต์ไม่อนุญาตให้เขียนไฟล์)

3. **เชื่อมต่อ Storage Link (กรณีใช้งาน `storage/app/public`):**
   - หากมีสิทธิ์ใช้งาน SSH ให้รันคำสั่ง:
     ```bash
     ln -s /home/username/ssophosai_core/storage/app/public /home/username/public_html/storage
     ```
   - หากไม่มี SSH สามารถสร้างไฟล์ `link.php` ชั่วคราวใน `public_html` เพื่อรัน `symlink()` แล้วลบทิ้งทันทีหลังใช้งาน

4. **เคลียร์ Cache บน Production:**
   ```bash
   cd /home/username/ssophosai_core
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 🛠️ การอัปเดตโค้ดขึ้น Git

```bash
git add .
git commit -m "docs: add README with deployment guide"
git push origin main
```

---

<div align="center">
  <sub>พัฒนาเพื่อให้บริการข้อมูลข่าวสารด้านสาธารณสุข — สำนักงานสาธารณสุขอำเภอโพธิ์ไทร จังหวัดอุบลราชธานี</sub>
</div>
