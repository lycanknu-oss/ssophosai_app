@extends('admin.layouts.app')

@section('title', 'จัดการบริการของเรา - ระบบบริหารจัดการเว็บไซต์ สสอ.โพธิ์ไทร')

@section('content')
<div class="max-w-7xl w-full mx-auto p-6 md:p-8 space-y-6">

    {{-- Header --}}
    <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#3126C9] to-[#1675E8] text-white grid place-items-center text-lg shrink-0 saas-shadow-glow">
                <i class="fa-solid fa-hand-holding-medical"></i>
            </span>
            <div>
                <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                    จัดการบริการของเรา (Our Services)
                </h1>
                <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-0.5">
                    บริหารจัดการรายการบริการด้านสาธารณสุข ระบบสารสนเทศ และลิงก์บริการประชาชนหน้าเว็บไซต์
                </p>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#1E293B] hover:text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold transition-colors self-start sm:self-center shrink-0">
            <i class="fa-solid fa-arrow-left"></i>
            <span>กลับหน้าหลัก Admin</span>
        </a>
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

    {{-- ฟอร์มเพิ่มรายการบริการใหม่ --}}
    <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4]">
        <div class="pb-4 mb-5 border-b border-[#E8ECF4] flex items-center justify-between">
            <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2">
                <i class="fa-solid fa-circle-plus text-[#3126C9]"></i>
                <span>เพิ่มรายการบริการใหม่</span>
            </h2>
            <span class="text-xs text-[#64748B]">ทั้งหมด {{ $services->count() }} รายการ</span>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="service-title" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ชื่อบริการ <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="service-title"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           class="saas-input w-full text-xs"
                           placeholder="เช่น ระบบรายงานข้อมูลสาธารณสุข (HDC)">
                </div>

                <div>
                    <label for="service-subtitle" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        หัวข้อย่อย / หมวดหมู่บริการ
                    </label>
                    <input type="text"
                           id="service-subtitle"
                           name="subtitle"
                           value="{{ old('subtitle') }}"
                           class="saas-input w-full text-xs"
                           placeholder="เช่น งานสารสนเทศและระบาดวิทยา">
                </div>
            </div>

            <div>
                <label for="service-description" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    คำอธิบายบริการโดยย่อ
                </label>
                <textarea id="service-description"
                          name="description"
                          rows="2"
                          class="saas-input w-full text-xs leading-relaxed"
                          placeholder="รายละเอียดขอบเขตการให้บริการ ขั้นตอน หรือกลุ่มผู้รับบริการ...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- คลาสไอคอน Font Awesome + พรีวิว --}}
                <div>
                    <label for="service-icon" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ไอคอน (Font Awesome) <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <span id="create-icon-preview" class="w-10 h-10 rounded-xl bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] grid place-items-center text-sm shrink-0">
                            <i class="fa-solid fa-hand-holding-medical"></i>
                        </span>
                        <input type="text"
                               id="service-icon"
                               name="icon"
                               value="{{ old('icon', 'fa-solid fa-hand-holding-medical') }}"
                               required
                               class="saas-input w-full text-xs"
                               placeholder="fa-solid fa-stethoscope">
                    </div>
                </div>

                {{-- โทนสีการ์ด --}}
                <div>
                    <label for="service-color" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        โทนสีสัญลักษณ์
                    </label>
                    <select id="service-color" name="badge_color" class="saas-input w-full text-xs cursor-pointer">
                        <option value="purple" {{ old('badge_color') === 'purple' ? 'selected' : '' }}>ม่วงน้ำเงิน (Primary)</option>
                        <option value="blue" {{ old('badge_color') === 'blue' ? 'selected' : '' }}>ฟ้า (Info)</option>
                        <option value="green" {{ old('badge_color') === 'green' ? 'selected' : '' }}>เขียวมรกต (Success)</option>
                        <option value="orange" {{ old('badge_color') === 'orange' ? 'selected' : '' }}>ส้มอำพัน (Accent)</option>
                    </select>
                </div>

                {{-- ลิงก์ปลายทาง --}}
                <div>
                    <label for="service-link" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ลิงก์ URL ปลายทาง
                    </label>
                    <input type="text"
                           id="service-link"
                           name="link_url"
                           value="{{ old('link_url') }}"
                           class="saas-input w-full text-xs"
                           placeholder="https://... หรือ /documents">
                </div>

                {{-- ลำดับการแสดงผล --}}
                <div>
                    <label for="service-order" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ลำดับการแสดงผล
                    </label>
                    <input type="number"
                           id="service-order"
                           name="sort_order"
                           value="{{ old('sort_order', 0) }}"
                           min="0"
                           class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="pt-3 border-t border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-5 text-xs text-[#1E293B]">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">เปิดใช้งานและแสดงบนหน้าเว็บไซต์</span>
                    </label>

                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="is_external" value="1" {{ old('is_external') ? 'checked' : '' }} class="w-4 h-4 rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">เปิดลิงก์ในแท็บใหม่ (Target Blank)</span>
                    </label>
                </div>

                <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-5 cursor-pointer self-start sm:self-auto">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>บันทึกรายการบริการ</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ตารางแสดงรายการบริการทั้งหมด (Material Design 3 Clean Table) --}}
    <div class="saas-card overflow-hidden bg-white rounded-2xl border border-[#E8ECF4]">
        <div class="p-5 border-b border-[#E8ECF4] flex items-center justify-between">
            <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0">
                รายการบริการของเราทั้งหมด
            </h2>
            <span class="text-xs text-[#64748B]">เรียงตามลำดับการแสดงผล (น้อยไปมาก)</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                        <th class="p-4 w-16 text-center">ลำดับ</th>
                        <th class="p-4 w-16 text-center">ไอคอน</th>
                        <th class="p-4">ชื่อบริการและรายละเอียด</th>
                        <th class="p-4">ลิงก์ปลายทาง</th>
                        <th class="p-4 w-28 text-center">สถานะ</th>
                        <th class="p-4 w-36 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                    @forelse($services as $service)
                        @php
                            $badgeStyle = match($service->badge_color) {
                                'blue'   => 'bg-sky-50 text-[#1675E8] border-sky-200',
                                'green'  => 'bg-emerald-50 text-[#13A678] border-emerald-200',
                                'orange' => 'bg-amber-50 text-[#F49A22] border-amber-200',
                                default  => 'bg-[#EEF2FF] text-[#3126C9] border-indigo-200',
                            };
                        @endphp
                        <tr class="hover:bg-[#F8FAFC] transition-colors">
                            <td class="p-4 text-center font-heading font-bold text-[#64748B]">
                                {{ $service->sort_order }}
                            </td>
                            <td class="p-4 text-center">
                                <span class="w-10 h-10 rounded-xl border {{ $badgeStyle }} inline-grid place-items-center text-sm">
                                    <i class="{{ $service->icon }}"></i>
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="font-heading font-bold text-sm text-[#1E293B]">{{ $service->title }}</div>
                                @if($service->subtitle)
                                    <div class="text-[11px] font-semibold text-[#3126C9] mt-0.5">{{ $service->subtitle }}</div>
                                @endif
                                @if($service->description)
                                    <p class="text-[#64748B] m-0 mt-1 line-clamp-2 leading-relaxed">{{ $service->description }}</p>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($service->link_url)
                                    <a href="{{ $service->link_url }}"
                                       target="{{ $service->is_external ? '_blank' : '_self' }}"
                                       rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1.5 text-[#1675E8] hover:underline break-all">
                                        <span>{{ Str::limit($service->link_url, 40) }}</span>
                                        @if($service->is_external)
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        @endif
                                    </a>
                                @else
                                    <span class="text-[#64748B]">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                @if($service->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-[#16A34A] font-heading font-semibold text-[11px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span> แสดงผล
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-[#64748B] font-heading font-semibold text-[11px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#64748B]"></span> ซ่อนไว้
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button"
                                            onclick='openEditServiceModal(@json($service))'
                                            class="px-3 py-1.5 rounded-lg bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white font-heading font-semibold transition-colors cursor-pointer">
                                        <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                                    </button>

                                    <form action="{{ route('admin.services.destroy', $service) }}"
                                          method="POST"
                                          onsubmit="return confirm('ยืนยันการลบบริการ \'{{ addslashes($service->title) }}\' ใช่หรือไม่?');"
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
                            <td colspan="6" class="p-10 text-center text-[#64748B]">
                                <i class="fa-solid fa-hand-holding-medical text-3xl text-[#3126C9]/30 mb-2 block"></i>
                                <p class="text-sm font-heading font-bold text-[#1E293B] m-0">ยังไม่มีรายการบริการในระบบ</p>
                                <p class="text-xs m-0 mt-1">เริ่มต้นเพิ่มรายการบริการของเราได้จากแบบฟอร์มด้านบน</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL: แก้ไขรายการบริการ --}}
<div id="edit-service-modal" class="hidden fixed inset-0 z-50 bg-slate-900/65 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="saas-card bg-white !bg-white rounded-2xl border border-[#E8ECF4] shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 sm:p-7 relative">
        <button type="button"
                onclick="closeEditServiceModal()"
                class="w-8 h-8 rounded-full bg-[#F8FAFC] hover:bg-rose-50 text-[#64748B] hover:text-rose-600 border border-[#E8ECF4] grid place-items-center absolute top-5 right-5 cursor-pointer"
                aria-label="ปิดหน้าต่าง">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <h3 class="text-[18px] sm:text-[20px] font-heading font-bold text-[#1E293B] m-0 pb-4 mb-5 border-b border-[#E8ECF4] flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-[#3126C9]"></i>
            <span>แก้ไขข้อมูลบริการ</span>
        </h3>

        <form id="edit-service-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="edit-service-title" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ชื่อบริการ <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="edit-service-title" name="title" required class="saas-input w-full text-xs">
                </div>

                <div>
                    <label for="edit-service-subtitle" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        หัวข้อย่อย / หมวดหมู่บริการ
                    </label>
                    <input type="text" id="edit-service-subtitle" name="subtitle" class="saas-input w-full text-xs">
                </div>
            </div>

            <div>
                <label for="edit-service-description" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    คำอธิบายบริการโดยย่อ
                </label>
                <textarea id="edit-service-description" name="description" rows="3" class="saas-input w-full text-xs leading-relaxed"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="edit-service-icon" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ไอคอน (Font Awesome) <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <span id="edit-icon-preview" class="w-10 h-10 rounded-xl bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] grid place-items-center text-sm shrink-0">
                            <i class="fa-solid fa-hand-holding-medical"></i>
                        </span>
                        <input type="text" id="edit-service-icon" name="icon" required class="saas-input w-full text-xs">
                    </div>
                </div>

                <div>
                    <label for="edit-service-color" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        โทนสีสัญลักษณ์
                    </label>
                    <select id="edit-service-color" name="badge_color" class="saas-input w-full text-xs cursor-pointer">
                        <option value="purple">ม่วงน้ำเงิน (Primary)</option>
                        <option value="blue">ฟ้า (Info)</option>
                        <option value="green">เขียวมรกต (Success)</option>
                        <option value="orange">ส้มอำพัน (Accent)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="edit-service-link" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ลิงก์ URL ปลายทาง
                    </label>
                    <input type="text" id="edit-service-link" name="link_url" class="saas-input w-full text-xs">
                </div>

                <div>
                    <label for="edit-service-order" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ลำดับการแสดงผล
                    </label>
                    <input type="number" id="edit-service-order" name="sort_order" min="0" class="saas-input w-full text-xs">
                </div>
            </div>

            <div class="pt-3 border-t border-[#E8ECF4] flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-5 text-xs text-[#1E293B]">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" id="edit-service-active" name="is_active" value="1" class="w-4 h-4 rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">เปิดใช้งาน</span>
                    </label>

                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" id="edit-service-external" name="is_external" value="1" class="w-4 h-4 rounded border-[#E8ECF4] text-[#3126C9] focus:ring-[#675CF0]">
                        <span class="font-medium">เปิดในแท็บใหม่</span>
                    </label>
                </div>

                <div class="flex items-center gap-2 ml-auto">
                    <button type="button"
                            onclick="closeEditServiceModal()"
                            class="px-4 py-2.5 rounded-xl bg-[#F8FAFC] hover:bg-slate-200 text-[#64748B] text-xs font-heading font-semibold transition-colors cursor-pointer">
                        ยกเลิก
                    </button>
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-5 cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>บันทึกการแก้ไข</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const createIconInput = document.getElementById('service-icon');
        const createIconPreview = document.getElementById('create-icon-preview');
        const editIconInput = document.getElementById('edit-service-icon');
        const editIconPreview = document.getElementById('edit-icon-preview');

        createIconInput?.addEventListener('input', function () {
            createIconPreview.innerHTML = `<i class="${this.value || 'fa-solid fa-hand-holding-medical'}"></i>`;
        });

        editIconInput?.addEventListener('input', function () {
            editIconPreview.innerHTML = `<i class="${this.value || 'fa-solid fa-hand-holding-medical'}"></i>`;
        });

        const editModal = document.getElementById('edit-service-modal');
        editModal?.addEventListener('click', function (e) {
            if (e.target === this) {
                closeEditServiceModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && editModal && !editModal.classList.contains('hidden')) {
                closeEditServiceModal();
            }
        });
    });

    window.openEditServiceModal = function (service) {
        const form = document.getElementById('edit-service-form');
        form.action = `/admin/services/${service.id}`;

        document.getElementById('edit-service-title').value = service.title || '';
        document.getElementById('edit-service-subtitle').value = service.subtitle || '';
        document.getElementById('edit-service-description').value = service.description || '';
        document.getElementById('edit-service-icon').value = service.icon || 'fa-solid fa-hand-holding-medical';
        document.getElementById('edit-icon-preview').innerHTML = `<i class="${service.icon || 'fa-solid fa-hand-holding-medical'}"></i>`;
        document.getElementById('edit-service-color').value = service.badge_color || 'purple';
        document.getElementById('edit-service-link').value = service.link_url || '';
        document.getElementById('edit-service-order').value = service.sort_order ?? 0;
        document.getElementById('edit-service-active').checked = Boolean(service.is_active);
        document.getElementById('edit-service-external').checked = Boolean(service.is_external);

        document.getElementById('edit-service-modal').classList.remove('hidden');
    };

    window.closeEditServiceModal = function () {
        document.getElementById('edit-service-modal').classList.add('hidden');
    };
</script>
@endpush
