<?php

namespace App\Http\Controllers;

use App\Models\AccountGcca;
use App\Models\AccountLedger;
use Illuminate\Http\Request;

class AccountLedgerController extends Controller
{
    public function index(){
        $ledgers = AccountLedger::orderBy('code', 'asc')->get();
        return view('pages.accounting.ledger.index',compact('ledgers'));
    }

    public function store(Request $request){
        try{
            $ledger_id = $request->ledger_id;
            $ledger = AccountGcca::find($ledger_id);
            if(!$ledger)
                $ledger = new AccountLedger();
            $ledger->gcca = $request->gcca;
            $ledger->code = $request->code;
            $ledger->description = $request->description;
            $ledger->save();
            return back()->with('success', 'Done successfully');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(AccountLedger $ledger){
        if($ledger->delete()){
            return back()->with('success', 'Account Ledger deleted successfully');
        }
        return back()->with('error', 'Something went wrong');
    }


    public function searchGl(Request $request){
        $q = $request->search;
        $accountLedgers = AccountLedger::whereRaw("(code LIKE '%$q%' OR description like '%$q%')")->get();
        $bank = [];
        foreach ($accountLedgers as $accountLedger){
            $bank[] = ["text" => $accountLedger->code . ' - ' . $accountLedger->description, "id" => $accountLedger->code];
        }
        return $bank;
    }
}
