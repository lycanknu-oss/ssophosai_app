@extends('admin.layouts.app')

@section('title', 'จัดการผู้ใช้งานระบบ - สำนักงานสาธารณสุขอำเภอโพธิ์ไทร')

@section('page-header')
    <div class="saas-card p-6 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 text-[11px] font-heading font-semibold text-[#3126C9] bg-[#EEF2FF] px-3 py-1 rounded-full mb-2">
                <i class="fa-solid fa-user-shield"></i> USER & ACCESS MANAGEMENT
            </span>
            <h1 class="text-[22px] sm:text-[26px] font-heading font-bold text-[#1E293B] m-0">
                จัดการผู้ใช้งานและสิทธิ์การเข้าถึง
            </h1>
            <p class="text-xs sm:text-sm text-[#64748B] m-0 mt-1">
                อนุมัติผู้ลงทะเบียนใหม่ (Waiting) และกำหนดระดับสิทธิ์การใช้งาน (User, Editor, Admin)
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-center shrink-0">
            <button type="button"
                    onclick="openUserModal('create')"
                    class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-5 inline-flex items-center gap-2 cursor-pointer">
                <i class="fa-solid fa-user-plus"></i>
                <span>เพิ่มผู้ใช้งานใหม่</span>
            </button>
        </div>
    </div>
@endsection

