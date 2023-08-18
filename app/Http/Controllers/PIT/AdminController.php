<?php

namespace App\Http\Controllers\PIT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\PitModel;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    
    public function admin()
    {
        return view('pit/admins');  
    }

    public function admin_create(Request $request)
    {
        $uname = $request->get('uname');
        $name = $request->get('name');
        $pword = Hash::make($request->get('pword'));
        $type = $request->get('type');

        // return $type;

        $checkuname = db::table('users')
            ->where('email', $uname)
            ->first();

        if($checkuname)
        {
            return 'exist';
        }
        else{
            db::table('users')
                ->insert([
                    'name' => $name,
                    'email' => $uname,
                    'password' => $pword,
                    'usertype' => $type,
                    'createdby' => auth()->user()->id,
                    'createddatetime' => PitModel::getserverdatetime()
                ]);

            return 'done';
        }
    }

    public function admin_read(Request $request)
    {
        $filter = $request->get('filter');

        $players = db::table('users')
            ->select(db::raw('users.id, users.`name`, users.usertype, u.name AS upline'))
            ->join('users as u', 'users.createdby', '=', 'u.id')
            ->where('users.deleted', 0)
            ->where('users.usertype', '!=', 'player')
            ->where('users.usertype', '!=', 'superadmin')
            ->get();

        return $players;
    }
    

}

