<?php

namespace App\Models\TrongTrePro;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TUserDevice extends Model
{
    use HasFactory;
    public function tUsers()
    {
        return $this->belongsTo(TUserDevice::class, 'user_id', 'id' );
    }    
}
