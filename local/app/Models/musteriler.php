<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class musteriler extends Model
{
    protected $table = 'musteriler';
	public $timestamps = false;
	
	protected $fillable = ['tc','ad_soyad','telefon','email','adres','cr_date','enable',];

}
