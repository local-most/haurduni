<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
	use SoftDeletes;

	protected $table = 'order';
	protected $fillable = [
		'user_id',
		'total_harga',
		'total_tagihan',
		'total_ongkir',
		'tanggal',
		'keterangan',
		'status',
		'bukti_pembayaran',
		'is_delivered',
		'wilayah_id',
		'alasan_tolak'
	];

	public function User()
	{
		return $this->belongsTo( User::class, 'user_id' );
	}

	public function OrderDetail()
	{
		return $this->hasMany( OrderDetail::class );
	}

	public function Wilayah()
	{
		return $this->belongsTo( Wilayah::class, 'wilayah_id' );
	}
}
