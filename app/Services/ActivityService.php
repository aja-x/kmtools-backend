<?php

namespace App\Services;

use App\ActivityHistory;
use Illuminate\Support\Facades\Auth;

class ActivityService
{
    public function updateFieldArticle($id)
    {
        $article = ActivityHistory::updateOrCreate(
            ['id_user' => Auth::id(), 'id_article' => $id],
            ['last_accessed' => date('Y-m-d H:i:s')]
        );

        return ($article) ? true : false;
    }

    public function updateFieldErrorReport($id)
    {
        $error_report = ActivityHistory::updateOrCreate(
            ['id_user' => Auth::id(), 'id_error_report' => $id],
            ['last_accessed' => date('Y-m-d H:i:s')]
        );

        return ($error_report) ? true : false;
    }
}
