<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    public $timestamps = false;
    protected $fillable = ['name', 'email', 'password'];
    protected $guarded = [];

    /* ELOQUENT RELATIONSHIP: One To Many */
	public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
