<?php
use App\Models\Album;
use App\Models\Complaint;
use App\Models\Activity;
use App\Models\Executive;
use App\Models\HeroSlide;
use App\Models\Shortcut;
use App\Models\OurService;
use App\Models\HealthOffice;
use App\Models\SiteSetting;
use App\Models\SiteVisitor;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\SiteInfoController;
use App\Http\Controllers\Admin\ShortcutController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Site\ComplaintController;
use App\Http\Controllers\Admin\PublicityController;
use App\Http\Controllers\Admin\OurServiceController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\SubordinateUnitController;
use App\Http\Controllers\Site\OrganizationPageController;


/*
|--------------------------------------------------------------------------
| Public Website Routes (หน้าเว็บไซต์สำหรับประชาชนและผู้เยี่ยมชม)
|--------------------------------------------------------------------------
*/
Route::view('/privacy-policy', 'site.privacy-policy')->name('privacy-policy');

// หน้าหลัก (ดึงข้อมูลสไลด์, ผู้บริหารปัจจุบัน, ทางลัด และข่าวล่าสุดจากฐานข้อมูล)
Route::get('/', function (Request $request) {
    SiteVisitor::recordVisit($request);

    $slides = HeroSlide::where('is_active', true)
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->get();

    $executives = Executive::where('is_active', true)
        ->where(function ($query) {
            $query->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', now()->toDateString());
        })
        ->orderBy('sort_order')
        ->orderBy('id')
        ->take(2)
        ->get();

    $shortcuts = Shortcut::where('is_active', true)
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->get();

    $activities = Activity::where('is_active', true)
        ->orderByDesc('is_pinned')
        ->orderByDesc('published_date')
        ->orderByDesc('id')
        ->get();

    $albums = Album::withCount('photos')
        ->with('photos')
        ->where('is_active', true)
        ->orderByDesc('activity_date')
        ->orderByDesc('id')
        ->take(6)
        ->get();

    // ดึงข้อมูลบริการของเราที่เปิดใช้งาน เรียงตามลำดับที่กำหนด
    $services = OurService::where('is_active', true)
        ->orderBy('sort_order')
        ->orderByDesc('id')
        ->get();

    // 1. บันทึกสถิติผู้เข้าชมหน้าเว็บไซต์
    SiteVisitor::recordVisit($request);

    // 2. เงื่อนไขหน่วยงานภายใต้สังกัดตามที่ตั้งค่าไว้ในฐานข้อมูล
    $provinceCode    = SiteSetting::getValue('unit_filter_province_code', '34');
    $districtCode    = SiteSetting::getValue('unit_filter_district_code', '3421');
    $orgType         = SiteSetting::getValue('unit_filter_org_type', 'รัฐบาล');
    $serviceUnitType = SiteSetting::getValue('unit_filter_service_unit_type', '');

    $unitCount = HealthOffice::whereNull('closed_date')
        ->when($provinceCode !== '', fn($q) => $q->where('province_code', $provinceCode))
        ->when($districtCode !== '', fn($q) => $q->where('district_code', $districtCode))
        ->when($orgType !== '', fn($q) => $q->where('org_type', $orgType))
        ->when($serviceUnitType !== '', fn($q) => $q->where('service_unit_type', $serviceUnitType))
        ->count();

    // 3. ข้อมูลสถิติการให้บริการ 4 หัวข้อ
    $serviceStats = [
        'today_visitors'   => SiteVisitor::todayCount(),
        'total_visitors'   => SiteVisitor::totalCount(),
        'service_units'    => $unitCount,
        'total_complaints' => Complaint::count(),
    ];

    return view('home', compact('slides', 'executives', 'shortcuts', 'activities', 'albums', 'services', 'serviceStats'));
})->name('home');


// เกี่ยวกับองค์กร
Route::get('/organization', function () {
    return view('site.organization');
})->name('organization');

// ข่าวกิจกรรม & ประกาศ
Route::get('/activities', function () {
    $activities = Activity::where('is_active', true)
        ->orderByDesc('is_pinned')
        ->orderByDesc('published_date')
        ->orderByDesc('id')
        ->get();

    return view('site.activities', compact('activities'));
})->name('activities');

