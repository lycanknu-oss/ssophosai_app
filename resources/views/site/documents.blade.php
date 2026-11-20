@extends('layouts.app')

@section('title', 'เอกสารเผยแพร่ - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('banner')
    <div class="h-[145px] md:h-[172px] relative overflow-hidden bg-[#124e49]">
        <img src="https://images.pexels.com/photos/40139106/pexels-photo-40139106.jpeg"
             alt="เอกสารเผยแพร่และแบบฟอร์มดาวน์โหลด"
             class="w-full h-full object-cover object-[center_45%] opacity-45"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-[#073933]/95 via-[#084e45]/75 to-[#084e45]/40"></div>
        <div class="absolute inset-0 z-10 flex items-center text-white">
            <div class="phs-container">
                <div class="flex items-center gap-1.5 text-[11px] text-[#b9f3dc] mb-1">
                    <a href="{{ route('home') }}" class="hover:underline">หน้าหลัก</a>
                    <span>/</span>
                    <span>เอกสารเผยแพร่</span>
                </div>
                <h2 class="text-[20px] md:text-[27px] leading-[1.3] font-bold m-0">เอกสารเผยแพร่และแบบฟอร์ม</h2>
                <p class="m-0 mt-1 text-[#e7f5ee] text-[11px] md:text-[13px]">คลังเอกสารราชการ แบบฟอร์มดาวน์โหลด คู่มือปฏิบัติงาน และรายงานผลการดำเนินงาน</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @php
        $categories = [
            ['id' => 'all', 'name' => 'เอกสารทั้งหมด', 'icon' => 'layers', 'count' => 6],
            ['id' => 'forms', 'name' => 'แบบฟอร์มราชการ', 'icon' => 'file-spreadsheet', 'count' => 2],
            ['id' => 'manuals', 'name' => 'คู่มือและแนวทางปฏิบัติ', 'icon' => 'book-open', 'count' => 2],
            ['id' => 'reports', 'name' => 'แผนงานและรายงานผล', 'icon' => 'bar-chart-3', 'count' => 1],
            ['id' => 'regulations', 'name' => 'กฎหมายและระเบียบที่เกี่ยวข้อง', 'icon' => 'scale', 'count' => 1],
        ];

        $documents = [
            [
                'category' => 'forms',
                'category_label' => 'แบบฟอร์มราชการ',
                'title' => 'แบบฟอร์มขออนุมัติเดินทางไปราชการและเบิกค่าใช้จ่ายในการเดินทาง (ฉบับปรับปรุง 2569)',
                'code' => 'DOC-001',
                'date' => '15 พ.ย. 2569',
                'file_type' => 'DOCX',
                'file_size' => '245 KB',
                'downloads' => 128,
            ],
            [
                'category' => 'forms',
                'category_label' => 'แบบฟอร์มราชการ',
                'title' => 'แบบฟอร์มใบลาป่วย ลากิจส่วนตัว ลาคลอดบุตร สำหรับข้าราชการและพนักงานกระทรวงสาธารณสุข',
                'code' => 'DOC-002',
                'date' => '10 พ.ย. 2569',
                'file_type' => 'PDF',
                'file_size' => '412 KB',
                'downloads' => 310,
            ],
            [
                'category' => 'manuals',
                'category_label' => 'คู่มือและแนวทางปฏิบัติ',
                'title' => 'คู่มือแนวทางการเฝ้าระวัง ป้องกัน และควบคุมโรคไข้เลือดออกในระดับพื้นที่อำเภอโพธิ์ไทร',
                'code' => 'MAN-001',
                'date' => '05 พ.ย. 2569',
                'file_type' => 'PDF',
                'file_size' => '2.4 MB',
                'downloads' => 185,
            ],
            [
                'category' => 'manuals',
                'category_label' => 'คู่มือและแนวทางปฏิบัติ',
                'title' => 'แนวทางการคัดกรองสุขภาพกลุ่มเสี่ยงโรคไม่ติดต่อเรื้อรัง (เบาหวานและความดันโลหิตสูง) ปีงบประมาณ 2570',
                'code' => 'MAN-002',
                'date' => '28 ต.ค. 2569',
                'file_type' => 'PDF',
                'file_size' => '1.8 MB',
                'downloads' => 240,
            ],
            [
                'category' => 'reports',
                'category_label' => 'แผนงานและรายงานผล',
                'title' => 'แผนปฏิบัติการด้านสาธารณสุขระดับอำเภอ (District Health Plan) ประจำปีงบประมาณ พ.ศ. 2570',
                'code' => 'RPT-001',
                'date' => '15 ต.ค. 2569',
                'file_type' => 'XLSX',
                'file_size' => '890 KB',
                'downloads' => 94,
            ],
            [
                'category' => 'regulations',
                'category_label' => 'กฎหมายและระเบียบที่เกี่ยวข้อง',
                'title' => 'พระราชบัญญัติการสาธารณสุข และประกาศกระทรวงสาธารณสุขที่เกี่ยวข้องกับการดำเนินงานในชุมชน',
                'code' => 'LAW-001',
                'date' => '01 ต.ค. 2569',
                'file_type' => 'PDF',
                'file_size' => '3.1 MB',
                'downloads' => 76,
            ],
        ];
    @endphp

    <section class="mb-[29px]" aria-labelledby="documents-heading">
        {{-- Section Heading --}}
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-4">
            <div>
                <span class="text-[11px] font-bold tracking-[1.6px] text-[#168d83] uppercase">PUBLIC DOCUMENTS</span>
                <h1 id="documents-heading" class="text-[20px] sm:text-[24px] font-bold leading-[1.3] mt-[3px] mb-0 text-[#124e49]">หมวดหมู่เอกสารเผยแพร่</h1>
            </div>
            <p class="m-0 text-[#68817d] text-xs">เลือกหมวดหมู่จากรายการด้านซ้ายเพื่อกรองเอกสารที่ต้องการ</p>
        </div>

        {{-- Layout: Sidebar List Menu + Content ListView --}}
        <div class="grid grid-cols-1 lg:grid-cols-[280px_minmax(0,1fr)] gap-5 items-start">

            {{-- Left Column: List Menu --}}
            <aside class="phs-card rounded-[18px] p-3.5 lg:sticky lg:top-[72px]" aria-label="เมนูหมวดหมู่เอกสาร">
                <div class="px-2.5 py-2 mb-1.5 border-b border-[#dcebe7] flex items-center gap-2">
                    <i data-lucide="folder-tree" class="w-4 h-4 text-[#168d83]"></i>
                    <h2 class="text-[13px] font-bold text-[#124e49] m-0">รายการหมวดหมู่เอกสาร</h2>
                </div>

                <ul class="list-none m-0 p-0 space-y-1" id="doc-category-menu">
                    @foreach($categories as $index => $cat)
                        <li>
                            <button type="button"
                                    data-category="{{ $cat['id'] }}"
                                    class="doc-menu-btn w-full flex items-center justify-between gap-2 px-3 py-2.5 rounded-xl text-left text-[13px] font-medium transition-all cursor-pointer {{ $index === 0 ? 'bg-[#124e49] text-white shadow-sm' : 'text-[#173a39] hover:bg-[#e8f5f1] hover:text-[#124e49]' }}">
                                <span class="flex items-center gap-2.5 min-w-0">
                                    <i data-lucide="{{ $cat['icon'] }}" class="menu-icon w-4 h-4 shrink-0 {{ $index === 0 ? 'text-[#a6ead3]' : 'text-[#168d83]' }}"></i>
                                    <span class="truncate">{{ $cat['name'] }}</span>
                                </span>
                                <span class="menu-badge text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 {{ $index === 0 ? 'bg-[#267a70] text-white' : 'bg-[#f5faf8] text-[#68817d] border border-[#dcebe7]' }}">
                                    {{ $cat['count'] }}
                                </span>
                            </button>
                        </li>
                    @endforeach
                </ul>

                {{-- กล่องช่วยเหลือด้านล่าง List Menu --}}
                <div class="mt-4 pt-3.5 border-t border-[#dcebe7] px-2">
                    <div class="bg-[#f5faf8] border border-[#dcebe7] rounded-xl p-3 text-[11px] text-[#68817d]">
                        <strong class="text-[#124e49] block mb-1">ไม่พบเอกสารที่ต้องการ?</strong>
                        <span>สามารถสอบถามข้อมูลเพิ่มเติมได้ที่กลุ่มงานบริหารทั่วไป โทรศัพท์หน่วยงาน</span>
                    </div>
                </div>
            </aside>

            {{-- Right Column: Search Bar + Document List View --}}
            <div class="space-y-4 min-w-0">
                {{-- Search & Header Card --}}
                <div class="phs-card rounded-[18px] p-4 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-[#e8f5f1] text-[#168d83] grid place-items-center shrink-0">
                            <i data-lucide="file-stack" class="w-4 h-4"></i>
                        </span>
                        <div>
                            <h2 id="current-doc-category-title" class="text-[15px] font-bold text-[#124e49] m-0">เอกสารทั้งหมด</h2>
                            <p id="current-doc-count" class="text-[11px] text-[#68817d] m-0">แสดงทั้งหมด {{ count($documents) }} รายการ</p>
                        </div>
                    </div>

                    <div class="relative w-full sm:w-[270px]">
                        <i data-lucide="search" class="w-4 h-4 text-[#68817d] absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input id="doc-search-input"
                               type="text"
                               placeholder="ค้นหาชื่อเอกสาร หรือรหัส..."
                               class="w-full pl-9 pr-3.5 py-2 text-xs bg-[#f5faf8] border border-[#dcebe7] rounded-xl text-[#173a39] focus:bg-white focus:border-[#168d83] outline-none transition-colors">
                    </div>
                </div>

                {{-- Document List View --}}
                <div class="phs-card rounded-[18px] p-4 sm:p-5">
                    <div id="document-listview" class="divide-y divide-[#edf3f1]">
                        @foreach($documents as $doc)
                            @php
                                $badgeStyle = match($doc['file_type']) {
                                    'PDF' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    'DOCX' => 'bg-sky-50 text-sky-700 border-sky-200',
                                    'XLSX' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    default => 'bg-[#e8f5f1] text-[#168d83] border-[#dcebe7]',
                                };
                            @endphp

                            <article class="doc-item py-4 px-2 first:pt-1 last:pb-1 flex flex-col sm:flex-row sm:items-center gap-3.5 justify-between hover:bg-[#f5faf8]/80 rounded-xl transition-colors"
                                     data-category="{{ $doc['category'] }}">

                                {{-- File Type Icon & Details --}}
                                <div class="flex items-start gap-3.5 min-w-0">
                                    <div class="w-11 h-12 rounded-xl border {{ $badgeStyle }} flex flex-col items-center justify-center shrink-0 font-bold">
                                        <i data-lucide="file-text" class="w-4 h-4 mb-0.5"></i>
                                        <span class="text-[9px] tracking-wider">{{ $doc['file_type'] }}</span>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <span class="phs-pill">{{ $doc['category_label'] }}</span>
                                            <span class="text-[11px] font-medium text-[#68817d]">รหัส: {{ $doc['code'] }}</span>
                                            <span class="text-[11px] text-[#68817d]">• อัปเดต {{ $doc['date'] }}</span>
                                        </div>

                                        <h3 class="doc-title text-[14px] font-semibold text-[#124e49] m-0 mb-1 leading-snug">
                                            <a href="#download" class="hover:text-[#168d83] transition-colors">{{ $doc['title'] }}</a>
                                        </h3>

                                        <div class="flex items-center gap-3 text-[11px] text-[#68817d]">
                                            <span class="inline-flex items-center gap-1">
                                                <i data-lucide="hard-drive" class="w-3 h-3"></i> ขนาด {{ $doc['file_size'] }}
                                            </span>
                                            <span class="inline-flex items-center gap-1">
                                                <i data-lucide="download" class="w-3 h-3"></i> ดาวน์โหลด {{ number_format($doc['downloads']) }} ครั้ง
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Download Button --}}
                                <div class="shrink-0 self-end sm:self-center">
                                    <a href="#download"
                                       class="inline-flex items-center gap-1.5 bg-[#e8f5f1] hover:bg-[#168d83] text-[#124e49] hover:text-white text-xs font-semibold px-3.5 py-2 rounded-xl border border-[#dcebe7] hover:border-[#168d83] transition-all">
                                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                        <span>ดาวน์โหลด</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    {{-- Empty State --}}
                    <div id="doc-empty-state" class="hidden py-12 px-4 text-center text-[#68817d] text-[13px]">
                        <i data-lucide="folder-open" class="w-8 h-8 mx-auto mb-2 text-[#168d83]/60"></i>
                        <p class="m-0">ไม่พบเอกสารที่ตรงกับหมวดหมู่หรือคำค้นหา</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        const $menuButtons = $('.doc-menu-btn');
        const $docItems = $('#document-listview .doc-item');
        const $searchInput = $('#doc-search-input');
        const $emptyState = $('#doc-empty-state');
        const $categoryTitle = $('#current-doc-category-title');
        const $docCount = $('#current-doc-count');

        let activeCategory = 'all';

        const categoryLabels = {
            all: 'เอกสารทั้งหมด',
            forms: 'แบบฟอร์มราชการ',
            manuals: 'คู่มือและแนวทางปฏิบัติ',
            reports: 'แผนงานและรายงานผล',
            regulations: 'กฎหมายและระเบียบที่เกี่ยวข้อง'
        };

        function filterDocuments() {
            const keyword = $searchInput.val().toLowerCase().trim();
            let visibleCount = 0;

            $docItems.each(function () {
                const itemCat = $(this).data('category');
                const itemText = $(this).text().toLowerCase();

                const matchCat = (activeCategory === 'all' || itemCat === activeCategory);
                const matchKeyword = (!keyword || itemText.includes(keyword));

                const show = matchCat && matchKeyword;
                $(this).toggleClass('hidden', !show);
                if (show) visibleCount++;
            });

            $emptyState.toggleClass('hidden', visibleCount > 0);
            $categoryTitle.text(categoryLabels[activeCategory] || 'เอกสารเผยแพร่');
            $docCount.text(`แสดง ${visibleCount} รายการ`);
        }

        // คลิกเลือกหมวดหมู่จาก List Menu ด้านซ้าย
        $menuButtons.on('click', function () {
            activeCategory = $(this).data('category');

            $menuButtons.each(function () {
                const isSelected = $(this).data('category') === activeCategory;

                $(this)
                    .toggleClass('bg-[#124e49] text-white shadow-sm', isSelected)
                    .toggleClass('text-[#173a39] hover:bg-[#e8f5f1] hover:text-[#124e49]', !isSelected);

                $(this).find('.menu-icon')
                    .toggleClass('text-[#a6ead3]', isSelected)
                    .toggleClass('text-[#168d83]', !isSelected);

                $(this).find('.menu-badge')
                    .toggleClass('bg-[#267a70] text-white', isSelected)
                    .toggleClass('bg-[#f5faf8] text-[#68817d] border border-[#dcebe7]', !isSelected);
            });

            filterDocuments();
        });

        // ค้นหาแบบ Real-time
        $searchInput.on('input', filterDocuments);
    });
</script>
@endpush
