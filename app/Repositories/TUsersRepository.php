<?php

namespace App\Repositories;

use App\Models\TrongTrePro\TUser;
use App\Repositories\BaseRepository;
class TUsersRepository extends BaseRepository
{
    public $model;
    public function __construct(TUser $model)
    {        
        $this->model = $model;        
    }
    
}
