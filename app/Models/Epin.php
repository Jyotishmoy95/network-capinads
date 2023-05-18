<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Epin extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    // Format the created_at field
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'generated_by', 'id');
    }

    // Relationship with Member
    public function member()
    {
        return $this->belongsTo(Member::class, 'used_by', 'member_id');
    }

    // Activated By Scope
    public function scopeActivationInfo($query){
        return $query
            ->when($this->account_type == 'admin',function($q){
                return $q->with('activatedByAdmin');
            })
            ->when($this->account_type == 'user',function($q){
                return $q->with('activatedByMember');
            });
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
