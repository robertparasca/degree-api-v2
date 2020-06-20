<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentDestroyRequest;
use App\Http\Requests\Student\StudentImportRequest;
use App\Http\Requests\Student\StudentIndexRequest;
use App\Http\Requests\Student\StudentShowRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

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
        $path = Storage::put('import', $request->file('file'));
        $path = Storage::path($path);
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();
        $columns = [];
        foreach ($data as $index => $row) {
            if ($index === 0) {
                $columns = $row;
            } else {
                $rowData = array_combine($columns, $row);
                dd($rowData);
                $studentData = [
                    "unique_registration_number" => $rowData["Nr.matricol"],
                    "email" => $rowData["Contact_email"],
                    "full_name" => $rowData["NUME SI PRENUME"],
                    "group" => $rowData["GRUPA I"],
                    "active_year" => $request->input('year'),
                    "field_of_study" => $rowData["Domeniu studii"],
                    "program_of_study" => $rowData["GRUPA I"],
                    "admission_grade" => $rowData["GRUPA I"],
                    "admission_year" => $rowData["GRUPA I"],
                    "start_year" => $rowData["GRUPA I"],
                    "is_paying_tax" => $rowData["GRUPA I"],
                ];
                $userData = [
                    "email" => $rowData["Contact_email"],
                    "is_student" => true,
                    "is_account_active" => false,
                ];
                $userExists = User::where('email', $rowData["Contact_email"])->first();

                if ($userExists) {

                    return;
                }
                $user = User::create($userData);
                $studentData['user_id'] = $user->id;
                Student::create($studentData);

            }
        }
    }
}
