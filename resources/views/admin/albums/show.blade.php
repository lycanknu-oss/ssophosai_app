@extends('admin.layouts.app')

@section('title', 'จัดการรูปภาพในอัลบั้ม - Admin Dashboard')

@section('page-header')
    <div class="saas-card p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="min-w-0">
            <a href="{{ route('admin.albums.index') }}" class="inline-flex items-center gap-1.5 text-xs font-heading font-semibold text-[#3126C9] hover:underline mb-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span>กลับหน้ารวมอัลบั้มกิจกรรม</span>
            </a>
            <h1 class="text-[20px] sm:text-[24px] font-heading font-bold text-[#1E293B] m-0">
                {{ $album->title }}
            </h1>
            <p class="text-xs text-[#64748B] m-0 mt-1">
                วันที่จัดกิจกรรม: {{ $album->activity_date ? $album->activity_date->format('d/m/') . ($album->activity_date->year + 543) : '-' }}
                @if($album->location) • สถานที่: {{ $album->location }} @endif
                • จำนวนรูปภาพทั้งหมด {{ $album->photos->count() }} รูป
            </p>
        </div>

        <form action="{{ route('admin.albums.destroy', $album) }}" method="POST" class="m-0 shrink-0" onsubmit="return confirm('ยืนยันการลบอัลบั้มนี้และรูปภาพทั้งหมด?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-200 text-xs font-heading font-semibold transition-colors cursor-pointer">
                <i class="fa-solid fa-trash-can"></i>
                <span>ลบอัลบั้มนี้</span>
            </button>
        </form>
    </div>
@endsection

@section('content')
    @if($errors->any())
        <div class="saas-card p-4 !border-rose-200 !bg-rose-50 text-rose-700 text-xs space-y-1">
            @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {{-- คอลัมน์ซ้าย: แก้ไขรายละเอียดอัลบั้ม --}}
        <div class="lg:col-span-5 saas-card p-6">
            <h2 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0 mb-4 pb-3 border-b border-[#E8ECF4]">
                แก้ไขข้อมูลอัลบั้ม
            </h2>

            <form action="{{ route('admin.albums.update', $album) }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">ชื่ออัลบั้มกิจกรรม <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $album->title) }}" required class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">สถานที่จัดกิจกรรม</label>
                    <input type="text" name="location" value="{{ old('location', $album->location) }}" class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">วันที่จัดกิจกรรม <span class="text-rose-500">*</span></label>
                    <input type="date" name="activity_date" value="{{ old('activity_date', $album->activity_date?->format('Y-m-d')) }}" required class="saas-input w-full text-xs">
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">รายละเอียดกิจกรรม</label>
                    <textarea name="description" rows="3" class="saas-input w-full text-xs">{{ old('description', $album->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-heading font-semibold text-[#1E293B] mb-1">เปลี่ยนรูปหน้าปกอัลบั้ม</label>
                    <input type="file" name="cover_image" accept="image/*" class="saas-input w-full text-xs">
                </div>

                <div class="pt-1">
                    <label class="inline-flex items-center gap-2 text-xs text-[#1E293B] cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $album->is_active ? 'checked' : '' }} class="rounded border-[#E8ECF4] text-[#3126C9]">
                        <span class="font-medium">เผยแพร่อัลบั้มบนเว็บไซต์</span>
                    </label>
                </div>

                <div class="pt-3 border-t border-[#E8ECF4]">
                    <button type="submit" class="btn-saas-primary w-full text-xs font-heading font-semibold !py-2.5 cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>บันทึกการแก้ไขอัลบั้ม</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- คอลัมน์ขวา: อัปโหลดรูปภาพเพิ่มเติม & แกลเลอรีรูปภาพในอัลบั้ม --}}
        <div class="lg:col-span-7 space-y-6">
            {{-- กล่องอัปโหลดรูปภาพเพิ่ม --}}
            <div class="saas-card p-6">
                <h2 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0 mb-3">
                    เพิ่มรูปภาพเข้าสู่อัลบั้ม
                </h2>
                <form action="{{ route('admin.albums.photos.upload', $album) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    @csrf
                    <input type="file" name="photos[]" accept="image/*" multiple required class="saas-input flex-1 text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-heading file:font-semibold file:bg-[#EEF2FF] file:text-[#3126C9] cursor-pointer">
                    <button type="submit" class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-5 cursor-pointer shrink-0">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>อัปโหลดรูปภาพ</span>
                    </button>
                </form>
            </div>

            {{-- แกลเลอรีรูปภาพในอัลบั้ม --}}
            <div class="saas-card p-6">
                <h3 class="text-[16px] font-heading font-semibold text-[#1E293B] m-0 mb-4 pb-3 border-b border-[#E8ECF4]">
                    รูปภาพภายในอัลบั้ม ({{ $album->photos->count() }} รูป)
                </h3>

                @if($album->photos->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3.5">
                        @foreach($album->photos as $photo)
                            @php $isCover = ($album->cover_image === $photo->image_path); @endphp
                            <div class="relative group rounded-2xl overflow-hidden border {{ $isCover ? 'border-[#3126C9] ring-2 ring-[#3126C9]/20' : 'border-[#E8ECF4]' }} bg-[#F8FAFC]">
                                <img src="{{ asset($photo->image_path) }}" alt="ภาพกิจกรรม" class="w-full h-32 object-cover">

                                @if($isCover)
                                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#3126C9] text-white text-[10px] font-heading font-semibold shadow-xs">
                                        หน้าปก
                                    </span>
                                @endif

                                {{-- ปุ่มจัดการแต่ละรูป --}}
                                <div class="p-2 bg-white border-t border-[#E8ECF4] flex items-center justify-between gap-1">
                                    @if(!$isCover)
                                        <form action="{{ route('admin.albums.photos.cover', [$album, $photo]) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-[11px] font-heading font-semibold text-[#3126C9] hover:underline cursor-pointer">
                                                ตั้งเป็นหน้าปก
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[11px] text-[#64748B]">ภาพหน้าปกหลัก</span>
                                    @endif

                                    <form action="{{ route('admin.albums.photos.destroy', [$album, $photo]) }}" method="POST" class="m-0" onsubmit="return confirm('ลบรูปภาพนี้?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-6 h-6 rounded-md bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white grid place-items-center transition-colors cursor-pointer" title="ลบรูป">
                                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-[#64748B] text-center py-6 m-0">ยังไม่มีรูปภาพในอัลบั้มนี้</p>
                @endif
            </div>
        </div>
    </div>
@endsection
