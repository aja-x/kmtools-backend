<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityHistory extends Model
{
    protected $fillable = [
        'id_user', 'id_article', 'last_accessed',
    ];

    public function article()
    {
        return $this->belongsTo('App\Article', 'id_article');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
