<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::query()->with(['media'])->paginate(10);
        return response()->json($programs);
    }
}
