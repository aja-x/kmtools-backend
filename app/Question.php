<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $fillable = [
        'content', 'id_test',
    ];

    public function questionChoice()
    {
        return $this->hasMany('question_choice');
    }

    public function test()
    {
        return $this->belongsTo('App\Test');
    }
}
