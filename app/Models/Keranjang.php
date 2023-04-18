<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keranjang extends Model
{
    use SoftDeletes;
    
    protected $table = 'keranjang';
    protected $fillable = [
        'user_id',
    	'produk_id',
    	'jumlah',
    	'warna_id',
    	'catatan',
        'status',
    ];

    public function User()
    {
        return $this->belongsTo( User::class, 'user_id' );
    }

    public function Produk()
    {
    	return $this->belongsTo( Produk::class, 'produk_id' )->withTrashed();
    }

    public function Warna()
    {
    	return $this->belongsTo( Warna::class, 'warna_id' );
    }
}
