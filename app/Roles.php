<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table='roles';
    protected $fillable=['name'];
    protected $primaryKey='id';
    //protected $timestamps='false';
    public function user()
    {
    	return $this->hasMany('App\User','role_id','id');
    }
}
