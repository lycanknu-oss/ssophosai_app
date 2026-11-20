@extends('admin.layouts.app')

@section('title', 'จัดการส่วนประชาสัมพันธ์ - Admin Dashboard')

@section('page-header')
    <div class="saas-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[11px] font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full mb-2">
                <i class="fa-solid fa-images"></i> PUBLICITY &amp; EXECUTIVES
            </span>
            <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                จัดการภาพประชาสัมพันธ์และผู้บริหาร
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-1">
                กำหนดภาพสไลด์หลักหน้าแรก (Hero Slideshow) และข้อมูลทำเนียบผู้บริหารองค์กร
            </p>
        </div>

        <a href="{{ route('home') }}#about" target="_blank"
           class="inline-flex items-center gap-2 bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold px-4 py-2.5 rounded-xl transition-colors self-start sm:self-center">
            <i class="fa-solid fa-eye"></i>
            <span>ดูตัวอย่างหน้าแรก</span>
        </a>
    </div>
@endsection

@section('content')
    {{-- แสดง Error การตรวจสอบข้อมูล --}}
    @if($errors->any())
        <div class="saas-card p-4 !border-rose-200 !bg-rose-50 text-rose-700 text-xs space-y-1">
            <strong class="font-heading block mb-1"><i class="fa-solid fa-circle-exclamation mr-1"></i> พบข้อผิดพลาดในการบันทึกข้อมูล:</strong>
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Nav Tabs สลับหมวดหมู่ --}}
    <div class="saas-card p-2 flex flex-wrap gap-2">
        <button type="button" data-target="#panel-slides"
                class="pub-tab active flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-heading font-semibold bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow cursor-pointer transition-all">
            <i class="fa-solid fa-panorama"></i>
            <span>ภาพประชาสัมพันธ์ ({{ $slides->count() }})</span>
        </button>

        <button type="button" data-target="#panel-executives"
                class="pub-tab flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs font-heading font-semibold text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B] cursor-pointer transition-all">
            <i class="fa-solid fa-user-tie"></i>
            <span>ผู้บริหารองค์กร ({{ $executives->count() }})</span>
        </button>
    </div>

    {{-- ===================================================================== --}}
    {{-- TAB 1: จัดการภาพประชาสัมพันธ์ (HERO SLIDESHOW)                        --}}
    {{-- ===================================================================== --}}
    <div id="panel-slides" class="pub-panel space-y-6">
        {{-- ฟอร์มเพิ่มภาพประชาสัมพันธ์ --}}
        <div class="saas-card p-6">
            <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 mb-4 pb-3 border-b border-[#E8ECF4] flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm">
                    <i class="fa-solid fa-plus"></i>
                </span>
                <span>เพิ่มภาพประชาสัมพันธ์ใหม่</span>
            </h2>

            <form action="{{ route('admin.publicity.slides.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                @csrf

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ป้ายกำกับหมวดหมู่ (Badge)</label>
                    <input type="text" name="badge" value="{{ old('badge', 'สุขภาพชุมชน') }}" class="saas-input w-full text-xs" placeholder="เช่น สุขภาพชุมชน, การดูแลเชิงรุก">
                </div>

                <div class="md:col-span-8">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">หัวข้อหลักบนสไลด์ <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required class="saas-input w-full text-xs" placeholder="เช่น ร่วมสร้างชุมชนสุขภาพดีไปด้วยกัน">
                </div>

                <div class="md:col-span-8">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">คำอธิบายย่อย (Subtitle)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="saas-input w-full text-xs" placeholder="เช่น ส่งเสริมการดูแลสุขภาพและการเข้าถึงข้อมูลที่เป็นประโยชน์">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ลำดับการแสดงผล</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="saas-input w-full text-xs">
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ไฟล์รูปภาพ (JPG, PNG, WEBP ไม่เกิน 4MB) <span class="text-rose-500">*</span></label>
                    <input type="file" name="image" accept="image/*" required class="saas-input w-full text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#EEF2FF] file:text-[#3126C9] hover:file:bg-[#E0E7FF] cursor-pointer">
                </div>

                <div class="md:col-span-6 flex flex-wrap items-end gap-5 pb-2">
                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">เผยแพร่ทันที</span>
                    </label>

                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_popup" id="create-slide-popup" value="1" {{ old('is_popup') ? 'checked' : '' }} class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium"><i class="fa-solid fa-window-restore text-[#1675E8] mr-1"></i> ออกแจ้งเตือนผ่าน popup</span>
                    </label>
                </div>

                <div class="md:col-span-12 pt-2 border-t border-[#E8ECF4] flex justify-end">
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-6 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>บันทึกสไลด์</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ตารางรายการภาพประชาสัมพันธ์ --}}
        <div class="saas-card overflow-hidden">
            <div class="p-5 border-b border-[#E8ECF4] flex items-center justify-between">
                <h3 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0">รายการภาพประชาสัมพันธ์ทั้งหมด</h3>
                <span class="text-xs text-[#64748B]">ทั้งหมด {{ $slides->count() }} รายการ</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                            <th class="p-4 w-16 text-center">ลำดับ</th>
                            <th class="p-4 w-36">ภาพตัวอย่าง</th>
                            <th class="p-4">รายละเอียดข้อความ</th>
                            <th class="p-4 w-36">สถานะ</th>
                            <th class="p-4 w-32 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                        @forelse($slides as $slide)
                            <tr class="hover:bg-[#F8FAFC] transition-colors">
                                <td class="p-4 text-center font-heading font-bold text-[#64748B]">{{ $slide->sort_order }}</td>
                                <td class="p-4">
                                    <img src="{{ asset($slide->image_path) }}" alt="{{ $slide->title }}" class="w-28 h-16 object-cover rounded-xl border border-[#E8ECF4]">
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-1.5 flex-wrap mb-1">
                                        @if($slide->badge)
                                            <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#EEF2FF] text-[#3126C9] font-heading font-semibold text-[10px]">
                                                {{ $slide->badge }}
                                            </span>
                                        @endif
                                        @if($slide->is_popup)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-sky-100 text-[#1675E8] font-heading font-semibold text-[10px]">
                                                <i class="fa-solid fa-window-restore"></i> Popup แจ้งเตือน
                                            </span>
                                        @endif
                                    </div>
                                    <div class="font-heading font-semibold text-[#1E293B] text-sm">{{ $slide->title }}</div>
                                    <div class="text-[#64748B] mt-0.5">{{ $slide->subtitle ?: '-' }}</div>
                                </td>
                                <td class="p-4">
                                    @if($slide->is_active)
                                        <span class="inline-flex items-center gap-1.5 text-[#16A34A] font-medium">
                                            <span class="w-2 h-2 rounded-full bg-[#16A34A]"></span> เผยแพร่
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[#64748B] font-medium">
                                            <span class="w-2 h-2 rounded-full bg-slate-400"></span> ซ่อน
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                    <button type="button"
                                            onclick='openEditSlideModal(@json($slide))'
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white transition-colors cursor-pointer"
                                            title="แก้ไข">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('admin.publicity.slides.destroy', $slide) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('ยืนยันการลบภาพประชาสัมพันธ์นี้?');">
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
                                <td colspan="5" class="p-8 text-center text-[#64748B]">
                                    ยังไม่มีภาพประชาสัมพันธ์ในฐานข้อมูล (หน้าเว็บจะแสดงภาพตัวอย่างเริ่มต้นจนกว่าจะเพิ่มข้อมูลใหม่)
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- TAB 2: จัดการผู้บริหารองค์กร (EXECUTIVES)                             --}}
    {{-- ===================================================================== --}}
    <div id="panel-executives" class="pub-panel hidden space-y-6">
        {{-- ฟอร์มเพิ่มผู้บริหาร --}}
        <div class="saas-card p-6">
            <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 mb-4 pb-3 border-b border-[#E8ECF4] flex items-center gap-2">
                <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm">
                    <i class="fa-solid fa-user-plus"></i>
                </span>
                <span>เพิ่มข้อมูลผู้บริหารองค์กร</span>
            </h2>

            <form action="{{ route('admin.publicity.executives.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                @csrf

                <div class="md:col-span-5">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ชื่อ - นามสกุล <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="saas-input w-full text-xs" placeholder="เช่น นายจำรัส พรมบุญ">
                </div>

                <div class="md:col-span-5">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ตำแหน่ง <span class="text-rose-500">*</span></label>
                    <input type="text" name="position" value="{{ old('position') }}" required class="saas-input w-full text-xs" placeholder="เช่น สาธารณสุขอำเภอโพธิ์ไทร">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">ลำดับแสดงผล</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="saas-input w-full text-xs">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">วันที่เข้ารับตำแหน่ง</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" class="saas-input w-full text-xs">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">วันที่สิ้นสุดการดำรงตำแหน่ง <span class="text-[11px] font-normal text-[#64748B]">(เว้นว่างหากอยู่ปัจจุบัน)</span></label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" class="saas-input w-full text-xs">
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">รูปภาพผู้บริหาร (1:1) <span class="text-rose-500">*</span></label>
                    <input type="file" name="image" accept="image/*" required class="saas-input w-full text-xs file:mr-2.5 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#EEF2FF] file:text-[#3126C9] hover:file:bg-[#E0E7FF] cursor-pointer">
                </div>

                <div class="md:col-span-12 pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-t border-[#E8ECF4]">
                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">แสดงผลบนหน้าเว็บไซต์</span>
                    </label>

                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-6 cursor-pointer self-start sm:self-auto">
                        <i class="fa-solid fa-user-check"></i>
                        <span>บันทึกข้อมูลผู้บริหาร</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- ตารางรายชื่อผู้บริหาร --}}
        <div class="saas-card overflow-hidden">
            <div class="p-5 border-b border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <h3 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0">รายชื่อผู้บริหารองค์กร</h3>
                <span class="text-xs text-[#64748B]">ทั้งหมด {{ $executives->count() }} ท่าน (แสดง 2 ลำดับแรกบนหน้าหลัก)</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                            <th class="p-4 w-16 text-center">ลำดับ</th>
                            <th class="p-4 w-20">รูปภาพ</th>
                            <th class="p-4">ชื่อ - นามสกุล</th>
                            <th class="p-4">ตำแหน่ง</th>
                            <th class="p-4">วาระการดำรงตำแหน่ง</th>
                            <th class="p-4 w-28">สถานะ</th>
                            <th class="p-4 w-32 text-right">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                        @forelse($executives as $exec)
                            <tr class="hover:bg-[#F8FAFC] transition-colors">
                                <td class="p-4 text-center font-heading font-bold text-[#64748B]">{{ $exec->sort_order }}</td>
                                <td class="p-4">
                                    <img src="{{ asset($exec->image_path) }}" alt="{{ $exec->name }}" class="w-12 h-12 rounded-full object-cover object-[center_25%] border-2 border-[#E8ECF4]">
                                </td>
                                <td class="p-4 font-heading font-semibold text-sm text-[#1E293B]">{{ $exec->name }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full bg-emerald-50 text-[#13A678] font-heading font-semibold text-[11px]">
                                        {{ $exec->position }}
                                    </span>
                                </td>
                                <td class="p-4 text-[#64748B] whitespace-nowrap">
                                    @if($exec->start_date || $exec->end_date)
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-calendar-check text-[#3126C9]"></i>
                                            <span>
                                                {{ $exec->start_date ? $exec->start_date->format('d/m/') . ($exec->start_date->year + 543) : 'ไม่ระบุ' }}
                                                –
                                                @if($exec->end_date)
                                                    {{ $exec->end_date->format('d/m/') . ($exec->end_date->year + 543) }}
                                                @else
                                                    <strong class="text-[#16A34A] font-semibold">ปัจจุบัน</strong>
                                                @endif
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-slate-400">- ไม่ระบุวันที่ -</span>
                                    @endif
                                </td>
                                <td class="p-4 whitespace-nowrap">
                                    @if($exec->is_active)
                                        <span class="inline-flex items-center gap-1.5 text-[#16A34A] font-medium">
                                            <span class="w-2 h-2 rounded-full bg-[#16A34A]"></span> แสดงผล
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-[#64748B] font-medium">
                                            <span class="w-2 h-2 rounded-full bg-slate-400"></span> ซ่อน
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                    <button type="button"
                                            onclick='openEditExecutiveModal(@json($exec))'
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white transition-colors cursor-pointer"
                                            title="แก้ไข">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <form action="{{ route('admin.publicity.executives.destroy', $exec) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('ยืนยันการลบข้อมูลผู้บริหารท่านนี้?');">
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
                                <td colspan="7" class="p-8 text-center text-[#64748B]">
                                    ยังไม่มีรายชื่อผู้บริหารในฐานข้อมูล
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- MODAL: แก้ไขภาพประชาสัมพันธ์                                           --}}
    {{-- ===================================================================== --}}
    <div id="edit-slide-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="saas-card w-full max-w-lg p-6">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#E8ECF4]">
                <h3 class="text-[16px] font-heading font-bold text-[#1E293B] m-0">แก้ไขภาพประชาสัมพันธ์</h3>
                <button type="button" onclick="$('#edit-slide-modal').addClass('hidden')" class="text-[#64748B] hover:text-[#1E293B] cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="edit-slide-form" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ป้ายกำกับหมวดหมู่</label>
                    <input type="text" name="badge" id="edit-slide-badge" class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">หัวข้อหลักบนสไลด์ <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit-slide-title" required class="saas-input w-full text-xs">
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">คำอธิบายย่อย</label>
                    <input type="text" name="subtitle" id="edit-slide-subtitle" class="saas-input w-full text-xs">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ลำดับแสดงผล</label>
                        <input type="number" name="sort_order" id="edit-slide-order" min="0" class="saas-input w-full text-xs">
                    </div>
                    <div class="flex flex-wrap items-end gap-4 pb-2">
                        <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                            <input type="checkbox" name="is_active" id="edit-slide-active" value="1" class="rounded border-[#E8ECF4] text-[#3126C9]">
                            <span>เผยแพร่บนหน้าเว็บ</span>
                        </label>
                        <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                            <input type="checkbox" name="is_popup" id="edit-slide-popup" value="1" class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                            <span class="font-medium"><i class="fa-solid fa-window-restore text-[#1675E8] mr-1"></i> ออกแจ้งเตือนผ่าน popup</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">เปลี่ยนรูปภาพใหม่ (เว้นว่างหากใช้รูปเดิม)</label>
                    <input type="file" name="image" accept="image/*" class="saas-input w-full text-xs">
                </div>

                <div class="pt-3 border-t border-[#E8ECF4] flex justify-end gap-2">
                    <button type="button" onclick="$('#edit-slide-modal').addClass('hidden')" class="px-4 py-2 rounded-xl border border-[#E8ECF4] text-xs font-heading font-semibold text-[#64748B] hover:bg-[#F8FAFC] cursor-pointer">ยกเลิก</button>
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2 !px-5 cursor-pointer">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================================================================== --}}
    {{-- MODAL: แก้ไขผู้บริหารองค์กร                                            --}}
    {{-- ===================================================================== --}}
    <div id="edit-executive-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="saas-card w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#E8ECF4]">
                <h3 class="text-[16px] font-heading font-bold text-[#1E293B] m-0">แก้ไขข้อมูลผู้บริหารองค์กร</h3>
                <button type="button" onclick="$('#edit-executive-modal').addClass('hidden')" class="text-[#64748B] hover:text-[#1E293B] cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="edit-executive-form" method="POST" enctype="multipart/form-data" class="space-y-3.5">
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">วันที่เข้ารับตำแหน่ง</label>
                        <input type="date" name="start_date" id="edit-exec-start-date" class="saas-input w-full text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">วันที่สิ้นสุดการดำรงตำแหน่ง</label>
                        <input type="date" name="end_date" id="edit-exec-end-date" class="saas-input w-full text-xs">
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
                            <span>แสดงบนหน้าแรก</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">เปลี่ยนรูปภาพใหม่ (เว้นว่างหากใช้รูปเดิม)</label>
                    <input type="file" name="image" accept="image/*" class="saas-input w-full text-xs">
                </div>

                <div class="pt-3 border-t border-[#E8ECF4] flex justify-end gap-2">
                    <button type="button" onclick="$('#edit-executive-modal').addClass('hidden')" class="px-4 py-2 rounded-xl border border-[#E8ECF4] text-xs font-heading font-semibold text-[#64748B] hover:bg-[#F8FAFC] cursor-pointer">ยกเลิก</button>
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2 !px-5 cursor-pointer">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        // สลับ Tab ระหว่าง ภาพประชาสัมพันธ์ กับ ผู้บริหารองค์กร
        $('.pub-tab').on('click', function () {
            const target = $(this).data('target');

            $('.pub-tab')
                .removeClass('active bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow')
                .addClass('text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]');

            $(this)
                .addClass('active bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow')
                .removeClass('text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]');

            $('.pub-panel').addClass('hidden');
            $(target).removeClass('hidden');
        });
    });

    // เปิด Modal แก้ไขสไลด์
    window.openEditSlideModal = function (slide) {
        $('#edit-slide-form').attr('action', `/admin/publicity/slides/${slide.id}`);
        $('#edit-slide-badge').val(slide.badge || '');
        $('#edit-slide-title').val(slide.title || '');
        $('#edit-slide-subtitle').val(slide.subtitle || '');
        $('#edit-slide-order').val(slide.sort_order || 0);
        $('#edit-slide-active').prop('checked', Boolean(slide.is_active));
        $('#edit-slide-popup').prop('checked', Boolean(slide.is_popup));
        $('#edit-slide-modal').removeClass('hidden');
    };

    // เปิด Modal แก้ไขผู้บริหาร
    window.openEditExecutiveModal = function (exec) {
        $('#edit-executive-form').attr('action', `/admin/publicity/executives/${exec.id}`);
        $('#edit-exec-name').val(exec.name || '');
        $('#edit-exec-position').val(exec.position || '');
        $('#edit-exec-start-date').val(exec.start_date ? exec.start_date.substring(0, 10) : '');
        $('#edit-exec-end-date').val(exec.end_date ? exec.end_date.substring(0, 10) : '');
        $('#edit-exec-order').val(exec.sort_order || 0);
        $('#edit-exec-active').prop('checked', Boolean(exec.is_active));
        $('#edit-executive-modal').removeClass('hidden');
    };
</script>
@endpush
