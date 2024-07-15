<?php

namespace App\Http\Controllers;
use App\Services\TTUsers\TTUserInterface;
use App\Services\TUsers\TUserInterface;
use Illuminate\Http\Request;
class ConvertController extends Controller
{
    protected $ttUserInterface;
    protected $tUserInterface;
    public function __construct(TTUserInterface $ttUserInterface, TUserInterface $tUserInterface)
    {
        $this->ttUserInterface = $ttUserInterface;
        $this->tUserInterface = $tUserInterface;
    }
    
    public function convertData(Request $request){                
        $data = $request->all();
        return $this->responseData($this->tUserInterface->convertDataFromTrongTrePro($data));
    }
}
