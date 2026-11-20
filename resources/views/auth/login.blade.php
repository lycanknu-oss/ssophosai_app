@extends('layouts.app')

@section('title', 'เข้าสู่ระบบสำหรับเจ้าหน้าที่ - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')
@if (session('status'))
    <div class="mb-4 p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium">
        <i class="fa-solid fa-clock mr-1.5 text-[#F49A22]"></i>{{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium">
        <i class="fa-solid fa-circle-exclamation mr-1.5"></i>{{ $errors->first() }}
    </div>
@endif
@section('banner')
    <div class="h-[130px] relative overflow-hidden bg-[#124e49]">
        <div class="absolute inset-0 bg-gradient-to-r from-[#073933]/95 via-[#084e45]/85 to-[#124e49]"></div>
        <div class="absolute inset-0 z-10 flex items-center text-white">
            <div class="phs-container">
                <div class="flex items-center gap-1.5 text-[11px] text-[#b9f3dc] mb-1">
                    <a href="{{ route('home') }}" class="hover:underline">หน้าหลัก</a>
                    <span>/</span>
                    <span>สำหรับเจ้าหน้าที่</span>
                </div>
                <h2 class="text-[20px] md:text-[25px] font-bold m-0 flex items-center gap-2.5">
                    <i class="fa-solid fa-user-shield text-[#a6ead3]"></i>
                    <span>ระบบยืนยันตัวตนเจ้าหน้าที่</span>
                </h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-[460px] mx-auto my-6">
        <div class="phs-card rounded-[20px] p-6 sm:p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-[#e8f5f1] text-[#168d83] grid place-items-center mx-auto mb-3 border border-[#dcebe7]">
                    <i class="fa-solid fa-lock text-2xl"></i>
                </div>
                <h1 class="text-[20px] font-bold text-[#124e49] m-0">เข้าสู่ระบบจัดการเว็บไซต์</h1>
                <p class="text-xs text-[#68817d] mt-1 mb-0">สำนักงานสาธารณสุขอำเภอโพธิ์ไทร จังหวัดอุบลราชธานี</p>
            </div>

            @if(session('success'))
                <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

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

            <form method="POST" action="{{ url('/login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-[#124e49] mb-1.5">อีเมลผู้ใช้งาน</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope text-[#68817d] text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input id="email" type="text" name="username" value="{{ old('username') }}" required autofocus
                               placeholder="staff@ssophosai.in.th"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs bg-[#f5faf8] border border-[#dcebe7] rounded-xl text-[#173a39] focus:bg-white focus:border-[#168d83] outline-none transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-[#124e49] mb-1.5">รหัสผ่าน</label>
                    <div class="relative">
                        <i class="fa-solid fa-key text-[#68817d] text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input id="password" type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full pl-9 pr-3.5 py-2.5 text-xs bg-[#f5faf8] border border-[#dcebe7] rounded-xl text-[#173a39] focus:bg-white focus:border-[#168d83] outline-none transition-colors">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="inline-flex items-center gap-2 text-[#68817d] cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-[#dcebe7] text-[#168d83] focus:ring-[#168d83]">
                        <span>จดจำการเข้าสู่ระบบ</span>
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-[#124e49] hover:bg-[#168d83] text-white text-xs font-semibold py-3 rounded-xl shadow-sm transition-colors cursor-pointer flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>เข้าสู่ระบบ</span>
                </button>
            </form>

            <div class="mt-6 pt-4 border-t border-[#dcebe7] text-center text-xs text-[#68817d]">
                <span>ยังไม่มีบัญชีผู้ใช้งานสำหรับเจ้าหน้าที่?</span>
                <a href="{{ route('register') }}" class="font-semibold text-[#168d83] hover:text-[#124e49] hover:underline ml-1">
                    ลงทะเบียนใหม่
                </a>
            </div>
        </div>
    </div>
@endsection
