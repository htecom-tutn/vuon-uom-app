<?php

namespace App\Models\TrongTrePro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TProviders extends Model
{
    use HasFactory;
    const FEMALE = 0;
    const MALE = 1;
    const OTHER = 2;

    const GENDER_MAP = [
        self::FEMALE => "Nữ",
        self::MALE => "Nữ",
        self::OTHER => "Nữ",
    ];

    protected $connection = 'mysql';
    protected $table = 't_providers';
    protected $fillable = [
        'id',
        'phone',
        'email',
        'password',
        'full_name',
        'type_id',
        'cmnd',
        'display_name',
        'gender',
        'dob',
        'address',
        'avt',
        'created_at',
        'channel_code',
        'hotline',
        'status',
        'lat',
        'lng',
        'rating',
        'admin_rating',
        'rating_count',
        'admin_rating_count',
        'gold',
        'money',
        'image',
        'cmnd_back',
        'cmnd_front',
        'notification',
        'bank_info',
        'description',
        'contact_other',
        'certificate',
        'lock',
        'tax_id_number',
        'citizen_id',
        'certificates',

    ];
    public function devices()
    {
        return $this->hasMany(TProviderDevices::class, 'provider_id', 'id' )->orderBy('created_at', 'desc');
    }    
}