Route::get('/activities/all', function () {
    $activities = Activity::where('is_active', true)
        ->orderByDesc('is_pinned')
        ->orderByDesc('published_date')
        ->orderByDesc('id')
        ->paginate(12);

    return view('site.activities-all', compact('activities'));
})->name('activities.all');

// หน้าหน่วยงานภายใต้สังกัด (ฝั่งประชาชน)
Route::get('/subordinate-units', function () {
    $provinceCode    = SiteSetting::getValue('unit_filter_province_code', '34');
    $districtCode    = SiteSetting::getValue('unit_filter_district_code', '3421');
    $orgType         = SiteSetting::getValue('unit_filter_org_type', 'รัฐบาล');
    $serviceUnitType = SiteSetting::getValue('unit_filter_service_unit_type', '');

    $units = HealthOffice::whereNull('closed_date')
        ->when($provinceCode !== '', fn($q) => $q->where('province_code', $provinceCode))
        ->when($districtCode !== '', fn($q) => $q->where('district_code', $districtCode))
        ->when($orgType !== '', fn($q) => $q->where('org_type', $orgType))
        ->when($serviceUnitType !== '', fn($q) => $q->where('service_unit_type', $serviceUnitType))
        ->orderBy('service_unit_type')
        ->orderBy('hospcode5')
        ->orderBy('name')
        ->get();

    // สรุปจำนวนแยกตามประเภทหน่วยบริการสุขภาพสำหรับปุ่มตัวกรอง
    $unitTypes = $units->pluck('service_unit_type')->filter()->unique()->values();

    return view('site.subordinate-units', compact('units', 'unitTypes', 'orgType'));
})->name('subordinate-units');

// เอกสารเผยแพร่ (List Menu Layout)
Route::get('/documents', function () {
    return view('site.documents');
})->name('documents');

// ลิงก์ภายในและระบบสารสนเทศ
Route::get('/internal-links', function () {
    return view('site.internal-links');
})->name('internal-links');

// รับเรื่องร้องเรียนจากประชาชน (หน้าเว็บสำหรับประชาชน)
Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

