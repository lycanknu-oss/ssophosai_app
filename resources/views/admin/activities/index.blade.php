@extends('admin.layouts.app')

@section('title', 'จัดการข่าวประชาสัมพันธ์ - Admin Dashboard')

@section('page-header')
    <div class="saas-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[11px] font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full mb-2">
                <i class="fa-solid fa-bullhorn"></i> NEWS &amp; ANNOUNCEMENTS
            </span>
            <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                จัดการข่าวประชาสัมพันธ์
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-1">
                เผยแพร่ข่าวกิจกรรม ข่าวรับสมัครงาน และประกาศจัดซื้อจัดจ้างของสำนักงานสาธารณสุขอำเภอโพธิ์ไทร
            </p>
        </div>

        <a href="{{ route('activities') }}" target="_blank"
           class="inline-flex items-center gap-2 bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold px-4 py-2.5 rounded-xl transition-colors self-start sm:self-center shrink-0">
            <i class="fa-solid fa-globe"></i>
            <span>ดูหน้าข่าวบนเว็บไซต์</span>
        </a>
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

    {{-- แถบสรุปจำนวนข่าวแยกตามหมวดหมู่ (คลิกเพื่อกรองได้ทันที) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
        <a href="{{ route('admin.activities.index', ['category' => 'all']) }}"
           class="saas-card p-4 flex items-center gap-3.5 hover:-translate-y-0.5 transition-all {{ request('category', 'all') === 'all' ? '!border-[#3126C9] ring-2 ring-[#3126C9]/15' : '' }}">
            <span class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#3126C9] to-[#1675E8] text-white grid place-items-center text-sm shrink-0">
                <i class="fa-solid fa-layer-group"></i>
            </span>
            <div>
                <span class="block text-[11px] text-[#64748B]">ข่าวทั้งหมด</span>
                <strong class="text-lg font-heading font-bold text-[#1E293B]">{{ number_format($counts['all']) }}</strong>
            </div>
        </a>

        <a href="{{ route('admin.activities.index', ['category' => 'general']) }}"
           class="saas-card p-4 flex items-center gap-3.5 hover:-translate-y-0.5 transition-all {{ request('category') === 'general' ? '!border-[#1675E8] ring-2 ring-[#1675E8]/15' : '' }}">
            <span class="w-10 h-10 rounded-xl bg-sky-50 text-[#1675E8] border border-sky-200/80 grid place-items-center text-sm shrink-0">
                <i class="fa-solid fa-newspaper"></i>
            </span>
            <div>
                <span class="block text-[11px] text-[#64748B]">ข่าวทั่วไป</span>
                <strong class="text-lg font-heading font-bold text-[#1E293B]">{{ number_format($counts['general']) }}</strong>
            </div>
        </a>

        <a href="{{ route('admin.activities.index', ['category' => 'recruitment']) }}"
           class="saas-card p-4 flex items-center gap-3.5 hover:-translate-y-0.5 transition-all {{ request('category') === 'recruitment' ? '!border-[#13A678] ring-2 ring-[#13A678]/15' : '' }}">
            <span class="w-10 h-10 rounded-xl bg-emerald-50 text-[#13A678] border border-emerald-200/80 grid place-items-center text-sm shrink-0">
                <i class="fa-solid fa-user-tie"></i>
            </span>
            <div>
                <span class="block text-[11px] text-[#64748B]">ข่าวรับสมัครงาน</span>
                <strong class="text-lg font-heading font-bold text-[#1E293B]">{{ number_format($counts['recruitment']) }}</strong>
            </div>
        </a>

        <a href="{{ route('admin.activities.index', ['category' => 'procurement']) }}"
           class="saas-card p-4 flex items-center gap-3.5 hover:-translate-y-0.5 transition-all {{ request('category') === 'procurement' ? '!border-[#F49A22] ring-2 ring-[#F49A22]/15' : '' }}">
            <span class="w-10 h-10 rounded-xl bg-amber-50 text-[#F49A22] border border-amber-200/80 grid place-items-center text-sm shrink-0">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </span>
            <div>
                <span class="block text-[11px] text-[#64748B]">ข่าวจัดซื้อจัดจ้าง</span>
                <strong class="text-lg font-heading font-bold text-[#1E293B]">{{ number_format($counts['procurement']) }}</strong>
            </div>
        </a>
    </div>

    {{-- 1. ฟอร์มเพิ่มข่าวประชาสัมพันธ์ใหม่ --}}
    <div class="saas-card p-6">
        <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 mb-5 pb-3.5 border-b border-[#E8ECF4] flex items-center gap-2.5">
            <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm shrink-0">
                <i class="fa-solid fa-plus"></i>
            </span>
            <span>เพิ่มข่าวประชาสัมพันธ์ / ประกาศใหม่</span>
        </h2>

        <form action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-4">
                    <label for="create-category" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        หมวดหมู่ข่าว <span class="text-rose-500">*</span>
                    </label>
                    <select id="create-category" name="category" required class="saas-input w-full text-xs cursor-pointer">
                        <option value="general" {{ old('category') === 'general' ? 'selected' : '' }}>ข่าวทั่วไป / กิจกรรม</option>
                        <option value="recruitment" {{ old('category') === 'recruitment' ? 'selected' : '' }}>ข่าวรับสมัครงาน</option>
                        <option value="procurement" {{ old('category') === 'procurement' ? 'selected' : '' }}>ข่าวจัดซื้อจัดจ้าง</option>
                    </select>
                </div>

                <div class="md:col-span-5">
                    <label for="create-title" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        หัวข้อข่าวประชาสัมพันธ์ <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="create-title" name="title" value="{{ old('title') }}" required class="saas-input w-full text-xs" placeholder="ระบุหัวข้อข่าวหรือชื่อประกาศ">
                </div>

                <div class="md:col-span-3">
                    <label for="create-published-date" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        วันที่เผยแพร่ <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="create-published-date" name="published_date" value="{{ old('published_date', date('Y-m-d')) }}" required class="saas-input w-full text-xs">
                </div>
            </div>

            <div>
                <label for="create-summary" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    คำโปรย / สรุปย่อ <span class="text-[#64748B] font-normal">(แสดงในการ์ดรายการข่าวหน้าแรก)</span>
                </label>
                <input type="text" id="create-summary" name="summary" value="{{ old('summary') }}" class="saas-input w-full text-xs" placeholder="สรุปใจความสำคัญของข่าวโดยย่อ...">
            </div>

            <div>
                <label for="create-content" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    รายละเอียดเนื้อหาข่าว
                </label>
                <textarea id="create-content" name="content" rows="4" class="saas-input w-full text-xs leading-relaxed" placeholder="กรอกรายละเอียดข่าวประชาสัมพันธ์ กำหนดการ สถานที่ หรือเงื่อนไขประกาศ...">{{ old('content') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="create-cover" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        รูปภาพหน้าปกข่าว <span class="text-[#64748B] font-normal">(JPG, PNG, WEBP ไม่เกิน 4MB)</span>
                    </label>
                    <input type="file" id="create-cover" name="cover_image" accept="image/*" class="saas-input w-full text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#EEF2FF] file:text-[#3126C9] hover:file:bg-[#E0E7FF] cursor-pointer">
                </div>

                <div>
                    <label for="create-attachment" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ไฟล์เอกสารแนบ <span class="text-[#64748B] font-normal">(PDF, DOCX, XLSX, ZIP ไม่เกิน 10MB)</span>
                    </label>
                    <input type="file" id="create-attachment" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="saas-input w-full text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-emerald-50 file:text-[#13A678] hover:file:bg-emerald-100 cursor-pointer">
                </div>
            </div>

            <div class="pt-4 border-t border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-6">
                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_pinned" value="1" class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium"><i class="fa-solid fa-thumbtack text-[#F49A22] mr-1"></i> ปักหมุดข่าวเด่น</span>
                    </label>

                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_popup" value="1" {{ old('is_popup') ? 'checked' : '' }} class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium"><i class="fa-solid fa-window-restore text-[#1675E8] mr-1"></i> ออกแจ้งเตือนผ่าน popup</span>
                    </label>

                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">เผยแพร่ทันที</span>
                    </label>
                </div>

                <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-6 cursor-pointer self-start sm:self-auto shrink-0">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>เผยแพร่ข่าวประชาสัมพันธ์</span>
                </button>
            </div>
        </form>
    </div>

    {{-- 2. ตารางแสดงรายการข่าวประชาสัมพันธ์ทั้งหมด --}}
    <div class="saas-card overflow-hidden">
        <div class="p-5 border-b border-[#E8ECF4] flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div>
                <h3 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0">รายการข่าวประชาสัมพันธ์</h3>
                <p class="text-xs text-[#64748B] m-0 mt-0.5">แสดง {{ $activities->total() }} รายการ</p>
            </div>

            {{-- ฟอร์มค้นหาและกรองหมวดหมู่ --}}
            <form action="{{ route('admin.activities.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 m-0">
                <select name="category" onchange="this.form.submit()" class="saas-input text-xs cursor-pointer">
                    <option value="all" {{ request('category', 'all') === 'all' ? 'selected' : '' }}>ทุกหมวดหมู่</option>
                    <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>ข่าวทั่วไป</option>
                    <option value="recruitment" {{ request('category') === 'recruitment' ? 'selected' : '' }}>ข่าวรับสมัครงาน</option>
                    <option value="procurement" {{ request('category') === 'procurement' ? 'selected' : '' }}>ข่าวจัดซื้อจัดจ้าง</option>
                </select>

                <div class="flex items-center gap-1.5">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาหัวข้อข่าว..." class="saas-input text-xs w-full sm:w-52">
                    <button type="submit" class="px-3.5 py-2.5 rounded-xl bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white text-xs font-heading font-semibold transition-colors cursor-pointer shrink-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                        <th class="p-4 w-24">รูปปก</th>
                        <th class="p-4">หัวข้อข่าว / ไฟล์แนบ</th>
                        <th class="p-4 w-36">หมวดหมู่</th>
                        <th class="p-4 w-32">วันที่เผยแพร่</th>
                        <th class="p-4 w-28">สถานะ</th>
                        <th class="p-4 w-32 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                    @forelse($activities as $news)
                        @php
                            $catBadge = match($news->category) {
                                'recruitment' => 'bg-emerald-50 text-[#13A678]',
                                'procurement' => 'bg-amber-50 text-[#F49A22]',
                                default       => 'bg-[#EEF2FF] text-[#3126C9]',
                            };
                        @endphp
                        <tr class="hover:bg-[#F8FAFC] transition-colors">
                            <td class="p-4">
                                @if($news->cover_image)
                                    <img src="{{ asset($news->cover_image) }}" alt="{{ $news->title }}" class="w-16 h-12 object-cover rounded-xl border border-[#E8ECF4]">
                                @else
                                    <div class="w-16 h-12 rounded-xl bg-[#F8FAFC] border border-[#E8ECF4] text-[#64748B] grid place-items-center text-sm">
                                        <i class="fa-regular fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    @if($news->is_pinned)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-heading font-semibold">
                                            <i class="fa-solid fa-thumbtack"></i> ปักหมุด
                                        </span>
                                    @endif
                                    @if($news->is_popup)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-sky-100 text-[#1675E8] text-[10px] font-heading font-semibold">
                                            <i class="fa-solid fa-window-restore"></i> Popup แจ้งเตือน
                                        </span>
                                    @endif
                                    <span class="font-heading font-semibold text-sm text-[#1E293B]">{{ $news->title }}</span>
                                </div>
                                @if($news->summary)
                                    <p class="text-[#64748B] m-0 mt-0.5 line-clamp-1">{{ $news->summary }}</p>
                                @endif
                                @if($news->attachment_path)
                                    <a href="{{ asset($news->attachment_path) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] text-[#1675E8] hover:underline mt-1">
                                        <i class="fa-solid fa-paperclip"></i>
                                        <span>เปิดดูไฟล์เอกสารแนบ</span>
                                    </a>
                                @endif
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full font-heading font-semibold text-[11px] {{ $catBadge }}">
                                    {{ $news->category_label }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap text-[#64748B]">
                                {{ $news->published_date ? $news->published_date->format('d/m/') . ($news->published_date->year + 543) : '-' }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($news->is_active)
                                    <span class="inline-flex items-center gap-1.5 text-[#16A34A] font-medium">
                                        <span class="w-2 h-2 rounded-full bg-[#16A34A]"></span> เผยแพร่
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[#64748B] font-medium">
                                        <span class="w-2 h-2 rounded-full bg-slate-400"></span> ฉบับร่าง
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right space-x-1.5 whitespace-nowrap">
                                <button type="button"
                                        onclick='openEditActivityModal(@json($news))'
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white transition-colors cursor-pointer"
                                        title="แก้ไข">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <form action="{{ route('admin.activities.destroy', $news) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('ยืนยันการลบข่าวประชาสัมพันธ์นี้?');">
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
                                ยังไม่มีรายการข่าวประชาสัมพันธ์ในฐานข้อมูล กรุณาเพิ่มข่าวใหม่จากแบบฟอร์มด้านบน
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div class="p-4 border-t border-[#E8ECF4]">
                {{ $activities->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL: แก้ไขข่าวประชาสัมพันธ์ --}}
    <div id="edit-activity-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="saas-card w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#E8ECF4]">
                <h3 class="text-[16px] font-heading font-bold text-[#1E293B] m-0">แก้ไขข่าวประชาสัมพันธ์</h3>
                <button type="button" onclick="$('#edit-activity-modal').addClass('hidden')" class="text-[#64748B] hover:text-[#1E293B] cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="edit-activity-form" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">หมวดหมู่ข่าว <span class="text-rose-500">*</span></label>
                        <select name="category" id="edit-act-category" required class="saas-input w-full text-xs cursor-pointer">
                            <option value="general">ข่าวทั่วไป / กิจกรรม</option>
                            <option value="recruitment">ข่าวรับสมัครงาน</option>
                            <option value="procurement">ข่าวจัดซื้อจัดจ้าง</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">วันที่เผยแพร่ <span class="text-rose-500">*</span></label>
                        <input type="date" name="published_date" id="edit-act-date" required class="saas-input w-full text-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">หัวข้อข่าวประชาสัมพันธ์ <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit-act-title" required class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">คำโปรย / สรุปย่อ</label>
                    <input type="text" name="summary" id="edit-act-summary" class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">รายละเอียดเนื้อหาข่าว</label>
                    <textarea name="content" id="edit-act-content" rows="4" class="saas-input w-full text-xs leading-relaxed"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">เปลี่ยนรูปหน้าปกใหม่ (เว้นว่างหากใช้รูปเดิม)</label>
                        <input type="file" name="cover_image" accept="image/*" class="saas-input w-full text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">เปลี่ยนไฟล์แนบใหม่ (เว้นว่างหากใช้ไฟล์เดิม)</label>
                        <input type="file" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="saas-input w-full text-xs">
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-6 pt-1">
                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_pinned" id="edit-act-pinned" value="1" class="rounded border-[#E8ECF4] text-[#3126C9]">
                        <span>ปักหมุดข่าวเด่น</span>
                    </label>

                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_popup" id="edit-act-popup" value="1" class="rounded border-[#E8ECF4] text-[#3126C9]">
                        <span><i class="fa-solid fa-window-restore text-[#1675E8] mr-1"></i> ออกแจ้งเตือนผ่าน popup</span>
                    </label>

                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_active" id="edit-act-active" value="1" class="rounded border-[#E8ECF4] text-[#3126C9]">
                        <span>เผยแพร่บนหน้าเว็บ</span>
                    </label>
                </div>

                <div class="pt-3 border-t border-[#E8ECF4] flex justify-end gap-2">
                    <button type="button" onclick="$('#edit-activity-modal').addClass('hidden')" class="px-4 py-2 rounded-xl border border-[#E8ECF4] text-xs font-heading font-semibold text-[#64748B] hover:bg-[#F8FAFC] cursor-pointer">ยกเลิก</button>
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2 !px-5 cursor-pointer">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script type="module">
    window.openEditActivityModal = function (news) {
        $('#edit-activity-form').attr('action', `/admin/activities/${news.id}`);
        $('#edit-act-category').val(news.category || 'general');
        $('#edit-act-date').val(news.published_date ? news.published_date.substring(0, 10) : '');
        $('#edit-act-title').val(news.title || '');
        $('#edit-act-summary').val(news.summary || '');
        $('#edit-act-content').val(news.content || '');
        $('#edit-act-pinned').prop('checked', Boolean(news.is_pinned));
        $('#edit-act-popup').prop('checked', Boolean(news.is_popup));
        $('#edit-act-active').prop('checked', Boolean(news.is_active));
        $('#edit-activity-modal').removeClass('hidden');
    };
</script>
@endpush
