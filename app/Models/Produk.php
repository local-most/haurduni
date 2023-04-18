<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
	use SoftDeletes;
	
	protected $table = 'produk';

	protected $fillable = [
		'nama',
		'kategori_id',
		'satuan_id',
		'harga',
		'berat',
		'deskripsi',
		'stok',
		'foto',
		'warna_id'
	];

	public function Kategori()
	{
		return $this->belongsTo( Kategori::class, 'kategori_id');
	}

	public function Satuan()
	{
		return $this->belongsTo( Satuan::class, 'satuan_id');
	}

	public function Foto()
	{
		return $this->hasMany( FotoProduk::class );
	}

	public function OrderDetail()
	{
		return $this->hasMany( OrderDetail::class, 'produk_id');
	}

	public function Testimoni()
	{
		return $this->hasMany( Testimoni::class, 'produk_id');
	}

	public function Diskon()
	{
		return $this->hasMany( Diskon::class, 'produk_id');
	}
}
