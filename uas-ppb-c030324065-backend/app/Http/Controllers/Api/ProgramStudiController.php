<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;

class ProgramStudiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => ProgramStudi::orderBy('nama_program_studi')->get()
        ]);
    }
}
