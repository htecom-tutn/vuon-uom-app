<?php

namespace App\Models\VuonUomApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTRoles extends Model
{
    use HasFactory;
    protected $connection = 'mysql1';
    protected $table = 'trong_tre_vai_tro';
    protected $fillable = ['id', 'name'];
    
}
