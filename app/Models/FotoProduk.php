<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoProduk extends Model
{
	protected $table = 'foto_produk';

	protected $fillable = [
		'foto',
		'produk_id'
	];

	public function Produk()
	{
		return $this->belongsTo(Produk::class, 'produk_id');
	}
}
