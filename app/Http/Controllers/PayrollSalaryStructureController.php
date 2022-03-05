<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollSalaryStructureController extends Controller
{
    //
    public function index(){
        $structures = [];
        $levels = DB::table('payroll_salary_structures')->select('id','level')->groupBy('level')->get();
        foreach($levels as $level){
            $lvl = $level->level;
            $steps = [];
            $levelStep = DB::table('payroll_salary_structures')->select('id','step')->groupBy('step')->where('level',$lvl)->get();
            foreach($levelStep as $step){
                $stp = $step->step;
                $steps[] = [
                    'step'=>$stp,
                    'items'=>DB::table('payroll_salary_structures')->where(['level'=> $lvl, 'step'=>$stp])->join('payroll_items','payroll_items.id', 'payroll_salary_structures.item_id')->get()
                ];
            }

            $structures[] = [
                "level"=>$lvl,
                'structure'=>json_decode(json_encode($steps))
            ];
        }
        $structures = json_decode(json_encode($structures));
//        return $structures;
        return view('pages.payroll.salary-structure.index', compact('structures'));
    }

    public function levelSteps($level){

    }

    public function stepStructures($level, $step){

    }
}
