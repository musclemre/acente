<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users_modul extends Model
{
    protected $table = 'users_modul';
	public $timestamps = false;
	protected $fillable = ['user_id','modul','full','y1','y2','y3','y4','y5','y6','y7','y8','y9','y10'];

}
