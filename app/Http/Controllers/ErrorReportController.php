<?php

namespace App\Http\Controllers;

use App\ErrorReport;
use App\InterestCategory;
use App\Services\ActivityService;
use App\Services\Http\Response;
use App\User;
use Illuminate\Http\Request;

class ErrorReportController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'title' => 'required|string',
            'content' => 'required|string',
            'id_user' => 'required|number',
            'id_interest_category' => 'required|number',
        ];
    }

    public function index()
    {
        $errorReport = ErrorReport::all()->paginate(5);

        return Response::view($errorReport);
    }

    public function view($id)
    {
        $errorReport = ErrorReport::findOrFail($id);
        if (! (new ActivityService())->updateFieldErrorReport($id)) {
            return Response::plain(['message' => 'Bad request'], 400);
        }

        return Response::view($errorReport);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, $this->rules);
            $user = User::findOrFail($request->input('id_user'));
            $interestCategory = InterestCategory::findOrFail($request->input('id_interest_category'));
        } catch (\Exception $exception) {
            return Response::plain(['message' => 'Error, bad request'], 400);
        }
        $errorReport = ErrorReport::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'id_user' => $request->input('id_user'),
            'id_interest_category' => $request->input('id_interest_category'),
        ]);

        return Response::success($errorReport, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, $this->rules);
            $user = User::findOrFail($request->input('id_user'));
            $interestCategory = InterestCategory::findOrFail($request->input('id_interest_category'));
        } catch (\Exception $exception) {
            return Response::plain(['message' => 'Error, bad request'], 400);
        }
        $errorReport = ErrorReport::findOrFail($id)->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'id_user' => $request->input('id_user'),
            'id_interest_category' => $request->input('id_interest_category'),
        ]);

        return Response::success($errorReport, 201);
    }

    public function destroy($id)
    {
        return Response::success(ErrorReport::destroy($id), 204);
    }
}
