<?php
class Frontoffice_model extends CI_Model
{


    function frontofficesales($fromdate, $todate, $filtervalue)
    {
        $foe = array();
        //------------query for checkin------------------------//
        $chkinquery = "SELECT
        count(check_room_trans.checkinroomtrnid) as checkin,
        check_room_trans.checkroomstatus,
        DATE_FORMAT(check_room_trans.checkindate,'%Y-%m-%d') as datefn
        
        FROM
        check_room_trans 
        where check_room_trans.checkroomstatus=0 and date(check_room_trans.checkindate) BETWEEN '" . $fromdate . "' and '" . $todate . "'
        GROUP BY datefn";
        $chkinrunquery = $this->db->query($chkinquery);
        $checkin = $chkinrunquery->result_array();
        $checkinarray = array();
        foreach ($checkin as $value) {
            $dates = $value['datefn'];
            $checkinarray[$dates] = $value['checkin'];
        }

        //-----------checkout query-----------------//
        $chkoutquery = "SELECT
        count(check_room_trans.checkinroomtrnid) as checkout,
        check_room_trans.checkroomstatus,
        DATE_FORMAT(check_room_trans.checkoutdate,'%Y-%m-%d') as datefn
        
        FROM
        check_room_trans 
        where check_room_trans.checkroomstatus=1 and date(check_room_trans.checkoutdate) BETWEEN '" . $fromdate . "' and '" . $todate . "'
        GROUP BY datefn";
        $chkoutquery = $this->db->query($chkoutquery);
        $checkout = $chkoutquery->result_array();
        $checkoutarray = array();
        foreach ($checkout as $value) {
            $dates = $value['datefn'];
            $checkoutarray[$dates] = $value['checkout'];
        }



        //--------------room satus query for single day-----------//
        if ($filtervalue == 1) {

            $roomsts = "SELECT
            count(room_master.roomstatus) as statuscount,
            roomstatus_master.roomstatusname,
            roomstatus_master.roomstatusid
            FROM
                    room_master
                    right JOIN roomstatus_master ON roomstatus_master.roomstatusid = room_master.roomstatus
            group by roomstatus_master.roomstatusname
            ORDER BY statuscount desc";
            $roomrunstatus = $this->db->query($roomsts);
            $statusdetail = $roomrunstatus->result_array();
            $foe['status'] = $statusdetail;
        }
        if ($filtervalue != 1) {
            $roomoccupencyquery = "SELECT
        count(checkin_room_charges.chargeid) as roomcnt,
        DATE_FORMAT(checkin_room_charges.chargedate, '%Y-%m-%d') AS datefn
        FROM
        checkin_room_charges
        INNER JOIN charges_master ON charges_master.chargeid = checkin_room_charges.chargeid 
        where 
        checkin_room_charges.chargeid=1 and
        checkin_room_charges.checkinroomtrnid>0 and 
        date(checkin_room_charges.chargedate) BETWEEN '" . $fromdate . "' and '" . $todate . "' GROUP BY
        datefn";
            $roomoccupencyrun = $this->db->query($roomoccupencyquery);
            $roomocupency = $roomoccupencyrun->result_array();
            $occupiedstatusarray = array();
            foreach ($roomocupency as $value) {
                $datekey = $value['datefn'];
                $occupiedstatusarray[$datekey] = $value['roomcnt'];
            }

            $foe["occupiedroomcount"] = $occupiedstatusarray;
        }



        //--------------------room sales------------------//
        $roomsalesquery = "SELECT
           
           
           sum(checkin_room_charges.chargeamount) as chk,
           
           
           DATE_FORMAT(checkin_room_charges.chargedate,'%Y-%m-%d') as datefn
           FROM
           checkin_room_charges
           INNER JOIN charges_master ON charges_master.chargeid = checkin_room_charges.chargeid
           where  
           charges_master.chargescostcentre ='ROOM' and  checkin_room_charges.chargeid != 8
           and date(checkin_room_charges.chargedate) BETWEEN '" . $fromdate . "' and '" . $todate . "'
           group by datefn";
        $roomrunsalesquery = $this->db->query($roomsalesquery);
        $roomsales = $roomrunsalesquery->result_array();
        $sale = array();
        foreach ($roomsales as $value) {
            $dates = $value['datefn'];
            $sale[$dates] = $value["chk"];
        }

        //others sales///
        $sql_sales = "SELECT
        checkin_room_charges.chargeid,
        checkin_room_charges.checkinroomtrnid,
        sum(
            checkin_room_charges.chargeamount
        )AS sales,
        charges_master.chargename,
        charges_master.chargescostcentre,
        DATE_FORMAT(
            checkin_room_charges.chargedate,
            '%Y-%m-%d'
        )AS datefn
    FROM
        checkin_room_charges
    INNER JOIN charges_master ON charges_master.chargeid = checkin_room_charges.chargeid
    WHERE
        charges_master.chargescostcentre IN ('FOOD','OTHERS','BEVERAGES')
    AND date(
        checkin_room_charges.chargedate
    )BETWEEN '" . $fromdate . "'
    AND '" . $todate . "'
    AND checkin_room_charges.chargeid != 8
    GROUP BY
        datefn
    
     
      ";
        $frtoffsales = $this->db->query($sql_sales);
        $sale_array = $frtoffsales->result_array();
        ///query for sale via voucher report
        $sql_vouchersales = "SELECT
        voucher_header.vchrid,
        DATE_FORMAT(voucher_header.vchrdate,'%Y-%m-%d') as datefn,
        sum(voucher_trans.dramount)AS vchrrev,
        voucher_header.vchrpostmode,
        voucher_header.vchrtypeid
    FROM
        voucher_header
    INNER JOIN voucher_trans ON voucher_trans.vchrid = voucher_header.vchrid
    WHERE
        voucher_header.vchrtypeid = 1
    AND voucher_header.vchrpostmode = 0
    AND date(voucher_header.vchrdate)BETWEEN '" . $fromdate . "'
    AND '" . $todate . "' order by datefn
    ";
        $frtoffvoursales = $this->db->query($sql_vouchersales);
        $vouchersale_array = $frtoffvoursales->result_array();

        // query for advance sales


        $salesadvne = "
        SELECT
            res_advdtl.advancevchrid,
            DATE_FORMAT(voucher_header.vchrdate,'%Y-%m-%d') as datefn,
            voucher_header.vchrid,
            sum(voucher_trans.dramount)AS advancevachr
        FROM
            res_advdtl
        INNER JOIN voucher_header ON voucher_header.vchrid = res_advdtl.advancevchrid
        INNER JOIN voucher_trans ON voucher_trans.vchrid = voucher_header.vchrid
        WHERE
            date(voucher_header.vchrdate)BETWEEN '" . $fromdate . "'
        AND '" . $todate . "' group by datefn";
        $frtoffadvancesales = $this->db->query($salesadvne);
        $advancesale_array = $frtoffadvancesales->result_array();



        $totelarray = array();
        $salesmodifiedarray = array();
        $vouchermodifiedarray = array();
        $advancemodifiedarray = array();

        foreach ($sale_array as $sales) {
            $dates = $sales['datefn'];

            if (!strlen($dates) == 0) {
                if (!in_array($dates, $totelarray)) {

                    array_push($totelarray, $dates);
                }
            }
        }
        foreach ($advancesale_array as $sales) {
            $dates = $sales['datefn'];

            if (!strlen($dates) == 0) {
                if (!in_array($dates, $totelarray)) {

                    array_push($totelarray, $dates);
                }
            }
        }
        foreach ($vouchersale_array as $sales) {
            $dates = $sales['datefn'];

            if (!strlen($dates) == 0) {
                if (!in_array($dates, $totelarray)) {

                    array_push($totelarray, $dates);
                }
            }
        }
        //echo"<pre>";
        //  print_r($totelarray);
        // echo"</pre>";
        foreach ($sale_array as $sales) {
            $dates = $sales['datefn'];
            $salesmodifiedarray[$dates] = $sales['sales'];
        }
        foreach ($vouchersale_array as $sales) {
            $dates2 = $sales['datefn'];


            $vouchermodifiedarray[$dates2] = $sales['vchrrev'];
        }
        foreach ($advancesale_array as $sales) {
            $dates3 = $sales['datefn'];
            $advancemodifiedarray[$dates3] = $sales['advancevachr'];
        }
        $totel = array();
        // echo"<pre>";
        //  print_r($totelarray);
        //  echo"</pre>";
        foreach ($totelarray as $value) {
            $sales = "";
            $voucher = "";
            $advance = "";

            if (array_key_exists($value, $salesmodifiedarray)) {

                $sales = $salesmodifiedarray[$value];
            } else {
                $sales = 0;
            }
            if (array_key_exists($value, $vouchermodifiedarray)) {

                $voucher = $vouchermodifiedarray[$value];
            } else {
                $voucher = 0;
            }
            if (array_key_exists($value, $advancemodifiedarray)) {

                $advance = $advancemodifiedarray[$value];
            } else {
                $advance = 0;
            }

            $totel[$value] = $sales + $voucher + $advance;
        }

        // echo"<pre>";
        // print_r($totel);
        //echo"</pre>";

        ////totel revenue//

        $revenuequery = "SELECT
           sum(
               checkin_room_charges.chargeamount
           )*- 1 AS chargeamounts,
           DATE_FORMAT(
               checkin_room_charges.chargedate,
               '%Y-%m-%d'
           )AS datefn,
           checkin_room_charges.settleid
       FROM
           checkin_room_charges
       INNER JOIN charges_master ON charges_master.chargeid = checkin_room_charges.chargeid
       INNER JOIN settle_master ON settle_master.settleid = checkin_room_charges.settleid
       WHERE
           date(
               checkin_room_charges.chargedate
           )BETWEEN '" . $fromdate . "'
       AND '" . $todate . "'
       AND checkin_room_charges.chargeid IN(7, 11)
       AND checkin_room_charges.vchrid > 0
       GROUP BY
           datefn,
           checkin_room_charges.settleid";
        $revenueqryrun = $this->db->query($revenuequery);
        $revenuearay = $revenueqryrun->result_array();


        $totelrevenue = array();
        foreach ($revenuearay as $value) {
            $dates = $value["datefn"];

            if (!array_key_exists($dates, $totelrevenue)) {
                $totelrevenue[$dates] = [];
            }
            array_push($totelrevenue[$dates], $value);
        }
        // echo"<pre>";
        //print_r($totelrevenue);
        //echo"</pre>";

        $revenueresult = array();
        foreach ($totelrevenue as $key => $dates) {

            $datedata = $key . "";
            $totels = 0;
            $revenueresult[$datedata] = [];

            foreach ($dates as $dkey => $value) {

                $totels += $value['chargeamounts'];

                $settleid = $value['settleid'];
                if ($settleid == 1) {
                    $key = "cash";
                    //$cash+=$value['chargeamounts'];
                } else if ($settleid == 2) {
                    $key = "card";
                    //$card+=$value['chargeamounts'];
                } else if ($settleid == 4) {
                    $key = "credit";
                    //$credit+=$value['chargeamounts'];
                } else if ($settleid == 3 || $settleid == 5) {
                    $key = "bank";
                    //$bank+=$value['chargeamounts'];
                }

                if (!array_key_exists($key, $revenueresult[$datedata])) {
                    $revenueresult[$datedata][$key] = 0;
                }
                $revenueresult[$datedata][$key] += $value['chargeamounts'];
                $revenueresult[$datedata]["totel"] = $totels;
            }
        }
        $highbalqry = "SELECT
	sum(
		checkin_room_charges.chargeamount
	)AS totel,
	checkin_room_charges.chargeid,
	DATE_FORMAT(
		checkin_room_charges.chargedate,
		'%Y-%m-%d'
	)AS datefn
    FROM
	checkin_room_charges
    INNER JOIN charges_master ON charges_master.chargeid = checkin_room_charges.chargeid
    WHERE
	charges_master.chargescostcentre IN(
		'ROOM',
		'FOOD',
		'OTHERS',
		'BEVERAGES'
	) And checkin_room_charges.chargeid!=8
    AND date(
	checkin_room_charges.chargedate
    )BETWEEN '" . $fromdate . "'
    AND '" . $todate . "'";


        $highbalqryrun = $this->db->query($highbalqry);
        $totelbalance = $highbalqryrun->result_array();
        foreach ($totelbalance as $value) {

            $totelbal = $value['totel'];
        }

        $hignbaldiscountqry = "SELECT
	chargedate,
	sum(chargeamount)*- 1 AS amount,
	chargeid
FROM
	checkin_room_charges
WHERE
	chargeid IN (7,8)
AND date(chargedate) BETWEEN '" . $fromdate . "'
AND '" . $todate . "'";
        $highbaldiscountqryrun = $this->db->query($hignbaldiscountqry);
        $discountandadvance = $highbaldiscountqryrun->result_array();
        foreach ($discountandadvance as $val) {
            $discountbal = $val['amount'];
        }
        $highbalance = $totelbal - $discountbal;

        $arrqry = "SELECT
	
		sum(checkin_room_charges.chargeamount) as totel,
	
	checkin_room_charges.chargeid,
	DATE_FORMAT(
		checkin_room_charges.chargedate,
		'%Y-%m-%d'
	)AS datefn
FROM
	checkin_room_charges
INNER JOIN charges_master ON charges_master.chargeid = checkin_room_charges.chargeid
WHERE
	charges_master.chargescostcentre = 'ROOM'
		 and 	checkin_room_charges.chargeid!=8
AND date(
	checkin_room_charges.chargedate
)BETWEEN '" . $fromdate . "'
AND '" . $todate . "'";
        $arrqryrun = $this->db->query($arrqry);
        $arrtotel = $arrqryrun->result_array();
        foreach ($arrtotel as $val) {
            $arrtotel1 = $val['totel'];
        }
        $arrdis = "SELECT
	DATE_FORMAT(
			checkin_room_charges.chargedate,
		'%Y-%m-%d'
	)AS datefn,
	sum(checkin_room_charges.chargeamount)*-1 as amount,
		checkin_room_charges.chargeid
FROM
	checkin_room_charges
WHERE
	checkin_room_charges.chargeid =8
AND 	date(checkin_room_charges.chargedate) BETWEEN '" . $fromdate . "'
AND '" . $todate . "'";
        $arrdisrun = $this->db->query($arrdis);
        $arrdiscount = $arrdisrun->result_Array();
        foreach ($arrdiscount as $val) {
            $arrtotel2 = $val['amount'];
        }
        $arr = $arrtotel1 - $arrtotel2;
        $foe['checkin'] = $checkinarray;
        $foe['checkout'] = $checkoutarray;
        $foe['arr'] = $arr;
        $foe['highbalance'] = $highbalance;
        $foe['sales'] = $sale;
        $foe['othersales'] = $totel;
        $foe['revenue'] = $revenueresult;
        // echo"<pre>";
        // print_r($totel);
        // echo"</pre>";
        // echo"<pre>";
        // print_r($foe);
        // echo"</pre>";
        return $foe;
    }
}
