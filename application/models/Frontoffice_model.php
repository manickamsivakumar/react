<?php
class Frontoffice_model extends CI_Model
{

  
    function frontofficesales($fromdate,$todate,$filtervalue,$propid){
        $foe=array();
        //var_dump($propid);
        $data=$this->session->userdata('propdetails')[$propid];
       
      //echo"<pre>";
      // print_r($data);
       //echo"</pre>";
      // return;
        $key=$propid;

         
           
           
             
            $dbname=$data['databasename'];
            $cmpid=$data['cmpid'];
            $propcity=$data['propcity'];
            $propcolor=$data['propcolor'];
            $propname=$data['propname'];
           
         
         $foe['propcolor']=$propcolor;
         $foe['propcity']=$propcity;
         $foe['propname']=$propname;
        //------------query for checkin------------------------//
        $chkinquery="SELECT
        count(".$dbname.".check_room_trans.checkinroomtrnid) as checkin,
        ".$dbname.".check_room_trans.checkroomstatus,
        DATE_FORMAT(".$dbname.".check_room_trans.checkindate,'%Y-%m-%d') as datefn
        
        FROM
        ".$dbname.".check_room_trans 
        where ".$dbname.".check_room_trans.propid=".$propid." and ".$dbname.".check_room_trans.cmpid=".$cmpid." and ".$dbname.".check_room_trans.checkroomstatus=0 and date(".$dbname.".check_room_trans.checkindate) BETWEEN '".$fromdate."' and '".$todate."'
        GROUP BY datefn";
        
        $chkinrunquery=$this->db->query($chkinquery);
        $checkin=$chkinrunquery->result_array();
          $checkinarray=array();
         foreach($checkin as $value){
             $dates=$value['datefn'];
            $checkinarray[$dates]=$value['checkin'];
         }

        //-----------checkout query-----------------//
        $chkoutquery="SELECT
        count(".$dbname.".check_room_trans.checkinroomtrnid) as checkout,
        ".$dbname.".check_room_trans.checkroomstatus,
        DATE_FORMAT(".$dbname.".check_room_trans.checkoutdate,'%Y-%m-%d') as datefn
        
        FROM
        ".$dbname.".check_room_trans 
        where ".$dbname.".check_room_trans.propid=".$propid." and ".$dbname.".check_room_trans.cmpid=".$cmpid." and ".$dbname.".check_room_trans.checkroomstatus=1 and date(".$dbname.".check_room_trans.checkoutdate) BETWEEN '".$fromdate."' and '".$todate."'
        GROUP BY datefn";
        $chkoutquery=$this->db->query($chkoutquery);
        $checkout=$chkoutquery->result_array();
        $checkoutarray=array();
        foreach($checkout as $value){
            $dates=$value['datefn'];
           $checkoutarray[$dates]=$value['checkout'];
        }


       //only happen when filter date is equal to today
        //--------------room satus query for single day---------here ".$dbname.".room_master.propid=".$propid." and ".$dbname.".room_master.cmpid=".$cmpid." --//
        if($filtervalue==1){

            $roomsts="SELECT
            count(".$dbname.".room_master.roomstatus) as statuscount,
            ".$dbname.".roomstatus_master.roomstatusname,
            ".$dbname.".roomstatus_master.roomstatusid
            FROM
            ".$dbname.".room_master
                    right JOIN ".$dbname.".roomstatus_master ON ".$dbname.".room_master.roomstatus = ".$dbname.".roomstatus_master.roomstatusid
                and ".$dbname.".room_master.activestatus != 0
                   
            group by ".$dbname.".roomstatus_master.roomstatusid
            ";
           // echo $roomsts;
            $roomrunstatus=$this->db->query($roomsts);
            $statusdetail=$roomrunstatus->result_array();
            $foe['status']= $statusdetail;
    
        }
        //only happen when filter date is not equal to today
       if($filtervalue!=1){
        $roomoccupencyquery="SELECT
        count(".$dbname.".checkin_room_charges.chargeid) as roomcnt,
        DATE_FORMAT(".$dbname.".checkin_room_charges.chargedate, '%Y-%m-%d') AS datefn
        FROM
        ".$dbname.".checkin_room_charges
        INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid 
        where ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
        ".$dbname.".checkin_room_charges.chargeid=1 and
        ".$dbname.".checkin_room_charges.checkinroomtrnid>0 and 
        date(".$dbname.".checkin_room_charges.chargedate) BETWEEN '".$fromdate ."' and '".$todate."' GROUP BY
        datefn";
        $roomoccupencyrun=$this->db->query($roomoccupencyquery);
        $roomocupency=$roomoccupencyrun->result_array();
        $occupiedstatusarray=array();
         foreach($roomocupency as $value){
          $datekey=$value['datefn'];
          $occupiedstatusarray[$datekey]=$value['roomcnt'];
          } 

         $foe["occupiedroomcount"]=$occupiedstatusarray;
       }
    
         

           //--------------------room sales------------------//
           $roomsalesquery="SELECT
           
           
           sum(".$dbname.".checkin_room_charges.chargeamount) as chk,
           
           
           DATE_FORMAT(".$dbname.".checkin_room_charges.chargedate,'%Y-%m-%d') as datefn
           FROM
           ".$dbname.".checkin_room_charges
           INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
           where  ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
           ".$dbname.".charges_master.chargescostcentre ='ROOM' and  ".$dbname.".checkin_room_charges.chargeid != 8
           and date(".$dbname.".checkin_room_charges.chargedate) BETWEEN '".$fromdate."' and '".$todate."'
           group by datefn";
           $roomrunsalesquery=$this->db->query($roomsalesquery);
           $roomsales=$roomrunsalesquery->result_array();
          $sale=array();
          foreach($roomsales as $value){
              $dates=$value['datefn'];
              $sale[$dates]=$value["chk"];
          }

           //others sales///
            $sql_sales = "SELECT
        ".$dbname.".checkin_room_charges.chargeid,
        ".$dbname.".checkin_room_charges.checkinroomtrnid,
        sum(
            ".$dbname.".checkin_room_charges.chargeamount
        )AS sales,
        ".$dbname.".charges_master.chargename,
        ".$dbname.".charges_master.chargescostcentre,
        DATE_FORMAT(
            ".$dbname.".checkin_room_charges.chargedate,
            '%Y-%m-%d'
        )AS datefn
    FROM
    ".$dbname.".checkin_room_charges
    INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
    WHERE ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
    ".$dbname.".charges_master.chargescostcentre IN ('FOOD','OTHERS','BEVERAGES')
    AND date(
        ".$dbname.".checkin_room_charges.chargedate
    )BETWEEN '".$fromdate."'
    AND '".$todate."'
    AND ".$dbname.".checkin_room_charges.chargeid != 8
    GROUP BY
        datefn
    
     
      ";
        $frtoffsales = $this->db->query($sql_sales);
        $sale_array = $frtoffsales->result_array();
///query for sale via voucher report
        $sql_vouchersales = "SELECT
        ".$dbname.".voucher_header.vchrid,
        DATE_FORMAT(".$dbname.".voucher_header.vchrdate,'%Y-%m-%d') as datefn,
        sum(".$dbname.".voucher_trans.dramount)AS vchrrev,
        ".$dbname.".voucher_header.vchrpostmode,
        ".$dbname.".voucher_header.vchrtypeid
    FROM
    ".$dbname.".voucher_header
    INNER JOIN ".$dbname.".voucher_trans ON ".$dbname.".voucher_trans.vchrid = ".$dbname.".voucher_header.vchrid
    WHERE
    ".$dbname.".voucher_header.propid=".$propid." and ".$dbname.".voucher_header.cmpid=".$cmpid." and
    ".$dbname.".voucher_header.vchrtypeid = 1
    AND ".$dbname.".voucher_header.vchrpostmode = 0
    AND date(".$dbname.".voucher_header.vchrdate)BETWEEN '".$fromdate."'
    AND '".$todate."' order by datefn
    ";
        $frtoffvoursales = $this->db->query($sql_vouchersales);
        $vouchersale_array = $frtoffvoursales->result_array();

        // query for advance sales


        $salesadvne = "
        SELECT
        ".$dbname.".res_advdtl.advancevchrid,
            DATE_FORMAT(".$dbname.".voucher_header.vchrdate,'%Y-%m-%d') as datefn,
            ".$dbname.".voucher_header.vchrid,
            sum(".$dbname.".voucher_trans.dramount)AS advancevachr
        FROM
        ".$dbname.".res_advdtl
        INNER JOIN ".$dbname.".voucher_header ON ".$dbname.".voucher_header.vchrid = ".$dbname.".res_advdtl.advancevchrid
        INNER JOIN ".$dbname.".voucher_trans ON ".$dbname.".voucher_trans.vchrid = ".$dbname.".voucher_header.vchrid
        WHERE date(".$dbname.".voucher_header.vchrdate)BETWEEN '".$fromdate."'
        AND '".$todate."' group by datefn";
        $frtoffadvancesales = $this->db->query($salesadvne);
        $advancesale_array = $frtoffadvancesales->result_array();



        $totelarray=array();
        $salesmodifiedarray=array();
        $vouchermodifiedarray=array();
        $advancemodifiedarray=array();
       
        foreach($sale_array as $sales){
            $dates=$sales['datefn'];
        
            if(!strlen($dates)==0){
            if(!in_array($dates,$totelarray)){

                array_push($totelarray,$dates);
            }
        }
        }
        foreach($advancesale_array as $sales){
            $dates=$sales['datefn'];
            
            if(!strlen($dates)==0){
            if(!in_array($dates,$totelarray)){

                array_push($totelarray,$dates);
            } }

        }
        foreach($vouchersale_array as $sales){
            $dates=$sales['datefn'];
            
            if(!strlen($dates)==0){
            if(!in_array($dates,$totelarray)){

                array_push($totelarray,$dates);
            }}

        }
        //echo"<pre>";
      //  print_r($totelarray);
     // echo"</pre>";
        foreach($sale_array as $sales){
            $dates=$sales['datefn'];
            $salesmodifiedarray[$dates]=$sales['sales'];

        }
        foreach( $vouchersale_array as $sales){
            $dates2=$sales['datefn'];

            
            $vouchermodifiedarray[$dates2]=$sales['vchrrev'];

        }
        foreach($advancesale_array as $sales){
            $dates3=$sales['datefn'];
            $advancemodifiedarray[$dates3]=$sales['advancevachr'];

        }
       $totel=array();
      // echo"<pre>";
      //  print_r($totelarray);
      //  echo"</pre>";
        foreach($totelarray as $value){
            $sales="";
            $voucher="";
            $advance="";
             
            if(array_key_exists($value,$salesmodifiedarray)){

                $sales=$salesmodifiedarray[$value];

            }else{
                $sales=0;
            }
            if(array_key_exists($value,$vouchermodifiedarray)){

                $voucher=$vouchermodifiedarray[$value];

            }else{
                $voucher=0;
            }
            if(array_key_exists($value,$advancemodifiedarray)){

                $advance=$advancemodifiedarray[$value];

            }else{
                $advance=0;
            }

             $totel[$value]=$sales+$voucher+$advance;
             

        }

       // echo"<pre>";
       // print_r($totel);
        //echo"</pre>";

           ////totel revenue//

           $revenuequery="SELECT
           sum(
            ".$dbname.".checkin_room_charges.chargeamount
           )*- 1 AS chargeamounts,
           DATE_FORMAT(
            ".$dbname.".checkin_room_charges.chargedate,
               '%Y-%m-%d'
           )AS datefn,
           ".$dbname.".checkin_room_charges.settleid
       FROM
       ".$dbname.".checkin_room_charges
       INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
       INNER JOIN ".$dbname.".settle_master ON ".$dbname.".settle_master.settleid = ".$dbname.".checkin_room_charges.settleid
       WHERE ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
           date(
            ".$dbname.".checkin_room_charges.chargedate
           )BETWEEN '".$fromdate."'
       AND '".$todate."'
       AND ".$dbname.".checkin_room_charges.chargeid IN(7, 11)
       AND ".$dbname.".checkin_room_charges.vchrid > 0
       GROUP BY
           datefn,
           ".$dbname.".checkin_room_charges.settleid";
           $revenueqryrun=$this->db->query($revenuequery);
           $revenuearay=$revenueqryrun->result_array();
          
         
          $totelrevenue=array();
          foreach($revenuearay as $value){
          $dates=$value["datefn"];

          if(!array_key_exists($dates,$totelrevenue)){
              $totelrevenue[$dates]=[];
          }
          array_push( $totelrevenue[$dates],$value);
        }
       // echo"<pre>";
        //print_r($totelrevenue);
        //echo"</pre>";
          
         $revenueresult=array();
          foreach($totelrevenue as $key => $dates){
           
            $datedata=$key."";
            $totels=0;
            $revenueresult[$datedata]=[];
            
            foreach($dates as $dkey=>$value){

            $totels+=$value['chargeamounts'];

             $settleid=$value['settleid'];
             if($settleid==1){
                 $key="cash";
                 //$cash+=$value['chargeamounts'];
             }
             else if($settleid==2){
                 $key="card";
                //$card+=$value['chargeamounts'];
             }
             else if($settleid==4){
                 $key="credit";
                //$credit+=$value['chargeamounts'];
             }else if($settleid==3||$settleid==5){
                 $key="bank";
                //$bank+=$value['chargeamounts'];
             }
            
             if(!array_key_exists($key,$revenueresult[$datedata])){
                $revenueresult[$datedata][$key]=0;

             }
             $revenueresult[$datedata][$key]+=$value['chargeamounts'];
             $revenueresult[$datedata]["totel"]=$totels;
            }
              

        }
        ///highbalance query section//

        $highbalanceqry="SELECT
        roomid,
        roomno,
        planname,
        checkinroomtrnid,
        currentcheckid,
        roomguestname,
        guestcmpname,
        checkindate,
        likelycheckoutdate,
        noofpax,
        total,
        advance,
        sum(balance) as highbalanceamount,
        highbalcutoffval
    FROM
        (
            SELECT
            ".$dbname.".room_master.roomid,
                ".$dbname.".room_master.roomno,
                ".$dbname.".room_rent_plan_master.planname,
                ".$dbname.".room_master.checkinroomtrnid,
                ".$dbname.".room_master.currentcheckid,
                ".$dbname.".check_room_trans.roomguestname,
                CASE
            WHEN ".$dbname.".checkin_master.webid = 0 THEN
                (
                    CASE
                    WHEN ".$dbname.".checkin_master.guestcmpid = 0 THEN
                    ".$dbname.".checkin_master.agentname
                    ELSE
                    ".$dbname.".checkin_master.guestcmpname
                    END
                )
            ELSE
            websitename
            END guestcmpname,
            DATE_FORMAT(
                ".$dbname.".check_room_trans.checkindate,
                '%d/%m/%Y %H:%i'
            )AS checkindate,
            DATE_FORMAT(
                ".$dbname.".check_room_trans.likelycheckoutdate,
                '%d/%m/%Y %H:%i'
            )AS likelycheckoutdate,
            ".$dbname.".check_room_trans.noofpax,
            COALESCE(
                (
                    SELECT
                        SUM(chargeamount)
                    FROM
                    ".$dbname.".checkin_room_charges
                    WHERE
                    checkinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
                    AND(
                        chargeamount > 0
                        OR chargeid IN(8, 15)
                    )
                ),
                0
            )AS total,
            COALESCE(
                (
                    - 1 *(
                        SELECT
                            SUM(chargeamount)
                        FROM
                        ".$dbname.".checkin_room_charges
                        WHERE
                        checkinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
                        AND chargeid NOT IN(8, 15)
                        AND chargeamount < 0
                    )
                ),
                0
            )AS advance,
            COALESCE(
                (
                    SELECT
                        SUM(chargeamount)
                    FROM
                    ".$dbname.".checkin_room_charges
                    WHERE
                    checkinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
                    AND(
                        chargeamount > 0
                        OR chargeid IN(8, 15)
                    )
                ),
                0
            )- COALESCE(
                (
                    - 1 *(
                        SELECT
                            SUM(chargeamount)
                        FROM
                        ".$dbname.".checkin_room_charges
                        WHERE
                        checkinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
                        AND chargeid NOT IN(8, 15)
                        AND chargeamount < 0
                    )
                ),
                0
            )AS balance,
            ".$dbname.".general_settings.highbalcutoffval
        FROM
        ".$dbname.".room_master
        INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.checkinroomtrnid = ".$dbname.".room_master.checkinroomtrnid
        INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".checkin_master.checkinid = ".$dbname.".check_room_trans.checkid
        INNER JOIN ".$dbname.".room_rent_plan_master ON ".$dbname.".room_rent_plan_master.planid = ".$dbname.".check_room_trans.roomrateplanid
        INNER JOIN ".$dbname.".general_settings ON ".$dbname.".general_settings.propid = ".$dbname.".check_room_trans.propid
        AND ".$dbname.".general_settings.cmpid = ".$dbname.".check_room_trans.cmpid
        LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid
        WHERE
            roomstatus = 2
        AND ".$dbname.".check_room_trans.propid = ".$propid."
        AND ".$dbname.".check_room_trans.cmpid = ".$cmpid."
     
        )AS T
    WHERE
        T.balance >= T.highbalcutoffval
    ORDER BY
        balance DESC
        
        ";
        $highbalqryrun=$this->db->query($highbalanceqry);
       $totelbalance=$highbalqryrun->result_array();
       $highbalance=$totelbalance[0]['highbalanceamount'];
     /*$highbalqry ="SELECT
	sum(
		".$dbname.".checkin_room_charges.chargeamount
	)AS totel,
	".$dbname.".checkin_room_charges.chargeid,
	DATE_FORMAT(
		".$dbname.".checkin_room_charges.chargedate,
		'%Y-%m-%d'
	)AS datefn
    FROM
	".$dbname.".checkin_room_charges
    INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
    WHERE
    ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
	".$dbname.".charges_master.chargescostcentre IN(
		'ROOM',
		'FOOD',
		'OTHERS',
		'BEVERAGES'
	) And ".$dbname.".checkin_room_charges.chargeid!=8
    AND date(
        ".$dbname.".checkin_room_charges.chargedate
    )BETWEEN '".$fromdate."'
    AND '".$todate."'";
    
  

foreach($totelbalance as $value){

    $totelbal=$value['totel'];
}
//high balance query section//
 $hignbaldiscountqry="SELECT
	DATE_FORMAT(".$dbname.".checkin_room_charges.chargedate,'%Y-%m-%d') as chargedates,
	sum(".$dbname.".checkin_room_charges.chargeamount)*- 1 AS amount,
	".$dbname.".checkin_room_charges.chargeid
FROM
".$dbname.".checkin_room_charges
WHERE
".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
".$dbname.".checkin_room_charges.chargeid IN (7,8)
AND date(".$dbname.".checkin_room_charges.chargedate) BETWEEN '".$fromdate."'
AND '".$todate."'";
$highbaldiscountqryrun=$this->db->query($hignbaldiscountqry);
$discountandadvance=$highbaldiscountqryrun->result_array();
foreach($discountandadvance as $val){
    $discountbal=$val['amount'];
}
$highbalance=$totelbal-$discountbal;*/
// average room rent query section/////
$arrqry="SELECT
	
		sum(".$dbname.".checkin_room_charges.chargeamount) as totel,
	
	".$dbname.".checkin_room_charges.chargeid,
	DATE_FORMAT(
		".$dbname.".checkin_room_charges.chargedate,
		'%Y-%m-%d'
	)AS datefn
FROM
".$dbname.".checkin_room_charges
INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
WHERE ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
".$dbname.".charges_master.chargescostcentre = 'ROOM'
		 and 	".$dbname.".checkin_room_charges.chargeid!=8
AND date(
	".$dbname.".checkin_room_charges.chargedate
)BETWEEN '".$fromdate."'
AND '".$todate."'";
$arrqryrun=$this->db->query($arrqry);
$arrtotel=$arrqryrun->result_array();
foreach($arrtotel as $val){
    $arrtotel1=$val['totel'];
}
  $arrdis="SELECT
	DATE_FORMAT(
        ".$dbname.".checkin_room_charges.chargedate,
		'%Y-%m-%d'
	)AS datefn,
	sum(".$dbname.".checkin_room_charges.chargeamount)*-1 as amount,
    ".$dbname.".checkin_room_charges.chargeid
FROM
".$dbname.".checkin_room_charges
WHERE ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
".$dbname.".checkin_room_charges.chargeid =8
AND 	date(".$dbname.".checkin_room_charges.chargedate) BETWEEN '".$fromdate."'
AND '".$todate."'";
$arrdisrun=$this->db->query($arrdis);
$arrdiscount=$arrdisrun->result_Array();   
foreach($arrdiscount as $val){
    $arrtotel2=$val['amount'];
}
$arr=$arrtotel1-$arrtotel2;
        $foe['checkin']=$checkinarray;
        $foe['checkout']=$checkoutarray;
        $foe['arr']=$arr;
       $foe['highbalance']=$highbalance;
        $foe['sales']= $sale;
        $foe['othersales']= $totel;
        $foe['revenue']=$revenueresult;
       // echo"<pre>";
       // print_r($totel);
       // echo"</pre>";
       // echo"<pre>";
       // print_r($foe);
       // echo"</pre>";
            return $foe;
    }

