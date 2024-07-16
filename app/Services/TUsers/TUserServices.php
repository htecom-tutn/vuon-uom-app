<?php

namespace App\Services\TUsers;

use App\Models\VuonUomApp\TTUser;
use App\Repositories\TTUsersRepository;
use App\Repositories\TUsersRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class TUserServices implements TUserInterface
{
    protected $tUsersRepository;
    protected $ttUsersRepository;
    public function __construct(TUsersRepository $tUsersRepository, TTUsersRepository $ttUsersRepository) {       
        $this->tUsersRepository = $tUsersRepository; // Trông trẻ pro     
        $this->ttUsersRepository = $ttUsersRepository; // vươn ươm     
    }
    
    public function getDataTT(){
        $model = $this->tUsersRepository->with(['devices'])->get();        
        return $model;
    }
    public function checkExistUsers($username){
        $status = false;
        $count = $this->ttUsersRepository->where('username', $username)->count();
        if($count > 0) $status = true;
        return $status;
    }
    public function convertDataFromTrongTrePro($params){
        try {
            $data = $this->getDataTT();        
            // Data mới của bảng vườn ươm    
            $status = config('app.data.notActive');        
            $active = config('app.data.notDeleted');
            // $hashPassword = Hash::make('123456aA@');
            $pTUsers = [];
            foreach ($data as $item) {            
                $status = $this->checkExistUsers($item['phone']);                   
                if($status) {
                    continue;
                } else {
                    if(count($item['devices']) > 0) $mobile_token = json_encode($item['devices']->pluck('fcm_token')->toArray());         
                    else $mobile_token = null;
                    if($item['status'] == 0 || $item['status'] == 1) $status = $item['status'];
                    if($item['status'] == -1) $active = config('app.data.deleted');
                    // Data của bảng user
                    $pTUsers[] = [
                        // Tài khoản đăng nhập lấy luôn số điện thoại
                        'username' => $item['phone'] ?? null,
                        'dien_thoai' => $item['phone'] ?? null,
                        'anh_nguoi_dung' => $item['avt'] ?? null,                
                        'email' => $item['email'] ?? null,                        
                        'status' => $status ?? 0,
                        'active' => $active ?? 0,
                        'created_at' => $item['created_at'] ?? Carbon::now()->format('Y-m-d H:i'),                               
                        // 'updated_at' => Carbon::now()->format('Y-m-d H:i'),                               
                        'hoten' => $item['full_name'] ?? null,
                        'dia_chi' => $item['address'] ?? null,
                        'mobile_token' => $mobile_token ?? null,                
                        'ngay_sinh' =>  $item['dob'] ?? null,   
                        'gioi_tinh' =>  $item['gender'] ?? null,   
                        'vi_dien_tu' =>  $item['money'] ?? null,   
                        'ghi_chu' =>  $item['note'] ?? null,   
                        'is_admin' =>  config('app.data.isNotAdmin') ?? null,   // Thêm cả bảng trong_tre_vaitrouser                
                        // 'auth_key' => !empty($item['last_login']) ? Str::random(35) : '',
                        'auth_key' => null,
                        'danh_gia' => null,  
        
                        'cmnd_cccd' => null,
                        'bang_cap' => null,
                        'dien_thoai_du_phong' => null,
                        'dich_vu' => null,
                        'trinh_do' => null,
                        'password_hash' => null,
                        'password' => null,
                        'is_finish' => 0,
                        // 'danh_gia' => null,                
                        // Thông tin về con                
                        'ho_ten_con' => null,
                        'ngay_sinh_cua_con' => Null,
                        'khoa_tai_khoan' => Null,
                        'ma_so_thue' => Null,
                        'trang_thai_vao_ca' => Null,
                        'ten_ngan_hang' => Null,
                        'so_tai_khoan' => Null,
                        'chu_tai_khoan' => Null,
                        // 'is_finish' => Null,
                        'leader_id' => Null,
                        'token_facebook' => Null,
                        'token_google' => Null,
                        'id_facebook' => Null,
                        'id_google' => Null,
        
                    ];                   
                }            
            }                                 
            // Thêm mới vào bảng user
            if(count($pTUsers) > 0) {
                $dUsers = $this->ttUsersRepository->createMultiple($pTUsers)->pluck('id')->toArray();
                foreach ($dUsers as $item) {
                    $uRoleData [] = [
                        'user_id' => $item,
                        'vaitro_id' => config('app.data.roles.isParent')
                    ];
                }
                dd('1111' , $uRoleData);
            }
            
            
            
        } catch (\Throwable $th) {
            Log::info($th->getMessage(), $th->getLine());
            return $th->getMessage();
        }


    }
}
