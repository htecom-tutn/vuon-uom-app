<?php

namespace App\Services\TUsers;

use App\Models\VuonUomApp\TTUser;
use App\Repositories\TTUsersRepository;
use App\Repositories\TUsersRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class TUserServices implements TUserInterface
{
    protected $tUsersRepository;
    protected $ttUsersRepository;
    public function __construct(TUsersRepository $tUsersRepository, TTUsersRepository $ttUsersRepository) {       
        $this->tUsersRepository = $tUsersRepository; // Trông trẻ pro     
    }
    //->where('status', '<>' , 1)
    public function getDataTT(){
        $model = $this->tUsersRepository->with(['devices'])->get();
        return $model;
    }

    public function convertDataFromTrongTrePro($params){
        $data = $this->getDataTT();        
        // Data mới của bảng vườn ươm
        $params = [];
        $status = config('app.data.notActive');        
        $active = config('app.data.notDeleted');
        $hashPassword = Hash::make('123456aA@');
        
        foreach ($data as $item) {
            $mobile_token = json_encode($item['devices']->pluck('fcm_token')->toArray());            
            if($item['status'] == 0 || $item['status'] == 1) $status = $item['status'];
            if($item['status'] == -1) $active = config('app.data.deleted');
            $params[] = [
                // Tài khoản đăng nhập lấy luôn số điện thoại
                'username' => $item['phone'] ?? null,
                'dien_thoai' => $item['phone'] ?? null,
                'anh_nguoi_dung' => $item['avt'] ?? null,
                'password_hash' => $hashPassword,
                // 'password' => Hash::make($item['password']) ??  Hash::make('123456aA@'),
                'email' => $item['email'] ?? null,
                'auth_key' => !empty($item['last_login']) ? Str::random(10) : '',
                'status' => $status ?? 0,
                'active' => $active ?? 0,
                'created_at' => $item['created_at'] ?? Carbon::now()->format('Y-m-d H:i'),                               
                'hoten' => $item['full_name'] ?? null,
                'dia_chi' => $item['address'] ?? null,
                'mobile_token' => $mobile_token ?? null,                
                'ngay_sinh' =>  $item['dob'] ?? null,   
                'gioi_tinh' =>  $item['gender'] ?? null,   
                'vi_dien_tu' =>  $item['money'] ?? null,   
                'ghi_chu' =>  $item['note'] ?? null,   
                'is_admin' =>  config('app.data.isNotAdmin') ?? null,   // Thêm cả bảng trong_tre_vaitrouser                
                'danh_gia' => null,  

                'cmnd_cccd' => null,
                'bang_cap' => null,
                'dien_thoai_du_phong' => null,
                'dich_vu' => null,
                'trinh_do' => null,
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
                'is_finish' => Null,
                'leader_id' => Null,
                'token_facebook' => Null,
                'token_google' => Null,
                'id_facebook' => Null,
                'id_google' => Null,
            ];           
        }      
        $insert = $this->ttUsersRepository->insert($data);
        dd($insert);
    }
}
