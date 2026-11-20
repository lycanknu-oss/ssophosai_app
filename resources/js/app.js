import $ from 'jquery';

window.$ = window.jQuery = $;

$(function () {
    // 1. Initialize Lucide Icons (สำหรับไอคอนส่วนเนื้อหาอื่นๆ ที่ยังใช้ Lucide)
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // 2. Mobile / Tablet Hamburger Drawer
    const $mobileToggle = $('#mobile-menu-toggle');
    const $mobileDrawer = $('#mobile-menu-drawer');
    const $iconOpen = $('#icon-menu-open');
    const $iconClose = $('#icon-menu-close');
    const $menuLabel = $('#mobile-menu-label');

    function closeMobileMenu() {
        $mobileDrawer.slideUp(200, function () {
            $(this).addClass('hidden').css('display', '');
        });
        $mobileToggle.attr('aria-expanded', 'false');
        $iconOpen.removeClass('hidden');
        $iconClose.addClass('hidden');
        $menuLabel.text('เมนู');
    }

    function openMobileMenu() {
        $mobileDrawer.removeClass('hidden').hide().slideDown(220);
        $mobileToggle.attr('aria-expanded', 'true');
        $iconOpen.addClass('hidden');
        $iconClose.removeClass('hidden');
        $menuLabel.text('ปิด');
    }

    $mobileToggle.on('click', function (e) {
        e.stopPropagation();
        const isExpanded = $mobileToggle.attr('aria-expanded') === 'true';
        if (isExpanded) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    });

    // ปิด Mobile Drawer อัตโนมัติเมื่อคลิกลิงก์นำทาง
    $('.mobile-nav-link').on('click', function () {
        if ($mobileToggle.attr('aria-expanded') === 'true') {
            closeMobileMenu();
        }
    });

    // ปิดเมนู Mobile เมื่อคลิกพื้นที่อื่นนอก Navbar หรือกดปุ่ม Escape
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#main-navbar').length && $mobileToggle.attr('aria-expanded') === 'true') {
            closeMobileMenu();
        }
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $mobileToggle.attr('aria-expanded') === 'true') {
            closeMobileMenu();
        }
    });
});
