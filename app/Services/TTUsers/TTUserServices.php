<?php

namespace App\Services\TTUsers;

use App\Repositories\TTUsersRepository;
class TTUserServices implements TTUserInterface
{
    protected $ttUsersRepository;
    protected $tUsersRepository;
    public function __construct(TTUsersRepository $ttUsersRepository) {
        $this->ttUsersRepository = $ttUsersRepository; // Vườn ươm app
        
    }
    
    public function getDataVU($params){
        $model = $this->ttUsersRepository->with(['devices:id,name'])->where('active', 1)->get()->toArray();
        return $model;
    }
    public function convertDataFromTrongTrePro($params){

    }
}
