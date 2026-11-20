@extends('admin.layouts.app')

@section('title', 'จัดการข้อมูลเว็บไซต์ - ระบบบริหารจัดการเว็บไซต์ สสอ.โพธิ์ไทร')

@section('content')
<div class="max-w-7xl w-full mx-auto p-6 md:p-8 space-y-6">

    {{-- Header --}}
    <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#3126C9] to-[#1675E8] text-white grid place-items-center text-lg shrink-0 shadow-sm">
                <i class="fa-solid fa-building-columns"></i>
            </span>
            <div>
                <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                    จัดการข้อมูลเว็บไซต์
                </h1>
                <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-0.5">
                    ตั้งค่าข้อมูลพื้นฐานของหน่วยงาน ช่องทางติดต่อ เวลาทำการ แผนที่ และวิสัยทัศน์องค์กร
                </p>
            </div>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#1E293B] hover:text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold transition-colors self-start sm:self-center shrink-0">
            <i class="fa-solid fa-arrow-left"></i>
            <span>กลับหน้า Admin</span>
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
                <i class="fa-solid fa-triangle-exclamation text-[#EF4444]"></i>
                <span>กรุณาตรวจสอบข้อมูลที่กรอกให้ครบถ้วน</span>
            </div>
            <ul class="list-disc pl-5 m-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.site-info.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- หมวดที่ 1: ชื่อหน่วยงาน ที่อยู่ และเบอร์โทรติดต่อ --}}
        <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] space-y-5">
            <div class="pb-3.5 border-b border-[#E8ECF4]">
                <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-[#3126C9]"></i>
                    <span>1. ข้อมูลชื่อหน่วยงานและช่องทางการติดต่อ</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="org_name_th" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ชื่อหน่วยงาน (Thai) <span class="text-[#EF4444]">*</span>
                    </label>
                    <input type="text"
                           id="org_name_th"
                           name="org_name_th"
                           value="{{ old('org_name_th', $info['org_name_th']) }}"
                           required
                           class="saas-input w-full text-xs"
                           placeholder="สำนักงานสาธารณสุขอำเภอโพธิ์ไทร">
                </div>

                <div>
                    <label for="org_name_en" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ชื่อหน่วยงาน (Eng) <span class="text-[#EF4444]">*</span>
                    </label>
                    <input type="text"
                           id="org_name_en"
                           name="org_name_en"
                           value="{{ old('org_name_en', $info['org_name_en']) }}"
                           required
                           class="saas-input w-full text-xs"
                           placeholder="Pho Sai District Public Health Office">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label for="address" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ที่อยู่ <span class="text-[#EF4444]">*</span>
                    </label>
                    <textarea id="address"
                              name="address"
                              rows="2"
                              required
                              class="saas-input w-full text-xs leading-relaxed"
                              placeholder="ระบุเลขที่ หมู่ ตำบล อำเภอ จังหวัด รหัสไปรษณีย์">{{ old('address', $info['address']) }}</textarea>
                </div>

                <div>
                    <label for="phone" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        เบอร์โทรติดต่อ <span class="text-[#EF4444]">*</span>
                    </label>
                    <input type="text"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', $info['phone']) }}"
                           required
                           class="saas-input w-full text-xs"
                           placeholder="เช่น 045-489-XXX">
                    <span class="block text-[11px] text-[#64748B] mt-1">หากมีหลายหมายเลขให้คั่นด้วยเครื่องหมายจุลภาค (,)</span>
                </div>
            </div>
        </div>

        {{-- หมวดที่ 2: เวลาทำการ (จ-ศ), (ส-อ.) และ Google Map (iframe) --}}
        <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] space-y-5">
            <div class="pb-3.5 border-b border-[#E8ECF4]">
                <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2">
                    <i class="fa-solid fa-clock text-[#1675E8]"></i>
                    <span>2. เวลาทำการและแผนที่ตั้งหน่วยงาน</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="hours_weekday" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        เวลาทำการ (จ-ศ) <span class="text-[#EF4444]">*</span>
                    </label>
                    <input type="text"
                           id="hours_weekday"
                           name="hours_weekday"
                           value="{{ old('hours_weekday', $info['hours_weekday']) }}"
                           required
                           class="saas-input w-full text-xs"
                           placeholder="วันจันทร์ - วันศุกร์ เวลา 08.30 - 16.30 น.">
                </div>

                <div>
                    <label for="hours_weekend" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        เวลาทำการ (ส-อ.) <span class="text-[#EF4444]">*</span>
                    </label>
                    <input type="text"
                           id="hours_weekend"
                           name="hours_weekend"
                           value="{{ old('hours_weekend', $info['hours_weekend']) }}"
                           required
                           class="saas-input w-full text-xs"
                           placeholder="วันเสาร์ - วันอาทิตย์ และวันหยุดนักขัตฤกษ์ ปิดทำการ">
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
                <div>
                    <label for="google_map_iframe" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        Google Map (iframe)
                    </label>
                    <textarea id="google_map_iframe"
                              name="google_map_iframe"
                              rows="5"
                              class="saas-input w-full text-xs font-mono leading-relaxed"
                              placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'>{{ old('google_map_iframe', $info['google_map_iframe']) }}</textarea>
                    <p class="text-[11px] text-[#64748B] m-0 mt-1.5">
                        คัดลอกโค้ด HTML จากเมนู <strong>แชร์ (Share) &rarr; ฝังแผนที่ (Embed a map)</strong> ใน Google Maps มาวางลงในช่องนี้
                    </p>
                </div>

                <div>
                    <span class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ตัวอย่างการแสดงผลแผนที่ (Preview)
                    </span>
                    <div id="map-preview-container" class="w-full h-[180px] rounded-xl border border-[#E8ECF4] bg-[#F8FAFC] overflow-hidden flex items-center justify-center text-xs text-[#64748B]">
                        @if(!empty($info['google_map_iframe']))
                            <div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full">
                                {!! $info['google_map_iframe'] !!}
                            </div>
                        @else
                            <div class="text-center p-4">
                                <i class="fa-solid fa-map-location-dot text-2xl text-[#3126C9]/30 mb-1.5 block"></i>
                                <span>ยังไม่ได้ระบุโค้ด Google Map iframe</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- หมวดที่ 3: สโลแกน, คำขวัญ, ค่านิยม, วิสัยทัศน์ --}}
        <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] space-y-5">
            <div class="pb-3.5 border-b border-[#E8ECF4]">
                <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0 flex items-center gap-2">
                    <i class="fa-solid fa-award text-[#13A678]"></i>
                    <span>3. สโลแกน คำขวัญ ค่านิยม และวิสัยทัศน์องค์กร</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="slogan" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        สโลแกน (Slogan)
                    </label>
                    <input type="text"
                           id="slogan"
                           name="slogan"
                           value="{{ old('slogan', $info['slogan']) }}"
                           class="saas-input w-full text-xs"
                           placeholder="เช่น สุขภาพดี เริ่มต้นที่ชุมชนของเรา">
                </div>

                <div>
                    <label for="motto" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        คำขวัญ (Motto)
                    </label>
                    <input type="text"
                           id="motto"
                           name="motto"
                           value="{{ old('motto', $info['motto']) }}"
                           class="saas-input w-full text-xs"
                           placeholder="ระบุคำขวัญประจำหน่วยงาน">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="core_values" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ค่านิยม (Core Values)
                    </label>
                    <textarea id="core_values"
                              name="core_values"
                              rows="4"
                              class="saas-input w-full text-xs leading-relaxed"
                              placeholder="ระบุค่านิยมองค์กร เช่น MOPH หรือค่านิยมประจำสำนักงานสาธารณสุขอำเภอโพธิ์ไทร...">{{ old('core_values', $info['core_values']) }}</textarea>
                </div>

                <div>
                    <label for="vision" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        วิสัยทัศน์ (Vision)
                    </label>
                    <textarea id="vision"
                              name="vision"
                              rows="4"
                              class="saas-input w-full text-xs leading-relaxed"
                              placeholder="ระบุวิสัยทัศน์ของสำนักงานสาธารณสุขอำเภอโพธิ์ไทร...">{{ old('vision', $info['vision']) }}</textarea>
                </div>
            </div>
        </div>

        {{-- ปุ่มบันทึกข้อมูล --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}"
               class="px-5 py-2.5 rounded-xl bg-white hover:bg-[#F8FAFC] text-[#64748B] border border-[#E8ECF4] text-xs font-heading font-semibold transition-colors">
                ยกเลิก
            </a>
            <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold py-2.5 px-5 cursor-pointer">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>บันทึกข้อมูลเว็บไซต์</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mapTextarea = document.getElementById('google_map_iframe');
        const previewBox = document.getElementById('map-preview-container');

        mapTextarea?.addEventListener('input', function () {
            const val = this.value.trim();
            if (val.includes('<iframe')) {
                previewBox.innerHTML = `<div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full">${val}</div>`;
            } else if (val.startsWith('https://')) {
                previewBox.innerHTML = `<iframe src="${val}" class="w-full h-full border-0" loading="lazy"></iframe>`;
            } else {
                previewBox.innerHTML = `<div class="text-center p-4"><i class="fa-solid fa-map-location-dot text-2xl text-[#3126C9]/30 mb-1.5 block"></i><span>ยังไม่ได้ระบุโค้ด Google Map iframe</span></div>`;
            }
        });
    });
</script>
@endpush
