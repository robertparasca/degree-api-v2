<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function includeRelation($user, $userRef) {
        if ($user->is_student) {
            $user = $userRef->with('student')->first();
        } else {
            $user = $userRef->with('staff')->first();
        }

        return $user;
    }

    public function addRoleFlag($user) {
        $user['role'] = $user->is_student ? 'student' : 'staff';
        return $user;
    }

    public function buildUser($request) {
        $userRef = User::where('id', $request->user()->id);
        $user = $userRef->first();

        $user = $this->includeRelation($user, $userRef);
        $user = $this->addRoleFlag($user);

        return $user;
    }

    public function createToken($user) {
        $token = $user->createToken('auth_token')->accessToken;

        return [
            'user' => $user,
            'access_token' => $token
        ];
    }

    public function login(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($validatedData)) {
            return $this->response422(['message' => 'Invalid credentials']);
        }

        $user = $this->buildUser($request);

        return $this->response200($this->createToken($user));
    }

    public function me(Request $request) {
        $user = $this->buildUser($request);
        return $this->response200($user);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        $request->user()->token()->delete();
        return $this->response200([]);
    }
}
