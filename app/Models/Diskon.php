<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon extends Model
{
    use SoftDeletes;
	
	protected $table = 'diskon';

	protected $fillable = [
		'produk_id',
		'harga',
		'status'
	];

	public function Produk()
	{
		return $this->belongsTo(Produk::class, 'produk_id');
	}
}
