<?php

namespace App\Http\Controllers;

use App\Models\TrongTrePro\TUser;
use App\Models\VuonUomApp\TTUser;
use App\Services\ConvertData\ConvertDataInterface;
use App\Services\TProviders\TProvidersInterface;
use App\Services\TTUsers\TTUserInterface;
use App\Services\TUsers\TUserInterface;
use Illuminate\Http\Request;
class ConvertController extends Controller
{
    protected $ttUserInterface;
    protected $tUserInterface;
    protected $convertDataInterface;
    protected $tProvidersInterface;
    public function __construct(
        TTUserInterface $ttUserInterface, 
        TUserInterface $tUserInterface,
        ConvertDataInterface $convertDataInterface,
        TProvidersInterface $tProvidersInterface        
    )
    {
        $this->ttUserInterface = $ttUserInterface;
        $this->tProvidersInterface = $tProvidersInterface;
        $this->tUserInterface = $tUserInterface;
        $this->convertDataInterface = $convertDataInterface;        
    }
    
    public function getDataVU(){        
        $model = TUser::all(); 
        return $model;
    }
    public function convertDataParent(){                
        // $data = $request->all();
        return $this->responseData($this->convertDataInterface->cvDataFromTrongTrePro());
    }
    public function convertDataTeacher(){
        return $this->responseData($this->tProvidersInterface->cvDataFromTrongTrePro());
    }
}
