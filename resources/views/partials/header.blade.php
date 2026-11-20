<header id="top" class="relative z-40">
    {{-- 1. Topline ไล่เฉดสี Full-Gradient --}}
    <div class="text-white text-[11px] sm:text-xs shadow-xs" style="background: linear-gradient(135deg, #093834 0%, #0d4f49 100%);">
        <div class="phs-container flex flex-col sm:flex-row justify-between items-center gap-1 sm:gap-3 py-2 text-center sm:text-left">
            <span class="inline-flex items-center gap-2">
                <i class="fa-solid fa-heart-pulse text-[#a6ead3] text-[13px] shrink-0" aria-hidden="true"></i>
                <span>เว็บไซต์ข้อมูลสาธารณสุขระดับอำเภอ</span>
            </span>
            <span class="inline-flex items-center gap-2">
                <i class="fa-solid fa-location-dot text-[#a6ead3] text-[13px] shrink-0" aria-hidden="true"></i>
                <span>อำเภอโพธิ์ไทร จังหวัดอุบลราชธานี</span>
            </span>
        </div>
    </div>

    {{-- 2. Brandbar พื้นหลังไล่เฉดละมุนตา --}}
    <div class="border-b border-[#dcebe7]/70" style="background: linear-gradient(180deg, #ffffff 0%, #f5faf8 100%);">
        <div class="phs-container flex items-center justify-between gap-4 py-3.5 md:py-5">
            <a href="{{ route('home') }}" class="flex items-center gap-3 md:gap-[15px] group min-w-0" aria-label="กลับไปหน้าหลัก">
                <span class="w-[46px] h-[46px] sm:w-[54px] sm:h-[54px] md:w-[63px] md:h-[63px] rounded-[100px] bg-white border border-[#bce2d6] grid place-items-center shadow-[0_8px_20px_rgba(22,141,131,0.16)] shrink-0 transition-transform group-hover:scale-105 overflow-hidden">
                    <img src="{{ asset('dist/img/logo_moph.png') }}"
                        alt="โลโก้สำนักงานสาธารณสุขอำเภอโพธิ์ไทร"
                        class="w-full h-full object-contain">
                </span>
                <div class="min-w-0">
                    <h1 class="text-[16px] sm:text-[19px] md:text-[23px] leading-[1.25] font-bold text-[#124e49] m-0 truncate flex items-center gap-2">
                        <span>สำนักงานสาธารณสุขอำเภอโพธิ์ไทร</span>
                    </h1>
                    <p class="text-[10px] md:text-xs text-[#168d83] font-medium mt-[2px] mb-0 tracking-wide truncate flex items-center gap-1.5">
                        <i class="fa-solid fa-staff-snake text-[11px]" aria-hidden="true"></i>
                        <span>PHO SAI DISTRICT PUBLIC HEALTH OFFICE</span>
                    </p>
                </div>
            </a>

            <div class="hidden lg:flex items-center gap-2 text-[#124e49] bg-white border border-[#bce2d6] rounded-full px-4 py-2 text-xs font-semibold shadow-xs shrink-0">
                <i class="fa-solid fa-shield-heart text-[#168d83] text-[15px]" aria-hidden="true"></i>
                <span>ดูแลสุขภาพชุมชนอย่างทั่วถึง</span>
            </div>
        </div>
    </div>

    {{-- 3. Banner ภาพกิจกรรม Full-Gradient Overlay --}}
    @hasSection('banner')
        @yield('banner')
    @else
        <div class="h-[140px] sm:h-[160px] md:h-[172px] relative overflow-hidden" style="background: linear-gradient(135deg, #0d4f49 0%, #168d83 100%);">
            <img src="https://images.pexels.com/photos/40139106/pexels-photo-40139106.jpeg"
                 alt="กิจกรรมส่งเสริมสุขภาพชุมชน"
                 class="w-full h-full object-cover object-[center_45%] opacity-40 mix-blend-overlay"
                 loading="lazy">
            <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(7,57,51,0.92) 0%, rgba(22,141,131,0.75) 60%, rgba(13,79,73,0.85) 100%);"></div>
            <div class="absolute inset-0 z-10 flex items-center text-white">
                <div class="phs-container">
                    <span class="text-[#b9f3dc] text-[10px] sm:text-xs tracking-[1px] font-semibold uppercase inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 border border-white/25 mb-1.5 backdrop-blur-xs">
                        <i class="fa-solid fa-hand-holding-medical" aria-hidden="true"></i>
                        <span>PUBLIC HEALTH FOR EVERYONE</span>
                    </span>
                    <h2 class="text-[19px] sm:text-[23px] md:text-[27px] leading-[1.3] font-bold mt-0.5 mb-1 text-white">สุขภาพดี เริ่มต้นที่ชุมชนของเรา</h2>
                    <p class="m-0 text-[#e7f5ee] text-[11px] sm:text-xs md:text-[13px]">ข้อมูลข่าวสารและบริการเพื่อประชาชนอำเภอโพธิ์ไทร</p>
                </div>
            </div>
        </div>
    @endif
