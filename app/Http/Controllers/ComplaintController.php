<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function teacherIndex(): View
    {
        return view('teacher.complaint.index');
    }

    public function parentIndex(): View
    {
        return view('parent.complaint.index');
    }
}
