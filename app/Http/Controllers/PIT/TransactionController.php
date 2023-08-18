<?php

namespace App\Http\Controllers\PIT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\PitModel;
use DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    
    public function transactions()
    {
        return view('pit/transactions');  
    }

    public function trx_gen()
    {
        $userid = auth()->user()->id;

        $trx = db::table('transactions')
            ->select(db::raw('transactions.createddatetime, users.name as loadfrom, loadto.name as loadto, amount, transactions.balance, transactions.endbalance, remarks'))
            ->join('users', 'transactions.loadfrom', '=', 'users.id')
            ->join('users as loadto', 'transactions.loadto', '=', 'loadto.id')
            ->where('userid', $userid)
            ->where('transactions.deleted', 0)
            ->orderBy('transactions.createddatetime')
            ->get();

        $users = db::table('users')
            ->where('id', $userid)
            ->first();

        $balance = $users->balance;

        $data = array(
            'trx' => $trx,
            'balance' => number_format($balance, 2)
        );

        return $data;
    }

    public function trx_getusers(Request $request)
    {
        $userid = auth()->user()->id;

        $user = db::table('users')
            ->where('id', $userid)
            ->first();

        if($user->usertype == 'superadmin')
        {
            $users = db::table('users')
                ->select('id', 'name')
                ->where('status', 'active')
                ->where('deleted', 0)
                ->get();

            return $users;
        }
        else{

        }
    }

    public function trx_deposit(Request $request)
    {
        $loadto = $request->get('userid');
        $amount = str_replace(',', '', $request->get('amount'));
        $remarks = $request->get('remarks');

        $userid = auth()->user()->id;

        $user = db::table('users')
            ->where('id', $userid)
            ->first();

        $endbalance = $user->balance;
        $balance = $user->balance;

        $to_user = db::table('users')
            ->where('id', $loadto)
            ->first();

        $to_usertype = $to_user->usertype;

        if($to_usertype == 'superadmin')
        {
            $balance += $amount;
            $endbalance += $amount;

            db::table('users')
                ->where('id', $loadto)
                ->update([
                    'balance' => $endbalance,
                    'updatedby' => $userid,
                    'updateddatetime' => PitModel::getserverdatetime()
                ]);

            db::table('transactions')
                ->insert([
                    'userid' => $userid,
                    'loadfrom' => $userid,
                    'loadto' => $loadto,
                    'amount' => $amount,
                    'balance' => $balance,
                    'endbalance' => $endbalance,
                    'remarks' => $remarks,
                    'createdby' => $userid,
                    'createddatetime' => PitModel::getserverdatetime()
                ]);

            return 'done';
        }
        else{
            // $balance -= $amount;
            $endbalance -= $amount;

            $to_balance = $to_user->balance;
            $to_balance += $amount;

            db::table('users')
                ->where('id', $loadto)
                ->update([
                    'balance' => $to_balance,
                    'updatedby' => $userid,
                    'updateddatetime' => PitModel::getserverdatetime()
                ]);

            db::table('transactions')
                ->insert([
                    'userid' => $userid,
                    'loadfrom' => $userid,
                    'loadto' => $loadto,
                    'amount' => $amount,
                    'balance' => $to_user->balance,
                    'endbalance' => $to_balance,
                    'remarks' => $remarks,
                    'createdby' => $userid,
                    'createddatetime' => PitModel::getserverdatetime()
                ]);

            db::table('users')
                ->where('id', $userid)
                ->update([
                    'balance' => $endbalance,
                    'updatedby' => $userid,
                    'updateddatetime' => PitModel::getserverdatetime()
                ]);            

            return 'done';
        }
    }
    
    

}

