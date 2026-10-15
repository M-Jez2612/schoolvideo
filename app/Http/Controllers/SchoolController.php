<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;
use App\Models\Major;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Student;

class SchoolController extends Controller
{
    public function profile()
    {
        $school = SchoolProfile::first();
        $majors = Major::withCount('students')->get();
        $teachers = Teacher::with(['user.profile'])->get();
        $totalStudents = Student::count();
        $totalClasses = SchoolClass::count();

        return view('school.profile', compact('school', 'majors', 'teachers', 'totalStudents', 'totalClasses'));
    }

    public function directory()
    {
        $classes = SchoolClass::with(['major', 'students.user.profile'])->get();
        $teachers = Teacher::with(['user.profile'])->get();
        $majors = Major::all();

        return view('school.directory', compact('classes', 'teachers', 'majors'));
    }
}
