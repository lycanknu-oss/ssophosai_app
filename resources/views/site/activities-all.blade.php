@extends('site.layouts.app')

@section('title', 'คลังข่าวประชาสัมพันธ์ทั้งหมด - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('content')
<div class="max-w-7xl w-full mx-auto p-4 sm:p-6 md:p-8 space-y-6">

    <div class="saas-card p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('activities') }}" class="inline-flex items-center gap-1.5 text-xs font-heading font-semibold text-[#168d83] hover:underline mb-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>กลับหน้าข่าวประชาสัมพันธ์และกิจกรรม</span>
            </a>
            <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#124e49] m-0">
                คลังข่าวประชาสัมพันธ์ทั้งหมด
            </h1>
            <p class="text-xs text-[#64748B] m-0 mt-1">
                พบข่าวประชาสัมพันธ์ทั้งหมด {{ number_format($activities->total()) }} รายการ
            </p>
        </div>

        <form action="{{ route('activities.all') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 m-0">
            <select name="category" onchange="this.form.submit()" class="saas-input text-xs cursor-pointer">
                <option value="all" {{ request('category', 'all') === 'all' ? 'selected' : '' }}>ทุกหมวดหมู่</option>
                <option value="general" {{ request('category') === 'general' ? 'selected' : '' }}>ข่าวทั่วไป</option>
                <option value="recruitment" {{ request('category') === 'recruitment' ? 'selected' : '' }}>ข่าวรับสมัครงาน</option>
                <option value="procurement" {{ request('category') === 'procurement' ? 'selected' : '' }}>ข่าวจัดซื้อจัดจ้าง</option>
            </select>

            <div class="flex items-center gap-1.5">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาหัวข้อข่าว..." class="saas-input text-xs sm:w-56">
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-[#124e49] hover:bg-[#168d83] text-white text-xs font-heading font-semibold transition-colors cursor-pointer shrink-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="saas-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                        <th class="p-4 w-32">วันที่เผยแพร่</th>
                        <th class="p-4 w-36">หมวดหมู่</th>
                        <th class="p-4">หัวข้อข่าวประชาสัมพันธ์</th>
                        <th class="p-4 w-36 text-right">เอกสารแนบ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                    @forelse($activities as $news)
                        @php
                            $catBadge = match($news->category) {
                                'recruitment' => 'bg-emerald-50 text-[#13A678]',
                                'procurement' => 'bg-amber-50 text-[#d97706]',
                                default       => 'bg-[#e8f5f1] text-[#168d83]',
                            };
                        @endphp
                        <tr class="hover:bg-[#F8FAFC] transition-colors">
                            <td class="p-4 whitespace-nowrap text-[#64748B]">
                                {{ $news->published_date ? $news->published_date->format('d/m/') . ($news->published_date->year + 543) : '-' }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full font-heading font-semibold text-[11px] {{ $catBadge }}">
                                    {{ $news->category_label }}
                                </span>
                            </td>
                            <td class="p-4">
                                <a href="{{ route('activities') }}#news-{{ $news->id }}" class="font-heading font-semibold text-sm text-[#124e49] hover:text-[#168d83] hover:underline">
                                    @if($news->is_pinned)
                                        <span class="text-amber-500 mr-1"><i class="fa-solid fa-thumbtack"></i></span>
                                    @endif
                                    {{ $news->title }}
                                </a>
                                @if($news->summary)
                                    <p class="text-[#64748B] m-0 mt-0.5 line-clamp-1">{{ $news->summary }}</p>
                                @endif
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                @if($news->attachment_path)
                                    <a href="{{ asset($news->attachment_path) }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#e8f5f1] hover:bg-[#168d83] text-[#168d83] hover:text-white font-heading font-semibold transition-colors">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                        <span>ดาวน์โหลด</span>
                                    </a>
                                @else
                                    <span class="text-[#64748B]">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-[#64748B]">
                                ไม่พบรายการข่าวประชาสัมพันธ์ในระบบ
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div class="p-4 border-t border-[#E8ECF4]">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
