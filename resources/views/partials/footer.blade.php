@php
    $footerInfo = [
        'org_name_th' => \App\Models\SiteSetting::getValue('site_org_name_th', 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร'),
        'org_name_en' => \App\Models\SiteSetting::getValue('site_org_name_en', 'Pho Sai District Public Health Office'),
        'address'     => \App\Models\SiteSetting::getValue('site_address', 'หมู่ที่ 2 ตำบลโพธิ์ไทร อำเภอโพธิ์ไทร จังหวัดอุบลราชธานี 34340'),
        'phone'       => \App\Models\SiteSetting::getValue('site_phone', '045-496-067'),
        'slogan'      => \App\Models\SiteSetting::getValue('site_slogan', 'สุขภาพดี เริ่มต้นที่ชุมชนของเรา'),
    ];

    // ดึง Public IP ของผู้เข้าชม (รองรับทั้งตรงและผ่าน Proxy / Cloudflare)
    $clientIp = request()->header('CF-Connecting-IP')
        ?? trim(explode(',', (string) request()->header('X-Forwarded-For'))[0])
        ?: request()->ip();
@endphp

<footer class="bg-[#083833] text-[#d5ece7] border-t border-[#168d83]/30 mt-auto">
    <div class="phs-container py-8">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pb-6 border-b border-white/10">
            {{-- ข้อมูลหน่วยงาน --}}
            <div class="space-y-1.5">
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-[#168d83]/25 border border-[#168d83]/50 text-[#9ce8d6] grid place-items-center text-sm shrink-0">
                        <i class="fa-solid fa-house-medical" aria-hidden="true"></i>
                    </span>
                    <div>
                        <strong class="block text-sm sm:text-base font-bold text-white leading-tight">
                            {{ $footerInfo['org_name_th'] }}
                        </strong>
                        <span class="block text-[11px] text-[#9ce8d6]">
                            {{ $footerInfo['org_name_en'] }}
                        </span>
                    </div>
                </div>
                <p class="text-xs text-[#b8dad3] m-0 pt-1">
                    {{ $footerInfo['address'] }} &bull; โทรศัพท์: <span class="text-white font-semibold">{{ $footerInfo['phone'] }}</span>
                </p>
            </div>

            {{-- เมนูลัดส่วนท้ายเว็บไซต์ --}}
            <nav aria-label="เมนูลัดส่วนท้ายเว็บไซต์" class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs font-medium">
                <a href="{{ route('home') }}" class="text-[#d5ece7] hover:text-white transition-colors">หน้าหลัก</a>
                <a href="{{ route('subordinate-units') }}" class="text-[#d5ece7] hover:text-white transition-colors">หน่วยงานภายใต้สังกัด</a>
                <a href="{{ route('complaints.index') }}" class="text-[#d5ece7] hover:text-white transition-colors">รับเรื่องร้องเรียน</a>
                <a href="{{ route('home') }}#contact" class="text-[#d5ece7] hover:text-white transition-colors">ติดต่อเรา</a>
            </nav>
        </div>

        {{-- แถบล่าง: Copyright และ Your public IP --}}
        <div class="pt-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-[#9ec7bf]">
            <p class="m-0 text-center sm:text-left">
                &copy; {{ now()->year + 543 }} ({{ now()->year }}) {{ $footerInfo['org_name_th'] }} ({{ $footerInfo['org_name_en'] }}). All Rights Reserved.
                <br>By. Kritsanu Krunsaw IT-officer
            </p>

            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/8 border border-white/15 text-[#d5ece7]">
                <span class="w-1.5 h-1.5 rounded-full bg-[#34d399]" aria-hidden="true"></span>
                <span>Your public IP is: <strong class="font-mono font-semibold text-white">{{ $clientIp }}</strong></span>
            </div>
        </div>
    </div>
</footer>
{{-- Fixed-Footer Cookie Consent Banner (Frosted Glassmorphism UI) --}}
<div id="cookie-consent-banner"
     role="region"
     aria-label="การแจ้งเตือนการใช้คุกกี้"
     class="hidden fixed bottom-0 inset-x-0 z-50 p-3 sm:p-4 pointer-events-none">
    <div class="phs-container pointer-events-auto">
        <div class="relative overflow-hidden rounded-[22px] p-4 sm:p-5 bg-white/75 backdrop-blur-xl border border-white/85 shadow-[0_16px_40px_rgba(13,79,73,0.18)] ring-1 ring-[#168d83]/15 flex flex-col lg:flex-row lg:items-center justify-between gap-4">

            {{-- วงกลมแสงเรืองรองด้านหลังกระจกฝ้า (Ambient Glow) --}}
            <span class="pointer-events-none absolute -left-10 -bottom-12 w-40 h-40 rounded-full bg-[#22b8a8]/20 blur-2xl"></span>
            <span class="pointer-events-none absolute right-10 -top-12 w-36 h-36 rounded-full bg-[#168d83]/15 blur-2xl"></span>

            <div class="relative z-10 flex items-start gap-3.5 max-w-3xl">
                <span class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#e8f5f1]/90 to-white/90 border border-[#bce2d6] text-[#168d83] grid place-items-center text-lg shrink-0 mt-0.5 shadow-xs backdrop-blur-md">
                    <i class="fa-solid fa-cookie-bite" aria-hidden="true"></i>
                </span>
                <div class="space-y-1">
                    <h3 class="text-sm sm:text-[15px] font-bold text-[#124e49] m-0">
                        เว็บไซต์นี้ใช้คุกกี้ (Cookies) เพื่อพัฒนาประสบการณ์การใช้งานของท่าน
                    </h3>
                    <p class="text-xs text-[#4b6662] m-0 leading-relaxed">
                        เราใช้คุกกี้ที่จำเป็นต่อการทำงานของเว็บไซต์และการวิเคราะห์สถิติการเข้าชม ท่านสามารถศึกษารายละเอียดเพิ่มเติมได้ที่
                        <a href="{{ route('privacy-policy') }}" class="underline font-semibold text-[#168d83] hover:text-[#0d4f49] transition-colors">
                            นโยบายการคุ้มครองข้อมูลส่วนบุคคล (PDPA) และ Privacy Policy
                        </a>
                    </p>
                </div>
            </div>

            <div class="relative z-10 flex flex-wrap items-center gap-2.5 shrink-0 self-end lg:self-center">
                <a href="{{ route('privacy-policy') }}"
                   class="px-4 py-2.5 rounded-xl bg-white/65 hover:bg-white/95 text-[#124e49] border border-[#bce2d6] backdrop-blur-md text-xs font-semibold transition-all shadow-2xs">
                    อ่านนโยบาย
                </a>
                <button type="button"
                        id="accept-cookie-btn"
                        class="px-5 py-2.5 rounded-xl text-white text-xs font-bold shadow-[0_6px_18px_rgba(22,141,131,0.3)] hover:shadow-[0_8px_22px_rgba(22,141,131,0.4)] hover:-translate-y-0.5 transition-all cursor-pointer inline-flex items-center gap-1.5"
                        style="background: linear-gradient(135deg, #0d4f49 0%, #168d83 65%, #22b8a8 100%);">
                    <i class="fa-solid fa-check text-[#d3f9ed]" aria-hidden="true"></i>
                    <span>ยอมรับการใช้งานคุกกี้</span>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const STORAGE_KEY = 'ssophosai_cookie_consent_v1';
        const banner = document.getElementById('cookie-consent-banner');
        const acceptBtn = document.getElementById('accept-cookie-btn');

        // ตรวจสอบว่าเคยกดยอมรับแล้วหรือยัง
        if (banner && !localStorage.getItem(STORAGE_KEY)) {
            banner.classList.remove('hidden');
        }

        // เมื่อกดปุ่มยอมรับ ให้บันทึกสถานะและซ่อนแถบแจ้งเตือนถาวร
        acceptBtn?.addEventListener('click', function () {
            localStorage.setItem(STORAGE_KEY, JSON.stringify({
                accepted: true,
                accepted_at: new Date().toISOString()
            }));
            banner.classList.add('hidden');
        });

        // ฟังก์ชันเสริมสำหรับให้ผู้ใช้เปิดแถบตั้งค่าคุกกี้ใหม่จากหน้านโยบาย
        window.resetCookieConsent = function () {
            localStorage.removeItem(STORAGE_KEY);
            banner?.classList.remove('hidden');
        };
    });
</script>
