<?php

namespace App\Models\TrongTrePro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TUser extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 't_users';
    protected $fillable = [
        'id',
        'phone',
        'email',
        'password',
        'full_name',
        'gender',
        'dob',
        'nation',
        'locale_id',
        'avt',
        'created_at',
        'active_date',
        'address',
        'last_login',
        'lat',
        'lng',
        'utm_source',
        'gold',
        'money',
        'note',
        'rating',
        'rating_count',
        'status',
    ];

}
