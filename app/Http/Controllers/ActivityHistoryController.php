<?php

namespace App\Http\Controllers;

use App\Article;
use App\ErrorReport;
use App\Services\Http\Response;
use App\User;
use Illuminate\Http\Request;
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

    public function searchResult(Request $request)
    {
        $this->validate($request, [
            'query' => 'required|max:40',
        ]);

        $resultArticle = Article::where('title', 'LIKE', "%{$request->input('query')}%")->get();
        $resultUser = User::where('name', 'LIKE', "%{$request->input('query')}%")->get();
        $resultErrorReport = ErrorReport::where('title', 'LIKE', "%{$request->input('query')}%")->get();

        return Response::plain(['article' => ['count' => $resultArticle->count(), 'data' => $resultArticle],
            'user' => ['count' => $resultUser->count(), 'data' => $resultUser],
            'error_report' => ['count' => $resultErrorReport->count(), 'data' => $resultErrorReport], ]);
    }
}
