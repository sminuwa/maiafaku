<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    //
    public function salarySheet(){
        $staffs = User::join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
            ->where('users.status', 'active')->get();
        return view('pages.payroll.salary-sheet.index', compact('staffs'));
    }

    public function deduction(){
        $staffs = User::join('payroll_users', 'users.id', '=', 'payroll_users.user_id')
            ->where('users.status', 'active')->get();
        return view('pages.payroll.deductions.index', compact('staffs'));
    }
}
