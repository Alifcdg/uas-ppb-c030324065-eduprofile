<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;

class AngkatanController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Angkatan::orderBy('tahun')->get()
        ]);
    }
}
