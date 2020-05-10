<?php

namespace App\Http\Controllers;

use App\Institute;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function index() {
        $institute = Institute::first();
        return $this->response200($institute);
    }

    public function update(Request $request) {
        dd($request);
    }
}
