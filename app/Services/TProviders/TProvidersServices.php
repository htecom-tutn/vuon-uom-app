<?php

namespace App\Services\TProviders;

use App\Models\TrongTrePro\TProviders;
use App\Models\VuonUomApp\TTUser;
use App\Models\VuonUomApp\TTUserRoles;
use App\Repositories\TProvidersRepository;
use App\Repositories\TTUsersRepository;
use App\Repositories\TTUsersRolesRepository;
use App\Repositories\TUsersRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TProvidersServices implements TProvidersInterface
{
    protected $tProvidersRepository;
    protected $ttUsersRepository;
    protected $ttUsersRolesRepository;
    public function __construct(
        TProvidersRepository $tProvidersRepository,
        TTUsersRolesRepository $ttUsersRolesRepository,
        TTUsersRepository $ttUsersRepository
    ) {
        $this->tProvidersRepository = $tProvidersRepository;
        $this->ttUsersRepository = $ttUsersRepository; // vươn ươm   
        $this->ttUsersRolesRepository = $ttUsersRolesRepository; // vươn ươm    
    }

    // 170735
    public function check_roles_exist($user_id){
        $status = false;
        // $dem = $this->ttUsersRepository->where('username', $username)->count();
        $dem = TTUserRoles::where('user_id', $user_id)->where('vaitro_id', config('app.data.roles.isTeacher'))->count();        
        if($dem > 0) $status = true;
        return $status;
    }
    public function check_users_exist($username){                
        $status = false;
        // $dem = $this->ttUsersRepository->where('username', $username)->count();
        $dem = TTUser::where('username', $username)->where('ghi_chu', config('app.data.roles.isTeacher'))->count();        
        if($dem > 0) $status = true;
        return $status;
    }
    private function getDataTProviders()
    {
        try {
            $status = config('app.data.active'); //1        
            $active = config('app.data.notDeleted'); //1                
            $pTUsers = [];
            $data = $this->tProvidersRepository->with(['devices'])->get();
            $lstPhone = [];  
            foreach ($data as $item) {             
                // $password = (string)$item['password'];                
                if (count($item['devices']) > 0) $mobile_token = json_encode($item->devices->pluck('fcm_token')->toArray());
                else $mobile_token = null;                    
                if ($item['status'] == 0) $status = $item['status'];
                if ($item['status'] == -1) $active = config('app.data.deleted');
                
                $exist = $this->check_users_exist($item['phone']);               
                if(!$exist) {
                    $pTUsers[] = [
                        // Tài khoản đăng nhập lấy luôn số điện thoại
                        'username' => $item['phone'] ?? null,
                        // 'password' => $password ?? null,
                        'dien_thoai' => $item['phone'] ?? null,
                        'anh_nguoi_dung' => $item['avt'] ?? null,
                        'email' => $item['email'] ?? null,
                        'status' => $status ?? 1,
                        'active' => $active ?? 1,
                        'created_at' => Carbon::now()->format('Y-m-d H:i'),                    
                        'hoten' => $item['full_name'] ?? null,
                        'dia_chi' => $item['address'] ?? null,
                        'mobile_token' => $mobile_token ?? null,
                        'ngay_sinh' =>  $item['dob'] ?? null,
                        'gioi_tinh' =>  isset($item['gender']) ? TProviders::GENDER_MAP[$item['gender']] : "Khác",
                        'vi_dien_tu' =>  $item['money'] ?? null,                    
                        'ghi_chu' =>  config('app.data.roles.isTeacher'),
                        'is_admin' => config('app.data.isNotAdmin') ?? null,   // Thêm cả bảng trong_tre_vaitrouser                                    
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
                // Data của bảng user
                $lstPhone[] = $item['phone'];
            }
            $uRoleData = [];
            // Thêm mới vào bảng user
            if (count($pTUsers) > 0){                
                $this->ttUsersRepository->createMultiple($pTUsers);
                $dUsers = TTUser::where('ghi_chu', config('app.data.roles.isTeacher'))->get();
                foreach ($dUsers as $item) {
                    $uRoleExist = $this->check_roles_exist($item['id']);
                    if(!$uRoleExist) {
                        $uRoleData[] = [
                            'user_id' => $item['id'],
                            'vaitro_id' => config('app.data.roles.isTeacher')
                        ];
                    }
                }                                   
                if(count($uRoleData) > 0) $this->ttUsersRolesRepository->createMultiple($uRoleData);                
            }
        } catch (\Exception $e) {               
            Log::error("Lỗi xử lý dữ liệu: " . $e->getMessage());
            return [
                "code" =>  401,
                "message" => $e->getMessage()
            ];
        }
    }
    public function cvDataFromTrongTrePro()
    {
        try {
            Log::info('Convert dữ liệu từ app cũ sang app mới');
            $this->DataTTPro();
            return true;
        } catch (\Throwable $th) {
            Log::info('Lỗi convert dữ liệu báo cáo tồn kho theo vị trí: ' . Carbon::now() . '-' . $th->getMessage() . ' Dòng: ' . $th->getLine());
        }
    }
    private function DataTTPro()
    {
        $totalRecord = $this->tProvidersRepository->with('devices')->count();
        $limit = 500;
        for ($i = 0; $i < $totalRecord; $i += $limit) {
            $this->getDataTProviders($i, $limit);
        }
    }
}
