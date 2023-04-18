<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;


class Notice extends Model
{
	use Notifiable, Uuid;

	protected $table = 'notice';
	protected $primaryKey = 'id';
	protected $keyType = 'string';
	public $incrementing = false;

	protected $fillable = [
		'id',
		'notice',
		'noticedes',
		'noticelink',
		'telegramid',
	];
}
