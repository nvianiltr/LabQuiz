<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $table = "items";
	public $timestamps = false;
    protected $fillable = ['name', 'user_id', 'price', 'stock'];
    protected $guarded = [];

    /* ELOQUENT RELATIONSHIP: One To Many (Inverse) */
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
}
