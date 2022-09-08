<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecapController extends Controller
{
    public function studentAttendance()
    {
        $attendances = DB::table('attendances_attendance')
            ->join('auth_user', 'attendances_attendance.user_id', '=', 'auth_user.id')
            ->join('attendances_attendancetimetable', 'attendances_attendance.timetable_id', '=', 'attendances_attendancetimetable.id')
            ->select('auth_user.first_name', 'attendances_attendancetimetable.role', 'attendances_attendance.status', 'attendances_attendancetimetable.date', 'attendances_attendance.clock_in', 'attendances_attendance.clock_out')
            ->where('attendances_attendancetimetable.role', 'MRD')
            ->latest('attendances_attendance.id')
            ->paginate(36);

        return view('recaps.student-attendance', compact('attendances'));
    }

    public function nonStudentAttendance()
    {
        $attendances = DB::table('attendances_attendance')
            ->join('auth_user', 'attendances_attendance.user_id', '=', 'auth_user.id')
            ->join('attendances_attendancetimetable', 'attendances_attendance.timetable_id', '=', 'attendances_attendancetimetable.id')
            ->select('auth_user.first_name', 'attendances_attendancetimetable.role', 'attendances_attendance.status', 'attendances_attendancetimetable.date', 'attendances_attendance.clock_in', 'attendances_attendance.clock_out')
            ->whereIn('attendances_attendancetimetable.role', ['GRU', 'KWN'])
            ->latest('attendances_attendance.id')
            ->paginate(50);

        return view('recaps.non-student-attendance', compact('attendances'));
    }

    public function classroomAttendance()
    {
        $subjects = DB::table('classrooms_classroomsubject')
            ->join('classrooms_classroom', 'classrooms_classroomsubject.classroom_id', '=', 'classrooms_classroom.id')
            ->select('classrooms_classroomsubject.id', 'classrooms_classroomsubject.name as subject', 'classrooms_classroom.grade as classroom');

        $timetables = DB::table('classrooms_classroomtimetable')
            ->joinSub($subjects, 'classrooms_subject', function ($join) {
                $join->on('classrooms_classroomtimetable.subject_id', '=', 'classrooms_subject.id');
            })
            ->select('classrooms_classroomtimetable.id', 'classrooms_subject.classroom', 'classrooms_subject.subject', 'classrooms_classroomtimetable.date', 'classrooms_classroomtimetable.start_time', 'classrooms_classroomtimetable.end_time');

        $attendances = DB::table('classrooms_classroomattendance')
            ->join('auth_user', 'classrooms_classroomattendance.student_id', '=', 'auth_user.id')
            ->joinSub($timetables, 'classrooms_timetable', function ($join) {
                $join->on('classrooms_classroomattendance.timetable_id', '=', 'classrooms_timetable.id');
            })
            ->select('auth_user.first_name', 'classrooms_classroomattendance.status', 'classrooms_timetable.classroom', 'classrooms_timetable.subject', 'classrooms_timetable.start_time', 'classrooms_timetable.end_time', 'classrooms_timetable.date')
            ->latest('classrooms_classroomattendance.id')
            ->paginate(36);

        return view('recaps.classroom-attendance', compact('attendances'));
    }

    public function journal()
    {
        $subjects = DB::table('classrooms_classroomsubject')
            ->join('auth_user', 'classrooms_classroomsubject.teacher_id', '=', 'auth_user.id')
            ->join('classrooms_classroom', 'classrooms_classroomsubject.classroom_id', '=', 'classrooms_classroom.id')
            ->select('classrooms_classroomsubject.id', 'auth_user.first_name', 'classrooms_classroom.grade as classroom', 'classrooms_classroomsubject.name as subject');

        $journals = DB::table('classrooms_classroomjournal')
            ->join('classrooms_classroomtimetable', 'classrooms_classroomjournal.timetable_id', '=', 'classrooms_classroomtimetable.id')
            ->joinSub($subjects, 'classrooms_subject', function ($join) {
                $join->on('classrooms_classroomjournal.subject_grade_id', '=', 'classrooms_subject.id');
            })->select('classrooms_subject.first_name', 'classrooms_subject.classroom', 'classrooms_subject.subject', 'classrooms_classroomjournal.description', 'classrooms_classroomtimetable.date')
            ->paginate(50);

        return view('recaps.journal', compact('journals'));
    }
}
