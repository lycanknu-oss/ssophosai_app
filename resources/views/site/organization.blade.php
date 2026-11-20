@extends('layouts.app')

@section('title', 'เกี่ยวกับองค์กร - ' . ($siteSettings['org_name_th'] ?? 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร'))

@section('content')
    {{-- Hero Header --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#3126C9] via-[#1675E8] to-[#3126C9] text-white p-8 sm:p-12 saas-shadow-lg mb-6">
        <div class="absolute inset-0 opacity-15 pointer-events-none"
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-xs border border-white/20 text-xs font-heading font-semibold tracking-wide mb-3">
                <i class="fa-solid fa-building-shield"></i>
                <span>ABOUT OUR ORGANIZATION</span>
            </span>
            <h1 class="text-[24px] sm:text-[32px] font-heading font-bold tracking-tight leading-tight m-0">
                เกี่ยวกับ{{ $siteSettings['org_name_th'] }}
            </h1>
            <p class="text-sm sm:text-base text-indigo-100 mt-2.5 mb-0 leading-relaxed">
                ข้อมูลพื้นฐานองค์กร นโยบาย วิสัยทัศน์ พันธกิจ โครงสร้างการบริหารงาน ทำเนียบผู้บริหาร บุคลากร และช่องทางการติดต่อราชการ
            </p>
        </div>
    </section>

    {{-- แถบ Switch Tab หลัก 4 หมวดหมู่ --}}
    <div class="saas-card p-2 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 mb-8" role="tablist">
        <button type="button"
                role="tab"
                aria-selected="true"
                data-main-tab="panel-overview"
                data-hash="#sec-overview"
                class="pub-main-tab flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs sm:text-[13px] font-heading font-semibold cursor-pointer transition-all bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow">
            <i class="fa-solid fa-file-lines"></i>
            <span>1. ข้อมูลพื้นฐานและนโยบาย</span>
        </button>

        <button type="button"
                role="tab"
                aria-selected="false"
                data-main-tab="panel-executives"
                data-hash="#sec-executives"
                class="pub-main-tab flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs sm:text-[13px] font-heading font-semibold cursor-pointer transition-all text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]">
            <i class="fa-solid fa-user-tie"></i>
            <span>2. ทำเนียบผู้บริหาร ({{ $executives->count() }})</span>
        </button>

        <button type="button"
                role="tab"
                aria-selected="false"
                data-main-tab="panel-staffs"
                data-hash="#sec-staffs"
                class="pub-main-tab flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs sm:text-[13px] font-heading font-semibold cursor-pointer transition-all text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]">
            <i class="fa-solid fa-users"></i>
            <span>3. บุคลากรและโครงสร้างงาน ({{ $staffs->count() }})</span>
        </button>

        <button type="button"
                role="tab"
                aria-selected="false"
                data-main-tab="panel-contact"
                data-hash="#sec-contact"
                class="pub-main-tab flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs sm:text-[13px] font-heading font-semibold cursor-pointer transition-all text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]">
            <i class="fa-solid fa-map-location-dot"></i>
            <span>4. เวลาทำการและแผนที่</span>
        </button>
    </div>

    {{-- ===================================================================== --}}
    {{-- TAB 1: ข้อมูลพื้นฐาน นโยบาย วิสัยทัศน์ โครงสร้าง และผังบุคลากร          --}}
    {{-- ===================================================================== --}}
    <section id="panel-overview" role="tabpanel" class="pub-main-panel space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
            <div>
                <span class="text-xs font-heading font-bold text-[#3126C9] uppercase tracking-wider">SECTION 01</span>
                <h2 class="text-[18px] sm:text-[22px] font-heading font-bold text-[#1E293B] m-0 mt-1">
                    ข้อมูลพื้นฐานองค์กร นโยบาย และโครงสร้าง
                </h2>
            </div>
        </div>

        @php
            $subIcons = [
                'general'        => 'fa-solid fa-building',
                'policy'         => 'fa-solid fa-scroll',
                'vision_mission' => 'fa-solid fa-bullseye',
                'structure'      => 'fa-solid fa-diagram-project',
                'staff_chart'    => 'fa-solid fa-users-rectangle',
            ];
            $availableKeys = array_keys($sections);
            $firstKey = $availableKeys[0] ?? 'general';
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            {{-- เมนูเลือกหัวข้อย่อยด้านซ้าย --}}
            <div class="lg:col-span-3 saas-card bg-white rounded-2xl border border-[#E8ECF4] p-2.5 saas-shadow space-y-1">
                @foreach($sections as $key => $label)
                    <button type="button"
                            data-public-sub="pub-sub-{{ $key }}"
                            class="pub-org-tab w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs sm:text-[13px] font-heading font-semibold text-left transition-all cursor-pointer {{ $key === $firstKey ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]' }}">
                        <i class="{{ $subIcons[$key] ?? 'fa-solid fa-file' }} w-4 text-center"></i>
                        <span>{{ $label }}</span>
                    </button>
                @endforeach
            </div>

            {{-- กล่องแสดงเนื้อหาด้านขวา --}}
            <div class="lg:col-span-9">
                @foreach($sections as $key => $label)
                    @php $item = $contents[$key] ?? null; @endphp
                    <div id="pub-sub-{{ $key }}" class="pub-org-panel saas-card bg-white rounded-2xl border border-[#E8ECF4] p-6 sm:p-8 saas-shadow {{ $key === $firstKey ? '' : 'hidden' }}">
                        <div class="flex items-center gap-3 pb-4 mb-6 border-b border-[#E8ECF4]">
                            <span class="w-10 h-10 rounded-xl bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-base shrink-0">
                                <i class="{{ $subIcons[$key] ?? 'fa-solid fa-file' }}"></i>
                            </span>
                            <div>
                                <h3 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0">
                                    {{ $item->title ?? $label }}
                                </h3>
                                @if($item?->updated_at)
                                    <span class="text-[12px] text-[#64748B]">
                                        ปรับปรุงข้อมูลล่าสุด: {{ $item->updated_at->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($item && (!empty($item->content) || !empty($item->image_path)))
                            @if(!empty($item->content))
                                <div class="prose prose-slate max-w-none text-[14px] sm:text-[15px] text-[#1E293B] leading-relaxed whitespace-pre-line">
                                    {{ $item->content }}
                                </div>
                            @endif

                            @if(!empty($item->image_path))
                                <div class="{{ !empty($item->content) ? 'mt-6 pt-6 border-t border-[#E8ECF4]' : '' }}">
                                    <div class="rounded-2xl border border-[#E8ECF4] bg-[#F8FAFC] p-3 sm:p-4 text-center">
                                        <a href="{{ asset($item->image_path) }}" target="_blank" title="คลิกเพื่อดูภาพขนาดเต็ม">
                                            <img src="{{ asset($item->image_path) }}"
                                                 alt="{{ $item->title ?? $label }}"
                                                 class="max-h-[650px] w-auto mx-auto rounded-xl object-contain">
                                        </a>
                                        <span class="inline-block mt-2.5 text-[12px] text-[#64748B]">
                                            <i class="fa-solid fa-magnifying-glass-plus mr-1"></i>คลิกที่รูปภาพเพื่อเปิดดูขนาดเต็ม
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="py-12 text-center text-xs sm:text-sm text-[#64748B]">
                                <i class="fa-regular fa-folder-open text-2xl text-slate-300 block mb-2"></i>
                                อยู่ระหว่างปรับปรุงข้อมูล{{ $label }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================================================================== --}}
    {{-- TAB 2: ทำเนียบผู้บริหาร                                              --}}
    {{-- ===================================================================== --}}
    <section id="panel-executives" role="tabpanel" class="pub-main-panel hidden space-y-6">
        <div>
            <span class="text-xs font-heading font-bold text-[#3126C9] uppercase tracking-wider">SECTION 02</span>
            <h2 class="text-[18px] sm:text-[22px] font-heading font-bold text-[#1E293B] m-0 mt-1">
                ทำเนียบผู้บริหาร
            </h2>
        </div>

        {{-- ผู้บริหารคนปัจจุบัน (Highlight Card) --}}
        @if($currentExecutive)
            <div class="saas-card bg-gradient-to-r from-[#EEF2FF] via-white to-[#F8FAFC] rounded-2xl border border-[#3126C9]/20 p-6 sm:p-8 saas-shadow flex flex-col sm:flex-row items-center gap-6">
                @if($currentExecutive->image_path)
                    <img src="{{ asset($currentExecutive->image_path) }}"
                         alt="{{ $currentExecutive->name }}"
                         class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl object-cover object-[center_20%] border-4 border-white shadow-md shrink-0">
                @else
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl bg-[#3126C9] text-white grid place-items-center text-4xl shrink-0">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                @endif

                <div class="text-center sm:text-left">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-[#13A678] text-xs font-heading font-bold mb-2">
                        <span class="w-2 h-2 rounded-full bg-[#13A678] animate-pulse"></span>
                        ผู้บริหารคนปัจจุบัน
                    </span>
                    <h3 class="text-xl sm:text-2xl font-heading font-bold text-[#1E293B] m-0">
                        {{ $currentExecutive->name }}
                    </h3>
                    <p class="text-sm sm:text-base font-medium text-[#3126C9] mt-1 mb-2">
                        {{ $currentExecutive->position }}
                    </p>
                    <div class="text-xs text-[#64748B]">
                        <i class="fa-regular fa-calendar-check mr-1 text-[#1675E8]"></i>
                        ดำรงตำแหน่งตั้งแต่ พ.ศ. <strong>{{ $currentExecutive->start_year ?: '-' }}</strong> ถึง <strong>ปัจจุบัน</strong>
                    </div>
                </div>
            </div>
        @endif

        {{-- ทำเนียบอดีตผู้บริหาร --}}
        @if($pastExecutives->isNotEmpty())
            <div class="saas-card bg-white rounded-2xl border border-[#E8ECF4] overflow-hidden saas-shadow">
                <div class="px-6 py-4 bg-[#F8FAFC] border-b border-[#E8ECF4] flex items-center justify-between">
                    <h3 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0">
                        ทำเนียบอดีตผู้บริหารหน่วยงาน
                    </h3>
                    <span class="text-xs text-[#64748B]">ทั้งหมด {{ $pastExecutives->count() }} ท่าน</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 divide-y md:divide-y-0 md:gap-px bg-[#E8ECF4]">
                    @foreach($pastExecutives as $exec)
                        <div class="bg-white p-5 flex items-center gap-4 hover:bg-[#F8FAFC] transition-colors">
                            @if($exec->image_path)
                                <img src="{{ asset($exec->image_path) }}"
                                     alt="{{ $exec->name }}"
                                     class="w-16 h-16 rounded-full object-cover object-[center_20%] border-2 border-[#E8ECF4] shrink-0">
                            @else
                                <div class="w-16 h-16 rounded-full bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-xl shrink-0">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                            @endif

                            <div class="min-w-0">
                                <h4 class="text-sm font-heading font-bold text-[#1E293B] m-0 truncate">
                                    {{ $exec->name }}
                                </h4>
                                <div class="text-xs text-[#64748B] mt-0.5 line-clamp-1">
                                    {{ $exec->position }}
                                </div>
                                <div class="text-[12px] text-[#64748B] mt-1">
                                    <i class="fa-regular fa-calendar mr-1 text-[#1675E8]"></i>
                                    พ.ศ. {{ $exec->start_year ?: '?' }} – {{ $exec->end_year }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif(!$currentExecutive)
            <div class="saas-card bg-white rounded-2xl border border-[#E8ECF4] p-10 text-center text-xs sm:text-sm text-[#64748B]">
                ยังไม่มีข้อมูลทำเนียบผู้บริหาร
            </div>
        @endif
    </section>

    {{-- ===================================================================== --}}
    {{-- TAB 3: บุคลากร / เจ้าหน้าที่ (แบ่ง 3 ระดับชั้น: ผู้บริหาร -> รอง/ผู้ช่วย -> หัวหน้ากลุ่มงานและเจ้าหน้าที่) --}}
    {{-- ===================================================================== --}}
    <section id="panel-staffs" role="tabpanel" class="pub-main-panel hidden space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="text-xs font-heading font-bold text-[#3126C9] uppercase tracking-wider">SECTION 03</span>
                <h2 class="text-[18px] sm:text-[22px] font-heading font-bold text-[#1E293B] m-0 mt-1">
                    คณะผู้บริหารและเจ้าหน้าที่
                </h2>
                <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-0.5">
                    ทำเนียบบุคลากร {{ $siteSettings['org_name_th'] }} แบ่งตามลำดับชั้นการบริหารงาน 3 ระดับ
                </p>
            </div>

            {{-- ตัวกรองตามกลุ่มงาน --}}
            @if($workgroups->isNotEmpty())
                <div class="flex flex-wrap items-center gap-2">
                    <label for="public-workgroup-filter" class="text-xs font-heading font-semibold text-[#1E293B]">
                        <i class="fa-solid fa-filter text-[#3126C9] mr-1"></i>กรองตามกลุ่มงาน:
                    </label>
                    <select id="public-workgroup-filter"
                            class="saas-input !py-2 !px-3.5 text-xs font-heading font-medium text-[#1E293B] cursor-pointer">
                        <option value="all">แสดงทุกกลุ่มงาน ({{ $staffs->count() }} คน)</option>
                        @foreach($workgroups as $wg)
                            <option value="{{ $wg->id }}">{{ $wg->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        @if($staffs->isNotEmpty())
            {{-- ============================================================= --}}
            {{-- ระดับที่ 1 (ชั้นบนสุด): ผู้บริหารสูงสุด (สาธารณสุขอำเภอ)       --}}
            {{-- ============================================================= --}}
            @if($topExecutives->isNotEmpty())
                <div id="org-layer-1" class="flex flex-col items-center">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1 rounded-full bg-amber-50 text-[#F49A22] border border-amber-200/80 text-xs font-heading font-bold mb-4 shadow-2xs">
                        <i class="fa-solid fa-crown"></i>
                        <span>ระดับที่ 1 • ผู้บริหารสูงสุด</span>
                    </span>

                    <div class="flex flex-wrap justify-center gap-6 w-full">
                        @foreach($topExecutives as $chief)
                            <div class="saas-card bg-white rounded-2xl border-2 border-[#3126C9]/20 p-6 saas-shadow w-full max-w-sm text-center hover:-translate-y-1 transition duration-300">
                                <div class="w-28 h-32 mx-auto rounded-2xl overflow-hidden border-4 border-[#EEF2FF] bg-[#F8FAFC] shadow-xs">
                                    @if($chief->image_path)
                                        <img src="{{ asset($chief->image_path) }}"
                                             alt="{{ $chief->name }}"
                                             class="w-full h-full object-cover object-[center_18%]">
                                    @else
                                        <div class="w-full h-full grid place-items-center bg-[#EEF2FF] text-[#3126C9] text-3xl">
                                            <i class="fa-solid fa-user-tie"></i>
                                        </div>
                                    @endif
                                </div>

                                <h3 class="text-[17px] sm:text-[18px] font-heading font-bold text-[#1E293B] m-0 mt-4">
                                    {{ $chief->name }}
                                </h3>
                                <div class="text-xs sm:text-sm font-semibold text-[#3126C9] mt-1">
                                    {{ $chief->position }}
                                </div>
                                @if($chief->admin_position)
                                    <div class="text-xs text-[#64748B] mt-0.5">
                                        {{ $chief->admin_position }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- เส้นเชื่อมจากระดับที่ 1 ลงสู่ระดับที่ 2 --}}
                    @if($deputyExecutives->isNotEmpty())
                        <div class="hidden lg:flex flex-col items-center w-full max-w-3xl mt-1">
                            <div class="w-0.5 h-6 bg-[#CBD5E1]"></div>
                            <div class="w-full h-0.5 bg-[#CBD5E1]"></div>
                            <div class="w-full flex justify-between">
                                <div class="w-0.5 h-6 bg-[#CBD5E1]"></div>
                                <div class="w-0.5 h-6 bg-[#CBD5E1]"></div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            {{-- ============================================================= --}}
            {{-- ระดับที่ 2 (ชั้นกลาง): รองผู้บริหาร และ ผู้ช่วยผู้บริหาร        --}}
            {{-- ============================================================= --}}
            @if($deputyExecutives->isNotEmpty())
                <div id="org-layer-2" class="space-y-4">
                    <div class="flex items-center justify-center">
                        <span class="inline-flex items-center gap-1.5 px-4 py-1 rounded-full bg-[#EEF2FF] text-[#3126C9] border border-[#3126C9]/20 text-xs font-heading font-bold">
                            <i class="fa-solid fa-user-shield"></i>
                            <span>ระดับที่ 2 • รองผู้บริหาร / ผู้ช่วยผู้บริหาร</span>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                        {{-- ฝั่งซ้าย: รอง/ผู้ช่วยผู้บริหาร ภารกิจด้านบริหาร --}}
                        <div class="flex flex-col items-center space-y-4">
                            @foreach($adminDeputies as $deputy)
                                <div class="staff-card saas-card bg-white rounded-2xl border border-[#1675E8]/30 p-5 saas-shadow w-full max-w-md text-center hover:-translate-y-1 transition duration-300"
                                     data-workgroup-id="{{ $deputy->workgroup_id ?? '' }}">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-sky-50 text-[#1675E8] text-[10px] font-heading font-semibold mb-2.5">
                                        {{ $deputy->priority_label }} • ภารกิจด้านบริหาร
                                    </span>

                                    <div class="w-24 h-28 mx-auto rounded-2xl overflow-hidden border-2 border-[#EEF2FF] bg-[#F8FAFC]">
                                        @if($deputy->image_path)
                                            <img src="{{ asset($deputy->image_path) }}" alt="{{ $deputy->name }}" class="w-full h-full object-cover object-[center_18%]">
                                        @else
                                            <div class="w-full h-full grid place-items-center bg-[#EEF2FF] text-[#3126C9] text-2xl">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <h4 class="text-[16px] font-heading font-bold text-[#1E293B] m-0 mt-3">
                                        {{ $deputy->name }}
                                    </h4>
                                    <div class="text-xs font-medium text-[#1675E8] mt-0.5">
                                        {{ $deputy->position }}
                                    </div>
                                    @if($deputy->admin_position)
                                        <div class="text-xs font-semibold text-[#3126C9] mt-0.5">
                                            {{ $deputy->admin_position }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- ฝั่งขวา: รอง/ผู้ช่วยผู้บริหาร ภารกิจด้านวิชาการและคุณภาพบริการ --}}
                        <div class="flex flex-col items-center space-y-4">
                            @foreach($academicDeputies as $deputy)
                                <div class="staff-card saas-card bg-white rounded-2xl border border-[#F49A22]/35 p-5 saas-shadow w-full max-w-md text-center hover:-translate-y-1 transition duration-300"
                                     data-workgroup-id="{{ $deputy->workgroup_id ?? '' }}">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-amber-50 text-[#B45309] text-[10px] font-heading font-semibold mb-2.5">
                                        {{ $deputy->priority_label }} • ภารกิจด้านวิชาการและคุณภาพบริการ
                                    </span>

                                    <div class="w-24 h-28 mx-auto rounded-2xl overflow-hidden border-2 border-amber-100 bg-[#F8FAFC]">
                                        @if($deputy->image_path)
                                            <img src="{{ asset($deputy->image_path) }}" alt="{{ $deputy->name }}" class="w-full h-full object-cover object-[center_18%]">
                                        @else
                                            <div class="w-full h-full grid place-items-center bg-amber-50 text-[#F49A22] text-2xl">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <h4 class="text-[16px] font-heading font-bold text-[#1E293B] m-0 mt-3">
                                        {{ $deputy->name }}
                                    </h4>
                                    <div class="text-xs font-medium text-[#1675E8] mt-0.5">
                                        {{ $deputy->position }}
                                    </div>
                                    @if($deputy->admin_position)
                                        <div class="text-xs font-semibold text-[#13A678] mt-0.5">
                                            {{ $deputy->admin_position }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- กรณีรอง/ผู้ช่วยผู้บริหารไม่ได้ระบุภารกิจ --}}
                    @if($unassignedDeputies->isNotEmpty())
                        <div class="flex flex-wrap justify-center gap-5 pt-2">
                            @foreach($unassignedDeputies as $deputy)
                                <div class="staff-card saas-card bg-white rounded-2xl border border-[#3126C9]/25 p-5 saas-shadow w-full max-w-sm text-center hover:-translate-y-1 transition duration-300"
                                     data-workgroup-id="{{ $deputy->workgroup_id ?? '' }}">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#EEF2FF] text-[#3126C9] text-[10px] font-heading font-semibold mb-2.5">
                                        {{ $deputy->priority_label }}
                                    </span>
                                    <div class="w-24 h-28 mx-auto rounded-2xl overflow-hidden border-2 border-[#EEF2FF] bg-[#F8FAFC]">
                                        @if($deputy->image_path)
                                            <img src="{{ asset($deputy->image_path) }}" alt="{{ $deputy->name }}" class="w-full h-full object-cover object-[center_18%]">
                                        @else
                                            <div class="w-full h-full grid place-items-center bg-[#EEF2FF] text-[#3126C9] text-2xl">
                                                <i class="fa-solid fa-user-tie"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <h4 class="text-[16px] font-heading font-bold text-[#1E293B] m-0 mt-3">{{ $deputy->name }}</h4>
                                    <div class="text-xs font-medium text-[#3126C9] mt-0.5">{{ $deputy->position }}</div>
                                    @if($deputy->admin_position)
                                        <div class="text-xs text-[#64748B] mt-0.5">{{ $deputy->admin_position }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- เส้นเชื่อมจากระดับที่ 2 ลงสู่ระดับที่ 3 --}}
                    <div class="hidden lg:flex justify-around w-full max-w-4xl mx-auto">
                        <div class="w-0.5 h-6 bg-[#CBD5E1]"></div>
                        <div class="w-0.5 h-6 bg-[#CBD5E1]"></div>
                    </div>
                </div>
            @endif

            {{-- ============================================================= --}}
            {{-- ระดับที่ 3 (Layer เดียวกัน): ภารกิจด้านบริหาร | ภารกิจด้านวิชาการและคุณภาพบริการ --}}
            {{-- ภายในแสดง: หัวหน้ากลุ่มงาน, หัวหน้ากลุ่มงาน | หัวหน้ากลุ่มงาน, หัวหน้ากลุ่มงาน และเจ้าหน้าที่ --}}
            {{-- ============================================================= --}}
            <div id="org-layer-3" class="space-y-4">
                <div class="flex items-center justify-center">
                    <span class="inline-flex items-center gap-1.5 px-4 py-1 rounded-full bg-emerald-50 text-[#13A678] border border-emerald-200 text-xs font-heading font-bold">
                        <i class="fa-solid fa-sitemap"></i>
                        <span>ระดับที่ 3 • หัวหน้ากลุ่มงานและเจ้าหน้าที่</span>
                    </span>
                </div>

                <div id="mission-columns-grid" class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">

                    {{-- ฝั่งซ้าย: ภารกิจด้านบริหาร (2 กลุ่มงานคู่กัน) --}}
                    <div class="mission-column rounded-3xl border border-[#1675E8]/25 bg-[#F8FAFC]/90 overflow-hidden saas-shadow"
                         data-mission="admin">
                        <div class="bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white px-5 py-3.5 flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-briefcase text-sm"></i>
                            <h3 class="text-sm sm:text-[16px] font-heading font-bold m-0">
                                ภารกิจด้านบริหาร
                            </h3>
                            <span class="mission-count ml-1 px-2 py-0.5 rounded-full bg-white/20 text-[11px] font-heading">
                                {{ $adminWorkgroupColumns->sum(fn ($c) => $c['staffs']->count()) }}
                            </span>
                        </div>

                        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 items-start workgroup-subgrid">
                            @foreach($adminWorkgroupColumns as $col)
                                @php $wg = $col['workgroup']; @endphp
                                <div class="workgroup-column rounded-2xl border border-[#E8ECF4] bg-white/70 p-3 space-y-3"
                                     data-workgroup-id="{{ $wg->id }}">
                                    {{-- หัวข้อกลุ่มงาน --}}
                                    <div class="px-3 py-2 rounded-xl bg-[#EEF2FF] border border-[#3126C9]/15 text-center">
                                        <span class="text-xs font-heading font-bold text-[#3126C9] leading-snug block">
                                            {{ Str::after($wg->name, ' : ') }}
                                        </span>
                                    </div>

                                    {{-- รายชื่อในกลุ่มงาน (หัวหน้ากลุ่มงานขึ้นก่อน -> ตามด้วยหัวหน้างาน/เจ้าหน้าที่) --}}
                                    <div class="space-y-3">
                                        @forelse($col['staffs'] as $staff)
                                            @php $isGroupHead = (int) $staff->workgroup_priority === 4; @endphp
                                            <div class="staff-card saas-card bg-white rounded-2xl p-4 saas-shadow text-center hover:-translate-y-1 transition duration-300 {{ $isGroupHead ? 'border-2 border-[#13A678]/45 ring-2 ring-emerald-50' : 'border border-[#E8ECF4]' }}"
                                                 data-workgroup-id="{{ $staff->workgroup_id ?? '' }}">

                                                @if($isGroupHead)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#13A678] border border-emerald-200 text-[10px] font-heading font-bold mb-2">
                                                        <i class="fa-solid fa-star"></i> หัวหน้ากลุ่มงาน
                                                    </span>
                                                @else
                                                    <span class="inline-block px-2 py-0.5 rounded-full bg-slate-100 text-[#64748B] text-[10px] font-heading font-medium mb-2">
                                                        เจ้าหน้าที่
                                                    </span>
                                                @endif

                                                <div class="w-20 h-24 mx-auto rounded-2xl overflow-hidden border-2 {{ $isGroupHead ? 'border-emerald-200' : 'border-[#EEF2FF]' }} bg-[#F8FAFC]">
                                                    @if($staff->image_path)
                                                        <img src="{{ asset($staff->image_path) }}"
                                                             alt="{{ $staff->name }}"
                                                             class="w-full h-full object-cover object-[center_18%]">
                                                    @else
                                                        <div class="w-full h-full grid place-items-center bg-[#EEF2FF] text-[#3126C9] text-xl">
                                                            <i class="fa-solid fa-user"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <h4 class="text-sm font-heading font-bold text-[#1E293B] m-0 mt-3 leading-snug">
                                                    {{ $staff->name }}
                                                </h4>
                                                <div class="text-[11px] font-medium text-[#1675E8] mt-0.5">
                                                    {{ $staff->position }}
                                                </div>

                                                @if($staff->admin_position)
                                                    <div class="text-[11px] font-semibold text-[#3126C9] mt-0.5">
                                                        {{ $staff->admin_position }}
                                                    </div>
                                                @endif

                                                @if($staff->job)
                                                    <div class="mt-2.5 pt-2.5 border-t border-[#E8ECF4] text-[11px] text-[#64748B]">
                                                        <i class="fa-solid fa-briefcase text-[#13A678] mr-1"></i>{{ $staff->job->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="p-6 text-center text-[11px] text-[#64748B] bg-white rounded-xl border border-dashed border-[#E8ECF4]">
                                                ยังไม่มีบุคลากรในกลุ่มงานนี้
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ฝั่งขวา: ภารกิจด้านวิชาการและคุณภาพบริการ (2 กลุ่มงานคู่กัน) --}}
                    <div class="mission-column rounded-3xl border border-[#F49A22]/25 bg-[#FFFBF5]/90 overflow-hidden saas-shadow"
                         data-mission="academic">
                        <div class="bg-gradient-to-r from-[#F49A22] to-[#F59E0B] text-white px-5 py-3.5 flex items-center justify-center gap-2.5">
                            <i class="fa-solid fa-hand-holding-medical text-sm"></i>
                            <h3 class="text-sm sm:text-[16px] font-heading font-bold m-0">
                                ภารกิจด้านวิชาการและคุณภาพบริการ
                            </h3>
                            <span class="mission-count ml-1 px-2 py-0.5 rounded-full bg-white/20 text-[11px] font-heading">
                                {{ $academicWorkgroupColumns->sum(fn ($c) => $c['staffs']->count()) }}
                            </span>
                        </div>

                        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 items-start workgroup-subgrid">
                            @foreach($academicWorkgroupColumns as $col)
                                @php $wg = $col['workgroup']; @endphp
                                <div class="workgroup-column rounded-2xl border border-amber-200/60 bg-white/70 p-3 space-y-3"
                                     data-workgroup-id="{{ $wg->id }}">
                                    {{-- หัวข้อกลุ่มงาน --}}
                                    <div class="px-3 py-2 rounded-xl bg-amber-50 border border-amber-200/80 text-center">
                                        <span class="text-xs font-heading font-bold text-[#B45309] leading-snug block">
                                            {{ Str::after($wg->name, ' : ') }}
                                        </span>
                                    </div>

                                    {{-- รายชื่อในกลุ่มงาน (หัวหน้ากลุ่มงานขึ้นก่อน -> ตามด้วยหัวหน้างาน/เจ้าหน้าที่) --}}
                                    <div class="space-y-3">
                                        @forelse($col['staffs'] as $staff)
                                            @php $isGroupHead = (int) $staff->workgroup_priority === 4; @endphp
                                            <div class="staff-card saas-card bg-white rounded-2xl p-4 saas-shadow text-center hover:-translate-y-1 transition duration-300 {{ $isGroupHead ? 'border-2 border-[#13A678]/45 ring-2 ring-emerald-50' : 'border border-[#E8ECF4]' }}"
                                                 data-workgroup-id="{{ $staff->workgroup_id ?? '' }}">

                                                @if($isGroupHead)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#13A678] border border-emerald-200 text-[10px] font-heading font-bold mb-2">
                                                        <i class="fa-solid fa-star"></i> หัวหน้ากลุ่มงาน
                                                    </span>
                                                @else
                                                    <span class="inline-block px-2 py-0.5 rounded-full bg-slate-100 text-[#64748B] text-[10px] font-heading font-medium mb-2">
                                                        เจ้าหน้าที่
                                                    </span>
                                                @endif

                                                <div class="w-20 h-24 mx-auto rounded-2xl overflow-hidden border-2 {{ $isGroupHead ? 'border-emerald-200' : 'border-amber-100' }} bg-[#F8FAFC]">
                                                    @if($staff->image_path)
                                                        <img src="{{ asset($staff->image_path) }}"
                                                             alt="{{ $staff->name }}"
                                                             class="w-full h-full object-cover object-[center_18%]">
                                                    @else
                                                        <div class="w-full h-full grid place-items-center bg-amber-50 text-[#F49A22] text-xl">
                                                            <i class="fa-solid fa-user"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <h4 class="text-sm font-heading font-bold text-[#1E293B] m-0 mt-3 leading-snug">
                                                    {{ $staff->name }}
                                                </h4>
                                                <div class="text-[11px] font-medium text-[#1675E8] mt-0.5">
                                                    {{ $staff->position }}
                                                </div>

                                                @if($staff->admin_position)
                                                    <div class="text-[11px] font-semibold text-[#13A678] mt-0.5">
                                                        {{ $staff->admin_position }}
                                                    </div>
                                                @endif

                                                @if($staff->job)
                                                    <div class="mt-2.5 pt-2.5 border-t border-[#E8ECF4] text-[11px] text-[#64748B]">
                                                        <i class="fa-solid fa-briefcase text-[#13A678] mr-1"></i>{{ $staff->job->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="p-6 text-center text-[11px] text-[#64748B] bg-white rounded-xl border border-dashed border-[#E8ECF4]">
                                                ยังไม่มีบุคลากรในกลุ่มงานนี้
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- กรณีมีบุคลากรที่ยังไม่ได้ระบุกลุ่มงาน --}}
            @if($unassignedStaffs->isNotEmpty())
                <div class="mission-column space-y-4 pt-2" data-mission="other">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-xl bg-slate-100 text-[#64748B] text-xs font-heading font-bold">
                            บุคลากร / เจ้าหน้าที่อื่น ๆ
                        </span>
                        <div class="h-px flex-1 bg-[#E8ECF4]"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($unassignedStaffs as $staff)
                            <div class="staff-card saas-card bg-white rounded-2xl border border-[#E8ECF4] p-5 saas-shadow text-center hover:-translate-y-1 transition duration-300"
                                 data-workgroup-id="">
                                <div class="w-20 h-24 mx-auto rounded-2xl overflow-hidden border-2 border-[#EEF2FF] bg-[#F8FAFC]">
                                    @if($staff->image_path)
                                        <img src="{{ asset($staff->image_path) }}" alt="{{ $staff->name }}" class="w-full h-full object-cover object-[center_18%]">
                                    @else
                                        <div class="w-full h-full grid place-items-center bg-[#EEF2FF] text-[#3126C9] text-xl">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <h4 class="text-sm font-heading font-bold text-[#1E293B] m-0 mt-3">{{ $staff->name }}</h4>
                                <div class="text-xs text-[#3126C9] mt-0.5">{{ $staff->position }}</div>
                                @if($staff->admin_position)
                                    <div class="text-[11px] text-[#13A678] font-semibold mt-0.5">{{ $staff->admin_position }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <div class="saas-card bg-white rounded-2xl border border-[#E8ECF4] p-10 text-center text-xs sm:text-sm text-[#64748B]">
                ยังไม่มีข้อมูลบุคลากรในระบบ
            </div>
        @endif
    </section>

    {{-- ===================================================================== --}}
    {{-- TAB 4: เวลาทำการและแผนที่ตั้งหน่วยงาน                                --}}
    {{-- ===================================================================== --}}
    <section id="panel-contact" role="tabpanel" class="pub-main-panel hidden space-y-6">
        <div>
            <span class="text-xs font-heading font-bold text-[#3126C9] uppercase tracking-wider">SECTION 04</span>
            <h2 class="text-[18px] sm:text-[22px] font-heading font-bold text-[#1E293B] m-0 mt-1">
                เวลาทำการและแผนที่ตั้งหน่วยงาน
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            <div class="lg:col-span-5 saas-card bg-white rounded-2xl border border-[#E8ECF4] p-6 sm:p-8 saas-shadow flex flex-col justify-between space-y-6">
                <div class="space-y-5">
                    <div class="flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-base shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <div>
                            <h3 class="text-xs font-heading font-bold text-[#64748B] uppercase m-0">ที่ตั้งสำนักงาน</h3>
                            <p class="text-sm font-semibold text-[#1E293B] m-0 mt-1">{{ $siteSettings['org_name_th'] }}</p>
                            <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-0.5 leading-relaxed">{{ $siteSettings['address'] }}</p>
                        </div>
                    </div>

                    @if(!empty($siteSettings['phone']))
                        <div class="flex items-start gap-3.5">
                            <span class="w-10 h-10 rounded-xl bg-sky-50 text-[#1675E8] grid place-items-center text-base shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <div>
                                <h3 class="text-xs font-heading font-bold text-[#64748B] uppercase m-0">โทรศัพท์ติดต่อราชการ</h3>
                                <p class="text-sm sm:text-base font-heading font-bold text-[#1E293B] m-0 mt-1">
                                    <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSettings['phone']) }}" class="hover:text-[#3126C9] transition-colors">
                                        {{ $siteSettings['phone'] }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#13A678] grid place-items-center text-base shrink-0">
                            <i class="fa-solid fa-clock"></i>
                        </span>
                        <div>
                            <h3 class="text-xs font-heading font-bold text-[#64748B] uppercase m-0">วันและเวลาทำการ</h3>
                            <p class="text-xs sm:text-sm font-medium text-[#1E293B] m-0 mt-1">
                                {{ $siteSettings['hours_weekday'] }}
                            </p>
                            <p class="text-xs text-rose-600 m-0 mt-1">
                                {{ $siteSettings['hours_weekend'] }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-[#E8ECF4]">
                    <a href="https://maps.google.com/?q={{ urlencode($siteSettings['org_name_th'] . ' ' . $siteSettings['address']) }}"
                       target="_blank"
                       class="btn-saas-primary w-full inline-flex items-center justify-center gap-2 !py-3 !px-5 text-xs sm:text-sm font-heading font-semibold">
                        <i class="fa-solid fa-diamond-turn-right"></i>
                        <span>เปิดนำทางด้วย Google Maps</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-7 saas-card bg-white rounded-2xl border border-[#E8ECF4] overflow-hidden saas-shadow min-h-[340px]">
                @if(!empty($siteSettings['google_map_iframe']))
                    <div class="w-full h-full min-h-[340px] [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:min-h-[340px] [&>iframe]:border-0">
                        {!! $siteSettings['google_map_iframe'] !!}
                    </div>
                @else
                    <iframe
                        src="https://maps.google.com/maps?q={{ urlencode($siteSettings['org_name_th'] . ' ' . $siteSettings['address']) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        class="w-full h-full min-h-[340px] border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. ระบบ Switch Tab หลัก 4 หมวดหมู่
        const mainTabs = document.querySelectorAll('.pub-main-tab');
        const mainPanels = document.querySelectorAll('.pub-main-panel');

        function activateMainTab(targetPanelId, updateHash = true) {
            mainTabs.forEach(tab => {
                const isTarget = tab.getAttribute('data-main-tab') === targetPanelId;
                tab.setAttribute('aria-selected', isTarget ? 'true' : 'false');

                if (isTarget) {
                    tab.classList.add('bg-gradient-to-r', 'from-[#3126C9]', 'to-[#1675E8]', 'text-white', 'saas-shadow-glow');
                    tab.classList.remove('text-[#64748B]', 'hover:bg-[#F8FAFC]', 'hover:text-[#1E293B]');
                    if (updateHash && tab.dataset.hash) {
                        history.replaceState(null, '', tab.dataset.hash);
                    }
                } else {
                    tab.classList.remove('bg-gradient-to-r', 'from-[#3126C9]', 'to-[#1675E8]', 'text-white', 'saas-shadow-glow');
                    tab.classList.add('text-[#64748B]', 'hover:bg-[#F8FAFC]', 'hover:text-[#1E293B]');
                }
            });

            mainPanels.forEach(panel => {
                panel.classList.toggle('hidden', panel.id !== targetPanelId);
            });
        }

        mainTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                activateMainTab(tab.getAttribute('data-main-tab'), true);
            });
        });

        // รองรับการเปิดแท็บตรงจาก URL Hash เช่น /organization#sec-staffs
        const hashMap = {
            '#sec-overview': 'panel-overview',
            '#sec-executives': 'panel-executives',
            '#sec-staffs': 'panel-staffs',
            '#sec-contact': 'panel-contact',
        };
        if (window.location.hash && hashMap[window.location.hash]) {
            activateMainTab(hashMap[window.location.hash], false);
        }

        // 2. สลับแท็บหัวข้อย่อยในหมวดที่ 1
        const subButtons = document.querySelectorAll('.pub-org-tab');
        const subPanels = document.querySelectorAll('.pub-org-panel');

        subButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-public-sub');

                subButtons.forEach(b => {
                    b.classList.remove('bg-gradient-to-r', 'from-[#3126C9]', 'to-[#1675E8]', 'text-white', 'saas-shadow-glow');
                    b.classList.add('text-[#64748B]', 'hover:bg-[#F8FAFC]', 'hover:text-[#1E293B]');
                });

                btn.classList.add('bg-gradient-to-r', 'from-[#3126C9]', 'to-[#1675E8]', 'text-white', 'saas-shadow-glow');
                btn.classList.remove('text-[#64748B]', 'hover:bg-[#F8FAFC]', 'hover:text-[#1E293B]');

                subPanels.forEach(panel => {
                    panel.classList.toggle('hidden', panel.id !== targetId);
                });
            });
        });

        // 3. กรองรายชื่อบุคลากรตามกลุ่มงาน (รองรับระดับ 2 และระดับ 3 แบบ 4 คอลัมน์กลุ่มงาน)
        const wgFilter = document.getElementById('public-workgroup-filter');
        if (wgFilter) {
            wgFilter.addEventListener('change', function () {
                const selectedWg = this.value;
                const layer1 = document.getElementById('org-layer-1');
                const layer2 = document.getElementById('org-layer-2');
                const missionGrid = document.getElementById('mission-columns-grid');
                const columns = document.querySelectorAll('.mission-column');

                if (layer1) {
                    layer1.classList.toggle('hidden', selectedWg !== 'all');
                }

                // กรองการ์ดในระดับที่ 2 (รอง/ผู้ช่วยผู้บริหาร)
                if (layer2) {
                    const deputyCards = layer2.querySelectorAll('.staff-card');
                    let visibleDeputies = 0;
                    deputyCards.forEach(card => {
                        const isMatch = selectedWg === 'all' || card.getAttribute('data-workgroup-id') === selectedWg;
                        card.classList.toggle('hidden', !isMatch);
                        if (isMatch) visibleDeputies++;
                    });
                    layer2.classList.toggle('hidden', visibleDeputies === 0);
                }

                // กรองการ์ดในระดับที่ 3 (4 กลุ่มงานภายใต้ 2 ภารกิจ)
                let visibleColumns = 0;
                columns.forEach(col => {
                    const wgCols = col.querySelectorAll('.workgroup-column');
                    const subGrid = col.querySelector('.workgroup-subgrid');
                    let missionVisibleCards = 0;

                    if (wgCols.length > 0) {
                        wgCols.forEach(wgCol => {
                            const isWgMatch = selectedWg === 'all' || wgCol.getAttribute('data-workgroup-id') === selectedWg;
                            wgCol.classList.toggle('hidden', !isWgMatch);
                            if (isWgMatch) {
                                missionVisibleCards += wgCol.querySelectorAll('.staff-card').length;
                            }
                        });
                        if (subGrid) {
                            subGrid.classList.toggle('md:grid-cols-1', selectedWg !== 'all');
                            subGrid.classList.toggle('md:grid-cols-2', selectedWg === 'all');
                        }
                    } else {
                        const cards = col.querySelectorAll('.staff-card');
                        cards.forEach(card => {
                            const isMatch = selectedWg === 'all' || card.getAttribute('data-workgroup-id') === selectedWg;
                            card.classList.toggle('hidden', !isMatch);
                            if (isMatch) missionVisibleCards++;
                        });
                    }

                    const countBadge = col.querySelector('.mission-count');
                    if (countBadge) {
                        countBadge.textContent = missionVisibleCards;
                    }

                    const showColumn = selectedWg === 'all' || missionVisibleCards > 0;
                    col.classList.toggle('hidden', !showColumn);
                    if (showColumn && col.dataset.mission !== 'other') {
                        visibleColumns++;
                    }
                });

                if (missionGrid) {
                    missionGrid.classList.toggle('xl:grid-cols-1', visibleColumns === 1);
                    missionGrid.classList.toggle('xl:grid-cols-2', visibleColumns !== 1);
                }
            });
        }
    });
</script>
@endpush
