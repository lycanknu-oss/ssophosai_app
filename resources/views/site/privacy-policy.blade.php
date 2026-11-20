@extends('layouts.app')

@section('title', 'นโยบายการคุ้มครองข้อมูลส่วนบุคคล (PDPA) และ Privacy Policy - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('banner')
    <div class="h-[145px] md:h-[172px] relative overflow-hidden bg-[#124e49]">
        <img src="https://images.pexels.com/photos/40139106/pexels-photo-40139106.jpeg"
             alt="นโยบายการคุ้มครองข้อมูลส่วนบุคคล สำนักงานสาธารณสุขอำเภอโพธิ์ไทร"
             class="w-full h-full object-cover object-[center_45%] opacity-45"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-[#073933]/95 via-[#084e45]/75 to-[#084e45]/40"></div>
        <div class="absolute inset-0 z-10 flex items-center text-white">
            <div class="phs-container">
                <div class="flex items-center gap-1.5 text-[11px] text-[#b9f3dc] mb-1">
                    <a href="{{ route('home') }}" class="hover:underline">หน้าหลัก</a>
                    <span>/</span>
                    <span>นโยบายการคุ้มครองข้อมูลส่วนบุคคล</span>
                </div>
                <h2 class="text-[20px] md:text-[27px] leading-[1.3] font-bold m-0">นโยบายการคุ้มครองข้อมูลส่วนบุคคลและ Privacy Policy</h2>
                <p class="m-0 mt-1 text-[#e7f5ee] text-[11px] md:text-[13px]">การเก็บรวบรวม ใช้ และเปิดเผยข้อมูลส่วนบุคคลตามพระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562 (PDPA)</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @php
        $orgNameTh = \App\Models\SiteSetting::getValue('site_org_name_th', 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร');
        $orgNameEn = \App\Models\SiteSetting::getValue('site_org_name_en', 'Pho Sai District Public Health Office');
        $address   = \App\Models\SiteSetting::getValue('site_address', 'หมู่ที่ 2 ตำบลโพธิ์ไทร อำเภอโพธิ์ไทร จังหวัดอุบลราชธานี 34340');
        $phone     = \App\Models\SiteSetting::getValue('site_phone', '045-496-067');
    @endphp

    {{-- แถบเมนูลัดภายในหน้า --}}
    <div class="phs-card p-3 mb-6 flex flex-wrap gap-2 items-center justify-between">
        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-xs font-semibold text-[#68817d] px-2">หัวข้อในหน้านี้:</span>
            <a href="#pdpa-purpose" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors">1. วัตถุประสงค์</a>
            <a href="#pdpa-data" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors">2. ข้อมูลที่จัดเก็บ</a>
            <a href="#cookie-policy" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors">3. นโยบายการใช้คุกกี้</a>
            <a href="#pdpa-rights" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors">4. สิทธิของเจ้าของข้อมูล</a>
            <a href="#pdpa-contact" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors">5. ช่องทางติดต่อ</a>
        </div>

        <button type="button"
                onclick="resetCookieConsent()"
                class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-[#e8f5f1] text-[#124e49] hover:bg-[#168d83] hover:text-white border border-[#bce2d6] transition-colors cursor-pointer">
            <i class="fa-solid fa-cookie-bite mr-1" aria-hidden="true"></i> ตั้งค่าความยินยอมคุกกี้ใหม่
        </button>
    </div>

    <section class="mb-[29px]" aria-labelledby="policy-main-title">
        <div class="flex justify-between items-end gap-[15px] mb-4">
            <div>
                <span class="text-[11px] font-bold tracking-[1.6px] text-[#168d83] uppercase">PDPA & PRIVACY POLICY</span>
                <h1 id="policy-main-title" class="text-[20px] sm:text-[24px] font-bold leading-[1.3] mt-[3px] mb-0 text-[#124e49]">
                    ประกาศนโยบายการคุ้มครองข้อมูลส่วนบุคคล
                </h1>
            </div>
            <p class="hidden sm:block m-0 text-[#68817d] text-xs">{{ $orgNameTh }} ({{ $orgNameEn }})</p>
        </div>

        <div class="grid grid-cols-1 gap-4">
            {{-- ข้อ 1 --}}
            <article id="pdpa-purpose" class="phs-card p-6 scroll-mt-20">
                <span class="phs-pill mb-2.5">หมวดที่ 1</span>
                <h3 class="text-[17px] font-bold text-[#124e49] mt-0 mb-[9px]">1. วัตถุประสงค์ของการเก็บรวบรวมข้อมูลส่วนบุคคล</h3>
                <p class="m-0 text-[#68817d] text-[13px] leading-relaxed">
                    {{ $orgNameTh }} ตระหนักถึงความสำคัญของการคุ้มครองข้อมูลส่วนบุคคลของประชาชน ผู้รับบริการ และผู้เข้าชมเว็บไซต์ จึงได้จัดทำนโยบายฉบับนี้ขึ้นเพื่อชี้แจงรายละเอียดการเก็บรวบรวม ใช้ และเปิดเผยข้อมูลส่วนบุคคลให้สอดคล้องกับพระราชบัญญัติคุ้มครองข้อมูลส่วนบุคคล พ.ศ. 2562 (PDPA) เพื่อใช้ในการให้บริการข้อมูลข่าวสารสาธารณสุข การรับเรื่องร้องเรียน/ร้องทุกข์ การติดต่อประสานงาน และการปรับปรุงประสิทธิภาพการให้บริการของหน่วยงาน
                </p>
            </article>

            {{-- ข้อ 2 --}}
            <article id="pdpa-data" class="phs-card p-6 scroll-mt-20">
                <span class="phs-pill mb-2.5">หมวดที่ 2</span>
                <h3 class="text-[17px] font-bold text-[#124e49] mt-0 mb-[9px]">2. ข้อมูลส่วนบุคคลที่เว็บไซต์จัดเก็บ</h3>
                <ul class="m-0 pl-5 space-y-2 text-[#68817d] text-[13px] leading-relaxed list-disc">
                    <li><strong class="text-[#124e49]">ข้อมูลจากการเข้าชมเว็บไซต์อัตโนมัติ:</strong> ข้อมูลทางเทคนิค เช่น หมายเลข IP Address ประเภทของเบราว์เซอร์ ระบบปฏิบัติการ วันเวลาที่เข้าใช้งาน และหน้าเว็บที่เข้าชม เพื่อจัดทำสถิติการให้บริการและรักษาความปลอดภัยของระบบ</li>
                    <li><strong class="text-[#124e49]">ข้อมูลที่ท่านกรอกผ่านแบบฟอร์ม:</strong> เช่น ชื่อ-นามสกุล เบอร์โทรศัพท์ อีเมล หรือรายละเอียดข้อเท็จจริงในระบบรับเรื่องร้องเรียน/ข้อเสนอแนะ (ซึ่งท่านสามารถเลือกส่งแบบไม่เปิดเผยตัวตนได้)</li>
                </ul>
            </article>

            {{-- ข้อ 3 --}}
            <article id="cookie-policy" class="phs-card p-6 scroll-mt-20">
                <span class="phs-pill mb-2.5">หมวดที่ 3</span>
                <h3 class="text-[17px] font-bold text-[#124e49] mt-0 mb-[9px]">3. นโยบายการใช้คุกกี้ (Cookie Policy)</h3>
                <p class="m-0 mb-3 text-[#68817d] text-[13px] leading-relaxed">
                    เว็บไซต์นี้ใช้งานคุกกี้ (Cookies) และพื้นที่จัดเก็บข้อมูลบนเบราว์เซอร์ (Local Storage) เพื่อช่วยให้เว็บไซต์ทำงานได้อย่างถูกต้อง ปลอดภัย และจดจำการตั้งค่าการใช้งานของท่าน ดังนี้:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                    <div class="p-4 rounded-[12px] bg-[#f5faf8] border border-[#bce2d6]">
                        <strong class="block text-[#124e49] font-bold mb-1">1. คุกกี้ที่จำเป็นต่อการทำงาน (Strictly Necessary Cookies)</strong>
                        <p class="m-0 text-[#68817d] leading-relaxed">จำเป็นสำหรับการรักษาความปลอดภัยของระบบ (CSRF Token, Session) และการจดจำสถานะการกดยอมรับนโยบายคุกกี้</p>
                    </div>
                    <div class="p-4 rounded-[12px] bg-[#f5faf8] border border-[#bce2d6]">
                        <strong class="block text-[#124e49] font-bold mb-1">2. คุกกี้เพื่อการวิเคราะห์และสถิติ (Analytics Cookies)</strong>
                        <p class="m-0 text-[#68817d] leading-relaxed">ใช้ประมวลผลภาพรวมจำนวนผู้เข้าชมเว็บไซต์ในแต่ละวัน เพื่อนำไปปรับปรุงเนื้อหาและบริการสาธารณสุขให้ดียิ่งขึ้น</p>
                    </div>
                </div>
            </article>

            {{-- ข้อ 4 --}}
            <article id="pdpa-rights" class="phs-card p-6 scroll-mt-20">
                <span class="phs-pill mb-2.5">หมวดที่ 4</span>
                <h3 class="text-[17px] font-bold text-[#124e49] mt-0 mb-[9px]">4. สิทธิของเจ้าของข้อมูลส่วนบุคคล</h3>
                <p class="m-0 text-[#68817d] text-[13px] leading-relaxed">
                    ท่านมีสิทธิขอเข้าถึง ขอรับสำเนา ขอแก้ไขข้อมูลให้ถูกต้อง ขอให้ลบหรือทำลายข้อมูล ขอระงับการใช้ข้อมูล หรือถอนความยินยอมที่ได้ให้ไว้แก่หน่วยงานได้ตลอดเวลา ภายใต้หลักเกณฑ์และเงื่อนไขที่กฎหมายกำหนด
                </p>
            </article>

            {{-- ข้อ 5 --}}
            <article id="pdpa-contact" class="phs-card p-6 scroll-mt-20">
                <span class="phs-pill mb-2.5">หมวดที่ 5</span>
                <h3 class="text-[17px] font-bold text-[#124e49] mt-0 mb-[9px]">5. ช่องทางการติดต่อผู้ควบคุมข้อมูลส่วนบุคคล</h3>
                <div class="p-4 rounded-[12px] bg-[#f5faf8] border border-[#bce2d6] text-[13px] text-[#124e49] space-y-1">
                    <p class="m-0 font-bold">{{ $orgNameTh }} ({{ $orgNameEn }})</p>
                    <p class="m-0 text-[#68817d]">ที่อยู่: {{ $address }}</p>
                    <p class="m-0 text-[#68817d]">โทรศัพท์ติดต่อ: <strong class="text-[#124e49]">{{ $phone }}</strong></p>
                </div>
            </article>
        </div>
    </section>
@endsection