   function foe_arrival_performance($fromdate,$todate,$filtervalue,$propid){
    $data=$this->session->userdata('propdetails')[$propid];
    //echo "<pre>";
    //print_r($data);
    //echo"</pre>";
    $key=$propid;
    $dbname=$data['databasename'];
    $cmpid=$data['cmpid'];
    $propcity=$data['propcity'];
    $propcolor=$data['propcolor'];
    $propname=$data['propname'];
   
       
         $foe_arrival=array();
         
           

     
    ///query for arrival based foe  sales//
    $sql_sale="SELECT
    ".$dbname.".checkin_room_charges.chargeid,
    ".$dbname.".checkin_room_charges.checkinroomtrnid,
    sum(
        ".$dbname.".checkin_room_charges.chargeamount
    )AS sales,
    
    ".$dbname.". checkin_master.arrivalmode,
    ".$dbname.".arrival_mode.arrivalmode as modeofarrival,
    DATE_FORMAT(
        ".$dbname.".checkin_room_charges.chargedate,
        '%Y-%m-%d'
    )AS datefn
    FROM
    ".$dbname.".checkin_room_charges
    INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
    inner join ".$dbname.".checkin_master on ".$dbname.".checkin_master.checkinid=".$dbname.".checkin_room_charges.checkinid
    inner join ".$dbname.".arrival_mode on ".$dbname.".arrival_mode.arrivalid=".$dbname.".checkin_master.arrivalmode
    WHERE ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
    ".$dbname.".charges_master.chargescostcentre IN ('FOOD','OTHERS','BEVERAGES','ROOM')
    AND date(
    ".$dbname.".checkin_room_charges.chargedate
    )BETWEEN '".$fromdate."'
    AND '".$todate."'
    AND ".$dbname.".checkin_room_charges.chargeid != 8
    GROUP BY
    ".$dbname.".checkin_master.arrivalmode"
    ;
    //echo $sql_sale;
    //return;
    $sql_sale_run=$this->db->query($sql_sale);
    $arrivalsalesarray=$sql_sale_run->result_array();
    

    ///arrival occupency and arr room rents///

    $sql_occu="
    SELECT
        count(".$dbname.".checkin_room_charges.chargeid) as count,
            sum(".$dbname.".checkin_room_charges.chargeamount) as totel,
        
        ".$dbname.".checkin_room_charges.chargeid,
        DATE_FORMAT(
            ".$dbname.".checkin_room_charges.chargedate,
            '%Y-%m-%d'
        )AS datefn,
        ".$dbname.". checkin_master.arrivalmode,
        (".$dbname.".arrival_mode.arrivalmode) as modeofarrival

    FROM
    ".$dbname.".checkin_room_charges
    INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
     inner join ".$dbname.".checkin_master on ".$dbname.".checkin_master.checkinid=".$dbname.".checkin_room_charges.checkinid
        inner join ".$dbname.".arrival_mode on ".$dbname.".arrival_mode.arrivalid=".$dbname.".checkin_master.arrivalmode
       
    WHERE ".$dbname.".checkin_room_charges.propid=".$propid." and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and
    ".$dbname.".charges_master.chargescostcentre = 'ROOM'
             and 	".$dbname.".checkin_room_charges.chargeid!=8
    AND date(
        ".$dbname.".checkin_room_charges.chargedate
    )BETWEEN '".$fromdate."'
    AND '".$todate."'
     group by modeofarrival";
    $sql_occu_run=$this->db->query($sql_occu);
    $arrivaloccupencyarray=$sql_occu_run->result_array();
   
    $sql="select 
    count(".$dbname.".checkin_master.arrivalmode) as count,
    ".$dbname.".website_master.websitename
    
    
    
     from ".$dbname.".checkin_master 
    inner join   ".$dbname.".website_master on ".$dbname.".website_master.webid=".$dbname.".checkin_master.webid
    
    where 
    ".$dbname.".checkin_master.propid=".$propid." and ".$dbname.".checkin_master.cmpid=".$cmpid." and

    ".$dbname.".checkin_master.arrivalmode=3 and
    date(
        ".$dbname.".checkin_master.checkindate
    )BETWEEN '".$fromdate."'
    AND '".$todate."'
    group by ".$dbname.".website_master.websitename";

    $sql_run=$this->db->query($sql);
    $ota_array=$sql_run->result_array();
    
    //echo "<pre>";
      //print_r($foe_arrival);
      //echo"</pre>";

      $roomcount="select count(roomid) as roomcount from ".$dbname.".room_master where activestatus!=0";
      $count_run=$this->db->query($roomcount);
      $totalrooms=$count_run->result_array();
     $salesarray=array();
     foreach($arrivalsalesarray as $value){
      $arrivalmode=$value['arrivalmode'];
      $salesarray[$arrivalmode]=$value;


     }
     $occupencyarray=array();
     foreach($arrivaloccupencyarray as $value){
      $arrivalmode=$value['arrivalmode'];
      $occupencyarray[$arrivalmode]=$value;


     }
     $otaarray=array();
     foreach($ota_array as $value){
      $websitename=$value['websitename'];
      $otaarray[$websitename]=$value['count'];
     }
     
     $foe_arrival['occupency']=$occupencyarray;
    
     $foe_arrival['sales']=$salesarray;
     $foe_arrival['ota']=$otaarray;
     $foe_arrival['totalrooms']=$totalrooms[0]['roomcount'];
     return $foe_arrival ; 

   }

