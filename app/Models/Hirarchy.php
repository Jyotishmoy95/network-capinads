<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Hirarchy extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    // Relationship to members table
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'member_id');
    }

    // Format the activation_time field
    public function getActivationTimeAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d h:i A');
    }

    public function scopeFilterDate($query, $from, $to)
    {
        if ($from && $to) {
           return $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
        }
        return $query;
    }

    public function scopeFilterType($query, $type)
    {
        if($type == 'active'){
            return $query->where('activation_amount', '>', 0);
        }elseif($type == 'inactive'){
            return $query->where('activation_amount', '=', 0);
        }
        return $query;
    }

}
