<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserKmAttribute extends Model
{

    protected $fillable = [
        'id_user', 'id_interest_category',
    ];

    public function userKmAttribute()
    {
        return $this->belongsTo('App\UserKmAttribute');
    }

}
