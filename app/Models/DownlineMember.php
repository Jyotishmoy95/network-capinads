<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DownlineMember extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    // Relationship to hirarchy table
    public function hirarchy()
    {
        return $this->belongsTo(Hirarchy::class, 'location_id', 'member_id');
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
