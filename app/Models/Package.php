<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Package extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id'];

    // Relationship with PackageLevel
    public function levels()
    {
        return $this->hasMany(PackageLevel::class);
    }

    public function adViewLevels()
    {
        return $this->hasMany(AdLevelIncome::class);
    }

    // Format the created_at field
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    }

}
