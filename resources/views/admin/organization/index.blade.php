@extends('admin.layouts.app')

@section('title', 'จัดการข้อมูลองค์กร - Admin Dashboard')

@section('page-header')
    <div class="saas-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[11px] font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full mb-2">
                <i class="fa-solid fa-sitemap"></i> ORGANIZATION MANAGEMENT
            </span>
            <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                จัดการข้อมูลองค์กร
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-1">
                จัดการข้อมูลพื้นฐานองค์กร นโยบาย วิสัยทัศน์ โครงสร้าง ผังบุคลากร ทำเนียบผู้บริหาร บุคลากร และเวลาทำการ
            </p>
        </div>

        <a href="{{ route('organization') }}" target="_blank"
           class="inline-flex items-center gap-2 bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold px-4 py-2.5 rounded-xl transition-colors self-start sm:self-center shrink-0">
            <i class="fa-solid fa-globe"></i>
            <span>ดูหน้าข้อมูลองค์กรบนเว็บไซต์</span>
        </a>
    </div>
@endsection

@section('content')
    @php
        $activeTab = session('active_tab', request('priority') ? 'tab-cat-3' : 'tab-cat-1');
        $activeSub = session('active_sub', 'general');
    @endphp

    @if(session('success'))
        <div class="saas-card p-4 !border-emerald-200 !bg-emerald-50 text-[#13A678] text-xs font-medium flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="saas-card p-4 !border-rose-200 !bg-rose-50 text-rose-700 text-xs space-y-1">
            <strong class="font-heading block mb-1"><i class="fa-solid fa-circle-exclamation mr-1"></i> พบข้อผิดพลาดในการบันทึกข้อมูล:</strong>
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- แถบเมนูหลัก 4 หมวดหมู่ --}}
    <div class="saas-card p-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
        <button type="button" data-tab="tab-cat-1"
                class="org-main-tab flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs font-heading font-semibold cursor-pointer transition-all {{ $activeTab === 'tab-cat-1' ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]' }}">
            <i class="fa-solid fa-file-lines"></i>
            <span>1. ข้อมูลพื้นฐานและนโยบาย</span>
        </button>

        <button type="button" data-tab="tab-cat-2"
                class="org-main-tab flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs font-heading font-semibold cursor-pointer transition-all {{ $activeTab === 'tab-cat-2' ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]' }}">
            <i class="fa-solid fa-user-tie"></i>
            <span>2. ทำเนียบผู้บริหาร ({{ $executives->count() }})</span>
        </button>

        <button type="button" data-tab="tab-cat-3"
                class="org-main-tab flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs font-heading font-semibold cursor-pointer transition-all {{ $activeTab === 'tab-cat-3' ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]' }}">
            <i class="fa-solid fa-users-gear"></i>
            <span>3. ข้อมูลเจ้าหน้าที่ ({{ $staffs->count() }})</span>
        </button>

        <button type="button" data-tab="tab-cat-4"
                class="org-main-tab flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-xs font-heading font-semibold cursor-pointer transition-all {{ $activeTab === 'tab-cat-4' ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]' }}">
            <i class="fa-solid fa-map-location-dot"></i>
            <span>4. เวลาทำการและแผนที่</span>
        </button>
    </div>

    {{-- ===================================================================== --}}
    {{-- หมวดที่ 1: เพิ่มข้อมูลตัวหนังสือและภาพได้ (5 เมนูย่อย รวมผังบุคลากร)   --}}
    {{-- ===================================================================== --}}
    <div id="tab-cat-1" class="org-tab-panel space-y-5 {{ $activeTab === 'tab-cat-1' ? '' : 'hidden' }}">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
            <div class="lg:col-span-3 saas-card p-3 space-y-1.5">
                <div class="px-3 py-2 text-[11px] font-heading font-bold text-[#64748B] uppercase tracking-wider">
                    เมนูย่อยข้อมูลองค์กร
                </div>
                @php
                    $subIcons = [
                        'general'        => 'fa-solid fa-building',
                        'policy'         => 'fa-solid fa-scroll',
                        'vision_mission' => 'fa-solid fa-bullseye',
                        'structure'      => 'fa-solid fa-diagram-project',
                        'staff_chart'    => 'fa-solid fa-users-rectangle',
                    ];
                @endphp
                @foreach($sections as $key => $label)
                    <button type="button" data-sub="sub-{{ $key }}"
                            class="org-sub-tab w-full flex items-center justify-between gap-2 px-3.5 py-2.5 rounded-xl text-xs font-heading font-semibold text-left cursor-pointer transition-all {{ $activeSub === $key ? 'bg-[#EEF2FF] text-[#3126C9] border border-[#3126C9]/20' : 'text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]' }}">
                        <span class="flex items-center gap-2.5">
                            <i class="{{ $subIcons[$key] ?? 'fa-solid fa-file' }} w-4 text-center"></i>
                            <span>{{ $label }}</span>
                        </span>
                        @if(isset($contents[$key]))
                            <span class="w-2 h-2 rounded-full bg-[#13A678]" title="มีข้อมูลแล้ว"></span>
                        @endif
                    </button>
                @endforeach
            </div>

            <div class="lg:col-span-9">
                @foreach($sections as $key => $label)
                    @php
                        $item = $contents[$key] ?? null;
                    @endphp
                    <div id="sub-{{ $key }}" class="org-sub-panel saas-card p-6 {{ $activeSub === $key ? '' : 'hidden' }}">
                        <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-[#E8ECF4]">
                            <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm">
                                    <i class="{{ $subIcons[$key] ?? 'fa-solid fa-file' }}"></i>
                                </span>
                                <span>{{ $label }}</span>
                            </h2>
                            @if($item?->updated_at)
                                <span class="text-[11px] text-[#64748B]">
                                    อัปเดตล่าสุด: {{ $item->updated_at->format('d/m/Y H:i') }}
                                </span>
                            @endif
                        </div>

                        <form action="{{ route('admin.organization.content.save', $key) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                                    หัวข้อหัวเรื่อง <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="title" value="{{ old('title', $item->title ?? $label) }}" required class="saas-input w-full text-xs">
                            </div>

                            <div>
                                <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                                    รายละเอียดเนื้อหา (ตัวหนังสือ)
                                </label>
                                <textarea name="content" rows="7" class="saas-input w-full text-xs leading-relaxed" placeholder="กรอกรายละเอียด{{ $label }}...">{{ old('content', $item->content ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start pt-2">
                                <div class="md:col-span-7">
                                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                                        รูปภาพประกอบ{{ $key === 'staff_chart' ? 'ผังบุคลากร' : '' }} <span class="text-[#64748B] font-normal">(JPG, PNG, WEBP ไม่เกิน 5MB)</span>
                                    </label>
                                    <input type="file" name="image" accept="image/*" class="saas-input w-full text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#EEF2FF] file:text-[#3126C9] hover:file:bg-[#E0E7FF] cursor-pointer">

                                    @if(!empty($item?->image_path))
                                        <label class="inline-flex items-center gap-2 text-xs text-rose-600 mt-2.5 cursor-pointer">
                                            <input type="checkbox" name="remove_image" value="1" class="rounded border-[#E8ECF4] text-rose-600">
                                            <span>ลบรูปภาพปัจจุบันออก</span>
                                        </label>
                                    @endif
                                </div>

                                <div class="md:col-span-5">
                                    @if(!empty($item?->image_path))
                                        <div class="p-2 rounded-xl border border-[#E8ECF4] bg-[#F8FAFC]">
                                            <span class="block text-[10px] text-[#64748B] mb-1">ภาพประกอบปัจจุบัน:</span>
                                            <img src="{{ asset($item->image_path) }}" alt="{{ $label }}" class="w-full max-h-48 object-contain rounded-lg">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-4 border-t border-[#E8ECF4] flex justify-end">
                                <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-6 cursor-pointer">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    <span>บันทึก{{ $label }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- หมวดที่ 2: บันทึกข้อมูลผู้บริหาร (แสดงรายชื่อแบบ List Group)            --}}
    {{-- ===================================================================== --}}
    <div id="tab-cat-2" class="org-tab-panel space-y-6 {{ $activeTab === 'tab-cat-2' ? '' : 'hidden' }}">
        <div class="saas-card p-6">
            <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 mb-5 pb-3.5 border-b border-[#E8ECF4] flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm">
                    <i class="fa-solid fa-user-plus"></i>
                </span>
                <span>เพิ่มข้อมูลทำเนียบผู้บริหาร</span>
            </h2>

            <form action="{{ route('admin.organization.executives.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                @csrf

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ชื่อ - นามสกุล <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required class="saas-input w-full text-xs" placeholder="เช่น นายจำรัส พรมบุญ">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ตำแหน่ง <span class="text-rose-500">*</span></label>
                    <input type="text" name="position" required class="saas-input w-full text-xs" placeholder="เช่น สาธารณสุขอำเภอโพธิ์ไทร">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ปีที่เริ่มดำรงตำแหน่ง</label>
                    <input type="text" name="start_year" maxlength="10" class="saas-input w-full text-xs" placeholder="เช่น 2566">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ปีที่ย้าย <span class="text-[10px] font-normal text-[#64748B]">(ว่าง=ปัจจุบัน)</span></label>
                    <input type="text" name="end_year" maxlength="10" class="saas-input w-full text-xs" placeholder="เช่น 2569">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รูปภาพผู้บริหาร (JPG, PNG, WEBP)</label>
                    <input type="file" name="image" accept="image/*" class="saas-input w-full text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#EEF2FF] file:text-[#3126C9] cursor-pointer">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ลำดับแสดงผล</label>
                    <input type="number" name="sort_order" value="0" min="0" class="saas-input w-full text-xs">
                </div>

                <div class="md:col-span-4 flex items-end justify-between gap-3 pb-1">
                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] pb-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-[#E8ECF4] text-[#3126C9]">
                        <span>แสดงผลบนเว็บ</span>
                    </label>

                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-5 cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>บันทึกผู้บริหาร</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="saas-card overflow-hidden">
            <div class="p-5 border-b border-[#E8ECF4] flex items-center justify-between">
                <div>
                    <h3 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0">ทำเนียบผู้บริหาร (List Group)</h3>
                    <p class="text-xs text-[#64748B] m-0 mt-0.5">ทั้งหมด {{ $executives->count() }} ท่าน</p>
                </div>
            </div>

            <ul class="divide-y divide-[#E8ECF4] m-0 p-0 list-none">
                @forelse($executives as $exec)
                    <li class="p-4 sm:px-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-[#F8FAFC] transition-colors">
                        <div class="flex items-center gap-4 min-w-0">
                            @if($exec->image_path)
                                <img src="{{ asset($exec->image_path) }}" alt="{{ $exec->name }}" class="w-14 h-14 rounded-full object-cover object-[center_20%] border-2 border-[#E8ECF4] shrink-0">
                            @else
                                <div class="w-14 h-14 rounded-full bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-lg font-heading font-bold shrink-0">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                            @endif

                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="text-sm sm:text-[15px] font-heading font-bold text-[#1E293B] m-0">{{ $exec->name }}</h4>
                                    @if(empty($exec->end_year))
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-[#13A678] border border-emerald-200/80 text-[10px] font-heading font-semibold">
                                            ดำรงตำแหน่งปัจจุบัน
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-[#64748B] text-[10px] font-heading font-semibold">
                                            อดีตผู้บริหาร
                                        </span>
                                    @endif
                                </div>

                                <div class="text-xs text-[#3126C9] font-medium mt-0.5">{{ $exec->position }}</div>

                                <div class="flex items-center gap-3 text-[11px] text-[#64748B] mt-1">
                                    <span>
                                        <i class="fa-regular fa-calendar mr-1 text-[#1675E8]"></i>
                                        วาระการดำรงตำแหน่ง:
                                        <strong class="text-[#1E293B]">{{ $exec->start_year ?: 'ไม่ระบุ' }}</strong>
                                        –
                                        <strong class="text-[#1E293B]">{{ $exec->end_year ?: 'ปัจจุบัน' }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                            <button type="button"
                                    onclick='openEditExecModal(@json($exec))'
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white text-xs font-heading font-semibold transition-colors cursor-pointer">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>แก้ไข</span>
                            </button>

                            <form action="{{ route('admin.organization.executives.destroy', $exec) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('ยืนยันการลบข้อมูลผู้บริหารท่านนี้?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white text-xs transition-colors cursor-pointer"
                                        title="ลบ">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="p-8 text-center text-xs text-[#64748B]">
                        ยังไม่มีข้อมูลผู้บริหาร กรุณาเพิ่มข้อมูลจากแบบฟอร์มด้านบน
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- หมวดที่ 3: บันทึกข้อมูลเจ้าหน้าที่ (Select กลุ่มงาน & งาน จากฐานข้อมูล)  --}}
    {{-- ===================================================================== --}}
    <div id="tab-cat-3" class="org-tab-panel space-y-6 {{ $activeTab === 'tab-cat-3' ? '' : 'hidden' }}">
        {{-- Datalist สำหรับ Autocomplete ตำแหน่ง --}}
        <datalist id="staff-position-list">
            @foreach($positionSuggestions as $pos)
                <option value="{{ $pos }}"></option>
            @endforeach
        </datalist>

        {{-- ฟอร์มเพิ่มข้อมูลเจ้าหน้าที่ --}}
        <div class="saas-card p-6">
            <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 mb-5 pb-3.5 border-b border-[#E8ECF4] flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm">
                    <i class="fa-solid fa-user-plus"></i>
                </span>
                <span>เพิ่มข้อมูลเจ้าหน้าที่ / บุคลากร</span>
            </h2>

            <form action="{{ route('admin.organization.staffs.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                @csrf

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ชื่อ - นามสกุล <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required class="saas-input w-full text-xs" placeholder="ระบุชื่อ-นามสกุล">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ตำแหน่ง <span class="text-rose-500">*</span>
                        <span class="text-[10px] font-normal text-[#1675E8]">(พิมพ์เพื่อค้นหาอัตโนมัติ)</span>
                    </label>
                    <input type="text" name="position" list="staff-position-list" autocomplete="off" required class="saas-input w-full text-xs" placeholder="เช่น นักวิชาการสาธารณสุขชำนาญการ">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ประเภทการจ้างงาน <span class="text-rose-500">*</span>
                    </label>
                    <select name="employment_type" required class="saas-input w-full text-xs cursor-pointer">
                        @foreach($employmentTypes as $empType)
                            <option value="{{ $empType }}">{{ $empType }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ตำแหน่งทางบริหาร</label>
                    <input type="text" name="admin_position" class="saas-input w-full text-xs" placeholder="เช่น หัวหน้ากลุ่มงานบริหารทั่วไป">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ระดับลำดับความสำคัญ (Priority) <span class="text-rose-500">*</span>
                    </label>
                    <select name="workgroup_priority" required class="saas-input w-full text-xs cursor-pointer">
                        @foreach($priorityGroups as $pKey => $pLabel)
                            <option value="{{ $pKey }}">{{ $pLabel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        กลุ่มงาน <span class="text-[#64748B] font-normal">(เว้นว่างได้)</span>
                    </label>
                    <select name="workgroup_id" id="create-staff-workgroup" class="saas-input w-full text-xs cursor-pointer">
                        <option value="">-- ไม่ระบุกลุ่มงาน / เว้นว่าง --</option>
                        @foreach($workgroups as $wg)
                            <option value="{{ $wg->id }}">{{ $wg->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        งานที่รับผิดชอบ <span class="text-[#64748B] font-normal">(เว้นว่างได้)</span>
                    </label>
                    <select name="job_id" id="create-staff-job" class="saas-input w-full text-xs cursor-pointer">
                        <option value="">-- ไม่ระบุงาน / เว้นว่าง --</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}" data-workgroup="{{ $job->workgroup_id }}">{{ $job->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รูปภาพเจ้าหน้าที่</label>
                    <input type="file" name="image" accept="image/*" class="saas-input w-full text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#EEF2FF] file:text-[#3126C9] cursor-pointer">
                </div>

                <div class="md:col-span-12 pt-3 border-t border-[#E8ECF4] flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-heading font-semibold text-[#1E293B]">ลำดับย่อย:</label>
                            <input type="number" name="sort_order" value="0" min="0" class="saas-input !py-1.5 !px-3 w-20 text-xs">
                        </div>

                        <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-[#E8ECF4] text-[#3126C9]">
                            <span>แสดงผลบนเว็บ</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-6 cursor-pointer">
                        <i class="fa-solid fa-plus"></i>
                        <span>บันทึกข้อมูลเจ้าหน้าที่</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ตัวกรอง Priority กลุ่มงาน --}}
        <div class="saas-card p-3 flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.organization.index', ['priority' => 'all']) }}"
               class="px-3.5 py-2 rounded-xl text-xs font-heading font-semibold transition-all {{ request('priority', 'all') === 'all' ? 'bg-[#3126C9] text-white' : 'bg-[#F8FAFC] text-[#64748B] hover:text-[#1E293B]' }}">
                ทั้งหมด ({{ $staffs->count() }})
            </a>
            @foreach($priorityGroups as $pKey => $pLabel)
                <a href="{{ route('admin.organization.index', ['priority' => $pKey]) }}"
                   class="px-3.5 py-2 rounded-xl text-xs font-heading font-semibold transition-all {{ (string) request('priority') === (string) $pKey ? 'bg-[#3126C9] text-white' : 'bg-[#F8FAFC] text-[#64748B] hover:text-[#1E293B]' }}">
                    {{ $pLabel }}
                </a>
            @endforeach
        </div>

        {{-- ตารางรายชื่อเจ้าหน้าที่เรียงตาม Priority --}}
        <div class="saas-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                            <th class="p-4 w-16 text-center">รูป</th>
                            <th class="p-4">ชื่อ - นามสกุล</th>
                            <th class="p-4">ตำแหน่ง / ประเภทจ้างงาน</th>
                            <th class="p-4">ระดับ / กลุ่มงาน / งาน</th>
                            <th class="p-4 w-20 text-center">ลำดับ</th>
                            <th class="p-4 w-28 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                        @forelse($staffs as $staff)
                            @php
                                $badgeStyle = match($staff->workgroup_priority) {
                                    1 => 'bg-[#EEF2FF] text-[#3126C9] border border-[#3126C9]/25',
                                    2 => 'bg-sky-50 text-[#1675E8] border border-sky-200',
                                    3 => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
                                    4 => 'bg-emerald-50 text-[#13A678] border border-emerald-200',
                                    5 => 'bg-amber-50 text-[#F49A22] border border-amber-200',
                                    default => 'bg-slate-100 text-[#64748B] border border-slate-200',
                                };
                            @endphp
                            <tr class="hover:bg-[#F8FAFC] transition-colors">
                                <td class="p-4 text-center">
                                    @if($staff->image_path)
                                        <img src="{{ asset($staff->image_path) }}" alt="{{ $staff->name }}" class="w-11 h-11 rounded-full object-cover object-[center_20%] border border-[#E8ECF4] mx-auto">
                                    @else
                                        <div class="w-11 h-11 rounded-full bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm mx-auto">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="font-heading font-semibold text-sm text-[#1E293B]">{{ $staff->name }}</div>
                                    @if($staff->admin_position)
                                        <div class="text-[11px] text-[#3126C9] mt-0.5">
                                            <i class="fa-solid fa-award mr-1"></i>{{ $staff->admin_position }}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-[#1E293B]">{{ $staff->position }}</div>
                                    @if($staff->employment_type)
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-slate-100 text-[#64748B] font-heading font-medium text-[10px]">
                                            {{ $staff->employment_type }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 space-y-1">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full font-heading font-semibold text-[10px] {{ $badgeStyle }}">
                                        {{ $staff->priority_label }}
                                    </span>
                                    @if($staff->workgroup)
                                        <div class="text-[11px] font-semibold text-[#1E293B]">
                                            <i class="fa-solid fa-layer-group text-[#1675E8] mr-1"></i>{{ $staff->workgroup->name }}
                                        </div>
                                    @endif
                                    @if($staff->job)
                                        <div class="text-[11px] text-[#64748B]">
                                            <i class="fa-solid fa-briefcase text-[#13A678] mr-1"></i>{{ $staff->job->name }}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-4 text-center font-heading font-bold text-[#64748B]">
                                    {{ $staff->sort_order }}
                                </td>
                                <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                    <button type="button"
                                            onclick='openEditStaffModal(@json($staff))'
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white transition-colors cursor-pointer"
                                            title="แก้ไข">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('admin.organization.staffs.destroy', $staff) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('ยืนยันการลบข้อมูลเจ้าหน้าที่ท่านนี้?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white transition-colors cursor-pointer"
                                                title="ลบ">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-[#64748B]">
                                    ยังไม่มีข้อมูลเจ้าหน้าที่ในระบบ
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- หมวดที่ 4: เวลาทำการและแผนที่ตั้งหน่วยงาน (ดึงจากข้อมูลพื้นฐานเว็บ)     --}}
    {{-- ===================================================================== --}}
    <div id="tab-cat-4" class="org-tab-panel space-y-6 {{ $activeTab === 'tab-cat-4' ? '' : 'hidden' }}">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <div class="lg:col-span-6 saas-card p-6">
                <div class="flex items-center justify-between pb-3.5 mb-5 border-b border-[#E8ECF4]">
                    <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm">
                            <i class="fa-solid fa-clock"></i>
                        </span>
                        <span>เวลาทำการและแผนที่ตั้งหน่วยงาน</span>
                    </h2>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-[#13A678] text-[10px] font-heading font-semibold">
                        เชื่อมโยงข้อมูลพื้นฐานเว็บ
                    </span>
                </div>

                <form action="{{ route('admin.organization.contact.save') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                            ที่ตั้งสำนักงาน <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="site_address" rows="2" required class="saas-input w-full text-xs">{{ old('site_address', $siteSettings['address']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                            โทรศัพท์ติดต่อ
                        </label>
                        <input type="text" name="site_phone" value="{{ old('site_phone', $siteSettings['phone']) }}" class="saas-input w-full text-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                                เวลาทำการ (วันจันทร์ - ศุกร์) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="site_hours_weekday" value="{{ old('site_hours_weekday', $siteSettings['hours_weekday']) }}" required class="saas-input w-full text-xs">
                        </div>

                        <div>
                            <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                                วันหยุดทำการ (เสาร์ - อาทิตย์) <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="site_hours_weekend" value="{{ old('site_hours_weekend', $siteSettings['hours_weekend']) }}" required class="saas-input w-full text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                            โค้ดฝังแผนที่ Google Maps (iframe)
                        </label>
                        <textarea name="site_google_map_iframe" rows="4" class="saas-input w-full text-xs font-mono" placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'>{{ old('site_google_map_iframe', $siteSettings['google_map_iframe']) }}</textarea>
                    </div>

                    <div class="pt-3 border-t border-[#E8ECF4] flex justify-end">
                        <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-6 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>บันทึกข้อมูลพื้นฐานเว็บ</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-6 saas-card p-6 space-y-4">
                <h3 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0">ตัวอย่างการแสดงผลแผนที่ปัจจุบัน</h3>

                <div class="p-4 rounded-xl bg-[#F8FAFC] border border-[#E8ECF4] text-xs space-y-1.5 text-[#1E293B]">
                    <div><strong class="text-[#3126C9]">หน่วยงาน:</strong> {{ $siteSettings['org_name_th'] }}</div>
                    <div><strong class="text-[#3126C9]">ที่อยู่:</strong> {{ $siteSettings['address'] }}</div>
                    <div><strong class="text-[#13A678]">วันทำการ:</strong> {{ $siteSettings['hours_weekday'] }}</div>
                    <div><strong class="text-[#F49A22]">วันหยุด:</strong> {{ $siteSettings['hours_weekend'] }}</div>
                </div>

                <div class="w-full h-72 rounded-2xl border border-[#E8ECF4] overflow-hidden bg-[#F8FAFC]">
                    @if(!empty($siteSettings['google_map_iframe']))
                        <div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:border-0">
                            {!! $siteSettings['google_map_iframe'] !!}
                        </div>
                    @else
                        <iframe
                            src="https://maps.google.com/maps?q={{ urlencode($siteSettings['org_name_th'] . ' ' . $siteSettings['address']) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            class="w-full h-full border-0"
                            loading="lazy">
                        </iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- MODAL: แก้ไขผู้บริหาร                                                 --}}
    {{-- ===================================================================== --}}
    <div id="edit-exec-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="saas-card w-full max-w-lg p-6">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#E8ECF4]">
                <h3 class="text-[16px] font-heading font-bold text-[#1E293B] m-0">แก้ไขข้อมูลผู้บริหาร</h3>
                <button type="button" onclick="$('#edit-exec-modal').addClass('hidden')" class="text-[#64748B] hover:text-[#1E293B] cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="edit-exec-form" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ชื่อ - นามสกุล <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="edit-exec-name" required class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ตำแหน่ง <span class="text-rose-500">*</span></label>
                    <input type="text" name="position" id="edit-exec-position" required class="saas-input w-full text-xs">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ปีที่เริ่มดำรงตำแหน่ง</label>
                        <input type="text" name="start_year" id="edit-exec-start-year" maxlength="10" class="saas-input w-full text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ปีที่ย้าย (เว้นว่าง=ปัจจุบัน)</label>
                        <input type="text" name="end_year" id="edit-exec-end-year" maxlength="10" class="saas-input w-full text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ลำดับแสดงผล</label>
                        <input type="number" name="sort_order" id="edit-exec-order" min="0" class="saas-input w-full text-xs">
                    </div>
                    <div class="flex items-end pb-2">
                        <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                            <input type="checkbox" name="is_active" id="edit-exec-active" value="1" class="rounded border-[#E8ECF4] text-[#3126C9]">
                            <span>แสดงผลบนเว็บ</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">เปลี่ยนรูปภาพใหม่ (เว้นว่างหากใช้รูปเดิม)</label>
                    <input type="file" name="image" accept="image/*" class="saas-input w-full text-xs">
                </div>

                <div class="pt-3 border-t border-[#E8ECF4] flex justify-end gap-2">
                    <button type="button" onclick="$('#edit-exec-modal').addClass('hidden')" class="px-4 py-2 rounded-xl border border-[#E8ECF4] text-xs font-heading font-semibold text-[#64748B] hover:bg-[#F8FAFC] cursor-pointer">ยกเลิก</button>
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2 !px-5 cursor-pointer">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- MODAL: แก้ไขเจ้าหน้าที่                                                --}}
    {{-- ===================================================================== --}}
    <div id="edit-staff-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="saas-card w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#E8ECF4]">
                <h3 class="text-[16px] font-heading font-bold text-[#1E293B] m-0">แก้ไขข้อมูลเจ้าหน้าที่</h3>
                <button type="button" onclick="$('#edit-staff-modal').addClass('hidden')" class="text-[#64748B] hover:text-[#1E293B] cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="edit-staff-form" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ชื่อ - นามสกุล <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="edit-staff-name" required class="saas-input w-full text-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ตำแหน่ง <span class="text-rose-500">*</span></label>
                        <input type="text" name="position" id="edit-staff-position" list="staff-position-list" autocomplete="off" required class="saas-input w-full text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ประเภทการจ้างงาน <span class="text-rose-500">*</span></label>
                        <select name="employment_type" id="edit-staff-employment-type" required class="saas-input w-full text-xs cursor-pointer">
                            @foreach($employmentTypes as $empType)
                                <option value="{{ $empType }}">{{ $empType }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ตำแหน่งทางบริหาร</label>
                        <input type="text" name="admin_position" id="edit-staff-admin-position" class="saas-input w-full text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ระดับลำดับความสำคัญ (Priority) <span class="text-rose-500">*</span></label>
                        <select name="workgroup_priority" id="edit-staff-priority" required class="saas-input w-full text-xs cursor-pointer">
                            @foreach($priorityGroups as $pKey => $pLabel)
                                <option value="{{ $pKey }}">{{ $pLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">กลุ่มงาน <span class="text-[#64748B] font-normal">(เว้นว่างได้)</span></label>
                    <select name="workgroup_id" id="edit-staff-workgroup" class="saas-input w-full text-xs cursor-pointer">
                        <option value="">-- ไม่ระบุกลุ่มงาน / เว้นว่าง --</option>
                        @foreach($workgroups as $wg)
                            <option value="{{ $wg->id }}">{{ $wg->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">งานที่รับผิดชอบ <span class="text-[#64748B] font-normal">(เว้นว่างได้)</span></label>
                    <select name="job_id" id="edit-staff-job" class="saas-input w-full text-xs cursor-pointer">
                        <option value="">-- ไม่ระบุงาน / เว้นว่าง --</option>
                        @foreach($jobs as $job)
                            <option value="{{ $job->id }}" data-workgroup="{{ $job->workgroup_id }}">{{ $job->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ลำดับย่อยในกลุ่ม</label>
                        <input type="number" name="sort_order" id="edit-staff-order" min="0" class="saas-input w-full text-xs">
                    </div>
                    <div class="flex items-end pb-2">
                        <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                            <input type="checkbox" name="is_active" id="edit-staff-active" value="1" class="rounded border-[#E8ECF4] text-[#3126C9]">
                            <span>แสดงผลบนเว็บ</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">เปลี่ยนรูปภาพใหม่ (เว้นว่างหากใช้รูปเดิม)</label>
                    <input type="file" name="image" accept="image/*" class="saas-input w-full text-xs">
                </div>

                <div class="pt-3 border-t border-[#E8ECF4] flex justify-end gap-2">
                    <button type="button" onclick="$('#edit-staff-modal').addClass('hidden')" class="px-4 py-2 rounded-xl border border-[#E8ECF4] text-xs font-heading font-semibold text-[#64748B] hover:bg-[#F8FAFC] cursor-pointer">ยกเลิก</button>
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2 !px-5 cursor-pointer">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        // สลับแท็บหลัก 4 หมวดหมู่
        $('.org-main-tab').on('click', function () {
            const target = $(this).data('tab');

            $('.org-main-tab')
                .removeClass('bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow')
                .addClass('text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]');

            $(this)
                .addClass('bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow')
                .removeClass('text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]');

            $('.org-tab-panel').addClass('hidden');
            $('#' + target).removeClass('hidden');
        });

        // สลับเมนูย่อยในหมวดที่ 1
        $('.org-sub-tab').on('click', function () {
            const subTarget = $(this).data('sub');

            $('.org-sub-tab')
                .removeClass('bg-[#EEF2FF] text-[#3126C9] border border-[#3126C9]/20')
                .addClass('text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]');

            $(this)
                .addClass('bg-[#EEF2FF] text-[#3126C9] border border-[#3126C9]/20')
                .removeClass('text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]');

            $('.org-sub-panel').addClass('hidden');
            $('#' + subTarget).removeClass('hidden');
        });

        // ฟังก์ชันกรองรายการ "งานที่รับผิดชอบ" ตาม "กลุ่มงาน" ที่เลือก
        function filterJobsByWorkgroup(workgroupSelectSelector, jobSelectSelector, preserveCurrent = false) {
            const wgId = $(workgroupSelectSelector).val();
            const $jobSelect = $(jobSelectSelector);
            const currentJobVal = $jobSelect.val();

            $jobSelect.find('option').each(function () {
                const optionWg = $(this).data('workgroup');
                if (!optionWg) {
                    $(this).prop('hidden', false).prop('disabled', false);
                    return;
                }
                const isMatch = !wgId || String(optionWg) === String(wgId);
                $(this).prop('hidden', !isMatch).prop('disabled', !isMatch);
            });

            if (!preserveCurrent) {
                const $selectedOption = $jobSelect.find('option:selected');
                if ($selectedOption.prop('disabled')) {
                    $jobSelect.val('');
                }
            } else {
                $jobSelect.val(currentJobVal);
            }
        }

        $('#create-staff-workgroup').on('change', function () {
            filterJobsByWorkgroup('#create-staff-workgroup', '#create-staff-job', false);
        });

        $('#edit-staff-workgroup').on('change', function () {
            filterJobsByWorkgroup('#edit-staff-workgroup', '#edit-staff-job', false);
        });

        window.applyEditJobFilter = function () {
            filterJobsByWorkgroup('#edit-staff-workgroup', '#edit-staff-job', true);
        };
    });

    // เปิด Modal แก้ไขผู้บริหาร
    window.openEditExecModal = function (exec) {
        $('#edit-exec-form').attr('action', `/admin/organization/executives/${exec.id}`);
        $('#edit-exec-name').val(exec.name || '');
        $('#edit-exec-position').val(exec.position || '');
        $('#edit-exec-start-year').val(exec.start_year || '');
        $('#edit-exec-end-year').val(exec.end_year || '');
        $('#edit-exec-order').val(exec.sort_order || 0);
        $('#edit-exec-active').prop('checked', Boolean(exec.is_active));
        $('#edit-exec-modal').removeClass('hidden');
    };

    // เปิด Modal แก้ไขเจ้าหน้าที่
    window.openEditStaffModal = function (staff) {
        $('#edit-staff-form').attr('action', `/admin/organization/staffs/${staff.id}`);
        $('#edit-staff-name').val(staff.name || '');
        $('#edit-staff-position').val(staff.position || '');
        $('#edit-staff-employment-type').val(staff.employment_type || 'ข้าราชการ');
        $('#edit-staff-admin-position').val(staff.admin_position || '');
        $('#edit-staff-priority').val(staff.workgroup_priority || 6);
        $('#edit-staff-workgroup').val(staff.workgroup_id || '');
        $('#edit-staff-job').val(staff.job_id || '');
        if (typeof window.applyEditJobFilter === 'function') {
            window.applyEditJobFilter();
        }
        $('#edit-staff-order').val(staff.sort_order || 0);
        $('#edit-staff-active').prop('checked', Boolean(staff.is_active));
        $('#edit-staff-modal').removeClass('hidden');
    };
</script>
@endpush
