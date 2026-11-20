@extends('admin.layouts.app')

@section('title', 'จัดการทางลัดข้อมูลที่น่าสนใจ - Admin Dashboard')

@php
    // รายการไอคอน Font Awesome สำหรับแสดงใน Select ทั้งหน้าเพิ่มและหน้าแก้ไข
    $iconOptions = [
        'fa-solid fa-link' => 'ลิงก์ทั่วไป (Link)',
        'fa-solid fa-file-lines' => 'เอกสาร / แบบฟอร์ม (File Lines)',
        'fa-solid fa-right-left' => 'รับส่งข้อมูล / สารบรรณ (Transfer)',
        'fa-solid fa-bullhorn' => 'ข่าวประชาสัมพันธ์ / ประกาศ (Bullhorn)',
        'fa-solid fa-heart-pulse' => 'สุขภาพ / สาธารณสุข (Heart Pulse)',
        'fa-solid fa-hospital' => 'โรงพยาบาล / หน่วยบริการ (Hospital)',
        'fa-solid fa-house-medical' => 'รพ.สต. / สถานบริการ (House Medical)',
        'fa-solid fa-chart-line' => 'รายงาน / สถิติข้อมูล (Chart Line)',
        'fa-solid fa-shield-halved' => 'ITA / ความโปร่งใส (Shield)',
        'fa-solid fa-calendar-days' => 'ปฏิทินกิจกรรม (Calendar)',
        'fa-solid fa-folder-open' => 'คลังข้อมูล / ดาวน์โหลด (Folder)',
        'fa-solid fa-users' => 'บุคลากร / องค์กร (Users)',
        'fa-solid fa-globe' => 'เว็บไซต์ / ระบบออนไลน์ (Globe)',
        'fa-solid fa-up-right-from-square' => 'ลิงก์ภายนอก (External Link)',
    ];
@endphp

