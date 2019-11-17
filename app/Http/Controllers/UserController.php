<?php

namespace App\Http\Controllers;

use App\Services\Http\Response;
use App\User;
use App\UserKmAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|string',
            'username' => ['required', 'string',
                Rule::unique('users', 'username')->ignore(Auth::id()),
            ],
            'email' => ['required', 'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            'id_interest_category' => 'required|exists:interest_categories,id',
        ];
    }

    public function user()
    {
        return Response::plain(['user' => Auth::user()], 201);
    }

    public function view($id)
    {
        return Response::view(User::findOrFail($id));
    }

    public function setInterestCategory(Request $request)
    {
        $this->validate($request, [
            'id_interest_category' => 'required|integer',
        ]);

        $userKmAttribute = UserKmAttribute::create([
            'id_interest_category' => $request->input('id_interest_category'),
            'id_user' => Auth::id(),
        ]);

        return Response::success($userKmAttribute);
    }

    public function update(Request $request)
    {
        $this->validate($request, $this->rules);
        $user = User::with('userKmAttribute')->findOrFail(Auth::id());
        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
        ]);
        $user->userKmAttribute->update([
            'id_interest_category' => $request->input('id_interest_category'),
        ]);

        return Response::success($user);
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, ['password' => 'required']);

        $user = User::findOrFail($id);
        if (! (Hash::check($request->input('password'), $user->password))) {
            Response::plain(['message' => 'Wrong password'], 400);
        }

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return Response::success($user);
    }

    public function destroy()
    {
        return Response::success(User::destroy(Auth::id()), 204);
    }
}
