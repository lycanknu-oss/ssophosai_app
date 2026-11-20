<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\HealthOffice;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        // ดึงรายชื่อหน่วยงานภายใต้สังกัดมาให้เลือกใน Dropdown
        $provinceCode = SiteSetting::getValue('unit_filter_province_code', '34');
        $districtCode = SiteSetting::getValue('unit_filter_district_code', '3421');
        $orgType      = SiteSetting::getValue('unit_filter_org_type', 'รัฐบาล');

        $units = HealthOffice::whereNull('closed_date')
            ->when($provinceCode !== '', fn($q) => $q->where('province_code', $provinceCode))
            ->when($districtCode !== '', fn($q) => $q->where('district_code', $districtCode))
            ->when($orgType !== '', fn($q) => $q->where('org_type', $orgType))
            ->orderBy('service_unit_type')
            ->orderBy('name')
            ->pluck('name');

        // ค้นหาสถานะเรื่องร้องเรียน (กรณีประชาชนกรอกรหัสติดตาม)
        $trackedComplaint = null;
        $trackCode = trim((string) $request->input('track', ''));
        if ($trackCode !== '') {
            $trackedComplaint = Complaint::where('tracking_code', strtoupper($trackCode))->first();
        }

        // สรุปสถิติภาพรวมแบบไม่เปิดเผยข้อมูลส่วนบุคคล
        $stats = [
            'total'       => Complaint::count(),
            'in_progress' => Complaint::whereIn('status', ['pending', 'in_progress'])->count(),
            'resolved'    => Complaint::where('status', 'resolved')->count(),
        ];

        return view('site.complaints', compact('units', 'trackedComplaint', 'trackCode', 'stats'));
    }

    public function store(Request $request)
    {
        $isAnonymous = $request->boolean('is_anonymous');

        $validated = $request->validate([
            'category'          => ['required', 'string', 'max:100'],
            'target_unit'       => ['nullable', 'string', 'max:255'],
            'subject'           => ['required', 'string', 'max:255'],
            'details'           => ['required', 'string', 'min:10'],
            'incident_date'     => ['nullable', 'date', 'before_or_equal:today'],
            'attachment'        => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
            'is_anonymous'      => ['nullable', 'boolean'],
            'complainant_name'  => [$isAnonymous ? 'nullable' : 'required', 'string', 'max:150'],
            'complainant_phone' => [$isAnonymous ? 'nullable' : 'required', 'string', 'max:30'],
            'complainant_email' => ['nullable', 'email', 'max:150'],
            'pdpa_consent'      => ['accepted'],
        ], [
            'category.required'          => 'กรุณาเลือกประเภทเรื่องร้องเรียน',
            'subject.required'           => 'กรุณาระบุหัวข้อเรื่องร้องเรียน',
            'details.required'           => 'กรุณากรอกรายละเอียดข้อเท็จจริง',
            'details.min'                => 'กรุณากรอกรายละเอียดอย่างน้อย 10 ตัวอักษร',
            'complainant_name.required'  => 'กรุณาระบุชื่อ-นามสกุล หรือเลือกส่งแบบไม่เปิดเผยตัวตน',
            'complainant_phone.required' => 'กรุณาระบุเบอร์โทรศัพท์ติดต่อ หรือเลือกส่งแบบไม่เปิดเผยตัวตน',
            'attachment.max'             => 'ไฟล์แนบต้องมีขนาดไม่เกิน 5 MB',
            'pdpa_consent.accepted'      => 'กรุณายืนยันข้อตกลงการคุ้มครองข้อมูลส่วนบุคคลและข้อเท็จจริง',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaints', 'public');
        }

        // สร้างรหัสติดตามเรื่องร้องเรียนรูปแบบ CMP-ปีพ.ศ.-เลขสุ่ม 4 หลัก
        $thaiYear = now()->year + 543;
        do {
            $trackingCode = 'CMP-' . $thaiYear . '-' . strtoupper(Str::random(4));
        } while (Complaint::where('tracking_code', $trackingCode)->exists());

        Complaint::create([
            'tracking_code'     => $trackingCode,
            'category'          => $validated['category'],
            'target_unit'       => $validated['target_unit'] ?? 'สำนักงานสาธารณสุขอำเภอโพธิ์ไทร',
            'subject'           => $validated['subject'],
            'details'           => $validated['details'],
            'incident_date'     => $validated['incident_date'] ?? null,
            'attachment_path'   => $attachmentPath,
            'is_anonymous'      => $isAnonymous,
            'complainant_name'  => $isAnonymous ? 'ไม่เปิดเผยตัวตน' : ($validated['complainant_name'] ?? null),
            'complainant_phone' => $isAnonymous ? null : ($validated['complainant_phone'] ?? null),
            'complainant_email' => $isAnonymous ? null : ($validated['complainant_email'] ?? null),
            'status'            => 'pending',
            'ip_address'        => $request->ip(),
        ]);

        return redirect()
            ->route('complaints.index', ['track' => $trackingCode])
            ->with('complaint_submitted', $trackingCode);
    }
}
