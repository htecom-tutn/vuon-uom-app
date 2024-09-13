<?php

namespace App\Models\TrongTrePro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TProviderDevices extends Model
{
    use HasFactory;
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 't_provider_devices';
    protected $fillable = [
        'id',
        'provider_id',
        'device_id',
        'device_type',
        'device_name',
        'fcm_token',
        'os_version',
        'app_version',
        'created_at',
        'updated_at'
    ];   
    public function providers()
    {
        return $this->belongsTo(TProviders::class, 'provider_id', 'id' )->orderBy('created_at', 'desc');
    }
}
