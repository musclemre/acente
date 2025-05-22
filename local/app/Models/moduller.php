<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class moduller extends Model
{
	protected $table = 'moduller';
	public $timestamps = false;
	protected $fillable = ['baslik','prefix', 'y1', 'y2', 'y3', 'y4', 'y5', 'y6', 'y7', 'y8', 'y9', 'y10'];
}
