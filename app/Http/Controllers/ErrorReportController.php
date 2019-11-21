<?php

namespace App\Http\Controllers;

use App\ErrorReport;
use App\Services\ActivityService;
use App\Services\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ErrorReportController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'title' => 'required|string',
            'content' => 'required|string',
            'id_interest_category' => 'required|integer|exists:interest_categories,id',
        ];
    }

    public function index()
    {
        $errorReport = ErrorReport::paginate(5);

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
        $this->validate($request, $this->rules);
        $errorReport = ErrorReport::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'id_user' => Auth::id(),
            'id_interest_category' => $request->input('id_interest_category'),
            'last_updated' => date('Y-m-d H:i:s'),
        ]);

        return Response::success($errorReport, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);
        if (! $errorReport = ErrorReport::where('id_user', Auth::id())->findOrFail($id)) {
            return Response::plain("Validation failed", 400);
        }

        $errorReport->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'id_user' => Auth::id(),
            'id_interest_category' => $request->input('id_interest_category'),
            'last_updated' => date('Y-m-d H:i:s'),
        ]);

        return Response::success($errorReport, 201);
    }

    public function destroy($id)
    {
        if (! $errorReport = ErrorReport::where('id_user', Auth::id())->findOrFail($id)) {
            return Response::plain("Validation failed", 400);
        }

        return Response::success($errorReport->delete(), 204);
    }
}
