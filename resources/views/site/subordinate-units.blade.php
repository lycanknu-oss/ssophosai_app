@extends('layouts.app')

@section('title', 'หน่วยงานภายใต้สังกัด - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('banner')
    <div class="h-[145px] md:h-[172px] relative overflow-hidden bg-[#124e49]">
        <img src="https://images.pexels.com/photos/40139106/pexels-photo-40139106.jpeg"
             alt="หน่วยงานภายใต้สังกัด สำนักงานสาธารณสุขอำเภอโพธิ์ไทร"
             class="w-full h-full object-cover object-[center_45%] opacity-45"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-[#073933]/95 via-[#084e45]/75 to-[#084e45]/40"></div>
        <div class="absolute inset-0 z-10 flex items-center text-white">
            <div class="phs-container">
                <div class="flex items-center gap-1.5 text-[11px] text-[#b9f3dc] mb-1">
                    <a href="{{ route('home') }}" class="hover:underline">หน้าหลัก</a>
                    <span>/</span>
                    <span>หน่วยงานภายใต้สังกัด</span>
                </div>
                <h2 class="text-[20px] md:text-[27px] leading-[1.3] font-bold m-0">หน่วยงานภายใต้สังกัด</h2>
                <p class="m-0 mt-1 text-[#e7f5ee] text-[11px] md:text-[13px]">รายชื่อสถานบริการสาธารณสุข โรงพยาบาลส่งเสริมสุขภาพตำบล (รพ.สต.) และเครือข่ายหน่วยบริการในพื้นที่</p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- แถบกรองประเภทหน่วยบริการ + ช่องค้นหา --}}
    <div class="phs-card p-3.5 mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
        <div class="flex flex-wrap gap-2 items-center" role="tablist" aria-label="กรองตามประเภทหน่วยบริการสุขภาพ">
            <span class="text-xs font-semibold text-[#68817d] px-2">ประเภทหน่วยบริการ:</span>
            <button type="button"
                    data-unit-type="all"
                    class="unit-filter-btn active text-xs font-semibold px-3.5 py-1.5 rounded-lg bg-[#124e49] text-white transition-colors cursor-pointer">
                ทั้งหมด ({{ $units->count() }})
            </button>

            @foreach($unitTypes as $type)
                <button type="button"
                        data-unit-type="{{ $type }}"
                        class="unit-filter-btn text-xs font-medium px-3.5 py-1.5 rounded-lg bg-[#f5faf8] text-[#124e49] hover:bg-[#e8f5f1] hover:text-[#168d83] transition-colors cursor-pointer">
                    {{ $type }} ({{ $units->where('service_unit_type', $type)->count() }})
                </button>
            @endforeach
        </div>

        <div class="relative w-full lg:w-72">
            <i class="fa-solid fa-magnifying-glass text-xs text-[#68817d] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" aria-hidden="true"></i>
            <input type="text"
                   id="unit-search-input"
                   class="w-full rounded-lg border border-[#dcebe7] bg-[#f5faf8] focus:bg-white focus:border-[#168d83] focus:outline-none pl-8 pr-3 py-1.5 text-xs text-[#124e49]"
                   placeholder="ค้นหาชื่อ รพ.สต., ตำบล หรือรหัส...">
        </div>
    </div>

    {{-- รายการหน่วยงานภายใต้สังกัด --}}
    <section id="subordinate-units" class="mb-[29px]" aria-labelledby="subordinate-units-title">
        <div class="flex justify-between items-end gap-[15px] mb-4">
            <div>
                <span class="text-[11px] font-bold tracking-[1.6px] text-[#168d83] uppercase">SUBORDINATE HEALTH UNITS</span>
                <h1 id="subordinate-units-title" class="text-[20px] sm:text-[24px] font-bold leading-[1.3] mt-[3px] mb-0 text-[#124e49]">
                    รายชื่อหน่วยบริการที่เปิดดำเนินการ ({{ number_format($units->count()) }} แห่ง)
                </h1>
            </div>
            <p class="hidden sm:block m-0 text-[#68817d] text-xs">สำนักงานสาธารณสุขอำเภอโพธิ์ไทร จังหวัดอุบลราชธานี</p>
        </div>

        @if($units->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($units as $unit)
                    <article data-type="{{ $unit->service_unit_type }}"
                             data-search="{{ mb_strtolower($unit->name . ' ' . $unit->hospcode5 . ' ' . $unit->hospcode9_new . ' ' . $unit->subdistrict_name . ' ' . $unit->service_unit_type) }}"
                             class="sub-unit-card phs-card p-6 flex flex-col justify-between hover:-translate-y-0.5 transition-all">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-2.5">
                                <span class="phs-pill">{{ $unit->service_unit_type }}</span>
                                @if($unit->hospcode5)
                                    <span class="text-[11px] font-semibold text-[#168d83] bg-[#f5faf8] border border-[#dcebe7] px-2 py-0.5 rounded">
                                        รหัส {{ $unit->hospcode5 }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-[16px] font-bold text-[#124e49] mt-0 mb-[8px] leading-snug">
                                <button type="button"
                                        onclick='openUnitDetailModal(@json($unit))'
                                        class="text-left hover:text-[#168d83] hover:underline cursor-pointer">
                                    {{ $unit->name }}
                                </button>
                            </h3>

                            <p class="m-0 text-[#68817d] text-[12.5px] leading-relaxed">
                                <i class="fa-solid fa-location-dot text-[#168d83] mr-1" aria-hidden="true"></i>
                                {{ $unit->address ? 'เลขที่ ' . $unit->address . ' ' : '' }}
                                {{ $unit->moo && $unit->moo !== '0' ? 'หมู่ ' . $unit->moo . ' ' : '' }}
                                ตำบล{{ $unit->subdistrict_name }} อำเภอ{{ $unit->district_name }} จังหวัด{{ $unit->province_name }} {{ $unit->zipcode }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-[#dcebe7] flex items-center justify-between text-xs">
                            <span class="text-[11px] font-semibold text-[#168d83]">
                                รหัส 9 หลัก: {{ $unit->hospcode9_new }}
                            </span>
                            <button type="button"
                                    onclick='openUnitDetailModal(@json($unit))'
                                    class="font-semibold text-[#124e49] hover:text-[#168d83] cursor-pointer">
                                รายละเอียด &rarr;
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>

            <div id="unit-empty-search" class="hidden phs-card p-10 text-center text-[#68817d] text-xs">
                ไม่พบหน่วยงานภายใต้สังกัดที่ตรงกับคำค้นหา
            </div>
        @else
            <div class="phs-card p-10 text-center text-[#68817d] text-xs">
                ยังไม่มีข้อมูลหน่วยงานภายใต้สังกัดในขณะนี้
            </div>
        @endif
    </section>

    {{-- Modal แสดงรายละเอียดหน่วยบริการ --}}
    <div id="unit-detail-modal" class="hidden fixed inset-0 z-50 bg-slate-900/65 flex items-center justify-center p-4">
        <div class="phs-card bg-white w-full max-w-xl max-h-[90vh] overflow-y-auto p-6 relative">
            <button type="button"
                    onclick="closeUnitDetailModal()"
                    class="w-8 h-8 rounded-full bg-[#f5faf8] hover:bg-rose-50 text-[#68817d] hover:text-rose-600 border border-[#dcebe7] grid place-items-center absolute top-5 right-5 cursor-pointer">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>

            <span id="modal-unit-type" class="phs-pill mb-2"></span>
            <h3 id="modal-unit-name" class="text-[19px] font-bold text-[#124e49] m-0 pr-8"></h3>

            <div class="mt-4 pt-4 border-t border-[#dcebe7] space-y-2.5 text-xs">
                <div class="grid grid-cols-2 gap-3 p-3.5 rounded-[11px] bg-[#f5faf8] border border-[#bce2d6]">
                    <div>
                        <span class="block text-[11px] text-[#68817d]">รหัสหน่วยบริการ 9 หลักใหม่</span>
                        <strong id="modal-unit-code9" class="text-sm text-[#124e49]"></strong>
                    </div>
                    <div>
                        <span class="block text-[11px] text-[#68817d]">รหัสหน่วยบริการ 5 หลัก</span>
                        <strong id="modal-unit-code5" class="text-sm text-[#124e49]"></strong>
                    </div>
                </div>

                <div class="divide-y divide-[#dcebe7]">
                    <div class="py-2.5 flex justify-between gap-4">
                        <span class="text-[#68817d]">ประเภทองค์กร / สังกัด</span>
                        <span id="modal-unit-org" class="font-semibold text-[#124e49] text-right"></span>
                    </div>
                    <div class="py-2.5 flex justify-between gap-4">
                        <span class="text-[#68817d]">หน่วยงานต้นสังกัด</span>
                        <span id="modal-unit-dept" class="font-semibold text-[#124e49] text-right"></span>
                    </div>
                    <div id="modal-unit-level-row" class="py-2.5 flex justify-between gap-4 hidden">
                        <span class="text-[#68817d]">ระดับโรงพยาบาล</span>
                        <span id="modal-unit-level" class="font-semibold text-[#124e49] text-right"></span>
                    </div>
                    <div id="modal-unit-parent-row" class="py-2.5 flex justify-between gap-4 hidden">
                        <span class="text-[#68817d]">โรงพยาบาลแม่ข่าย</span>
                        <span id="modal-unit-parent" class="font-semibold text-[#124e49] text-right"></span>
                    </div>
                    <div class="py-2.5 flex justify-between gap-4">
                        <span class="text-[#68817d]">ที่ตั้งหน่วยบริการ</span>
                        <span id="modal-unit-address" class="font-semibold text-[#124e49] text-right"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentType = 'all';
        const searchInput = document.getElementById('unit-search-input');
        const filterBtns = document.querySelectorAll('.unit-filter-btn');
        const cards = document.querySelectorAll('.sub-unit-card');
        const emptyBox = document.getElementById('unit-empty-search');

        function filterUnits() {
            const keyword = (searchInput?.value || '').toLowerCase().trim();
            let visibleCount = 0;

            cards.forEach(card => {
                const type = card.getAttribute('data-type') || '';
                const text = card.getAttribute('data-search') || '';
                const matchType = (currentType === 'all' || type === currentType);
                const matchText = (!keyword || text.includes(keyword));

                if (matchType && matchText) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (emptyBox) {
                emptyBox.classList.toggle('hidden', visibleCount > 0 || cards.length === 0);
            }
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                currentType = this.getAttribute('data-unit-type');

                filterBtns.forEach(b => {
                    b.classList.remove('active', 'bg-[#124e49]', 'text-white');
                    b.classList.add('bg-[#f5faf8]', 'text-[#124e49]');
                });

                this.classList.add('active', 'bg-[#124e49]', 'text-white');
                this.classList.remove('bg-[#f5faf8]', 'text-[#124e49]');

                filterUnits();
            });
        });

        searchInput?.addEventListener('input', filterUnits);
    });

    window.openUnitDetailModal = function (unit) {
        document.getElementById('modal-unit-type').textContent = unit.service_unit_type || 'หน่วยบริการสุขภาพ';
        document.getElementById('modal-unit-name').textContent = unit.name || '-';
        document.getElementById('modal-unit-code9').textContent = unit.hospcode9_new || '-';
        document.getElementById('modal-unit-code5').textContent = unit.hospcode5 || '-';
        document.getElementById('modal-unit-org').textContent = `${unit.org_type || '-'} (${unit.ministry || 'กระทรวงสาธารณสุข'})`;
        document.getElementById('modal-unit-dept').textContent = unit.department || '-';

        const levelRow = document.getElementById('modal-unit-level-row');
        if (unit.hospital_level) {
            const bedsText = unit.actual_beds > 0 ? ` (${unit.actual_beds} เตียง)` : '';
            document.getElementById('modal-unit-level').textContent = `${unit.hospital_level}${bedsText}`;
            levelRow.classList.remove('hidden');
        } else {
            levelRow.classList.add('hidden');
        }

        const parentRow = document.getElementById('modal-unit-parent-row');
        if (unit.parent_hospital) {
            document.getElementById('modal-unit-parent').textContent = unit.parent_hospital;
            parentRow.classList.remove('hidden');
        } else {
            parentRow.classList.add('hidden');
        }

        const addressParts = [
            unit.address ? `เลขที่ ${unit.address}` : '',
            unit.moo && unit.moo !== '0' ? `หมู่ ${unit.moo}` : '',
            unit.subdistrict_name ? `ตำบล${unit.subdistrict_name}` : '',
            unit.district_name ? `อำเภอ${unit.district_name}` : '',
            unit.province_name ? `จังหวัด${unit.province_name}` : '',
            unit.zipcode || ''
        ].filter(Boolean);

        document.getElementById('modal-unit-address').textContent = addressParts.join(' ') || '-';
        document.getElementById('unit-detail-modal').classList.remove('hidden');
    };

    window.closeUnitDetailModal = function () {
        document.getElementById('unit-detail-modal').classList.add('hidden');
    };
</script>
@endpush
