<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportFilesLogIndex;
use App\ImportFilesLog;

class ImportFilesLogController extends Controller
{
    public function index(ImportFilesLogIndex $request)
    {
        $studentImports = ImportFilesLog::where('type', 'student_import')->orderBy('created_at', 'desc')->first();
        $scholarshipImports = ImportFilesLog::where('type', 'scholarship_import')->orderBy('created_at', 'desc')->first();

        return $this->response200([
            'studentImports' => $studentImports,
            'scholarshipImports' => $scholarshipImports
        ]);
    }
}
