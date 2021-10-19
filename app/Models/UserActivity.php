<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;
    protected $table='user_activity';
    protected $primaryKey = 'user_activity_id';
    protected $fillable = [
        'user_activity_id',  
        'refUser_id',
        'refModule_id',
        'activity',
        'subject',
        'url',
        'device',  
        'ip_address',
        'date_added'
    ]; 
}
