<?php

namespace App\Http\Controllers;

use App\Models\TrongTrePro\TUser;
use App\Models\VuonUomApp\TTUser;
use App\Services\ConvertData\ConvertDataInterface;
use App\Services\TTUsers\TTUserInterface;
use App\Services\TUsers\TUserInterface;
use Illuminate\Http\Request;
class ConvertController extends Controller
{
    protected $ttUserInterface;
    protected $tUserInterface;
    protected $convertDataInterface;
    public function __construct(
        TTUserInterface $ttUserInterface, 
        TUserInterface $tUserInterface,
        ConvertDataInterface $convertDataInterface
    )
    {
        $this->ttUserInterface = $ttUserInterface;
        $this->tUserInterface = $tUserInterface;
        $this->convertDataInterface = $convertDataInterface;        
    }
    
    public function getDataVU(){        
        $model = TUser::all(); 
        dd($model);
    }
    public function convertData(Request $request){                
        $data = $request->all();
        return $this->responseData($this->convertDataInterface->cvDataFromTrongTrePro());
    }
}
