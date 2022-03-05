<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayrollPayslipController extends Controller
{
    //

    public function myPayrollShow(){
        return view('pages.payroll.my-payslip.index');
    }
}
