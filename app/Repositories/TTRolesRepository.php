<?php

namespace App\Repositories;
use App\Models\VuonUomApp\TTRoles;
use App\Repositories\BaseRepository;
class TRolesRepository extends BaseRepository
{
    public $model;
    public function __construct(TTRoles $model)
    {        
        $this->model = $model;        
    }
    
}
