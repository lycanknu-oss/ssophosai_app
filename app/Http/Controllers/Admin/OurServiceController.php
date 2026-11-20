<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OurService;
use Illuminate\Http\Request;

class OurServiceController extends Controller
{
    public function index()
    {
        $services = OurService::orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon'        => ['required', 'string', 'max:100'],
            'badge_color' => ['required', 'in:purple,blue,green,orange'],
            'link_url'    => ['nullable', 'string', 'max:500'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        OurService::create([
            'title'       => $validated['title'],
            'subtitle'    => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'],
            'badge_color' => $validated['badge_color'],
            'link_url'    => $validated['link_url'] ?? null,
            'is_external' => $request->boolean('is_external'),
            'sort_order'  => $validated['sort_order'] ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'เพิ่มรายการบริการเรียบร้อยแล้ว');
    }

    public function update(Request $request, OurService $service)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon'        => ['required', 'string', 'max:100'],
            'badge_color' => ['required', 'in:purple,blue,green,orange'],
            'link_url'    => ['nullable', 'string', 'max:500'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
        ]);

        $service->update([
            'title'       => $validated['title'],
            'subtitle'    => $validated['subtitle'] ?? null,
            'description' => $validated['description'] ?? null,
            'icon'        => $validated['icon'],
            'badge_color' => $validated['badge_color'],
            'link_url'    => $validated['link_url'] ?? null,
            'is_external' => $request->boolean('is_external'),
            'sort_order'  => $validated['sort_order'] ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'อัปเดตข้อมูลบริการเรียบร้อยแล้ว');
    }

    public function destroy(OurService $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'ลบรายการบริการเรียบร้อยแล้ว');
    }
}
