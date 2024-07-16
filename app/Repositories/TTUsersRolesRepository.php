<?php

namespace App\Repositories;
use App\Models\VuonUomApp\TTUserRoles;
use App\Repositories\BaseRepository;
class TTUsersRolesRepository extends BaseRepository
{
    public $model;
    public function __construct(TTUserRoles $model)
    {        
        $this->model = $model;        
    }
    
}
