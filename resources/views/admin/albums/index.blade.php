@extends('admin.layouts.app')

@section('title', 'จัดการอัลบั้มกิจกรรม - Admin Dashboard')

@section('page-header')
    <div class="saas-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[11px] font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full mb-2">
                <i class="fa-solid fa-photo-film"></i> ACTIVITY GALLERY MANAGEMENT
            </span>
            <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                จัดการอัลบั้มกิจกรรม
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-1">
                สร้างอัลบั้มภาพกิจกรรม อัปโหลดภาพถ่ายหลายรายการ และจัดระเบียบคลังภาพของสำนักงานสาธารณสุขอำเภอโพธิ์ไทร
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 self-start sm:self-center shrink-0">
            <button type="button"
                    id="toggle-create-album-btn"
                    class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-4 cursor-pointer">
                <i class="fa-solid fa-folder-plus"></i>
                <span>สร้างอัลบั้มใหม่</span>
            </button>

            <a href="{{ route('activities') }}" target="_blank"
               class="inline-flex items-center gap-2 bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fa-solid fa-globe"></i>
                <span>ดูหน้าเว็บไซต์หลัก</span>
            </a>
        </div>
    </div>
@endsection

@section('content')
    @if($errors->any())
        <div class="saas-card p-4 !border-rose-200 !bg-rose-50 text-rose-700 text-xs space-y-1">
            <strong class="font-heading block mb-1"><i class="fa-solid fa-circle-exclamation mr-1"></i> พบข้อผิดพลาดในการบันทึกข้อมูล:</strong>
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- 1. แถบสรุปสถิติอัลบั้มกิจกรรม (KPI Cards) --}}
    @php
        $totalAlbums = $albums->total();
        $activeCount = \App\Models\Album::where('is_active', true)->count();
        $hiddenCount = \App\Models\Album::where('is_active', false)->count();
        $totalPhotos = \App\Models\AlbumPhoto::count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="saas-card p-4 flex items-center gap-3.5">
            <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#3126C9] to-[#1675E8] text-white grid place-items-center text-base shrink-0 saas-shadow-glow">
                <i class="fa-solid fa-photo-film"></i>
            </span>
            <div>
                <span class="block text-[11px] text-[#64748B]">อัลบั้มทั้งหมด</span>
                <strong class="text-xl font-heading font-bold text-[#1E293B]">{{ number_format($totalAlbums) }}</strong>
            </div>
        </div>

        <div class="saas-card p-4 flex items-center gap-3.5">
            <span class="w-11 h-11 rounded-2xl bg-emerald-50 text-[#13A678] border border-emerald-200/80 grid place-items-center text-base shrink-0">
                <i class="fa-solid fa-eye"></i>
            </span>
            <div>
                <span class="block text-[11px] text-[#64748B]">กำลังเผยแพร่</span>
                <strong class="text-xl font-heading font-bold text-[#1E293B]">{{ number_format($activeCount) }}</strong>
            </div>
        </div>

        <div class="saas-card p-4 flex items-center gap-3.5">
            <span class="w-11 h-11 rounded-2xl bg-amber-50 text-[#F49A22] border border-amber-200/80 grid place-items-center text-base shrink-0">
                <i class="fa-solid fa-eye-slash"></i>
            </span>
            <div>
                <span class="block text-[11px] text-[#64748B]">ซ่อน / ฉบับร่าง</span>
                <strong class="text-xl font-heading font-bold text-[#1E293B]">{{ number_format($hiddenCount) }}</strong>
            </div>
        </div>

        <div class="saas-card p-4 flex items-center gap-3.5">
            <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] text-[#3126C9] border border-[#E0E7FF] grid place-items-center text-base shrink-0">
                <i class="fa-regular fa-images"></i>
            </span>
            <div>
                <span class="block text-[11px] text-[#64748B]">ภาพถ่ายรวมทั้งหมด</span>
                <strong class="text-xl font-heading font-bold text-[#1E293B]">{{ number_format($totalPhotos) }}</strong>
            </div>
        </div>
    </div>

    {{-- 2. กล่องฟอร์มสร้างอัลบั้มกิจกรรมใหม่ (แบ่ง 2 ฝั่ง: ข้อมูลกิจกรรม vs อัปโหลดไฟล์ & พรีวิว) --}}
    {{-- 2. กล่องฟอร์มสร้างอัลบั้มกิจกรรมใหม่ (Input ขยายเต็มพื้นที่ 100% ทุกช่อง) --}}
    <div id="create-album-panel" class="saas-card p-6 sm:p-7 w-full">
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-[#E8ECF4]">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-xl bg-gradient-to-br from-[#3126C9] to-[#1675E8] text-white grid place-items-center text-sm shrink-0 saas-shadow-glow">
                    <i class="fa-solid fa-folder-plus"></i>
                </span>
                <div>
                    <h2 class="text-[16px] sm:text-[18px] font-heading font-bold text-[#1E293B] m-0">
                        สร้างอัลบั้มกิจกรรมใหม่
                    </h2>
                    <p class="text-xs text-[#64748B] m-0 mt-0.5">กรอกรายละเอียดกิจกรรมและเลือกอัปโหลดภาพถ่ายเข้าสู่อัลบั้ม</p>
                </div>
            </div>

            <button type="button"
                    id="collapse-create-album-btn"
                    class="w-8 h-8 rounded-lg bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#64748B] hover:text-[#3126C9] border border-[#E8ECF4] grid place-items-center transition-colors cursor-pointer shrink-0"
                    title="ย่อ/ขยายฟอร์ม">
                <i class="fa-solid fa-chevron-up text-xs"></i>
            </button>
        </div>

        <form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data" class="w-full space-y-5">
            @csrf

            {{-- แถวที่ 1: ชื่ออัลบั้มกิจกรรม (เต็มความกว้าง 100%) --}}
            <div class="w-full min-w-0">
                <label for="album-title" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    ชื่ออัลบั้มกิจกรรม <span class="text-rose-500">*</span>
                </label>
                <input type="text"
                       id="album-title"
                       name="title"
                       value="{{ old('title') }}"
                       required
                       style="width: 100%; display: block;"
                       class="saas-input w-full text-xs"
                       placeholder="เช่น โครงการอบรมเชิงปฏิบัติการพัฒนาศักยภาพ อสม. อำเภอโพธิ์ไทร ประจำปี 2569">
            </div>

            {{-- แถวที่ 2: สถานที่จัดกิจกรรม + วันที่จัดกิจกรรม (แบ่ง 2 คอลัมน์เต็มพื้นที่) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <div class="w-full min-w-0">
                    <label for="album-location" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        สถานที่จัดกิจกรรม
                    </label>
                    <input type="text"
                           id="album-location"
                           name="location"
                           value="{{ old('location') }}"
                           style="width: 100%; display: block;"
                           class="saas-input w-full text-xs"
                           placeholder="เช่น หอประชุมอำเภอโพธิ์ไทร จังหวัดอุบลราชธานี">
                </div>

                <div class="w-full min-w-0">
                    <label for="album-date" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        วันที่จัดกิจกรรม <span class="text-rose-500">*</span>
                    </label>
                    <input type="date"
                           id="album-date"
                           name="activity_date"
                           value="{{ old('activity_date', date('Y-m-d')) }}"
                           required
                           style="width: 100%; display: block;"
                           class="saas-input w-full text-xs">
                </div>
            </div>

            {{-- แถวที่ 3: รายละเอียดกิจกรรม (เต็มความกว้าง 100%) --}}
            <div class="w-full min-w-0">
                <label for="album-description" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    รายละเอียดกิจกรรม
                </label>
                <textarea id="album-description"
                          name="description"
                          rows="3"
                          style="width: 100%; display: block;"
                          class="saas-input w-full text-xs leading-relaxed"
                          placeholder="คำบรรยายรายละเอียดกิจกรรม วัตถุประสงค์ หรือกลุ่มเป้าหมายที่เข้าร่วม...">{{ old('description') }}</textarea>
            </div>

            {{-- แถวที่ 4: กล่องอัปโหลดรูปภาพหน้าปก และ รูปภาพในอัลบั้ม (แบ่ง 2 คอลัมน์เต็มพื้นที่) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <div class="w-full min-w-0">
                    <label for="album-cover" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        รูปภาพหน้าปกอัลบั้ม <span class="text-[#64748B] font-normal">(ไม่บังคับ)</span>
                    </label>
                    <label for="album-cover" class="saas-file-box w-full cursor-pointer">
                        <span class="w-10 h-10 rounded-xl bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-base shrink-0">
                            <i class="fa-regular fa-image"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <input type="file"
                                   id="album-cover"
                                   name="cover_image"
                                   accept="image/*"
                                   class="block w-full text-xs text-[#64748B] file:mr-2.5 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#3126C9] file:text-white hover:file:bg-[#1675E8] cursor-pointer">
                            <span class="block text-[11px] text-[#64748B] mt-1">หากไม่เลือก ระบบจะใช้รูปแรกในอัลบั้มเป็นหน้าปก</span>
                        </div>
                    </label>

                    <div id="cover-preview-wrapper" class="hidden mt-2.5 relative rounded-xl overflow-hidden border border-[#E8ECF4] h-32 bg-white">
                        <img id="cover-preview-img" src="" alt="ตัวอย่างหน้าปก" class="w-full h-full object-cover">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#3126C9] text-white text-[10px] font-heading font-semibold">
                            ตัวอย่างหน้าปก
                        </span>
                    </div>
                </div>

                <div class="w-full min-w-0">
                    <label for="album-photos" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        อัปโหลดรูปภาพในอัลบั้ม <span class="text-[#13A678] font-normal">(เลือกได้หลายไฟล์พร้อมกัน)</span>
                    </label>
                    <label for="album-photos" class="saas-file-box w-full cursor-pointer">
                        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#13A678] grid place-items-center text-base shrink-0">
                            <i class="fa-solid fa-images"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <input type="file"
                                   id="album-photos"
                                   name="photos[]"
                                   accept="image/*"
                                   multiple
                                   class="block w-full text-xs text-[#64748B] file:mr-2.5 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#13A678] file:text-white hover:file:bg-emerald-600 cursor-pointer">
                            <span id="photos-selected-count" class="block text-[11px] text-[#64748B] mt-1">รองรับ JPG, PNG, WEBP ขนาดไม่เกิน 4MB/รูป</span>
                        </div>
                    </label>

                    <div id="photos-preview-grid" class="hidden mt-2.5 grid grid-cols-4 gap-2 max-h-36 overflow-y-auto p-1"></div>
                </div>
            </div>

            {{-- แถวที่ 5: ตัวเลือกเผยแพร่ และ ปุ่มบันทึก --}}
            <div class="pt-4 border-t border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-4 w-full">
                <label class="inline-flex items-center gap-2.5 text-xs text-[#1E293B] cursor-pointer select-none">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                    <span class="font-medium">เผยแพร่อัลบั้มบนเว็บไซต์ทันที</span>
                </label>

                <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-6 cursor-pointer self-start sm:self-auto shrink-0">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>สร้างอัลบั้มและบันทึกภาพ</span>
                </button>
            </div>
        </form>
    </div>

    {{-- 3. ส่วนแสดงคลังอัลบั้มกิจกรรมทั้งหมด + ช่องค้นหาด่วน --}}
    <div class="space-y-4">
        <div class="saas-card p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <h3 class="text-[16px] sm:text-[18px] font-heading font-bold text-[#1E293B] m-0">
                    คลังอัลบั้มกิจกรรมทั้งหมด
                </h3>
                <span class="text-xs font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-0.5 rounded-full">
                    {{ number_format($albums->total()) }} อัลบั้ม
                </span>
            </div>

            {{-- ค้นหาชื่ออัลบั้มหรือสถานที่ในหน้าปัจจุบัน --}}
            <div class="relative w-full sm:w-72">
                <i class="fa-solid fa-magnifying-glass text-xs text-[#64748B] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                <input type="text"
                       id="album-quick-search"
                       class="saas-input !pl-9 text-xs"
                       placeholder="ค้นหาชื่ออัลบั้ม หรือสถานที่...">
            </div>
        </div>

        @if($albums->count() > 0)
            <div id="album-cards-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($albums as $album)
                    <div data-search-text="{{ mb_strtolower($album->title . ' ' . $album->location) }}"
                         class="album-card-item saas-card overflow-hidden flex flex-col justify-between hover:-translate-y-1 transition duration-300 group">
                        <div>
                            {{-- รูปภาพหน้าปก --}}
                            <div class="relative h-48 bg-[#F8FAFC] overflow-hidden border-b border-[#E8ECF4]">
                                @if($album->cover_image)
                                    <img src="{{ asset($album->cover_image) }}"
                                         alt="{{ $album->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full grid place-items-center text-[#64748B]">
                                        <div class="text-center">
                                            <i class="fa-regular fa-images text-3xl block mb-1"></i>
                                            <span class="text-[11px]">ยังไม่มีภาพหน้าปก</span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Gradient Overlay ด้านล่างรูป --}}
                                <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-slate-900/70 to-transparent pointer-events-none"></div>

                                {{-- ป้ายจำนวนรูปภาพ --}}
                                <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/95 text-[#1E293B] text-[11px] font-heading font-bold shadow-xs">
                                    <i class="fa-regular fa-image text-[#3126C9]"></i>
                                    <span>{{ number_format($album->photos_count) }} รูป</span>
                                </span>

                                {{-- ป้ายวันที่จัดกิจกรรม --}}
                                <span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 text-white text-[11px] font-medium">
                                    <i class="fa-regular fa-calendar"></i>
                                    <span>{{ $album->activity_date ? $album->activity_date->format('d/m/') . ($album->activity_date->year + 543) : '-' }}</span>
                                </span>

                                {{-- ป้ายสถานะการเผยแพร่ --}}
                                <span class="absolute top-3 left-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-heading font-semibold shadow-xs {{ $album->is_active ? 'bg-[#13A678] text-white' : 'bg-slate-700 text-white' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    {{ $album->is_active ? 'เผยแพร่' : 'ซ่อนไว้' }}
                                </span>
                            </div>

                            {{-- เนื้อหาการ์ด --}}
                            <div class="p-4 sm:p-5">
                                @if($album->location)
                                    <div class="inline-flex items-center gap-1.5 text-[11px] font-medium text-[#13A678] bg-emerald-50 px-2.5 py-0.5 rounded-full mb-2 max-w-full">
                                        <i class="fa-solid fa-location-dot shrink-0"></i>
                                        <span class="truncate">{{ $album->location }}</span>
                                    </div>
                                @endif

                                <h4 class="text-[15px] font-heading font-bold leading-[1.4] text-[#1E293B] group-hover:text-[#3126C9] transition-colors m-0 line-clamp-2">
                                    <a href="{{ route('admin.albums.show', $album) }}">{{ $album->title }}</a>
                                </h4>

                                @if($album->description)
                                    <p class="text-xs leading-[1.5] text-[#64748B] m-0 mt-1.5 line-clamp-2">{{ $album->description }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- ส่วนท้ายการ์ด: ปุ่มจัดการรูปภาพและลบ --}}
                        <div class="px-4 py-3 bg-[#F8FAFC] border-t border-[#E8ECF4] flex items-center justify-between gap-2">
                            <a href="{{ route('admin.albums.show', $album) }}"
                               class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white text-xs font-heading font-semibold shadow-2xs hover:opacity-95 transition-opacity">
                                <i class="fa-solid fa-images"></i>
                                <span>จัดการรูปภาพ &amp; แก้ไข</span>
                            </a>

                            <form action="{{ route('admin.albums.destroy', $album) }}" method="POST" class="m-0" onsubmit="return confirm('ยืนยันการลบอัลบั้มนี้และรูปภาพทั้งหมดภายในอัลบั้ม?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200/60 grid place-items-center transition-colors cursor-pointer"
                                        title="ลบอัลบั้ม">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- แจ้งเตือนเมื่อค้นหาแล้วไม่พบรายการ --}}
            <div id="album-search-empty" class="hidden saas-empty-state">
                <p class="text-sm font-heading font-semibold text-[#1E293B] m-0">ไม่พบอัลบั้มกิจกรรมที่ตรงกับคำค้นหา</p>
                <p class="text-xs text-[#64748B] m-0 mt-1">ลองเปลี่ยนคำค้นหาใหม่อีกครั้ง</p>
            </div>

            @if($albums->hasPages())
                <div class="saas-card p-4">
                    {{ $albums->links() }}
                </div>
            @endif
        @else
            <div class="saas-empty-state">
                <div class="w-16 h-16 rounded-2xl bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-2xl mx-auto mb-3.5">
                    <i class="fa-solid fa-photo-film"></i>
                </div>
                <h4 class="text-base font-heading font-bold text-[#1E293B] m-0">ยังไม่มีอัลบั้มกิจกรรมในระบบ</h4>
                <p class="text-xs text-[#64748B] m-0 mt-1.5 max-w-md mx-auto">
                    เริ่มต้นสร้างอัลบั้มภาพกิจกรรมแรกของคุณได้จากแบบฟอร์มด้านบน โดยสามารถเลือกอัปโหลดภาพถ่ายได้หลายรูปพร้อมกัน
                </p>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        // ย่อ/ขยายกล่องฟอร์มสร้างอัลบั้ม
        $('#toggle-create-album-btn, #collapse-create-album-btn').on('click', function () {
            const $panel = $('#create-album-panel');
            $panel.slideToggle(200);
            $('#collapse-create-album-btn i').toggleClass('fa-chevron-up fa-chevron-down');
        });

        // แสดงตัวอย่างรูปภาพหน้าปกก่อนอัปโหลด
        $('#album-cover').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#cover-preview-img').attr('src', e.target.result);
                    $('#cover-preview-wrapper').removeClass('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                $('#cover-preview-wrapper').addClass('hidden');
            }
        });

        // แสดงตัวอย่างรูปภาพหลายรูปก่อนอัปโหลด
        $('#album-photos').on('change', function () {
            const files = Array.from(this.files);
            const $grid = $('#photos-preview-grid');
            $grid.empty();

            if (files.length > 0) {
                $('#photos-selected-count').html(`<strong class="text-[#13A678]">เลือกแล้ว ${files.length} รูปภาพ</strong>`);
                $grid.removeClass('hidden');

                files.slice(0, 12).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $grid.append(`
                            <div class="aspect-square rounded-lg overflow-hidden border border-[#E8ECF4] bg-white">
                                <img src="${e.target.result}" class="w-full h-full object-cover" alt="preview">
                            </div>
                        `);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                $('#photos-selected-count').text('รองรับ JPG, PNG, WEBP ไม่เกิน 4MB/รูป');
                $grid.addClass('hidden');
            }
        });

        // ค้นหาอัลบั้มแบบ Real-time
        $('#album-quick-search').on('input', function () {
            const keyword = $(this).val().toLowerCase().trim();
            let visible = 0;

            $('.album-card-item').each(function () {
                const text = $(this).data('search-text') || '';
                if (text.includes(keyword)) {
                    $(this).removeClass('hidden');
                    visible++;
                } else {
                    $(this).addClass('hidden');
                }
            });

            if (visible === 0 && $('.album-card-item').length > 0) {
                $('#album-search-empty').removeClass('hidden');
            } else {
                $('#album-search-empty').addClass('hidden');
            }
        });
    });
</script>
@endpush
