<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Executive;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicityController extends Controller
{
    // แสดงหน้าจัดการภาพประชาสัมพันธ์และผู้บริหาร
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderByDesc('id')->get();
        $executives = Executive::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.publicity.index', compact('slides', 'executives'));
    }

    // ================= ส่วนจัดการภาพประชาสัมพันธ์ (Hero Slideshow) =================

    public function storeSlide(Request $request)
    {
        $isPopup = $request->boolean('is_popup');

        // หากติ๊กออกแจ้งเตือนผ่าน Popup ให้ยกเลิกการแจ้งเตือนของรายการเก่า เพื่อแสดงประกาศเด่นเพียงรายการเดียว
        if ($isPopup) {  HeroSlide::where('is_popup', true)->update(['is_popup' => false]); }

        $data['is_popup'] = $isPopup;

        $validated = $request->validate([
            'badge' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'กรุณากรอกหัวข้อหลักบนสไลด์',
            'image.required' => 'กรุณาอัปโหลดรูปภาพประชาสัมพันธ์',
            'image.image' => 'ไฟล์ที่อัปโหลดต้องเป็นรูปภาพเท่านั้น',
            'image.max' => 'ขนาดรูปภาพต้องไม่เกิน 4MB',
        ]);

        $path = $request->file('image')->store('uploads/slides', 'public');

        HeroSlide::create([
            'badge' => $validated['badge'] ?? 'ประชาสัมพันธ์',
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'image_path' => 'storage/' . $path,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'is_popup' => $isPopup,
        ]);

        return back()->with('success', 'เพิ่มภาพประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    public function updateSlide(Request $request, HeroSlide $slide)
    {
        $isPopup = $request->boolean('is_popup');

        // หากติ๊กออกแจ้งเตือนผ่าน Popup ให้ยกเลิกการแจ้งเตือนของรายการเก่า เพื่อแสดงประกาศเด่นเพียงรายการเดียว
        if ($isPopup) { HeroSlide::where('is_popup', true)->update(['is_popup' => false]); }

        $data['is_popup'] = $isPopup;

        $validated = $request->validate([
            'badge' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = [
            'badge' => $validated['badge'],
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
            'is_popup' => $isPopup,
        ];

        if ($request->hasFile('image')) {
            if ($slide->image_path && str_starts_with($slide->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $slide->image_path));
            }
            $path = $request->file('image')->store('uploads/slides', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $slide->update($data);

        return back()->with('success', 'อัปเดตข้อมูลภาพประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    public function destroySlide(HeroSlide $slide)
    {
        if ($slide->image_path && str_starts_with($slide->image_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $slide->image_path));
        }
        $slide->delete();

        return back()->with('success', 'ลบภาพประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    // ================= ส่วนจัดการผู้บริหารองค์กร (Executives) =================

    // ================= ส่วนจัดการผู้บริหารองค์กร (Executives) =================

    public function storeExecutive(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'กรุณากรอกชื่อ-นามสกุลผู้บริหาร',
            'position.required' => 'กรุณากรอกตำแหน่งผู้บริหาร',
            'end_date.after_or_equal' => 'วันที่สิ้นสุดการดำรงตำแหน่งต้องไม่ก่อนวันที่เข้ารับตำแหน่ง',
            'image.required' => 'กรุณาอัปโหลดรูปภาพผู้บริหาร',
        ]);

        $path = $request->file('image')->store('uploads/executives', 'public');

        Executive::create([
            'name' => $validated['name'],
            'position' => $validated['position'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'image_path' => 'storage/' . $path,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'เพิ่มข้อมูลผู้บริหารเรียบร้อยแล้ว');
    }

    public function updateExecutive(Request $request, Executive $executive)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'end_date.after_or_equal' => 'วันที่สิ้นสุดการดำรงตำแหน่งต้องไม่ก่อนวันที่เข้ารับตำแหน่ง',
        ]);

        $data = [
            'name' => $validated['name'],
            'position' => $validated['position'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($executive->image_path && str_starts_with($executive->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $executive->image_path));
            }
            $path = $request->file('image')->store('uploads/executives', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $executive->update($data);

        return back()->with('success', 'อัปเดตข้อมูลผู้บริหารเรียบร้อยแล้ว');
    }

    public function destroyExecutive(Executive $executive)
    {
        if ($executive->image_path && str_starts_with($executive->image_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $executive->image_path));
        }
        $executive->delete();

        return back()->with('success', 'ลบข้อมูลผู้บริหารเรียบร้อยแล้ว');
    }
}