   function get_closebal($propid,$cmpid,$ledgerid,$accfromdt,$dbname,$fromdt='',$todt='')   
  
   {
    //$dbname="cloud_dev"; 
       if ($fromdt=='') 
      {
           $fromdt=$accfromdt;
           $todt=date('Y-m-d');
       }
       if($fromdt==$accfromdt)
      {
          $asql="cross join (select 0 balamt) as oledger";        
       }
       else
       {
          $asql=" cross join (select COALESCE(sum(dramount)-sum(cramount),0) balamt from ".$dbname.".ledgerbal where cmpid=".$cmpid." and propid=".$propid." and ledgerid=".$ledgerid." and date(vchrdate) >='".$accfromdt."' and date(vchrdate) < '".$fromdt."') as oledger";
       }
       $dbsql="SELECT odebit,cdebit,ocredit,ccredit,(odebit+cdebit)-(ocredit+ccredit) closebal
       from 
       (select COALESCE(sum(dramount),0) cdebit, COALESCE(sum(cramount),0) ccredit from ".$dbname.".ledgerbal where cmpid=".$cmpid." and propid=".$propid." and ledgerid=".$ledgerid." and date(vchrdate) BETWEEN '".$fromdt."' AND '".$todt."') as cledger
           cross join (select case when (((case when ledgeropentype=1 then 1 when ledgeropentype=0 then -1 else 1 end) * ledgeropenbal) + balamt) >=0 then (((case when ledgeropentype=1 then 1 when ledgeropentype=0 then -1 else 1 end) * ledgeropenbal) + balamt) else 0 end odebit,
       case when (((case when ledgeropentype=1 then 1 when ledgeropentype=0 then -1 else 1 end) * ledgeropenbal) + balamt) <=0 then abs(((case when ledgeropentype=1 then 1 when ledgeropentype=0 then -1 else 1 end) * ledgeropenbal) + balamt) else 0 end ocredit
       from ".$dbname.".ledgerbal ".$asql."
            where cmpid=".$cmpid." and propid=".$propid." and ledgerid=".$ledgerid." LIMIT 1
       ) as obal";
      // echo $dbsql;
       
      $closebal=$this->db->query($dbsql);
  $balancearray=$closebal->result_array();
   
       $closebal=$balancearray[0]['closebal'];
   
   return $closebal;
   }
   
