<?php

namespace App\Http\Controllers;

use App\Models\AccountGcca;
use Illuminate\Http\Request;

class AccountGccaController extends Controller
{
    //
    public function index(){
        $gccas = AccountGcca::orderBy('code', 'asc')->get();
        return view('pages.accounting.gcca.index',compact('gccas'));
    }

    public function store(Request $request){
        try{
            $gcca_id = $request->gcca_id;
            $gcca = AccountGcca::find($gcca_id);
            if(!$gcca)
                $gcca = new AccountGcca();
            $gcca->prefix = $request->prefix;
            $gcca->code = $request->code;
            $gcca->description = $request->description;
            $gcca->save();
            return back()->with('success', 'Done successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(AccountGcca $gcca){
        if($gcca->delete()){
            return back()->with('success', 'GCCA deleted successfully');
        }
        return back()->with('error', 'Something went wrong');
    }
}
