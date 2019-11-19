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
        return Response::view(Article::whereNotNull('id_error_report')->whereNotNull('published_date')->get());
    }

    public function view($id)
    {
        $article = Article::with('errorReport')->findOrFail($id);
        if (!(new ActivityService())->updateFieldArticle($id)) {
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
        } else {
            $errorReport = ErrorReport::where('id_error_report', $article->errorReport->id_error_report)
                ->get();
            $troubleshoot = [];
            foreach ($errorReport as $item) {
                $troubleshoot[] = $item->article;
            }

            return Response::success($troubleshoot);
        }
    }

    public function save(Request $request, $id = null)
    {
        $this->validate($request, $this->rules);
        if ($id === null) {
            $article = Article::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'last_edited' => date('Y-m-d H:i:s'),
                'id_error_report' => $request->input('id_error_report'),
                'id_user' => Auth::id(),
            ]);
        } else {
            $article = Article::findOrFail($id)->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'last_edited' => date('Y-m-d H:i:s'),
                'id_error_report' => $request->input('id_error_report'),
                'id_user' => Auth::id(),
            ]);
        }

        return Response::success($article, 201);
    }

    public function publish(Request $request, $id = null)
    {
        $this->validate($request, $this->rules);
        if ($id === null) {
            $article = Article::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'last_edited' => date('Y-m-d H:i:s'),
                'published_date' => date('Y-m-d H:i:s'),
                'id_error_report' => $request->input('id_error_report'),
                'id_user' => Auth::id(),
            ]);
        } else {
            $article = Article::findOrFail($id)->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'last_edited' => date('Y-m-d H:i:s'),
                'published_date' => date('Y-m-d H:i:s'),
                'id_error_report' => $request->input('id_error_report'),
                'id_user' => Auth::id(),
            ]);
        }

        return Response::success($article);
    }
}
