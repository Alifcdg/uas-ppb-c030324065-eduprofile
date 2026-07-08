<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hobby;

class HobbyController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Hobby::orderBy('nama_hobby')->get()
        ]);
    }
}
