<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ErrorReport extends Model
{
    protected $fillable = [
        'title', 'content', 'id_user', 'id_interest_category', 'last_updated',
    ];

    public function article()
    {
        return $this->hasMany('App\Article', 'id_error_report');
    }

    public function activityHistory()
    {
        return $this->hasMany('App\ActivityHistory', 'id_error_report');
    }

    public function interestCategory()
    {
        return $this->belongsTo('App\InterestCategory', 'id_interest_category');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function image()
    {
        return $this->belongsToMany('App\Image', 'error_report_images',
            'id_error_report', 'id_image')
            ->as('errorReportImages')->withTimestamps();
    }
}
