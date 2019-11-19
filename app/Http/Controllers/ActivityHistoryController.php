<?php

namespace App\Http\Controllers;

use App\Article;
use App\Services\Http\Response;
use App\User;
use Illuminate\Support\Facades\Auth;

class ActivityHistoryController extends Controller
{
    public function getArticleActivity($id = null)
    {
        if ($id === null) {
            $user = User::with(['activityHistory' => function ($query) {
                $query->whereNotNull('id_article')->with('article');
            }])->findOrFail(Auth::id());
            return Response::view($user);
        } else {
            $user = User::with(['activityHistory' => function ($query) {
                $query->whereNotNull('id_article')->with('article');
            }])->findOrFail($id);
            return Response::view($user);
        }
    }

    public function getErrorReportActivity($id = null)
    {
        if ($id === null) {
            $user = User::with(['activityHistory' => function ($query) {
                $query->whereNotNull('id_error_report')->with('errorReport');
            }])->findOrFail(Auth::id());
            return Response::view($user);
        } else {
            $user = User::with(['activityHistory' => function ($query) {
                $query->whereNotNull('id_error_report')->with('errorReport');
            }])->findOrFail($id);
            return Response::view($user);
        }
    }
}
