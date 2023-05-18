<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Incentive extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    // Relationship to members table
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    //scope filter type
    public function scopeFilterType($query, $type){
        if($type !== 'all'){
            $query->where('incentive_name', $type);
        }
        return $query;
    }

    //scope filter date
    public function scopeFilterDate($query, $from, $to)
    {
        if ($from && $to) {
           return $query->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59']);
        }
        return $query;
    }

    //scope filter username
    public function scopeFilterUsername($query, $username){
        if(!empty($username)){
            $query->where('username', $username);
        }
        return $query;
    }


}
