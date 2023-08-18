<?php

namespace App\Http\Controllers\PIT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\PitModel;
use DB;

class DeclaratorController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    
    public function view()
    {
        return view('pit/declarator');  
    }

    public function event_save(Request $request)    
    {
        $eventname = $request->get('eventname');
        $maxbet = $request->get('maxbet');
        $liveurl = $request->get('liveurl');
        $banner = $request->get('banner');
        $betmultiplier = $request->get('betmultiplier');
        $id = $request->get('id');

        if($id == 0)
        {
            $check = db::table('events')
                ->where('eventname', $eventname)
                ->where('deleted', 0)
                ->where('eventstatus', 'open')
                ->first();

            if($check)
            {
                return 'exist';
            }
            else{
                DB::table('events')
                    ->insert([
                        'eventname' => $eventname,
                        'maxbet' => $maxbet,
                        'liveurl' => $liveurl,
                        'banner' => $banner,
                        'betmultiplier' => $betmultiplier,
                        'startdatetime' => PitModel::getserverdatetime(),
                        'decid' => auth()->user()->id,
                        'createdby' => auth()->user()->id,
                        'createddatetime' => PitModel::getserverdatetime()
                    ]);

                return 'done';
            }
        }
        else{
            $check = db::table('events')
                ->where('eventname', $eventname)
                ->where('id', '!=', $id)
                ->first();

            if($check)
            {
                return 'exist';
            }
            else{
                db::table('events')
                    ->where('id', $id)
                    ->update([
                        'eventname' => $eventname,
                        'maxbet' => $maxbet,
                        'liveurl' => $liveurl,
                        'banner' => $banner,
                        'betmultiplier' => $betmultiplier,
                        'updatedby' => auth()->user()->id,
                        'updateddatetime' => PitModel::getserverdatetime()
                    ]);

                return 'done';
            }
        }
    }

    public function event_generate(Request $request)
    {
        $filter = $request->get('filter');

        $events = db::table('events')
            ->where('deleted', 0)
            ->orderBy('id', 'DESC')
            ->get();

        return $events;
    }

    public function event_read(Request $request)
    {
        $id = $request->get('id');

        $event = db::table('events')
            ->where('id', $id)
            ->first();

        return collect($event);
    }

    public function event_view($id)
    {
        $event = db::table('events')
            ->where('id', $id)
            ->first();

        $event = collect($event);
        

        return view('pit.event_view', compact('event'));
        
        // return view('pit/declarator/')
    }
    

}

