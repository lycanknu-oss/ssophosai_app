@extends('layouts.app')

@section('title', 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('content')
    {{-- 1. Hero Slideshow & ผู้บริหารองค์กร --}}
    <section id="about" class="mb-[29px] scroll-mt-5" aria-label="ภาพประชาสัมพันธ์และผู้บริหาร">
    {{-- ใช้ items-stretch เพื่อให้คอลัมน์ซ้ายและขวามีความสูงเท่ากันบน Desktop --}}
        <div class="grid grid-cols-1 md:grid-cols-12 md:items-stretch gap-[18px]">

            {{-- ฝั่งซ้าย: สไลด์ภาพประชาสัมพันธ์ (ความสูง inherit / stretch ตามการ์ดผู้บริหารฝั่งขวาบนจอ md ขึ้นไป) --}}
            <div id="hero-slideshow"
                class="md:col-span-9 min-h-[300px] sm:min-h-[340px] md:min-h-full md:h-auto relative rounded-[18px] overflow-hidden bg-[#124e49] shadow-[var(--phs-shadow)]"
                aria-label="สไลด์ภาพประชาสัมพันธ์">
                @if(isset($slides) && $slides->count() > 0)
                    @foreach($slides as $index => $slide)
                        <div class="slide absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'active opacity-100' : 'opacity-0 pointer-events-none' }}">
                            <img src="{{ asset($slide->image_path) }}" alt="{{ $slide->title }}" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#042525]/90 via-transparent to-transparent"></div>
                            <div class="absolute z-10 left-[19px] right-[15px] bottom-[67px] sm:left-[30px] sm:right-[80px] sm:bottom-[27px] text-white">
                                @if($slide->badge)
                                    <span class="text-[11px] font-semibold text-[#bdf4dd] tracking-[1px]">{{ $slide->badge }}</span>
                                @endif
                                <h3 class="text-[19px] sm:text-[24px] font-bold leading-[1.35] my-1.5">{{ $slide->title }}</h3>
                                @if($slide->subtitle)
                                    <p class="m-0 text-[#e8f5ef] text-xs">{{ $slide->subtitle }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- Dots เลือกสไลด์ --}}
                    @if($slides->count() > 1)
                        <div class="dots absolute top-[18px] left-6 z-20 flex gap-1.5" aria-label="เลือกสไลด์">
                            @foreach($slides as $index => $slide)
                                <button type="button"
                                        class="dot h-[7px] rounded-full hover:bg-white transition-all cursor-pointer {{ $index === 0 ? 'active w-[23px] bg-white' : 'w-[7px] bg-white/60' }}"
                                        data-index="{{ $index }}"
                                        aria-label="สไลด์ {{ $index + 1 }}"
                                        @if($index === 0) aria-current="true" @endif></button>
                            @endforeach
                        </div>
                    @endif
                @else
                    {{-- ภาพตัวอย่างสำรองกรณีฐานข้อมูลยังไม่มีสไลด์ --}}
                    <div class="slide active absolute inset-0 transition-opacity duration-500 opacity-100">
                        <img src="https://images.pexels.com/photos/40198180/pexels-photo-40198180.jpeg" alt="กิจกรรมออกกำลังกายกลางแจ้งเพื่อสุขภาพชุมชน" class="w-full h-full object-cover" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#042525]/90 via-transparent to-transparent"></div>
                        <div class="absolute z-10 left-[19px] right-[15px] bottom-[67px] sm:left-[30px] sm:right-[80px] sm:bottom-[27px] text-white">
                            <span class="text-[11px] font-semibold text-[#bdf4dd] tracking-[1px]">สุขภาพชุมชน</span>
                            <h3 class="text-[19px] sm:text-[24px] font-bold leading-[1.35] my-1.5">ร่วมสร้างชุมชนสุขภาพดีไปด้วยกัน</h3>
                            <p class="m-0 text-[#e8f5ef] text-xs">ส่งเสริมการดูแลสุขภาพและการเข้าถึงข้อมูลที่เป็นประโยชน์</p>
                        </div>
                    </div>
                @endif

                {{-- Controls ปุ่มเลื่อนซ้าย-ขวา --}}
                <div class="absolute z-20 right-5 bottom-4 sm:bottom-6 flex gap-[7px]">
                    <button id="previous-slide" type="button" class="w-[35px] h-[35px] border border-white/65 bg-white/15 text-white rounded-full grid place-items-center hover:bg-white hover:text-[#124e49] transition-colors cursor-pointer" aria-label="ภาพก่อนหน้า">
                        <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>
                    </button>
                    <button id="next-slide" type="button" class="w-[35px] h-[35px] border border-white/65 bg-white/15 text-white rounded-full grid place-items-center hover:bg-white hover:text-[#124e49] transition-colors cursor-pointer" aria-label="ภาพถัดไป">
                        <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            {{-- ฝั่งขวา: ผู้บริหารองค์กร (เป็นตัวกำหนดความสูงหลักของแถวบน Desktop) --}}
            <aside class="md:col-span-3 phs-card rounded-[18px] p-4 sm:p-5 grid grid-cols-2 md:flex md:flex-col gap-3.5" aria-labelledby="leaders-title">
                <div class="col-span-2 flex items-center justify-between pb-2 border-b border-[#dcebe7]">
                    <h2 id="leaders-title" class="text-[15px] font-bold m-0 text-[#124e49] flex items-center gap-2">
                        <i class="fa-solid fa-users text-[#168d83]" aria-hidden="true"></i>
                        <span>ผู้บริหารองค์กร</span>
                    </h2>
                    <a href="{{ route('organization') }}" class="text-[11px] font-semibold text-[#168d83] hover:text-[#124e49] hover:underline">
                        ทำเนียบทั้งหมด
                    </a>
                </div>

                @forelse($executives ?? [] as $exec)
                    <div class="bg-[#f5faf8] border border-[#dcebe7]/70 rounded-2xl p-4 text-center flex-1 flex flex-col items-center justify-center">
                        <img src="{{ asset($exec->image_path) }}"
                            alt="{{ $exec->name }}"
                            class="w-[150px] h-[150px] rounded-full object-cover object-[center_25%] border-[3px] border-white shadow-[0_3px_10px_rgba(18,78,73,0.14)] shrink-0"
                            loading="lazy">
                        <strong class="block text-[13px] font-bold leading-[1.35] text-[#124e49] mt-2.5">
                            {{ $exec->name }}
                        </strong>
                        <span class="inline-block bg-[#e8f5f1] text-[#168d83] text-[11px] font-semibold px-3 py-0.5 rounded-full mt-1">
                            {{ $exec->position }}
                        </span>
                        @if($exec->start_date)
                            <small class="block text-[10px] leading-[1.4] text-[#68817d] mt-1.5">
                                ดำรงตำแหน่ง: {{ $exec->start_date->locale('th')->translatedFormat('d M') }} {{ $exec->start_date->year + 543 }} – ปัจจุบัน
                            </small>
                        @endif
                    </div>
                @empty
                    <div class="bg-[#f5faf8] border border-[#dcebe7]/70 rounded-2xl p-4 text-center flex-1 flex flex-col items-center justify-center">
                        <img src="https://images.pexels.com/photos/38618421/pexels-photo-38618421.jpeg" alt="สาธารณสุขอำเภอ" class="w-[78px] h-[78px] rounded-full object-cover object-[center_25%] border-[3px] border-white shadow-[0_3px_10px_rgba(18,78,73,0.14)] shrink-0" loading="lazy">
                        <strong class="block text-[13px] font-bold leading-[1.35] text-[#124e49] mt-2.5">รอปรับปรุงรายชื่อ</strong>
                        <span class="inline-block bg-[#e8f5f1] text-[#168d83] text-[11px] font-semibold px-3 py-0.5 rounded-full mt-1">สาธารณสุขอำเภอ</span>
                    </div>

                    <div class="bg-[#f5faf8] border border-[#dcebe7]/70 rounded-2xl p-4 text-center flex-1 flex flex-col items-center justify-center">
                        <img src="https://images.pexels.com/photos/32115905/pexels-photo-32115905.jpeg" alt="ผู้ช่วยสาธารณสุขอำเภอ" class="w-[78px] h-[78px] rounded-full object-cover object-[center_25%] border-[3px] border-white shadow-[0_3px_10px_rgba(18,78,73,0.14)] shrink-0" loading="lazy">
                        <strong class="block text-[13px] font-bold leading-[1.35] text-[#124e49] mt-2.5">รอปรับปรุงรายชื่อ</strong>
                        <span class="inline-block bg-[#e8f5f1] text-[#168d83] text-[11px] font-semibold px-3 py-0.5 rounded-full mt-1">ผู้ช่วยสาธารณสุขอำเภอ</span>
                    </div>
                @endforelse
            </aside>

        </div>
    </section>

    {{-- 3. ทางลัดข้อมูลที่น่าสนใจ --}}
    {{-- Section: ทางลัดข้อมูลที่น่าสนใจ --}}
    <section id="shortcuts" class="mb-[29px] scroll-mt-5" aria-labelledby="shortcuts-title">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3.5">
            <div>
                <h2 id="shortcuts-title" class="text-[17px] sm:text-[19px] font-bold text-[#124e49] m-0 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-[#e8f5f1] text-[#168d83] border border-[#dcebe7] grid place-items-center text-sm shrink-0">
                        <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                    </span>
                    <span>ทางลัดข้อมูลที่น่าสนใจ</span>
                </h2>
                <p class="text-xs text-[#68817d] m-0 mt-1">
                    เข้าถึงบริการ ระบบสารสนเทศ และเอกสารสำคัญของสำนักงานสาธารณสุขอำเภอโพธิ์ไทรอย่างรวดเร็ว
                </p>
            </div>

            <a href="{{ route('internal-links') }}"
            class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#168d83] hover:text-[#124e49] hover:underline self-start sm:self-center">
                <span>ดูลิงก์บริการทั้งหมด</span>
                <i class="fa-solid fa-arrow-right text-[11px]" aria-hidden="true"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
            @forelse($shortcuts ?? [] as $item)
                @php
                    // จับคู่โทนสีไอคอนตาม color_theme ที่ตั้งค่าไว้ใน Admin
                    $iconBadgeClass = match($item->color_theme) {
                        'emerald' => 'bg-emerald-50 text-[#13A678] border-emerald-200/80 group-hover:bg-[#13A678] group-hover:text-white',
                        'blue'    => 'bg-sky-50 text-[#1675E8] border-sky-200/80 group-hover:bg-[#1675E8] group-hover:text-white',
                        'amber'   => 'bg-amber-50 text-[#F49A22] border-amber-200/80 group-hover:bg-[#F49A22] group-hover:text-white',
                        default   => 'bg-[#e8f5f1] text-[#168d83] border-[#dcebe7] group-hover:bg-[#168d83] group-hover:text-white',
                    };
                @endphp

                <a href="{{ $item->url }}"
                @if($item->open_new_tab) target="_blank" rel="noopener noreferrer" @endif
                class="phs-card rounded-[18px] p-4 flex items-start gap-3.5 hover:-translate-y-1 hover:border-[#168d83]/50 transition-all duration-300 group">

                    {{-- กล่องไอคอน --}}
                    <span class="w-11 h-11 rounded-2xl border {{ $iconBadgeClass }} grid place-items-center text-base shrink-0 transition-colors shadow-2xs">
                        <i class="{{ $item->icon ?: 'fa-solid fa-link' }}" aria-hidden="true"></i>
                    </span>

                    {{-- ชื่อทางลัดและคำอธิบาย --}}
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-1.5">
                            <h3 class="text-[13.5px] font-bold leading-[1.35] text-[#124e49] group-hover:text-[#168d83] transition-colors m-0 line-clamp-2">
                                {{ $item->title }}
                            </h3>
                            @if($item->open_new_tab)
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-[#68817d] group-hover:text-[#168d83] mt-1 shrink-0" aria-hidden="true"></i>
                            @endif
                        </div>

                        @if($item->description)
                            <p class="text-[11.5px] leading-[1.45] text-[#68817d] m-0 mt-1 line-clamp-2">
                                {{ $item->description }}
                            </p>
                        @endif
                    </div>
                </a>
            @empty
                {{-- ข้อมูลทางลัดเริ่มต้น กรณีฐานข้อมูลยังไม่มีรายการ --}}
                    <a href="https://forums.ssophosai.in.th/" target="_blank" rel="noopener noreferrer"
                    class="phs-card rounded-[18px] p-4 flex items-start gap-3.5 hover:-translate-y-1 hover:border-[#168d83]/50 transition-all duration-300 group">
                        <span class="w-11 h-11 rounded-2xl border bg-[#e8f5f1] text-[#168d83] border-[#dcebe7] group-hover:bg-[#168d83] group-hover:text-white grid place-items-center text-base shrink-0 transition-colors">
                            <i class="fa-solid fa-right-left" aria-hidden="true"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-1.5">
                                <h3 class="text-[13.5px] font-bold leading-[1.35] text-[#124e49] group-hover:text-[#168d83] m-0">ระบบรับส่งข้อมูล</h3>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-[#68817d] mt-1 shrink-0" aria-hidden="true"></i>
                            </div>
                            <p class="text-[11.5px] leading-[1.45] text-[#68817d] m-0 mt-1">รับ-ส่งหนังสือราชการและเอกสารอิเล็กทรอนิกส์</p>
                        </div>
                    </a>

                    <a href="{{ route('documents') }}"
                    class="phs-card rounded-[18px] p-4 flex items-start gap-3.5 hover:-translate-y-1 hover:border-[#168d83]/50 transition-all duration-300 group">
                        <span class="w-11 h-11 rounded-2xl border bg-emerald-50 text-[#13A678] border-emerald-200/80 group-hover:bg-[#13A678] group-hover:text-white grid place-items-center text-base shrink-0 transition-colors">
                            <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-[13.5px] font-bold leading-[1.35] text-[#124e49] group-hover:text-[#168d83] m-0">ดาวน์โหลดแบบฟอร์ม</h3>
                            <p class="text-[11.5px] leading-[1.45] text-[#68817d] m-0 mt-1">แบบฟอร์มราชการ คู่มือปฏิบัติงาน และแผนงาน</p>
                        </div>
                    </a>

                    <a href="{{ route('activities') }}"
                    class="phs-card rounded-[18px] p-4 flex items-start gap-3.5 hover:-translate-y-1 hover:border-[#168d83]/50 transition-all duration-300 group">
                        <span class="w-11 h-11 rounded-2xl border bg-sky-50 text-[#1675E8] border-sky-200/80 group-hover:bg-[#1675E8] group-hover:text-white grid place-items-center text-base shrink-0 transition-colors">
                            <i class="fa-solid fa-bullhorn" aria-hidden="true"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-[13.5px] font-bold leading-[1.35] text-[#124e49] group-hover:text-[#168d83] m-0">ข่าวประกาศ &amp; รับสมัครงาน</h3>
                            <p class="text-[11.5px] leading-[1.45] text-[#68817d] m-0 mt-1">ติดตามข่าวกิจกรรม ประกาศจัดซื้อจัดจ้างล่าสุด</p>
                        </div>
                    </a>

                    <a href="{{ route('organization') }}"
                    class="phs-card rounded-[18px] p-4 flex items-start gap-3.5 hover:-translate-y-1 hover:border-[#168d83]/50 transition-all duration-300 group">
                        <span class="w-11 h-11 rounded-2xl border bg-amber-50 text-[#F49A22] border-amber-200/80 group-hover:bg-[#F49A22] group-hover:text-white grid place-items-center text-base shrink-0 transition-colors">
                            <i class="fa-solid fa-hospital" aria-hidden="true"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-[13.5px] font-bold leading-[1.35] text-[#124e49] group-hover:text-[#168d83] m-0">เครือข่ายหน่วยบริการ</h3>
                            <p class="text-[11.5px] leading-[1.45] text-[#68817d] m-0 mt-1">ข้อมูลโครงสร้างหน่วยงานและ รพ.สต. ในสังกัด</p>
                        </div>
                    </a>
                @endforelse
            </div>
        </section>

    {{-- Section: ข่าวประชาสัมพันธ์ --}}
    <section id="news" class="mb-[29px] scroll-mt-5" aria-labelledby="news-title">
        <div class="phs-card rounded-[18px] p-5 sm:p-6">
            {{-- Header & Category Filter Tabs --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3.5 pb-4 mb-5 border-b border-[#dcebe7]">
                <div>
                    <h2 id="news-title" class="text-[17px] sm:text-[19px] font-bold text-[#124e49] m-0 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-[#e8f5f1] text-[#168d83] border border-[#dcebe7] grid place-items-center text-sm shrink-0">
                            <i class="fa-solid fa-bullhorn" aria-hidden="true"></i>
                        </span>
                        <span>ข่าวประชาสัมพันธ์</span>
                    </h2>
                    <p class="text-xs text-[#68817d] m-0 mt-1">
                        ข่าวสารกิจกรรม ประกาศรับสมัครงาน และประกาศจัดซื้อจัดจ้าง สำนักงานสาธารณสุขอำเภอโพธิ์ไทร
                    </p>
                </div>

                {{-- ปุ่มสลับหมวดหมู่ข่าว --}}
                <div class="flex flex-wrap items-center gap-1.5" role="tablist" aria-label="หมวดหมู่ข่าวประชาสัมพันธ์">
                    <button type="button"
                            data-news-filter="all"
                            class="news-tab-btn active px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#124e49] text-white transition-all cursor-pointer">
                        ทั้งหมด
                    </button>
                    <button type="button"
                            data-news-filter="general"
                            class="news-tab-btn px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] border border-[#dcebe7] transition-all cursor-pointer">
                        ข่าวทั่วไป
                    </button>
                    <button type="button"
                            data-news-filter="recruitment"
                            class="news-tab-btn px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] border border-[#dcebe7] transition-all cursor-pointer">
                        ข่าวรับสมัครงาน
                    </button>
                    <button type="button"
                            data-news-filter="procurement"
                            class="news-tab-btn px-3.5 py-1.5 rounded-full text-xs font-semibold bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] border border-[#dcebe7] transition-all cursor-pointer">
                        ข่าวจัดซื้อจัดจ้าง
                    </button>
                </div>
            </div>

            {{-- รายการข่าวประชาสัมพันธ์ --}}
            @if(isset($activities) && $activities->count() > 0)
                <div id="home-news-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($activities->take(9) as $news)
                        @php
                            $catBadgeClass = match($news->category) {
                                'recruitment' => 'bg-emerald-50 text-[#13A678] border-emerald-200/80',
                                'procurement' => 'bg-amber-50 text-[#d97706] border-amber-200/80',
                                default       => 'bg-[#e8f5f1] text-[#168d83] border-[#dcebe7]',
                            };
                        @endphp

                        <article data-category="{{ $news->category }}"
                                class="news-card-item bg-[#f5faf8]/70 hover:bg-white border border-[#dcebe7] hover:border-[#168d83]/50 rounded-2xl overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_24px_-6px_rgba(18,78,73,0.12)] group">
                            <div>
                                {{-- รูปภาพหน้าปก (ถ้ามี) --}}
                                @if($news->cover_image)
                                    <div class="relative h-40 overflow-hidden bg-[#124e49]/10">
                                        <img src="{{ asset($news->cover_image) }}"
                                            alt="{{ $news->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy">
                                        @if($news->is_pinned)
                                            <span class="absolute top-2.5 right-2.5 inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-500 text-white text-[10px] font-bold shadow-sm">
                                                <i class="fa-solid fa-thumbtack"></i> ปักหมุด
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <div class="p-4">
                                    {{-- ป้ายหมวดหมู่ + วันที่เผยแพร่ --}}
                                    <div class="flex items-center justify-between gap-2 mb-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full border text-[11px] font-semibold {{ $catBadgeClass }}">
                                            {{ $news->category_label }}
                                        </span>

                                        <time class="text-[11px] text-[#68817d] flex items-center gap-1 shrink-0">
                                            <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                            @if($news->published_date)
                                                {{ $news->published_date->locale('th')->translatedFormat('d M') }} {{ $news->published_date->year + 543 }}
                                            @else
                                                -
                                            @endif
                                        </time>
                                    </div>

                                    {{-- ป้ายปักหมุดกรณีไม่มีรูปปก --}}
                                    @if(!$news->cover_image && $news->is_pinned)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-bold mb-1.5">
                                            <i class="fa-solid fa-thumbtack"></i> ข่าวเด่นปักหมุด
                                        </span>
                                    @endif

                                    {{-- หัวข้อข่าว --}}
                                    <h3 class="text-[14px] font-bold leading-[1.4] text-[#124e49] group-hover:text-[#168d83] transition-colors m-0 line-clamp-2">
                                        <a href="{{ route('activities') }}#news-{{ $news->id }}" class="hover:underline">
                                            {{ $news->title }}
                                        </a>
                                    </h3>

                                    {{-- คำโปรย / สรุปย่อ --}}
                                    @if($news->summary)
                                        <p class="text-xs leading-[1.5] text-[#68817d] m-0 mt-1.5 line-clamp-2">
                                            {{ $news->summary }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- ส่วนท้ายการ์ด: ดาวน์โหลดไฟล์แนบ / อ่านรายละเอียด --}}
                            <div class="px-4 py-3 border-t border-[#dcebe7]/70 bg-white/60 flex items-center justify-between gap-2 text-[11.5px]">
                                @if($news->attachment_path)
                                    <a href="{{ asset($news->attachment_path) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 font-semibold text-[#13A678] hover:text-[#124e49] hover:underline">
                                        <i class="fa-solid fa-file-arrow-down" aria-hidden="true"></i>
                                        <span>ดาวน์โหลดเอกสาร</span>
                                    </a>
                                @else
                                    <span class="text-[#68817d]">สสอ.โพธิ์ไทร</span>
                                @endif

                                <a href="{{ route('activities') }}#news-{{ $news->id }}"
                                class="inline-flex items-center gap-1 font-semibold text-[#168d83] hover:text-[#124e49] ml-auto">
                                    <span>อ่านเพิ่มเติม</span>
                                    <i class="fa-solid fa-chevron-right text-[10px]" aria-hidden="true"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- ข้อความแจ้งเตือนเมื่อกรองหมวดหมู่แล้วไม่พบข่าวในหมวดนั้น --}}
                <div id="home-news-empty-filter" class="hidden py-10 text-center text-xs text-[#68817d]">
                    <i class="fa-regular fa-folder-open text-2xl text-[#168d83]/50 mb-2 block"></i>
                    ยังไม่มีข่าวประชาสัมพันธ์ในหมวดหมู่นี้
                </div>
            @else
                {{-- กรณีฐานข้อมูลยังไม่มีข่าวประชาสัมพันธ์ --}}
                <div class="py-12 text-center bg-[#f5faf8] rounded-2xl border border-dashed border-[#dcebe7]">
                    <i class="fa-solid fa-bullhorn text-2xl text-[#168d83]/60 mb-2 block"></i>
                    <p class="text-sm font-semibold text-[#124e49] m-0">ยังไม่มีข่าวประชาสัมพันธ์ในขณะนี้</p>
                    <p class="text-xs text-[#68817d] m-0 mt-1">ติดตามข่าวสารกิจกรรมและประกาศสำคัญของสำนักงานสาธารณสุขอำเภอโพธิ์ไทรได้ที่นี่</p>
                </div>
            @endif

            {{-- ปุ่มดูข่าวประชาสัมพันธ์ทั้งหมด --}}
            <div class="mt-5 pt-4 border-t border-[#dcebe7] flex flex-col sm:flex-row items-center justify-between gap-3">
                <span class="text-xs text-[#68817d]">
                    แสดงข่าวประชาสัมพันธ์ล่าสุดจากระบบสารสนเทศ สสอ.โพธิ์ไทร
                </span>
                <a href="{{ route('activities.all') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#124e49] hover:bg-[#168d83] text-white text-xs font-semibold transition-colors shadow-xs">
                    <span>ดูข่าวประชาสัมพันธ์ทั้งหมด</span>
                    <i class="fa-solid fa-arrow-right text-[11px]" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Section #onepage: อัลบั้มภาพกิจกรรม --}}
    <section id="onepage" class="mb-[29px] scroll-mt-20" aria-labelledby="onepage-title">
        <div class="phs-card rounded-[18px] p-5 sm:p-6">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-5 border-b border-[#dcebe7]">
                <div>
                    <h2 id="onepage-title" class="text-[17px] sm:text-[19px] font-bold text-[#124e49] m-0 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-[#e8f5f1] text-[#168d83] border border-[#dcebe7] grid place-items-center text-sm shrink-0">
                            <i class="fa-solid fa-photo-film" aria-hidden="true"></i>
                        </span>
                        <span>อัลบั้มภาพกิจกรรม</span>
                    </h2>
                    <p class="text-xs text-[#68817d] m-0 mt-1">
                        ประมวลภาพกิจกรรมการดำเนินงานด้านสาธารณสุขและบริการชุมชน สำนักงานสาธารณสุขอำเภอโพธิ์ไทร
                    </p>
                </div>

                <a href="{{ route('activities') }}#albums-section"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#168d83] hover:text-[#124e49] hover:underline self-start sm:self-center shrink-0">
                    <span>ดูอัลบั้มภาพทั้งหมด</span>
                    <i class="fa-solid fa-arrow-right text-[11px]" aria-hidden="true"></i>
                </a>
            </div>

            {{-- Grid แสดงรายการอัลบั้มภาพ --}}
            @if(isset($albums) && $albums->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                    @foreach($albums as $album)
                        @php
                            $thaiAlbumDate = $album->activity_date
                                ? $album->activity_date->locale('th')->translatedFormat('d M') . ' ' . ($album->activity_date->year + 543)
                                : '-';
                        @endphp

                        <article class="bg-[#f5faf8]/70 hover:bg-white border border-[#dcebe7] hover:border-[#168d83]/50 rounded-2xl overflow-hidden flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_24px_-6px_rgba(18,78,73,0.12)] group">
                            <div>
                                {{-- ภาพหน้าปกอัลบั้ม --}}
                                <div class="relative h-48 overflow-hidden bg-[#124e49]/10 border-b border-[#dcebe7]/70 cursor-pointer"
                                    onclick='openAlbumGalleryModal(@json($album), "{{ $thaiAlbumDate }}")'>
                                    @if($album->cover_image)
                                        <img src="{{ asset($album->cover_image) }}"
                                            alt="{{ $album->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy">
                                    @else
                                        <div class="w-full h-full grid place-items-center text-[#68817d]">
                                            <i class="fa-regular fa-images text-3xl"></i>
                                        </div>
                                    @endif

                                    {{-- Gradient Overlay --}}
                                    <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-[#042525]/80 to-transparent pointer-events-none"></div>

                                    {{-- ป้ายจำนวนรูปภาพในอัลบั้ม --}}
                                    <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/95 text-[#124e49] text-[11px] font-bold shadow-xs">
                                        <i class="fa-regular fa-image text-[#168d83]"></i>
                                        <span>{{ number_format($album->photos_count) }} ภาพ</span>
                                    </span>

                                    {{-- วันที่จัดกิจกรรม --}}
                                    <span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 text-white text-[11px] font-medium">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span>{{ $thaiAlbumDate }}</span>
                                    </span>
                                </div>

                                {{-- รายละเอียดอัลบั้ม --}}
                                <div class="p-4">
                                    @if($album->location)
                                        <div class="inline-flex items-center gap-1.5 text-[11px] font-medium text-[#168d83] bg-[#e8f5f1] px-2.5 py-0.5 rounded-full mb-2 max-w-full">
                                            <i class="fa-solid fa-location-dot shrink-0"></i>
                                            <span class="truncate">{{ $album->location }}</span>
                                        </div>
                                    @endif

                                    <h3 class="text-[14.5px] font-bold leading-[1.4] text-[#124e49] group-hover:text-[#168d83] transition-colors m-0 line-clamp-2">
                                        <button type="button"
                                                onclick='openAlbumGalleryModal(@json($album), "{{ $thaiAlbumDate }}")'
                                                class="text-left hover:underline cursor-pointer">
                                            {{ $album->title }}
                                        </button>
                                    </h3>

                                    @if($album->description)
                                        <p class="text-xs leading-[1.55] text-[#68817d] m-0 mt-1.5 line-clamp-2">
                                            {{ $album->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- ส่วนท้ายการ์ด --}}
                            <div class="px-4 py-3 border-t border-[#dcebe7]/70 bg-white/60 flex items-center justify-between text-[11.5px]">
                                <span class="text-[#68817d]">คลังภาพ สสอ.โพธิ์ไทร</span>
                                <button type="button"
                                        onclick='openAlbumGalleryModal(@json($album), "{{ $thaiAlbumDate }}")'
                                        class="inline-flex items-center gap-1 font-semibold text-[#168d83] hover:text-[#124e49] cursor-pointer">
                                    <span>เปิดดูอัลบั้มภาพ</span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center bg-[#f5faf8] rounded-2xl border border-dashed border-[#dcebe7]">
                    <i class="fa-solid fa-photo-film text-2xl text-[#168d83]/60 mb-2 block"></i>
                    <p class="text-sm font-semibold text-[#124e49] m-0">ยังไม่มีอัลบั้มภาพกิจกรรมในขณะนี้</p>
                    <p class="text-xs text-[#68817d] m-0 mt-1">ประมวลภาพกิจกรรมการดำเนินงานของสำนักงานสาธารณสุขอำเภอโพธิ์ไทรจะแสดงที่นี่</p>
                </div>
            @endif
        </div>
    </section>

    {{-- MODAL: เปิดดูรูปภาพทั้งหมดในอัลบั้มจากหน้าแรก --}}
    <div id="home-album-modal" class="hidden fixed inset-0 z-50 bg-slate-900/75 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl border border-[#dcebe7] shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto p-6 sm:p-7 relative">
            <button type="button"
                    onclick="$('#home-album-modal').addClass('hidden')"
                    class="w-8 h-8 rounded-full bg-[#f5faf8] hover:bg-rose-50 text-[#68817d] hover:text-rose-600 border border-[#dcebe7] grid place-items-center absolute top-5 right-5 cursor-pointer"
                    aria-label="ปิดหน้าต่าง">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="pr-8">
                <div class="flex flex-wrap items-center gap-2 text-xs text-[#168d83] font-semibold mb-1.5">
                    <span id="modal-album-date"></span>
                    <span id="modal-album-location"></span>
                </div>
                <h3 id="modal-album-title" class="text-[18px] sm:text-[22px] font-bold text-[#124e49] m-0"></h3>
                <p id="modal-album-desc" class="text-xs sm:text-sm text-[#68817d] m-0 mt-2 leading-relaxed whitespace-pre-line"></p>
            </div>

            <div id="modal-album-photos-grid" class="mt-5 pt-5 border-t border-[#dcebe7] grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3"></div>
        </div>
    </div>

    {{-- 6. บริการของเรา --}}
    <section id="services" class="mb-[29px] scroll-mt-20" aria-labelledby="services-title">
        <div class="phs-card rounded-[18px] p-5 sm:p-6">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-5 border-b border-[#dcebe7]">
                <div>
                    <h2 id="services-title" class="text-[17px] sm:text-[19px] font-bold text-[#124e49] m-0 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-[#e8f5f1] text-[#168d83] border border-[#dcebe7] grid place-items-center text-sm shrink-0">
                            <i class="fa-solid fa-hand-holding-medical" aria-hidden="true"></i>
                        </span>
                        <span>บริการของเรา</span>
                    </h2>
                    <p class="text-xs text-[#68817d] m-0 mt-1">
                        ระบบงานบริการด้านสาธารณสุข ข้อมูลสุขภาพ และช่องทางติดต่อรับบริการสำหรับประชาชนและเจ้าหน้าที่
                    </p>
                </div>

                <a href="{{ route('internal-links') }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#168d83] hover:text-[#124e49] hover:underline self-start sm:self-center shrink-0">
                    <span>ดูระบบบริการทั้งหมด</span>
                    <i class="fa-solid fa-arrow-right text-[11px]" aria-hidden="true"></i>
                </a>
            </div>

            {{-- Grid แสดงรายการบริการจากฐานข้อมูล our_services --}}
            @if(isset($services) && $services->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                    @foreach($services as $service)
                        @php
                            // กำหนดโทนสีไอคอนและป้ายกำกับตาม badge_color ที่เลือกไว้ใน Admin
                            $colorConfig = match($service->badge_color) {
                                'blue' => [
                                    'iconBox' => 'bg-sky-50 text-[#1675E8] border-sky-200/80 group-hover:bg-[#1675E8] group-hover:text-white',
                                    'badge'   => 'bg-sky-50 text-[#1675E8]',
                                ],
                                'green' => [
                                    'iconBox' => 'bg-emerald-50 text-[#13A678] border-emerald-200/80 group-hover:bg-[#13A678] group-hover:text-white',
                                    'badge'   => 'bg-emerald-50 text-[#13A678]',
                                ],
                                'orange' => [
                                    'iconBox' => 'bg-amber-50 text-[#F49A22] border-amber-200/80 group-hover:bg-[#F49A22] group-hover:text-white',
                                    'badge'   => 'bg-amber-50 text-[#d97706]',
                                ],
                                default => [
                                    'iconBox' => 'bg-[#e8f5f1] text-[#168d83] border-[#dcebe7] group-hover:bg-[#124e49] group-hover:text-white',
                                    'badge'   => 'bg-[#e8f5f1] text-[#168d83]',
                                ],
                            };

                            $hasLink = !empty($service->link_url);
                            $tag = $hasLink ? 'a' : 'div';
                        @endphp

                        <{{ $tag }}
                            @if($hasLink)
                                href="{{ $service->link_url }}"
                                @if($service->is_external)
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                            @endif
                            class="bg-[#f5faf8]/70 hover:bg-white border border-[#dcebe7] hover:border-[#168d83]/50 rounded-2xl p-5 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_24px_-6px_rgba(18,78,73,0.12)] group {{ $hasLink ? 'cursor-pointer' : '' }}">

                            <div>
                                <div class="flex items-start justify-between gap-3 mb-3.5">
                                    {{-- กล่องไอคอนบริการ --}}
                                    <span class="w-12 h-12 rounded-2xl border {{ $colorConfig['iconBox'] }} grid place-items-center text-lg shrink-0 transition-colors duration-300">
                                        <i class="{{ $service->icon ?: 'fa-solid fa-hand-holding-medical' }}" aria-hidden="true"></i>
                                    </span>

                                    {{-- ป้ายหมวดหมู่ย่อย (ถ้ามี) --}}
                                    @if($service->subtitle)
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold {{ $colorConfig['badge'] }} line-clamp-1 max-w-[65%]">
                                            {{ $service->subtitle }}
                                        </span>
                                    @endif
                                </div>

                                {{-- ชื่อบริการ --}}
                                <h3 class="text-[15px] sm:text-[16px] font-bold leading-[1.4] text-[#124e49] group-hover:text-[#168d83] transition-colors m-0">
                                    {{ $service->title }}
                                </h3>

                                {{-- คำอธิบายบริการโดยย่อ --}}
                                @if($service->description)
                                    <p class="text-xs leading-[1.6] text-[#68817d] m-0 mt-2 line-clamp-3">
                                        {{ $service->description }}
                                    </p>
                                @endif
                            </div>

                            {{-- ส่วนท้ายการ์ด --}}
                            <div class="mt-4 pt-3 border-t border-[#dcebe7]/70 flex items-center justify-between text-[11.5px]">
                                <span class="text-[#68817d]">สสอ.โพธิ์ไทร</span>

                                @if($hasLink)
                                    <span class="inline-flex items-center gap-1.5 font-semibold text-[#168d83] group-hover:text-[#124e49]">
                                        <span>{{ $service->is_external ? 'เข้าสู่ระบบบริการ' : 'ดูรายละเอียด' }}</span>
                                        <i class="fa-solid {{ $service->is_external ? 'fa-arrow-up-right-from-square' : 'fa-chevron-right' }} text-[10px] transition-transform group-hover:translate-x-0.5" aria-hidden="true"></i>
                                    </span>
                                @else
                                    <span class="text-[#68817d] font-medium">บริการ ณ จุดบริการ</span>
                                @endif
                            </div>
                        </{{ $tag }}>
                    @endforeach
                </div>
            @else
                {{-- กรณียังไม่มีข้อมูลบริการในฐานข้อมูล --}}
                <div class="py-12 text-center bg-[#f5faf8] rounded-2xl border border-dashed border-[#dcebe7]">
                    <i class="fa-solid fa-hand-holding-medical text-2xl text-[#168d83]/60 mb-2 block"></i>
                    <p class="text-sm font-semibold text-[#124e49] m-0">ยังไม่มีรายการบริการที่เปิดเผยแพร่ในขณะนี้</p>
                    <p class="text-xs text-[#68817d] m-0 mt-1">ข้อมูลบริการด้านสาธารณสุขของสำนักงานสาธารณสุขอำเภอโพธิ์ไทรจะแสดงที่นี่</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Section #calendar: ปฏิทินกิจกรรม (ดึงข้อมูลจาก Google Calendar) --}}
    <section id="calendar" class="mb-[29px] scroll-mt-20" aria-labelledby="calendar-title">
        <div class="phs-card rounded-[18px] p-5 sm:p-6">
            {{-- Header & Controls --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3.5 pb-4 mb-5 border-b border-[#dcebe7]">
                <div>
                    <h2 id="calendar-title" class="text-[17px] sm:text-[19px] font-bold text-[#124e49] m-0 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-xl bg-[#e8f5f1] text-[#168d83] border border-[#dcebe7] grid place-items-center text-sm shrink-0">
                            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>
                        </span>
                        <span>ปฏิทินกิจกรรม</span>
                    </h2>
                    <p class="text-xs text-[#68817d] m-0 mt-1">
                        กำหนดการประชุม อบรม และกิจกรรมดำเนินงานสาธารณสุข สำนักงานสาธารณสุขอำเภอโพธิ์ไทร
                    </p>
                </div>

                {{-- ปุ่มสลับมุมมองปฏิทิน & ลิงก์เปิดเต็มจอ --}}
                <div class="flex flex-wrap items-center gap-2">
                    <div class="inline-flex rounded-full bg-[#f5faf8] p-1 border border-[#dcebe7]" role="group" aria-label="สลับมุมมองปฏิทิน">
                        <button type="button"
                                data-cal-mode="MONTH"
                                class="cal-mode-btn active px-3 py-1 rounded-full text-xs font-semibold bg-[#124e49] text-white transition-all cursor-pointer">
                            <i class="fa-regular fa-calendar mr-1"></i> รายเดือน
                        </button>
                        <button type="button"
                                data-cal-mode="AGENDA"
                                class="cal-mode-btn px-3 py-1 rounded-full text-xs font-semibold text-[#124e49] hover:bg-[#e8f5f1] transition-all cursor-pointer">
                            <i class="fa-solid fa-list-ul mr-1"></i> กำหนดการ
                        </button>
                    </div>

                    <a href="https://calendar.google.com/calendar/u/0/r?cid=4bc8959963335cc522a3b52f18610fa5480d0993b90ded8dada6f9f08b3e40e7%40group.calendar.google.com"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#e8f5f1] hover:bg-[#168d83] text-[#124e49] hover:text-white border border-[#dcebe7] text-xs font-semibold transition-colors">
                        <i class="fa-solid fa-calendar-plus text-[11px]"></i>
                        <span>เพิ่มลงปฏิทินของฉัน</span>
                    </a>
                </div>
            </div>

            {{-- กรอบแสดงผล Google Calendar Iframe --}}
            <div class="relative rounded-2xl overflow-hidden border border-[#dcebe7] bg-[#f5faf8]">
                <iframe id="gcal-embed-frame"
                        src="https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Asia%2FBangkok&bgcolor=%23ffffff&showTitle=0&showNav=1&showDate=1&showPrint=0&showTabs=0&showCalendars=0&showTz=0&mode=MONTH&hl=th&src=4bc8959963335cc522a3b52f18610fa5480d0993b90ded8dada6f9f08b3e40e7%40group.calendar.google.com&color=%23168d83"
                        title="ปฏิทินกิจกรรม สำนักงานสาธารณสุขอำเภอโพธิ์ไทร"
                        class="w-full h-[460px] sm:h-[560px] lg:h-[620px] border-0 block"
                        loading="lazy">
                </iframe>
            </div>

            {{-- แถบหมายเหตุด้านล่าง --}}
            <div class="mt-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-[11.5px] text-[#68817d]">
                <span class="inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-info text-[#168d83]"></i>
                    <span>คลิกที่รายการกิจกรรมในปฏิทินเพื่อดูรายละเอียด เวลา และสถานที่จัดกิจกรรม</span>
                </span>
                <a href="https://calendar.google.com/calendar/embed?src=4bc8959963335cc522a3b52f18610fa5480d0993b90ded8dada6f9f08b3e40e7%40group.calendar.google.com&ctz=Asia%2FBangkok"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center gap-1 font-semibold text-[#168d83] hover:text-[#124e49] hover:underline self-start sm:self-auto">
                    <span>เปิดปฏิทินในหน้าต่างเต็ม</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- สถิติการให้บริการ (Service Statistics - Full Gradient Palette) --}}
    <section id="service-statistics" class="mb-[29px]" aria-labelledby="service-statistics-title">
        <div class="flex justify-between items-end gap-[15px] mb-4">
            <div>
                <span class="text-[11px] font-bold tracking-[1.6px] text-[#168d83] uppercase">SERVICE STATISTICS</span>
                <h2 id="service-statistics-title" class="text-[20px] sm:text-[24px] font-bold leading-[1.3] mt-[3px] mb-0 text-[#124e49]">
                    สถิติการให้บริการ
                </h2>
            </div>
            <p class="hidden sm:block m-0 text-[#68817d] text-xs">
                ข้อมูล ณ วันที่ {{ now()->format('d/m/') . (now()->year + 543) }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- 1. จำนวนผู้เยี่ยมชมวันนี้ (Teal-Emerald Gradient) --}}
            <article class="relative overflow-hidden rounded-[18px] p-5 text-white shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center gap-4"
                    style="background: linear-gradient(135deg, #0d4f49 0%, #168d83 65%, #22b8a8 100%);">
                <span class="pointer-events-none absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10"></span>
                <span class="pointer-events-none absolute -top-8 right-6 w-16 h-16 rounded-full bg-white/10"></span>

                <span class="relative z-10 w-13 h-13 rounded-[15px] bg-white/18 backdrop-blur-xs border border-white/25 text-white grid place-items-center text-xl shrink-0 shadow-xs">
                    <i class="fa-solid fa-user-clock" aria-hidden="true"></i>
                </span>
                <div class="relative z-10 min-w-0">
                    <span class="block text-xs font-medium text-[#d3f9ed]">จำนวนผู้เยี่ยมชมวันนี้</span>
                    <div class="flex items-baseline gap-1.5 mt-0.5">
                        <strong class="text-[26px] font-bold text-white leading-tight tracking-tight">
                            {{ number_format($serviceStats['today_visitors'] ?? 0) }}
                        </strong>
                        <span class="text-xs text-[#d3f9ed]">คน</span>
                    </div>
                </div>
            </article>

            {{-- 2. จำนวนผู้เยี่ยมชมทั้งหมด (Deep Ocean-Cyan Gradient) --}}
            <article class="relative overflow-hidden rounded-[18px] p-5 text-white shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center gap-4"
                    style="background: linear-gradient(135deg, #0b4a5e 0%, #0e7490 60%, #06b6d4 100%);">
                <span class="pointer-events-none absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10"></span>
                <span class="pointer-events-none absolute -top-8 right-6 w-16 h-16 rounded-full bg-white/10"></span>

                <span class="relative z-10 w-13 h-13 rounded-[15px] bg-white/18 backdrop-blur-xs border border-white/25 text-white grid place-items-center text-xl shrink-0 shadow-xs">
                    <i class="fa-solid fa-users-viewfinder" aria-hidden="true"></i>
                </span>
                <div class="relative z-10 min-w-0">
                    <span class="block text-xs font-medium text-[#cffafe]">จำนวนผู้เยี่ยมชมทั้งหมด</span>
                    <div class="flex items-baseline gap-1.5 mt-0.5">
                        <strong class="text-[26px] font-bold text-white leading-tight tracking-tight">
                            {{ number_format($serviceStats['total_visitors'] ?? 0) }}
                        </strong>
                        <span class="text-xs text-[#cffafe]">คน</span>
                    </div>
                </div>
            </article>

            {{-- 3. จำนวนหน่วยบริการ (Forest-Mint Green Gradient) --}}
            <a href="{{ route('subordinate-units') }}"
            class="relative overflow-hidden rounded-[18px] p-5 text-white shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center gap-4 group"
            style="background: linear-gradient(135deg, #065f46 0%, #059669 60%, #10b981 100%);">
                <span class="pointer-events-none absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 group-hover:scale-110 transition-transform"></span>
                <span class="pointer-events-none absolute -top-8 right-6 w-16 h-16 rounded-full bg-white/10"></span>

                <span class="relative z-10 w-13 h-13 rounded-[15px] bg-white/18 backdrop-blur-xs border border-white/25 text-white grid place-items-center text-xl shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-hospital-user" aria-hidden="true"></i>
                </span>
                <div class="relative z-10 min-w-0">
                    <span class="block text-xs font-medium text-[#d1fae5]">จำนวนหน่วยบริการ</span>
                    <div class="flex items-baseline gap-1.5 mt-0.5">
                        <strong class="text-[26px] font-bold text-white leading-tight tracking-tight">
                            {{ number_format($serviceStats['service_units'] ?? 0) }}
                        </strong>
                        <span class="text-xs text-[#d1fae5]">แห่ง</span>
                    </div>
                </div>
            </a>

            {{-- 4. จำนวนข้อร้องเรียน (Warm Amber-Terracotta Gradient) --}}
            <a href="{{ route('complaints.index') }}"
            class="relative overflow-hidden rounded-[18px] p-5 text-white shadow-md hover:-translate-y-1 transition-all duration-300 flex items-center gap-4 group"
            style="background: linear-gradient(135deg, #9a3412 0%, #d97706 60%, #f59e0b 100%);">
                <span class="pointer-events-none absolute -right-6 -bottom-6 w-28 h-28 rounded-full bg-white/10 group-hover:scale-110 transition-transform"></span>
                <span class="pointer-events-none absolute -top-8 right-6 w-16 h-16 rounded-full bg-white/10"></span>

                <span class="relative z-10 w-13 h-13 rounded-[15px] bg-white/18 backdrop-blur-xs border border-white/25 text-white grid place-items-center text-xl shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-bullhorn" aria-hidden="true"></i>
                </span>
                <div class="relative z-10 min-w-0">
                    <span class="block text-xs font-medium text-[#fef3c7]">จำนวนข้อร้องเรียน</span>
                    <div class="flex items-baseline gap-1.5 mt-0.5">
                        <strong class="text-[26px] font-bold text-white leading-tight tracking-tight">
                            {{ number_format($serviceStats['total_complaints'] ?? 0) }}
                        </strong>
                        <span class="text-xs text-[#fef3c7]">เรื่อง</span>
                    </div>
                </div>
            </a>
        </div>
    </section>

    {{-- ติดต่อหน่วยงาน (Contact Us - ดึงข้อมูลล่าสุดจากตาราง site_settings) --}}
    @php
        $siteInfo = [
            'org_name_th'       => \App\Models\SiteSetting::getValue('site_org_name_th', 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร'),
            'org_name_en'       => \App\Models\SiteSetting::getValue('site_org_name_en', 'Pho Sai District Public Health Office'),
            'address'           => \App\Models\SiteSetting::getValue('site_address', 'หมู่ที่ 2 ตำบลโพธิ์ไทร อำเภอโพธิ์ไทร จังหวัดอุบลราชธานี 34340'),
            'phone'             => \App\Models\SiteSetting::getValue('site_phone', '045-489-XXX'),
            'google_map_iframe' => \App\Models\SiteSetting::getValue('site_google_map_iframe', ''),
            'hours_weekday'     => \App\Models\SiteSetting::getValue('site_hours_weekday', 'วันจันทร์ - วันศุกร์ เวลา 08.30 - 16.30 น.'),
            'hours_weekend'     => \App\Models\SiteSetting::getValue('site_hours_weekend', 'วันเสาร์ - วันอาทิตย์ และวันหยุดนักขัตฤกษ์ ปิดทำการ'),
            'slogan'            => \App\Models\SiteSetting::getValue('site_slogan', 'สุขภาพดี เริ่มต้นที่ชุมชนของเรา'),
        ];
    @endphp

    <section id="contact" class="mb-[29px]" aria-labelledby="contact-title">
        <div class="flex justify-between items-end gap-[15px] mb-4">
            <div>
                <span class="text-[11px] font-bold tracking-[1.6px] text-[#168d83] uppercase">CONTACT US</span>
                <h2 id="contact-title" class="text-[20px] sm:text-[24px] font-bold leading-[1.3] mt-[3px] mb-0 text-[#124e49]">
                    ติดต่อหน่วยงาน
                </h2>
            </div>
            <p class="hidden sm:block m-0 text-[#68817d] text-xs">
                {{ $siteInfo['org_name_th'] }} ({{ $siteInfo['org_name_en'] }})
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
            {{-- คอลัมน์ซ้าย: ข้อมูลที่อยู่ เบอร์โทรศัพท์ และเวลาทำการ --}}
            <article class="lg:col-span-6 relative overflow-hidden rounded-[18px] p-6 text-white shadow-md flex flex-col justify-between space-y-5"
                style="background: linear-gradient(135deg, #0d4f49 0%, #168d83 62%, #22b8a8 100%);">
            {{-- วงกลมแสงตกแต่งพื้นหลัง --}}
            <span class="pointer-events-none absolute -right-10 -bottom-10 w-44 h-44 rounded-full bg-white/10"></span>
            <span class="pointer-events-none absolute -top-10 right-12 w-24 h-24 rounded-full bg-white/10"></span>

            <div class="relative z-10">
                <div class="flex items-start justify-between gap-3 mb-3">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-white/15 border border-white/25 text-[#d3f9ed] mb-2">
                            ข้อมูลการติดต่อ
                        </span>
                        <h3 class="text-[17px] sm:text-[18px] font-bold text-white m-0">
                            {{ $siteInfo['org_name_th'] }}
                        </h3>
                        <p class="text-xs text-[#d3f9ed] font-medium m-0 mt-0.5">
                            {{ $siteInfo['org_name_en'] }}
                        </p>
                    </div>
                </div>

                @if(!empty($siteInfo['slogan']))
                    <div class="p-3 rounded-[12px] bg-white/14 backdrop-blur-xs border border-white/25 text-xs text-white font-medium mb-4 flex items-center gap-2.5 shadow-xs">
                        <i class="fa-solid fa-quote-left text-[#fde68a] shrink-0" aria-hidden="true"></i>
                        <span>{{ $siteInfo['slogan'] }}</span>
                    </div>
                @endif

                <div class="divide-y divide-white/15 text-[13px]">
                    {{-- ที่อยู่ --}}
                    <div class="py-3 flex items-start gap-3">
                        <span class="w-9 h-9 rounded-xl bg-white/18 backdrop-blur-xs border border-white/25 text-white grid place-items-center text-sm shrink-0 mt-0.5 shadow-xs">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        </span>
                        <div>
                            <strong class="block text-xs font-semibold text-[#d3f9ed]">ที่ตั้งสำนักงาน</strong>
                            <p class="m-0 mt-0.5 text-white/95 leading-relaxed">{{ $siteInfo['address'] }}</p>
                        </div>
                    </div>

                    {{-- เบอร์โทรติดต่อ --}}
                    <div class="py-3 flex items-start gap-3">
                        <span class="w-9 h-9 rounded-xl bg-white/18 backdrop-blur-xs border border-white/25 text-white grid place-items-center text-sm shrink-0 mt-0.5 shadow-xs">
                            <i class="fa-solid fa-phone-volume" aria-hidden="true"></i>
                        </span>
                        <div>
                            <strong class="block text-xs font-semibold text-[#d3f9ed]">โทรศัพท์ติดต่อ</strong>
                            <p class="m-0 mt-0.5 text-white font-bold text-sm tracking-wide">{{ $siteInfo['phone'] }}</p>
                        </div>
                    </div>

                    {{-- เวลาทำการ --}}
                    <div class="py-3 flex items-start gap-3">
                        <span class="w-9 h-9 rounded-xl bg-white/18 backdrop-blur-xs border border-white/25 text-white grid place-items-center text-sm shrink-0 mt-0.5 shadow-xs">
                            <i class="fa-solid fa-clock" aria-hidden="true"></i>
                        </span>
                        <div class="space-y-1">
                            <strong class="block text-xs font-semibold text-[#d3f9ed]">วันและเวลาทำการ</strong>
                            <p class="m-0 text-xs text-white">
                                <span class="font-semibold text-[#fde68a]">จ. - ศ. :</span> {{ $siteInfo['hours_weekday'] }}
                            </p>
                            <p class="m-0 text-xs text-white/85">
                                <span class="font-semibold text-[#d3f9ed]">ส. - อา. :</span> {{ $siteInfo['hours_weekend'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ปุ่มทางลัดติดต่อ / แจ้งเรื่องร้องเรียน --}}
            <div class="relative z-10 pt-3 border-t border-white/20 flex flex-wrap items-center gap-2.5">
                <a href="{{ route('complaints.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white hover:bg-[#f5faf8] text-[#0d4f49] text-xs font-bold shadow-xs transition-all">
                    <i class="fa-solid fa-bullhorn text-[#d97706]" aria-hidden="true"></i>
                    <span>ศูนย์รับเรื่องร้องเรียน / ข้อเสนอแนะ</span>
                </a>

                <a href="{{ route('subordinate-units') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 text-white border border-white/30 backdrop-blur-xs text-xs font-semibold transition-all">
                    <i class="fa-solid fa-hospital-user text-[#d3f9ed]" aria-hidden="true"></i>
                    <span>หน่วยงานภายใต้สังกัด</span>
                </a>
            </div>
        </article>

            {{-- คอลัมน์ขวา: แผนที่ Google Map (iframe) --}}
            <article class="lg:col-span-6 phs-card p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <div>
                        <span class="phs-pill mb-1.5">แผนที่ตั้งหน่วยงาน</span>
                        <h3 class="text-[17px] font-bold text-[#124e49] m-0">แผนที่เดินทาง (Google Maps)</h3>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($siteInfo['org_name_th']) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#f5faf8] hover:bg-[#e8f5f1] text-[#124e49] border border-[#dcebe7] text-xs font-semibold transition-colors shrink-0">
                        <i class="fa-solid fa-diamond-turn-right text-[#168d83]" aria-hidden="true"></i>
                        <span>เปิดใน Google Maps</span>
                    </a>
                </div>

                <div class="w-full h-[320px] lg:h-full min-h-[300px] rounded-[14px] border border-[#dcebe7] bg-[#f5faf8] overflow-hidden relative">
                    @if(!empty($siteInfo['google_map_iframe']))
                        <div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                            {!! $siteInfo['google_map_iframe'] !!}
                        </div>
                    @else
                        <iframe
                            src="https://maps.google.com/maps?q={{ urlencode($siteInfo['org_name_th'] . ' ' . $siteInfo['address']) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            class="w-full h-full border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="แผนที่ {{ $siteInfo['org_name_th'] }}">
                        </iframe>
                    @endif
                </div>
            </article>
        </div>
    </section>
{{-- ===================================================================== --}}
    {{-- 8. POPUP ALERT ข่าวแจ้งเตือน (FROSTED GLASSMORPHISM UI - ขนาด XL)     --}}
    {{-- ===================================================================== --}}
    @php
        $alertSlide = \App\Models\HeroSlide::where('is_active', true)
            ->where('is_popup', true)
            ->orderBy('sort_order', 'asc')
            ->orderByDesc('id')
            ->first();

        $alertImage = $alertSlide?->image_path ?? $alertSlide?->image ?? $alertSlide?->cover_image ?? null;
        $alertDesc  = $alertSlide?->subtitle ?? $alertSlide?->description ?? $alertSlide?->summary ?? null;
        $alertLink  = $alertSlide?->link_url ?? $alertSlide?->url ?? null;
    @endphp

    @if($alertSlide)
        <div id="welcome-news-modal"
             role="dialog"
             aria-modal="true"
             aria-labelledby="welcome-news-title"
             style="display: none;"
             class="fixed inset-0 z-[9999] items-center justify-center p-4 sm:p-6 bg-[#073933]/60 backdrop-blur-md transition-opacity duration-300">

            <div class="relative w-full max-w-xl overflow-hidden rounded-[26px] bg-white/85 backdrop-blur-2xl border border-white/90 shadow-[0_24px_60px_rgba(7,57,51,0.35)] ring-1 ring-[#168d83]/20 animate-[fadeInScale_0.25s_ease-out]">

                <span class="pointer-events-none absolute -top-16 -left-16 w-48 h-48 rounded-full bg-[#22b8a8]/25 blur-3xl"></span>
                <span class="pointer-events-none absolute -bottom-16 -right-16 w-52 h-52 rounded-full bg-[#168d83]/25 blur-3xl"></span>

                <div class="relative z-10 px-6 py-4 bg-white/50 backdrop-blur-md border-b border-white/70 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-2xl text-white grid place-items-center text-base shrink-0 shadow-sm"
                              style="background: linear-gradient(135deg, #0d4f49 0%, #168d83 65%, #22b8a8 100%);">
                            <i class="fa-solid fa-bullhorn text-[#fde68a]" aria-hidden="true"></i>
                        </span>
                        <div>
                            <span class="block text-[10px] font-bold tracking-[1.5px] text-[#168d83] uppercase">PUBLICITY ANNOUNCEMENT</span>
                            <h3 id="welcome-news-title" class="text-sm sm:text-base font-bold text-[#124e49] m-0">
                                ข่าวประชาสัมพันธ์ / แจ้งเตือนสำคัญ
                            </h3>
                        </div>
                    </div>

                    <button type="button"
                            id="close-welcome-modal-x"
                            aria-label="ปิดหน้าต่างแจ้งเตือน"
                            class="w-8 h-8 rounded-full bg-white/75 hover:bg-white text-[#124e49] border border-[#dcebe7] grid place-items-center text-sm transition-all shadow-2xs cursor-pointer">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>

                @if(!empty($alertImage))
                    <div class="relative z-10 px-6 pt-5">
                        <div class="w-full max-h-80 rounded-[18px] bg-white/50 overflow-hidden border border-white/80 shadow-xs">
                            <img src="{{ str_starts_with($alertImage, 'http') ? $alertImage : asset($alertImage) }}"
                                 alt="{{ $alertSlide->title ?? 'ข่าวประชาสัมพันธ์' }}"
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                @endif

                <div class="relative z-10 p-6 space-y-3">
                    @if(!empty($alertSlide->title))
                        <h4 class="text-[18px] sm:text-[20px] font-bold text-[#124e49] leading-snug m-0">
                            {{ $alertSlide->title }}
                        </h4>
                    @endif

                    @if(!empty($alertDesc))
                        <p class="text-xs sm:text-[14px] text-[#3e5753] leading-relaxed m-0">
                            {{ $alertDesc }}
                        </p>
                    @endif

                    <div class="pt-4 border-t border-white/70 flex flex-wrap items-center justify-end gap-2.5">
                        <button type="button"
                                id="close-welcome-modal-btn"
                                class="px-4 py-2.5 rounded-xl bg-white/75 hover:bg-white text-[#124e49] border border-[#bce2d6] backdrop-blur-md text-xs font-semibold transition-all cursor-pointer">
                            รับทราบ / ปิดหน้าต่าง
                        </button>

                        @if(!empty($alertLink))
                            <a href="{{ $alertLink }}"
                               target="{{ str_starts_with($alertLink, 'http') ? '_blank' : '_self' }}"
                               rel="noopener noreferrer"
                               class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-[0_6px_18px_rgba(22,141,131,0.3)] hover:shadow-[0_8px_22px_rgba(22,141,131,0.4)] hover:-translate-y-0.5 transition-all inline-flex items-center gap-1.5"
                               style="background: linear-gradient(135deg, #0d4f49 0%, #168d83 65%, #22b8a8 100%);">
                                <span>ดูรายละเอียดเพิ่มเติม</span>
                                <i class="fa-solid fa-arrow-right text-[11px]" aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('scripts')
<style>
    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>

<script>
    // =========================================================================
    // ฟังก์ชันเปิด Modal แสดงรูปภาพทั้งหมดในอัลบั้ม (Global Scope สำหรับ onclick)
    // =========================================================================
    window.openAlbumGalleryModal = function (album, thaiDate) {
        const modal = document.getElementById('home-album-modal');
        const titleEl = document.getElementById('modal-album-title');
        const dateEl = document.getElementById('modal-album-date');
        const locationEl = document.getElementById('modal-album-location');
        const descEl = document.getElementById('modal-album-desc');
        const gridEl = document.getElementById('modal-album-photos-grid');

        if (!modal || !album) return;

        const baseAssetUrl = "{{ rtrim(asset(''), '/') }}";
        const resolveAssetUrl = (path) => {
            if (!path) return '';
            if (path.startsWith('http://') || path.startsWith('https://')) return path;
            return `${baseAssetUrl}/${path.replace(/^\/+/, '')}`;
        };

        // เติมข้อมูลส่วนหัวของอัลบั้ม
        titleEl.textContent = album.title || 'อัลบั้มภาพกิจกรรม';
        dateEl.innerHTML = `<i class="fa-regular fa-calendar mr-1"></i>${thaiDate || '-'}`;

        if (album.location) {
            locationEl.innerHTML = `<span class="text-[#dcebe7] mx-1">•</span><i class="fa-solid fa-location-dot mr-1"></i>${album.location}`;
            locationEl.classList.remove('hidden');
        } else {
            locationEl.innerHTML = '';
            locationEl.classList.add('hidden');
        }

        if (album.description) {
            descEl.textContent = album.description;
            descEl.classList.remove('hidden');
        } else {
            descEl.textContent = '';
            descEl.classList.add('hidden');
        }

        // เตรียมรายการรูปภาพ (รองรับทั้ง relation photos และ cover_image)
        gridEl.innerHTML = '';
        const rawPhotos = Array.isArray(album.photos) ? album.photos : [];
        const photoList = [];

        rawPhotos.forEach((p) => {
            const path = typeof p === 'string' ? p : (p.image_path || p.photo_path || p.path || p.file_path || p.image);
            const caption = typeof p === 'object' ? (p.caption || p.title || album.title) : album.title;
            if (path) {
                photoList.push({ url: resolveAssetUrl(path), caption });
            }
        });

        // หากไม่ได้โหลด relation photos มาด้วย ให้แสดงภาพหน้าปกเป็นค่าเริ่มต้น
        if (photoList.length === 0 && album.cover_image) {
            photoList.push({ url: resolveAssetUrl(album.cover_image), caption: album.title });
        }

        if (photoList.length > 0) {
            photoList.forEach((photo) => {
                const link = document.createElement('a');
                link.href = photo.url;
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                link.title = 'คลิกเพื่อดูภาพขนาดเต็ม';
                link.className = 'group relative aspect-square rounded-xl overflow-hidden bg-[#f5faf8] border border-[#dcebe7] block';

                const img = document.createElement('img');
                img.src = photo.url;
                img.alt = photo.caption || 'ภาพกิจกรรม';
                img.loading = 'lazy';
                img.className = 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300';

                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-[#042525]/0 group-hover:bg-[#042525]/35 transition-colors flex items-center justify-center';
                overlay.innerHTML = '<i class="fa-solid fa-magnifying-glass-plus text-white opacity-0 group-hover:opacity-100 transition-opacity text-lg drop-shadow"></i>';

                link.appendChild(img);
                link.appendChild(overlay);
                gridEl.appendChild(link);
            });
        } else {
            gridEl.innerHTML = `
                <div class="col-span-full py-8 text-center text-xs text-[#68817d]">
                    <i class="fa-regular fa-images text-2xl text-[#168d83]/50 mb-2 block"></i>
                    ไม่พบรายการรูปภาพในอัลบั้มนี้
                </div>
            `;
        }

        // เปิด Modal และล็อกการเลื่อนหน้าจอหลัก
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeAlbumGalleryModal = function () {
        const modal = document.getElementById('home-album-modal');
        if (!modal) return;
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };

    document.addEventListener('DOMContentLoaded', function () {
        // ผูกปุ่มปิดและคลิกพื้นหลังสำหรับ Album Modal (ทำงานได้แม้ไม่มี jQuery)
        const albumModal = document.getElementById('home-album-modal');
        if (albumModal) {
            const closeAlbumBtn = albumModal.querySelector('button[aria-label="ปิดหน้าต่าง"]');
            if (closeAlbumBtn) {
                closeAlbumBtn.removeAttribute('onclick');
                closeAlbumBtn.addEventListener('click', window.closeAlbumGalleryModal);
            }
            albumModal.addEventListener('click', function (e) {
                if (e.target === albumModal) window.closeAlbumGalleryModal();
            });
        }

        // 1. ระบบควบคุม Hero Slideshow (ตรงกับ class .slide / .dot ใน HTML)
        const slides = document.querySelectorAll('#hero-slideshow .slide');
        const dots = document.querySelectorAll('#hero-slideshow .dot');
        const prevBtn = document.getElementById('previous-slide');
        const nextBtn = document.getElementById('next-slide');

        if (slides.length > 1) {
            let currentIndex = 0;
            let slideInterval;

            function showSlide(index) {
                currentIndex = (index + slides.length) % slides.length;
                slides.forEach((slide, i) => {
                    const isActive = i === currentIndex;
                    slide.classList.toggle('active', isActive);
                    slide.classList.toggle('opacity-100', isActive);
                    slide.classList.toggle('opacity-0', !isActive);
                    slide.classList.toggle('pointer-events-none', !isActive);
                });

                dots.forEach((dot, i) => {
                    const isActive = i === currentIndex;
                    dot.classList.toggle('active', isActive);
                    dot.classList.toggle('w-[23px]', isActive);
                    dot.classList.toggle('bg-white', isActive);
                    dot.classList.toggle('w-[7px]', !isActive);
                    dot.classList.toggle('bg-white/60', !isActive);
                });
            }

            function startAutoSlide() {
                slideInterval = setInterval(() => showSlide(currentIndex + 1), 5500);
            }

            function resetAutoSlide() {
                clearInterval(slideInterval);
                startAutoSlide();
            }

            prevBtn?.addEventListener('click', () => {
                showSlide(currentIndex - 1);
                resetAutoSlide();
            });

            nextBtn?.addEventListener('click', () => {
                showSlide(currentIndex + 1);
                resetAutoSlide();
            });

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const target = parseInt(dot.getAttribute('data-index'), 10);
                    showSlide(target);
                    resetAutoSlide();
                });
            });

            startAutoSlide();
        }

        // 2. ระบบสลับหมวดหมู่ข่าวประชาสัมพันธ์
        const newsTabs = document.querySelectorAll('.news-tab-btn');
        const newsCards = document.querySelectorAll('.news-card-item');
        const emptyNewsMsg = document.getElementById('home-news-empty-filter');

        newsTabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const filter = this.getAttribute('data-news-filter');

                newsTabs.forEach(btn => {
                    btn.classList.remove('active', 'bg-[#124e49]', 'text-white');
                    btn.classList.add('bg-[#f5faf8]', 'text-[#124e49]', 'border', 'border-[#dcebe7]');
                });
                this.classList.add('active', 'bg-[#124e49]', 'text-white');
                this.classList.remove('bg-[#f5faf8]', 'text-[#124e49]', 'border', 'border-[#dcebe7]');

                let visibleCount = 0;
                newsCards.forEach(card => {
                    const match = filter === 'all' || card.getAttribute('data-category') === filter;
                    card.classList.toggle('hidden', !match);
                    if (match) visibleCount++;
                });

                if (emptyNewsMsg) {
                    emptyNewsMsg.classList.toggle('hidden', visibleCount > 0);
                }
            });
        });

        // 3. ระบบสลับมุมมองปฏิทิน Google Calendar (MONTH / AGENDA)
        const calButtons = document.querySelectorAll('.cal-mode-btn');
        const calFrame = document.getElementById('gcal-embed-frame');

        calButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const mode = this.getAttribute('data-cal-mode');
                calButtons.forEach(b => {
                    b.classList.remove('active', 'bg-[#124e49]', 'text-white');
                    b.classList.add('text-[#124e49]');
                });
                this.classList.add('active', 'bg-[#124e49]', 'text-white');
                this.classList.remove('text-[#124e49]');

                if (calFrame && mode) {
                    const url = new URL(calFrame.src);
                    url.searchParams.set('mode', mode);
                    calFrame.src = url.toString();
                }
            });
        });

        // 4. ระบบควบคุม Popup Alert (แสดงครั้งแรก หรือทุกๆ 12 ชั่วโมง)
        @if($alertSlide)
            const MODAL_KEY = 'ssophosai_hero_popup_{{ $alertSlide->id }}_last_shown';
            const TWELVE_HOURS_MS = 12 * 60 * 60 * 1000;

            const modal = document.getElementById('welcome-news-modal');
            const closeBtnX = document.getElementById('close-welcome-modal-x');
            const closeBtnMain = document.getElementById('close-welcome-modal-btn');

            if (modal) {
                function openModal() {
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }

                function closeModal() {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                    localStorage.setItem(MODAL_KEY, Date.now().toString());
                }

                const lastShown = localStorage.getItem(MODAL_KEY);
                const now = Date.now();

                if (!lastShown || (now - parseInt(lastShown, 10)) >= TWELVE_HOURS_MS) {
                    setTimeout(openModal, 350);
                }

                closeBtnX?.addEventListener('click', closeModal);
                closeBtnMain?.addEventListener('click', closeModal);

                modal.addEventListener('click', function (e) {
                    if (e.target === modal) closeModal();
                });
            }
        @endif

        // ปิด Modal ด้วยปุ่ม Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                if (albumModal && !albumModal.classList.contains('hidden')) {
                    window.closeAlbumGalleryModal();
                }
                const welcomeModal = document.getElementById('welcome-news-modal');
                if (welcomeModal && welcomeModal.style.display === 'flex') {
                    welcomeModal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            }
        });
    });
</script>
@endpush
