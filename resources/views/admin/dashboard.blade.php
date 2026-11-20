@extends('admin.layouts.app')

@section('title', 'แดชบอร์ดผู้ดูแลระบบ - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('page-header')
    <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[11px] font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full mb-2">
                <i class="fa-solid fa-gauge-high"></i> ADMIN DASHBOARD OVERVIEW
            </span>
            <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                ระบบบริหารจัดการเว็บไซต์ สำนักงานสาธารณสุขอำเภอโพธิ์ไทร
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-1">
                ยินดีต้อนรับ, <strong class="text-[#1E293B]">{{ auth()->user()->name ?? 'ผู้ดูแลระบบ' }}</strong> • ภาพรวมข้อมูลองค์กร บุคลากร ข่าวประชาสัมพันธ์ และเอกสารเผยแพร่
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-center shrink-0">
            <a href="{{ url('/') }}" target="_blank"
               class="inline-flex items-center gap-2 bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold px-4 py-2.5 rounded-xl transition-colors">
                <i class="fa-solid fa-globe"></i>
                <span>ดูหน้าเว็บไซต์หลัก</span>
            </a>

            @if(Route::has('admin.organization.index'))
                <a href="{{ route('admin.organization.index') }}"
                   class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-4 inline-flex items-center gap-2">
                    <i class="fa-solid fa-sitemap"></i>
                    <span>จัดการข้อมูลองค์กร</span>
                </a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    @php
        $staffCount     = $stats['staffs'] ?? (\App\Models\OrganizationStaff::where('is_active', true)->count());
        $executiveCount = $stats['executives'] ?? (\App\Models\OrganizationExecutive::where('is_active', true)->count());
        $workgroupCount = $stats['workgroups'] ?? (\App\Models\OrganizationWorkgroup::where('is_active', true)->count());
        $jobCount       = $stats['jobs'] ?? (\App\Models\OrganizationJob::where('is_active', true)->count());

        $recentStaffs = $recentStaffs ?? \App\Models\OrganizationStaff::with(['workgroup', 'job'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $orgSections = \App\Models\OrganizationContent::sections();
        $orgContents = \App\Models\OrganizationContent::all()->keyBy('section_key');
    @endphp

    {{-- แถวที่ 1: การ์ดสรุปสถิติข้อมูลองค์กรและบุคลากร (KPI Cards) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        {{-- บุคลากรทั้งหมด --}}
        <div class="saas-card p-5 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow hover:-translate-y-1 transition duration-300">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-heading font-semibold text-[#64748B]">บุคลากร / เจ้าหน้าที่</span>
                    <div class="text-[28px] font-heading font-bold text-[#1E293B] mt-1 leading-none">
                        {{ number_format($staffCount) }}
                        <span class="text-xs font-normal text-[#64748B]">คน</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-lg shrink-0">
                    <i class="fa-solid fa-users"></i>
                </span>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E8ECF4] flex items-center justify-between text-[11px]">
                <span class="text-[#13A678] font-medium">
                    <i class="fa-solid fa-circle-check mr-1"></i>แสดงผลบนหน้าเว็บ
                </span>
                @if(Route::has('admin.organization.index'))
                    <a href="{{ route('admin.organization.index') }}?priority=all" class="font-heading font-semibold text-[#3126C9] hover:underline">
                        จัดการ <i class="fa-solid fa-arrow-right ml-0.5"></i>
                    </a>
                @endif
            </div>
        </div>

        {{-- ทำเนียบผู้บริหาร --}}
        <div class="saas-card p-5 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow hover:-translate-y-1 transition duration-300">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-heading font-semibold text-[#64748B]">ทำเนียบผู้บริหาร</span>
                    <div class="text-[28px] font-heading font-bold text-[#1E293B] mt-1 leading-none">
                        {{ number_format($executiveCount) }}
                        <span class="text-xs font-normal text-[#64748B]">ท่าน</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-sky-50 text-[#1675E8] grid place-items-center text-lg shrink-0">
                    <i class="fa-solid fa-user-tie"></i>
                </span>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E8ECF4] flex items-center justify-between text-[11px]">
                <span class="text-[#64748B]">ผู้บริหารปัจจุบันและอดีต</span>
                @if(Route::has('admin.organization.index'))
                    <a href="{{ route('admin.organization.index') }}" class="font-heading font-semibold text-[#1675E8] hover:underline">
                        ดูทำเนียบ <i class="fa-solid fa-arrow-right ml-0.5"></i>
                    </a>
                @endif
            </div>
        </div>

        {{-- กลุ่มงานตามโครงสร้าง สสอ. --}}
        <div class="saas-card p-5 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow hover:-translate-y-1 transition duration-300">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-heading font-semibold text-[#64748B]">โครงสร้างกลุ่มงาน</span>
                    <div class="text-[28px] font-heading font-bold text-[#1E293B] mt-1 leading-none">
                        {{ number_format($workgroupCount) }}
                        <span class="text-xs font-normal text-[#64748B]">กลุ่มงาน</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-emerald-50 text-[#13A678] grid place-items-center text-lg shrink-0">
                    <i class="fa-solid fa-layer-group"></i>
                </span>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E8ECF4] flex items-center justify-between text-[11px]">
                <span class="text-[#64748B]">แบ่งตาม 2 ภารกิจหลัก</span>
                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-[#13A678] font-heading font-semibold">เกณฑ์ปี 65-69</span>
            </div>
        </div>

        {{-- งานย่อยในความรับผิดชอบ --}}
        <div class="saas-card p-5 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow hover:-translate-y-1 transition duration-300">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-heading font-semibold text-[#64748B]">งานย่อยตามโครงสร้าง</span>
                    <div class="text-[28px] font-heading font-bold text-[#1E293B] mt-1 leading-none">
                        {{ number_format($jobCount) }}
                        <span class="text-xs font-normal text-[#64748B]">งาน</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-amber-50 text-[#F49A22] grid place-items-center text-lg shrink-0">
                    <i class="fa-solid fa-briefcase"></i>
                </span>
            </div>
            <div class="mt-4 pt-3 border-t border-[#E8ECF4] flex items-center justify-between text-[11px]">
                <span class="text-[#64748B]">ฐานข้อมูลงาน สสอ.</span>
                <span class="px-2 py-0.5 rounded-full bg-amber-50 text-[#F49A22] font-heading font-semibold">Active</span>
            </div>
        </div>
    </div>

    {{-- แถวที่ 2: เมนูลัดเข้าถึงระบบงาน + สถานะความครบถ้วนของข้อมูลองค์กร --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {{-- เมนูลัดจัดการระบบ (Quick Actions) --}}
        <div class="lg:col-span-7 saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow space-y-5">
            <div class="flex items-center justify-between pb-3.5 border-b border-[#E8ECF4]">
                <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm">
                        <i class="fa-solid fa-bolt"></i>
                    </span>
                    <span>เมนูลัดการจัดการข้อมูล</span>
                </h2>
                <span class="text-[11px] text-[#64748B]">Quick Access</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                @if(Route::has('admin.organization.index'))
                    <a href="{{ route('admin.organization.index') }}"
                       class="group p-4 rounded-2xl border border-[#E8ECF4] bg-[#F8FAFC] hover:bg-[#EEF2FF] hover:border-[#3126C9]/30 transition-all flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#3126C9] to-[#1675E8] text-white grid place-items-center text-sm shrink-0 shadow-xs">
                            <i class="fa-solid fa-sitemap"></i>
                        </span>
                        <div>
                            <h3 class="text-xs sm:text-sm font-heading font-bold text-[#1E293B] group-hover:text-[#3126C9] m-0">
                                จัดการข้อมูลองค์กร
                            </h3>
                            <p class="text-[11px] text-[#64748B] m-0 mt-1 leading-relaxed">
                                ข้อมูลพื้นฐาน นโยบาย วิสัยทัศน์ โครงสร้าง และผังบุคลากร
                            </p>
                        </div>
                    </a>

                    <a href="{{ route('admin.organization.index') }}?priority=all"
                       class="group p-4 rounded-2xl border border-[#E8ECF4] bg-[#F8FAFC] hover:bg-emerald-50/70 hover:border-[#13A678]/30 transition-all flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#13A678] to-[#10B981] text-white grid place-items-center text-sm shrink-0 shadow-xs">
                            <i class="fa-solid fa-users-gear"></i>
                        </span>
                        <div>
                            <h3 class="text-xs sm:text-sm font-heading font-bold text-[#1E293B] group-hover:text-[#13A678] m-0">
                                ทำเนียบบุคลากรและกลุ่มงาน
                            </h3>
                            <p class="text-[11px] text-[#64748B] m-0 mt-1 leading-relaxed">
                                เพิ่ม/แก้ไขเจ้าหน้าที่ กำหนดลำดับชั้น กลุ่มงาน และงานรับผิดชอบ
                            </p>
                        </div>
                    </a>
                @endif

                @if(Route::has('admin.news.index'))
                    <a href="{{ route('admin.news.index') }}"
                       class="group p-4 rounded-2xl border border-[#E8ECF4] bg-[#F8FAFC] hover:bg-sky-50/70 hover:border-[#1675E8]/30 transition-all flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-[#1675E8] text-white grid place-items-center text-sm shrink-0 shadow-xs">
                            <i class="fa-solid fa-newspaper"></i>
                        </span>
                        <div>
                            <h3 class="text-xs sm:text-sm font-heading font-bold text-[#1E293B] group-hover:text-[#1675E8] m-0">
                                ข่าวประชาสัมพันธ์และกิจกรรม
                            </h3>
                            <p class="text-[11px] text-[#64748B] m-0 mt-1 leading-relaxed">
                                เผยแพร่ข่าวสาร ประกาศจัดซื้อจัดจ้าง และภาพกิจกรรมหน่วยงาน
                            </p>
                        </div>
                    </a>
                @endif

                @if(Route::has('admin.ita.index'))
                    <a href="{{ route('admin.ita.index') }}"
                       class="group p-4 rounded-2xl border border-[#E8ECF4] bg-[#F8FAFC] hover:bg-amber-50/70 hover:border-[#F49A22]/30 transition-all flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-[#F49A22] text-white grid place-items-center text-sm shrink-0 shadow-xs">
                            <i class="fa-solid fa-shield-halved"></i>
                        </span>
                        <div>
                            <h3 class="text-xs sm:text-sm font-heading font-bold text-[#1E293B] group-hover:text-[#F49A22] m-0">
                                ประเมินคุณธรรมและความโปร่งใส (ITA)
                            </h3>
                            <p class="text-[11px] text-[#64748B] m-0 mt-1 leading-relaxed">
                                อัปโหลดเอกสาร OIT และจัดการข้อมูลเปิดเผยสาธารณะ
                            </p>
                        </div>
                    </a>
                @endif

                @if(Route::has('organization'))
                    <a href="{{ route('organization') }}#sec-staffs" target="_blank"
                       class="group p-4 rounded-2xl border border-[#E8ECF4] bg-[#F8FAFC] hover:bg-[#EEF2FF] hover:border-[#3126C9]/30 transition-all flex items-start gap-3.5">
                        <span class="w-10 h-10 rounded-xl bg-[#675CF0] text-white grid place-items-center text-sm shrink-0 shadow-xs">
                            <i class="fa-solid fa-diagram-project"></i>
                        </span>
                        <div>
                            <h3 class="text-xs sm:text-sm font-heading font-bold text-[#1E293B] group-hover:text-[#3126C9] m-0">
                                ตรวจสอบผังบุคลากรหน้าเว็บ
                            </h3>
                            <p class="text-[11px] text-[#64748B] m-0 mt-1 leading-relaxed">
                                เปิดดูการแสดงผลผังบุคลากร 3 ระดับชั้นบนหน้าเว็บไซต์หลัก
                            </p>
                        </div>
                    </a>
                @endif
            </div>
        </div>

        {{-- สถานะความครบถ้วนของข้อมูลองค์กร 5 หัวข้อย่อย --}}
        <div class="lg:col-span-5 saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow space-y-4">
            <div class="flex items-center justify-between pb-3.5 border-b border-[#E8ECF4]">
                <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-emerald-50 text-[#13A678] grid place-items-center text-sm">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </span>
                    <span>สถานะข้อมูลพื้นฐานองค์กร</span>
                </h2>
                <span class="text-[11px] font-heading font-semibold text-[#13A678]">
                    {{ $orgContents->count() }}/{{ count($orgSections) }} หัวข้อ
                </span>
            </div>

            <ul class="divide-y divide-[#E8ECF4] m-0 p-0 list-none">
                @foreach($orgSections as $secKey => $secLabel)
                    @php
                        $secRecord = $orgContents[$secKey] ?? null;
                        $hasData   = $secRecord && (!empty($secRecord->content) || !empty($secRecord->image_path));
                    @endphp
                    <li class="py-3 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="text-xs font-heading font-semibold text-[#1E293B] truncate">
                                {{ $secLabel }}
                            </div>
                            <div class="text-[11px] text-[#64748B] mt-0.5">
                                @if($secRecord?->updated_at)
                                    อัปเดตเมื่อ {{ $secRecord->updated_at->format('d/m/Y H:i') }}
                                @else
                                    ยังไม่ได้บันทึกข้อมูล
                                @endif
                            </div>
                        </div>

                        @if($hasData)
                            <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-[#13A678] border border-emerald-200/80 text-[10px] font-heading font-semibold shrink-0">
                                <i class="fa-solid fa-check mr-1"></i>พร้อมแสดงผล
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-full bg-amber-50 text-[#F49A22] border border-amber-200/80 text-[10px] font-heading font-semibold shrink-0">
                                <i class="fa-solid fa-clock mr-1"></i>รอดำเนินการ
                            </span>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- แถวที่ 3: ตารางอัปเดตข้อมูลบุคลากรล่าสุด (Material Design 3 Clean Table) --}}
    <div class="saas-card bg-white rounded-2xl border border-[#E8ECF4] overflow-hidden saas-shadow">
        <div class="p-5 border-b border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0">
                    อัปเดตข้อมูลบุคลากรล่าสุด
                </h2>
                <p class="text-xs text-[#64748B] m-0 mt-0.5">
                    รายการเจ้าหน้าที่ที่เพิ่มหรือแก้ไขข้อมูลล่าสุด 5 รายการ
                </p>
            </div>

            @if(Route::has('admin.organization.index'))
                <a href="{{ route('admin.organization.index') }}?priority=all"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white text-xs font-heading font-semibold transition-colors self-start sm:self-center">
                    <span>ดูบุคลากรทั้งหมด</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                        <th class="p-4 w-16 text-center">รูป</th>
                        <th class="p-4">ชื่อ - นามสกุล</th>
                        <th class="p-4">ตำแหน่ง</th>
                        <th class="p-4">กลุ่มงาน / งานที่รับผิดชอบ</th>
                        <th class="p-4 text-center">ระดับ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                    @forelse($recentStaffs as $staff)
                        <tr class="hover:bg-[#F8FAFC] transition-colors">
                            <td class="p-4 text-center">
                                @if($staff->image_path)
                                    <img src="{{ asset($staff->image_path) }}" alt="{{ $staff->name }}"
                                         class="w-10 h-10 rounded-full object-cover object-[center_20%] border border-[#E8ECF4] mx-auto">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm mx-auto">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="font-heading font-semibold text-sm text-[#1E293B]">{{ $staff->name }}</div>
                                @if($staff->admin_position)
                                    <div class="text-[11px] text-[#3126C9] mt-0.5">{{ $staff->admin_position }}</div>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="font-medium">{{ $staff->position }}</div>
                                @if($staff->employment_type)
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-slate-100 text-[#64748B] text-[10px] font-heading">
                                        {{ $staff->employment_type }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 space-y-0.5">
                                @if($staff->workgroup)
                                    <div class="text-[11px] font-semibold text-[#1E293B]">
                                        <i class="fa-solid fa-layer-group text-[#1675E8] mr-1"></i>{{ $staff->workgroup->name }}
                                    </div>
                                @else
                                    <span class="text-[11px] text-[#64748B]">- ไม่ระบุกลุ่มงาน -</span>
                                @endif
                                @if($staff->job)
                                    <div class="text-[11px] text-[#64748B]">
                                        <i class="fa-solid fa-briefcase text-[#13A678] mr-1"></i>{{ $staff->job->name }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#EEF2FF] text-[#3126C9] text-[10px] font-heading font-semibold">
                                    {{ $staff->priority_label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-[#64748B]">
                                ยังไม่มีข้อมูลบุคลากรในระบบ
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
