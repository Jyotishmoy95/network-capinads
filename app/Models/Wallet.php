<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Wallet extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopeFilterDate($query, $from, $to)
    {
        if ($from && $to) {
           return $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
        }
        return $query;
    }

    public function scopeFilterStatus($query, $status)
    {
        if($status == 0){
            return $query->where('status', 0);
        }elseif($status == 1){
            return $query->where('status', 1);
        }elseif($status == 2){
            return $query->where('status', 2);
        }

        return $query;
    }

    public function bankDetails()
    {
        return $this->hasOne(MemberBankDetail::class, 'member_id', 'username');
    }

    public function scopeFilterUsername($query, $username)
    {
        if ($username) {
           return $query->where('username', $username);
        }
        return $query;
    }


}
