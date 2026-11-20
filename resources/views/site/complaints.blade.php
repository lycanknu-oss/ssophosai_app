@extends('layouts.app')

@section('title', 'ศูนย์รับเรื่องร้องเรียน / ร้องทุกข์ - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('banner')
    <div class="h-[145px] md:h-[172px] relative overflow-hidden bg-[#124e49]">
        <img src="https://images.pexels.com/photos/40139106/pexels-photo-40139106.jpeg"
             alt="ศูนย์รับเรื่องร้องเรียน / ร้องทุกข์ สำนักงานสาธารณสุขอำเภอโพธิ์ไทร"
             class="w-full h-full object-cover object-[center_45%] opacity-45"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-[#073933]/95 via-[#084e45]/75 to-[#084e45]/40"></div>
        <div class="absolute inset-0 z-10 flex items-center text-white">
            <div class="phs-container">
                <div class="flex items-center gap-1.5 text-[11px] text-[#b9f3dc] mb-1">
                    <a href="{{ route('home') }}" class="hover:underline">หน้าหลัก</a>
                    <span>/</span>
                    <span>รับเรื่องร้องเรียน</span>
                </div>
                <h2 class="text-[20px] md:text-[27px] leading-[1.3] font-bold m-0">ศูนย์รับเรื่องร้องเรียน / ร้องทุกข์</h2>
                <p class="m-0 mt-1 text-[#e7f5ee] text-[11px] md:text-[13px]">ช่องทางรับแจ้งเบาะแสการทุจริต ประพฤติมิชอบ และข้อเสนอแนะการให้บริการด้านสาธารณสุข</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- แถบเมนูลัดและสถิติภาพรวมภายในหน้า --}}
    <div class="phs-card p-3 mb-6 flex flex-wrap justify-between gap-3 items-center">
        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-xs font-semibold text-[#68817d] px-2">หัวข้อในหน้านี้:</span>
            <a href="#complaint-form-section" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors">แบบฟอร์มแจ้งเรื่องร้องเรียน</a>
            <a href="#complaint-track-section" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors">ติดตามสถานะเรื่องร้องเรียน</a>
            <a href="#complaint-process-section" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors">ขั้นตอนการดำเนินการ</a>
        </div>

        <div class="flex flex-wrap items-center gap-2 px-2 text-[11px]">
            <span class="px-2.5 py-1 rounded-lg bg-[#f5faf8] border border-[#dcebe7] text-[#124e49] font-semibold">
                เรื่องทั้งหมด: {{ number_format($stats['total']) }}
            </span>
            <span class="px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 font-semibold">
                กำลังดำเนินการ: {{ number_format($stats['in_progress']) }}
            </span>
            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 font-semibold">
                แล้วเสร็จ: {{ number_format($stats['resolved']) }}
            </span>
        </div>
    </div>

    {{-- แจ้งเตือนเมื่อส่งเรื่องร้องเรียนสำเร็จ พร้อมรหัสติดตาม --}}
    @if(session('complaint_submitted'))
        <div class="phs-card p-5 mb-6 bg-emerald-50/90 border border-emerald-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <span class="w-10 h-10 rounded-xl bg-[#168d83] text-white grid place-items-center text-base shrink-0">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                </span>
                <div>
                    <h3 class="text-[16px] font-bold text-[#124e49] m-0">ระบบได้รับเรื่องร้องเรียนของท่านเรียบร้อยแล้ว</h3>
                    <p class="text-xs text-[#2d635d] m-0 mt-1">กรุณาบันทึกรหัสติดตามด้านล่างไว้ เพื่อใช้ตรวจสอบความคืบหน้าการดำเนินการได้ตลอดเวลา</p>
                </div>
            </div>

            <div class="bg-white border border-[#bce2d6] rounded-[11px] px-4 py-2 text-center shrink-0">
                <span class="block text-[11px] text-[#68817d]">รหัสติดตามเรื่องร้องเรียน</span>
                <strong class="text-base font-bold text-[#124e49] tracking-wider select-all">{{ session('complaint_submitted') }}</strong>
            </div>
        </div>
    @endif

    {{-- แสดงข้อผิดพลาดจากการกรอกฟอร์ม --}}
    @if($errors->any())
        <div class="phs-card p-4 mb-6 bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600" aria-hidden="true"></i>
                <span>กรุณาตรวจสอบข้อมูลที่กรอกให้ครบถ้วน</span>
            </div>
            <ul class="list-disc pl-5 m-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- หัวข้อหลักของหน้า --}}
    <section id="complaints-main" class="mb-[29px]" aria-labelledby="complaints-title">
        <div class="flex justify-between items-end gap-[15px] mb-4">
            <div>
                <span class="text-[11px] font-bold tracking-[1.6px] text-[#168d83] uppercase">PUBLIC COMPLAINT & FEEDBACK</span>
                <h1 id="complaints-title" class="text-[20px] sm:text-[24px] font-bold leading-[1.3] mt-[3px] mb-0 text-[#124e49]">ยื่นเรื่องร้องเรียนและติดตามผลการดำเนินการ</h1>
            </div>
            <p class="hidden sm:block m-0 text-[#68817d] text-xs">สำนักงานสาธารณสุขอำเภอโพธิ์ไทร จังหวัดอุบลราชธานี</p>
        </div>

        {{-- โครงสร้าง 2 คอลัมน์ (ซ้าย 8 ส่วน / ขวา 4 ส่วน) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

            {{-- คอลัมน์ซ้าย: แบบฟอร์มรับเรื่องร้องเรียน --}}
            <article id="complaint-form-section" class="lg:col-span-8 phs-card p-6 scroll-mt-6">
                <span class="phs-pill mb-2.5">แจ้งเรื่องร้องเรียน / ข้อเสนอแนะ</span>
                <h3 class="text-[17px] font-bold text-[#124e49] mt-0 mb-[6px]">แบบฟอร์มรับเรื่องร้องเรียนออนไลน์</h3>
                <p class="m-0 mb-5 text-[#68817d] text-[13px] leading-relaxed">
                    ข้อมูลของผู้ร้องเรียนจะถูกเก็บเป็นความลับตามมาตรฐานราชการ ท่านสามารถเลือกส่งเรื่องแบบไม่เปิดเผยตัวตนได้
                </p>

                <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="category" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                                ประเภทเรื่องร้องเรียน <span class="text-rose-500">*</span>
                            </label>
                            <select id="category" name="category" required
                                    class="w-full rounded-xl border border-[#dcebe7] bg-[#f5faf8] focus:bg-white focus:border-[#168d83] focus:outline-none px-3.5 py-2.5 text-[13px] text-[#124e49] cursor-pointer">
                                <option value="">-- เลือกประเภทเรื่องร้องเรียน --</option>
                                <option value="ร้องเรียนด้านการให้บริการและพฤติกรรมเจ้าหน้าที่" {{ old('category') === 'ร้องเรียนด้านการให้บริการและพฤติกรรมเจ้าหน้าที่' ? 'selected' : '' }}>
                                    1. ด้านการให้บริการและพฤติกรรมเจ้าหน้าที่
                                </option>
                                <option value="แจ้งเบาะแสการทุจริตและประพฤติมิชอบ" {{ old('category') === 'แจ้งเบาะแสการทุจริตและประพฤติมิชอบ' ? 'selected' : '' }}>
                                    2. แจ้งเบาะแสการทุจริตและประพฤติมิชอบ
                                </option>
                                <option value="ร้องเรียนด้านมาตรฐานสถานบริการและสิ่งแวดล้อม" {{ old('category') === 'ร้องเรียนด้านมาตรฐานสถานบริการและสิ่งแวดล้อม' ? 'selected' : '' }}>
                                    3. ด้านมาตรฐานสถานบริการและสิ่งแวดล้อม
                                </option>
                                <option value="ข้อเสนอแนะ / ชมเชยการปฏิบัติงาน" {{ old('category') === 'ข้อเสนอแนะ / ชมเชยการปฏิบัติงาน' ? 'selected' : '' }}>
                                    4. ข้อเสนอแนะ / ชมเชยการปฏิบัติงาน
                                </option>
                                <option value="อื่นๆ" {{ old('category') === 'อื่นๆ' ? 'selected' : '' }}>
                                    5. เรื่องร้องเรียนอื่นๆ
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="target_unit" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                                หน่วยงานที่เกี่ยวข้อง / ถูกร้องเรียน
                            </label>
                            <select id="target_unit" name="target_unit"
                                    class="w-full rounded-xl border border-[#dcebe7] bg-[#f5faf8] focus:bg-white focus:border-[#168d83] focus:outline-none px-3.5 py-2.5 text-[13px] text-[#124e49] cursor-pointer">
                                <option value="สำนักงานสาธารณสุขอำเภอโพธิ์ไทร">สำนักงานสาธารณสุขอำเภอโพธิ์ไทร</option>
                                @foreach($units as $unitName)
                                    <option value="{{ $unitName }}" {{ old('target_unit') === $unitName ? 'selected' : '' }}>
                                        {{ $unitName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                            หัวข้อเรื่องร้องเรียน <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               id="subject"
                               name="subject"
                               value="{{ old('subject') }}"
                               required
                               class="w-full rounded-xl border border-[#dcebe7] bg-[#f5faf8] focus:bg-white focus:border-[#168d83] focus:outline-none px-3.5 py-2.5 text-[13px] text-[#124e49]"
                               placeholder="ระบุสรุปประเด็นเรื่องร้องเรียนโดยย่อ">
                    </div>

                    <div>
                        <label for="details" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                            รายละเอียดข้อเท็จจริง / พฤติการณ์ <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="details"
                                  name="details"
                                  rows="5"
                                  required
                                  class="w-full rounded-xl border border-[#dcebe7] bg-[#f5faf8] focus:bg-white focus:border-[#168d83] focus:outline-none p-3.5 text-[13px] text-[#124e49] leading-relaxed"
                                  placeholder="โปรดระบุรายละเอียดเหตุการณ์ วันเวลา สถานที่ บุคคลที่เกี่ยวข้อง หรือความเสียหายที่เกิดขึ้น...">{{ old('details') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="incident_date" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                                วันที่เกิดเหตุ (ถ้าทราบ)
                            </label>
                            <input type="date"
                                   id="incident_date"
                                   name="incident_date"
                                   max="{{ now()->toDateString() }}"
                                   value="{{ old('incident_date') }}"
                                   class="w-full rounded-xl border border-[#dcebe7] bg-[#f5faf8] focus:bg-white focus:border-[#168d83] focus:outline-none px-3.5 py-2 text-[13px] text-[#124e49]">
                        </div>

                        <div>
                            <label for="attachment" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                                แนบเอกสาร / ภาพถ่ายหลักฐาน (ไม่เกิน 5 MB)
                            </label>
                            <input type="file"
                                   id="attachment"
                                   name="attachment"
                                   accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                   class="w-full rounded-xl border border-[#dcebe7] bg-[#f5faf8] px-3 py-1.5 text-xs text-[#68817d] file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#e8f5f1] file:text-[#124e49] hover:file:bg-[#168d83] hover:file:text-white cursor-pointer">
                        </div>
                    </div>

                    {{-- ส่วนข้อมูลผู้ร้องเรียน (เลือกปกปิดตัวตนได้) --}}
                    <div class="p-4 sm:p-5 rounded-[14px] bg-[#f5faf8] border border-[#bce2d6] space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <h4 class="text-sm font-bold text-[#124e49] m-0">ข้อมูลผู้แจ้งเรื่อง</h4>
                                <p class="text-[11px] text-[#68817d] m-0 mt-0.5">เลือกปกปิดตัวตนได้หากไม่ประสงค์เปิดเผยชื่อ-นามสกุล</p>
                            </div>

                            <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-white border border-[#dcebe7] text-xs font-semibold text-[#124e49] cursor-pointer select-none">
                                <input type="checkbox"
                                       id="is_anonymous"
                                       name="is_anonymous"
                                       value="1"
                                       {{ old('is_anonymous') ? 'checked' : '' }}
                                       class="rounded border-[#dcebe7] text-[#168d83] focus:ring-[#168d83]">
                                <span>ส่งแบบไม่เปิดเผยตัวตน</span>
                            </label>
                        </div>

                        <div id="complainant-fields" class="grid grid-cols-1 sm:grid-cols-3 gap-4 {{ old('is_anonymous') ? 'opacity-50 pointer-events-none' : '' }}">
                            <div>
                                <label for="complainant_name" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                                    ชื่อ - นามสกุล <span class="text-rose-500">*</span>
                                </label>
                                <input type="text"
                                       id="complainant_name"
                                       name="complainant_name"
                                       value="{{ old('complainant_name') }}"
                                       class="w-full rounded-xl border border-[#dcebe7] bg-white focus:border-[#168d83] focus:outline-none px-3.5 py-2 text-[13px] text-[#124e49]"
                                       placeholder="ระบุชื่อ-นามสกุล">
                            </div>

                            <div>
                                <label for="complainant_phone" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                                    เบอร์โทรศัพท์ติดต่อ <span class="text-rose-500">*</span>
                                </label>
                                <input type="text"
                                       id="complainant_phone"
                                       name="complainant_phone"
                                       value="{{ old('complainant_phone') }}"
                                       class="w-full rounded-xl border border-[#dcebe7] bg-white focus:border-[#168d83] focus:outline-none px-3.5 py-2 text-[13px] text-[#124e49]"
                                       placeholder="08X-XXX-XXXX">
                            </div>

                            <div>
                                <label for="complainant_email" class="block text-xs font-semibold text-[#124e49] mb-1.5">
                                    อีเมล (ถ้ามี)
                                </label>
                                <input type="email"
                                       id="complainant_email"
                                       name="complainant_email"
                                       value="{{ old('complainant_email') }}"
                                       class="w-full rounded-xl border border-[#dcebe7] bg-white focus:border-[#168d83] focus:outline-none px-3.5 py-2 text-[13px] text-[#124e49]"
                                       placeholder="name@example.com">
                            </div>
                        </div>
                    </div>

                    {{-- ยืนยันความถูกต้องและ PDPA --}}
                    <label class="flex items-start gap-2.5 text-xs text-[#68817d] cursor-pointer leading-relaxed">
                        <input type="checkbox"
                               name="pdpa_consent"
                               value="1"
                               required
                               class="mt-0.5 rounded border-[#dcebe7] text-[#168d83] focus:ring-[#168d83] shrink-0">
                        <span>
                            ข้าพเจ้าขอรับรองว่าข้อความและเอกสารหลักฐานที่แจ้งข้างต้นเป็นความจริงทุกประการ และยินยอมให้สำนักงานสาธารณสุขอำเภอโพธิ์ไทรประมวลผลข้อมูลเพื่อการตรวจสอบข้อเท็จจริงตามพระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล (PDPA)
                        </span>
                    </label>

                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-[#124e49] hover:bg-[#168d83] text-white text-[13px] font-semibold transition-colors cursor-pointer">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                            <span>ส่งเรื่องร้องเรียน</span>
                        </button>
                    </div>
                </form>
            </article>

            {{-- คอลัมน์ขวา: กล่องติดตามสถานะ + ขั้นตอนการดำเนินงาน --}}
            <div class="lg:col-span-4 space-y-4">

                {{-- กล่องตรวจสอบสถานะเรื่องร้องเรียน --}}
                <article id="complaint-track-section" class="phs-card p-6 scroll-mt-6">
                    <span class="phs-pill mb-2.5">ตรวจสอบสถานะ</span>
                    <h3 class="text-[17px] font-bold text-[#124e49] mt-0 mb-[6px]">ติดตามสถานะเรื่องร้องเรียน</h3>
                    <p class="m-0 text-[#68817d] text-[13px] leading-relaxed">
                        กรอกรหัสติดตามที่ได้รับ (เช่น <code class="text-[#124e49] bg-[#f5faf8] border border-[#dcebe7] px-1.5 py-0.5 rounded font-semibold">CMP-2569-XXXX</code>)
                    </p>

                    <form action="{{ route('complaints.index') }}" method="GET" class="mt-4 flex items-center gap-2">
                        <input type="text"
                               name="track"
                               value="{{ $trackCode }}"
                               class="w-full rounded-xl border border-[#dcebe7] bg-[#f5faf8] focus:bg-white focus:border-[#168d83] focus:outline-none px-3.5 py-2.5 text-[13px] text-[#124e49] uppercase"
                               placeholder="กรอกรหัสติดตาม...">
                        <button type="submit"
                                class="px-4 py-2.5 rounded-xl bg-[#168d83] hover:bg-[#124e49] text-white text-[13px] font-semibold shrink-0 transition-colors cursor-pointer">
                            ตรวจสอบ
                        </button>
                    </form>

                    @if($trackCode !== '')
                        <div class="mt-4 pt-4 border-t border-[#dcebe7]">
                            @if($trackedComplaint)
                                @php $badge = $trackedComplaint->status_label; @endphp
                                <div class="p-4 rounded-[11px] bg-[#f5faf8] border border-[#bce2d6] space-y-2 text-xs">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="font-bold text-[#124e49]">{{ $trackedComplaint->tracking_code }}</span>
                                        <span class="px-2.5 py-0.5 rounded-full border text-[11px] font-semibold {{ $badge['class'] }}">
                                            {{ $badge['text'] }}
                                        </span>
                                    </div>
                                    <div class="font-semibold text-[#124e49]">
                                        {{ $trackedComplaint->subject }}
                                    </div>
                                    <div class="text-[11px] text-[#68817d]">
                                        วันที่แจ้ง: {{ $trackedComplaint->created_at?->format('d/m/Y H:i') }} น.
                                    </div>

                                    @if($trackedComplaint->admin_response)
                                        <div class="mt-2 p-3 rounded-lg bg-white border border-[#dcebe7]">
                                            <span class="block text-[11px] font-semibold text-[#168d83] mb-1">
                                                <i class="fa-solid fa-reply mr-1" aria-hidden="true"></i> คำชี้แจง / ผลการดำเนินการ:
                                            </span>
                                            <p class="text-xs text-[#124e49] m-0 leading-relaxed">{{ $trackedComplaint->admin_response }}</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="p-3.5 rounded-[11px] bg-rose-50 border border-rose-200 text-xs text-rose-700 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                                    <span>ไม่พบข้อมูลรหัสติดตาม <strong>{{ strtoupper($trackCode) }}</strong> ในระบบ</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </article>

                {{-- กล่องขั้นตอนการจัดการเรื่องร้องเรียน --}}
                <article id="complaint-process-section" class="phs-card p-6 scroll-mt-6">
                    <span class="phs-pill mb-2.5">แนวทางปฏิบัติ</span>
                    <h3 class="text-[17px] font-bold text-[#124e49] mt-0 mb-3">ขั้นตอนการดำเนินการ</h3>

                    <ol class="space-y-3.5 text-xs text-[#68817d] m-0 pl-0 list-none">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-[#e8f5f1] text-[#124e49] border border-[#bce2d6] font-bold grid place-items-center shrink-0">1</span>
                            <div>
                                <strong class="text-[#124e49] block">รับเรื่องและออกรหัสติดตาม</strong>
                                <span>ระบบบันทึกข้อมูลและออกรหัสอ้างอิงให้ผู้ร้องเรียนทันที</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-[#e8f5f1] text-[#124e49] border border-[#bce2d6] font-bold grid place-items-center shrink-0">2</span>
                            <div>
                                <strong class="text-[#124e49] block">คัดกรองและตรวจสอบข้อเท็จจริง</strong>
                                <span>คณะกรรมการพิจารณาเรื่องร้องเรียนตรวจสอบข้อมูลภายใน 7 วันทำการ</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-[#168d83] text-white font-bold grid place-items-center shrink-0">3</span>
                            <div>
                                <strong class="text-[#124e49] block">แจ้งผลการดำเนินการ</strong>
                                <span>บันทึกผลการแก้ไขและชี้แจงให้ทราบผ่านระบบติดตามสถานะ</span>
                            </div>
                        </li>
                    </ol>

                    <div class="mt-4 pt-3 border-t border-[#dcebe7] text-[11px] text-[#68817d] flex items-center gap-2">
                        <i class="fa-solid fa-phone-volume text-[#168d83]" aria-hidden="true"></i>
                        <span>สอบถามเพิ่มเติม โทร. 045-489-XXX (ในวันและเวลาราชการ)</span>
                    </div>
                </article>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const anonymousCheckbox = document.getElementById('is_anonymous');
        const fieldsWrapper = document.getElementById('complainant-fields');
        const nameInput = document.getElementById('complainant_name');
        const phoneInput = document.getElementById('complainant_phone');

        function toggleComplainantFields() {
            const isAnon = anonymousCheckbox.checked;
            fieldsWrapper.classList.toggle('opacity-50', isAnon);
            fieldsWrapper.classList.toggle('pointer-events-none', isAnon);
            nameInput.required = !isAnon;
            phoneInput.required = !isAnon;
        }

        if (anonymousCheckbox) {
            toggleComplainantFields();
            anonymousCheckbox.addEventListener('change', toggleComplainantFields);
        }
    });
</script>
@endpush
