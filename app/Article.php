<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title', 'content', 'last_edited', 'published_date', 'id_user', 'id_interest_category', 'id_error_report',
    ];

    public function comment()
    {
        return $this->hasMany('App\Comment', 'id_article');
    }

    public function test()
    {
        return $this->hasMany('App\Test', 'id_article');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function interestCategory()
    {
        return $this->belongsTo('App\InterestCategory', 'id_interest_category');
    }

    public function errorReport()
    {
        return $this->belongsTo('App\ErrorReport', 'id_error_report');
    }
}
