<?php

namespace App\Http\Controllers;

use App\ActivateAccountToken;
use App\Http\Requests\Student\StudentDestroyRequest;
use App\Http\Requests\Student\StudentImportRequest;
use App\Http\Requests\Student\StudentIndexRequest;
use App\Http\Requests\Student\StudentShowRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\ImportFilesLog;
use App\Mail\ActivateAccount;
use App\Student;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

    public function setActiveYear($activeYear) {
        switch ($activeYear) {
            case 1:
                return 'I';
            case 2:
                return 'II';
            case 3:
                return 'III';
            case 4:
                return 'IV';
            default:
                return 'V';
        }
    }

    public function import(StudentImportRequest $request) {
        $path = Storage::put('import', $request->file('file'));
        $year = $request->input('year');
        $activeYear = explode('_', $year)[0];
        $cycleOfStudy = explode('_', $year)[1];
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

                if (!$rowData['Contact_email']) break;

                $studentData = [
                    "unique_registration_number" => $rowData["Nr.matricol"],
                    "first_name" => $rowData["PRENUME"],
                    "last_name" => $rowData["NUME_ACTUAL"],
                    "birth_name" => $rowData["NUME_NASTERE"],
                    "father_name_initial" => $rowData["INITIALE_TATA"],
                    "email" => $rowData["Contact_email"],
                    "full_name" => $rowData["NUME SI PRENUME"],
                    "group" => $rowData["GRUPA I"],
                    "active_year" => $this->setActiveYear($activeYear),
                    "field_of_study" => $rowData["Domeniu studii"],
                    "program_of_study" => $rowData["ID_program_studii_actual"],
                    "admission_grade" => $rowData["Medie adm."],
                    "admission_year" => $rowData["An admitere"],
                    "start_year" => $rowData["An inmatr"],
                    "is_paying_tax" => strtolower($rowData["Taxa"]) === 'nu' ? false : true,
                    "cycle_of_study" => $cycleOfStudy
                ];

                $userData = [
                    "email" => $studentData["email"],
                    "is_student" => true,
                    "is_account_active" => false,
                    "password" => bcrypt(Str::random(40)),
                ];

                $userExists = User::where('email', $rowData["Contact_email"])->first();

                if ($userExists) {
                    $existingStudent = Student::where('user_id', $userExists->id)->first();
                    $existingStudent->update($studentData);
                } else {
                    $user = User::create($userData);
                    $studentData['user_id'] = $user->id;
                    Student::create($studentData);

                    $token = ActivateAccountToken::create([
                        'token' => md5(Str::random(40) . microtime(true)),
                        'user_id' => $user->id
                    ]);

                    Mail::to($user)->send(new ActivateAccount($user, $token->token));
                }
            }
        }

        ImportFilesLog::create([
            'type' => 'student_import'
        ]);
        return $this->response200(['Success import']);
    }
}
