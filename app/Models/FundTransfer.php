<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FundTransfer extends Model  implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    public function scopeFilterDate($query, $from, $to)
    {
        if ($from && $to) {
           return $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
        }
        return $query;
    }

    public function scopeFilterUsername($query, $username)
    {
        if ($username) {
           return $query->where('member_id', $username);
        }
        return $query;
    }

}
