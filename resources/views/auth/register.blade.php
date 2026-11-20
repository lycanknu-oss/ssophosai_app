@extends('layouts.app')

@section('title', 'ลงทะเบียนเจ้าหน้าที่ - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('banner')
    <div class="h-[130px] relative overflow-hidden bg-[#124e49]">
        <div class="absolute inset-0 bg-gradient-to-r from-[#073933]/95 via-[#084e45]/85 to-[#124e49]"></div>
        <div class="absolute inset-0 z-10 flex items-center text-white">
            <div class="phs-container">
                <div class="flex items-center gap-1.5 text-[11px] text-[#b9f3dc] mb-1">
                    <a href="{{ route('home') }}" class="hover:underline">หน้าหลัก</a>
                    <span>/</span>
                    <a href="{{ route('login') }}" class="hover:underline">เข้าสู่ระบบ</a>
                    <span>/</span>
                    <span>ลงทะเบียน</span>
                </div>
                <h2 class="text-[20px] md:text-[25px] font-bold m-0 flex items-center gap-2.5">
                    <i class="fa-solid fa-user-plus text-[#a6ead3]"></i>
                    <span>ลงทะเบียนบัญชีเจ้าหน้าที่</span>
                </h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-[480px] mx-auto my-6">
        <div class="phs-card rounded-[20px] p-6 sm:p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-[#e8f5f1] text-[#168d83] grid place-items-center mx-auto mb-3 border border-[#dcebe7]">
                    <i class="fa-solid fa-id-card-clip text-2xl"></i>
                </div>
                <h1 class="text-[20px] font-bold text-[#124e49] m-0">สร้างบัญชีผู้ใช้งานใหม่</h1>
                <p class="text-xs text-[#68817d] mt-1 mb-0">ข้อมูลรหัสผ่านจะถูกเข้ารหัสความปลอดภัยมาตรฐานระบบ</p>
            </div>

            @if($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-semibold text-[#124e49] mb-1.5">ชื่อ - นามสกุล</label>
                    <div class="relative">
                        <i class="fa-solid fa-user text-[#68817d] text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               placeholder="เช่น นายสมชาย ใจดี"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs bg-[#f5faf8] border border-[#dcebe7] rounded-xl text-[#173a39] focus:bg-white focus:border-[#168d83] outline-none transition-colors">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-[#124e49] mb-1.5">อีเมลผู้ใช้งาน</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope text-[#68817d] text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               placeholder="staff@ssophosai.in.th"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs bg-[#f5faf8] border border-[#dcebe7] rounded-xl text-[#173a39] focus:bg-white focus:border-[#168d83] outline-none transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-[#124e49] mb-1.5">รหัสผ่าน (อย่างน้อย 8 ตัวอักษร)</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock text-[#68817d] text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input id="password" type="password" name="password" required
                               placeholder="กำหนดรหัสผ่าน"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs bg-[#f5faf8] border border-[#dcebe7] rounded-xl text-[#173a39] focus:bg-white focus:border-[#168d83] outline-none transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-[#124e49] mb-1.5">ยืนยันรหัสผ่านอีกครั้ง</label>
                    <div class="relative">
                        <i class="fa-solid fa-shield-halved text-[#68817d] text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               placeholder="กรอกรหัสผ่านให้ตรงกัน"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs bg-[#f5faf8] border border-[#dcebe7] rounded-xl text-[#173a39] focus:bg-white focus:border-[#168d83] outline-none transition-colors">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-[#168d83] hover:bg-[#124e49] text-white text-xs font-semibold py-3 rounded-xl shadow-sm transition-colors cursor-pointer flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-check"></i>
                    <span>ยืนยันการลงทะเบียน</span>
                </button>
            </form>

            <div class="mt-6 pt-4 border-t border-[#dcebe7] text-center text-xs text-[#68817d]">
                <span>มีบัญชีผู้ใช้งานอยู่แล้ว?</span>
                <a href="{{ route('login') }}" class="font-semibold text-[#168d83] hover:text-[#124e49] hover:underline ml-1">
                    เข้าสู่ระบบที่นี่
                </a>
            </div>
        </div>
    </div>
@endsection
