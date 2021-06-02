<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccountChange;
use App\Models\Change;
use App\Models\Name;

use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        return $request->user();
    }

    public function getBaseAccountInfo(Request $request){
        $user_id = $this->getUser($request)->id;
        $info = [];
        $user =  User::all()->where('id', $user_id)->pluck('name')->first();
        array_push($info,  $user);
        $user_names = Name::all('id', 'name', 'user_id')->whereIn('user_id', [$user_id, 0]);
        array_push($info, $user_names);
        $sum_changes = [];
        $changes = DB::table('account_changes')->select('change_id', 'quantity')->where('user_id', $user_id)->get();

        return response()->json([
            'status'=>true,
            'user'=> $info,
            'changes'=>$changes
//            'user_names' => $info[1]
        ], 200);
    }

    public function getAllChangeAccount(Request $request)
    {
        return DB::table('account_changes')
            ->join('names', 'names.id', '=', 'account_changes.name_id')
            ->join('currencies', 'account_changes.currency_id', '=', 'currencies.id')
            ->select('account_changes.id', 'account_changes.change_id', 'account_changes.quantity', 'names.name as type_changes', 'currencies.name as currency_type', 'account_changes.date')
            ->where('account_changes.user_id', $this->getUser($request)->id)
            ->get();
    }

    public function getReplenishmentsChangeAccount(Request $request)
    {
        return AccountChange::all()->where('user_id', $this->getUser($request)->id)->where('change_id', 1)->sortByDesc('date');
    }

    public function getInvoiceChangeAccount(Request $request)
    {
        return AccountChange::all()->where('user_id', $this->getUser($request)->id)->where('change_id', 2)->sortByDesc('date');
    }


    public function createChangeAccount(Request $request)
    {
        $user = $this->getUser($request);
        $validator = Validator::make($request->all(), [
            'change_id' => 'required|numeric',
            'name_id' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }

        $change = AccountChange::create([
            'user_id' => $user->id,
            'change_id' => $request->change_id,
            'name_id' => $request->name_id,
            'currency_id' => $request->currency_id,
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'status'=>true,
            'info'=> $change
        ], 200);
    }

    public function getAccountNames(Request $request){
        $names = Name::all()
            ->whereIn('user_id', [0, $this->getUser($request)->id])->pluck('name');
        return response()->json([
            'status'=>true,
            'info'=> $names
        ], 200);
    }

    public function deleteAccountChange(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()
            ], 400);
        }

        $change = AccountChange::all()->where('id', $request->id)->first();
        if($change->delete()){
            return response()->json([
                'status'=>true,
            ], 200);
        }
        else{
            return response()->json([
                'status'=> false,
            ], 400);
        }
    }
}
