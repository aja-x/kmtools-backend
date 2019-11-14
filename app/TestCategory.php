<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCategory extends Model
{

    protected $fillable = [
        'name',
    ];

    public function test($key)
    {
        return $this->hasMany('App\Test', 'id_article');
    }
}
