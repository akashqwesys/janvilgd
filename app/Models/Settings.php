<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    
    protected $table = 'settings';
    protected $primaryKey = 'setting_id';
    protected $fillable = [
        'setting_id',
        'key',
        'value',
        'updated_by',
        'date_updated'
    ];
}
