<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')</title>

    {{-- Google Fonts: Prompt & IBM Plex Sans Thai --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@400;500;600;700&family=Prompt:wght@500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome 6 Free --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- SaaS Theme CSS --}}
    <!--<link rel="stylesheet" href="{{ asset('dist/css/theme-saas.css') }}">-->

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/css/theme-saas.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-vector-pattern min-h-screen flex flex-col relative overflow-x-hidden antialiased pb-16 md:pb-0">

    {{-- Decorative Ambient Glow Elements --}}
    <div class="pointer-events-none fixed -top-32 -left-32 w-72 sm:w-96 h-72 sm:h-96 rounded-full bg-[#3126C9]/10 blur-3xl z-0"></div>
    <div class="pointer-events-none fixed top-1/3 -right-32 w-72 sm:w-96 h-72 sm:h-96 rounded-full bg-[#1675E8]/10 blur-3xl z-0"></div>

    {{-- 1. Sticky Top Header (All-Device Responsive) --}}
    <header class="sticky top-0 z-40 bg-gradient-to-r from-[#3126C9] via-[#1675E8] to-[#3126C9] text-white saas-shadow-lg">
        <div class="max-w-7xl w-full mx-auto px-3.5 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between gap-2.5 sm:gap-4">

            {{-- Left: Mobile/Tablet Hamburger + Agency Brand --}}
            <div class="flex items-center gap-2.5 sm:gap-3 min-w-0">
                <button type="button"
                        id="admin-sidebar-toggle"
                        aria-controls="admin-sidebar"
                        aria-expanded="false"
                        aria-label="เปิดเมนูผู้ดูแลระบบ"
                        class="lg:hidden w-9 h-9 rounded-xl bg-white/15 hover:bg-white/25 active:scale-95 grid place-items-center text-white transition-all cursor-pointer shrink-0">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 sm:gap-3 min-w-0 group">
                    <span class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white p-1 border border-white/30 grid place-items-center shrink-0 shadow-sm transition-transform group-hover:scale-105 overflow-hidden">
                        <img src="{{ asset('dist/img/logo_moph.png') }}" alt="โลโก้ สสอ.โพธิ์ไทร" class="w-full h-full object-contain">
                    </span>
                    <div class="min-w-0">
                        <span class="font-heading font-bold text-[13px] sm:text-base tracking-wide block truncate">
                            สำนักงานสาธารณสุขอำเภอโพธิ์ไทร
                        </span>
                        <span class="text-[10px] sm:text-[11px] text-white/80 block truncate">
                            Admin Portal • ระบบจัดการเว็บไซต์
                        </span>
                    </div>
                </a>
            </div>

            {{-- Right: Date Badge + User Profile + Logout --}}
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                {{-- Date Badge (แสดงบนจอ md ขึ้นไป) --}}
                <div class="hidden md:flex items-center gap-2 bg-white/15 border border-white/20 rounded-full px-3.5 py-1.5 text-xs font-medium">
                    <i class="fa-regular fa-calendar text-white/90"></i>
                    <span>{{ now()->locale('th')->translatedFormat('d M') }} {{ now()->year + 543 }}</span>
                </div>

                @auth
                    {{-- User Profile Pill --}}
                    <div class="flex items-center gap-2 bg-white/15 border border-white/20 rounded-full p-1 sm:pr-3.5 text-xs" title="{{ Auth::user()->name }}">
                        <span class="w-7 h-7 sm:w-6 sm:h-6 rounded-full bg-white text-[#3126C9] font-heading font-bold grid place-items-center text-[11px] shrink-0">
                            {{ mb_substr(Auth::user()->name, 0, 1) }}
                        </span>
                        <span class="hidden sm:inline font-medium max-w-[130px] truncate">{{ Auth::user()->name }}</span>
                    </div>

                    {{-- Logout Button --}}
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-1.5 bg-white/15 hover:bg-rose-500 active:scale-95 text-white border border-white/25 hover:border-rose-400 text-xs font-heading font-semibold w-9 h-9 sm:w-auto sm:h-auto sm:px-3.5 sm:py-2 rounded-xl transition-all cursor-pointer"
                                title="ออกจากระบบ">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="hidden sm:inline">ออกจากระบบ</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    {{-- 2. Main Layout Wrapper (Responsive Sidebar + Content Container) --}}
    <div class="flex-1 max-w-7xl w-full mx-auto px-3.5 sm:px-6 lg:px-8 py-4 sm:py-6 md:py-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-[265px_minmax(0,1fr)] gap-5 lg:gap-6 items-start">

            {{-- Mobile/Tablet Backdrop Overlay --}}
            <div id="admin-sidebar-backdrop"
                 class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 lg:hidden transition-opacity"></div>

            {{-- Left Sidebar Navigation (Slide-over Drawer on Mobile/Tablet, Sticky Card on Desktop) --}}
            <aside id="admin-sidebar"
                   aria-label="เมนูนำทางระบบหลังบ้าน"
                   class="fixed lg:sticky top-0 lg:top-24 left-0 z-50 lg:z-10 w-[280px] max-w-[82vw] lg:w-auto h-dvh lg:h-auto -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-out bg-white lg:rounded-[18px] border-r lg:border border-[#E8ECF4] shadow-2xl lg:shadow-[0_4px_20px_-2px_rgba(30,41,59,0.05)] p-4 flex flex-col justify-between overflow-y-auto">

                <div class="space-y-5">
                    {{-- Mobile Drawer Header --}}
                    <div class="flex lg:hidden items-center justify-between pb-3.5 border-b border-[#E8ECF4]">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <img src="{{ asset('dist/img/logo_moph.png') }}" alt="โลโก้" class="w-8 h-8 object-contain shrink-0">
                            <div class="min-w-0">
                                <strong class="font-heading text-xs text-[#1E293B] block truncate">เมนูผู้ดูแลระบบ</strong>
                                <span class="text-[10px] text-[#64748B] block truncate">{{ Auth::user()->name ?? 'เจ้าหน้าที่' }}</span>
                            </div>
                        </div>
                        <button type="button"
                                id="admin-sidebar-close"
                                aria-label="ปิดเมนู"
                                class="w-8 h-8 rounded-xl bg-[#F8FAFC] hover:bg-rose-50 text-[#64748B] hover:text-rose-600 grid place-items-center transition-colors cursor-pointer shrink-0">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    {{-- หมวดที่ 1: ภาพรวมระบบ --}}
                    <div>
                        <p class="px-3 mb-2 text-[11px] font-heading font-semibold uppercase tracking-wider text-[#64748B]">
                            ภาพรวมระบบ
                        </p>
                        <nav class="space-y-1">
                            <a href="{{ route('admin.dashboard') }}"
                               class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                <i class="fa-solid fa-gauge-high w-4 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-[#3126C9]' }}"></i>
                                <span>แผงควบคุม (Dashboard)</span>
                            </a>
                        </nav>
                    </div>

                    {{-- หมวดที่ 2: จัดการเนื้อหาเว็บไซต์ --}}
                    <div>
                        <p class="px-3 mb-2 text-[11px] font-heading font-semibold uppercase tracking-wider text-[#64748B]">
                            จัดการเนื้อหาเว็บไซต์
                        </p>
                        <nav class="space-y-1">
                            <a href="{{ route('admin.publicity.index') }}"
                               class="admin-nav-link {{ request()->routeIs('admin.publicity.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                <i class="fa-solid fa-images w-4 text-center {{ request()->routeIs('admin.publicity.*') ? 'text-white' : 'text-[#3126C9]' }}"></i>
                                <span>จัดการส่วนประชาสัมพันธ์</span>
                            </a>

                            <a href="{{ route('admin.shortcuts.index') }}"
                            class="admin-nav-link {{ request()->routeIs('admin.shortcuts.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                <i class="fa-solid fa-bolt w-4 text-center {{ request()->routeIs('admin.shortcuts.*') ? 'text-white' : 'text-[#1675E8]' }}"></i>
                                <span>จัดการทางลัดข้อมูลที่น่าสนใจ</span>
                            </a>

                            <a href="{{ route('admin.activities.index') }}"
                            class="admin-nav-link {{ request()->routeIs('admin.activities.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                <i class="fa-solid fa-bullhorn w-4 text-center {{ request()->routeIs('admin.activities.*') ? 'text-white' : 'text-[#1675E8]' }}"></i>
                                <span>จัดการข่าวประชาสัมพันธ์</span>
                            </a>
                            <a href="{{ route('admin.albums.index') }}"
                            class="admin-nav-link {{ request()->routeIs('admin.albums.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                <i class="fa-solid fa-photo-film w-4 text-center {{ request()->routeIs('admin.albums.*') ? 'text-white' : 'text-[#675CF0]' }}"></i>
                                <span>จัดการอัลบั้มกิจกรรม</span>
                            </a>
                            <a href="{{ route('admin.services.index') }}"
                            class="admin-nav-link {{ request()->routeIs('admin.services.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                <i class="fa-solid fa-hand-holding-medical {{ request()->routeIs('admin.services.*') ? 'text-white' : 'text-[#675CF0]' }}"></i>
                                <span>จัดการบริการของเรา</span>
                            </a>
                            <a href="{{ route('documents') }}"
                               class="admin-nav-link text-[#1E293B] hover:bg-[#F8FAFC] flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-colors">
                                <i class="fa-solid fa-file-lines w-4 text-center text-[#13A678]"></i>
                                <span>เอกสารเผยแพร่ / แบบฟอร์ม</span>
                            </a>

                            <a href="{{ route('admin.units.index') }}"
                            class="admin-nav-link {{ request()->routeIs('admin.units.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                <i class="fa-solid fa-hospital-user w-4 text-center text-[#13A678]"></i>
                                <span>หน่วยงานภายใต้สังกัด</span>
                            </a>
                            <a href="{{ route('admin.organization.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-semibold transition-all {{ request()->routeIs('admin.organization.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#64748B] hover:bg-[#F8FAFC] hover:text-[#1E293B]' }}">
                                <i class="fa-solid fa-sitemap w-4 text-center"></i>
                                <span>จัดการข้อมูลองค์กร</span>
                            </a>
                        </nav>
                    </div>
                    <div>
                        <p class="px-3 mb-2 text-[11px] font-heading font-semibold uppercase tracking-wider text-[#64748B]">
                            จัดการข้อมูลพื้นฐานเว็บไซต์
                        </p>
                        <nav class="space-y-1">
                            <a href="{{ route('admin.site-info.index') }}"
                            class="admin-nav-link {{ request()->routeIs('admin.site-info.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                <i class="fa-solid fa-building-columns w-4 text-center text-[#F49A22]"></i>
                                <span>จัดการข้อมูลเว็บไซต์</span>
                            </a>
                                <a href="{{ route('admin.users.index') }}"
                                    class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white saas-shadow-glow' : 'text-[#1E293B] hover:bg-[#F8FAFC]' }} flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-heading font-medium transition-all">
                                    <i class="fa-solid fa-user-shield w-4 text-center"></i>
                                    <span>จัดการผู้ใช้งานระบบ</span>
                                </a>
                        </nav>
                    </div>
                </div>

                {{-- Footer ของ Sidebar: ลิงก์เปิดหน้าเว็บหลัก --}}
                <div class="pt-4 mt-5 border-t border-[#E8ECF4]">
                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="admin-nav-link w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-[#F8FAFC] hover:bg-[#EEF2FF] text-[#3126C9] border border-[#E8ECF4] text-xs font-heading font-semibold transition-colors">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-globe"></i>
                            <span>เปิดหน้าเว็บไซต์หลัก</span>
                        </span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </aside>

            {{-- Main Content Area --}}
            <main class="min-w-0 space-y-4 sm:space-y-6">
                @hasSection('page-header')
                    @yield('page-header')
                @endif

                {{-- Flash Success Message --}}
                @if(session('success'))
                    <div class="saas-card p-3.5 sm:p-4 !border-emerald-200 !bg-emerald-50/95 text-emerald-800 text-xs flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-7 h-7 rounded-lg bg-emerald-600 text-white grid place-items-center shrink-0">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="font-medium break-words">{{ session('success') }}</span>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 p-1 cursor-pointer shrink-0" aria-label="ปิดการแจ้งเตือน">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- 3. Desktop & Tablet Footer --}}
    <footer class="bg-white/80 backdrop-blur-md border-t border-[#E8ECF4] relative z-10 mt-auto">
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-1.5 text-center sm:text-left text-xs text-[#64748B]">
            <p class="m-0">
                &copy; {{ date('Y') + 543 }} <strong class="text-[#1E293B] font-heading">สำนักงานสาธารณสุขอำเภอโพธิ์ไทร</strong> จังหวัดอุบลราชธานี
            </p>
            <p class="m-0 text-[11px]">
                ระบบบริหารจัดการข้อมูลสารสนเทศสาธารณสุขระดับอำเภอ
            </p>
        </div>
    </footer>

    {{-- 4. Mobile Bottom Quick Navigation Bar (แสดงเฉพาะบนมือถือต่ำกว่า md) --}}
    <nav class="md:hidden fixed bottom-0 inset-x-0 z-30 bg-white/95 backdrop-blur-md border-t border-[#E8ECF4] shadow-[0_-4px_16px_rgba(30,41,59,0.06)] px-2 py-1.5" aria-label="เมนูลัดด้านล่าง">
        <div class="grid grid-cols-4 gap-1 text-center">
            <a href="{{ route('admin.dashboard') }}"
               class="flex flex-col items-center justify-center py-1 rounded-xl text-[10px] font-heading font-semibold transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-[#3126C9] bg-[#EEF2FF]' : 'text-[#64748B] hover:text-[#1E293B]' }}">
                <i class="fa-solid fa-gauge-high text-sm mb-0.5"></i>
                <span>แดชบอร์ด</span>
            </a>

            <a href="{{ route('admin.publicity.index') }}"
               class="flex flex-col items-center justify-center py-1 rounded-xl text-[10px] font-heading font-semibold transition-colors {{ request()->routeIs('admin.publicity.*') ? 'text-[#3126C9] bg-[#EEF2FF]' : 'text-[#64748B] hover:text-[#1E293B]' }}">
                <i class="fa-solid fa-images text-sm mb-0.5"></i>
                <span>ประชาสัมพันธ์</span>
            </a>

            <a href="{{ route('home') }}"
               target="_blank"
               class="flex flex-col items-center justify-center py-1 rounded-xl text-[10px] font-heading font-semibold text-[#64748B] hover:text-[#1E293B] transition-colors">
                <i class="fa-solid fa-globe text-sm mb-0.5"></i>
                <span>หน้าเว็บหลัก</span>
            </a>

            <button type="button"
                    id="mobile-bottom-menu-btn"
                    class="flex flex-col items-center justify-center py-1 rounded-xl text-[10px] font-heading font-semibold text-[#64748B] hover:text-[#3126C9] transition-colors cursor-pointer">
                <i class="fa-solid fa-bars text-sm mb-0.5"></i>
                <span>เมนูทั้งหมด</span>
            </button>
        </div>
    </nav>

    {{-- All-Device Sidebar & Drawer Script --}}
    <script type="module">
        $(function () {
            const $sidebar = $('#admin-sidebar');
            const $backdrop = $('#admin-sidebar-backdrop');
            const $toggleBtn = $('#admin-sidebar-toggle');
            const $body = $('body');

            function openSidebar() {
                $sidebar.removeClass('-translate-x-full');
                $backdrop.removeClass('hidden');
                $toggleBtn.attr('aria-expanded', 'true');
                $body.addClass('overflow-hidden lg:overflow-auto');
            }

            function closeSidebar() {
                $sidebar.addClass('-translate-x-full');
                $backdrop.addClass('hidden');
                $toggleBtn.attr('aria-expanded', 'false');
                $body.removeClass('overflow-hidden lg:overflow-auto');
            }

            $toggleBtn.on('click', function () {
                const isOpen = !$sidebar.hasClass('-translate-x-full');
                isOpen ? closeSidebar() : openSidebar();
            });

            $('#mobile-bottom-menu-btn').on('click', openSidebar);
            $('#admin-sidebar-close, #admin-sidebar-backdrop').on('click', closeSidebar);

            // ปิด Drawer อัตโนมัติเมื่อแตะเมนูบนหน้าจอเล็ก
            $('.admin-nav-link').on('click', function () {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });

            // ปิด Drawer เมื่อกดปุ่ม Escape
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape' && !$sidebar.hasClass('-translate-x-full') && window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