   function getopeningbal($propid,$cmpid,$dbname){
    $dbname="cloud_dev"; 
      $sql="select * from ".$dbname.".general_settings where cmpid=".$cmpid."
      and propid=".$propid."";
      $dbsql=$this->db->query($sql);
      $dbsql1=$dbsql->result_array();
      $openingbal=$dbsql1[0]['showopeningbal'];
      return $openingbal;
  
   }
   function getpropaddress($propid,$cmpid,$dbname){
  
    $dbname="cloud_dev"; 
  
      $sql="select * from ".$dbname.".property_master where cmpid=".$cmpid."
      and propid=".$propid."";
      $dbsql=$this->db->query($sql);
      $dbsql1=$dbsql->result_array();
      $propadd=$dbsql1[0]['propadd1'];
      return $propadd;
   }
   function getsettle($strbill,$rptdate,$start_from,$limit,$from,$to,$propid,$cmpid,$cashledgerid,$dbname){
    $dbname="cloud_dev";  
    $dbvchrsql='';
      $strdt1=$rptdate.' '.$from;
      $strdt2=$rptdate.' '.$to;
      
      if ($strbill=='ADVANCE' || $strbill=='RECEIPT' || $strbill=='PAYMENT')
      {
          $asql="";
          $csql="";
          
          if ($strbill=='ADVANCE') 	//reservation advance
          {	
              
              $vchrtyp=1; 
              $bsql = " resno regno";
              $csql=" INNER JOIN ".$dbname.".res_header on ".$dbname.".res_header.cmpid=".$dbname.".voucher_header.cmpid and ".$dbname.".res_header.propid=".$dbname.".voucher_header.propid
              INNER JOIN ".$dbname.".res_advdtl ON res_advdtl.resid = ".$dbname.".res_header.resid and ".$dbname.".res_advdtl.advancevchrid=".$dbname.".voucher_header.vchrid LEFT JOIN ".$dbname.".guest_cmp_master ON ".$dbname.".guest_cmp_master.guestcmpid=".$dbname.".res_header.res_cmpid
      LEFT JOIN ".$dbname.".website_master ON webid = res_otaid 
      LEFT JOIN ".$dbname.".guest_cmp_master ta ON ta.guestcmpid = res_taid ";
              $resql=" case WHEN COALESCE(".$dbname.".res_header.resid,0)!=0 THEN ".$dbname.".res_header.guestname ELSE ".$dbname.".ledger_master.ledgername end as roomguestname,CASE WHEN ".$dbname.".res_header.res_mode=1 THEN 'Walkin' WHEN  ".$dbname.".res_header.res_mode=3 THEN coalesce(websitename,'') ELSE coalesce(ta.guestcmpname,'') END as mode, CASE WHEN ".$dbname.".res_header.res_iscmpguest=1 THEN ".$dbname.".guest_cmp_master.guestcmpname ELSE '' END as company";
              
          }	
          else if ($strbill=='RECEIPT') 
          {	
              
              $vchrtyp=1; 
              $bsql = "left(narration,20) regno";
              $asql = " and ".$dbname.".voucher_header.vchrid not in (select ".$dbname.".res_advdtl.advancevchrid from ".$dbname.".res_header INNER JOIN ".$dbname.".res_advdtl ON ".$dbname.".res_advdtl.resid = ".$dbname.".res_header.resid where ".$dbname.".res_header.cmpid=".$dbname.".voucher_header.cmpid and ".$dbname.".res_header.propid=".$dbname.".voucher_header.propid  and ".$dbname.".res_advdtl.advancevchrid=".$dbname.".voucher_header.vchrid)";
              $resql=" ".$dbname.".ledger_master.ledgername as roomguestname,case when ".$dbname.".voucher_header.billid!=0 then CONCAT(gm.guestfirstname,coalesce(gm.guestlastname,'')) else '' end mode,'' company";
          }	
          else if ($strbill=='PAYMENT') 
          {	
              $vchrtyp=2;
              $bsql = "left(narration,20) regno";
              $csql=" Left JOIN ".$dbname.".res_cancel ON ".$dbname.".res_cancel.canvchcrid=".$dbname.".voucher_header.vchrid 
      LEFT JOIN ".$dbname.".res_header ON ".$dbname.".res_cancel.resid=".$dbname.".res_header.resid ";
              $resql=" case WHEN COALESCE(res_cancel.resid,0)!=0 THEN ".$dbname.".res_header.guestname ELSE ".$dbname.".ledger_master.ledgername end as roomguestname,'' mode,'' company";
          }	
          $dbvchrsql="(SELECT ".$dbname.".voucher_header.vchrid, case when ".$dbname.".voucher_header.billid!=0 then concat(".$dbname.".voucher_header.vchrno,',',bh.billno) else ".$dbname.".voucher_header.vchrno end billno, ".$bsql.", 
          refno roomno, ".$dbname.".ledger_master.ledgerid, ".$dbname.".ledger_master.ledgername as rmgst, ".$dbname.".voucher_header.vchrtypeid,  
      sum(CASE ".$dbname.".voucher_dtls.settlemode when 1 then (case when vchrtypeid=2 then ".$dbname.".voucher_trans.cramount else ".$dbname.".voucher_trans.dramount end) else 0.00 end) as cash,
      sum(CASE ".$dbname.".voucher_dtls.settlemode when 2 then (case when vchrtypeid=2 then ".$dbname.".voucher_trans.cramount else ".$dbname.".voucher_trans.dramount end) else 0.00 end) as creditcard,
      sum(CASE when ".$dbname.".voucher_dtls.settlemode in (3,5) or (left(refno,8)='POS-Bill' and ".$dbname.".voucher_dtls.settlemode=7) then (case when vchrtypeid=2 then ".$dbname.".voucher_trans.cramount else ".$dbname.".voucher_trans.dramount end) else 0.00 end) as bank, 0.00 credit, ".$resql.", DATE_FORMAT(vchrdate,'%H:%i') Time,vchrdate, ".$dbname.".voucher_dtls.settlemode,username, 0 settletrnid,'' trs, 2 srno
      FROM ".$dbname.".voucher_header
      INNER JOIN ".$dbname.".voucher_trans ON ".$dbname.".voucher_header.vchrid = voucher_trans.vchrid AND voucher_trans.trndir= case when vchrtypeid=1 then 'DR' else 'CR' end
      INNER JOIN ".$dbname.".ledger_master ON ".$dbname.".voucher_header.cmpid = ledger_master.cmpid AND voucher_header.propid = ledger_master.propid AND voucher_header.vchrpartyid = ledger_master.ledgerid
      LEFT JOIN ".$dbname.".voucher_dtls ON ".$dbname.".voucher_header.vchrid = voucher_dtls.vchrid and voucher_trans.ledgerid = case when voucher_header.billid!=0 then voucher_dtls.ldrid else voucher_trans.ledgerid end
      left join ".$dbname.".bill_header bh on ".$dbname.".voucher_header.billid = bh.billhdrid 
      left join ".$dbname.".guest_master gm on gm.guestid = bh.guestid
      LEFT JOIN ".$dbname.".user_master on userid=vchruserid ".$csql." 
      where ".$dbname.".voucher_header.checkinroomtrnid=0 and ".$dbname.".voucher_header.vchrtypeid=".$vchrtyp." and ".$dbname.".voucher_header.bnqttrnid=0 and voucher_header.cmpid=".$cmpid." and voucher_header.propid=".$propid." and vchrdate between '". $strdt1."' and '".$strdt2."' and case when ".$dbname.".voucher_dtls.settlemode=1 then ".$cashledgerid." else ".$dbname.".voucher_trans.ledgerid end = ".$dbname.".voucher_trans.ledgerid ".$asql." GROUP BY ".$dbname.".voucher_header.vchrid ORDER BY ".$dbname.".voucher_header.vchrid)";
          //echo $dbvchrsql."<br>";
          // INNER JOIN voucher_trans vt ON voucher_header.vchrid = vt.vchrid AND voucher_header.vchrpartyid <> vt.ledgerid 
      }
      if ($strbill=='CONTRA-IN')
      {
      //CASE cbst when 1 then voucher_trans.dramount else 0.00 end as cash, 0.00 as creditcard,
      //CASE cbst when 2 then voucher_trans.dramount else 0.00 end as bank, 0.00 credit, DATE_FORMAT(vchrdate,'%h:%i %p') 
          $dbsql="SELECT ".$dbname.".voucher_trans.vchrid, ".$dbname.".voucher_header.vchrno billno, left(narration,20) regno, 
          refno roomno, ".$dbname.".ledger_master.ledgerid, ".$dbname.".ledger_master.ledgername roomguestname,
          voucher_trans.dramount cash, 0.00 as creditcard, 0.00 as bank, 0.00 credit, '' company, '' mode, DATE_FORMAT(vchrdate,'%H:%i') 
      Time,vchrdate, username,0 settletrnid,'' trs
      FROM
      ".$dbname.".voucher_trans
      INNER JOIN ".$dbname.".voucher_header ON ".$dbname.".voucher_trans.vchrid = ".$dbname.".voucher_header.vchrid
      INNER JOIN ".$dbname.".voucher_trans vtcr ON vtcr.vchrid = voucher_trans.vchrid and vtcr.trndir='CR'
      INNER JOIN ".$dbname.".ledger_master ON vtcr.ledgerid = ".$dbname.".ledger_master.ledgerid
      INNER JOIN ".$dbname.".ledger_group_master ON ".$dbname.".ledger_master.ledgergrpid = ".$dbname.".ledger_group_master.ledgergrpid
      LEFT JOIN ".$dbname.".user_master on userid=vchruserid
      WHERE ".$dbname.".voucher_header.cmpid=".$cmpid." and ".$dbname.".voucher_header.propid=".$propid." and ".$dbname.".voucher_header.vchrtypeid=6 and vchrdate between '". $strdt1."' and '".$strdt2."' and ".$dbname.".voucher_trans.trndir='DR' and ".$dbname.".voucher_trans.ledgerid=".$cashledgerid." 
       ORDER BY ".$dbname.".voucher_trans.vchrid";
          //echo "<br>cntin :".$dbsql."<br>";
          /*
          and voucher_trans.vchrid in (SELECT DISTINCT voucher_trans.vchrid FROM voucher_trans INNER JOIN voucher_header ON voucher_trans.vchrid = voucher_header.vchrid
      WHERE voucher_header.cmpid=".$cmpid." and voucher_header.propid=".$propid." and voucher_header.vchrtypeid=6 and date(vchrdate)='". $strdt ."' and voucher_trans.ledgerid=".$cashledgerid." and trndir='DR')
          */
      }
      else if ($strbill=='CONTRA-OUT')
      {
      //CASE cbst when 1 then voucher_trans.cramount else 0.00 end as cash, 0.00 as creditcard,
      //CASE cbst when 2 then voucher_trans.cramount else 0.00 end as bank, 0.00 credit, '' company, '' mode, 
          $dbsql="SELECT ".$dbname.".voucher_trans.vchrid, ".$dbname.".voucher_header.vchrno billno, left(narration,20) regno, 
          refno roomno, ".$dbname.".ledger_master.ledgerid, ".$dbname.".ledger_master.ledgername roomguestname,
          ".$dbname.".voucher_trans.cramount as cash, 0.00 as creditcard, 0.00 as bank, 0.00 credit, '' company, '' mode,
      DATE_FORMAT(vchrdate,'%H:%i') Time,vchrdate, username,0 settletrnid,'' trs
      FROM
      ".$dbname.".voucher_trans
      INNER JOIN ".$dbname.".voucher_header ON ".$dbname.".voucher_trans.vchrid = ".$dbname.".voucher_header.vchrid
      INNER JOIN ".$dbname.".voucher_trans vtdr ON vtdr.vchrid = ".$dbname.".voucher_trans.vchrid and vtdr.trndir='DR'
      INNER JOIN ".$dbname.".ledger_master ON vtdr.ledgerid = ".$dbname.".ledger_master.ledgerid
      INNER JOIN ".$dbname.".ledger_group_master ON ".$dbname.".ledger_master.ledgergrpid = ".$dbname.".ledger_group_master.ledgergrpid
      LEFT JOIN ".$dbname.".user_master on userid=vchruserid
      WHERE voucher_header.cmpid=".$cmpid." and ".$dbname.".voucher_header.propid=".$propid." and ".$dbname.".voucher_header.vchrtypeid=6 and vchrdate between '". $strdt1."' and '".$strdt2."' and ".$dbname.".voucher_trans.trndir='CR' and ".$dbname.".voucher_trans.ledgerid=".$cashledgerid." 
       ORDER BY voucher_trans.vchrid";
          /*
          and voucher_trans.vchrid in (SELECT DISTINCT voucher_trans.vchrid FROM voucher_trans INNER JOIN voucher_header ON voucher_trans.vchrid = voucher_header.vchrid
      WHERE voucher_header.cmpid=".$cmpid." and voucher_header.propid=".$propid." and voucher_header.vchrtypeid=6 and date(vchrdate)='". $strdt ."' and voucher_trans.ledgerid=".$cashledgerid." and trndir='CR')
          */
      }
      else if ($strbill=='ADVANCE')
      {	
          $biltrn="";
          $dbsql1="
              UNION 
              " . $dbvchrsql;
          $dbsql0="(SELECT ".$dbname.".checkin_room_charges.checkroomchargeid,".$dbname.".voucher_header.vchrno billno, ".$dbname.".checkin_master.grc regno,
      room_master.roomno, check_room_trans.checkid, check_room_trans.roomguestname as rmgst, ".$dbname.".charges_master.chargetype,
      CASE  ".$dbname.".checkin_room_charges.settleid when 1 then (-1)*".$dbname.".checkin_room_charges.chargeamount else 0.00 end as cash,
      CASE  ".$dbname.".checkin_room_charges.settleid when 2 then (-1)*".$dbname.".checkin_room_charges.chargeamount else 0.00 end as creditcard,
      CASE  when ".$dbname.".checkin_room_charges.settleid in (3,5) then (-1)*".$dbname.".checkin_room_charges.chargeamount else 0.00 end as bank, 0.00 credit, ".$dbname.".check_room_trans.roomguestname, CASE WHEN ".$dbname.".checkin_master.arrivalmode=1 THEN 'Walkin' WHEN  ".$dbname.".checkin_master.arrivalmode=3 THEN coalesce(websitename,'') ELSE ".$dbname.".checkin_master.Agentname END as mode,CASE WHEN ".$dbname.".checkin_master.guestcmpid!=0 THEN ".$dbname.".checkin_master.guestcmpname ELSE '' END AS company, DATE_FORMAT(chargedate,'%H:%i') Time,chargedate, ".$dbname.".checkin_room_charges.settleid, username, ".$dbname.".checkin_room_charges.settletrnid,'' trs, 1 srno 
      FROM
      ".$dbname.".checkin_room_charges
      INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
      INNER JOIN ".$dbname.".charge_def_master ON ".$dbname.".charge_def_master.defid = ".$dbname.".charges_master.defineid
      INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.checkinroomtrnid = ".$dbname.".checkin_room_charges.checkinroomtrnid
      INNER JOIN ".$dbname.".room_master ON ".$dbname.".room_master.roomid = ".$dbname.".check_room_trans.roomid
      INNER JOIN ".$dbname.".voucher_header ON ".$dbname.".checkin_room_charges.vchrid = ".$dbname.".voucher_header.vchrid
      INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".checkin_master.checkinid = ".$dbname.".check_room_trans.checkid
      LEFT JOIN ".$dbname.".user_master on userid=vchruserid
      LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid 
      where ".$dbname.".checkin_room_charges.settleid<>6 and ".$dbname.".checkin_room_charges.cmpid=".$cmpid." and ".$dbname.".checkin_room_charges.propid=".$propid." and vchrdate between '". $strdt1."' and '".$strdt2."' and (".$dbname.".charge_def_master.definename = '" . $strbill . "')
      ORDER BY checkroomchargeid)";	//charge_def_master.definename, charge_def_master.definetype, checkin_room_charges.checkinroomtrnid, checkin_room_charges.settletrnid,
          //checkin_room_charges.nightaudit=1 and
          $dbsql = $dbsql0 . $dbsql1 . " order by srno,time 
          LIMIT $start_from,$limit";
          //echo $dbsql." -adv<br>";
      }
      else if ($strbill=='RECEIPT' || $strbill=='REFUND')
      {
          $dbsql1='';$biltrn="(4,7)";
          if ($strbill=='RECEIPT')
          {
              $asql = "('RECEIPT','CREDIT','BILL TRANSFER')";
              $trnsbil=" case when COALESCE(".$dbname.".checkin_room_charges.billcheckinroomtrnid,0)!=0 and COALESCE(totrns.checkroomstatus,0)=1 THEN (select COALESCE(abs(settleamount),0) from ".$dbname.".bill_settle where ".$dbname.".bill_settle.billhdrid = ".$dbname.".bill_header.billhdrid and ".$dbname.".bill_settle.settletrnid=".$dbname.".checkin_room_charges.settletrnid and ".$dbname.".bill_settle.settleid in (4,7)) ELSE '' END as trs, 1 srno ";
              $dbsql1="
              UNION 
              " . $dbvchrsql;
              
          }
          else
          {
              $asql = "('REFUND')"; $trnsbil=" '' trs, 1 srno ";
          }
          $dbsql0="(SELECT DISTINCT ".$dbname.".voucher_header.vchrid,case when ".$dbname.".voucher_header.vchrid!=0 then concat(".$dbname.".voucher_header.vchrno,',',".$dbname.".bill_header.billno) else ".$dbname.".bill_header.billno end as billno, ".$dbname.".checkin_master.grc regno, ".$dbname.".room_master.roomno, ".$dbname.".check_room_trans.checkid, ".$dbname.".check_room_trans.roomguestname as rmgst, ".$dbname.".bill_header.propid, 
      (select COALESCE(settleamount,0) from ".$dbname.".bill_settle where bill_settle.billhdrid = ".$dbname.".bill_header.billhdrid and ".$dbname.".bill_settle.settletrnid=".$dbname.".checkin_room_charges.settletrnid and ".$dbname.".bill_settle.settleid=1) as cash,
      (select COALESCE(settleamount,0) from ".$dbname.".bill_settle where bill_settle.billhdrid = ".$dbname.".bill_header.billhdrid and ".$dbname.".bill_settle.settletrnid=".$dbname.".checkin_room_charges.settletrnid and ".$dbname.".bill_settle.settleid=2) as creditcard,
      (select COALESCE(settleamount,0) from ".$dbname.".bill_settle where bill_settle.billhdrid = ".$dbname.".bill_header.billhdrid and ".$dbname.".bill_settle.settletrnid=".$dbname.".checkin_room_charges.settletrnid and ".$dbname.".bill_settle.settleid=3) as bank, 
      case when COALESCE(totrns.checkroomstatus,0)=0 THEN (select abs(COALESCE(settleamount,0)) from ".$dbname.".bill_settle where ".$dbname.".bill_settle.billhdrid = ".$dbname.".bill_header.billhdrid and ".$dbname.".bill_settle.settletrnid=".$dbname.".checkin_room_charges.settletrnid and ".$dbname.".bill_settle.settleid in ".$biltrn.") ELSE '' END as credit,
      case when ".$dbname.".checkin_room_charges.billcheckinroomtrnid !=0 THEN CONCAT(".$dbname.".check_room_trans.roomguestname,' ','(Bill Trans. to Rm.',torm.roomno,')') ELSE CONCAT(check_room_trans.roomguestname) END as roomguestname,CASE WHEN checkin_master.arrivalmode=1 THEN 'Walkin' WHEN  checkin_master.arrivalmode=3 THEN coalesce(websitename,'') ELSE checkin_master.Agentname END as mode,CASE WHEN checkin_master.guestcmpid!=0 THEN checkin_master.guestcmpname ELSE '' END AS company,
      DATE_FORMAT(billdate,'%H:%i') Time,billdate chargedate,
      ".$dbname.".bill_header.billcheckinroomtrnid checkinroomtrnid,username,".$dbname.".checkin_room_charges.settletrnid,".$trnsbil."
      FROM
      ".$dbname.".bill_header INNER JOIN ".$dbname.".checkin_room_charges ON ".$dbname.".bill_header.billhdrid = ".$dbname.".checkin_room_charges.billid and chargedate between '". $strdt1."' and '".$strdt2."'
      INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
      INNER JOIN ".$dbname.".charge_def_master ON ".$dbname.".charge_def_master.defid = ".$dbname.".charges_master.defineid
      INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.checkinroomtrnid = ".$dbname.".bill_header.billcheckinroomtrnid
      INNER JOIN ".$dbname.".room_master ON ".$dbname.".room_master.roomid = ".$dbname.".check_room_trans.roomid
      INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".checkin_master.checkinid = ".$dbname.".check_room_trans.checkid
      LEFT JOIN ".$dbname.".check_room_trans totrns ON totrns.checkinroomtrnid=".$dbname.".checkin_room_charges.billcheckinroomtrnid 
      LEFT JOIN ".$dbname.".room_master torm ON totrns.roomid=torm.roomid
      LEFT JOIN ".$dbname.".voucher_header on ".$dbname.".checkin_room_charges.vchrid=".$dbname.".voucher_header.vchrid
      LEFT JOIN ".$dbname.".user_master on userid=billusrid
      LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid 
      where ".$dbname.".checkin_room_charges.settletrnid != 0 and ".$dbname.".bill_header.cmpid=".$cmpid." and ".$dbname.".bill_header.propid=".$propid." and (billdate between '". $strdt1."' and '".$strdt2."' or vchrdate between '". $strdt1."' and '".$strdt2."') and (".$dbname.".charge_def_master.definename IN ".$asql.") ORDER BY ".$dbname.".voucher_header.vchrid) ";
      $dbsql = $dbsql0 . $dbsql1 . " order by vchrid 
      LIMIT $start_from,$limit";
          // bill_header.billcheckinroomtrnid = checkin_room_charges.checkinroomtrnid and
          //(select COALESCE(settleamount,0) from bill_settle where bill_settle.billhdrid = bill_header.billhdrid and bill_settle.settletrnid=checkin_room_charges.settletrnid and bill_settle.settleid in ".$biltrn.") as credit, 
      //echo "<br>rcp: ".$dbsql.'<br><br>';
      }
      else if ($strbill=='PAYMENT')
      {
          $dbsql=$dbvchrsql ;//  Order by Time LIMIT $limit,$start_from";
          //echo "<br><br>pymnt: ".$dbsql;
      }
      //echo $dbsql.'<br><br>';
      $runsql=$this->db->query($dbsql);
      $result=$runsql->result_array();
  
      return $result;
  
  
  
   }
  function gethighbalancereport($propid,$dbname,$cmpid){
//var_dump($dbname);

    $highbalanceqry="SELECT
    roomid,
    roomno,
    planname,
    checkinroomtrnid,
    currentcheckid,
    roomguestname,
    guestcmpname,
    checkindate,
    likelycheckoutdate,
    noofpax,
    total,
    advance,
    balance,
    highbalcutoffval
FROM
    (
        SELECT
        ".$dbname.".room_master.roomid,
            ".$dbname.".room_master.roomno,
            ".$dbname.".room_rent_plan_master.planname,
            ".$dbname.".room_master.checkinroomtrnid,
            ".$dbname.".room_master.currentcheckid,
            ".$dbname.".check_room_trans.roomguestname,
            CASE
        WHEN ".$dbname.".checkin_master.webid = 0 THEN
            (
                CASE
                WHEN ".$dbname.".checkin_master.guestcmpid = 0 THEN
                ".$dbname.".checkin_master.agentname
                ELSE
                ".$dbname.".checkin_master.guestcmpname
                END
            )
        ELSE
        websitename
        END guestcmpname,
        DATE_FORMAT(
            ".$dbname.".check_room_trans.checkindate,
            '%d/%m/%Y %H:%i'
        )AS checkindate,
        DATE_FORMAT(
            ".$dbname.".check_room_trans.likelycheckoutdate,
            '%d/%m/%Y %H:%i'
        )AS likelycheckoutdate,
        ".$dbname.".check_room_trans.noofpax,
        COALESCE(
            (
                SELECT
                    SUM(chargeamount)
                FROM
                ".$dbname.".checkin_room_charges
                WHERE
                checkinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
                AND(
                    chargeamount > 0
                    OR chargeid IN(8, 15)
                )
            ),
            0
        )AS total,
        COALESCE(
            (
                - 1 *(
                    SELECT
                        SUM(chargeamount)
                    FROM
                    ".$dbname.".checkin_room_charges
                    WHERE
                    checkinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
                    AND chargeid NOT IN(8, 15)
                    AND chargeamount < 0
                )
            ),
            0
        )AS advance,
        COALESCE(
            (
                SELECT
                    SUM(chargeamount)
                FROM
                ".$dbname.".checkin_room_charges
                WHERE
                checkinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
                AND(
                    chargeamount > 0
                    OR chargeid IN(8, 15)
                )
            ),
            0
        )- COALESCE(
            (
                - 1 *(
                    SELECT
                        SUM(chargeamount)
                    FROM
                    ".$dbname.".checkin_room_charges
                    WHERE
                    checkinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
                    AND chargeid NOT IN(8, 15)
                    AND chargeamount < 0
                )
            ),
            0
        )AS balance,
        ".$dbname.".general_settings.highbalcutoffval
    FROM
    ".$dbname.".room_master
    INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.checkinroomtrnid = ".$dbname.".room_master.checkinroomtrnid
    INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".checkin_master.checkinid = ".$dbname.".check_room_trans.checkid
    INNER JOIN ".$dbname.".room_rent_plan_master ON ".$dbname.".room_rent_plan_master.planid = ".$dbname.".check_room_trans.roomrateplanid
    INNER JOIN ".$dbname.".general_settings ON ".$dbname.".general_settings.propid = ".$dbname.".check_room_trans.propid
    AND ".$dbname.".general_settings.cmpid = ".$dbname.".check_room_trans.cmpid
    LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid
    WHERE
        roomstatus = 2
    AND ".$dbname.".check_room_trans.propid = ".$propid."
    AND ".$dbname.".check_room_trans.cmpid = ".$cmpid."
 
    )AS T
WHERE
    T.balance >= T.highbalcutoffval
ORDER BY
    balance DESC
    
    ";
    $highbalqryrun=$this->db->query($highbalanceqry);
   $totalbalance=$highbalqryrun->result_array();
  
return $totalbalance;

  }
  function getcurrentoccupancy($today,$propid,$dbname,$cmpid){

                $Coccupency="SELECT DISTINCT
                ".$dbname.".res_header.resno,
                ".$dbname.".check_room_trans.checkinroomtrnid,
                ".$dbname.".check_room_trans.checkid,
                ".$dbname.".room_master.roomid,
                ".$dbname.".room_master.roomno,checkin_master.grc,
                ".$dbname.".check_room_trans.noofpax,
                ".$dbname.".check_room_trans.extrapax,
                ".$dbname.".check_room_trans.chkincmplmtst,
                ".$dbname.".checkin_master.grpchkinst,
                case when ".$dbname.".check_room_trans.chkincmplmtst=1 then 'Yes' else '' end as complimentary,
                case when ".$dbname.".checkin_master.arrivalmode=3 then ".$dbname.".website_master.websitename else ".$dbname.".arrival_mode.arrivalmode end as arrivalmode,
                ".$dbname.".room_rent_plan_master.planname,
                ".$dbname.".check_room_trans.roomrateplanid,
                ".$dbname.".check_room_trans.roomguestname,
                ".$dbname.".check_room_trans.checkindate,
                ".$dbname.".check_room_trans.likelycheckoutdate, ".$dbname.".checkin_master.guestcmpname
                FROM
                ".$dbname.".room_master
                INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.checkinroomtrnid = ".$dbname.".room_master.checkinroomtrnid
                INNER JOIN ".$dbname.".room_rent_plan_master ON ".$dbname.".room_rent_plan_master.planid = ".$dbname.".check_room_trans.roomrateplanid
                INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".check_room_trans.checkid = ".$dbname.".checkin_master.checkinid
                INNER JOIN ".$dbname.".arrival_mode ON ".$dbname.".checkin_master.arrivalmode = ".$dbname.".arrival_mode.arrivalid
                LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid AND ".$dbname.".check_room_trans.cmpid = ".$dbname.".website_master.cmpid AND ".$dbname.".check_room_trans.propid = ".$dbname.".website_master.propid
                LEFT JOIN ".$dbname.".res_room_trans ON ".$dbname.".res_room_trans.checkinid = ".$dbname.".checkin_master.checkinid and ".$dbname.".res_room_trans.resroomtypeid = ".$dbname.".check_room_trans.roomtypeid
                LEFT JOIN ".$dbname.".res_header ON ".$dbname.".res_room_trans.resid = ".$dbname.".res_header.resid
                where ".$dbname.".room_master.cmpid ='".$cmpid."' and ".$dbname.".room_master.propid = '".$propid."' and roomstatus = 2 and DATE(".$dbname.".check_room_trans.checkindate)<='".$today."'
                ORDER BY ".$dbname.".check_room_trans.checkid DESC,".$dbname.".check_room_trans.checkinroomtrnid";
                $Coccupencyqryrun=$this->db->query($Coccupency);
                $currentoccupancy=$Coccupencyqryrun->result_array();
                return $currentoccupancy;
 }
  function getguestinformation($trn,$propid,$dbname,$cmpid){

    $d1=$this->db->query("select checkroomstatus from ".$dbname.".check_room_trans where checkinroomtrnid='$trn'");
	foreach($d1->result() as $v)
	{
		$status=$v->checkroomstatus;
	}
    //var_dump($status);
	if($status==1)
	{
		$titl="Check-Out Info";
		/*query to find today checkedin & checkout guest information*/
		$d2="SELECT
		".$dbname.".check_room_trans.checkinroomtrnid,
		".$dbname.".check_room_trans.discounttype,
		coalesce(".$dbname.".checkin_master.guestid,0) guestid,coalesce(".$dbname.".guest_master.creditallowst,0) creditallowst,coalesce(".$dbname.".guest_master.ledgerid,0) ledgerid,
		".$dbname.".check_room_trans.checkid,".$dbname.".room_master.roomno, ".$dbname.".check_room_trans.roomguestname, CASE WHEN ".$dbname.".checkin_master.arrivalmode = 3 THEN ".$dbname.".website_master.websitename when ".$dbname.".checkin_master.arrivalmode = 2 THEN g1.guestcmpname  ELSE ".$dbname.".arrival_mode.arrivalmode END AS arrivalmode,
		case when ".$dbname.".checkin_master.iscompanyguest=1 then g2.guestcmpname else '' end as cmp_name,".$dbname.".room_rent_plan_master.planname,
		t.roomtypename,".$dbname.".check_room_trans.roomguestname,date_format(".$dbname.".check_room_trans.checkindate,'%d-%m-%Y %h:%i %p') in_date,
		date_format(".$dbname.".check_room_trans.likelycheckoutdate,'%d-%m-%Y %h:%i %p') like_out_date,
		date_format(".$dbname.".check_room_trans.checkoutdate,'%d-%m-%Y %h:%i %p') out_date,
		DATEDIFF(date(".$dbname.".check_room_trans.checkoutdate),date(".$dbname.".check_room_trans.checkindate)) as diff,
		".$dbname.".check_room_trans.checkroomstatus,
		".$dbname.".checkin_master.bookingref as chnlbkgid,
		".$dbname.".check_room_trans.dayscount,
		case when ".$dbname.".check_room_trans.extrapax>0 then concat('Pax : ',".$dbname.".check_room_trans.noofpax,' / Ext.pax : ',".$dbname.".check_room_trans.extrapax) else concat('Pax : ',".$dbname.".check_room_trans.noofpax) end as pax,
		date_format(".$dbname.".res_header.resdatetime,'%d-%m-%Y %h:%i %p') as bkdate,
		CASE WHEN ".$dbname.".check_room_trans.noofpax < 2 THEN det.singlerent ELSE det.doublerent END AS plnrate1, CASE WHEN ".$dbname.".check_room_trans.extrapax > 0 THEN det.extrabed  ELSE 0 END AS plnrate2,
		case when ".$dbname.".check_room_trans.discounttype=1 then ".$dbname.".check_room_trans.discountrate when ".$dbname.".check_room_trans.discounttype=2 then concat(".$dbname.".check_room_trans.discountrate,'%') else 0 end as disct,
		case when ".$dbname.".check_room_trans.rentincltax>0 && ".$dbname.".check_room_trans.rentincltaxst=1 then concat(".$dbname.".check_room_trans.rentincltax,' (Incl. of Tax)') when ".$dbname.".check_room_trans.rentincltax>0 && ".$dbname.".check_room_trans.rentincltaxst=0 then concat(".$dbname.".check_room_trans.rentincltax,' + Tax') else 0 end as netrate,
		".$dbname.".check_room_trans.rentincltaxst,
		".$dbname.".check_room_trans.chkincmplmtst,
		".$dbname.".check_room_trans.applyincltax,
		".$dbname.".check_room_trans.gracetime tim,
		".$dbname.".check_room_trans.discounttype,
		".$dbname.".check_room_trans.rmdiscntmaxprcnt,
		c.username as checkin_user,
		r.username as booked_by,
		".$dbname.".res_header.resno,
		".$dbname.".res_header.resid FROM ".$dbname.".room_master
		INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.roomid = ".$dbname.".room_master.roomid
		INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".check_room_trans.checkid = ".$dbname.".checkin_master.checkinid
		LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid 
		AND ".$dbname.".check_room_trans.cmpid = ".$dbname.".website_master.cmpid AND ".$dbname.".check_room_trans.propid = ".$dbname.".website_master.propid
		INNER JOIN ".$dbname.".roomtype_master t on  t.roomtypeid = ".$dbname.".check_room_trans.roomtypeid
		INNER JOIN ".$dbname.".arrival_mode ON ".$dbname.".checkin_master.arrivalmode = ".$dbname.".arrival_mode.arrivalid
		INNER JOIN ".$dbname.".room_rent_plan_master ON ".$dbname.".room_rent_plan_master.planid = ".$dbname.".check_room_trans.roomrateplanid
		LEFT JOIN ".$dbname.".res_room_trans ON ".$dbname.".res_room_trans.checkinid = ".$dbname.".checkin_master.checkinid and ".$dbname.".res_room_trans.resroomtypeid = ".$dbname.".check_room_trans.roomtypeid 
		LEFT JOIN ".$dbname.".res_header ON ".$dbname.".res_room_trans.resid = ".$dbname.".res_header.resid 
		and ".$dbname.".res_header.resid = ".$dbname.".check_room_trans.reserveid
		INNER JOIN ".$dbname.".user_master c on c.userid=".$dbname.".check_room_trans.checkinuserid 
		 left JOIN ".$dbname.".user_master r on r.userid = ".$dbname.".res_header.userid
		 left JOIN ".$dbname.".guest_cmp_master g1 on g1.guestcmpid = ".$dbname.".checkin_master.agentid
		left JOIN ".$dbname.".guest_cmp_master g2 on g2.guestcmpid = ".$dbname.".checkin_master.guestcmpid
		INNER JOIN ".$dbname.".room_rent_plan_details det on det.planid=".$dbname.".check_room_trans.roomrateplanid 
		and det.roomtypeid =".$dbname.".check_room_trans.roomtypeid and det.arriavalmode = ".$dbname.".checkin_master.arrivalmode 
		AND det.plandtlsid = ".$dbname.".check_room_trans.roomrateplanidtrnid
		inner join ".$dbname.".guest_master on ".$dbname.".guest_master.guestid=".$dbname.".checkin_master.guestid
		where ".$dbname.".check_room_trans.cmpid = '".$cmpid."' and ".$dbname.".check_room_trans.propid = '".$propid."'  and ".$dbname.".check_room_trans.checkinroomtrnid='$trn' GROUP BY checkinroomtrnid";
	}
	else
	{
		$titl="Check-In Info";
		/*query to find today checkin guest information*/
		$d2="SELECT DISTINCT
		".$dbname.".check_room_trans.checkinroomtrnid,
		coalesce(".$dbname.".checkin_master.guestid,0) guestid,coalesce(".$dbname.".guest_master.creditallowst,0) creditallowst,coalesce(".$dbname.".guest_master.ledgerid,0) ledgerid,
		check_room_trans.checkid,".$dbname.".room_master.roomno,
		".$dbname.".check_room_trans.discounttype,".$dbname.".check_room_trans.roomguestname,CASE WHEN ".$dbname.".checkin_master.arrivalmode = 3 THEN ".$dbname.".website_master.websitename when ".$dbname.".checkin_master.arrivalmode = 2 THEN g1.guestcmpname  ELSE ".$dbname.".arrival_mode.arrivalmode END AS arrivalmode,case when ".$dbname.".checkin_master.iscompanyguest=1 then g2.guestcmpname else '' end as cmp_name,".$dbname.".room_rent_plan_master.planname,t.roomtypename,".$dbname.".check_room_trans.roomguestname,date_format(".$dbname.".check_room_trans.checkindate,'%d-%m-%Y %h:%i %p') in_date,date_format(".$dbname.".check_room_trans.likelycheckoutdate,'%d-%m-%Y %h:%i %p') like_out_date,date_format(".$dbname.".check_room_trans.checkoutdate,'%d-%m-%Y %h:%i %p') out_date,DATEDIFF(date(".$dbname.".check_room_trans.likelycheckoutdate),date(".$dbname.".check_room_trans.checkindate)) as diff,".$dbname.".check_room_trans.checkroomstatus,".$dbname.".checkin_master.bookingref as chnlbkgid,".$dbname.".check_room_trans.dayscount,case when ".$dbname.".check_room_trans.extrapax>0 then concat('Pax : ',".$dbname.".check_room_trans.noofpax,' / Ext.pax : ',".$dbname.".check_room_trans.extrapax) else concat('Pax : ',".$dbname.".check_room_trans.noofpax) end as pax,
		date_format(".$dbname.".res_header.resdatetime,'%d-%m-%Y %h:%i %p') as bkdate,
		CASE WHEN ".$dbname.".check_room_trans.noofpax < 2 THEN det.singlerent ELSE det.doublerent  END AS plnrate1,CASE WHEN ".$dbname.".check_room_trans.extrapax > 0 THEN det.extrabed ELSE 0 END AS plnrate2,
		case when ".$dbname.".check_room_trans.discounttype=1 then ".$dbname.".check_room_trans.discountrate when ".$dbname.".check_room_trans.discounttype=2 then concat(".$dbname.".check_room_trans.discountrate,'%') else 0 end as disct,
		case when ".$dbname.".check_room_trans.rentincltax>0 && ".$dbname.".check_room_trans.rentincltaxst=1 then concat(".$dbname.".check_room_trans.rentincltax,' (Incl. of Tax)') when ".$dbname.".check_room_trans.rentincltax>0 && ".$dbname.".check_room_trans.rentincltaxst=0 then concat(".$dbname.".check_room_trans.rentincltax,' + Tax') else 0 end as netrate,
		".$dbname.".check_room_trans.rentincltaxst,
		".$dbname.".check_room_trans.chkincmplmtst,
		".$dbname.".check_room_trans.applyincltax,
		".$dbname.".check_room_trans.gracetime  tim,
		".$dbname.".check_room_trans.discounttype,
		".$dbname.".check_room_trans.rmdiscntmaxprcnt,
		c.username as checkin_user,
		r.username as booked_by,
		".$dbname.".res_header.resno,
		".$dbname.".res_header.resid
		FROM
		".$dbname.".room_master
		INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.checkinroomtrnid = ".$dbname.".room_master.checkinroomtrnid
		INNER JOIN ".$dbname.".room_rent_plan_master ON ".$dbname.".room_rent_plan_master.planid = ".$dbname.".check_room_trans.roomrateplanid 
		INNER JOIN ".$dbname.".roomtype_master t on  t.roomtypeid = ".$dbname.".check_room_trans.roomtypeid
		INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".check_room_trans.checkid = ".$dbname.".checkin_master.checkinid
		INNER JOIN ".$dbname.".arrival_mode ON ".$dbname.".checkin_master.arrivalmode = ".$dbname.".arrival_mode.arrivalid
		LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid AND ".$dbname.".check_room_trans.cmpid = website_master.cmpid AND check_room_trans.propid = website_master.propid
		LEFT JOIN ".$dbname.".res_room_trans ON res_room_trans.checkinid = ".$dbname.".checkin_master.checkinid and res_room_trans.resroomtypeid = check_room_trans.roomtypeid 
		left JOIN ".$dbname.".guest_cmp_master g1 on g1.guestcmpid = ".$dbname.".checkin_master.agentid
		left JOIN ".$dbname.".guest_cmp_master g2 on g2.guestcmpid = ".$dbname.".checkin_master.guestcmpid
		LEFT JOIN ".$dbname.".res_header ON ".$dbname.".res_room_trans.resid = ".$dbname.".res_header.resid and ".$dbname.".res_header.resid = ".$dbname.".check_room_trans.reserveid
		INNER JOIN ".$dbname.".user_master c on c.userid=".$dbname.".check_room_trans.checkinuserid 
		 left JOIN ".$dbname.".user_master r on r.userid = ".$dbname.".res_header.userid
		INNER JOIN ".$dbname.".room_rent_plan_details det on det.planid=".$dbname.".check_room_trans.roomrateplanid and det.roomtypeid =".$dbname.".check_room_trans.roomtypeid and det.arriavalmode = ".$dbname.".checkin_master.arrivalmode AND det.plandtlsid = ".$dbname.".check_room_trans.roomrateplanidtrnid
		inner join ".$dbname.".guest_master on ".$dbname.".guest_master.guestid=".$dbname.".checkin_master.guestid
		where ".$dbname.".room_master.cmpid ='".$cmpid."' and ".$dbname.".room_master.propid = '".$propid."' and ".$dbname.".check_room_trans.checkinroomtrnid='$trn' GROUP BY checkinroomtrnid";
	}
	//echo $this->db->last_query();
	$d2run=$this->db->query($d2);
    $data['chkio']=$d2run->result_array();
    $d3="SELECT
	".$dbname.".charges_master.chargename,
	Sum(".$dbname.".checkin_room_charges.chargeamount) AS charges,
	".$dbname.".charges_master.displayorder,
	".$dbname.".charge_def_master.definetype,
	".$dbname.".charge_def_master.definetypedisplay,
	".$dbname.".charges_master.chargetype,
    case when ".$dbname.".charge_def_master.definetype ='TAX' then 1 when definetypedisplay = 'B - RECEIPT' then 2 when definetype = 'BILL TRANSFER' and Sum(".$dbname.".checkin_room_charges.chargeamount) < 0 then 2 else 0 end taxst
	FROM
	".$dbname.".checkin_room_charges
	INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = ".$dbname.".checkin_room_charges.chargeid
	INNER JOIN ".$dbname.".charge_def_master ON ".$dbname.".charge_def_master.defid = ".$dbname.".charges_master.defineid
	WHERE
	".$dbname.".checkin_room_charges.checkinroomtrnid ='".$trn."' 
	GROUP BY ".$dbname.".charges_master.chargeid
	ORDER BY taxst,displayorder,chargename";
    $d3run=$this->db->query($d3);
    $data['rent']=$d3run->result_array();
	$gg=$this->db->query("select GROUP_CONCAT(' ',billno) as billno from ".$dbname.".bill_header where billcheckinroomtrnid=".$trn." and cmpid=".$cmpid." and propid=".$propid)->row_array();

    $d4="select ".$dbname.".check_room_trans.checkinroomtrnid,".$dbname.".guest_master.guest_gst_no,".$dbname.".guest_cmp_master.cmp_gstno from ".$dbname.".check_room_trans 
	INNER JOIN ".$dbname.".checkin_room_charges on ".$dbname.".check_room_trans.checkinroomtrnid=".$dbname.".checkin_room_charges.checkinroomtrnid
	inner JOIN ".$dbname.".res_header on ".$dbname.".res_header.resid=".$dbname.".check_room_trans.reserveid
	inner JOIN ".$dbname.".guest_master on ".$dbname.".guest_master.guestid = ".$dbname.".res_header.guestid
	INNER JOIN ".$dbname.".checkin_master on ".$dbname.".checkin_master.checkinid=".$dbname.".check_room_trans.checkid
	left JOIN ".$dbname.".guest_cmp_master on ".$dbname.".guest_cmp_master.guestcmpid=".$dbname.".checkin_master.guestcmpid
	INNER JOIN ".$dbname.".charges_master on ".$dbname.".charges_master.chargeid=".$dbname.".checkin_room_charges.chargeid
	where ".$dbname.".check_room_trans.checkinroomtrnid='".$trn."' GROUP BY ".$dbname.".check_room_trans.checkinroomtrnid";
    $d4run=$this->db->query($d4);
    $data['rent2']=$d4run->result_array();

    
    $cc="select ".$dbname.".bill_header.billhdrid, 
	coalesce(Sum(case when ".$dbname.".charges_master.chargeid=7 and case when coalesce(".$dbname.".res_header.advancevchrid,0)=0 then charges.settleid else ".$dbname.".voucher_dtls.settlemode end in (1,6) then charges.chargeamount else NULL end),0)* (-1) AS 'AdvanceCash', 
	coalesce(Sum(case when ".$dbname.".charges_master.chargeid=7 and case when coalesce(".$dbname.".res_header.advancevchrid,0)=0 then charges.settleid else ".$dbname.".voucher_dtls.settlemode end = 2 then charges.chargeamount else NULL end),0) * (-1) AS 'AdvanceCard', 
	coalesce(Sum(case when ".$dbname.".charges_master.chargeid=7 and case when coalesce(".$dbname.".res_header.advancevchrid,0)=0 then charges.settleid else ".$dbname.".voucher_dtls.settlemode end in (3,5) then charges.chargeamount else NULL end),0) * (-1) AS 'AdvanceBank',
	
	coalesce(Sum(case when ".$dbname.".charges_master.chargeid=11 and charges.settleid = 1 then charges.chargeamount else NULL end),0) * (-1) AS 'SettleCash',
	coalesce(Sum(case when ".$dbname.".charges_master.chargeid=11 and charges.settleid = 2 then charges.chargeamount else NULL end),0) * (-1) AS 'SettleCard',
	coalesce(Sum(case when ".$dbname.".charges_master.chargeid=11 and charges.settleid = 3 then charges.chargeamount else NULL end),0) * (-1) AS 'SettleBank',
	coalesce(Sum(case when (".$dbname.".charges_master.chargeid=16 and charges.settleid = 4) then charges.chargeamount else NULL end),0)* (-1) as 'credit',
	 
	coalesce(Sum(case when (".$dbname.".charges_master.chargeid=16 and charges.settleid = 4) then charges.chargeamount * (-1) when (charges.billcheckinroomtrnid!=0 and ".$dbname.".charges_master.chargeid=18) then charges.chargeamount * (-1) else NULL end),0) + Sum(case when (charges.rmtrfrchkrmchrgid!=0 and ".$dbname.".charges_master.chargeid=18) then charges.chargeamount * (-1) else 0 end) AS 'SettleCredit'
	
	from 
	".$dbname.".checkin_room_charges as charges
	left JOIN ".$dbname.".bill_header on ".$dbname.".bill_header.billhdrid = ".$dbname.".charges.billid
	left JOIN ".$dbname.".bill_settle on ".$dbname.".bill_settle.billhdrid = ".$dbname.".charges.billid and bill_settle.settleid=1 
	INNER JOIN ".$dbname.".charges_master ON ".$dbname.".charges_master.chargeid = charges.chargeid
	INNER JOIN ".$dbname.".check_room_trans on ".$dbname.".check_room_trans.checkinroomtrnid = charges.checkinroomtrnid
	INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".checkin_master.checkinid = ".$dbname.".check_room_trans.checkid 
	INNER JOIN ".$dbname.".room_master ON ".$dbname.".room_master.roomid = ".$dbname.".check_room_trans.roomid
	LEFT JOIN ".$dbname.".res_header ON ".$dbname.".check_room_trans.reserveid = ".$dbname.".res_header.resid
	LEFT JOIN ".$dbname.".voucher_dtls ON ".$dbname.".res_header.advancevchrid = ".$dbname.".voucher_dtls.vchrid
	where ".$dbname.".check_room_trans.checkinroomtrnid = ".$trn." and ".$dbname.".check_room_trans.checkroomstatus = 1 and ".$dbname.".charges_master.cmpid = ".$cmpid." and ".$dbname.".charges_master.propid = ".$propid." and referenceno not like 'pos%'   
	and (EXISTS(select settleid from ".$dbname.".bill_settle gl where gl.settleid in (1,2,3,4,5) and gl.billhdrid=charges.billid) or 
	NOT EXISTS(select settleid from ".$dbname.".bill_settle nb where nb.billhdrid=".$dbname.".bill_header.billhdrid and ".$dbname.".bill_header.fullpmtst=1) OR ".$dbname.".bill_header.billtrfrdst=1) 
	GROUP BY charges.billid, charges.checkinroomtrnid";
    $ccrun=$this->db->query($cc);
    $data['advance']=$ccrun->result_array();

    if($status==1)
	{
		$dbd=$this->db->query("select ".$dbname.".bill_header.billcheckinroomtrnid as frmtrnid, room.roomno as frmroomno, charges.billcheckinroomtrnid as totrnid, ".$dbname.".room_master.roomno as toroomno, trans.checkroomstatus as frmsts, ".$dbname.".check_room_trans.checkroomstatus as tormsts, ".$dbname.".bill_header.billno, case when ".$dbname.".check_room_trans.checkroomstatus=0 then CONCAT('Bill Amount Transfered to the Room No : ',".$dbname.".room_master.roomno,' - ',coalesce(concat(".$dbname.".checkin_master.guesttitle,'.',' ', ".$dbname.".checkin_master.guestfirstname,' ',".$dbname.".checkin_master.guestlastname),'')) else CONCAT('".$dbname.".Bill Amount Transfered to the Bill No : ',bhead.billno,' - ',coalesce(concat(".$dbname.".checkin_master.guesttitle,'.',' ', ".$dbname.".checkin_master.guestfirstname,' ',".$dbname.".checkin_master.guestlastname),'')) end as `status`, ".$dbname.".bill_header.billtrfrdst 
		from ".$dbname.".bill_header 
		INNER JOIN ".$dbname.".checkin_room_charges as charges on charges.checkinroomtrnid = ".$dbname.".bill_header.billcheckinroomtrnid
		INNER JOIN ".$dbname.".check_room_trans on ".$dbname.".check_room_trans.checkinroomtrnid = charges.billcheckinroomtrnid
		INNER JOIN ".$dbname.".checkin_master on ".$dbname.".checkin_master.checkinid = ".$dbname.".check_room_trans.checkid
		LEFT JOIN ".$dbname.".bill_header as bhead on bhead.billcheckinroomtrnid = ".$dbname.".check_room_trans.checkinroomtrnid
		INNER JOIN ".$dbname.".check_room_trans as trans on trans.checkinroomtrnid = charges.checkinroomtrnid
		inner JOIN ".$dbname.".room_master on ".$dbname.".room_master.roomid = ".$dbname.".check_room_trans.roomid
		inner JOIN ".$dbname.".room_master as room on room.roomid = trans.roomid
		where ".$dbname.".bill_header.billcheckinroomtrnid = ".$trn." and bill_header.cmpid = ".$cmpid." 
		and ".$dbname.".bill_header.propid = ".$propid." and ".$dbname.".bill_header.billtrfrdst = 1 GROUP BY ".$dbname.".bill_header.billhdrid");

        
        $data['checkoutbill']=$dbd->result_array();
    }

    return $data;


  }
  function getcheckin($today,$propid,$dbname,$cmpid){

    $query=$this->db->query("select * from
    ((
        SELECT DISTINCT
            ".$dbname.".check_room_trans.checkinroomtrnid,
            ".$dbname.".check_room_trans.checkid,
            ".$dbname.".room_master.roomno,
            CASE
        WHEN ".$dbname.".checkin_master.arrivalmode = 3 THEN
        ".$dbname.".website_master.websitename
        ELSE
        ".$dbname.".arrival_mode.arrivalmode
        END AS arrivalmode,
        ".$dbname.".room_rent_plan_master.planname,
        ".$dbname.".check_room_trans.roomrateplanid,
        ".$dbname.".check_room_trans.roomguestname,
        ".$dbname.".check_room_trans.checkindate,
        ".$dbname.".check_room_trans.chkincmplmtst,
        ".$dbname.".check_room_trans.likelycheckoutdate,
        ".$dbname.".check_room_trans.checkroomstatus
    FROM
    ".$dbname.".room_master
    INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.checkinroomtrnid = ".$dbname.".room_master.checkinroomtrnid
    INNER JOIN ".$dbname.".room_rent_plan_master ON ".$dbname.".room_rent_plan_master.planid = ".$dbname.".check_room_trans.roomrateplanid
    INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".check_room_trans.checkid = ".$dbname.".checkin_master.checkinid
    INNER JOIN ".$dbname.".arrival_mode ON ".$dbname.".checkin_master.arrivalmode = ".$dbname.".arrival_mode.arrivalid
    LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid
    AND ".$dbname.".check_room_trans.cmpid = ".$dbname.".website_master.cmpid
    AND ".$dbname.".check_room_trans.propid = ".$dbname.".website_master.propid
    LEFT JOIN ".$dbname.".res_room_trans ON ".$dbname.".res_room_trans.checkinid = ".$dbname.".checkin_master.checkinid
    AND ".$dbname.".res_room_trans.resroomtypeid = ".$dbname.".check_room_trans.roomtypeid
    LEFT JOIN ".$dbname.".res_header ON ".$dbname.".res_room_trans.resid = ".$dbname.".res_header.resid
    where ".$dbname.".room_master.cmpid ='".$cmpid."' and ".$dbname.".room_master.propid = '".$propid."' and roomstatus = 2 
    and chkincancelst=0 and checkroomstatus = 0 and DATE(".$dbname.".check_room_trans.checkindate)='".$today."'
    )
    UNION
        (
            SELECT
            ".$dbname.".check_room_trans.checkinroomtrnid,
            ".$dbname.".check_room_trans.checkid,
            ".$dbname.".room_master.roomno,
                CASE
            WHEN ".$dbname.".checkin_master.arrivalmode = 3 THEN
            ".$dbname.".website_master.websitename
            ELSE
            ".$dbname.".arrival_mode.arrivalmode
            END AS arrivalmode,
            ".$dbname.".room_rent_plan_master.planname,
            ".$dbname.".check_room_trans.roomrateplanid,
            ".$dbname.".check_room_trans.roomguestname,
            ".$dbname.".check_room_trans.checkindate,
            ".$dbname.".check_room_trans.chkincmplmtst,
            ".$dbname.".check_room_trans.likelycheckoutdate,
            ".$dbname.".check_room_trans.checkroomstatus
        FROM
        ".$dbname.".room_master
        INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.roomid = ".$dbname.".room_master.roomid
        INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".check_room_trans.checkid = ".$dbname.".checkin_master.checkinid
        LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid
        AND ".$dbname.".check_room_trans.cmpid = ".$dbname.".website_master.cmpid
        AND ".$dbname.".check_room_trans.propid = ".$dbname.".website_master.propid
        INNER JOIN ".$dbname.".arrival_mode ON ".$dbname.".checkin_master.arrivalmode = ".$dbname.".arrival_mode.arrivalid
        INNER JOIN ".$dbname.".room_rent_plan_master ON ".$dbname.".room_rent_plan_master.planid = ".$dbname.".check_room_trans.roomrateplanid
        where ".$dbname.".check_room_trans.cmpid = '".$cmpid."' and checkroomstatus = 0 and ".$dbname.".check_room_trans.propid = '".$propid."' and chkincancelst=0 and DATE(".$dbname.".check_room_trans.checkindate)= '".$today."'
        )) tt
    ORDER BY tt.checkid DESC,tt.checkinroomtrnid");
    
   return $query->result_array();    



  }
  function getcheckout($today,$propid,$dbname,$cmpid){
  


	$db=$this->db->query("select * from ( SELECT
	".$dbname.".check_room_trans.checkinroomtrnid,
	".$dbname.".check_room_trans.checkid,
	".$dbname.".room_master.roomno,
	case when ".$dbname.".checkin_master.arrivalmode=3 then ".$dbname.".website_master.websitename else ".$dbname.".arrival_mode.arrivalmode end as arrivalmode,
	".$dbname.".room_rent_plan_master.planname,
	".$dbname.".check_room_trans.roomrateplanid,
	".$dbname.".check_room_trans.roomguestname,
	".$dbname.".check_room_trans.checkindate,
	".$dbname.".check_room_trans.chkincmplmtst,
	".$dbname.".check_room_trans.likelycheckoutdate,
	".$dbname.".check_room_trans.checkroomstatus,
	".$dbname.".check_room_trans.checkoutdate
	FROM
	".$dbname.".room_master
	INNER JOIN ".$dbname.".check_room_trans ON ".$dbname.".check_room_trans.roomid = ".$dbname.".room_master.roomid
	INNER JOIN ".$dbname.".checkin_master ON ".$dbname.".check_room_trans.checkid = ".$dbname.".checkin_master.checkinid
	LEFT JOIN ".$dbname.".website_master ON ".$dbname.".checkin_master.webid = ".$dbname.".website_master.webid AND ".$dbname.".check_room_trans.cmpid = ".$dbname.".website_master.cmpid 
	AND ".$dbname.".check_room_trans.propid = ".$dbname.".website_master.propid
	INNER JOIN ".$dbname.".arrival_mode ON ".$dbname.".checkin_master.arrivalmode = ".$dbname.".arrival_mode.arrivalid
	INNER JOIN ".$dbname.".room_rent_plan_master ON ".$dbname.".room_rent_plan_master.planid = ".$dbname.".check_room_trans.roomrateplanid
	where ".$dbname.".check_room_trans.cmpid = ".$cmpid." and ".$dbname.".check_room_trans.propid = ".$propid." and checkroomstatus = 1 and chkincancelst=0 
	and DATE(".$dbname.".check_room_trans.checkoutdate)= '{$today}' ORDER BY ".$dbname.".check_room_trans.checkid DESC) tt
	ORDER BY tt.checkoutdate DESC");
return 	$db->result_array();


  }
}
