<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shortcut;
use Illuminate\Http\Request;

class ShortcutController extends Controller
{
    public function index()
    {
        $shortcuts = Shortcut::orderBy('sort_order')->orderByDesc('id')->get();

        return view('admin.shortcuts.index', compact('shortcuts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:100'],
            'color_theme' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'กรุณากรอกชื่อทางลัดข้อมูลที่น่าสนใจ',
            'url.required' => 'กรุณากรอกลิงก์ปลายทาง (URL)',
        ]);

        Shortcut::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'url' => $validated['url'],
            'icon' => $validated['icon'] ?: 'fa-solid fa-link',
            'color_theme' => $validated['color_theme'] ?: 'indigo',
            'open_new_tab' => $request->boolean('open_new_tab'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'เพิ่มทางลัดข้อมูลที่น่าสนใจเรียบร้อยแล้ว');
    }

    public function update(Request $request, Shortcut $shortcut)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:500'],
            'icon' => ['nullable', 'string', 'max:100'],
            'color_theme' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'กรุณากรอกชื่อทางลัดข้อมูลที่น่าสนใจ',
            'url.required' => 'กรุณากรอกลิงก์ปลายทาง (URL)',
        ]);

        $shortcut->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'url' => $validated['url'],
            'icon' => $validated['icon'] ?: 'fa-solid fa-link',
            'color_theme' => $validated['color_theme'] ?: 'indigo',
            'open_new_tab' => $request->boolean('open_new_tab'),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'อัปเดตข้อมูลทางลัดเรียบร้อยแล้ว');
    }

    public function destroy(Shortcut $shortcut)
    {
        $shortcut->delete();

        return back()->with('success', 'ลบรายการทางลัดเรียบร้อยแล้ว');
    }
}