</header>

{{-- 4. All-Device Responsive Sticky Navbar (Full-Gradient Palette) --}}
<nav id="main-navbar" class="sticky top-0 z-50 text-white shadow-[0_6px_20px_rgba(13,79,73,0.3)] border-b border-white/15" style="background: linear-gradient(135deg, #0d4f49 0%, #168d83 55%, #124e49 100%);" aria-label="เมนูหลัก">
    <div class="phs-container">
        <div class="flex items-center justify-between h-[52px] lg:h-auto">

            {{-- Mobile / Tablet Brand Label & Quick Home --}}
            <div class="flex items-center gap-2 lg:hidden">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-white bg-white/20 hover:bg-white/30 px-3 py-1.5 rounded-lg border border-white/25 transition-colors">
                    <i class="fa-solid fa-house text-[13px]" aria-hidden="true"></i>
                    <span>เมนูหลัก</span>
                </a>
            </div>

            {{-- Desktop Menu (แสดงบนจอใหญ่ lg ขึ้นไป) --}}
            <div class="hidden lg:flex items-center gap-0.5 flex-wrap">
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'bg-white/25 text-white shadow-xs' : '' }} whitespace-nowrap px-3.5 py-[14px] text-[13px] font-medium hover:bg-white/15 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-house text-[13px] text-[#a6ead3]" aria-hidden="true"></i>
                    <span>หน้าหลัก</span>
                </a>

                <a href="{{ route('organization') }}"
                   class="{{ request()->routeIs('organization*') ? 'bg-white/25 text-white shadow-xs' : '' }} whitespace-nowrap px-3.5 py-[14px] text-[13px] font-medium hover:bg-white/15 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-sitemap text-[13px] text-[#a6ead3]" aria-hidden="true"></i>
                    <span>เกี่ยวกับองค์กร</span>
                </a>

                {{-- Dropdown เมนู: ข่าวกิจกรรม --}}
                <div class="relative group">
                    <button type="button"
                            class="{{ request()->routeIs('activities*') ? 'bg-white/25 text-white shadow-xs' : '' }} whitespace-nowrap px-3.5 py-[14px] text-[13px] font-medium text-white hover:bg-white/15 transition-colors inline-flex items-center gap-2 cursor-pointer"
                            aria-expanded="false"
                            aria-haspopup="true">
                        <i class="fa-solid fa-bullhorn text-[13px] text-[#a6ead3]" aria-hidden="true"></i>
                        <span>ข่าวกิจกรรม</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-[#a6ead3] transition-transform duration-200 group-hover:rotate-180" aria-hidden="true"></i>
                    </button>

                    {{-- เมนูย่อย Dropdown --}}
                    <div class="invisible opacity-0 translate-y-1 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200 absolute left-0 top-full pt-1 z-50 w-60">
                        <div class="bg-white rounded-2xl border border-[#dcebe7] shadow-xl p-1.5 space-y-0.5 text-xs">
                            <a href="{{ route('activities', ['category' => 'general']) }}"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[#1E293B] hover:bg-[#f5faf8] hover:text-[#168d83] font-medium transition-colors">
                                <i class="fa-solid fa-newspaper w-4 text-center text-[#168d83]" aria-hidden="true"></i>
                                <span>ข่าวทั่วไป</span>
                            </a>

                            <a href="{{ route('activities', ['category' => 'recruitment']) }}"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[#1E293B] hover:bg-[#f5faf8] hover:text-[#13A678] font-medium transition-colors">
                                <i class="fa-solid fa-user-tie w-4 text-center text-[#13A678]" aria-hidden="true"></i>
                                <span>ข่าวรับสมัครงาน</span>
                            </a>

                            <a href="{{ route('activities', ['category' => 'procurement']) }}"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[#1E293B] hover:bg-[#f5faf8] hover:text-[#d97706] font-medium transition-colors">
                                <i class="fa-solid fa-file-invoice-dollar w-4 text-center text-[#d97706]" aria-hidden="true"></i>
                                <span>ข่าวจัดซื้อจัดจ้าง</span>
                            </a>

                            <a href="{{ route('activities', ['category' => 'hr']) }}"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[#1E293B] hover:bg-[#f5faf8] hover:text-[#1675E8] font-medium transition-colors">
                                <i class="fa-solid fa-id-card-clip w-4 text-center text-[#1675E8]" aria-hidden="true"></i>
                                <span>HR (บริหารงานบุคคล)</span>
                            </a>

                            <div class="my-1 border-t border-[#dcebe7]"></div>

                            <a href="{{ route('home') }}#onepage"
                               class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-[#124e49] bg-[#f5faf8] hover:bg-[#e8f5f1] font-semibold transition-colors">
                                <i class="fa-solid fa-photo-film w-4 text-center text-[#168d83]" aria-hidden="true"></i>
                                <span>อัลบั้มภาพ</span>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="https://forums.ssophosai.in.th/"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="whitespace-nowrap px-3.5 py-[14px] text-[13px] font-medium hover:bg-white/15 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-right-left text-[13px] text-[#a6ead3]" aria-hidden="true"></i>
                    <span>รับส่งข้อมูล</span>
                </a>

                <a href="{{ route('home') }}#calendar"
                   class="whitespace-nowrap px-3.5 py-[14px] text-[13px] font-medium hover:bg-white/15 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-[13px] text-[#a6ead3]" aria-hidden="true"></i>
                    <span>ปฏิทินกิจกรรม</span>
                </a>

                <a href="{{ route('documents') }}"
                   class="{{ request()->routeIs('documents*') ? 'bg-white/25 text-white shadow-xs' : '' }} whitespace-nowrap px-3.5 py-[14px] text-[13px] font-medium hover:bg-white/15 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-file-lines text-[13px] text-[#a6ead3]" aria-hidden="true"></i>
                    <span>เอกสารเผยแพร่</span>
                </a>

                <a href="{{ route('internal-links') }}"
                   class="{{ request()->routeIs('internal-links*') ? 'bg-white/25 text-white shadow-xs' : '' }} whitespace-nowrap px-3.5 py-[14px] text-[13px] font-medium hover:bg-white/15 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-up-right-from-square text-[13px] text-[#a6ead3]" aria-hidden="true"></i>
                    <span>ลิงก์ภายใน</span>
                </a>
            </div>

            {{-- Desktop Right Action --}}
            <div class="hidden lg:flex items-center">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                       class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white border border-white/30 text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-sm backdrop-blur-xs">
                        <i class="fa-solid fa-gauge-high text-[13px]" aria-hidden="true"></i>
                        <span>ระบบหลังบ้าน</span>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white border border-white/30 text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-sm backdrop-blur-xs">
                        <i class="fa-solid fa-user-lock text-[13px]" aria-hidden="true"></i>
                        <span>สำหรับเจ้าหน้าที่</span>
                    </a>
                @endauth
            </div>

            {{-- Mobile / Tablet Hamburger Button --}}
            <button type="button"
                    id="mobile-menu-toggle"
                    aria-controls="mobile-menu-drawer"
                    aria-expanded="false"
                    class="lg:hidden inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-white text-xs font-medium transition-colors cursor-pointer">
                <span id="mobile-menu-label">เมนู</span>
                <i id="icon-menu-open" class="fa-solid fa-bars text-[15px]" aria-hidden="true"></i>
                <i id="icon-menu-close" class="fa-solid fa-xmark text-[16px] hidden" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    {{-- Mobile & Tablet Slide-Down Drawer --}}
    <div id="mobile-menu-drawer" class="hidden lg:hidden bg-[#0d4f49] border-t border-white/20 shadow-2xl max-h-[calc(100vh-52px)] overflow-y-auto">
        <div class="phs-container py-3 space-y-1">
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'bg-white/25 text-white' : 'text-[#e8f5f1] hover:bg-white/15' }} flex items-center gap-3 px-3.5 py-3 rounded-xl text-[13px] font-medium transition-colors mobile-nav-link">
                <i class="fa-solid fa-house w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                <span>หน้าหลัก</span>
            </a>

            <a href="{{ route('organization') }}"
               class="{{ request()->routeIs('organization*') ? 'bg-white/25 text-white' : 'text-[#e8f5f1] hover:bg-white/15' }} flex items-center gap-3 px-3.5 py-3 rounded-xl text-[13px] font-medium transition-colors mobile-nav-link">
                <i class="fa-solid fa-sitemap w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                <span>เกี่ยวกับองค์กร</span>
            </a>

            {{-- Accordion เมนูย่อยบน Mobile: ข่าวกิจกรรม --}}
            <div class="rounded-xl overflow-hidden {{ request()->routeIs('activities*') ? 'bg-white/20' : 'bg-white/5' }}">
                <button type="button"
                        id="mobile-activities-toggle"
                        aria-expanded="false"
                        aria-controls="mobile-activities-submenu"
                        class="w-full flex items-center justify-between px-3.5 py-3 text-[13px] font-medium text-[#e8f5f1] hover:bg-white/15 transition-colors cursor-pointer">
                    <span class="flex items-center gap-3">
                        <i class="fa-solid fa-bullhorn w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                        <span>ข่าวกิจกรรม</span>
                    </span>
                    <i id="mobile-activities-chevron" class="fa-solid fa-chevron-down text-[11px] text-[#a6ead3] transition-transform duration-200" aria-hidden="true"></i>
                </button>

                <div id="mobile-activities-submenu" class="hidden pl-7 pr-3 pb-2.5 pt-1 space-y-1 border-t border-white/15 bg-black/15">
                    <a href="{{ route('activities', ['category' => 'general']) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs text-[#d9f0e9] hover:bg-white/15 hover:text-white transition-colors mobile-nav-link">
                        <i class="fa-solid fa-newspaper w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                        <span>ข่าวทั่วไป</span>
                    </a>

                    <a href="{{ route('activities', ['category' => 'recruitment']) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs text-[#d9f0e9] hover:bg-white/15 hover:text-white transition-colors mobile-nav-link">
                        <i class="fa-solid fa-user-tie w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                        <span>ข่าวรับสมัครงาน</span>
                    </a>

                    <a href="{{ route('activities', ['category' => 'procurement']) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs text-[#d9f0e9] hover:bg-white/15 hover:text-white transition-colors mobile-nav-link">
                        <i class="fa-solid fa-file-invoice-dollar w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                        <span>ข่าวจัดซื้อจัดจ้าง</span>
                    </a>

                    <a href="{{ route('activities', ['category' => 'hr']) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs text-[#d9f0e9] hover:bg-white/15 hover:text-white transition-colors mobile-nav-link">
                        <i class="fa-solid fa-id-card-clip w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                        <span>HR (บริหารงานบุคคล)</span>
                    </a>

                    <a href="{{ route('home') }}#onepage"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold text-[#a6ead3] hover:bg-white/15 hover:text-white transition-colors mobile-nav-link">
                        <i class="fa-solid fa-photo-film w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                        <span>อัลบั้มภาพ</span>
                    </a>
                </div>
            </div>

            <a href="https://forums.ssophosai.in.th/"
               target="_blank"
               rel="noopener noreferrer"
               class="text-[#e8f5f1] hover:bg-white/15 flex items-center justify-between px-3.5 py-3 rounded-xl text-[13px] font-medium transition-colors mobile-nav-link">
                <span class="flex items-center gap-3">
                    <i class="fa-solid fa-right-left w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                    <span>รับส่งข้อมูล</span>
                </span>
            </a>

            <a href="{{ route('home') }}#calendar"
               class="text-[#e8f5f1] hover:bg-white/15 flex items-center gap-3 px-3.5 py-3 rounded-xl text-[13px] font-medium transition-colors mobile-nav-link">
                <i class="fa-solid fa-calendar-days w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                <span>ปฏิทินกิจกรรม</span>
            </a>

            <a href="{{ route('documents') }}"
               class="{{ request()->routeIs('documents*') ? 'bg-white/25 text-white' : 'text-[#e8f5f1] hover:bg-white/15' }} flex items-center gap-3 px-3.5 py-3 rounded-xl text-[13px] font-medium transition-colors mobile-nav-link">
                <i class="fa-solid fa-file-lines w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                <span>เอกสารเผยแพร่</span>
            </a>

            <a href="{{ route('internal-links') }}"
               class="{{ request()->routeIs('internal-links*') ? 'bg-white/25 text-white' : 'text-[#e8f5f1] hover:bg-white/15' }} flex items-center gap-3 px-3.5 py-3 rounded-xl text-[13px] font-medium transition-colors mobile-nav-link">
                <i class="fa-solid fa-up-right-from-square w-4 text-center text-[#a6ead3]" aria-hidden="true"></i>
                <span>ลิงก์ภายใน</span>
            </a>

            <div class="pt-2 pb-1">
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                       class="w-full flex items-center justify-center gap-2 bg-white text-[#0d4f49] hover:bg-[#f5faf8] text-xs font-semibold py-3 rounded-xl transition-colors shadow-sm mobile-nav-link">
                        <i class="fa-solid fa-gauge-high" aria-hidden="true"></i>
                        <span>เข้าสู่ระบบหลังบ้าน (Admin Dashboard)</span>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="w-full flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 border border-white/30 text-white text-xs font-semibold py-3 rounded-xl transition-colors mobile-nav-link">
                        <i class="fa-solid fa-user-lock" aria-hidden="true"></i>
                        <span>สำหรับเจ้าหน้าที่</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const menuDrawer = document.getElementById('mobile-menu-drawer');
        const menuLabel = document.getElementById('mobile-menu-label');
        const iconOpen = document.getElementById('icon-menu-open');
        const iconClose = document.getElementById('icon-menu-close');

        const actToggle = document.getElementById('mobile-activities-toggle');
        const actSubmenu = document.getElementById('mobile-activities-submenu');
        const actChevron = document.getElementById('mobile-activities-chevron');

        function setMobileMenu(open) {
            if (!menuDrawer) return;
            menuDrawer.classList.toggle('hidden', !open);
            iconOpen?.classList.toggle('hidden', open);
            iconClose?.classList.toggle('hidden', !open);
            if (menuLabel) menuLabel.textContent = open ? 'ปิด' : 'เมนู';
            menuToggle?.setAttribute('aria-expanded', String(open));
        }

        menuToggle?.addEventListener('click', function () {
            const isHidden = menuDrawer.classList.contains('hidden');
            setMobileMenu(isHidden);
        });

        // พับเปิด-ปิดเมนูย่อย "ข่าวกิจกรรม" บน Mobile
        actToggle?.addEventListener('click', function () {
            const isHidden = actSubmenu.classList.toggle('hidden');
            actChevron?.classList.toggle('rotate-180', !isHidden);
            actToggle.setAttribute('aria-expanded', String(!isHidden));
        });

        // ปิด Drawer อัตโนมัติเมื่อแตะลิงก์เมนูบน Mobile
        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', function () {
                setMobileMenu(false);
            });
        });

        // กดปุ่ม Escape เพื่อปิดเมนู Mobile
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && menuDrawer && !menuDrawer.classList.contains('hidden')) {
                setMobileMenu(false);
            }
        });
    });
</script>
