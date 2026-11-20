@extends('layouts.app')

@section('title', 'ข่าวประชาสัมพันธ์และกิจกรรม - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('content')
<div class="max-w-7xl w-full mx-auto p-4 sm:p-6 md:p-8 space-y-6">

    {{-- Page Header Banner --}}
    <div class="saas-card p-6 sm:p-8 bg-gradient-to-r from-[#124e49] via-[#168d83] to-[#124e49] text-white border-0 shadow-lg relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 text-[11px] font-heading font-semibold bg-white/15 text-[#bdf4dd] px-3 py-1 rounded-full mb-2.5">
                    <i class="fa-solid fa-bullhorn"></i> NEWS &amp; PUBLIC RELATIONS
                </span>
                <h1 class="text-[24px] sm:text-[30px] font-heading font-bold m-0 leading-tight">
                    ข่าวประชาสัมพันธ์และกิจกรรม
                </h1>
                <p class="text-xs sm:text-sm text-[#e8f5ef] m-0 mt-1.5 max-w-2xl">
                    ติดตามข่าวสารการดำเนินงาน ประกาศรับสมัครงาน ประกาศจัดซื้อจัดจ้าง และภาพกิจกรรมของสำนักงานสาธารณสุขอำเภอโพธิ์ไทร
                </p>
            </div>

            <a href="{{ route('activities.all') }}"
               class="inline-flex items-center gap-2 bg-white text-[#124e49] hover:bg-[#e8f5f1] text-xs font-heading font-bold px-5 py-3 rounded-xl transition-colors self-start md:self-center shrink-0 shadow-sm">
                <i class="fa-solid fa-list-ul"></i>
                <span>ดูคลังข่าวทั้งหมด ({{ $activities->count() }})</span>
            </a>
        </div>
    </div>

    {{-- แถบเครื่องมือกรองหมวดหมู่ + ค้นหาด่วน --}}
    <div class="saas-card bg-white p-4 sm:p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2" role="tablist" aria-label="หมวดหมู่ข่าวประชาสัมพันธ์">
            <button type="button"
                    data-filter="all"
                    class="act-filter-btn active px-4 py-2 rounded-full text-xs font-heading font-semibold bg-[#124e49] text-white transition-all cursor-pointer">
                ทั้งหมด ({{ $activities->count() }})
            </button>
            <button type="button"
                    data-filter="general"
                    class="act-filter-btn px-4 py-2 rounded-full text-xs font-heading font-semibold bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] border border-[#dcebe7] transition-all cursor-pointer">
                ข่าวทั่วไป ({{ $activities->where('category', 'general')->count() }})
            </button>
            <button type="button"
                    data-filter="recruitment"
                    class="act-filter-btn px-4 py-2 rounded-full text-xs font-heading font-semibold bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] border border-[#dcebe7] transition-all cursor-pointer">
                ข่าวรับสมัครงาน ({{ $activities->where('category', 'recruitment')->count() }})
            </button>
            <button type="button"
                    data-filter="procurement"
                    class="act-filter-btn px-4 py-2 rounded-full text-xs font-heading font-semibold bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] border border-[#dcebe7] transition-all cursor-pointer">
                ข่าวจัดซื้อจัดจ้าง ({{ $activities->where('category', 'procurement')->count() }})
            </button>
        </div>

        <div class="relative w-full lg:w-72">
            <i class="fa-solid fa-magnifying-glass text-xs text-[#68817d] absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input type="text"
                   id="act-search-input"
                   class="saas-input !pl-9 text-xs"
                   placeholder="ค้นหาหัวข้อข่าวหรือคำสำคัญ...">
        </div>
    </div>

    {{-- รายการข่าวประชาสัมพันธ์ --}}
    @if($activities->count() > 0)
        <div id="activities-news-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($activities as $news)
                @php
                    $catBadgeClass = match($news->category) {
                        'recruitment' => 'bg-emerald-50 text-[#13A678] border-emerald-200/80',
                        'procurement' => 'bg-amber-50 text-[#d97706] border-amber-200/80',
                        default       => 'bg-[#e8f5f1] text-[#168d83] border-[#dcebe7]',
                    };
                    $thaiDate = $news->published_date
                        ? $news->published_date->locale('th')->translatedFormat('d M') . ' ' . ($news->published_date->year + 543)
                        : '-';
                @endphp

                <article id="news-{{ $news->id }}"
                         data-category="{{ $news->category }}"
                         data-search="{{ mb_strtolower($news->title . ' ' . $news->summary) }}"
                         class="act-news-card saas-card bg-white overflow-hidden flex flex-col justify-between hover:-translate-y-1 transition-all duration-300 group scroll-mt-24">
                    <div>
                        {{-- รูปภาพหน้าปก --}}
                        @if($news->cover_image)
                            <div class="relative h-48 overflow-hidden bg-[#124e49]/10 border-b border-[#E8ECF4]">
                                <img src="{{ asset($news->cover_image) }}"
                                     alt="{{ $news->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     loading="lazy">
                                @if($news->is_pinned)
                                    <span class="absolute top-3 right-3 inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-500 text-white text-[10px] font-heading font-bold shadow-sm">
                                        <i class="fa-solid fa-thumbtack"></i> ปักหมุด
                                    </span>
                                @endif
                            </div>
                        @endif

                        <div class="p-5">
                            {{-- หมวดหมู่ + วันที่ --}}
                            <div class="flex items-center justify-between gap-2 mb-2.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full border text-[11px] font-heading font-semibold {{ $catBadgeClass }}">
                                    {{ $news->category_label }}
                                </span>

                                <time class="text-[11px] text-[#64748B] flex items-center gap-1 shrink-0">
                                    <i class="fa-regular fa-calendar"></i>
                                    <span>{{ $thaiDate }}</span>
                                </time>
                            </div>

                            @if(!$news->cover_image && $news->is_pinned)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-heading font-bold mb-1.5">
                                    <i class="fa-solid fa-thumbtack"></i> ข่าวเด่นปักหมุด
                                </span>
                            @endif

                            {{-- หัวข้อข่าว --}}
                            <h2 class="text-[15px] sm:text-[16px] font-heading font-bold leading-[1.45] text-[#124e49] group-hover:text-[#168d83] transition-colors m-0">
                                <button type="button"
                                        onclick='openNewsDetailModal(@json($news), "{{ $thaiDate }}", "{{ $news->category_label }}")'
                                        class="text-left hover:underline cursor-pointer">
                                    {{ $news->title }}
                                </button>
                            </h2>

                            {{-- คำโปรย / สรุปย่อ --}}
                            @if($news->summary)
                                <p class="text-xs leading-[1.6] text-[#64748B] m-0 mt-2 line-clamp-3">
                                    {{ $news->summary }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- ส่วนท้ายการ์ด --}}
                    <div class="px-5 py-3.5 bg-[#F8FAFC] border-t border-[#E8ECF4] flex items-center justify-between gap-2 text-xs">
                        @if($news->attachment_path)
                            <a href="{{ asset($news->attachment_path) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 font-heading font-semibold text-[#13A678] hover:text-[#124e49] hover:underline">
                                <i class="fa-solid fa-file-arrow-down"></i>
                                <span>ดาวน์โหลดไฟล์แนบ</span>
                            </a>
                        @else
                            <span class="text-[11px] text-[#64748B]">สสอ.โพธิ์ไทร</span>
                        @endif

                        <button type="button"
                                onclick='openNewsDetailModal(@json($news), "{{ $thaiDate }}", "{{ $news->category_label }}")'
                                class="inline-flex items-center gap-1 font-heading font-semibold text-[#168d83] hover:text-[#124e49] ml-auto cursor-pointer">
                            <span>อ่านรายละเอียด</span>
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </button>
                    </div>
                </article>
            @endforeach
        </div>

        <div id="act-empty-search" class="hidden saas-empty-state">
            <i class="fa-regular fa-folder-open text-3xl text-[#168d83]/50 mb-2 block"></i>
            <p class="text-sm font-heading font-bold text-[#1E293B] m-0">ไม่พบข่าวประชาสัมพันธ์ที่ตรงกับเงื่อนไข</p>
            <p class="text-xs text-[#64748B] m-0 mt-1">ลองเลือกหมวดหมู่อื่นหรือเปลี่ยนคำค้นหาใหม่</p>
        </div>
    @else
        <div class="saas-empty-state">
            <i class="fa-solid fa-bullhorn text-3xl text-[#168d83]/50 mb-2 block"></i>
            <p class="text-sm font-heading font-bold text-[#1E293B] m-0">ยังไม่มีข่าวประชาสัมพันธ์ในขณะนี้</p>
            <p class="text-xs text-[#64748B] m-0 mt-1">กรุณาติดตามข้อมูลข่าวสารและประกาศสำคัญได้ในภายหลัง</p>
        </div>
    @endif

    {{-- ส่วนแสดงอัลบั้มภาพกิจกรรม (ถ้ามีข้อมูลในตาราง albums) --}}
    @if(isset($albums) && $albums->count() > 0)
        <section class="pt-4 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-[18px] sm:text-[20px] font-heading font-bold text-[#124e49] m-0 flex items-center gap-2">
                        <i class="fa-solid fa-photo-film text-[#168d83]"></i>
                        <span>อัลบั้มภาพกิจกรรม</span>
                    </h2>
                    <p class="text-xs text-[#68817d] m-0 mt-0.5">ประมวลภาพกิจกรรมการดำเนินงานด้านสาธารณสุขอำเภอโพธิ์ไทร</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($albums as $album)
                    <div class="saas-card bg-white overflow-hidden flex flex-col justify-between group">
                        <div class="relative h-44 bg-[#F8FAFC] overflow-hidden border-b border-[#E8ECF4]">
                            @if($album->cover_image)
                                <img src="{{ asset($album->cover_image) }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full grid place-items-center text-[#64748B]">
                                    <i class="fa-regular fa-images text-3xl"></i>
                                </div>
                            @endif
                            <span class="absolute bottom-2.5 right-2.5 px-2.5 py-1 rounded-full bg-slate-900/75 text-white text-[11px] font-heading font-semibold">
                                <i class="fa-regular fa-image mr-1"></i> {{ $album->photos_count }} ภาพ
                            </span>
                        </div>

                        <div class="p-4">
                            <div class="text-[11px] text-[#64748B] mb-1">
                                <i class="fa-regular fa-calendar mr-1 text-[#168d83]"></i>
                                {{ $album->activity_date ? $album->activity_date->locale('th')->translatedFormat('d M') . ' ' . ($album->activity_date->year + 543) : '-' }}
                                @if($album->location)
                                    • {{ $album->location }}
                                @endif
                            </div>
                            <h3 class="text-sm font-heading font-bold text-[#124e49] m-0 line-clamp-2">{{ $album->title }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>

{{-- MODAL: อ่านรายละเอียดข่าวประชาสัมพันธ์ฉบับเต็ม (พื้นหลังสีขาวทึบ) --}}
<div id="news-detail-modal" class="hidden fixed inset-0 z-50 bg-slate-900/65 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="saas-card bg-white !bg-white rounded-2xl border border-[#E8ECF4] shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 sm:p-7 relative">
        <button type="button"
                onclick="$('#news-detail-modal').addClass('hidden')"
                class="w-8 h-8 rounded-full bg-[#F8FAFC] hover:bg-rose-50 text-[#64748B] hover:text-rose-600 border border-[#E8ECF4] grid place-items-center absolute top-5 right-5 cursor-pointer"
                aria-label="ปิดหน้าต่าง">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="pr-8">
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <span id="modal-news-category" class="px-3 py-0.5 rounded-full bg-[#e8f5f1] text-[#168d83] text-[11px] font-heading font-semibold"></span>
                <span id="modal-news-date" class="text-xs text-[#64748B]"></span>
            </div>

            <h3 id="modal-news-title" class="text-[18px] sm:text-[21px] font-heading font-bold text-[#124e49] leading-snug m-0"></h3>
        </div>

        <div id="modal-news-cover-wrap" class="hidden mt-4 rounded-2xl overflow-hidden border border-[#E8ECF4] bg-[#F8FAFC]">
            <img id="modal-news-cover" src="" alt="ภาพประกอบข่าว" class="w-full max-h-80 object-cover">
        </div>

        <div id="modal-news-summary" class="hidden mt-4 p-3.5 rounded-xl bg-[#f5faf8] border border-[#dcebe7] text-xs font-medium text-[#124e49] leading-relaxed"></div>

        <div id="modal-news-content" class="mt-4 text-xs sm:text-sm text-[#1E293B] leading-[1.8] whitespace-pre-line"></div>

        <div id="modal-news-attachment-wrap" class="hidden mt-5 pt-4 border-t border-[#E8ECF4] flex items-center justify-between gap-3">
            <span class="text-xs text-[#64748B]">เอกสารประกอบข่าวประชาสัมพันธ์</span>
            <a id="modal-news-attachment" href="#" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#13A678] hover:bg-[#124e49] text-white text-xs font-heading font-semibold transition-colors">
                <i class="fa-solid fa-file-arrow-down"></i>
                <span>ดาวน์โหลดเอกสารแนบ</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="module">
    $(function () {
        let currentCategory = 'all';

        function filterActivities() {
            const keyword = $('#act-search-input').val().toLowerCase().trim();
            let visible = 0;

            $('.act-news-card').each(function () {
                const cat = $(this).data('category');
                const text = $(this).data('search') || '';
                const matchCat = (currentCategory === 'all' || cat === currentCategory);
                const matchText = (!keyword || text.includes(keyword));

                if (matchCat && matchText) {
                    $(this).removeClass('hidden');
                    visible++;
                } else {
                    $(this).addClass('hidden');
                }
            });

            if (visible === 0 && $('.act-news-card').length > 0) {
                $('#act-empty-search').removeClass('hidden');
            } else {
                $('#act-empty-search').addClass('hidden');
            }
        }

        $('.act-filter-btn').on('click', function () {
            currentCategory = $(this).data('filter');

            $('.act-filter-btn')
                .removeClass('active bg-[#124e49] text-white')
                .addClass('bg-[#f5faf8] text-[#124e49] border border-[#dcebe7]');

            $(this)
                .addClass('active bg-[#124e49] text-white')
                .removeClass('bg-[#f5faf8] text-[#124e49] border border-[#dcebe7]');

            filterActivities();
        });

        $('#act-search-input').on('input', filterActivities);

        // คลิกพื้นที่พื้นหลังมืดนอกกรอบ Modal หรือกดปุ่ม Escape เพื่อปิดหน้าต่าง
        $('#news-detail-modal').on('click', function (e) {
            if (e.target === this) {
                $(this).addClass('hidden');
            }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && !$('#news-detail-modal').hasClass('hidden')) {
                $('#news-detail-modal').addClass('hidden');
            }
        });

        // หากเปิดลิงก์พร้อม Hash เช่น #news-5 ให้เปิด Modal ข่าวนั้นให้อัตโนมัติ
        if (window.location.hash && window.location.hash.startsWith('#news-')) {
            const $targetCard = $(window.location.hash);
            if ($targetCard.length) {
                $targetCard.find('button').first().trigger('click');
            }
        }
    });

    window.openNewsDetailModal = function (news, thaiDate, categoryLabel) {
        $('#modal-news-category').text(categoryLabel);
        $('#modal-news-date').html(`<i class="fa-regular fa-calendar mr-1"></i> เผยแพร่เมื่อ ${thaiDate}`);
        $('#modal-news-title').text(news.title || '');

        if (news.cover_image) {
            $('#modal-news-cover').attr('src', `/${news.cover_image}`);
            $('#modal-news-cover-wrap').removeClass('hidden');
        } else {
            $('#modal-news-cover-wrap').addClass('hidden');
        }

        if (news.summary) {
            $('#modal-news-summary').text(news.summary).removeClass('hidden');
        } else {
            $('#modal-news-summary').addClass('hidden');
        }

        $('#modal-news-content').text(news.content || news.summary || 'ไม่มีรายละเอียดเพิ่มเติม');

        if (news.attachment_path) {
            $('#modal-news-attachment').attr('href', `/${news.attachment_path}`);
            $('#modal-news-attachment-wrap').removeClass('hidden');
        } else {
            $('#modal-news-attachment-wrap').addClass('hidden');
        }

        $('#news-detail-modal').removeClass('hidden');
    };
</script>
@endpush
