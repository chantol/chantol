<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username','email', 'password','active','role_id',
    ];

   
    protected $hidden = [
        'password', 'remember_token',
    ];

     public function role(){
        return $this->hasOne('App\Roles','id','role_id');
    }
    private function CheckifuserhasRole($need_role)
    {
        return (strtolower($need_role) == strtolower($this->role->name)) ? true : null;
    }
    
    public function hasRole($roles){
        if(is_array($roles))
        {
            foreach ($roles as $need_role){

                if($this->CheckifuserhasRole($need_role)){
                    return true;
                }
           
            }
        }else
        {
            return $this->CheckifuserhasRole($roles);
        }
        return false;
    }
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
