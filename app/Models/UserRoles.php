<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;
    protected $table='user_role';
    protected $primaryKey = 'user_role_id';
    protected $fillable = [
        'user_role_id',  
        'name',
        'access_permission',
        'modify_permission', 
        'added_by',
        'is_active',
        'is_deleted' ,
        'date_added',
        'date_updated'
    ]; 
}