@section('content')
    {{-- แจ้งเตือนผลการทำงาน --}}
    @if(session('success'))
        <div class="saas-card p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-xs sm:text-sm flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-[#13A678] text-white grid place-items-center shrink-0">
                    <i class="fa-solid fa-check"></i>
                </span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="saas-card p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-xs sm:text-sm flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-rose-600 text-white grid place-items-center shrink-0">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 cursor-pointer">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="saas-card p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 text-xs space-y-1">
            <div class="font-heading font-bold flex items-center gap-1.5">
                <i class="fa-solid fa-circle-exclamation"></i> กรุณาตรวจสอบข้อมูลที่กรอก:
            </div>
            <ul class="m-0 pl-5 list-disc space-y-0.5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- การ์ดสรุปสถิติผู้ใช้งาน (KPI Cards) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="saas-card p-5 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow hover:-translate-y-1 transition duration-300">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-heading font-semibold text-[#64748B]">ผู้ใช้งานทั้งหมด</span>
                    <div class="text-[28px] font-heading font-bold text-[#1E293B] mt-1 leading-none">
                        {{ number_format($stats['total']) }}
                        <span class="text-xs font-normal text-[#64748B]">บัญชี</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-[#EEF2FF] text-[#3126C9] grid place-items-center text-lg shrink-0">
                    <i class="fa-solid fa-users"></i>
                </span>
            </div>
        </div>

        <a href="{{ route('admin.users.index', ['status' => 'waiting']) }}"
           class="saas-card p-5 bg-white rounded-2xl border {{ $stats['waiting'] > 0 ? 'border-amber-300 ring-2 ring-amber-100' : 'border-[#E8ECF4]' }} saas-shadow hover:-translate-y-1 transition duration-300 block">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-heading font-semibold text-[#B45309]">รออนุมัติ (Waiting)</span>
                    <div class="text-[28px] font-heading font-bold text-[#F49A22] mt-1 leading-none">
                        {{ number_format($stats['waiting']) }}
                        <span class="text-xs font-normal text-[#64748B]">บัญชี</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-amber-50 text-[#F49A22] grid place-items-center text-lg shrink-0">
                    <i class="fa-solid fa-hourglass-half"></i>
                </span>
            </div>
        </a>

        <div class="saas-card p-5 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow hover:-translate-y-1 transition duration-300">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-heading font-semibold text-[#64748B]">อนุมัติใช้งานแล้ว (Approved)</span>
                    <div class="text-[28px] font-heading font-bold text-[#13A678] mt-1 leading-none">
                        {{ number_format($stats['approved']) }}
                        <span class="text-xs font-normal text-[#64748B]">บัญชี</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-emerald-50 text-[#13A678] grid place-items-center text-lg shrink-0">
                    <i class="fa-solid fa-circle-check"></i>
                </span>
            </div>
        </div>

        <div class="saas-card p-5 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow hover:-translate-y-1 transition duration-300">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <span class="text-xs font-heading font-semibold text-[#64748B]">ผู้ดูแลระบบ (Admin)</span>
                    <div class="text-[28px] font-heading font-bold text-[#1E293B] mt-1 leading-none">
                        {{ number_format($stats['admins']) }}
                        <span class="text-xs font-normal text-[#64748B]">บัญชี</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-2xl bg-sky-50 text-[#1675E8] grid place-items-center text-lg shrink-0">
                    <i class="fa-solid fa-user-gear"></i>
                </span>
            </div>
        </div>
    </div>

    {{-- คำอธิบายระดับสิทธิ์ 3 ระดับ --}}
    <div class="saas-card p-4 bg-[#F8FAFC] rounded-2xl border border-[#E8ECF4] grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
        <div class="flex items-start gap-2.5 bg-white p-3 rounded-xl border border-[#E8ECF4]">
            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-[#64748B] font-heading font-bold shrink-0">User</span>
            <span class="text-[#64748B]">ใช้งานได้เฉพาะเมนู <strong class="text-[#1E293B]">ประชาสัมพันธ์</strong> และ <strong class="text-[#1E293B]">อัลบั้มกิจกรรม</strong></span>
        </div>
        <div class="flex items-start gap-2.5 bg-white p-3 rounded-xl border border-[#E8ECF4]">
            <span class="px-2 py-0.5 rounded-md bg-sky-50 text-[#1675E8] font-heading font-bold shrink-0">Editor</span>
            <span class="text-[#64748B]">ใช้งานได้ <strong class="text-[#1E293B]">ทุกเมนู</strong> ยกเว้นเมนูจัดการผู้ใช้งาน</span>
        </div>
        <div class="flex items-start gap-2.5 bg-white p-3 rounded-xl border border-[#E8ECF4]">
            <span class="px-2 py-0.5 rounded-md bg-[#EEF2FF] text-[#3126C9] font-heading font-bold shrink-0">Admin</span>
            <span class="text-[#64748B]">ใช้งานได้ <strong class="text-[#1E293B]">ทุกเมนู</strong> และอนุมัติผู้ลงทะเบียนใหม่</span>
        </div>
    </div>

    {{-- แถบค้นหาและกรองข้อมูล --}}
    <div class="saas-card p-5 bg-white rounded-2xl border border-[#E8ECF4] saas-shadow">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-5">
                <label for="search" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    ค้นหาชื่อผู้ใช้งาน หรือ อีเมล
                </label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass text-[#64748B] text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text"
                           id="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="พิมพ์ชื่อ-นามสกุล หรืออีเมล..."
                           class="saas-input w-full !pl-9 !py-2.5 text-xs">
                </div>
            </div>

            <div class="md:col-span-2">
                <label for="status" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    สถานะบัญชี
                </label>
                <select id="status" name="status" class="saas-input w-full !py-2.5 !px-3.5 text-xs cursor-pointer">
                    <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>ทุกสถานะ</option>
                    <option value="waiting" {{ request('status') === 'waiting' ? 'selected' : '' }}>รออนุมัติ (Waiting)</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>อนุมัติแล้ว (Approved)</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>ระงับการใช้งาน</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label for="role" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                    ระดับสิทธิ์
                </label>
                <select id="role" name="role" class="saas-input w-full !py-2.5 !px-3.5 text-xs cursor-pointer">
                    <option value="all" {{ request('role', 'all') === 'all' ? 'selected' : '' }}>ทุกสิทธิ์</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User (ประชาสัมพันธ์/อัลบั้ม)</option>
                    <option value="editor" {{ request('role') === 'editor' ? 'selected' : '' }}>Editor (ทุกเมนูยกเว้นผู้ใช้)</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin (ทุกเมนู)</option>
                </select>
            </div>

            <div class="md:col-span-3 flex items-center gap-2">
                <button type="submit" class="btn-saas-primary flex-1 text-xs font-heading font-semibold !py-2.5 !px-4 cursor-pointer">
                    <i class="fa-solid fa-filter mr-1"></i> ค้นหา
                </button>
                @if(request()->filled('search') || (request()->filled('role') && request('role') !== 'all') || (request()->filled('status') && request('status') !== 'all'))
                    <a href="{{ route('admin.users.index') }}"
                       class="px-3.5 py-2.5 rounded-xl border border-[#E8ECF4] bg-[#F8FAFC] hover:bg-slate-100 text-[#64748B] text-xs font-heading font-semibold transition-colors">
                        ล้างค่า
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ตารางรายชื่อผู้ใช้งาน (Material Design 3 Clean Table) --}}
    <div class="saas-card bg-white rounded-2xl border border-[#E8ECF4] overflow-hidden saas-shadow">
        <div class="p-5 border-b border-[#E8ECF4] flex items-center justify-between">
            <h2 class="text-[16px] sm:text-[18px] font-heading font-semibold text-[#1E293B] m-0">
                รายชื่อผู้ใช้งานในระบบ
            </h2>
            <span class="text-xs text-[#64748B]">แสดง {{ $users->count() }} จากทั้งหมด {{ $users->total() }} รายการ</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFC] border-b border-[#E8ECF4] text-[#64748B] font-heading font-semibold">
                        <th class="p-4 w-14 text-center">#</th>
                        <th class="p-4">ผู้ใช้งาน</th>
                        <th class="p-4">อีเมลเข้าสู่ระบบ</th>
                        <th class="p-4 text-center">ระดับสิทธิ์</th>
                        <th class="p-4 text-center">สถานะอนุมัติ</th>
                        <th class="p-4">วันที่ลงทะเบียน</th>
                        <th class="p-4 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8ECF4] text-[#1E293B]">
                    @forelse($users as $index => $user)
                        @php
                            $isSelf = $user->id === auth()->id();
                            $roleMap = [
                                'admin'  => ['label' => 'Admin (ทุกเมนู)', 'class' => 'bg-[#EEF2FF] text-[#3126C9] border-[#3126C9]/20'],
                                'editor' => ['label' => 'Editor (ยกเว้นผู้ใช้)', 'class' => 'bg-sky-50 text-[#1675E8] border-sky-200'],
                                'user'   => ['label' => 'User (ข่าว/อัลบั้ม)', 'class' => 'bg-slate-100 text-[#64748B] border-slate-200'],
                            ];
                            $userRole = $user->role ?? 'user';
                            $roleInfo = $roleMap[$userRole] ?? $roleMap['user'];

                            $statusMap = [
                                'waiting'   => ['label' => 'รออนุมัติ (Waiting)', 'class' => 'bg-amber-50 text-[#B45309] border-amber-200', 'dot' => 'bg-[#F49A22] animate-pulse'],
                                'approved'  => ['label' => 'อนุมัติแล้ว (Approved)', 'class' => 'bg-emerald-50 text-[#13A678] border-emerald-200', 'dot' => 'bg-[#13A678]'],
                                'suspended' => ['label' => 'ระงับการใช้งาน', 'class' => 'bg-rose-50 text-rose-600 border-rose-200', 'dot' => 'bg-rose-500'],
                            ];
                            $userStatus = $user->status ?? 'waiting';
                            $statusInfo = $statusMap[$userStatus] ?? $statusMap['waiting'];
                        @endphp
                        <tr class="hover:bg-[#F8FAFC] transition-colors {{ $userStatus === 'waiting' ? 'bg-amber-50/30' : '' }}">
                            <td class="p-4 text-center text-[#64748B] font-heading">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#3126C9] to-[#1675E8] text-white font-heading font-bold text-sm grid place-items-center shrink-0">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-heading font-semibold text-sm text-[#1E293B] flex items-center gap-2">
                                            <span>{{ $user->name }}</span>
                                            @if($isSelf)
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-[#13A678] border border-emerald-200 text-[10px] font-heading">
                                                    คุณ (กำลังใช้งาน)
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-[#64748B]">ID: #{{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 font-medium text-[#1E293B]">
                                <i class="fa-regular fa-envelope text-[#1675E8] mr-1.5"></i>{{ $user->email }}
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <span class="inline-block px-2.5 py-1 rounded-full border text-[11px] font-heading font-semibold {{ $roleInfo['class'] }}">
                                    {{ $roleInfo['label'] }}
                                </span>
                            </td>
                            <td class="p-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[11px] font-heading font-semibold {{ $statusInfo['class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $statusInfo['dot'] }}"></span>
                                    {{ $statusInfo['label'] }}
                                </span>
                            </td>
                            <td class="p-4 text-[#64748B] whitespace-nowrap">
                                {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    {{-- ปุ่มอนุมัติด่วนสำหรับผู้ที่สถานะ waiting --}}
                                    @if($userStatus === 'waiting')
                                        <form method="POST"
                                              action="{{ route('admin.users.approve', $user) }}"
                                              onsubmit="return confirm('ยืนยันการอนุมัติผู้ใช้งาน {{ $user->name }} เข้าสู่ระบบหรือไม่?');"
                                              class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-xl bg-[#13A678] hover:bg-emerald-700 text-white text-xs font-heading font-semibold transition-colors cursor-pointer shadow-2xs">
                                                <i class="fa-solid fa-check mr-1"></i>อนุมัติ
                                            </button>
                                        </form>
                                    @endif

                                    <button type="button"
                                            onclick="openUserModal('edit', {{ Js::from([
                                                'id'      => $user->id,
                                                'name'    => $user->name,
                                                'email'   => $user->email,
                                                'role'    => $userRole,
                                                'status'  => $userStatus,
                                                'is_self' => $isSelf,
                                                'action'  => route('admin.users.update', $user),
                                            ]) }})"
                                            class="px-3 py-1.5 rounded-xl bg-[#EEF2FF] hover:bg-[#3126C9] text-[#3126C9] hover:text-white text-xs font-heading font-semibold transition-colors cursor-pointer">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i>แก้ไข
                                    </button>

                                    @if(!$isSelf)
                                        <form method="POST"
                                              action="{{ route('admin.users.destroy', $user) }}"
                                              onsubmit="return confirm('ยืนยันการลบผู้ใช้งาน {{ $user->name }} ออกจากระบบหรือไม่?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white text-xs font-heading font-semibold transition-colors cursor-pointer">
                                                <i class="fa-solid fa-trash-can mr-1"></i>ลบ
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-10 text-center text-[#64748B]">
                                <i class="fa-regular fa-user text-2xl text-slate-300 block mb-2"></i>
                                ไม่พบข้อมูลผู้ใช้งานตามเงื่อนไขที่ค้นหา
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-[#E8ECF4] bg-[#F8FAFC]">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- Modal เพิ่ม / แก้ไขผู้ใช้งาน --}}
    <div id="user-form-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 backdrop-blur-xs p-4">
        <div class="saas-card bg-white rounded-3xl border border-[#E8ECF4] w-full max-w-lg overflow-hidden saas-shadow-lg">
            <div class="px-6 py-4 bg-gradient-to-r from-[#3126C9] to-[#1675E8] text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <i id="modal-user-icon" class="fa-solid fa-user-plus"></i>
                    <h3 id="modal-user-title" class="text-base font-heading font-bold m-0">เพิ่มผู้ใช้งานใหม่</h3>
                </div>
                <button type="button" onclick="closeUserModal()" class="text-white/80 hover:text-white cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="user-modal-form" method="POST" action="{{ route('admin.users.store') }}" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="_method" id="user-form-method" value="POST">

                <div>
                    <label for="modal_name" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        ชื่อ - นามสกุล <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="modal_name"
                           name="name"
                           required
                           placeholder="เช่น นายกฤษณุ ครุ่นส้าว"
                           class="saas-input w-full !py-2.5 !px-3.5 text-xs">
                </div>

                <div>
                    <label for="modal_email" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                        อีเมลเข้าสู่ระบบ <span class="text-rose-500">*</span>
                    </label>
                    <input type="email"
                           id="modal_email"
                           name="email"
                           required
                           placeholder="name@ssophosai.in.th"
                           class="saas-input w-full !py-2.5 !px-3.5 text-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label for="modal_role" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                            ระดับสิทธิ์การใช้งาน <span class="text-rose-500">*</span>
                        </label>
                        <select id="modal_role" name="role" class="saas-input w-full !py-2.5 !px-3.5 text-xs cursor-pointer">
                            <option value="user">User (ประชาสัมพันธ์, อัลบั้มกิจกรรม)</option>
                            <option value="editor">Editor (ทุกเมนู ยกเว้นจัดการผู้ใช้)</option>
                            <option value="admin">Admin (ใช้งานได้ทุกเมนู)</option>
                        </select>
                    </div>

                    <div id="modal-status-wrapper">
                        <label for="modal_status" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                            สถานะการอนุมัติ <span class="text-rose-500">*</span>
                        </label>
                        <select id="modal_status" name="status" class="saas-input w-full !py-2.5 !px-3.5 text-xs cursor-pointer">
                            <option value="approved">อนุมัติแล้ว (Approved)</option>
                            <option value="waiting">รออนุมัติ (Waiting)</option>
                            <option value="suspended">ระงับการใช้งาน (Suspended)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                    <div>
                        <label for="modal_password" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                            รหัสผ่าน <span id="password-req-star" class="text-rose-500">*</span>
                        </label>
                        <input type="password"
                               id="modal_password"
                               name="password"
                               minlength="8"
                               placeholder="อย่างน้อย 8 ตัวอักษร"
                               class="saas-input w-full !py-2.5 !px-3.5 text-xs">
                    </div>

                    <div>
                        <label for="modal_password_confirmation" class="block text-xs font-heading font-semibold text-[#1E293B] mb-1.5">
                            ยืนยันรหัสผ่าน <span id="password-confirm-star" class="text-rose-500">*</span>
                        </label>
                        <input type="password"
                               id="modal_password_confirmation"
                               name="password_confirmation"
                               minlength="8"
                               placeholder="กรอกรหัสผ่านอีกครั้ง"
                               class="saas-input w-full !py-2.5 !px-3.5 text-xs">
                    </div>
                </div>

                <p id="password-edit-hint" class="hidden text-[11px] text-[#64748B] m-0">
                    <i class="fa-solid fa-circle-info text-[#1675E8] mr-1"></i>เว้นว่างช่องรหัสผ่านไว้ หากไม่ต้องการเปลี่ยนรหัสผ่านเดิม
                </p>

                <div class="pt-4 border-t border-[#E8ECF4] flex items-center justify-end gap-2.5">
                    <button type="button"
                            onclick="closeUserModal()"
                            class="px-4 py-2.5 rounded-xl border border-[#E8ECF4] bg-[#F8FAFC] hover:bg-slate-100 text-[#64748B] text-xs font-heading font-semibold cursor-pointer">
                        ยกเลิก
                    </button>
                    <button type="submit"
                            class="btn-saas-primary text-xs font-heading font-semibold !py-2.5 !px-5 cursor-pointer">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const userModal = document.getElementById('user-form-modal');
    const userForm = document.getElementById('user-modal-form');
    const methodInput = document.getElementById('user-form-method');
    const modalTitle = document.getElementById('modal-user-title');
    const modalIcon = document.getElementById('modal-user-icon');
    const nameInput = document.getElementById('modal_name');
    const emailInput = document.getElementById('modal_email');
    const roleSelect = document.getElementById('modal_role');
    const statusSelect = document.getElementById('modal_status');
    const passInput = document.getElementById('modal_password');
    const passConfirmInput = document.getElementById('modal_password_confirmation');
    const passStar = document.getElementById('password-req-star');
    const passConfirmStar = document.getElementById('password-confirm-star');
    const passEditHint = document.getElementById('password-edit-hint');

    function openUserModal(mode, userData = null) {
        userForm.reset();

        if (mode === 'edit' && userData) {
            userForm.action = userData.action;
            methodInput.value = 'PUT';
            modalTitle.textContent = 'แก้ไขข้อมูลและสิทธิ์ผู้ใช้งาน';
            modalIcon.className = 'fa-solid fa-user-pen';

            nameInput.value = userData.name || '';
            emailInput.value = userData.email || '';
            roleSelect.value = userData.role || 'user';
            statusSelect.value = userData.status || 'waiting';

            roleSelect.disabled = !!userData.is_self;
            statusSelect.disabled = !!userData.is_self;

            passInput.required = false;
            passConfirmInput.required = false;
            passStar.classList.add('hidden');
            passConfirmStar.classList.add('hidden');
            passEditHint.classList.remove('hidden');
        } else {
            userForm.action = "{{ route('admin.users.store') }}";
            methodInput.value = 'POST';
            modalTitle.textContent = 'เพิ่มผู้ใช้งานใหม่';
            modalIcon.className = 'fa-solid fa-user-plus';

            roleSelect.value = 'user';
            statusSelect.value = 'approved';
            roleSelect.disabled = false;
            statusSelect.disabled = false;

            passInput.required = true;
            passConfirmInput.required = true;
            passStar.classList.remove('hidden');
            passConfirmStar.classList.remove('hidden');
            passEditHint.classList.add('hidden');
        }

        userModal.classList.remove('hidden');
        userModal.classList.add('flex');
    }

    function closeUserModal() {
        userModal.classList.add('hidden');
        userModal.classList.remove('flex');
    }

    userModal.addEventListener('click', function (e) {
        if (e.target === userModal) {
            closeUserModal();
        }
    });
</script>
@endpush
