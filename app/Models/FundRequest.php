<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FundRequest extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function scopeFilterStatus($query, $status)
    {
        $list_status = $status === 'pending' ? 0 : ($status === 'approved' ? 1 : 2);
        if ($status) {
           return $query->where('status', $list_status);
        }
        return $query;
    }

}
