<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthOffice;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SubordinateUnitController extends Controller
{
    public function index(Request $request)
    {
        // อ่านค่าเงื่อนไขที่บันทึกล่าสุดจากตาราง site_settings (หากยังไม่เคยบันทึกให้ใช้ค่าเริ่มต้น อ.โพธิ์ไทร)
        $savedProvince    = SiteSetting::getValue('unit_filter_province_code', '34');
        $savedDistrict    = SiteSetting::getValue('unit_filter_district_code', '3421');
        $savedOrgType     = SiteSetting::getValue('unit_filter_org_type', 'รัฐบาล');
        $savedUnitType    = SiteSetting::getValue('unit_filter_service_unit_type', '');

        // ใช้ค่าจาก Query String ถ้ามีการกดเลือกตัวกรองใหม่ มิฉะนั้นใช้ค่าที่บันทึกไว้ใน Database
        $provinceCode    = $request->has('province_code') ? (string) $request->input('province_code', '') : (string) $savedProvince;
        $districtCode    = $request->has('district_code') ? (string) $request->input('district_code', '') : (string) $savedDistrict;
        $orgType         = $request->has('org_type') ? (string) $request->input('org_type', '') : (string) $savedOrgType;
        $serviceUnitType = $request->has('service_unit_type') ? (string) $request->input('service_unit_type', '') : (string) $savedUnitType;
        $keyword         = trim((string) $request->input('q', ''));

        // บังคับเงื่อนไขหลัก: วันที่ปิดบริการ = NULL
        $query = HealthOffice::whereNull('closed_date');

        if ($provinceCode !== '') {
            $query->where('province_code', $provinceCode);
        }

        if ($districtCode !== '') {
            $query->where('district_code', $districtCode);
        }

        if ($orgType !== '') {
            $query->where('org_type', $orgType);
        }

        if ($serviceUnitType !== '') {
            $query->where('service_unit_type', $serviceUnitType);
        }

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('hospcode9_new', 'like', "%{$keyword}%")
                  ->orWhere('hospcode5', 'like', "%{$keyword}%")
                  ->orWhere('subdistrict_name', 'like', "%{$keyword}%");
            });
        }

        $units = $query->orderBy('service_unit_type')
            ->orderBy('hospcode5')
            ->orderBy('name')
            ->get();

        $provinces = HealthOffice::whereNull('closed_date')
            ->select('province_code', 'province_name')
            ->whereNotNull('province_code')
            ->distinct()
            ->orderBy('province_code')
            ->get();

        $districts = HealthOffice::whereNull('closed_date')
            ->when($provinceCode !== '', fn($q) => $q->where('province_code', $provinceCode))
            ->select('district_code', 'district_name')
            ->whereNotNull('district_code')
            ->distinct()
            ->orderBy('district_code')
            ->get();

        $orgTypes = HealthOffice::whereNull('closed_date')
            ->whereNotNull('org_type')
            ->distinct()
            ->orderBy('org_type')
            ->pluck('org_type');

        $serviceUnitTypes = HealthOffice::whereNull('closed_date')
            ->when($provinceCode !== '', fn($q) => $q->where('province_code', $provinceCode))
            ->when($districtCode !== '', fn($q) => $q->where('district_code', $districtCode))
            ->when($orgType !== '', fn($q) => $q->where('org_type', $orgType))
            ->whereNotNull('service_unit_type')
            ->distinct()
            ->orderBy('service_unit_type')
            ->pluck('service_unit_type');

        return view('admin.units.index', compact(
            'units',
            'provinces',
            'districts',
            'orgTypes',
            'serviceUnitTypes',
            'provinceCode',
            'districtCode',
            'orgType',
            'serviceUnitType',
            'keyword'
        ));
    }

    /**
     * บันทึกการตั้งค่าเงื่อนไขการกรองหน่วยงานภายใต้สังกัดลงตาราง site_settings
     */
    public function saveFilterSettings(Request $request)
    {
        $validated = $request->validate([
            'province_code'     => ['nullable', 'string', 'max:2'],
            'district_code'     => ['nullable', 'string', 'max:4'],
            'org_type'          => ['nullable', 'string', 'max:50'],
            'service_unit_type' => ['nullable', 'string', 'max:150'],
        ]);

        SiteSetting::setValue('unit_filter_province_code', $validated['province_code'] ?? '', 'รหัสจังหวัดเริ่มต้นของหน่วยงานภายใต้สังกัด');
        SiteSetting::setValue('unit_filter_district_code', $validated['district_code'] ?? '', 'รหัสอำเภอเริ่มต้นของหน่วยงานภายใต้สังกัด');
        SiteSetting::setValue('unit_filter_org_type', $validated['org_type'] ?? '', 'ประเภทองค์กรเริ่มต้นของหน่วยงานภายใต้สังกัด');
        SiteSetting::setValue('unit_filter_service_unit_type', $validated['service_unit_type'] ?? '', 'ประเภทหน่วยบริการสุขภาพเริ่มต้น');

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'บันทึกการตั้งค่าเงื่อนไขหน่วยงานภายใต้สังกัดลงฐานข้อมูลเรียบร้อยแล้ว');
    }

    // ... เมธอด store(), update(), destroy() เดิมคงไว้เหมือนเดิม ...
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'hospcode9_new'     => ['required', 'string', 'max:9', 'unique:healthoffice,hospcode9_new'],
            'hospcode9'         => ['nullable', 'string', 'max:9'],
            'hospcode5'         => ['nullable', 'string', 'max:5'],
            'org_type'          => ['required', 'string', 'max:50'],
            'service_unit_type' => ['required', 'string', 'max:150'],
            'ministry'          => ['nullable', 'string', 'max:150'],
            'department'        => ['nullable', 'string', 'max:150'],
            'province_code'     => ['required', 'string', 'max:2'],
            'province_name'     => ['required', 'string', 'max:100'],
            'district_code'     => ['required', 'string', 'max:4'],
            'district_name'     => ['required', 'string', 'max:100'],
            'subdistrict_code'  => ['nullable', 'string', 'max:6'],
            'subdistrict_name'  => ['nullable', 'string', 'max:100'],
            'moo'               => ['nullable', 'string', 'max:10'],
            'address'           => ['nullable', 'string'],
            'zipcode'           => ['nullable', 'string', 'max:5'],
            'parent_hospital'   => ['nullable', 'string', 'max:255'],
            'actual_beds'       => ['nullable', 'integer', 'min:0'],
        ]);

        HealthOffice::create(array_merge($validated, [
            'usage_status'      => 'กำลังใช้งาน',
            'health_region'     => 'เขตสุขภาพที่ 10',
            'closed_date'       => null,
            'source_updated_at' => now(),
        ]));

        return redirect()
            ->route('admin.units.index', $request->only(['province_code', 'district_code', 'org_type', 'service_unit_type']))
            ->with('success', 'เพิ่มข้อมูลหน่วยงานภายใต้สังกัดเรียบร้อยแล้ว');
    }

    public function update(Request $request, HealthOffice $unit)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'hospcode9_new'     => ['required', 'string', 'max:9', 'unique:healthoffice,hospcode9_new,' . $unit->id],
            'hospcode5'         => ['nullable', 'string', 'max:5'],
            'org_type'          => ['required', 'string', 'max:50'],
            'service_unit_type' => ['required', 'string', 'max:150'],
            'ministry'          => ['nullable', 'string', 'max:150'],
            'department'        => ['nullable', 'string', 'max:150'],
            'subdistrict_name'  => ['nullable', 'string', 'max:100'],
            'moo'               => ['nullable', 'string', 'max:10'],
            'address'           => ['nullable', 'string'],
            'zipcode'           => ['nullable', 'string', 'max:5'],
            'parent_hospital'   => ['nullable', 'string', 'max:255'],
            'actual_beds'       => ['nullable', 'integer', 'min:0'],
            'closed_date'       => ['nullable', 'date'],
        ]);

        $validated['usage_status'] = empty($validated['closed_date']) ? 'กำลังใช้งาน' : 'ปิดให้บริการ';
        $validated['source_updated_at'] = now();

        $unit->update($validated);

        return back()->with('success', 'อัปเดตข้อมูลหน่วยงานเรียบร้อยแล้ว');
    }

    public function destroy(HealthOffice $unit)
    {
        $unit->delete();

        return back()->with('success', 'ลบข้อมูลหน่วยงานเรียบร้อยแล้ว');
    }
}
