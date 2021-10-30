<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table='users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'mobile',
        'email',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'id_proof_1' ,
        'id_proof_2',
        'profile_pic',
        'role_id',
        'username',
        'password',
        'added_by' ,
        'is_active',
        'is_deleted',
        'last_login_type',
        'last_login_date_time',
        'date_added',
        'date_updated'
    ];
}
