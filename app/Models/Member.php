<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;

class Member extends Authenticatable implements Auditable
{
    use Notifiable;
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $guard = 'member';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname', 'lname', 'email', 'phone', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    // Format the created_at field
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d h:i A');
    }

    // Relationship to hirarchies table
    public function hirarchy()
    {
        return $this->hasOne(Hirarchy::class, 'member_id', 'member_id');
    }

    //Relationship to member documents table
    public function documents(){
        return $this->hasOne(MemberDocument::class, 'member_id', 'member_id');
    }

}
