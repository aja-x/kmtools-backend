<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestHistory extends Model
{
    protected $fillable = [
        'score', 'completed_time', 'id_user', 'id_test',
    ];

    public function test()
    {
        return $this->belongsTo('App\Test', 'id_test');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
