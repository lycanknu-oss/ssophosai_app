<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * แสดงหน้ารายการจัดการข่าวประชาสัมพันธ์ พร้อมตัวกรองหมวดหมู่และคำค้นหา
     */
    public function index(Request $request)
    {
        $query = Activity::query();

        // กรองตามหมวดหมู่ (general, recruitment, procurement)
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // ค้นหาจากหัวข้อข่าวหรือสรุปย่อ
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        $activities = $query->orderByDesc('is_pinned')
            ->orderByDesc('published_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        // สรุปจำนวนข่าวแต่ละหมวดหมู่สำหรับแสดงบนการ์ดด้านบน
        $counts = [
            'all'         => Activity::count(),
            'general'     => Activity::where('category', 'general')->count(),
            'recruitment' => Activity::where('category', 'recruitment')->count(),
            'procurement' => Activity::where('category', 'procurement')->count(),
        ];

        return view('admin.activities.index', compact('activities', 'counts'));
    }

    /**
     * บันทึกข่าวประชาสัมพันธ์ใหม่
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category'       => ['required', 'in:general,recruitment,procurement'],
            'title'          => ['required', 'string', 'max:255'],
            'summary'        => ['nullable', 'string', 'max:500'],
            'content'        => ['nullable', 'string'],
            'published_date' => ['required', 'date'],
            'cover_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'attachment'     => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:10240'],
        ], [
            'category.required'       => 'กรุณาเลือกหมวดหมู่ข่าว',
            'title.required'          => 'กรุณากรอกหัวข้อข่าวประชาสัมพันธ์',
            'published_date.required' => 'กรุณาระบุวันที่เผยแพร่',
            'cover_image.image'       => 'รูปภาพหน้าปกต้องเป็นไฟล์รูปภาพเท่านั้น',
            'cover_image.max'         => 'ขนาดรูปภาพหน้าปกต้องไม่เกิน 4MB',
            'attachment.mimes'        => 'ไฟล์เอกสารแนบต้องเป็น PDF, DOCX, XLSX หรือ ZIP เท่านั้น',
            'attachment.max'          => 'ขนาดไฟล์เอกสารแนบต้องไม่เกิน 10MB',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('uploads/activities/covers', 'public');
            $coverPath = 'storage/' . $path;
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('uploads/activities/files', 'public');
            $attachmentPath = 'storage/' . $path;
        }

        Activity::create([
            'category'        => $validated['category'],
            'title'           => $validated['title'],
            'summary'         => $validated['summary'] ?? null,
            'content'         => $validated['content'] ?? null,
            'published_date'  => $validated['published_date'],
            'cover_image'     => $coverPath,
            'attachment_path' => $attachmentPath,
            'is_pinned'       => $request->boolean('is_pinned'),
            'is_active'       => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'เพิ่มข่าวประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    /**
     * อัปเดตข้อมูลข่าวประชาสัมพันธ์
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'category'       => ['required', 'in:general,recruitment,procurement'],
            'title'          => ['required', 'string', 'max:255'],
            'summary'        => ['nullable', 'string', 'max:500'],
            'content'        => ['nullable', 'string'],
            'published_date' => ['required', 'date'],
            'cover_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'attachment'     => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,zip', 'max:10240'],
        ], [
            'category.required'       => 'กรุณาเลือกหมวดหมู่ข่าว',
            'title.required'          => 'กรุณากรอกหัวข้อข่าวประชาสัมพันธ์',
            'published_date.required' => 'กรุณาระบุวันที่เผยแพร่',
            'cover_image.image'       => 'รูปภาพหน้าปกต้องเป็นไฟล์รูปภาพเท่านั้น',
            'cover_image.max'         => 'ขนาดรูปภาพหน้าปกต้องไม่เกิน 4MB',
            'attachment.mimes'        => 'ไฟล์เอกสารแนบต้องเป็น PDF, DOCX, XLSX หรือ ZIP เท่านั้น',
            'attachment.max'          => 'ขนาดไฟล์เอกสารแนบต้องไม่เกิน 10MB',
        ]);

        $data = [
            'category'       => $validated['category'],
            'title'          => $validated['title'],
            'summary'        => $validated['summary'] ?? null,
            'content'        => $validated['content'] ?? null,
            'published_date' => $validated['published_date'],
            'is_pinned'      => $request->boolean('is_pinned'),
            'is_active'      => $request->boolean('is_active'),
        ];

        // อัปเดตรูปภาพหน้าปกใหม่ (ลบไฟล์เก่าออกถ้ามี)
        if ($request->hasFile('cover_image')) {
            if ($activity->cover_image && str_starts_with($activity->cover_image, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $activity->cover_image));
            }
            $path = $request->file('cover_image')->store('uploads/activities/covers', 'public');
            $data['cover_image'] = 'storage/' . $path;
        }

        // อัปเดตไฟล์เอกสารแนบใหม่ (ลบไฟล์เก่าออกถ้ามี)
        if ($request->hasFile('attachment')) {
            if ($activity->attachment_path && str_starts_with($activity->attachment_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $activity->attachment_path));
            }
            $path = $request->file('attachment')->store('uploads/activities/files', 'public');
            $data['attachment_path'] = 'storage/' . $path;
        }

        $activity->update($data);

        return back()->with('success', 'อัปเดตข่าวประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    /**
     * ลบข่าวประชาสัมพันธ์และไฟล์แนบที่เกี่ยวข้อง
     */
    public function destroy(Activity $activity)
    {
        if ($activity->cover_image && str_starts_with($activity->cover_image, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $activity->cover_image));
        }

        if ($activity->attachment_path && str_starts_with($activity->attachment_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $activity->attachment_path));
        }

        $activity->delete();

        return back()->with('success', 'ลบข่าวประชาสัมพันธ์เรียบร้อยแล้ว');
    }
}
