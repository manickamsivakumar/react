<?php
class Mis_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->connectdatabase();
    }

    public function get_all_prop_db_details($cmpid, $propids)
    {



        $sql = 'SELECT
                property_master.propid,
                property_master.cmpid,
                property_master.propname,
                property_master.propcity,
                property_master.propadd1,
                property_master.databasename,
                cloud_dbserver_master.clouddbservername,
                cloud_dbserver_master.dbserverip,
                cloud_dbserver_master.dbserveruserid,
                cloud_dbserver_master.dbserverpwd
            FROM
                property_master
            INNER JOIN cloud_dbserver_master ON property_master.clouddbserverid = cloud_dbserver_master.clouddbid
            WHERE
                property_master.cmpid = ' . $cmpid . '
            AND property_master.propid IN(' . $propids . ')';



        $query = $this->db->query($sql);
        $data = $query->result_array();
        //echo $this->db->last_query();



        /*$mydata=array();
        if(!empty($data))
        {
           foreach($data as $value)
           {
              if(array_key_exists($value['propid'],$mydata))
              {

                    $mydata[] = $value;

              }
              else
              {

                    $mydata[] = $value;

              }


           }

        }
      
        echo '<pre>';
        print_r($mydata);
        echo '</pre>';*/

        //$db_manual_connect=$this->connect_database_manualy($data[0]);

        return $data;
    }

    public function connectdatabase()
    {
        $data['logindetails'] = $this->session->userdata('logindetails');
        $dbserverip = $dbserveruserid = $dbserverpwd = $databasename = "";
        $dbserverip = $data['logindetails']['dbserverip'];
        $dbserveruserid = $data['logindetails']['dbserveruserid'];
        $dbserverpwd = $data['logindetails']['dbserverpwd'];
        $databasename = $data['logindetails']['databasename'];

        if ($dbserverip != "" && $dbserveruserid != "" && $dbserverpwd != "" && $databasename != "") {
            $dbchange = $this->loaddatabase($dbserveruserid, $dbserverpwd, $dbserverip, $databasename);
            $this->db = $this->load->database($dbchange, true);
        }
        /*$name = $this->house->getdbname();
        echo "<pre>";
        print_r($name);
        echo "</pre>";*/
    }
    public function loaddatabase($userid = "", $password = "", $hostname = "", $dbname = "")
    {
        if (($userid != "") && ($password != "") && ($hostname != "") && ($dbname != "")) {
            $dsn = 'mysqli://' . $userid . ':' . $password . '@' . $hostname . '/' . $dbname;
            //$this->load->database($dsn,true);            
            //return $dsn;
            return $dsn;
        } else {
            //$this->load->database();
            return 'raspmaster';
        }
    }







    //database password decrypt method end




    public function get_all_module_values($fromdate, $todate)
    {

        // $data = [];
        $main_page_all_datas = array();
        $main_page_all_data = array();
        $module_list = array();


        $data = $this->session->userdata('propdetails');

        //echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        $moduledata = $this->session->userdata('module_list');








        $allmoduledata = json_decode(json_encode($moduledata), true);
        /* foreach($result as $values)
        {

            if(!array_key_exists($values['propid'],$module_list))
            {
                $module_list[$values['propid']]=array();
            }
                  array_push($module_list[$values['propid']],$values['modid']);

        }*/

        //echo '<pre>';
        // print_r($data);
        //echo '</pre>';      

        foreach ($data as $key => $value) {


            $dbname = $value['databasename'];
            $propname = $value['propname'];
            $propcity = $value['propcity'];
            $propcolor = $value['propcolor'];

            $cmpid = $value['cmpid'];
                $propid = $key;

            //get_prop_details
            $main_page_all_data[$key]['propname'] = $propname;
            $main_page_all_data[$key]['propcity'] = $propcity;
            $main_page_all_data[$key]['propcolor'] = $propcolor;

            //get pos_amount
            //$sql = 'select sum(amount) as amount from '. $dbname .'.tbl_pos_billcharges WHERE DATE(added_date) BETWEEN "' . $fromdate . '" AND "' . $todate . '"';
            $sql = 'SELECT
            sum(amount)AS totelamount,
            DATE_FORMAT(added_date, "%Y-%m-%d")AS addeddate
            FROM
            ' . $dbname . '.tbl_pos_billcharges
            WHERE 
            DATE(added_date)BETWEEN "'. $fromdate.'"
            AND "' . $todate . '"
            GROUP BY
            addeddate';
            
            $query = $this->db->query($sql);
            $data1 = $query->result_array();
            $bookingpos=array();
            foreach($data1 as $value){
            $adddate=$value['addeddate'];
            $bookingpos[$adddate]=$value['totelamount'];
            }
           
            //get bnqt_amount
            //$sql = 'select sum(amount) as amount from ' . $dbname . '.tbl_bnqt_booking_charges WHERE DATE(addeddatetime) BETWEEN "' . $fromdate . '" AND "' . $todate . '"';
            $sql = 'SELECT
                    sum(amount)AS totelamount,
                    DATE_FORMAT(addeddatetime, "%Y-%m-%d")AS addeddate
                    FROM
                    ' . $dbname . '.tbl_bnqt_booking_charges
                    WHERE 
                    DATE(addeddatetime)BETWEEN "' . $fromdate . '"
                    AND "' . $todate . '"
                    GROUP BY
                    addeddate';


            $query = $this->db->query($sql);
            $data2 = $query->result_array();
          $billingpos=array();
          foreach($data2 as $value){
          $adddate=$value['addeddate'];
          $billingpos[$adddate]=$value['totelamount'];
          }
            $frontoffice = $this->frontoffice($fromdate, $todate, $dbname);

            //$alertandauth= $this->alertandauth($fromdate,$todate,$propid,$dbname,$cmpid);
            //$main_page_all_data[$key]['alertcount'] = $alertandauth['alertcount'];
            //$main_page_all_data[$key]['authcount'] = $alertandauth['authcount'];

            $main_page_all_data[$key]['pos_total_bill_amount']=$billingpos;
            $main_page_all_data[$key]['bnqt_total_booking_charges_amount']=$bookingpos;
            $main_page_all_data[$key]['front_offize_total_amount'] = $frontoffice['sales'];
            $main_page_all_data[$key]['front_offize_total_revenue'] = $frontoffice['revenue'];;
            $main_page_all_data[$key]['front_offize_total_occupied'] = $frontoffice['occupied'];;
            $main_page_all_data[$key]['front_offize_total_totelrooms'] = $frontoffice['totalrooms'];;
        }

        $main_page_all_datas['module_list'] = $allmoduledata;
        $main_page_all_datas['amount_details'] = $main_page_all_data;

        //  echo '<pre>';
        // print_r($main_page_all_datas);
        //  echo '</pre>';



        return $main_page_all_datas;
    }
    public function get_indiv_module_values($fromdate, $todate, $propid)
    {

        // $data = [];
        $main_page_all_datas = array();
        $main_page_all_data = array();
        $module_list = array();


        $data = $this->session->userdata('propdetails')[$propid];
        $key = (int)$propid;

        $moduledata = $this->session->userdata('module_list');








        $allmoduledata = json_decode(json_encode($moduledata), true);
        /* foreach($result as $values)
        {

            if(!array_key_exists($values['propid'],$module_list))
            {
                $module_list[$values['propid']]=array();
            }
                  array_push($module_list[$values['propid']],$values['modid']);

        }*/

        //echo '<pre>';
        // print_r($data);
        //echo '</pre>';      





        $dbname = $data['databasename'];
        $propname = $data['propname'];
        $propcity = $data['propcity'];
        $propcolor = $data['propcolor'];

        //get_prop_details
        $main_page_all_data[$key]['propname'] = $propname;
        $main_page_all_data[$key]['propcity'] = $propcity;
        $main_page_all_data[$key]['propcolor'] = $propcolor;

        //get pos_amount
        $sql = 'SELECT
            sum(amount)AS totelamount,
            DATE_FORMAT(added_date, "%Y-%m-%d")AS addeddate
            FROM
            ' . $dbname . '.tbl_pos_billcharges
            WHERE 
            DATE(added_date)BETWEEN "'. $fromdate.'"
            AND "' . $todate . '"
            GROUP BY
            addeddate';
            
            $query = $this->db->query($sql);
            $data1 = $query->result_array();
            $bookingpos=array();
            foreach($data1 as $value){
            $adddate=$value['addeddate'];
            $bookingpos[$adddate]=$value['totelamount'];
            }
           
            //get bnqt_amount
            //$sql = 'select sum(amount) as amount from ' . $dbname . '.tbl_bnqt_booking_charges WHERE DATE(addeddatetime) BETWEEN "' . $fromdate . '" AND "' . $todate . '"';
            $sql = 'SELECT
                    sum(amount)AS totelamount,
                    DATE_FORMAT(addeddatetime, "%Y-%m-%d")AS addeddate
                    FROM
                    ' . $dbname . '.tbl_bnqt_booking_charges
                    WHERE 
                    DATE(addeddatetime)BETWEEN "' . $fromdate . '"
                    AND "' . $todate . '"
                    GROUP BY
                    addeddate';


            $query = $this->db->query($sql);
            $data2 = $query->result_array();
          $billingpos=array();
          foreach($data2 as $value){
          $adddate=$value['addeddate'];
          $billingpos[$adddate]=$value['totelamount'];
          }
            $frontoffice = $this->frontoffice($fromdate, $todate, $dbname);







            $main_page_all_data[$key]['pos_total_bill_amount']=$billingpos;
            $main_page_all_data[$key]['bnqt_total_booking_charges_amount']=$bookingpos;
           

        $main_page_all_data[$key]['front_offize_total_amount'] = $frontoffice['sales'];
        $main_page_all_data[$key]['front_offize_total_revenue'] = $frontoffice['revenue'];;
        $main_page_all_data[$key]['front_offize_total_occupied'] = $frontoffice['occupied'];;
        $main_page_all_data[$key]['front_offize_total_totelrooms'] = $frontoffice['totalrooms'];;


        $main_page_all_datas['module_list'] = $allmoduledata;
        $main_page_all_datas['amount_details'] = $main_page_all_data;

        //  echo '<pre>';
        // print_r($main_page_all_datas);
        //  echo '</pre>';



        return $main_page_all_datas;
    }

    function frontoffice($fromdate, $todate, $dbname)
    {

        $revenuequery = "SELECT
        " . $dbname . ".checkin_room_charges.chargeid,
        " . $dbname . ".checkin_room_charges.checkinroomtrnid,
        sum(
            " . $dbname . ".checkin_room_charges.chargeamount
        )*- 1 AS revenue,
        " . $dbname . ".charges_master.chargename,
        DATE_FORMAT(
            " . $dbname . ".checkin_room_charges.chargedate,
            '%Y-%m-%d'
        )AS datefn,
        " . $dbname . ".checkin_room_charges.vchrid
    FROM
    " . $dbname . ".checkin_room_charges
    INNER JOIN " . $dbname . ".charges_master ON " . $dbname . ".charges_master.chargeid = " . $dbname . ".checkin_room_charges.chargeid
    WHERE
        date(
            " . $dbname . ".checkin_room_charges.chargedate
        )BETWEEN '" . $fromdate . "'
    AND '" . $todate . "'
    AND " . $dbname . ".checkin_room_charges.chargeid IN(7, 11)
    AND " . $dbname . ".checkin_room_charges.vchrid > 0
    GROUP BY
        datefn";

        $revenueqryrun = $this->db->query($revenuequery);
        $revenuearay = $revenueqryrun->result_array();
        if (!empty($revenuearay)) {
            $revenue = 0;
            //revenue calculation
            foreach ($revenuearay as $value) {

                $revenue += $value['revenue'];
            }
        } else {

            $revenue = 0;
        }


        //get_front_office_details
        $sql_sales = "SELECT
        " . $dbname . ".checkin_room_charges.chargeid,
        " . $dbname . ".checkin_room_charges.checkinroomtrnid,
        sum(
            " . $dbname . ".checkin_room_charges.chargeamount
        )AS sales,
        " . $dbname . ".charges_master.chargename,
        " . $dbname . ".charges_master.chargescostcentre,
        DATE_FORMAT(
            " . $dbname . ".checkin_room_charges.chargedate,
            '%Y-%m-%d'
        )AS datefn
    FROM
    " . $dbname . ".checkin_room_charges
    INNER JOIN " . $dbname . ".charges_master ON " . $dbname . ".charges_master.chargeid = " . $dbname . ".checkin_room_charges.chargeid
    WHERE
    " . $dbname . ".charges_master.chargescostcentre IN ('ROOM','FOOD','OTHERS','BEVERAGES')
    AND date(
        " . $dbname . ".checkin_room_charges.chargedate
    )BETWEEN '" . $fromdate . "'
    AND '" . $todate . "'
    AND " . $dbname . ".checkin_room_charges.chargeid != 8
    GROUP BY
        datefn
    
     
      ";
        $frtoffsales = $this->db->query($sql_sales);
        $sale_array = $frtoffsales->result_array();
        ///query for sale via voucher report
        $sql_vouchersales = "SELECT
       " . $dbname . ".voucher_header.vchrid,
        DATE_FORMAT(" . $dbname . ".voucher_header.vchrdate,'%Y-%m-%d') as datefn,
        sum(" . $dbname . ".voucher_trans.dramount)AS vchrrev,
        " . $dbname . ".voucher_header.vchrpostmode,
        " . $dbname . ".voucher_header.vchrtypeid
    FROM
    " . $dbname . ".voucher_header
    INNER JOIN " . $dbname . ".voucher_trans ON " . $dbname . ".voucher_trans.vchrid = " . $dbname . ".voucher_header.vchrid
    WHERE
    " . $dbname . ".voucher_header.vchrtypeid = 1
    AND " . $dbname . ".voucher_header.vchrpostmode = 0
    AND date(" . $dbname . ".voucher_header.vchrdate)BETWEEN '" . $fromdate . "'
    AND '" . $todate . "' order by datefn
    ";
        $frtoffvoursales = $this->db->query($sql_vouchersales);
        $vouchersale_array = $frtoffvoursales->result_array();

        // query for advance sales


        $salesadvne = "
        SELECT
        " . $dbname . ".res_advdtl.advancevchrid,
        DATE_FORMAT(" . $dbname . ".voucher_header.vchrdate,'%Y-%m-%d') as datefn,
        " . $dbname . ".voucher_header.vchrid,
            sum(" . $dbname . ".voucher_trans.dramount)AS advancevachr
        FROM
        " . $dbname . ".res_advdtl
        INNER JOIN " . $dbname . ".voucher_header ON " . $dbname . ".voucher_header.vchrid = " . $dbname . ".res_advdtl.advancevchrid
        INNER JOIN " . $dbname . ".voucher_trans ON " . $dbname . ".voucher_trans.vchrid = " . $dbname . ".voucher_header.vchrid
        WHERE
            date(" . $dbname . ".voucher_header.vchrdate)BETWEEN '" . $fromdate . "'
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
        $salestotel = 0;
        $totel = array();
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
        $occupiedquery = "SELECT
        count(
            " . $dbname . ".checkin_room_charges.chargeid
        )AS roomcnt,
        " . $dbname . ".charges_master.chargename,
        DATE_FORMAT(
            " . $dbname . ".checkin_room_charges.chargedate,
            '%Y-%m-%d'
        )AS datefn
    FROM
    " . $dbname . ".checkin_room_charges
    INNER JOIN " . $dbname . ".charges_master ON " . $dbname . ".charges_master.chargeid = " . $dbname . ".checkin_room_charges.chargeid
    WHERE
    " . $dbname . ".checkin_room_charges.chargeid = 1
    AND " . $dbname . ".checkin_room_charges.checkinroomtrnid > 0
    AND date(
        " . $dbname . ".checkin_room_charges.chargedate
    )BETWEEN '" . $fromdate . "'
    AND '" . $todate . "'
    GROUP BY
        datefn";
        $occupied = $this->db->query($occupiedquery);
        $occupiedarray = $occupied->result_array();

        $occupiedrooms = 0;
        foreach ($occupiedarray as $value) {

            $occupiedrooms += $value['roomcnt'];
        }

        $totelrooms = "select count(roomid)as totel  from " . $dbname . ".room_master";
        $roomscount = $this->db->query($totelrooms);
        $rooms = $roomscount->result_array();

        $frtoffice = array();
        $frtoffice['sales'] = $totel;
        $frtoffice['revenue'] = $revenue;
        $frtoffice['occupied'] = $occupiedrooms;
        $frtoffice['totalrooms'] = $rooms[0]['totel'];


        return $frtoffice;
    }

    function alertandauth($fromdate,$todate,$propid,$dbname,$cmpid) {

        $userid = $this->session->userdata('userid');
    
            //$dbname = "cloud_dev";
    
            $result['alertcount'] = $result['authcount'] = 0;
    
    
          $psql = " AND ".$dbname.".tbl_gen_alert_trans.propid = ".$propid;
          $msql = " AND ".$dbname.".tbl_gen_alert_trans.status in (0)";
    
          $sql = 'SELECT
            '.$dbname.'.tbl_gen_alert_trans.alerttrnid,
            '.$dbname.'.tbl_gen_alert_trans.cmpid,
            '.$dbname.'.tbl_gen_alert_trans.propid,
            '.$dbname.'.tbl_gen_alert_trans.alertid,
            '.$dbname.'.tbl_gen_alert_trans.userid,
            '.$dbname.'.tbl_gen_alert_trans.`status`,
            '.$dbname.'.tbl_gen_alert_header.messagedetails,
            '.$dbname.'.tbl_gen_alert_trans.alertdate,
            '.$dbname.'.tbl_gen_alert_trans.readdate,
            '.$dbname.'.tbl_gen_alert_header.alerthtrnid,
            '.$dbname.'.tbl_gen_alert_master.alertname,
            '.$dbname.'.tbl_gen_alert_master.alertmod,
            '.$dbname.'.tbl_gen_alert_master.authid,
            '.$dbname.'.module_list.modulename
            FROM
                '.$dbname.'.tbl_gen_alert_trans
            INNER JOIN '.$dbname.'.tbl_gen_alert_header ON '.$dbname.'.tbl_gen_alert_header.alertid = '.$dbname.'.tbl_gen_alert_trans.alertid
            INNER JOIN '.$dbname.'.tbl_gen_alert_master ON '.$dbname.'.tbl_gen_alert_master.alertid = '.$dbname.'.tbl_gen_alert_header.alertid
            INNER JOIN '.$dbname.'.module_list ON '.$dbname.'.tbl_gen_alert_master.alertmod = '.$dbname.'.module_list.modid
            WHERE
                '.$dbname.'.tbl_gen_alert_trans.userid = '.$userid.'
            AND DATE('.$dbname.'.tbl_gen_alert_trans.alertdate) BETWEEN "'.$fromdate.'" AND "'.$todate.'"
            AND '.$dbname.'.tbl_gen_alert_trans.cmpid = '.$cmpid.$psql.$msql;
            
            //echo $sql;
    
            $query = $this->db->query($sql);
            $adata = $query->result_array();
    
            $result['alertcount'] = 0;
    
            if($adata) {
                $result['alertcount'] = count($adata);
            }
    
            //$userid = 1;
    
            $sql = 'SELECT
            '.$dbname.'.tbl_gen_auth_req_header.authstatus,
            '.$dbname.'.tbl_gen_auth_req_header.authreasonid,
            '.$dbname.'.tbl_gen_auth_req_header.authremark,
            '.$dbname.'.tbl_gen_auth_req_header.authcheckinroomtrnid,
            '.$dbname.'.tbl_gen_auth_req_header.authdatetime,
            '.$dbname.'.tbl_gen_auth_req_header.authtypeid,
            '.$dbname.'.tbl_gen_auth_req_header.authreqrollno,
            '.$dbname.'.tbl_gen_auth_req_header.authreqtrnid,
            '.$dbname.'.tbl_gen_auth_req_header.authreqoldvalue as messagedetails,
            '.$dbname.'.tbl_gen_auth_req_user_trans.authmode,
            '.$dbname.'.tbl_gen_auth_req_user_trans.authusertrnid,
            '.$dbname.'.tbl_gen_auth_req_user_trans.authuserid,
            '.$dbname.'.tbl_gen_auth_req_user_trans.authstatus as authstatustype,
            '.$dbname.'.tbl_gen_auth_req_user_trans.authreadsts,
            '.$dbname.'.tbl_gen_auth_req_user_trans.authreaddatetime,
            '.$dbname.'.tbl_gen_authorization_master.module,
            '.$dbname.'.tbl_gen_authorization_master.authmode as authmodetype,
            '.$dbname.'.tbl_gen_authorization_master.authname,
            '.$dbname.'.tbl_gen_authorization_master.authtype,
            '.$dbname.'.tbl_gen_authorization_master.cmpid,
            '.$dbname.'.tbl_gen_authorization_master.propid,
            '.$dbname.'.tbl_gen_authorization_master.requiredauthby,
            '.$dbname.'.tbl_gen_authorization_master.verificationby,
            '.$dbname.'.tbl_gen_authorization_users.authvaltrnid,
            '.$dbname.'.tbl_gen_authorization_valuesauth.authstartvalue,
            '.$dbname.'.tbl_gen_authorization_valuesauth.authendvalue,
            '.$dbname.'.user_master.username as requestusername,
            '.$dbname.'.module_list.modulename
            FROM
            '.$dbname.'.tbl_gen_auth_req_user_trans
            INNER JOIN '.$dbname.'.tbl_gen_auth_req_header ON '.$dbname.'.tbl_gen_auth_req_header.authreqtrnid = '.$dbname.'.tbl_gen_auth_req_user_trans.authtrnid
            INNER JOIN '.$dbname.'.user_master ON '.$dbname.'.tbl_gen_auth_req_header.authrequserid = '.$dbname.'.user_master.userid
            LEFT JOIN '.$dbname.'.tbl_gen_authorization_master ON tbl_gen_auth_req_header.authtypeid = '.$dbname.'.tbl_gen_authorization_master.authtrnid
            LEFT JOIN '.$dbname.'.tbl_gen_authorization_users ON '.$dbname.'.tbl_gen_authorization_users.authid = '.$dbname.'.tbl_gen_authorization_master.authtrnid
            LEFT JOIN '.$dbname.'.tbl_gen_authorization_valuesauth ON '.$dbname.'.tbl_gen_authorization_valuesauth.authvaltrnid = '.$dbname.'.tbl_gen_authorization_users.authvaltrnid
            INNER JOIN '.$dbname.'.module_list ON '.$dbname.'.tbl_gen_authorization_master.module = '.$dbname.'.module_list.modid
            WHERE
                '.$dbname.'.tbl_gen_authorization_master.propid = '.$propid.'
            AND '.$dbname.'.tbl_gen_auth_req_header.authstatus = 0
            AND DATE('.$dbname.'.tbl_gen_auth_req_header.authdatetime) BETWEEN "'.$fromdate.'" AND "'.$todate.'"
            AND '.$dbname.'.tbl_gen_auth_req_user_trans.authuserid = '.$userid;
    
            //echo $sql;
    
            $query = $this->db->query($sql);
            $adata = $query->result_array();
    
            $result['authcount'] = 0;
    
            if($adata) {
                $result['authcount'] = count($adata);
            }
    
            return $result;
        }
}
