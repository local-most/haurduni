<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
	protected $table = 'order_detail';
	protected $fillable = [
		'order_id',
		'produk_id',
		'jumlah',
		'harga',
		'warna_id',
		'keterangan'
	];

	public function Order()
	{
		return $this->belongsTo( Order::class, 'order_id' );
	}

	public function Produk()
	{
		return $this->belongsTo( Produk::class, 'produk_id' );
	}

	public function Testimoni()
	{
		return $this->hasMany( Testimoni::class, 'order_detail_id' );
	}

	public function Warna()
	{
		return $this->belongsTo( Warna::class, 'warna_id' );
	}
}
