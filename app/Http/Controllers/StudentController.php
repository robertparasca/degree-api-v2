<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentDestroyRequest;
use App\Http\Requests\Student\StudentImportRequest;
use App\Http\Requests\Student\StudentIndexRequest;
use App\Http\Requests\Student\StudentShowRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Student;
use App\User;

class StudentController extends Controller
{
    public function index(StudentIndexRequest $request) {
        $students = User::where('is_student', true)->with('student')->paginate(5);
        return $this->response200($students);
    }

    public function show(StudentShowRequest $request, int $id) {
        $student = User::where('is_student', true)->where('id', $id)->with(['student.scholarships', 'student.tickets'])->first();
        if ($student) {
            return $this->response200($student);
        }

        return $this->response404();
    }

    public function update(StudentUpdateRequest $request, int $id) {
        $userData = $request->only(['email']);
        $data = $request->only([
            'email',
            'first_name'
        ]);
        $user = User::find($id);

        if (!$user->is_student) {
            return $this->response404();
        }

        $user->update($userData);
        Student::where('user_id', $user->id)->update($data);

        $student = User::where('id', $id)->with('student')->first();
        return $this->response200($student);
    }

    public function destroy(StudentDestroyRequest $request, int $id) {
        $deleted = User::destroy($id);
        if ($deleted) {
            return $this->response200(['Success']);
        }

        return $this->response422(['Error']);
    }

    public function import(StudentImportRequest $request) {

    }
}
