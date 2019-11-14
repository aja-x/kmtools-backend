<?php

namespace App\Http\Controllers;

use App\Article;
use App\ErrorReport;
use App\Test;
use App\Services\Http\Response;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'query' => 'required|max:40'
        ];
    }
    public function result(Request  $request)
    {
        $this->validate($request, $this->rules);

        $resultArticle=Article::where('title', 'LIKE', "%{$request->input('query')}%")->get();
        $resultUser=User::where('name', 'LIKE', "%{$request->input('query')}%")->get();
        $resultErrorReport=ErrorReport::where('title', 'LIKE', "%{$request->input('query')}%")->get();
        return Response::plain(['article' => $resultArticle, 'user' => $resultUser,
            'error_report' => $resultErrorReport]);

    }
}
