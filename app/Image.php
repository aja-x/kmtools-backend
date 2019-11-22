<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url', 'name', 'type',
    ];

    public function article()
    {
        return $this->belongsToMany('App\Articles', 'article_images',
            'id_article', 'id_image')->as('articleImages')->withTimestamps();
    }

    public function errorReport()
    {
        return $this->belongsToMany('App\ErrorReport', 'error_report_images',
            'id_error_report', 'id_image')
            ->as('errorReportImages')->withTimestamps();
    }
}