@section('page-header')
    <div class="saas-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[11px] font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full mb-2">
                <i class="fa-solid fa-bolt"></i> QUICK SHORTCUTS
            </span>
            <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                จัดการทางลัดข้อมูลที่น่าสนใจ
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-1">
                เพิ่มและจัดการลิงก์ทางลัดเข้าถึงบริการ ระบบสารสนเทศ และข้อมูลสำคัญสำหรับประชาชนและเจ้าหน้าที่
            </p>
        </div>

        <a href="{{ route('home') }}" target="_blank"
           class="inline-flex items-center gap-2 bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold px-4 py-2.5 rounded-xl transition-colors self-start sm:self-center shrink-0">
            <i class="fa-solid fa-globe"></i>
            <span>ดูหน้าเว็บไซต์หลัก</span>
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

    {{-- 1. ฟอร์มบันทึกข้อมูลทางลัดใหม่ (ปรับ Layout เป็นระเบียบ สมดุลทุกช่อง) --}}
    <div class="saas-card p-6">
        <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 mb-5 pb-3.5 border-b border-[#E8ECF4] flex items-center gap-2.5">
            <span class="w-8 h-8 rounded-lg bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-sm shrink-0">
                <i class="fa-solid fa-plus"></i>
            </span>
            <span>เพิ่มทางลัดข้อมูลที่น่าสนใจใหม่</span>
        </h2>

        <form action="{{ route('admin.shortcuts.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- แถวที่ 1: ชื่อทางลัด และ ลิงก์ปลายทาง (แบ่ง 2 คอลัมน์เท่ากัน) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="create-title" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ชื่อทางลัดข้อมูลที่น่าสนใจ <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="create-title"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           class="saas-input w-full text-xs"
                           placeholder="เช่น ระบบรับส่งข้อมูล สสอ.โพธิ์ไทร">
                </div>

                <div>
                    <label for="create-url" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ลิงก์ปลายทาง (URL) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="create-url"
                           name="url"
                           value="{{ old('url') }}"
                           required
                           class="saas-input w-full text-xs"
                           placeholder="https://forums.ssophosai.in.th/ หรือ /documents">
                </div>
            </div>

            {{-- แถวที่ 2: คำอธิบายสั้นๆ เต็มความกว้าง --}}
            <div>
                <label for="create-description" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    คำอธิบายสั้นๆ <span class="text-[#64748B] font-normal">(ถ้ามี)</span>
                </label>
                <input type="text"
                       id="create-description"
                       name="description"
                       value="{{ old('description') }}"
                       class="saas-input w-full text-xs"
                       placeholder="เช่น ระบบรับ-ส่งหนังสือราชการและเอกสารอิเล็กทรอนิกส์สำหรับหน่วยงานในสังกัด">
            </div>

            {{-- แถวที่ 3: เลือกไอคอน Font Awesome (Select) + โทนสีป้าย + ลำดับแสดงผล --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
                {{-- Select เลือกไอคอน พร้อมกล่อง Preview ด้านซ้าย --}}
                <div class="sm:col-span-2 lg:col-span-6">
                    <label for="create-icon-select" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ไอคอน Font Awesome
                    </label>
                    <div class="flex items-center gap-2.5">
                        <span id="create-icon-preview"
                              class="w-10 h-10 rounded-xl bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] grid place-items-center text-sm shrink-0">
                            <i class="{{ old('icon', 'fa-solid fa-link') }}"></i>
                        </span>
                        <select id="create-icon-select"
                                name="icon"
                                class="saas-input w-full text-xs cursor-pointer">
                            @foreach($iconOptions as $iconClass => $iconLabel)
                                <option value="{{ $iconClass }}" {{ old('icon', 'fa-solid fa-link') === $iconClass ? 'selected' : '' }}>
                                    {{ $iconLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Select โทนสีป้าย --}}
                <div class="lg:col-span-4">
                    <label for="create-color-theme" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        โทนสีป้ายไอคอน
                    </label>
                    <select id="create-color-theme"
                            name="color_theme"
                            class="saas-input w-full text-xs cursor-pointer">
                        <option value="indigo" {{ old('color_theme') === 'indigo' ? 'selected' : '' }}>ม่วง-น้ำเงิน (Primary)</option>
                        <option value="emerald" {{ old('color_theme') === 'emerald' ? 'selected' : '' }}>เขียวสาธารณสุข (Emerald)</option>
                        <option value="blue" {{ old('color_theme') === 'blue' ? 'selected' : '' }}>ฟ้าสดใส (Blue)</option>
                        <option value="amber" {{ old('color_theme') === 'amber' ? 'selected' : '' }}>ส้มอำพัน (Amber)</option>
                    </select>
                </div>

                {{-- ลำดับการแสดงผล --}}
                <div class="lg:col-span-2">
                    <label for="create-sort-order" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ลำดับแสดงผล
                    </label>
                    <input type="number"
                           id="create-sort-order"
                           name="sort_order"
                           value="{{ old('sort_order', 0) }}"
                           min="0"
                           class="saas-input w-full text-xs">
                </div>
            </div>

            {{-- แถวที่ 4: ตัวเลือกเพิ่มเติม และ ปุ่มบันทึก --}}
            <div class="pt-4 border-t border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-6">
                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="open_new_tab" value="1" checked class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">เปิดลิงก์ในแท็บใหม่ (New Tab)</span>
                    </label>

                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">เผยแพร่ทันที</span>
                    </label>
                </div>

                <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-6 cursor-pointer self-start sm:self-auto shrink-0">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>บันทึกทางลัด</span>
                </button>
            </div>
        </form>
    </div>

    {{-- 2. ตารางแสดงรายการทางลัดข้อมูลที่น่าสนใจทั้งหมด --}}
    <div class="saas-card overflow-hidden">
        <div class="p-5 border-b border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0">รายการทางลัดข้อมูลที่น่าสนใจ</h3>
                <p class="text-xs text-[#64748B] m-0 mt-0.5">เรียงลำดับตามค่าลำดับแสดงผลจากน้อยไปมาก</p>
            </div>
            <span class="text-xs font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full self-start sm:self-center">
                ทั้งหมด {{ $shortcuts->count() }} รายการ
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                        <th class="p-4 w-16 text-center">ลำดับ</th>
                        <th class="p-4 w-16 text-center">ไอคอน</th>
                        <th class="p-4">ชื่อทางลัด &amp; คำอธิบาย</th>
                        <th class="p-4">ลิงก์ปลายทาง (URL)</th>
                        <th class="p-4 w-28">สถานะ</th>
                        <th class="p-4 w-32 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                    @forelse($shortcuts as $item)
                        @php
                            $themeClasses = match($item->color_theme) {
                                'emerald' => 'bg-emerald-50 text-[#13A678] border-emerald-200',
                                'blue'    => 'bg-sky-50 text-[#1675E8] border-sky-200',
                                'amber'   => 'bg-amber-50 text-[#F49A22] border-amber-200',
                                default   => 'bg-[#EEF2FF] text-[#3126C9] border-[#E0E7FF]',
                            };
                        @endphp
                        <tr class="hover:bg-[#F8FAFC] transition-colors">
                            <td class="p-4 text-center font-heading font-bold text-[#64748B]">{{ $item->sort_order }}</td>
                            <td class="p-4 text-center">
                                <span class="w-9 h-9 rounded-xl border {{ $themeClasses }} inline-grid place-items-center text-sm">
                                    <i class="{{ $item->icon }}"></i>
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="font-heading font-semibold text-sm text-[#1E293B]">{{ $item->title }}</div>
                                @if($item->description)
                                    <div class="text-[#64748B] mt-0.5">{{ $item->description }}</div>
                                @endif
                            </td>
                            <td class="p-4">
                                <a href="{{ $item->url }}" target="_blank" class="inline-flex items-center gap-1.5 text-[#1675E8] hover:underline break-all">
                                    <span>{{ $item->url }}</span>
                                    @if($item->open_new_tab)
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    @endif
                                </a>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($item->is_active)
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
                                        onclick='openEditShortcutModal(@json($item))'
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white transition-colors cursor-pointer"
                                        title="แก้ไข">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <form action="{{ route('admin.shortcuts.destroy', $item) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('ยืนยันการลบทางลัดข้อมูลที่น่าสนใจนี้?');">
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
                                ยังไม่มีรายการทางลัดข้อมูลที่น่าสนใจในระบบ กรุณาเพิ่มข้อมูลจากแบบฟอร์มด้านบน
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL: แก้ไขทางลัดข้อมูลที่น่าสนใจ --}}
    <div id="edit-shortcut-modal" class="hidden fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="saas-card w-full max-w-xl p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#E8ECF4]">
                <h3 class="text-[16px] font-heading font-bold text-[#1E293B] m-0">แก้ไขทางลัดข้อมูลที่น่าสนใจ</h3>
                <button type="button" onclick="$('#edit-shortcut-modal').addClass('hidden')" class="text-[#64748B] hover:text-[#1E293B] cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="edit-shortcut-form" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ชื่อทางลัดข้อมูลที่น่าสนใจ <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit-shortcut-title" required class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ลิงก์ปลายทาง (URL) <span class="text-rose-500">*</span></label>
                    <input type="text" name="url" id="edit-shortcut-url" required class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">คำอธิบายสั้นๆ</label>
                    <input type="text" name="description" id="edit-shortcut-description" class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ไอคอน Font Awesome</label>
                    <div class="flex items-center gap-2.5">
                        <span id="edit-icon-preview" class="w-10 h-10 rounded-xl bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] grid place-items-center text-sm shrink-0">
                            <i class="fa-solid fa-link"></i>
                        </span>
                        <select name="icon" id="edit-shortcut-icon" class="saas-input w-full text-xs cursor-pointer">
                            @foreach($iconOptions as $iconClass => $iconLabel)
                                <option value="{{ $iconClass }}">{{ $iconLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">โทนสีป้าย</label>
                        <select name="color_theme" id="edit-shortcut-theme" class="saas-input w-full text-xs cursor-pointer">
                            <option value="indigo">ม่วง-น้ำเงิน (Primary)</option>
                            <option value="emerald">เขียวสาธารณสุข (Emerald)</option>
                            <option value="blue">ฟ้าสดใส (Blue)</option>
                            <option value="amber">ส้มอำพัน (Amber)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ลำดับแสดงผล</label>
                        <input type="number" name="sort_order" id="edit-shortcut-order" min="0" class="saas-input w-full text-xs">
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-5 pt-1">
                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="open_new_tab" id="edit-shortcut-newtab" value="1" class="rounded border-[#E8ECF4] text-[#3126C9]">
                        <span>เปิดในแท็บใหม่</span>
                    </label>

                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_active" id="edit-shortcut-active" value="1" class="rounded border-[#E8ECF4] text-[#3126C9]">
                        <span>เผยแพร่บนหน้าเว็บ</span>
                    </label>
                </div>

                <div class="pt-3 border-t border-[#E8ECF4] flex justify-end gap-2">
                    <button type="button" onclick="$('#edit-shortcut-modal').addClass('hidden')" class="px-4 py-2 rounded-xl border border-[#E8ECF4] text-xs font-heading font-semibold text-[#64748B] hover:bg-[#F8FAFC] cursor-pointer">ยกเลิก</button>
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2 !px-5 cursor-pointer">บันทึกการแก้ไข</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        // อัปเดตตัวอย่างไอคอนเมื่อเปลี่ยน Select ในฟอร์มเพิ่มข้อมูล
        $('#create-icon-select').on('change', function () {
            const iconClass = $(this).val() || 'fa-solid fa-link';
            $('#create-icon-preview').html(`<i class="${iconClass}"></i>`);
        });

        // อัปเดตตัวอย่างไอคอนเมื่อเปลี่ยน Select ใน Modal แก้ไข
        $('#edit-shortcut-icon').on('change', function () {
            const iconClass = $(this).val() || 'fa-solid fa-link';
            $('#edit-icon-preview').html(`<i class="${iconClass}"></i>`);
        });
    });

    window.openEditShortcutModal = function (item) {
        const iconClass = item.icon || 'fa-solid fa-link';
        $('#edit-shortcut-form').attr('action', `/admin/shortcuts/${item.id}`);
        $('#edit-shortcut-title').val(item.title || '');
        $('#edit-shortcut-url').val(item.url || '');
        $('#edit-shortcut-description').val(item.description || '');
        $('#edit-shortcut-icon').val(iconClass);
        $('#edit-icon-preview').html(`<i class="${iconClass}"></i>`);
        $('#edit-shortcut-theme').val(item.color_theme || 'indigo');
        $('#edit-shortcut-order').val(item.sort_order || 0);
        $('#edit-shortcut-newtab').prop('checked', Boolean(item.open_new_tab));
        $('#edit-shortcut-active').prop('checked', Boolean(item.is_active));
        $('#edit-shortcut-modal').removeClass('hidden');
    };
</script>
@endpush
