<?php

namespace App\Services\TUsers;

use App\Models\VuonUomApp\TTUser;
use App\Models\VuonUomApp\TTUserRoles;
use App\Repositories\TTUsersRepository;
use App\Repositories\TTUsersRolesRepository;
use App\Repositories\TUsersRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class TUserServices implements TUserInterface
{
    protected $tUsersRepository;
    protected $ttUsersRepository;
    protected $ttUsersRolesRepository;
    public function __construct(TUsersRepository $tUsersRepository, TTUsersRepository $ttUsersRepository, TTUsersRolesRepository $ttUsersRolesRepository) {       
        $this->tUsersRepository = $tUsersRepository; // Trông trẻ pro     
        $this->ttUsersRepository = $ttUsersRepository; // vươn ươm     
        $this->ttUsersRolesRepository = $ttUsersRolesRepository; // vươn ươm     
    }
    
    public function getDataTT(){
        // $model = $this->tUsersRepository->with(['devices'])->get();        
        $model = $this->tUsersRepository->with(['devices'])->where('phone', '0973631930')->get();            
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
            $status = config('app.data.active'); //1        
            $active = config('app.data.notDeleted'); //1            
            $pTUsers = [];
            foreach ($data as $item) {            
                $check = $this->checkExistUsers($item['phone']);  
                           
                if($check) {
                    continue;
                } else {
                    if(count($item['devices']) > 0) $mobile_token = json_encode($item['devices']->pluck('fcm_token')->toArray());         
                    else $mobile_token = null;
                    if($item['status'] == 0) $status = $item['status'];                    
                    if($item['status'] == -1) $active = config('app.data.deleted');
                    // Data của bảng user
                    $pTUsers[] = [
                        // Tài khoản đăng nhập lấy luôn số điện thoại
                        'username' => $item['phone'] ?? null,
                        'dien_thoai' => $item['phone'] ?? null,
                        'anh_nguoi_dung' => $item['avt'] ?? null,                
                        'email' => $item['email'] ?? null,                        
                        'status' => $status ?? 1,
                        'active' => $active ?? 1,
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
                        'danh_gia' => '5/5',          
                        'cmnd_cccd' => null,
                        'bang_cap' => null,
                        'dien_thoai_du_phong' => null,
                        'dich_vu' => null,
                        'trinh_do' => null,
                        'password_hash' => null,
                        'password' => null,
                        'is_finish' => 1,                                      
                        // Thông tin về con                
                        'ho_ten_con' => null,
                        'ngay_sinh_cua_con' => Null,
                        'khoa_tai_khoan' => 0,
                        'ma_so_thue' => Null,
                        'trang_thai_vao_ca' => 'Đang rảnh',
                        'ten_ngan_hang' => Null,
                        'so_tai_khoan' => Null,
                        'chu_tai_khoan' => Null,                        
                        'leader_id' => Null,
                        'token_facebook' => Null,
                        'token_google' => Null,
                        'id_facebook' => Null,
                        'id_google' => Null,        
                    ];                   
                }            
            }     
            $uRoleData = [];                            
            // Thêm mới vào bảng user
            if(count($pTUsers) > 0) {
                $dUsers = $this->ttUsersRepository->createMultiple($pTUsers)->pluck('id')->toArray();
                foreach ($dUsers as $item) {                    
                    $uRoleData [] = [
                        'user_id' => $item,
                        'vaitro_id' => config('app.data.roles.isParent')
                    ];
                }
                // TTUserRoles::insert($uRoleData);
                $this->ttUsersRolesRepository->createMultiple($uRoleData);
            }            
        } catch (\Throwable $th) {                   
            Log::info($th->getMessage());
            return $th->getMessage();
        }
        return true;
    }
}
