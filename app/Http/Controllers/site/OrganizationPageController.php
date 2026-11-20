<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\OrganizationContent;
use App\Models\OrganizationExecutive;
use App\Models\OrganizationStaff;
use App\Models\OrganizationWorkgroup;
use App\Models\SiteSetting;

class OrganizationPageController extends Controller
{
    public function index()
    {
        // หมวดที่ 1: ข้อมูลพื้นฐาน นโยบาย วิสัยทัศน์ โครงสร้าง ผังบุคลากร
        $sections = OrganizationContent::sections();
        $contents = OrganizationContent::all()->keyBy('section_key');

        // หมวดที่ 2: ทำเนียบผู้บริหาร
        $executives = OrganizationExecutive::where('is_active', true)
            ->orderByRaw('CASE WHEN end_year IS NULL OR end_year = "" THEN 0 ELSE 1 END ASC')
            ->orderByDesc('start_year')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $currentExecutive = $executives->first(fn ($exec) => empty($exec->end_year));
        $pastExecutives   = $executives->filter(fn ($exec) => !empty($exec->end_year));

        // หมวดที่ 3: บุคลากร / เจ้าหน้าที่
        $workgroups = OrganizationWorkgroup::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $staffs = OrganizationStaff::with(['workgroup', 'job'])
            ->where('is_active', true)
            ->orderBy('workgroup_priority', 'asc')
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $isAdminMission = function ($staff): bool {
            $code = $staff->workgroup?->code ?? '';
            return in_array((int) $staff->workgroup_id, [1, 2], true) || str_starts_with($code, 'ADM');
        };

        $isAcademicMission = function ($staff): bool {
            $code = $staff->workgroup?->code ?? '';
            return in_array((int) $staff->workgroup_id, [3, 4], true) || str_starts_with($code, 'ACD');
        };

        // ระดับที่ 1: ผู้บริหารสูงสุด (Priority 1)
        $topExecutives = $staffs->where('workgroup_priority', 1)->values();

        // ระดับที่ 2: รองผู้บริหาร และ ผู้ช่วยผู้บริหาร (Priority 2, 3)
        $deputyExecutives   = $staffs->whereIn('workgroup_priority', [2, 3])->values();
        $adminDeputies      = $deputyExecutives->filter($isAdminMission)->values();
        $academicDeputies   = $deputyExecutives->filter($isAcademicMission)->values();
        $unassignedDeputies = $deputyExecutives->filter(
            fn ($s) => !$adminDeputies->contains('id', $s->id) && !$academicDeputies->contains('id', $s->id)
        )->values();

        // ระดับที่ 3: หัวหน้ากลุ่มงาน (4) และ เจ้าหน้าที่ (5, 6) แยกตาม 4 กลุ่มงานภายใต้ 2 ภารกิจ
        $layer3Staffs = $staffs->whereIn('workgroup_priority', [4, 5, 6])->values();

        $adminWorkgroups = $workgroups->filter(
            fn ($wg) => in_array((int) $wg->id, [1, 2], true) || str_starts_with($wg->code ?? '', 'ADM')
        )->values();

        $academicWorkgroups = $workgroups->filter(
            fn ($wg) => in_array((int) $wg->id, [3, 4], true) || str_starts_with($wg->code ?? '', 'ACD')
        )->values();

        $adminWorkgroupColumns = $adminWorkgroups->map(function ($wg) use ($layer3Staffs) {
            return [
                'workgroup' => $wg,
                'staffs'    => $layer3Staffs->where('workgroup_id', $wg->id)->values(),
            ];
        });

        $academicWorkgroupColumns = $academicWorkgroups->map(function ($wg) use ($layer3Staffs) {
            return [
                'workgroup' => $wg,
                'staffs'    => $layer3Staffs->where('workgroup_id', $wg->id)->values(),
            ];
        });

        $assignedWorkgroupIds = $adminWorkgroups->pluck('id')
            ->merge($academicWorkgroups->pluck('id'))
            ->all();

        $unassignedStaffs = $layer3Staffs->filter(
            fn ($s) => !in_array((int) $s->workgroup_id, $assignedWorkgroupIds, true)
        )->values();

        // หมวดที่ 4: เวลาทำการและแผนที่ติดต่อ
        $siteSettings = [
            'org_name_th'       => SiteSetting::getValue('site_org_name_th', 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร'),
            'address'           => SiteSetting::getValue('site_address', 'หมู่ที่ 2 ตำบลโพธิ์ไทร อำเภอโพธิ์ไทร จังหวัดอุบลราชธานี 34340'),
            'phone'             => SiteSetting::getValue('site_phone', '045-496-067'),
            'hours_weekday'     => SiteSetting::getValue('site_hours_weekday', 'วันจันทร์ - วันศุกร์ เวลา 08.30 - 16.30 น.'),
            'hours_weekend'     => SiteSetting::getValue('site_hours_weekend', 'วันเสาร์ - วันอาทิตย์ และวันหยุดนักขัตฤกษ์ ปิดทำการ'),
            'google_map_iframe' => SiteSetting::getValue('site_google_map_iframe', ''),
        ];

        return view('site.organization', compact(
            'sections',
            'contents',
            'executives',
            'currentExecutive',
            'pastExecutives',
            'workgroups',
            'staffs',
            'topExecutives',
            'deputyExecutives',
            'adminDeputies',
            'academicDeputies',
            'unassignedDeputies',
            'adminWorkgroupColumns',
            'academicWorkgroupColumns',
            'unassignedStaffs',
            'siteSettings'
        ));
    }
}
