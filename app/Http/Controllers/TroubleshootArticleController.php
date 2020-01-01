<?php

namespace App\Http\Controllers;

use App\Article;
use App\ErrorReport;
use App\Services\ActivityService;
use App\Services\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TroubleshootArticleController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'title' => 'required|string',
            'content' => 'required|string',
            'id_error_report' => 'required|exists:error_reports,id',
        ];
    }

    public function index()
    {
        $troubleshoot = Article::whereNotNull('id_error_report')->whereNotNull('published_date')->paginate(5);

        return Response::view($troubleshoot);
    }

    public function view($id)
    {
        $article = Article::with('errorReport')->findOrFail($id);
        if (! (new ActivityService())->updateFieldArticle($id)) {
            return Response::plain(['message' => 'Bad request'], 400);
        }

        return Response::view($article);
    }

    public function getErrorReport($id)
    {
        $troubleshoot = Article::findOrFail($id);
        if ($troubleshoot->id_error_report === null) {
            return Response::plain(['message' => 'Bad request'], 400);
        } else {
            return Response::view($troubleshoot->errorReport);
        }
    }

    public function filterCategory($id)
    {
        $article = Article::findOrFail($id);
        if ($article->id_error_report === null) {
            return Response::plain(['message' => 'Bad request'], 400);
        }

        $errorReport = ErrorReport::with('article')
            ->where('id_interest_category', $article->errorReport->id_interest_category)->get();

        return Response::success($errorReport);
    }

    public function save(Request $request, $id = null)
    {
        $this->validate($request, $this->rules);
        $inputValue = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'last_edited' => date('Y-m-d H:i:s'),
            'id_error_report' => $request->input('id_error_report'),
            'id_user' => Auth::id(),
        ];
        if ($id === null) {
            $article = Article::create($inputValue);
        } else {
            $article = Article::findOrFail($id)->update($inputValue);
        }

        return Response::success($article, 201);
    }

    public function publish(Request $request, $id = null)
    {
        $this->validate($request, $this->rules);
        $inputValue = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'last_edited' => date('Y-m-d H:i:s'),
            'published_date' => date('Y-m-d H:i:s'),
            'id_error_report' => $request->input('id_error_report'),
            'id_user' => Auth::id(),
        ];
        if ($id === null) {
            $article = Article::create($inputValue);
        } else {
            $article = Article::findOrFail($id)->update($inputValue);
        }

        return Response::success($article);
    }
}
