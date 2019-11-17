<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Services\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'content' => 'required|string',
            'id_article' => 'required|exists:articles,id',
        ];
    }

    public function getArticleComments($id)
    {
        $article = Article::findOrFail($id);
        return Response::view($article->comment);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $comment = Comment::create([
            'content' => $request->input('content'),
            'id_user' => Auth::id(),
            'id_article' => $request->input('id_article'),
        ]);
        return Response::success($comment, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);
        $comment = Comment::findOrFail($id)->update([
            'content' => $request->input('content'),
            'id_user' => Auth::id(),
            'id_article' => $request->input('id_article'),
        ]);
        return Response::success($comment);
    }

    public function destroy($id)
    {
        return Response::success(Comment::findOrFail($id)->destroy(), 204);
    }

}
