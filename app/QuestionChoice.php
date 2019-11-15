<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{

    protected $fillable = [
        'content', 'is_correct', 'id_question',
    ];

    public function questionChoice()
    {
        return $this->belongsTo('App\Question');
    }
}
