<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isApproved(): bool
    {
        return ($this->status ?? 'approved') === 'approved';
    }

    public function isAdmin(): bool
    {
        return ($this->role ?? '') === 'admin';
    }

    public function isEditor(): bool
    {
        return ($this->role ?? '') === 'editor';
    }

    public function isUser(): bool
    {
        return ($this->role ?? 'user') === 'user';
    }

    /**
     * ตรวจสอบสิทธิ์การเข้าใช้งานตามกลุ่มเมนู
     * - admin : ได้ทุกเมนู
     * - editor: ได้ทุกเมนู ยกเว้นเมนูจัดการผู้ใช้งาน (users)
     * - user  : ได้เฉพาะ ประชาสัมพันธ์ (news), อัลบั้มกิจกรรม (albums) และหน้าหลักแดชบอร์ด (dashboard)
     */
    public function canAccessMenu(string $menu): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isEditor()) {
            return $menu !== 'users';
        }

        // สิทธิ์ระดับ user
        return in_array($menu, ['dashboard', 'news', 'albums'], true);
    }
}
