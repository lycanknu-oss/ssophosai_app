<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // เรียงผู้ที่รออนุมัติ (waiting) ขึ้นบนสุดเพื่อให้ Admin เห็นและอนุมัติได้ทันที
        $users = $query
            ->orderByRaw("CASE WHEN status = 'waiting' THEN 0 WHEN status = 'approved' THEN 1 ELSE 2 END ASC")
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total'    => User::count(),
            'waiting'  => User::where('status', 'waiting')->count(),
            'approved' => User::where('status', 'approved')->count(),
            'admins'   => User::where('role', 'admin')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => ['required', 'string', 'in:admin,editor,user'],
            'status'   => ['required', 'string', 'in:waiting,approved,suspended'],
        ], [
            'name.required'      => 'กรุณาระบุชื่อ - นามสกุลผู้ใช้งาน',
            'username.required'  => 'กรุณาระบุชื่อผู้ใช้งาน',
            'email.required'     => 'กรุณาระบุอีเมลสำหรับเข้าสู่ระบบ',
            'email.unique'       => 'อีเมลนี้ถูกใช้งานในระบบแล้ว',
            'password.required'  => 'กรุณากำหนดรหัสผ่าน',
            'password.confirmed' => 'ยืนยันรหัสผ่านไม่ตรงกัน',
            'password.min'       => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
            'status'   => $validated['status'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'เพิ่มผู้ใช้งาน "' . $validated['name'] . '" เรียบร้อยแล้ว');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role'     => ['required', 'string', 'in:admin,editor,user'],
            'status'   => ['required', 'string', 'in:waiting,approved,suspended'],
        ], [
            'name.required'      => 'กรุณาระบุชื่อ - นามสกุลผู้ใช้งาน',
            'username.required'  => 'กรุณาระบุชื่อผู้ใช้งาน',
            'email.required'     => 'กรุณาระบุอีเมลสำหรับเข้าสู่ระบบ',
            'email.unique'       => 'อีเมลนี้ถูกใช้งานในระบบแล้ว',
            'password.confirmed' => 'ยืนยันรหัสผ่านไม่ตรงกัน',
            'password.min'       => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
        ]);

        // ป้องกันไม่ให้ Admin ลดสิทธิ์หรือระงับบัญชีตัวเองที่กำลังล็อกอิน
        if ($user->id === auth()->id()) {
            $validated['role']   = 'admin';
            $validated['status'] = 'approved';
        }

        $data = [
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'role'   => $validated['role'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'อัปเดตข้อมูลและสิทธิ์ของ "' . $user->name . '" เรียบร้อยแล้ว');
    }

    /**
     * ปุ่มอนุมัติการลงทะเบียนด่วน (เปลี่ยนสถานะจาก waiting เป็น approved)
     */
    public function approve(Request $request, User $user)
    {
        $role = $request->input('role', $user->role ?: 'user');
        if (!in_array($role, ['admin', 'editor', 'user'], true)) {
            $role = 'user';
        }

        $user->update([
            'status' => 'approved',
            'role'   => $role,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'อนุมัติบัญชีผู้ใช้งาน "' . $user->name . '" เรียบร้อยแล้ว');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'ไม่สามารถลบบัญชีผู้ใช้งานที่กำลังเข้าสู่ระบบอยู่ได้');
        }

        $deletedName = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'ลบผู้ใช้งาน "' . $deletedName . '" เรียบร้อยแล้ว');
    }
}
