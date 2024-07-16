<?php

namespace App\Models\VuonUomApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTUserRoles extends Model
{
    use HasFactory;
    protected $connection = 'mysql1';
    protected $table = 'trong_tre_vaitrouser';
    protected $fillable = ['id', 'user_id', 'vaitro_id'];
}
