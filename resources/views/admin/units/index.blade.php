@extends('admin.layouts.app')

@section('title', 'จัดการหน่วยงานภายใต้สังกัด - ระบบบริหารจัดการเว็บไซต์ สสอ.โพธิ์ไทร')

@section('content')
<div class="max-w-7xl w-full mx-auto p-6 md:p-8 space-y-6">

    {{-- Header --}}
    <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#13A678] to-[#10B981] text-white grid place-items-center text-lg shrink-0 shadow-sm">
                <i class="fa-solid fa-hospital-user"></i>
            </span>
            <div>
                <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                    จัดการหน่วยงานภายใต้สังกัด
                </h1>
                <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-0.5 flex flex-wrap items-center gap-2">
                    <span>ฐานข้อมูลหน่วยบริการสุขภาพ (ตาราง healthoffice)</span>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-[#16A34A] text-[11px] font-heading font-semibold">
                        <i class="fa-solid fa-filter text-[10px]"></i> เงื่อนไข: วันที่ปิดบริการ = NULL (เปิดใช้งานอยู่)
                    </span>
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 self-start sm:self-center shrink-0">
            <button type="button"
                    onclick="document.getElementById('create-unit-modal').classList.remove('hidden')"
                    class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-4 cursor-pointer">
                <i class="fa-solid fa-plus"></i>
                <span>เพิ่มหน่วยงานใหม่</span>
            </button>

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#1E293B] hover:text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                <span>กลับหน้า Admin</span>
            </a>
        </div>
    </div>

    {{-- แจ้งเตือนสถานะการทำงาน --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2.5">
            <i class="fa-solid fa-circle-check text-base text-[#16A34A]"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
            <div class="font-heading font-bold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>กรุณาตรวจสอบข้อมูลที่กรอก</span>
            </div>
            <ul class="list-disc pl-5 m-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- การ์ดตัวกรองเงื่อนไขตามที่กำหนด --}}
    <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4]">
        <div class="pb-3.5 mb-4 border-b border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h2 class="text-[15px] sm:text-[17px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2">
                <i class="fa-solid fa-sliders text-[#3126C9]"></i>
                <span>เงื่อนไขการกรองหน่วยงานภายใต้สังกัด</span>
            </h2>
            <span class="text-xs font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full">
                พบข้อมูลทั้งหมด {{ number_format($units->count()) }} หน่วยงาน
            </span>
        </div>

        <form action="{{ route('admin.units.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- 1. รหัสจังหวัด --}}
            <div>
                <label for="filter-province" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    รหัสจังหวัด (province_code)
                </label>
                <select id="filter-province" name="province_code" class="saas-input w-full text-xs cursor-pointer" onchange="this.form.submit()">
                    <option value="">-- ทุกจังหวัด --</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov->province_code }}" {{ $provinceCode === $prov->province_code ? 'selected' : '' }}>
                            {{ $prov->province_code }} - {{ $prov->province_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. รหัสอำเภอ --}}
            <div>
                <label for="filter-district" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    รหัสอำเภอ (district_code)
                </label>
                <select id="filter-district" name="district_code" class="saas-input w-full text-xs cursor-pointer" onchange="this.form.submit()">
                    <option value="">-- ทุกอำเภอ --</option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->district_code }}" {{ $districtCode === $dist->district_code ? 'selected' : '' }}>
                            {{ $dist->district_code }} - {{ $dist->district_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3. ประเภทองค์กร --}}
            <div>
                <label for="filter-org-type" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    ประเภทองค์กร (org_type)
                </label>
                <select id="filter-org-type" name="org_type" class="saas-input w-full text-xs cursor-pointer" onchange="this.form.submit()">
                    <option value="">-- ทุกประเภทองค์กร --</option>
                    @foreach($orgTypes as $type)
                        <option value="{{ $type }}" {{ $orgType === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 4. ประเภทหน่วยบริการสุขภาพ --}}
            <div>
                <label for="filter-unit-type" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    ประเภทหน่วยบริการสุขภาพ
                </label>
                <select id="filter-unit-type" name="service_unit_type" class="saas-input w-full text-xs cursor-pointer" onchange="this.form.submit()">
                    <option value="">-- ทุกประเภทหน่วยบริการ --</option>
                    @foreach($serviceUnitTypes as $uType)
                        <option value="{{ $uType }}" {{ $serviceUnitType === $uType ? 'selected' : '' }}>
                            {{ $uType }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 5. ค้นหาชื่อ / รหัสหน่วยบริการ --}}
            <div>
                <label for="filter-keyword" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    ค้นหาชื่อ / รหัส 5 หรือ 9 หลัก
                </label>
                <div class="flex items-center gap-1.5">
                    <input type="text"
                           id="filter-keyword"
                           name="q"
                           value="{{ $keyword }}"
                           class="saas-input w-full text-xs"
                           placeholder="ชื่อหน่วยบริการ, รหัส...">
                    <button type="submit"
                            class="px-3.5 py-2.5 rounded-xl bg-[#3126C9] hover:bg-[#1675E8] text-white text-xs font-heading font-semibold transition-colors cursor-pointer shrink-0"
                            title="ค้นหา">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </div>
        </form>

        {{-- แถบแสดงเงื่อนไขที่กำลังใช้งาน + ปุ่มบันทึกการตั้งค่าลง Database --}}
        <div class="mt-4 pt-3.5 border-t border-[#E8ECF4] flex flex-col lg:flex-row lg:items-center justify-between gap-3 text-[11px]">
            <div class="flex flex-wrap items-center gap-2 text-[#64748B]">
                <span class="font-heading font-semibold text-[#1E293B]">เงื่อนไขที่เลือกอยู่:</span>
                <span class="px-2.5 py-0.5 rounded-md bg-[#F8FAFC] border border-[#E8ECF4]">จังหวัด: <strong class="text-[#1E293B]">{{ $provinceCode ?: 'ทั้งหมด' }}</strong></span>
                <span class="px-2.5 py-0.5 rounded-md bg-[#F8FAFC] border border-[#E8ECF4]">อำเภอ: <strong class="text-[#1E293B]">{{ $districtCode ?: 'ทั้งหมด' }}</strong></span>
                <span class="px-2.5 py-0.5 rounded-md bg-[#F8FAFC] border border-[#E8ECF4]">ประเภทองค์กร: <strong class="text-[#1E293B]">{{ $orgType ?: 'ทั้งหมด' }}</strong></span>
                <span class="px-2.5 py-0.5 rounded-md bg-[#F8FAFC] border border-[#E8ECF4]">ประเภทหน่วยบริการ: <strong class="text-[#1E293B]">{{ $serviceUnitType ?: 'ทั้งหมด' }}</strong></span>
                <span class="px-2.5 py-0.5 rounded-md bg-emerald-50 border border-emerald-200 text-[#16A34A] font-semibold">วันที่ปิดบริการ: NULL</span>
            </div>

            <div class="flex flex-wrap items-center gap-2 shrink-0">
                {{-- ฟอร์มบันทึกการตั้งค่าเงื่อนไขลง Database --}}
                <form action="{{ route('admin.units.settings') }}" method="POST" class="inline m-0">
                    @csrf
                    <input type="hidden" name="province_code" value="{{ $provinceCode }}">
                    <input type="hidden" name="district_code" value="{{ $districtCode }}">
                    <input type="hidden" name="org_type" value="{{ $orgType }}">
                    <input type="hidden" name="service_unit_type" value="{{ $serviceUnitType }}">

                    <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-[#13A678] to-[#10B981] hover:opacity-95 text-white text-xs font-heading font-semibold shadow-xs transition-all cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>บันทึกการตั้งค่าเงื่อนไขลงฐานข้อมูล</span>
                    </button>
                </form>

                <a href="{{ route('admin.units.index') }}"
                class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold transition-colors">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>โหลดค่าที่บันทึกไว้</span>
                </a>
            </div>
        </div>

    {{-- ตารางแสดงรายการหน่วยงานภายใต้สังกัด (Material Design 3 Clean Table) --}}
    <div class="saas-card overflow-hidden bg-white rounded-2xl border border-[#E8ECF4]">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                        <th class="p-4 w-12 text-center">#</th>
                        <th class="p-4 w-32">รหัสหน่วยบริการ</th>
                        <th class="p-4">ชื่อหน่วยงาน / ที่ตั้ง</th>
                        <th class="p-4">ประเภทหน่วยบริการสุขภาพ</th>
                        <th class="p-4">องค์กร / สังกัด</th>
                        <th class="p-4 w-28 text-center">วันที่ปิดบริการ</th>
                        <th class="p-4 w-32 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                    @forelse($units as $index => $unit)
                        <tr class="hover:bg-[#F8FAFC] transition-colors">
                            <td class="p-4 text-center font-heading font-semibold text-[#64748B]">
                                {{ $index + 1 }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="font-heading font-bold text-[#3126C9]">{{ $unit->hospcode9_new }}</div>
                                @if($unit->hospcode5)
                                    <div class="text-[11px] text-[#64748B] mt-0.5">รหัส 5 หลัก: {{ $unit->hospcode5 }}</div>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="font-heading font-bold text-sm text-[#1E293B]">{{ $unit->name }}</div>
                                <div class="text-[11px] text-[#64748B] mt-0.5">
                                    {{ $unit->address ? $unit->address . ' ' : '' }}
                                    {{ $unit->moo ? 'หมู่ ' . $unit->moo . ' ' : '' }}
                                    ต.{{ $unit->subdistrict_name }} อ.{{ $unit->district_name }} จ.{{ $unit->province_name }} {{ $unit->zipcode }}
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#EEF2FF] text-[#3126C9] font-heading font-semibold text-[11px]">
                                    {{ $unit->service_unit_type }}
                                </span>
                                @if($unit->hospital_level)
                                    <div class="text-[11px] text-[#64748B] mt-1">{{ $unit->hospital_level }}</div>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md {{ $unit->org_type === 'รัฐบาล' ? 'bg-emerald-50 text-[#13A678]' : 'bg-amber-50 text-[#F49A22]' }} font-heading font-semibold text-[11px]">
                                    {{ $unit->org_type }}
                                </span>
                                <div class="text-[11px] text-[#64748B] mt-1">{{ $unit->department ?: $unit->ministry }}</div>
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-[#16A34A] font-heading font-semibold text-[11px]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span> NULL (เปิดบริการ)
                                </span>
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button"
                                            onclick='openEditUnitModal(@json($unit))'
                                            class="px-3 py-1.5 rounded-lg bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white font-heading font-semibold transition-colors cursor-pointer">
                                        <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                                    </button>

                                    <form action="{{ route('admin.units.destroy', $unit) }}"
                                          method="POST"
                                          onsubmit="return confirm('ยืนยันการลบข้อมูลหน่วยงาน \'{{ addslashes($unit->name) }}\' ใช่หรือไม่?');"
                                          class="inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-[#EF4444] text-[#EF4444] hover:text-white font-heading font-semibold transition-colors cursor-pointer">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-[#64748B]">
                                <i class="fa-solid fa-hospital text-3xl text-[#3126C9]/30 mb-2 block"></i>
                                <p class="text-sm font-heading font-bold text-[#1E293B] m-0">ไม่พบข้อมูลหน่วยงานที่ตรงตามเงื่อนไข</p>
                                <p class="text-xs m-0 mt-1">ลองปรับตัวกรองรหัสจังหวัด รหัสอำเภอ หรือประเภทหน่วยบริการสุขภาพด้านบน</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL: เพิ่มหน่วยงานภายใต้สังกัดใหม่ --}}
<div id="create-unit-modal" class="hidden fixed inset-0 z-50 bg-slate-900/65 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="saas-card bg-white !bg-white rounded-2xl border border-[#E8ECF4] shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 sm:p-7 relative">
        <button type="button"
                onclick="document.getElementById('create-unit-modal').classList.add('hidden')"
                class="w-8 h-8 rounded-full bg-[#F8FAFC] hover:bg-rose-50 text-[#64748B] hover:text-rose-600 border border-[#E8ECF4] grid place-items-center absolute top-5 right-5 cursor-pointer">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-[18px] sm:text-[20px] font-heading font-bold text-[#1E293B] m-0 pb-4 mb-5 border-b border-[#E8ECF4] flex items-center gap-2">
            <i class="fa-solid fa-circle-plus text-[#13A678]"></i>
            <span>เพิ่มหน่วยงานภายใต้สังกัด</span>
        </h3>

        <form action="{{ route('admin.units.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ชื่อหน่วยงาน <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required class="saas-input w-full text-xs" placeholder="เช่น โรงพยาบาลส่งเสริมสุขภาพตำบล...">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รหัส 9 หลักใหม่ <span class="text-rose-500">*</span></label>
                    <input type="text" name="hospcode9_new" maxlength="9" required class="saas-input w-full text-xs" placeholder="GA000XXXX">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รหัส 5 หลัก</label>
                    <input type="text" name="hospcode5" maxlength="5" class="saas-input w-full text-xs" placeholder="037XX">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ประเภทองค์กร <span class="text-rose-500">*</span></label>
                    <select name="org_type" required class="saas-input w-full text-xs">
                        <option value="รัฐบาล" selected>รัฐบาล</option>
                        <option value="เอกชน">เอกชน</option>
                        <option value="อปท.">อปท.</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ประเภทหน่วยบริการสุขภาพ <span class="text-rose-500">*</span></label>
                    <input type="text" name="service_unit_type" value="โรงพยาบาลส่งเสริมสุขภาพตำบล" required class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รหัสจังหวัด <span class="text-rose-500">*</span></label>
                    <input type="text" name="province_code" value="{{ $provinceCode ?: '34' }}" maxlength="2" required class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">จังหวัด <span class="text-rose-500">*</span></label>
                    <input type="text" name="province_name" value="อุบลราชธานี" required class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รหัสอำเภอ <span class="text-rose-500">*</span></label>
                    <input type="text" name="district_code" value="{{ $districtCode ?: '3421' }}" maxlength="4" required class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">อำเภอ <span class="text-rose-500">*</span></label>
                    <input type="text" name="district_name" value="โพธิ์ไทร" required class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ตำบล</label>
                    <input type="text" name="subdistrict_name" class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">หมู่ที่</label>
                    <input type="text" name="moo" class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รหัสไปรษณีย์</label>
                    <input type="text" name="zipcode" value="34340" maxlength="5" class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">สังกัด</label>
                    <input type="text" name="ministry" value="กระทรวงสาธารณสุข" class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">กรม / หน่วยงานต้นสังกัด</label>
                    <input type="text" name="department" value="สำนักงานปลัดกระทรวงสาธารณสุข" class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="pt-4 border-t border-[#E8ECF4] flex justify-end gap-2">
                <button type="button"
                        onclick="document.getElementById('create-unit-modal').classList.add('hidden')"
                        class="px-4 py-2.5 rounded-xl bg-[#F8FAFC] hover:bg-slate-200 text-[#64748B] text-xs font-heading font-semibold cursor-pointer">
                    ยกเลิก
                </button>
                <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-5 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>บันทึกข้อมูลหน่วยงาน</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: แก้ไขข้อมูลหน่วยงานภายใต้สังกัด --}}
<div id="edit-unit-modal" class="hidden fixed inset-0 z-50 bg-slate-900/65 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="saas-card bg-white !bg-white rounded-2xl border border-[#E8ECF4] shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 sm:p-7 relative">
        <button type="button"
                onclick="document.getElementById('edit-unit-modal').classList.add('hidden')"
                class="w-8 h-8 rounded-full bg-[#F8FAFC] hover:bg-rose-50 text-[#64748B] hover:text-rose-600 border border-[#E8ECF4] grid place-items-center absolute top-5 right-5 cursor-pointer">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-[18px] sm:text-[20px] font-heading font-bold text-[#1E293B] m-0 pb-4 mb-5 border-b border-[#E8ECF4] flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-[#3126C9]"></i>
            <span>แก้ไขข้อมูลหน่วยงานภายใต้สังกัด</span>
        </h3>

        <form id="edit-unit-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ชื่อหน่วยงาน <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit-unit-name" name="name" required class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รหัส 9 หลักใหม่ <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit-unit-code9" name="hospcode9_new" maxlength="9" required class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รหัส 5 หลัก</label>
                    <input type="text" id="edit-unit-code5" name="hospcode5" maxlength="5" class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ประเภทองค์กร <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit-unit-org" name="org_type" required class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ประเภทหน่วยบริการสุขภาพ <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit-unit-type" name="service_unit_type" required class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ตำบล</label>
                    <input type="text" id="edit-unit-subdistrict" name="subdistrict_name" class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">หมู่ที่</label>
                    <input type="text" id="edit-unit-moo" name="moo" class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รหัสไปรษณีย์</label>
                    <input type="text" id="edit-unit-zipcode" name="zipcode" maxlength="5" class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">กรม / หน่วยงานต้นสังกัด</label>
                    <input type="text" id="edit-unit-department" name="department" class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">วันที่ปิดบริการ (เว้นว่าง = NULL / เปิดใช้งาน)</label>
                    <input type="date" id="edit-unit-closed" name="closed_date" class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="pt-4 border-t border-[#E8ECF4] flex justify-end gap-2">
                <button type="button"
                        onclick="document.getElementById('edit-unit-modal').classList.add('hidden')"
                        class="px-4 py-2.5 rounded-xl bg-[#F8FAFC] hover:bg-slate-200 text-[#64748B] text-xs font-heading font-semibold cursor-pointer">
                    ยกเลิก
                </button>
                <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-5 cursor-pointer">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>บันทึกการแก้ไข</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.openEditUnitModal = function (unit) {
        const form = document.getElementById('edit-unit-form');
        form.action = `/admin/units/${unit.id}`;

        document.getElementById('edit-unit-name').value = unit.name || '';
        document.getElementById('edit-unit-code9').value = unit.hospcode9_new || '';
        document.getElementById('edit-unit-code5').value = unit.hospcode5 || '';
        document.getElementById('edit-unit-org').value = unit.org_type || '';
        document.getElementById('edit-unit-type').value = unit.service_unit_type || '';
        document.getElementById('edit-unit-subdistrict').value = unit.subdistrict_name || '';
        document.getElementById('edit-unit-moo').value = unit.moo || '';
        document.getElementById('edit-unit-zipcode').value = unit.zipcode || '';
        document.getElementById('edit-unit-department').value = unit.department || '';
        document.getElementById('edit-unit-closed').value = unit.closed_date ? unit.closed_date.substring(0, 10) : '';

        document.getElementById('edit-unit-modal').classList.remove('hidden');
    };
</script>
@endpush
