<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // แสดงหน้าเข้าสู่ระบบ
    public function showLogin()
    {
        if (Auth::check()) {
            if ((Auth::user()->status ?? 'approved') === 'approved') {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
        }

        return view('auth.login');
    }

    // ตรวจสอบการเข้าสู่ระบบด้วย username และ password
    public function checkLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้งาน (Username)',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'username' => trim($credentials['username']),
            'password' => $credentials['password'],
        ], $remember)) {
            $user = Auth::user();
            $status = $user->status ?? 'approved';

            // 1. กรณีสถานะรออนุมัติ (waiting)
            if ($status === 'waiting') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'username' => 'บัญชีของท่านอยู่ระหว่างรออนุมัติ (Waiting) กรุณารอผู้ดูแลระบบ (Admin) อนุมัติก่อนเข้าใช้งาน',
                ])->onlyInput('username');
            }

            // 2. กรณีถูกระงับสิทธิ์ (suspended)
            if ($status !== 'approved') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'username' => 'บัญชีของท่านถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแลระบบ',
                ])->onlyInput('username');
            }

            // 3. ผ่านการอนุมัติแล้ว
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'เข้าสู่ระบบเรียบร้อยแล้ว');
        }

        return back()->withErrors([
            'username' => 'ชื่อผู้ใช้งาน (Username) หรือรหัสผ่านไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง',
        ])->onlyInput('username');
    }

    // แสดงหน้าสมัครสมาชิก
    public function showRegister()
    {
        if (Auth::check()) {
            if ((Auth::user()->status ?? 'approved') === 'approved') {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
        }

        return view('auth.register');
    }

    // บันทึกข้อมูลสมัครสมาชิก (กำหนด username, role = user และ status = waiting)
    public function storeRegister(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'min:4', 'max:50', 'unique:users,username'],
            'email'    => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'       => 'กรุณาระบุชื่อ - นามสกุล',
            'username.required'   => 'กรุณากำหนดชื่อผู้ใช้งาน (Username)',
            'username.alpha_dash' => 'ชื่อผู้ใช้งานใช้ได้เฉพาะตัวอักษรภาษาอังกฤษ ตัวเลข ขีดกลาง (-) และขีดล่าง (_)',
            'username.min'        => 'ชื่อผู้ใช้งานต้องมีอย่างน้อย 4 ตัวอักษร',
            'username.unique'     => 'ชื่อผู้ใช้งาน (Username) นี้ถูกใช้งานแล้ว',
            'email.email'         => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.unique'        => 'อีเมลนี้ถูกลงทะเบียนในระบบแล้ว',
            'password.required'   => 'กรุณากำหนดรหัสผ่าน',
            'password.confirmed'  => 'ยืนยันรหัสผ่านไม่ตรงกัน',
            'password.min'        => 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษร',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => strtolower(trim($request->username)),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
            'status'   => 'waiting',
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'ลงทะเบียนสำเร็จ! บัญชีของท่านอยู่ในสถานะ "รออนุมัติ (Waiting)" กรุณารอผู้ดูแลระบบอนุมัติก่อนเข้าสู่ระบบ');
    }

    // แสดงหน้า Admin Dashboard
    public function adminDashboard()
    {
        return view('admin.dashboard', [
            'user'         => Auth::user(),
            'totalUsers'   => User::count(),
            'waitingUsers' => User::where('status', 'waiting')->count(),
        ]);
    }

    // ออกจากระบบ
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
    }
}
