<?php

namespace App\Models\VuonUomApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTUser extends Model
{
    use HasFactory;
    use HasFactory;
    protected $connection = 'mysql1';
    protected $table = 'trong_tre_user';
    protected $fillable = [
        'id',
        'username',
        'anh_nguoi_dung',
        'password_hash',
        'email',
        'auth_key',
        'status',
        'created_at',
        'updated_at',
        'password',
        'hoten',
        'dien_thoai',
        'dia_chi',
        'active',
        'mobile_token',
        'ma_kich_hoat',
        'ngay_sinh',
        'dien_thoai_du_phong',
        'dich_vu',
        'trinh_do',
        'danh_gia',
        'gioi_tinh',
        'vi_dien_tu',
        'cmnd_cccd',
        'bang_cap',
        'ghi_chu',
        'is_admin',
        'ho_ten_con',
        'ngay_sinh_cua_con',
        'khoa_tai_khoan',
        'ma_so_thue',
        'trang_thai_vao_ca',
        'ten_ngan_hang',
        'so_tai_khoan',
        'chu_tai_khoan',
        'is_finish',
        'leader_id',
        'token_facebook',
        'token_google',
        'id_facebook',
        'id_google',

    ];
}
