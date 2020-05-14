<?php

namespace App\Http\Controllers;

use App\ActivateAccountToken;
use App\Http\Requests\Auth\ActivateAccountRequest;
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

        // && is_account_active
        if (!auth()->attempt($validatedData)) {
            return $this->response422(['message' => 'Invalid credentials']);
        }

        if (!$request->user()->is_account_active) {
            return $this->response422(['message' => 'Contul tau nu este activat inca. Verifica email-ul.']);
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

    public function activateAccount(ActivateAccountRequest $request) {
        $data = $request->only(['token', 'password']);

        $line = ActivateAccountToken::where('token', $data['token'])->first();

        if (!$line) {
            return $this->response401();
        }

        $user = User::find($line->user_id);

        $user->password = bcrypt($data['password']);
        $user->is_account_active = true;

        $result = $user->save();

        ActivateAccountToken::destroy($line->id);

        if ($result) {
            return $this->response200(['Success']);
        }

        return $this->response401();
    }
}
