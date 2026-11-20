@extends('layouts.app')

@section('title', 'ลิงก์ภายในและระบบสารสนเทศ - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('banner')
    <div class="h-[145px] md:h-[172px] relative overflow-hidden bg-[#124e49]">
        <img src="https://images.pexels.com/photos/40139106/pexels-photo-40139106.jpeg"
             alt="ลิงก์ภายในและระบบสารสนเทศ"
             class="w-full h-full object-cover object-[center_45%] opacity-45"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-[#073933]/95 via-[#084e45]/75 to-[#084e45]/40"></div>
        <div class="absolute inset-0 z-10 flex items-center text-white">
            <div class="phs-container">
                <div class="flex items-center gap-1.5 text-[11px] text-[#b9f3dc] mb-1">
                    <a href="{{ route('home') }}" class="hover:underline">หน้าหลัก</a>
                    <span>/</span>
                    <span>ลิงก์ภายใน</span>
                </div>
                <h2 class="text-[20px] md:text-[27px] leading-[1.3] font-bold m-0">ลิงก์ภายในและระบบสารสนเทศ</h2>
                <p class="m-0 mt-1 text-[#e7f5ee] text-[11px] md:text-[13px]">ศูนย์รวมลิงก์ระบบงานภายใน ฐานข้อมูลสุขภาพ และช่องทางเชื่อมโยงสำหรับเจ้าหน้าที่</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @php
        // กำหนดรายการลิงก์ภายใน (สามารถแก้ไข URL หรือเพิ่มรายการได้ทันที)
        $linkGroups = [
            [
                'group_id' => 'office-systems',
                'group_title' => 'ระบบงานสารสนเทศภายในสำนักงาน',
                'group_desc' => 'ระบบบริหารจัดการงานเอกสาร การสื่อสาร และงานบริการภายใน สสอ.โพธิ์ไทร',
                'icon' => 'server',
                'links' => [
                    [
                        'title' => 'ระบบรับ-ส่งข้อมูลและกระดานข่าวสาร (Forums สสอ.โพธิ์ไทร)',
                        'desc' => 'ช่องทางแลกเปลี่ยนข้อมูล หนังสือเวียน และประสานงานระหว่าง สสอ. กับ รพ.สต. ในสังกัด',
                        'url' => 'https://forums.ssophosai.in.th/',
                        'icon' => 'messages-square',
                        'tag' => 'ระบบหลัก',
                        'external' => true,
                    ],
                    [
                        'title' => 'ระบบสารบรรณอิเล็กทรอนิกส์ (E-Document)',
                        'desc' => 'ระบบลงรับ-ส่งหนังสือราชการ ติดตามสถานะเอกสาร และจัดเก็บแฟ้มดิจิทัล',
                        'url' => '#',
                        'icon' => 'folder-check',
                        'tag' => 'งานบริหาร',
                        'external' => true,
                    ],
                    [
                        'title' => 'ระบบจองห้องประชุมและบันทึกการประชุมออนไลน์',
                        'desc' => 'ตรวจสอบตารางการใช้ห้องประชุม จองคิว และดาวน์โหลดรายงานการประชุม',
                        'url' => '#',
                        'icon' => 'calendar-check',
                        'tag' => 'งานอำนวยการ',
                        'external' => true,
                    ],
                    [
                        'title' => 'ระบบฐานข้อมูลบุคลากรและการลาออนไลน์',
                        'desc' => 'ตรวจสอบข้อมูลบุคลากร ประวัติการฝึกอบรม และยื่นใบลาอิเล็กทรอนิกส์',
                        'url' => '#',
                        'icon' => 'user-cog',
                        'tag' => 'ทรัพยากรบุคคล',
                        'external' => true,
                    ],
                ],
            ],
            [
                'group_id' => 'health-systems',
                'group_title' => 'ระบบฐานข้อมูลสุขภาพและตัวชี้วัด (MOPH / HDC)',
                'group_desc' => 'ระบบรายงานข้อมูลสุขภาพระดับอำเภอ จังหวัด และกระทรวงสาธารณสุข',
                'icon' => 'activity',
                'links' => [
                    [
                        'title' => 'ระบบคลังข้อมูลด้านการแพทย์และสุขภาพ (HDC จังหวัดอุบลราชธานี)',
                        'desc' => 'ติดตามตัวชี้วัด 43 แฟ้ม ข้อมูลประชากร และรายงานสถานะสุขภาพระดับพื้นที่',
                        'url' => 'https://ubn.hdc.moph.go.th/',
                        'icon' => 'database',
                        'tag' => 'ฐานข้อมูลสุขภาพ',
                        'external' => true,
                    ],
                    [
                        'title' => 'ทำเนียบ รพ.สต. และหน่วยบริการปฐมภูมิในสังกัด',
                        'desc' => 'ข้อมูลพื้นฐาน พิกัด และช่องทางติดต่อโรงพยาบาลส่งเสริมสุขภาพตำบลในอำเภอโพธิ์ไทร',
                        'url' => route('home') . '#contact',
                        'icon' => 'hospital',
                        'tag' => 'เครือข่ายบริการ',
                        'external' => false,
                    ],
                    [
                        'title' => 'ศูนย์รวมแบบฟอร์มและคู่มือปฏิบัติงาน (Documents)',
                        'desc' => 'ดาวน์โหลดแบบฟอร์มราชการ คู่มือแนวทางปฏิบัติ และแผนงานประจำปี',
                        'url' => route('documents'),
                        'icon' => 'file-down',
                        'tag' => 'เอกสารภายใน',
                        'external' => false,
                    ],
                ],
            ],
        ];
    @endphp

    <section class="mb-[29px]" aria-labelledby="internal-links-heading">
        {{-- Section Heading + Search Box --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-5">
            <div>
                <span class="text-[11px] font-bold tracking-[1.6px] text-[#168d83] uppercase">INTERNAL PORTAL &amp; LINKS</span>
                <h1 id="internal-links-heading" class="text-[20px] sm:text-[24px] font-bold leading-[1.3] mt-[3px] mb-0 text-[#124e49]">รายการลิงก์ภายในหน่วยงาน</h1>
            </div>

            <div class="relative w-full md:w-[300px]">
                <i data-lucide="search" class="w-4 h-4 text-[#68817d] absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                <input id="search-internal-links"
                       type="text"
                       placeholder="ค้นหาชื่อระบบงาน หรือลิงก์ภายใน..."
                       class="w-full pl-9 pr-4 py-2 text-xs bg-white border border-[#dcebe7] rounded-xl text-[#173a39] shadow-sm focus:border-[#168d83] outline-none transition-colors">
            </div>
        </div>

        {{-- รายการลิงก์แยกตามหมวดหมู่ (List Layout) --}}
        <div id="internal-links-container" class="space-y-6">
            @foreach($linkGroups as $group)
                <div class="link-group-card phs-card rounded-[18px] p-4 sm:p-6">
                    {{-- Group Header --}}
                    <div class="flex items-start sm:items-center gap-3 pb-3.5 mb-3 border-b border-[#dcebe7]">
                        <span class="w-10 h-10 rounded-xl bg-[#124e49] text-[#a6ead3] grid place-items-center shrink-0">
                            <i data-lucide="{{ $group['icon'] }}" class="w-5 h-5"></i>
                        </span>
                        <div>
                            <h2 class="text-[16px] sm:text-[17px] font-bold text-[#124e49] m-0">{{ $group['group_title'] }}</h2>
                            <p class="text-xs text-[#68817d] m-0 mt-0.5">{{ $group['group_desc'] }}</p>
                        </div>
                    </div>

                    {{-- List Items --}}
                    <ul class="list-none m-0 p-0 divide-y divide-[#edf3f1]">
                        @foreach($group['links'] as $link)
                            <li class="link-list-item py-3 first:pt-1 last:pb-1">
                                <a href="{{ $link['url'] }}"
                                   @if($link['external']) target="_blank" rel="noopener noreferrer" @endif
                                   class="group flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-3 rounded-xl hover:bg-[#f5faf8] border border-transparent hover:border-[#dcebe7] transition-all">

                                    <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                                        <span class="w-10 h-10 rounded-xl bg-[#e8f5f1] group-hover:bg-[#168d83] text-[#168d83] group-hover:text-white grid place-items-center shrink-0 transition-colors">
                                            <i data-lucide="{{ $link['icon'] }}" class="w-5 h-5"></i>
                                        </span>

                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center gap-2 mb-0.5">
                                                <h3 class="link-title text-[14px] font-semibold text-[#124e49] group-hover:text-[#168d83] m-0 transition-colors">
                                                    {{ $link['title'] }}
                                                </h3>
                                                <span class="phs-pill">{{ $link['tag'] }}</span>
                                            </div>
                                            <p class="link-desc m-0 text-xs text-[#68817d] leading-relaxed">{{ $link['desc'] }}</p>
                                        </div>
                                    </div>

                                    <div class="shrink-0 self-end sm:self-center">
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#168d83] group-hover:text-white bg-[#e8f5f1] group-hover:bg-[#124e49] px-3.5 py-2 rounded-xl transition-colors">
                                            <span>เข้าสู่ระบบ</span>
                                            <i data-lucide="{{ $link['external'] ? 'external-link' : 'arrow-right' }}" class="w-3.5 h-3.5"></i>
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        {{-- Empty Search State --}}
        <div id="links-empty-state" class="hidden phs-card rounded-[18px] py-12 px-4 text-center text-[#68817d] text-[13px]">
            <i data-lucide="search-x" class="w-8 h-8 mx-auto mb-2 text-[#168d83]/60"></i>
            <p class="m-0">ไม่พบรายการลิงก์ภายในที่ตรงกับคำค้นหา</p>
        </div>
    </section>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        const $searchInput = $('#search-internal-links');
        const $groupCards = $('.link-group-card');
        const $emptyState = $('#links-empty-state');

        $searchInput.on('input', function () {
            const keyword = $(this).val().toLowerCase().trim();
            let totalVisible = 0;

            $groupCards.each(function () {
                const $card = $(this);
                let groupVisibleCount = 0;

                $card.find('.link-list-item').each(function () {
                    const text = $(this).text().toLowerCase();
                    const isMatch = !keyword || text.includes(keyword);
                    $(this).toggleClass('hidden', !isMatch);
                    if (isMatch) {
                        groupVisibleCount++;
                        totalVisible++;
                    }
                });

                // ซ่อนทั้งกล่องหมวดหมู่หากไม่มีรายการย่อยที่ตรงกับการค้นหา
                $card.toggleClass('hidden', groupVisibleCount === 0);
            });

            $emptyState.toggleClass('hidden', totalVisible > 0);
        });
    });
</script>
@endpush
