<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    protected $fillable = [
        'duration', 'id_article', 'id_test_category',
    ];

    public function testCategory()
    {
        return $this->belongsTo('App\TestCategory', 'id_test_category');
    }

    public function article()
    {
        return $this->belongsTo('App\Article', 'id_article');
    }

    public function question()
    {
        return $this->belongsTo('App\Question', 'id_question');
    }

    public function testHistory()
    {
        return $this->hasMany('App\TestHistory', 'id_test');
    }


}
