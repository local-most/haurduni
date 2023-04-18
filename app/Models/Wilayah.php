<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wilayah extends Model
{
	use SoftDeletes;

    protected $table = 'wilayah';

	protected $fillable = [
		'nama',
		'ongkir'
	];
}
