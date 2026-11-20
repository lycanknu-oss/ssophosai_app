<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::withCount('photos')
            ->orderByDesc('activity_date')
            ->orderByDesc('id')
            ->paginate(9);

        return view('admin.albums.index', compact('albums'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'photos.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'title.required' => 'กรุณากรอกชื่ออัลบั้มกิจกรรม',
            'activity_date.required' => 'กรุณาระบุวันที่จัดกิจกรรม',
            'cover_image.image' => 'ไฟล์หน้าปกต้องเป็นรูปภาพเท่านั้น',
            'photos.*.image' => 'ไฟล์รูปภาพในอัลบั้มต้องเป็นรูปภาพเท่านั้น',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('uploads/albums/covers', 'public');
            $coverPath = 'storage/' . $path;
        }

        $album = Album::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'activity_date' => $validated['activity_date'],
            'cover_image' => $coverPath,
            'is_active' => $request->boolean('is_active', true),
        ]);

        // อัปโหลดรูปภาพหลายรูปพร้อมกัน (ถ้ามีการเลือกไฟล์)
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photoFile) {
                $photoPath = $photoFile->store("uploads/albums/{$album->id}", 'public');
                $savedPath = 'storage/' . $photoPath;

                AlbumPhoto::create([
                    'album_id' => $album->id,
                    'image_path' => $savedPath,
                    'sort_order' => $index,
                ]);

                // หากไม่ได้อัปโหลดรูปหน้าปกแยก ให้ใช้รูปแรกเป็นหน้าปกอัตโนมัติ
                if (!$album->cover_image && $index === 0) {
                    $album->update(['cover_image' => $savedPath]);
                }
            }
        }

        return back()->with('success', 'สร้างอัลบั้มกิจกรรมเรียบร้อยแล้ว');
    }

    public function show(Album $album)
    {
        $album->load('photos');

        return view('admin.albums.show', compact('album'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'activity_date' => ['required', 'date'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'activity_date' => $validated['activity_date'],
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image && str_starts_with($album->cover_image, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $album->cover_image));
            }
            $path = $request->file('cover_image')->store('uploads/albums/covers', 'public');
            $data['cover_image'] = 'storage/' . $path;
        }

        $album->update($data);

        return back()->with('success', 'อัปเดตข้อมูลอัลบั้มกิจกรรมเรียบร้อยแล้ว');
    }

    public function uploadPhotos(Request $request, Album $album)
    {
        $request->validate([
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'photos.required' => 'กรุณาเลือกรูปภาพอย่างน้อย 1 รูป',
            'photos.*.image' => 'ไฟล์ที่อัปโหลดต้องเป็นรูปภาพเท่านั้น',
            'photos.*.max' => 'ขนาดรูปภาพแต่ละไฟล์ต้องไม่เกิน 4MB',
        ]);

        $maxOrder = $album->photos()->max('sort_order') ?? 0;

        foreach ($request->file('photos') as $index => $photoFile) {
            $photoPath = $photoFile->store("uploads/albums/{$album->id}", 'public');
            $savedPath = 'storage/' . $photoPath;

            AlbumPhoto::create([
                'album_id' => $album->id,
                'image_path' => $savedPath,
                'sort_order' => $maxOrder + $index + 1,
            ]);

            if (!$album->cover_image && $index === 0) {
                $album->update(['cover_image' => $savedPath]);
            }
        }

        return back()->with('success', 'เพิ่มรูปภาพเข้าสู่อัลบั้มเรียบร้อยแล้ว');
    }

    public function setCover(Album $album, AlbumPhoto $photo)
    {
        if ($photo->album_id === $album->id) {
            $album->update(['cover_image' => $photo->image_path]);
        }

        return back()->with('success', 'ตั้งค่ารูปภาพหน้าปกอัลบั้มเรียบร้อยแล้ว');
    }

    public function destroyPhoto(Album $album, AlbumPhoto $photo)
    {
        if ($photo->album_id === $album->id) {
            if ($photo->image_path && str_starts_with($photo->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $photo->image_path));
            }
            $photo->delete();
        }

        return back()->with('success', 'ลบรูปภาพออกจากอัลบั้มเรียบร้อยแล้ว');
    }

    public function destroy(Album $album)
    {
        foreach ($album->photos as $photo) {
            if ($photo->image_path && str_starts_with($photo->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $photo->image_path));
            }
        }

        if ($album->cover_image && str_starts_with($album->cover_image, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $album->cover_image));
        }

        $album->delete();

        return redirect()->route('admin.albums.index')->with('success', 'ลบอัลบั้มกิจกรรมเรียบร้อยแล้ว');
    }
}
