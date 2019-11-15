<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable = [
        'title', 'content', 'last_edited', 'published_date', 'id_user', 'id_interest_category', 'id_error_report',
    ];

    public function test()
    {
        return $this->hasMany('App\Test');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function interestCategory()
    {
        return $this->belongsTo('App\InterestCategory');
    }

    public function errorReport()
    {
        return $this->belongsTo('App\ErrorReport');
    }

}
