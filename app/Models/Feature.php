<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'name', 'value'
    ];
    public static function getByName($slug)
    {
        $query = self::select(['name', 'value'])->firstWhere('name', $slug);

        if ($query) {
        	try {
        		$query->value = json_decode($query->value);
        	} catch (Exception $e) {
        		
        	}
        }

        return $query;
    }
}
