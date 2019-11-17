<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorReport extends Model
{
    protected $fillable = [
        'title', 'content', 'id_user', 'id_interest_category',
    ];

    public function article()
    {
        return $this->hasMany('App\Article', 'id_error_report');
    }

    public function interestCategory()
    {
        return $this->belongsTo('App\InterestCategory', 'id_interest_category');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
