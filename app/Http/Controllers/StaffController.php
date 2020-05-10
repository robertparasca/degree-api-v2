<?php

namespace App\Http\Controllers;

use App\Http\Requests\Staff\StaffDestroyRequest;
use App\Http\Requests\Staff\StaffIndexRequest;
use App\Http\Requests\Staff\StaffStoreRequest;
use App\Http\Requests\Staff\StaffUpdateRequest;
use App\Staff;
use App\User;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index(StaffIndexRequest $request) {
        $staffList = User::where('is_student', false)->with('staff')->paginate(5);
        return $this->response200($staffList);
    }

    public function show(StaffIndexRequest $request, int $id) {
        $staff = User::where('is_student', false)->where('id', $id)->with('staff')->first();
        if ($staff) {
            return $this->response200($staff);
        }

        return $this->response404();
    }

    public function store(StaffStoreRequest $request) {
        $userData = $request->only(['email', 'password']);
        $staffData = $request->only([
            'first_name',
            'last_name'
        ]);

        $userData['password'] = bcrypt($userData['password']);

        $user = User::create($userData);

        $staffData['user_id'] = $user->id;

        $staff = Staff::create($staffData);

        return $this->response200(['Success']);
    }

    public function update(StaffUpdateRequest $request, int $id) {
        $userData = $request->only(['email']);
        $staffData = $request->only([
            'first_name',
            'last_name'
        ]);
        $user = User::find($id);

        if ($user->is_student) {
            return $this->response404();
        }

        $user->update($userData);
        Staff::where('user_id', $user->id)->update($staffData);

        $staff = User::where('id', $id)->with('staff')->first();

        return $this->response200($staff);
    }

    public function destroy(StaffDestroyRequest $request, int $id) {
        if (Auth::user()->id == $id) {
            return $this->response422(['You cannot delete yourself.']);
        }
        $deleted = User::destroy($id);
        if ($deleted) {
            return $this->response200(['Success']);
        }

        return $this->response422(['Error']);
    }
}
