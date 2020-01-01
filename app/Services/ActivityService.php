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
}
