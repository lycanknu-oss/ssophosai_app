<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
{
    public function index()
    {
        $info = [
            'org_name_th'       => SiteSetting::getValue('site_org_name_th', 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร'),
            'org_name_en'       => SiteSetting::getValue('site_org_name_en', 'Pho Sai District Public Health Office'),
            'address'           => SiteSetting::getValue('site_address', 'หมู่ที่ 2 ตำบลโพธิ์ไทร อำเภอโพธิ์ไทร จังหวัดอุบลราชธานี 34340'),
            'phone'             => SiteSetting::getValue('site_phone', '045-489-XXX'),
            'google_map_iframe' => SiteSetting::getValue('site_google_map_iframe', ''),
            'hours_weekday'     => SiteSetting::getValue('site_hours_weekday', 'วันจันทร์ - วันศุกร์ เวลา 08.30 - 16.30 น.'),
            'hours_weekend'     => SiteSetting::getValue('site_hours_weekend', 'วันเสาร์ - วันอาทิตย์ และวันหยุดนักขัตฤกษ์ ปิดทำการ'),
            'slogan'            => SiteSetting::getValue('site_slogan', 'สุขภาพดี เริ่มต้นที่ชุมชนของเรา'),
            'motto'             => SiteSetting::getValue('site_motto', ''),
            'core_values'       => SiteSetting::getValue('site_core_values', ''),
            'vision'            => SiteSetting::getValue('site_vision', ''),
        ];

        return view('admin.site-info.index', compact('info'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'org_name_th'       => ['required', 'string', 'max:255'],
            'org_name_en'       => ['required', 'string', 'max:255'],
            'address'           => ['required', 'string', 'max:1000'],
            'phone'             => ['required', 'string', 'max:150'],
            'google_map_iframe' => ['nullable', 'string', 'max:5000'],
            'hours_weekday'     => ['required', 'string', 'max:255'],
            'hours_weekend'     => ['required', 'string', 'max:255'],
            'slogan'            => ['nullable', 'string', 'max:500'],
            'motto'             => ['nullable', 'string', 'max:500'],
            'core_values'       => ['nullable', 'string', 'max:2000'],
            'vision'            => ['nullable', 'string', 'max:2000'],
        ], [
            'org_name_th.required'   => 'กรุณากรอกชื่อหน่วยงาน (ภาษาไทย)',
            'org_name_en.required'   => 'กรุณากรอกชื่อหน่วยงาน (ภาษาอังกฤษ)',
            'address.required'       => 'กรุณากรอกที่อยู่หน่วยงาน',
            'phone.required'         => 'กรุณากรอกเบอร์โทรติดต่อ',
            'hours_weekday.required' => 'กรุณากรอกเวลาทำการ (จันทร์ - ศุกร์)',
            'hours_weekend.required' => 'กรุณากรอกเวลาทำการ (เสาร์ - อาทิตย์)',
        ]);

        // กรองให้เก็บเฉพาะแท็ก <iframe> ที่ปลอดภัยสำหรับ Google Maps
        $mapIframe = trim((string) ($validated['google_map_iframe'] ?? ''));
        if ($mapIframe !== '' && !str_contains($mapIframe, '<iframe')) {
            // กรณีผู้ใช้แปะเฉพาะลิงก์ Embed URL ให้ครอบด้วยแท็ก iframe ให้อัตโนมัติ
            $safeUrl = e($mapIframe);
            $mapIframe = "<iframe src=\"{$safeUrl}\" width=\"100%\" height=\"350\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>";
        }

        SiteSetting::setValue('site_org_name_th', $validated['org_name_th'], 'ชื่อหน่วยงาน (Thai)');
        SiteSetting::setValue('site_org_name_en', $validated['org_name_en'], 'ชื่อหน่วยงาน (Eng)');
        SiteSetting::setValue('site_address', $validated['address'], 'ที่อยู่หน่วยงาน');
        SiteSetting::setValue('site_phone', $validated['phone'], 'เบอร์โทรติดต่อ');
        SiteSetting::setValue('site_google_map_iframe', $mapIframe, 'แผนที่ Google Map (iframe)');
        SiteSetting::setValue('site_hours_weekday', $validated['hours_weekday'], 'เวลาทำการ (จ-ศ)');
        SiteSetting::setValue('site_hours_weekend', $validated['hours_weekend'], 'เวลาทำการ (ส-อ.)');
        SiteSetting::setValue('site_slogan', $validated['slogan'] ?? '', 'สโลแกน');
        SiteSetting::setValue('site_motto', $validated['motto'] ?? '', 'คำขวัญ');
        SiteSetting::setValue('site_core_values', $validated['core_values'] ?? '', 'ค่านิยม');
        SiteSetting::setValue('site_vision', $validated['vision'] ?? '', 'วิสัยทัศน์');

        return redirect()
            ->route('admin.site-info.index')
            ->with('success', 'บันทึกข้อมูลพื้นฐานของเว็บไซต์ลงฐานข้อมูลเรียบร้อยแล้ว');
    }
}
