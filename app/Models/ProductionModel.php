<?php

namespace App\Models;
use DB;
use Carbon\Carbon;


use Illuminate\Database\Eloquent\Model;

class ProductionModel extends Model
{
	public static function getserverdatetime()
	{
		// return db::raw('select CURRENT_TIMESTAMP()');  //Carbon::now('Asia/Manila');
        $timestamp = db::select(db::raw('SELECT CURRENT_TIMESTAMP() as curtime'));
        return $timestamp[0]->curtime;

	}

	public static function loadstockindetails($headerid)
	{
		$details = db::table('stockindetail')
            ->where('stockinid', $headerid)
            ->where('cancelled', 'N')
            ->get();

        $list = '';

        foreach($details as $detail)
        {
            $cylinder = db::table('cylinder')
                ->select('cylinder.id', 'serialno', 'owner', 'gasname', 'tag')
                ->join('gas', 'cylinder.gasid', 'gas.id')
                ->where('cylinder.id', $detail->CYLINDERID)
                ->where('cylinder.cancelled', 'N')
                ->first();

            if($cylinder)
            {
                $tagged = '';

                if($cylinder->tag == 1)
                {
                    $tagged = '<i class="fas fa-check"></i>';
                }
                else
                {
                    $tagged = '';
                }

                $list .='
                    <tr>
                        <td>'.$cylinder->serialno.'</td>
                        <td>'.$cylinder->gasname.'</td>
                        <td>'.$cylinder->owner.'</td>
                        <td class="text-center text-success">'.$tagged.'</td>
                        <td>
                            <button class="btn btn-danger incoming_detaildel" data-id="'.$detail->ID.'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </td>
                ';
            }
        }

        return $list;

	}

    public static function incoming_gascounter($headerid)
    {
        $gaslist = '';
        $runcount = 0;
        $cylinders = db::table('stockindetail')
            ->select(db::raw('COUNT(cylinderid) AS cylindercount, gasname'))
            ->join('cylinder', 'stockindetail.cylinderid', '=', 'cylinder.id')
            ->join('gas', 'cylinder.gasid', '=', 'gas.id')
            ->where('stockinid', $headerid)
            ->where('stockindetail.cancelled', 'N')
            ->groupBy('gasid')
            ->get();

        $gaslist .='
            <tr>
        ';

        foreach($cylinders as $cylinder)
        {
            if($runcount == 0)
            {
                $gaslist .='
                    <td style="border-left: solid 1px gray; border-right:solid 1px gray">'.$cylinder->gasname.': ' . $cylinder->cylindercount . '</td>
                ';
            }
            
        }

        $gaslist .='
            </tr>
        ';

        return $gaslist;

    }

    public static function loadunregcylinder($headerid)
    {
        $gastypes = db::table('gas')
                ->where('cancelled', 'N')
                ->get();

        $gaslist = '';

        foreach($gastypes as $gas)
        {
            $gaslist .='
                <option value="'.$gas->ID.'">'.$gas->GASNAME.'</option>
            ';
        }

        $unregs = db::table('cylinder_unreg')
            ->where('headerid', $headerid)
            ->where('registered', 'N')
            ->get();

        $unregcount = count($unregs);
        $unreglist ='';

        foreach($unregs as $unreg)
        {
            $unreglist .='
                <tr data-id="'.$unreg->ID.'">
                    <td class="unreg_serialno">'.$unreg->SERIALNO.'</td>
                    <td>
                        <select class="form-control unreg_gasowner">
                            <option value="BRANCH CYLINDER">BRANCH</option>
                            <option value="CUSTOMER TANK">CUSTOMER</option>
                            <option value="DEALER CYLINDER">DEALER</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control unreg_gastype">
                            '.$gaslist.'
                        </select>
                    </td>
                    <td>
                </tr>
            ';
        }

        $data = array(
            'unreglist' => $unreglist,
            'unregcount' => $unregcount
        );

        return $data;
    }

    public static function loadsreleasedetails($headerid)
    {
        $details = db::table('sreleasedetail')
            ->where('sreleaseid', $headerid)
            ->where('cancelled', 'N')
            ->get();

        // return $details;

        $list = '';

        foreach($details as $detail)
        {
            $cylinder = db::table('cylinder')
                ->select('cylinder.id', 'serialno', 'owner', 'gasname')
                ->join('gas', 'cylinder.gasid', 'gas.id')
                ->where('cylinder.id', $detail->CYLINDERID)
                ->first();

            if($cylinder)
            {
                // echo 'serial: ' . $cylinder->serialno . '<br>';
                // echo 'id: ' . $cylinder->id . '<br>';

                $list .='
                    <tr>
                        <td>'.$cylinder->serialno.'</td>
                        <td>'.$cylinder->gasname.'</td>
                        <td>'.$cylinder->owner.'</td>
                        <td>
                            <button class="btn btn-danger outgoing_detaildel" data-id="'.$detail->ID.'">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </td>
                ';
            }
        }

        return $list;

    }

    public static function outgoing_gascounter($headerid)
    {
        $gaslist = '';
        $runcount = 0;
        $cylinders = db::table('sreleasedetail')
            ->select(db::raw('COUNT(cylinderid) AS cylindercount, gasname'))
            ->join('cylinder', 'sreleasedetail.cylinderid', '=', 'cylinder.id')
            ->join('gas', 'cylinder.gasid', '=', 'gas.id')
            ->where('sreleaseid', $headerid)
            ->where('sreleasedetail.cancelled', 'N')
            ->groupBy('gasid')
            ->get();

        $gaslist .='
            <tr>
        ';

        // return $cylinders;

        foreach($cylinders as $cylinder)
        {
            if($runcount == 0)
            {
                $gaslist .='
                    <td style="border-left: solid 1px gray; border-right:solid 1px gray">'.$cylinder->gasname.': ' . $cylinder->cylindercount . '</td>
                ';
            }
            
        }

        $gaslist .='
            </tr>
        ';

        return $gaslist;
    }
}