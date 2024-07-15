<?php

namespace App\Repositories;

use App\Models\VuonUomApp\TTUser;

class TTUsersRepository extends BaseRepository
{
    public $model;
    public function __construct(TTUser $model)
    {        
        $this->model = $model;        
    }
    
}
