<?php

namespace App\Http\Controllers;

use App\Models\TrongTrePro\TUser;
use App\Models\VuonUomApp\TTUser;
use Illuminate\Http\Request;

class ConvertController extends Controller
{
    //

    public function __construct()
    {
        
    }

    public function getDataTT(){
        $model = TUser::all();
        return $this->responseData($model);
    }

    public function getDataVU(){
        $model = TTUser::all();
        return $this->responseData($model);
    }
    
}
