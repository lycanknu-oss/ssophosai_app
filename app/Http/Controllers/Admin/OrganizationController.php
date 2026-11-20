<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationContent;
use App\Models\OrganizationExecutive;
use App\Models\OrganizationJob;
use App\Models\OrganizationStaff;
use App\Models\OrganizationWorkgroup;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $sections = OrganizationContent::sections();
        $contents = OrganizationContent::all()->keyBy('section_key');

        // หมวดที่ 2: ผู้บริหาร
        $executives = OrganizationExecutive::orderByDesc('start_year')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        // หมวดที่ 3: เจ้าหน้าที่ + ข้อมูลกลุ่มงานและงานจากฐานข้อมูล
        $priorityGroups  = OrganizationStaff::priorityGroups();
        $employmentTypes = OrganizationStaff::employmentTypes();

        $workgroups = OrganizationWorkgroup::with('jobs')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $jobs = OrganizationJob::where('is_active', true)
            ->orderBy('workgroup_id')
            ->orderBy('sort_order')
            ->get();

        $staffQuery = OrganizationStaff::with(['workgroup', 'job'])
            ->orderBy('workgroup_priority', 'asc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc');

        if ($request->filled('priority') && $request->priority !== 'all') {
            $staffQuery->where('workgroup_priority', (int) $request->priority);
        }

        $staffs = $staffQuery->get();

        // รายชื่อตำแหน่งสำหรับ Autocomplete
        $defaultPositions = [
            'สาธารณสุขอำเภอ',
            'นักวิชาการสาธารณสุขทรงคุณวุฒิ',
            'นักวิชาการสาธารณสุขเชี่ยวชาญ',
            'นักวิชาการสาธารณสุขชำนาญการพิเศษ',
            'นักวิชาการสาธารณสุขชำนาญการ',
            'นักวิชาการสาธารณสุขปฏิบัติการ',
            'นักวิชาการสาธารณสุข',
            'นักสาธารณสุขชำนาญการพิเศษ',
            'นักสาธารณสุขชำนาญการ',
            'นักสาธารณสุขปฏิบัติการ',
            'นักสาธารณสุข',
            'พยาบาลวิชาชีพชำนาญการพิเศษ',
            'พยาบาลวิชาชีพชำนาญการ',
            'พยาบาลวิชาชีพปฏิบัติการ',
            'พยาบาลวิชาชีพ',
            'เจ้าพนักงานสาธารณสุขอาวุโส',
            'เจ้าพนักงานสาธารณสุขชำนาญงาน',
            'เจ้าพนักงานสาธารณสุขปฏิบัติงาน',
            'เจ้าพนักงานสาธารณสุข',
            'นักวิชาการเงินและบัญชีชำนาญการ',
            'นักวิชาการเงินและบัญชีปฏิบัติการ',
            'นักวิชาการเงินและบัญชี',
            'เจ้าพนักงานการเงินและบัญชีชำนาญงาน',
            'เจ้าพนักงานการเงินและบัญชีปฏิบัติงาน',
            'เจ้าพนักงานการเงินและบัญชี',
            'นักวิชาการคอมพิวเตอร์ชำนาญการ',
            'นักวิชาการคอมพิวเตอร์ปฏิบัติการ',
            'นักวิชาการคอมพิวเตอร์',
            'เจ้าพนักงานธุรการชำนาญงาน',
            'เจ้าพนักงานธุรการปฏิบัติงาน',
            'เจ้าพนักงานธุรการ',
            'เจ้าพนักงานทันตสาธารณสุขชำนาญงาน',
            'เจ้าพนักงานทันตสาธารณสุขปฏิบัติงาน',
            'เจ้าพนักงานทันตสาธารณสุข',
            'เจ้าพนักงานเภสัชกรรมชำนาญงาน',
            'เจ้าพนักงานเภสัชกรรมปฏิบัติงาน',
            'เจ้าพนักงานเภสัชกรรม',
            'นักวิชาการพัสดุปฏิบัติการ',
            'นักวิชาการพัสดุ',
            'เจ้าพนักงานพัสดุชำนาญงาน',
            'เจ้าพนักงานพัสดุปฏิบัติงาน',
            'เจ้าพนักงานพัสดุ',
            'นักจัดการงานทั่วไปชำนาญการ',
            'นักจัดการงานทั่วไปปฏิบัติการ',
            'นักจัดการงานทั่วไป',
            'แพทย์แผนไทยปฏิบัติการ',
            'แพทย์แผนไทย',
            'นักกายภาพบำบัดปฏิบัติการ',
            'นักกายภาพบำบัด',
            'พนักงานช่วยเหลือคนไข้',
            'พนักงานขับรถยนต์',
            'พนักงานบริการ',
        ];

        $existingPositions = OrganizationStaff::whereNotNull('position')
            ->where('position', '!=', '')
            ->distinct()
            ->pluck('position')
            ->toArray();

        $positionSuggestions = collect(array_merge($defaultPositions, $existingPositions))
            ->unique()
            ->values();

        // หมวดที่ 4: ข้อมูลพื้นฐานเว็บ
        $siteSettings = [
            'org_name_th'       => SiteSetting::getValue('site_org_name_th', 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร'),
            'address'           => SiteSetting::getValue('site_address', 'หมู่ที่ 2 ตำบลโพธิ์ไทร อำเภอโพธิ์ไทร จังหวัดอุบลราชธานี 34340'),
            'phone'             => SiteSetting::getValue('site_phone', '045-496-067'),
            'hours_weekday'     => SiteSetting::getValue('site_hours_weekday', 'วันจันทร์ - วันศุกร์ เวลา 08.30 - 16.30 น.'),
            'hours_weekend'     => SiteSetting::getValue('site_hours_weekend', 'วันเสาร์ - วันอาทิตย์ และวันหยุดนักขัตฤกษ์ ปิดทำการ'),
            'google_map_iframe' => SiteSetting::getValue('site_google_map_iframe', ''),
        ];

        return view('admin.organization.index', compact(
            'sections',
            'contents',
            'executives',
            'priorityGroups',
            'employmentTypes',
            'workgroups',
            'jobs',
            'positionSuggestions',
            'staffs',
            'siteSettings'
        ));
    }

    // ==================== หมวดที่ 1: บันทึกเนื้อหาและรูปภาพ ====================
    public function saveContent(Request $request, string $sectionKey)
    {
        $sections = OrganizationContent::sections();
        abort_unless(array_key_exists($sectionKey, $sections), 404);

        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'content'      => ['nullable', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ], [
            'title.required' => 'กรุณากรอกหัวข้อเรื่อง',
            'image.image'    => 'ไฟล์ที่อัปโหลดต้องเป็นรูปภาพเท่านั้น',
            'image.max'      => 'ขนาดรูปภาพต้องไม่เกิน 5MB',
        ]);

        $record = OrganizationContent::firstOrNew(['section_key' => $sectionKey]);
        $record->title = $validated['title'];
        $record->content = $validated['content'] ?? null;
        $record->updated_by = Auth::id();

        if ($request->boolean('remove_image') && $record->image_path) {
            $this->deletePublicFile($record->image_path);
            $record->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($record->image_path) {
                $this->deletePublicFile($record->image_path);
            }
            $path = $request->file('image')->store('uploads/organization/sections', 'public');
            $record->image_path = 'storage/' . $path;
        }

        $record->save();

        return back()
            ->with('active_tab', 'tab-cat-1')
            ->with('active_sub', $sectionKey)
            ->with('success', "บันทึกข้อมูล \"{$sections[$sectionKey]}\" เรียบร้อยแล้ว");
    }

    // ==================== หมวดที่ 2: บันทึกข้อมูลผู้บริหาร ====================
    public function storeExecutive(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'position'   => ['required', 'string', 'max:255'],
            'start_year' => ['nullable', 'string', 'max:10'],
            'end_year'   => ['nullable', 'string', 'max:10'],
            'image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required'     => 'กรุณากรอกชื่อ-นามสกุลผู้บริหาร',
            'position.required' => 'กรุณากรอกตำแหน่งผู้บริหาร',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/organization/executives', 'public');
            $imagePath = 'storage/' . $path;
        }

        OrganizationExecutive::create([
            'name'       => $validated['name'],
            'position'   => $validated['position'],
            'start_year' => $validated['start_year'] ?? null,
            'end_year'   => $validated['end_year'] ?? null,
            'image_path' => $imagePath,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active', true),
        ]);

        return back()
            ->with('active_tab', 'tab-cat-2')
            ->with('success', 'เพิ่มข้อมูลผู้บริหารเรียบร้อยแล้ว');
    }

    public function updateExecutive(Request $request, OrganizationExecutive $executive)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'position'   => ['required', 'string', 'max:255'],
            'start_year' => ['nullable', 'string', 'max:10'],
            'end_year'   => ['nullable', 'string', 'max:10'],
            'image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = [
            'name'       => $validated['name'],
            'position'   => $validated['position'],
            'start_year' => $validated['start_year'] ?? null,
            'end_year'   => $validated['end_year'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($executive->image_path) {
                $this->deletePublicFile($executive->image_path);
            }
            $path = $request->file('image')->store('uploads/organization/executives', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $executive->update($data);

        return back()
            ->with('active_tab', 'tab-cat-2')
            ->with('success', 'อัปเดตข้อมูลผู้บริหารเรียบร้อยแล้ว');
    }

    public function destroyExecutive(OrganizationExecutive $executive)
    {
        if ($executive->image_path) {
            $this->deletePublicFile($executive->image_path);
        }
        $executive->delete();

        return back()
            ->with('active_tab', 'tab-cat-2')
            ->with('success', 'ลบข้อมูลผู้บริหารเรียบร้อยแล้ว');
    }

    // ==================== หมวดที่ 3: บันทึกข้อมูลเจ้าหน้าที่ ====================
    public function storeStaff(Request $request)
    {
        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'position'           => ['required', 'string', 'max:255'],
            'employment_type'    => ['required', 'string', Rule::in(OrganizationStaff::employmentTypes())],
            'admin_position'     => ['nullable', 'string', 'max:255'],
            'workgroup_priority' => ['required', 'integer', 'in:1,2,3,4,5,6'],
            'workgroup_id'       => ['nullable', 'integer', 'exists:organization_workgroups,id'],
            'job_id'             => ['nullable', 'integer', 'exists:organization_jobs,id'],
            'image'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order'         => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required'               => 'กรุณากรอกชื่อ-นามสกุลเจ้าหน้าที่',
            'position.required'           => 'กรุณากรอกตำแหน่ง',
            'employment_type.required'    => 'กรุณาเลือกประเภทการจ้างงาน',
            'workgroup_priority.required' => 'กรุณาเลือกระดับความสำคัญ (Priority)',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/organization/staffs', 'public');
            $imagePath = 'storage/' . $path;
        }

        $workgroupId = $validated['workgroup_id'] ?? null;
        $jobId       = $validated['job_id'] ?? null;

        // หากเลือกงานย่อย แต่ไม่ได้เลือกกลุ่มงาน ให้ดึงกลุ่มงานของงานย่อยนั้นให้อัตโนมัติ
        if ($jobId && !$workgroupId) {
            $job = OrganizationJob::find($jobId);
            $workgroupId = $job?->workgroup_id;
        }

        OrganizationStaff::create([
            'name'               => $validated['name'],
            'position'           => $validated['position'],
            'employment_type'    => $validated['employment_type'],
            'admin_position'     => $validated['admin_position'] ?? null,
            'workgroup_priority' => (int) $validated['workgroup_priority'],
            'workgroup_id'       => $workgroupId ?: null,
            'job_id'             => $jobId ?: null,
            'workgroup_name'     => $workgroupId ? OrganizationWorkgroup::find($workgroupId)?->name : null,
            'image_path'         => $imagePath,
            'sort_order'         => $validated['sort_order'] ?? 0,
            'is_active'          => $request->boolean('is_active', true),
        ]);

        return back()
            ->with('active_tab', 'tab-cat-3')
            ->with('success', 'เพิ่มข้อมูลเจ้าหน้าที่เรียบร้อยแล้ว');
    }

    public function updateStaff(Request $request, OrganizationStaff $staff)
    {
        $validated = $request->validate([
            'name'               => ['required', 'string', 'max:255'],
            'position'           => ['required', 'string', 'max:255'],
            'employment_type'    => ['required', 'string', Rule::in(OrganizationStaff::employmentTypes())],
            'admin_position'     => ['nullable', 'string', 'max:255'],
            'workgroup_priority' => ['required', 'integer', 'in:1,2,3,4,5,6'],
            'workgroup_id'       => ['nullable', 'integer', 'exists:organization_workgroups,id'],
            'job_id'             => ['nullable', 'integer', 'exists:organization_jobs,id'],
            'image'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order'         => ['nullable', 'integer', 'min:0'],
        ]);

        $workgroupId = $validated['workgroup_id'] ?? null;
        $jobId       = $validated['job_id'] ?? null;

        if ($jobId && !$workgroupId) {
            $job = OrganizationJob::find($jobId);
            $workgroupId = $job?->workgroup_id;
        }

        $data = [
            'name'               => $validated['name'],
            'position'           => $validated['position'],
            'employment_type'    => $validated['employment_type'],
            'admin_position'     => $validated['admin_position'] ?? null,
            'workgroup_priority' => (int) $validated['workgroup_priority'],
            'workgroup_id'       => $workgroupId ?: null,
            'job_id'             => $jobId ?: null,
            'workgroup_name'     => $workgroupId ? OrganizationWorkgroup::find($workgroupId)?->name : null,
            'sort_order'         => $validated['sort_order'] ?? 0,
            'is_active'          => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($staff->image_path) {
                $this->deletePublicFile($staff->image_path);
            }
            $path = $request->file('image')->store('uploads/organization/staffs', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $staff->update($data);

        return back()
            ->with('active_tab', 'tab-cat-3')
            ->with('success', 'อัปเดตข้อมูลเจ้าหน้าที่เรียบร้อยแล้ว');
    }

    public function destroyStaff(OrganizationStaff $staff)
    {
        if ($staff->image_path) {
            $this->deletePublicFile($staff->image_path);
        }
        $staff->delete();

        return back()
            ->with('active_tab', 'tab-cat-3')
            ->with('success', 'ลบข้อมูลเจ้าหน้าที่เรียบร้อยแล้ว');
    }

    // ==================== หมวดที่ 4: เวลาทำการและแผนที่ (SiteSetting) ====================
    public function updateContactMap(Request $request)
    {
        $validated = $request->validate([
            'site_address'           => ['required', 'string', 'max:500'],
            'site_phone'             => ['nullable', 'string', 'max:100'],
            'site_hours_weekday'     => ['required', 'string', 'max:255'],
            'site_hours_weekend'     => ['required', 'string', 'max:255'],
            'site_google_map_iframe' => ['nullable', 'string'],
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return back()
            ->with('active_tab', 'tab-cat-4')
            ->with('success', 'อัปเดตเวลาทำการและแผนที่ตั้งหน่วยงานเรียบร้อยแล้ว');
    }

    private function deletePublicFile(string $publicPath): void
    {
        if (str_starts_with($publicPath, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $publicPath));
        }
    }
}
