<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Categories;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

   const USER_ADMIN_ROLE = 1;
   const USER_MOD_ROLE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['last_login_time', 'created_time', 'customer_type_name'];

    public function getCreatedTimeAttribute()
    {
        $created_time = null;
        if (!empty($this->created_at)) {
            $created_time = Carbon::parse($this->created_at);
        } 
        return parseDateFormat($created_time, true);
    }

    public function getLastLoginTimeAttribute()
    {
        $last_login_time = null;
        if (!empty($this->last_login)) {
            $last_login_time = Carbon::parse($this->last_login);
        } 
        return parseDateFormat($last_login_time, true);
    }

    public function getCustomerTypeNameAttribute()
    {
        $customer_type_name = '';
        if ($this->customer_type > 0) {
            $customer_type = Categories::get(config('env.LANGUAGE_DEFAULT'), $this->customer_type);
            if(isset($customer_type->id) && $customer_type->id){
                $customer_type_name = $customer_type->name;
            }
        } 
        return $customer_type_name;
    }

    public static function listStaffs($limit = 0, $from = 0){
        $list = User::where("is_staff", 1)->where("active", 1)->where("deleted", 0)
                ->offset($from)->limit($limit)->get();
        return $list;
    }

    public static function listCustomers($param_search = [], $limit = 0, $from = 0){
        $query = User::where("is_staff", 0)->where("active", 1)->where("deleted", 0);
        if(isset($param_search['keyword']) && !empty($param_search['keyword'])){
            $query->whereRaw("(name LIKE '%".addslashes($param_search['keyword'])."%' OR phone LIKE '%".addslashes($param_search['keyword'])."%')");
        }
        $list = $query->offset($from)->limit($limit)->get();
        return $list;
    }

    public static function getCustomerByPhone($phone, $check_active = false){
        $query = User::where("is_staff", 0)->where("phone", $phone)->where("deleted", 0);
        if($check_active === true){
            $query->where("active", 1);
        }
        return $query->first();
    }

    public function hasRole($role_name){
        if($role_name == 'admin' && $this->role_id == self::USER_ADMIN_ROLE){
            return true;
        } else if($role_name == 'mod' && $this->role_id == self::USER_MOD_ROLE){
            return true;
        }
        return false;
    }
}
