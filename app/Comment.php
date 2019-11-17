<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'content', 'id_article', 'id_user',
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
