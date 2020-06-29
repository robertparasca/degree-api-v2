<?php

namespace App\Http\Controllers;

use App\ImportFilesLog;
use App\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ScholarshipController extends Controller
{
    public function import(Request $request) {
        $path = Storage::put('import', $request->file('file'));
        $path = Storage::path($path);
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();
        $columns = [];
        Scholarship::truncate();
        foreach ($data as $index => $row) {
            if ($index === 0) {
                $columns = $row;
            } else {
                $rowData = array_combine($columns, $row);
                $scholarshipData = [
                    "unique_registration_number" => $rowData["Nr. Matricol"],
                    "amount" => $rowData["Suma"],
                    "type" => $rowData["Tip"]
                ];
                Scholarship::create($scholarshipData);
            }
        }


        ImportFilesLog::create([
            'type' => 'scholarship_import'
        ]);
        return $this->response200(['Success import']);
    }
}
