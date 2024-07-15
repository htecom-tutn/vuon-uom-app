<?php

namespace App\Repositories;

use App\Models\TrongTrePro\TUser;

class TUsersRepository extends BaseRepository
{
    public $model;
    public function __construct(TUser $model)
    {        
        $this->model = $model;        
    }
    
}
