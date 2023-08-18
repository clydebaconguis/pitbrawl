<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class CashierModel extends Model
{
    public static function getSYID()
    {
    	$sy = DB::table('chrngterminals')
		      ->where('owner', auth()->user()->id)
		      ->first();

        if($sy)
        {
            return $sy->syid;
        }
    }

    public static function getSYDesc()
    {
        $terminal_sy = DB::table('chrngterminals')
            ->where('owner', auth()->user()->id)
            ->first();

        if($terminal_sy)
        {
            $sy = db::table('sy')
                ->where('id', $terminal_sy->syid)
                ->first();

            if($sy)
            {
                return $sy->sydesc;
            }
        }
        else
        {
            return 2;
        }
    }

    public static function getSemID()
    {
        // $semID = db::table('semester')
        //         ->where('isactive', 1)
        //         ->first();

        $semID = db::table('chrngterminals')
            ->where('owner', auth()->user()->id)
            ->first();

        if($semID)
        {
            return $semID->semid;
        }
    }

    public static function getSemDesc()
    {
        $chrnginfo = db::table('chrngterminals')
            ->where('owner', auth()->user()->id)
            ->first();

        if($chrnginfo)
        {
            $semID = db::table('semester')
                ->where('id', $chrnginfo->semid)
                ->first();

            return $semID->semester; 
        }
        else
        {
            return 1;
        }

        
    }

    public static function getServerDateTime()
    {
        $serverDateTime = db::select('SELECT CURRENT_TIMESTAMP');

        return Carbon::now('Asia/Manila');

        // return $serverDateTime[0]->CURRENT_TIMESTAMP;
    }

    public static function ActiveSY()
    {
        $activesy = db::table('sy')
            ->where('isactive', 1)
            ->first();

        return $activesy->id;
    }

    public static function ActiveSem()
    {
        $sem = db::table('semester')
            ->where('isactive', 1)
            ->first();

        return $sem->id;
    }

    public static function ActiveSemDesc()
    {
        $sem = db::table('semester')
            ->where('isactive', 1)
            ->first();        

        return $sem->semester;
    }

    public static function ActiveSYDesc()
    {
        $activesy = db::table('sy')
            ->where('isactive', 1)
            ->first();

        return $activesy->sydesc;
    }

    public static function colorcode($payno)
    {
    	if($payno==1)
    	{
    		$colorclass = 'pay-1';
    	}

    	elseif($payno==2)
    	{
    		$colorclass = 'pay-2';
    	}

    	elseif($payno==3)
    	{
    		$colorclass = 'pay-3';
    	}

    	elseif($payno==4)
    	{
    		$colorclass = 'pay-4';
    	}

    	elseif($payno==5)
    	{
    		$colorclass = 'pay-5';
    	}

    	elseif($payno==6)
    	{
    		$colorclass = 'pay-6';
    	}

    	elseif($payno==7)
    	{
    		$colorclass = 'pay-7';
    	}

    	elseif($payno==8)
    	{
    		$colorclass = 'pay-8';
    	}

    	elseif($payno==9)
    	{
    		$colorclass = 'pay-9';
    	}

    	elseif($payno==10)
    	{
    		$colorclass = 'pay-10';
    	}

    	elseif($payno==11)
    	{
    		$colorclass = 'pay-11';
    	}

    	elseif($payno==12)
    	{
    		$colorclass = 'pay-12';
    	}

    	else
    	{
    		$colorclass = 'pay-oth';
    	}

    	return $colorclass;

	}
	
	public static function insertOR($ornum, $terminalno, $paytype)
	{
		$checkOR = db::table('orcounter')
			->where('ornum', $ornum)
			->get();
		if(count($checkOR) > 0)
		{
      
            $genORnum = db::table('orcounter')
                ->where(function($q) use($paytype){
                    if($paytype != 'CASH' || $paytype != 'CHEQUE')
                    {
                        $q->where('oltrans', 0);
                    }
                    else
                    {
                        $q->where('oltrans', 0);
                    }
                })
                ->get();


            if($paytype != 'CASH' || $paytype != 'CHEQUE')
            {
                $insertOR = db::table('orcounter')
                    ->insert([
                        'ornum' => $ornum,
                        'terminalno' =>  $terminalno,
                        'used' => 0,
                        'oltrans' => 0,
                        'createddatetime' => CashierModel::getServerDateTime()
                    ]);        
            }
            else
            {
                $insertOR = db::table('orcounter')
                    ->insert([
                        'ornum' => $ornum,
                        'terminalno' =>  $terminalno,
                        'used' => 0,
                        'createddatetime' => CashierModel::getServerDateTime()
                    ]);
            }
		}
		else
		{
            // return $paytype;
            if($paytype != 'CASH' && $paytype != 'CHEQUE')
            {
                $insertOR = db::table('orcounter')
                    ->insert([
                        'ornum' => $ornum,
                        'terminalno' =>  $terminalno,
                        'used' => 0,
                        'oltrans' => 0,
                        'createddatetime' => CashierModel::getServerDateTime()
                    ]);        
            }
            else
            {
      			$insertOR = db::table('orcounter')
      				->insert([
      					'ornum' => $ornum,
      					'terminalno' =>  $terminalno,
                        'used' => 0,
  					     'createddatetime' => CashierModel::getServerDateTime()
                    ]);
            } 
		}
	}

    public static function getornum($terminalno, $paytypeid)
    {
        $schoolinfo = db::table('schoolinfo')
          ->first();

        if($schoolinfo->olreceipt == 1 and $paytypeid >= 3)
        {
          $ornum = db::table('orcounter')
            ->where('terminalno', $terminalno)
            ->where('used', 0)
            ->where('oltrans', 1)
            ->orderBy('id','desc')
            ->take(1)
            ->get(); 
        }
        else
        {
        $ornum = db::table('orcounter')
            ->where('terminalno', $terminalno)
            ->where('used', 0)
            ->where('oltrans', 0)
            ->orderBy('id','desc')
            ->take(1)
            ->get();
        }
        if(count($ornum) > 0)
        {
            return $ornum[0]->ornum;
        }
        else
        {
            return 0;
        }   
	}

    public static function checkornum($ornumber)
    {
        $ornum = db::table('orcounter')
            ->where('ornum', $ornumber)
            ->first();

        if($ornum)
        {
            if($ornum->used == 0)
            {
                return 0;
            }
            else
            {
                return 1;
            }
        }
        else
        {
            return 0;
        }

    }
	
	public static function ledgerRbal($studid, $syid)
	{
		$rbal = 0;

		$ledger = db::table('studledger')
			->get();
	}



    public static function smsPayment($studid, $amount, $or)
    {
        $stud = db::table('studinfo')
            ->where('id', $studid)
            ->first();

        $dt = date_create(CashierModel::getServerDateTime());
        $dt = date_format($dt, 'm-d-Y h:i A');
        $num = '';

        $studname = strtoupper($stud->lastname  . ', ' . $stud->firstname . ' ' . $stud->middlename .' '. $stud->suffix);

        $msg = 'You have just paid '. number_format($amount, 2) . ' for '. $studname . ' with OR#: ' . $or. '. Thank you. ' . $dt;

        if($stud->ismothernum == 1)
        {
            $num = $stud->mcontactno;
        }
        elseif($stud->isfathernum == 1)
        {
            $num = $stud->fcontactno;
        }
        elseif($stud->isguardannum == 1)
        {
            $num = $stud->gcontactno;
        }

        if($num <> '')
        {
        if($num[0] == 0)
        {
            $num = ltrim($num, $num[0]);
            $num = '+63' . $num;
        }


        $sms = db::table('smsbunker')
            ->insert([
                'message' => $msg,
                'receiver' => $num,
                'smsstatus' => 0
            ]);
    }
  }



    public static function getIp()
    {

    // return substr(exec('getmac'), 0, 17); 
    // return exec('getmac');


    // foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
    //     if (array_key_exists($key, $_SERVER) === true){
    //         foreach (explode(',', $_SERVER[$key]) as $ip){
    //             $ip = trim($ip); // just to be safe
    //             if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
    //                 return $ip;
    //             }
    //             else
    //             {
    //               return $ip;
    //             }
    //         }
    //     }
    // }

        return auth()->user()->id;

    // $cookie = Response::make('cookie');
    // $cookie =Cookie::forever('name', 'testing');
    // return Cookie::get('name')

    // return request()->ip();

    // return $request->header('User-Agent');


    }

    public static function getTransNo()
    {
        $transno = db::select('select max(transno) as transno from transcounter');
        $tnum = $transno[0]->transno + 1; 

        $updtransno = db::table('transcounter') 
            ->where('terminalno', 1)
            ->update([
              'transno' => $tnum
            ]);

        return $tnum;
    }


    public static function getOrderLines($transno, $cashtransid)
    {
        $cashtrans = db::table('chrngcashtrans')
            ->where('transno', $transno)
            ->where('deleted', 0)
            ->get();

        $output = '';
        $tAmount = 0.00;

        if(count($cashtrans) > 0)
        {
            foreach($cashtrans as $cash)
            {
                $tAmount += $cash->amount;

                if($cash->id == $cashtransid)
                {
                    if($cash->qty > 1)
                    {
                        $output .='
                            <ul class="orderlines text-info">
                                <li class="orderline bg-success" detail-id="'.$cash->payscheddetailid.'" data-id="'.$cash->id.'" month-due="'.$cash->duedate.'" paykind="'.$cash->transdone.'" data-value="'.$cash->amount.'">
                                    <span class="product-name">'.$cash->particulars.' </span>
                                    <span class="price">'.number_format($cash->amount, 2).'</span>
                                    <ul class="info-list text-secondary">
                                      <li class="info"><em>QTY:</em> '.$cash->qty.' @ '.$cash->itemprice.'/qty</li>
                                    </ul>
                                </li>
                            </ul>
                        ';
                    }
                    else
                    {
                        $output .='
                            <ul class="orderlines text-info">
                                <li class="orderline bg-success" detail-id="'.$cash->payscheddetailid.'" data-id="'.$cash->id.'" month-due="'.$cash->duedate.'" paykind="'.$cash->transdone.'" data-value="'.$cash->amount.'">
                                    <span class="product-name">'.$cash->particulars.' </span>
                                    <span class="price">'.number_format($cash->amount, 2).'</span>
                                </li>
                            </ul>
                        '; 
                    }
                }
                else
                {
                    if($cash->qty > 1)
                    {
                        $output .='
                            <ul class="orderlines text-info">
                                <li class="orderline" detail-id="'.$cash->payscheddetailid.'" data-id="'.$cash->id.'" month-due="'.$cash->duedate.'" paykind="'.$cash->transdone.'" data-value="'.$cash->amount.'">
                                    <span class="product-name">'.$cash->particulars.' </span>
                                    <span class="price">'.number_format($cash->amount, 2).'</span>
                                    <ul class="info-list text-secondary">
                                      <li class="info"><em>QTY:</em> '.$cash->qty.' @ '.$cash->itemprice.'/qty</li>
                                    </ul>
                                </li>
                            </ul>
                      ';
                    }
                    else
                    {
                        $output .='
                            <ul class="orderlines text-info">
                                <li class="orderline" detail-id="'.$cash->payscheddetailid.'" data-id="'.$cash->id.'" month-due="'.$cash->duedate.'" paykind="'.$cash->transdone.'" data-value="'.$cash->amount.'">
                                    <span class="product-name">'.$cash->particulars.' </span>
                                    <span class="price">'.number_format($cash->amount, 2).'</span>
                                </li>
                            </ul>
                        ';
                    }
                }
            }

            $tAmount = number_format($tAmount, 2, '.', '');
        
            $output .='
                <div class="summary clearfix text-success">
                    <div class="line">
                        <div class="entry total">
                            <span class="">Total: </span> <span id="tAmount" class="value" data-value="'.$tAmount.'"> '.number_format($tAmount, 2).'</span>
                          
                        </div>
                    </div>
                </div>  
            ';
        }
        else
        {
            $output = '
              <div class="order-empty">
                  <i class="fa fa-shopping-cart" role="img" aria-label="Shopping cart" title="Shopping cart"></i>
                  <h1>No data to display</h1>
              </div>       
            ';
        }

        return $output;
    }

    public static function paytype()
    {
        $paytype = db::table('paymenttype')
            ->get();

        return $paytype;
    }

    public static function schoolinfo() 
    {
        $schoolinfo = db::table('schoolinfo')
            ->first();

        return $schoolinfo;
    }

    public static function checkOLPay()
    {
        $olpaid = db::table('onlinepayments')
            ->where('isapproved', 1)
            ->count();

        $count = '';

        if($olpaid >= 10)
        {
            $count = '9+';
        }
        else
        {
            $count = $olpaid;
        }

        return $count;

    }

    public static function select2_studlist()
    {
        $student = db::table('studinfo')
            ->select('studinfo.id', 'lastname', 'firstname', 'middlename', 'suffix', 'levelid', 'contactno', 'sid', 'lrn', 'gradelevel.levelname', 'sectionname')
            ->join('gradelevel', 'studinfo.levelid', '=', 'gradelevel.id')
            // ->join('grantee', 'studinfo.grantee', '=', 'grantee.id')
            ->where('studinfo.deleted', 0)
            ->orderby('lastname', 'asc')
            ->orderby('firstname', 'asc')
            ->get();

        return $student;
    }

    public static function select2_mop()
    {
        $modeofpayment = db::table('paymentsetup')
          ->where('deleted', 0)
          ->get();

        return $modeofpayment;
    }

    public static function v2_orderlines($transno)
    {
        $total = 0;
        $line = '';

        $cashtrans = db::table('chrngcashtrans')
            ->where('transno', $transno)
            ->where('deleted', 0)
            ->get();

        // return $cashtrans;

        foreach($cashtrans as $trans)
        {
            $line .='
                <tr class="v2_selitems" data-id="'.$trans->id.'" paysched-id="'.$trans->payscheddetailid.'" data-kind="'.$trans->kind.'">
                    <td>'.$trans->particulars.'</td>
                    <td class="text-right">
                        <input type="text" class="line-val" placeholder="0.00" value="'.number_format($trans->amount, 2).'" name="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" autocomplete="off" data-id="'.$trans->id.'">
                    </td>
                    <td class="text-right">
                        <button class="btn btn-sm btn-remove btn-gray text-danger" data-id="'.$trans->id.'"><i class="fas fa-times"></i></i></button>
                    </td>
                </tr>
            ';

            $total += $trans->amount;
        }

        $data = array(
            'line' => $line,
            'total' => $total
        );

        return $data;
    }

    public static function ledgeritemizedreset($studid)
    {
        db::table('studledgeritemized')
          ->where('studid', $studid)
          ->where('syid', CashierModel::getSYID())
          ->where('semid', CashierModel::getSemID())
          ->delete();


        $studinfo = db::table('studinfo')
            ->where('id', $studid)
            ->first();

        if($studinfo)
        {
            if($studinfo->studstatus != 0)
            {
                $tuitions = db::table('tuitionheader')
                    ->select('syid', 'semid', 'grantee', 'tuitiondetail.id as detailid', 'tuitionitems.id as tuitionitemid', 'classificationid', 'itemid', 'tuitionitems.amount')
                    ->join('tuitiondetail', 'tuitionheader.id', '=', 'tuitiondetail.headerid')
                    ->join('tuitionitems', 'tuitiondetail.id', '=', 'tuitionitems.tuitiondetailid')
                    ->where('tuitionheader.deleted', 0)
                    ->where('tuitiondetail.deleted', 0)
                    ->where('tuitionitems.deleted', 0)
                    ->where('levelid', $studinfo->levelid)
                    ->where('grantee', $studinfo->grantee)
                    ->where('syid', CashierModel::getSYID())
                    ->where('semid', CashierModel::getSemID())
                    ->get();

                if(count($tuitions) == 0)
                {
                    $tuitions = db::table('tuitionheader')
                    ->select('syid', 'semid', 'grantee', 'tuitiondetail.id as detailid', 'tuitionitems.id as tuitionitemid', 'classificationid', 'itemid', 'tuitionitems.amount')
                    ->join('tuitiondetail', 'tuitionheader.id', '=', 'tuitiondetail.headerid')
                    ->join('tuitionitems', 'tuitiondetail.id', '=', 'tuitionitems.tuitiondetailid')
                    ->where('tuitionheader.deleted', 0)
                    ->where('tuitiondetail.deleted', 0)
                    ->where('tuitionitems.deleted', 0)
                    ->where('levelid', $studinfo->levelid)
                    ->where('syid', CashierModel::getSYID())
                    ->where('semid', CashierModel::getSemID())
                    ->get();
                }

                foreach($tuitions as $tuition)
                {
                    db::table('studledgeritemized')
                        ->insert([
                            'studid' => $studinfo->id,
                            'syid' => CashierModel::getSYID(),
                            'semid' => CashierModel::getSemID(),
                            'tuitiondetailid' => $tuition->detailid,
                            'classificationid' => $tuition->classificationid,
                            'tuitionitemid' => $tuition->tuitionitemid,
                            'itemAmount' => $tuition->amount,
                            'itemid' => $tuition->itemid,
                            'deleted' => 0
                        ]); 
                }


                $balforwardsetup = db::table('balforwardsetup')->first();

                $studledger = db::table('studledger')
                    ->where('studid', $studid)
                    ->where('syid', CashierModel::getSYID())
                    ->where('semid', CashierModel::getSemID())
                    ->where('classid', $balforwardsetup->classid)
                    ->where('void', 0)
                    ->where('deleted', 0)
                    ->first();

                if($studledger)
                {
                    db::table('studledgeritemized')
                        ->insert([
                            'studid' => $studid,
                            'syid' => CashierModel::getSYID(),
                            'semid' => CashierModel::getSemID(), 
                            'classificationid' => $studledger->classid,
                            'itemamount' => $studledger->amount,
                            'deleted' => 0,
                            'createdby' => auth()->user()->id,
                            'createddatetime' => CashierModel::getServerDateTime()
                        ]);
                }

            }
        }
    }

    public static function transitemsreset($studid)
    {
        db::table('chrngtransitems')
          ->where('studid', $studid)
          ->where('syid', CashierModel::getSYID())
          ->where('semid', CashierModel::getSemID())
          ->delete();

        $chrngtrans = db::table('chrngtrans')
            ->select('chrngtransid', 'chrngtransdetail.id as chrngtransdetailid', 'ornum', 'classid', 'chrngtransdetail.amount', 'studid', 'syid', 'semid')
            ->join('chrngtransdetail', 'chrngtrans.id', '=', 'chrngtransdetail.chrngtransid')
            ->where('cancelled', 0)
            ->where('studid', $studid)
            ->get();

        $transOR = 0;
        $transstudID = 0;

        foreach($chrngtrans as $trans)
        {

            $transOR = $trans->ornum;
            $transstudID = $trans->studid;
            $transamount = $trans->amount;

            top:

            $ledgeritemized = db::select(
                'SELECT *
                FROM `studledgeritemized` 
                WHERE `studid` = ? 
                    AND `syid` = ? 
                    AND `semid` = ? 
                    AND `classificationid` =? 
                    AND `deleted` = 0
                    AND (`totalamount` < itemamount or isnull(totalamount))', [$trans->studid, $trans->syid, $trans->semid, $trans->classid]
            );


            if(count($ledgeritemized) == 0)
            {
                $ledgeritemized = db::select(
                    'SELECT *
                    FROM `studledgeritemized` 
                    WHERE `studid` = ? 
                        AND `syid` = ? 
                        AND `semid` = ? 
                        AND `classificationid` =? 
                        AND `deleted` = 0', [$trans->studid, $trans->syid, $trans->semid, $trans->classid]
                );
            }

            foreach($ledgeritemized as $item)
            {
                if($transamount > 0)
                {
                    $checkitem = db::table('studledgeritemized')
                        ->where('id', $item->id)
                        ->first();

                    if($checkitem)
                    {
                        if($checkitem->totalamount < $item->itemamount)
                        {
                            $_getamount = $item->itemamount - $item->totalamount;

                            if($transamount >= $_getamount)
                            {
                                db::table('studledgeritemized')
                                    ->where('id', $item->id)
                                    ->update([
                                        'totalamount' => $item->totalamount + $_getamount,
                                        'updatedby' => auth()->user()->id,
                                        'updateddatetime' => CashierModel::getServerDateTime()
                                    ]);

                                db::table('chrngtransitems')
                                    ->insert([
                                        'chrngtransid' => $trans->chrngtransid,
                                        'chrngtransdetailid' => $trans->chrngtransdetailid,
                                        'ornum' => $trans->ornum,
                                        'itemid' => $item->itemid,
                                        'classid' => $item->classificationid,
                                        'amount' => $_getamount,
                                        'studid' => $item->studid,
                                        'syid' => $trans->syid,
                                        'semid' => $trans->semid,
                                        'createdby' => auth()->user()->id,
                                        'createddatetime' => CashierModel::getServerDateTime()
                                    ]);


                                $transamount -= $_getamount;
                            }
                            else
                            {
                                db::table('studledgeritemized')
                                    ->where('id', $item->id)
                                    ->update([
                                        'totalamount' => $item->totalamount + $transamount,
                                        'updatedby' => auth()->user()->id,
                                        'updateddatetime' => CashierModel::getServerDateTime()
                                    ]);

                                db::table('chrngtransitems')
                                    ->insert([
                                        'chrngtransid' => $trans->chrngtransid,
                                        'chrngtransdetailid' => $trans->chrngtransdetailid,
                                        'ornum' => $trans->ornum,
                                        'itemid' => $item->itemid,
                                        'classid' => $item->classificationid,
                                        'amount' => $transamount,
                                        'studid' => $item->studid,
                                        'syid' => $trans->syid,
                                        'semid' => $trans->semid,
                                        'createdby' => auth()->user()->id,
                                        'createddatetime' => CashierModel::getServerDateTime()
                                    ]);

                                $transamount = 0;
                            }
      
                        }
                    }
                }
            }

            if($transamount > 0)
            {

                $chrngtrans = db::table('chrngtrans')
                    ->select('chrngtransid', 'chrngtransdetail.id as chrngtransdetailid', 'ornum', 'classid', 'chrngtransdetail.amount', 'studid', 'syid', 'semid')
                    ->join('chrngtransdetail', 'chrngtrans.id', '=', 'chrngtransdetail.chrngtransid')
                    ->where('cancelled', 0)
                    ->where('posted', 1)
                    ->where('studid', $transstudID)
                    ->where('ornum', $transOR)
                    ->get();

                foreach($chrngtrans as $trans)
                {
                    if($transamount > 0)
                    {
                        $ledgeritemized = db::select(
                            'SELECT *
                            FROM `studledgeritemized` 
                            WHERE `studid` = ? 
                                AND `syid` = ? 
                                AND `semid` = ? 
                                AND `classificationid` =? 
                                AND `deleted` = 0', [$trans->studid, $trans->syid, $trans->semid, $trans->classid]
                        );

                        foreach($ledgeritemized as $item)
                        {
                            db::table('chrngtransitems')
                                ->insert([
                                    'chrngtransid' => $trans->chrngtransid,
                                    'chrngtransdetailid' => $trans->chrngtransdetailid,
                                    'ornum' => $trans->ornum,
                                    'itemid' => $item->itemid,
                                    'classid' => $item->classificationid,
                                    'amount' => $transamount,
                                    'studid' => $item->studid,
                                    'syid' => $trans->syid,
                                    'semid' => $trans->semid,
                                    'createdby' => auth()->user()->id,
                                    'createddatetime' => CashierModel::getServerDateTime()
                                ]);

                            $transamount = 0;
                        }
                    }
                }
            }

        }
    }

    public static function chrngdistlogs($studid, $transid, $transdetailid, $scheddetailid, $classid, $amount)
    {
        db::table('chrngdistlogs')
            ->insert([
                'studid' => $studid,
                'transid' => $transid,
                'transdetailid' => $transdetailid,
                'scheddetailid' => $scheddetailid,
                'classid' => $classid,
                'amount' => $amount,
                'createddatetime' => CashierModel::getServerDateTime(),
                'createdby' => auth()->user()->id
            ]);
    }

    public static function shssetup()
    {
        $setup = db::table('schoolinfo')
            ->first()
            ->shssetup;

        return $setup;
    }


    public static function procItemized($tuitiondetailid, $payschedid ,$amount, $classid, $levelid, $chrngtransid, $chrngtransdetailid, $ornum, $studid, $kind)
    {
        // echo 'aaaa';

        $setup = db::table('chrngsetup')
            ->where('classid', $classid)
            ->first();

        if($setup)
        {
            if($setup->itemized == 0)
            {
                if($amount > 0)
                {
                    $itemized = db::table('studledgeritemized')   
                        ->where('tuitiondetailid', $tuitiondetailid)
                        ->where('studid', $studid)
                        ->where('deleted', 0)
                        ->whereColumn('totalamount', '<', 'itemamount')
                        ->where('classificationid', $classid)
                        ->where(function($q) use($levelid){
                            if($levelid == 14 || $levelid == 15)
                            {
                                if(CashierModel::shssetup() == 0)
                                {
                                    $q->where('semid', CashierModel::getSemID());
                                }
                            }
                            if($levelid >= 17 && $levelid <= 21)
                            {
                                $q->where('semid', CashierModel::getSemID());
                            }
                        })
                        ->get();

                    if(count($itemized) == 0)
                    {
                        $itemized = db::table('studledgeritemized')   
                            ->where('studid', $studid)
                            ->where('deleted', 0)
                            ->whereColumn('totalamount', '<', 'itemamount')
                            ->where('classificationid', $classid)
                            ->where(function($q) use($levelid){
                                if($levelid == 14 || $levelid == 15)
                                {
                                    if(CashierModel::shssetup() == 0)
                                    {
                                        $q->where('semid', CashierModel::getSemID());
                                    }
                                }
                                if($levelid >= 17 && $levelid <= 21)
                                {
                                    $q->where('semid', CashierModel::getSemID());
                                }
                            })
                            ->get();

                        if(count($itemized) == 0)
                        {
                            $itemized = db::table('studledgeritemized')   
                                ->where('studid', $studid)
                                ->where('deleted', 0)
                                ->whereColumn('totalamount', '<', 'itemamount')
                                ->where(function($q) use($levelid){
                                    if($levelid == 14 || $levelid == 15)
                                    {
                                        if(CashierModel::shssetup() == 0)
                                        {
                                            $q->where('semid', CashierModel::getSemID());
                                        }
                                    }
                                    if($levelid >= 17 && $levelid <= 21)
                                    {
                                        $q->where('semid', CashierModel::getSemID());
                                    }
                                })
                                ->get();   
                        }
                    }

                    foreach($itemized as $item)
                    {
                        $balance = $item->itemamount - $item->totalamount;
                        if($amount > $balance)
                        {
                            db::table('studledgeritemized')
                                ->where('id', $item->id)
                                ->update([
                                    'totalamount' => $item->totalamount + $balance,
                                    'updateddatetime' => CashierModel::getServerDateTime(),
                                    'updatedby' => auth()->user()->id
                                ]);

                            db::table('chrngtransitems')
                                ->insert([
                                    'chrngtransid' => $chrngtransid,
                                    'chrngtransdetailid' => $chrngtransdetailid,
                                    'ornum' => $ornum,
                                    'itemid' => $item->itemid,
                                    'classid' => $classid,
                                    'amount' => $balance,
                                    'studid' => $studid,
                                    'syid' => CashierModel::getSYID(),
                                    'semid' => CashierModel::getSemID(),
                                    'kind' => $kind,
                                    'createddatetime' => CashierModel::getServerDateTime(),
                                    'createdby' => auth()->user()->id,
                                ]);

                            $amount -= $balance;
                        }
                        else
                        {
                            db::table('studledgeritemized')
                                ->where('id', $item->id)
                                ->update([
                                    'totalamount' => $item->totalamount + $amount,
                                    'updateddatetime' => CashierModel::getServerDateTime(),
                                    'updatedby' => auth()->user()->id
                                ]);

                            db::table('chrngtransitems')
                                ->insert([
                                    'chrngtransid' => $chrngtransid,
                                    'chrngtransdetailid' => $chrngtransdetailid,
                                    'ornum' => $ornum,
                                    'itemid' => $item->itemid,
                                    'classid' => $classid,
                                    'amount' => $amount,
                                    'studid' => $studid,
                                    'syid' => CashierModel::getSYID(),
                                    'semid' => CashierModel::getSemID(),
                                    'kind' => $kind,
                                    'createddatetime' => CashierModel::getServerDateTime(),
                                    'createdby' => auth()->user()->id,
                                ]);

                            $amount = 0;
                        }
                    }
                }
            }
            else
            {
                if($amount > 0)
                {
                    $itemized = db::table('studledgeritemized')
                        ->where('id', $payschedid)
                        ->where('studid', $studid)
                        ->whereColumn('totalamount', '<', 'itemamount')
                        ->where('deleted', 0)
                        ->get();

                    if(count($itemized) == 0)
                    {
                        $itemized = db::table('studledgeritemized')
                            ->where('classificationid', $classid)
                            ->where('studid', $studid)
                            ->whereColumn('totalamount', '<', 'itemamount')
                            ->where('deleted', 0)
                            ->get();

                        if(count($itemized) == 0)
                        {
                            $itemized = db::table('studledgeritemized')
                                // ->where('classificationid', $classid)
                                ->where('studid', $studid)
                                ->whereColumn('totalamount', '<', 'itemamount')
                                ->where('deleted', 0)
                                ->get();
                        }
                    }
                    
                    foreach($itemized as $item)
                    {
                        $balance = $item->itemamount - $item->totalamount;

                        if($amount > $balance)
                        {
                            db::table('studledgeritemized')
                                ->where('id', $item->id)
                                ->update([
                                    'totalamount' => $item->totalamount + $balance,
                                    'updateddatetime' => CashierModel::getServerDateTime(),
                                    'updatedby' => auth()->user()->id
                                ]);

                            db::table('chrngtransitems')
                                ->insert([
                                    'chrngtransid' => $chrngtransid,
                                    'chrngtransdetailid' => $chrngtransdetailid,
                                    'ornum' => $ornum,
                                    'itemid' => $item->itemid,
                                    'classid' => $classid,
                                    'amount' => $balance,
                                    'studid' => $studid,
                                    'syid' => CashierModel::getSYID(),
                                    'semid' => CashierModel::getSemID(),
                                    'kind' => $kind,
                                    'createddatetime' => CashierModel::getServerDateTime(),
                                    'createdby' => auth()->user()->id,
                                ]);

                            $amount -= $balance;
                        }
                        else
                        {
                            db::table('studledgeritemized')
                                ->where('id', $item->id)
                                ->update([
                                    'totalamount' => $item->totalamount + $amount,
                                    'updateddatetime' => CashierModel::getServerDateTime(),
                                    'updatedby' => auth()->user()->id
                                ]);

                            db::table('chrngtransitems')
                                ->insert([
                                    'chrngtransid' => $chrngtransid,
                                    'chrngtransdetailid' => $chrngtransdetailid,
                                    'ornum' => $ornum,
                                    'itemid' => $item->itemid,
                                    'classid' => $classid,
                                    'amount' => $amount,
                                    'studid' => $studid,
                                    'syid' => CashierModel::getSYID(),
                                    'semid' => CashierModel::getSemID(),
                                    'kind' => $kind,
                                    'createddatetime' => CashierModel::getServerDateTime(),
                                    'createdby' => auth()->user()->id,
                                ]);

                            $amount = 0;
                        }
                    }
                }
            }


            if($amount > 0)
            {
                $itemized = db::table('studledgeritemized')   
                    ->where('tuitiondetailid', $tuitiondetailid)
                    ->where('deleted', 0)
                    ->whereColumn('totalamount', '<', 'itemamount')
                    ->where(function($q) use($levelid){
                        if($levelid == 14 || $levelid == 15)
                        {
                            if(CashierModel::shssetup() == 0)
                            {
                                $q->where('semid', CashierModel::getSemID());
                            }
                        }
                        if($levelid >= 17 && $levelid <= 21)
                        {
                            $q->where('semid', CashierModel::getSemID());
                        }
                    })
                    ->get();

                foreach($itemized as $item)
                {
                    $balance = $item->itemamount - $item->totalamount;
                    if($amount > $balance)
                    {
                        db::table('studledgeritemized')
                            ->where('id', $item->id)
                            ->update([
                                'totalamount' => $item->totalamount + $balance,
                                'updateddatetime' => CashierModel::getServerDateTime(),
                                'updatedby' => auth()->user()->id
                            ]);

                        db::table('chrngtransitems')
                            ->insert([
                                'chrngtransid' => $chrngtransid,
                                'chrngtransdetailid' => $chrngtransdetailid,
                                'ornum' => $ornum,
                                'itemid' => $item->itemid,
                                'classid' => $classid,
                                'amount' => $balance,
                                'studid' => $studid,
                                'syid' => CashierModel::getSYID(),
                                'semid' => CashierModel::getSemID(),
                                'kind' => $kind,
                                'createddatetime' => CashierModel::getServerDateTime(),
                                'createdby' => auth()->user()->id,
                            ]);

                        $amount -= $balance;
                    }
                    else
                    {
                        db::table('studledgeritemized')
                            ->where('id', $item->id)
                            ->update([
                                'totalamount' => $item->totalamount + $amount,
                                'updateddatetime' => CashierModel::getServerDateTime(),
                                'updatedby' => auth()->user()->id
                            ]);

                        db::table('chrngtransitems')
                            ->insert([
                                'chrngtransid' => $chrngtransid,
                                'chrngtransdetailid' => $chrngtransdetailid,
                                'ornum' => $ornum,
                                'itemid' => $item->itemid,
                                'classid' => $classid,
                                'amount' => $amount,
                                'studid' => $studid,
                                'syid' => CashierModel::getSYID(),
                                'semid' => CashierModel::getSemID(),
                                'kind' => $kind,
                                'createddatetime' => CashierModel::getServerDateTime(),
                                'createdby' => auth()->user()->id,
                            ]);

                        $amount = 0;
                    }   
                }

            }

        }
    }

    public static function voidledgeritemized($studid, $chrngtransid)
    {
        $levelid = db::table('studinfo')->where('id', $studid)->first()->levelid;

        $chrngtransitems = db::table('chrngtransitems')
            ->where('chrngtransid', $chrngtransid)
            ->where('deleted', 0)
            ->get();

        foreach($chrngtransitems as $items)
        {
            $setup = db::table('chrngsetup')
                ->where('classid', $items->classid)
                ->first();

            // return $items->classid;

            if($setup)
            {
                if($setup->itemized == 0)
                {
                    $ledgeritemized = db::table('studledgeritemized')
                        ->where('classificationid', $items->classid)
                        ->where('deleted', 0)
                        ->where('syid', CashierModel::getSYID())
                        ->where(function($q) use($levelid){
                            if($levelid == 14 || $levelid == 15)
                            {
                                if(db::table('schoolinfo')->first()->shssetup == 0)
                                {
                                    $q->where('semid', CashierModel::getSemID());
                                }
                            }

                            if($levelid >= 17 && $levelid <= 20)
                            {
                                $q->where('semid', CashierModel::getSemID());
                            }
                        })
                        ->get();

                    foreach($ledgeritemized as $leditem)
                    {
                        $_amount = $leditem->totalamount - $items->amount;

                        if($_amount < 0)
                        {
                            $_amount = 0;
                        }

                        db::table('studledgeritemized')
                            ->where('id', $leditem->id)
                            ->update([
                                'totalamount' =>  $_amount,
                                'updatedby' => auth()->user()->id,
                                'updateddatetime' => CashierModel::getServerDateTime()
                            ]);
                    }
                }
                else
                {
                    $ledgeritemized = db::table('studledgeritemized')
                        ->where('itemid', $items->itemid)
                        ->where('studid', $studid)
                        ->where('deleted', 0)
                        ->where('syid', CashierModel::getSYID())
                        ->where(function($q) use($levelid){
                            if($levelid == 14 || $levelid == 15)
                            {
                                if(db::table('schoolinfo')->first()->shssetup == 0)
                                {
                                    $q->where('semid', CashierModel::getSemID());
                                }
                            }

                            if($levelid >= 17 && $levelid <= 20)
                            {
                                $q->where('semid', CashierModel::getSemID());
                            }
                        })
                        ->first();

                    if($ledgeritemized)
                    {
                        $_amount = $ledgeritemized->totalamount - $items->amount;

                        

                        if($_amount < 0)
                        {
                            $_amount = 0;
                        }

                        db::table('studledgeritemized')
                            ->where('id', $ledgeritemized->id)
                            ->update([
                                'totalamount' => $_amount,
                                'updatedby' => auth()->user()->id,
                                'updateddatetime' => CashierModel::getServerDateTime()
                            ]);
                    }


                }
            }
        }

        db::table('chrngtransitems')
            ->where('chrngtransid', $chrngtransid)
            ->where('deleted', 0)
            ->update([
                'deleted' => 1,
                'deletedby' => auth()->user()->id,
                'deleteddatetime' => CashierModel::getServerDateTime()
            ]);
    }




















    public static function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }

        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);

    }

  public static function numberTowords($num)
  {

    $ones = array(
    0 =>"ZERO",
    1 => "ONE",
    2 => "TWO",
    3 => "THREE",
    4 => "FOUR",
    5 => "FIVE",
    6 => "SIX",
    7 => "SEVEN",
    8 => "EIGHT",
    9 => "NINE",
    10 => "TEN",
    11 => "ELEVEN",
    12 => "TWELVE",
    13 => "THIRTEEN",
    14 => "FOURTEEN",
    15 => "FIFTEEN",
    16 => "SIXTEEN",
    17 => "SEVENTEEN",
    18 => "EIGHTEEN",
    19 => "NINETEEN",
    "014" => "FOURTEEN"
    );
    $tens = array( 
    0 => "ZERO",
    1 => "TEN",
    2 => "TWENTY",
    3 => "THIRTY", 
    4 => "FORTY", 
    5 => "FIFTY", 
    6 => "SIXTY", 
    7 => "SEVENTY", 
    8 => "EIGHTY", 
    9 => "NINETY" 
    ); 
    $hundreds = array( 
    "HUNDRED", 
    "THOUSAND", 
    "MILLION", 
    "BILLION", 
    "TRILLION", 
    "QUARDRILLION" 
    ); /*limit t quadrillion */
    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    $decnum = $num_arr[1]; 
    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr,1); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i){
      
    while(substr($i,0,1)=="0")
        $i=substr($i,1,5);
    if($i < 20){ 
    /* echo "getting:".$i; */
    $rettxt .= $ones[$i]; 
    }elseif($i < 100){ 
    if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
    if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
    }else{ 
    if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
    if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
    if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
    } 
    if($key > 0){ 
    $rettxt .= " ".$hundreds[$key]." "; 
    }
    } 
    if($decnum > 0){
    $rettxt .= " and ";
    if($decnum < 20){
    $rettxt .= $ones[$decnum];
    }elseif($decnum < 100){
    $rettxt .= $tens[substr($decnum,0,1)];
    $rettxt .= " ".$ones[substr($decnum,1,1)];
    }
    }
    return $rettxt;
  }


}