// หน้าข้อมูลเกี่ยวกับองค์กร (Organization Page) - สำหรับประชาชน
Route::get('/organization', [OrganizationPageController::class, 'index'])->name('organization');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Login -> CheckLogin -> AdminDashboard & Register)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'checkLogin'])->name('login.check');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Dashboard & Management Routes (เฉพาะเจ้าหน้าที่ที่ Login แล้วเท่านั้น)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // แผงควบคุมหลัก
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');

    // 1. จัดการส่วนประชาสัมพันธ์ (ภาพสไลด์ Hero Slideshow & ผู้บริหารองค์กร Executives)
    Route::get('/publicity', [PublicityController::class, 'index'])->name('publicity.index');

    Route::post('/publicity/slides', [PublicityController::class, 'storeSlide'])->name('publicity.slides.store');
    Route::put('/publicity/slides/{slide}', [PublicityController::class, 'updateSlide'])->name('publicity.slides.update');
    Route::delete('/publicity/slides/{slide}', [PublicityController::class, 'destroySlide'])->name('publicity.slides.destroy');

    Route::post('/publicity/executives', [PublicityController::class, 'storeExecutive'])->name('publicity.executives.store');
    Route::put('/publicity/executives/{executive}', [PublicityController::class, 'updateExecutive'])->name('publicity.executives.update');
    Route::delete('/publicity/executives/{executive}', [PublicityController::class, 'destroyExecutive'])->name('publicity.executives.destroy');

    // 2. จัดการทางลัดข้อมูลที่น่าสนใจ (Shortcuts)
    Route::get('/shortcuts', [ShortcutController::class, 'index'])->name('shortcuts.index');
    Route::post('/shortcuts', [ShortcutController::class, 'store'])->name('shortcuts.store');
    Route::put('/shortcuts/{shortcut}', [ShortcutController::class, 'update'])->name('shortcuts.update');
    Route::delete('/shortcuts/{shortcut}', [ShortcutController::class, 'destroy'])->name('shortcuts.destroy');

    // 3. จัดการข่าวประชาสัมพันธ์ (Activities / News)
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

    // ภายในกลุ่ม middleware('auth')->prefix('admin')->name('admin.')
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');
    Route::put('/albums/{album}', [AlbumController::class, 'update'])->name('albums.update');
    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');

    Route::post('/albums/{album}/photos', [AlbumController::class, 'uploadPhotos'])->name('albums.photos.upload');
    Route::patch('/albums/{album}/photos/{photo}/cover', [AlbumController::class, 'setCover'])->name('albums.photos.cover');
    Route::delete('/albums/{album}/photos/{photo}', [AlbumController::class, 'destroyPhoto'])->name('albums.photos.destroy');

    // หน้าจัดการบริการขององค์กร (Our Services)
    Route::get('/services', [OurServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [OurServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [OurServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [OurServiceController::class, 'destroy'])->name('services.destroy');

    // จัดการหน่วยงานภายใต้สังกัด
    Route::get('/units', [SubordinateUnitController::class, 'index'])->name('units.index');
    Route::post('/units', [SubordinateUnitController::class, 'store'])->name('units.store');
    Route::post('/units/settings', [SubordinateUnitController::class, 'saveFilterSettings'])->name('units.settings'); // <--- เพิ่มบรรทัดนี้
    Route::put('/units/{unit}', [SubordinateUnitController::class, 'update'])->name('units.update');
    Route::delete('/units/{unit}', [SubordinateUnitController::class, 'destroy'])->name('units.destroy');

    // จัดการข้อมูลเว็บไซต์ (Site Information)
    Route::get('/site-info', [SiteInfoController::class, 'index'])->name('site-info.index');
    Route::put('/site-info', [SiteInfoController::class, 'update'])->name('site-info.update');

    // จัดการข้อมูลองค์กร
    Route::prefix('organization')->name('organization.')->group(function () {
        Route::get('/', [OrganizationController::class, 'index'])->name('index');

        // หมวดที่ 1: เนื้อหาและรูปภาพ 4 เมนูย่อย
        Route::post('/content/{sectionKey}', [OrganizationController::class, 'saveContent'])->name('content.save');

        // หมวดที่ 2: ข้อมูลผู้บริหาร (List Group)
        Route::post('/executives', [OrganizationController::class, 'storeExecutive'])->name('executives.store');
        Route::put('/executives/{executive}', [OrganizationController::class, 'updateExecutive'])->name('executives.update');
        Route::delete('/executives/{executive}', [OrganizationController::class, 'destroyExecutive'])->name('executives.destroy');

        // หมวดที่ 3: ข้อมูลเจ้าหน้าที่ (Priority กลุ่มงาน)
        Route::post('/staffs', [OrganizationController::class, 'storeStaff'])->name('staffs.store');
        Route::put('/staffs/{staff}', [OrganizationController::class, 'updateStaff'])->name('staffs.update');
        Route::delete('/staffs/{staff}', [OrganizationController::class, 'destroyStaff'])->name('staffs.destroy');

        // หมวดที่ 4: อัปเดตเวลาทำการและแผนที่ลง SiteSetting
        Route::post('/contact-map', [OrganizationController::class, 'updateContactMap'])->name('contact.save');

    });

    // ภายใน Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        // });

});

Route::middleware(['auth', 'approved'])->prefix('admin')->name('admin.')->group(function () {

    // 1. หน้าแดชบอร์ด (เข้าได้ทุกสิทธิ์ที่อนุมัติแล้ว: user, editor, admin)
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');

    // 2. เมนูที่ user, editor, admin ใช้งานได้: ประชาสัมพันธ์ & อัลบั้มกิจกรรม
    Route::middleware('menu:news')->group(function () {
        // Route ประชาสัมพันธ์ (news) ของเดิมวางในกลุ่มนี้
    });

    Route::middleware('menu:albums')->group(function () {
        // Route อัลบั้มกิจกรรม (albums) ของเดิมวางในกลุ่มนี้
    });

    // 3. เมนูที่ editor และ admin ใช้งานได้ (user เข้าไม่ได้)
    Route::middleware('menu:general')->group(function () {
        // Route ข้อมูลพื้นฐานเว็บไซต์, ข้อมูลองค์กร, ITA ฯลฯ ของเดิมวางในกลุ่มนี้
    });

    // 4. เมนูจัดการผู้ใช้งาน (เฉพาะ admin เท่านั้น)
    Route::middleware('menu:users')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});



