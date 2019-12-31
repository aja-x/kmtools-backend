<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public function userKmAttribute()
    {
        return $this->hasMany('App\UserKmAttribute', 'id_interest_category');
    }

    public function article()
    {
        return $this->hasMany('App\Article', 'id_interest_category');
    }

}
