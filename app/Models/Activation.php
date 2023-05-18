<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Activation extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    // Format the created_at field
    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d h:i A', strtotime($value));
    }

    // Relationship with Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    // Activated By Relationship with Admin
    public function activatedByAdmin()
    {
        return $this->belongsTo(User::class, 'activated_by', 'id');
    }

    // Activated By Relationship with Member
    public function activatedByMember()
    {
        return $this->belongsTo(Member::class, 'activated_by', 'id');
    }
}
