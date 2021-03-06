<?php

namespace App\Http\Controllers;

use App\Article;
use App\Services\ActivityService;
use App\Services\Http\Response;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'title' => 'required|string',
            'content' => 'required|string',
            'id_interest_category' => 'required|integer',
        ];
    }

    public function index()
    {
        $article = Article::whereNotNull('id_interest_category')->whereNotNull('published_date')
            ->orderBy('id', 'desc')->paginate(6);

        return Response::view($article);
    }

    public function view($id)
    {
        $article = Article::findOrFail($id);
        if (! (new ActivityService())->updateFieldArticle($id)) {
            return Response::plain(['message' => 'Bad request'], 400);
        }

        return Response::view($article);
    }

    public function recommendation()
    {
        $user = User::findOrFail(Auth::id());

        return Response::view($user->UserKmAttribute->interestCategory->article()->paginate(6));
    }

    public function save(Request $request, $id = null)
    {
        $this->validate($request, $this->rules);
        $inputValue = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'last_edited' => date('Y-m-d H:i:s'),
            'id_interest_category' => $request->input('id_interest_category'),
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
            'id_interest_category' => $request->input('id_interest_category'),
            'id_user' => Auth::id(),
        ];
        if ($id === null) {
            $article = Article::create($inputValue);
        } else {
            $article = Article::findOrFail($id)->update($inputValue);
        }

        return Response::success($article);
    }

    public function destroy($id)
    {
        return Response::success(Article::destroy($id), 204);
    }
}
