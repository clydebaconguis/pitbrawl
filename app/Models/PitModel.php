<?php

namespace App\Models;
use DB;
use Carbon\Carbon;


use Illuminate\Database\Eloquent\Model;

class PitModel extends Model
{
	public static function getserverdatetime()
	{
		// return db::raw('select CURRENT_TIMESTAMP()');  //Carbon::now('Asia/Manila');
        $timestamp = db::select(db::raw('SELECT CURRENT_TIMESTAMP() as curtime'));
        return $timestamp[0]->curtime;

	}

	
}