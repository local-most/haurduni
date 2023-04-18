<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
	protected $table = 'testimoni';
	protected $fillable = [
		'produk_id',
		'order_detail_id',
		'user_id',
		'keterangan',
		'rate',
		'gambar',
	];

	public function Produk()
	{
		return $this->belongsTo( Produk::class, 'produk_id' );
	}

	public function User()
	{
		return $this->belongsTo( User::class, 'user_id' );
	}
}
