<?php

namespace App\Repositories;

use App\Models\TrongTrePro\TProviders;
use App\Repositories\BaseRepository;
class TProvidersRepository extends BaseRepository
{
    public $model;
    public function __construct(TProviders $model)
    {        
        $this->model = $model;        
    }
    
}
