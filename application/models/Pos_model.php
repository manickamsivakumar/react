<?php

class Pos_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

        //$this->load->database();

        $this->connectdatabase();

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





    public function get_all_pos_sales_datas($fromdate, $todate, $indiv_propid)

    {

        $pos_all_data = array();



        $data = $this->session->userdata('propdetails');

        $userid = $this->session->userdata('userid');

        //  $userid = 9;

        $propname = $data[$indiv_propid]['propname'];

        $databasename = $data[$indiv_propid]['databasename'];

        $propname = $data[$indiv_propid]['propname'];

        $propcity = $data[$indiv_propid]['propcity'];

        $propcolor = $data[$indiv_propid]['propcolor'];

        $cmpid = $data[$indiv_propid]['cmpid'];

        //hardcode 







        //1.fst get arealist based on userid and some restrictions //intha userku intha proprtykikilla ithuna area 



        $sql = 'SELECT DISTINCT

                        ' . $databasename . '.user_master.userid,

                        ' . $databasename . '.user_master.username AS fullname,

                        ' . $databasename . '.user_master.cmpid,

                        ' . $databasename . '.user_property_list_secgrp.propid,

                        ' . $databasename . '.tbl_pos_area.areaid,

                        ' . $databasename . '.tbl_pos_area.areaname,

                        ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid,

                        ' . $databasename . '.tbl_pos_area.defaultservicetypeid,

                        ' . $databasename . '.tbl_pos_area.defaultprinter,

                        ' . $databasename . '.user_property_list_secgrp.usersecuritygrpid,

                        ' . $databasename . '.user_property_list_secgrp.srvid

                        FROM

                            ' . $databasename . '.user_master

                        INNER JOIN ' . $databasename . '.user_property_list_secgrp ON ' . $databasename . '.user_master.userid = ' . $databasename . '.user_property_list_secgrp.userid

                        LEFT JOIN ' . $databasename . '.user_role_master ON ' . $databasename . '.user_master.userroleid = ' . $databasename . '.user_role_master.roleid

                        INNER JOIN ' . $databasename . '.tbl_pos_area ON ' . $databasename . '.user_property_list_secgrp.areaid = ' . $databasename . '.tbl_pos_area.areaid

                        AND ' . $databasename . '.user_property_list_secgrp.propid = ' . $databasename . '.tbl_pos_area.propid

                        LEFT JOIN ' . $databasename . '.tbl_pos_servicetypemaster ON ' . $databasename . '.tbl_pos_area.defaultservicetypeid = ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid

                        LEFT JOIN ' . $databasename . '.tbl_pos_areaservicetype ON ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid = ' . $databasename . '.tbl_pos_areaservicetype.servicetypeid

                        INNER JOIN ' . $databasename . '.user_group_master_cmp ON ' . $databasename . '.user_property_list_secgrp.usersecuritygrpid = ' . $databasename . '.user_group_master_cmp.trnid

                        WHERE

                            ' . $databasename . '.user_master.userid = ' . $userid . '

                        AND ' . $databasename . '.user_group_master_cmp.module = "POS"

                        AND ' . $databasename . '.user_property_list_secgrp.propid=' . $indiv_propid . ' AND ' . $databasename . '.user_property_list_secgrp.cmpid= ' . $cmpid . ' 

                        AND ' . $databasename . '.user_master. STATUS = 1

                        GROUP BY

                            ' . $databasename . '.user_property_list_secgrp.areaid';



        //  echo $sql;



        $query = $this->db->query($sql);

        $arealist = $query->result_array();



        $area_data = array();

        $area_ids = array();

        if (!empty($arealist)) {

            foreach ($arealist as $value) {



                array_push($area_ids, $value['areaid']);







                $area_data[$value['propid']][$value['areaid']] = $value;

            }

        }

        /* echo '<pre>';

        print_r($area_data);

        echo '</pre>';



        echo '<pre>';

        print_r($area_ids);

        echo '</pre>';



       

        echo '<pre>';

        print_r($areaids);

        echo '</pre>';*/

        $areaids = implode(",", $area_ids);





        //2.get servicelist  based on user



        $service_data = array();

        if ($area_data) {



            foreach ($area_data as $values) {



                //echo $value['usersecuritygrpid']; 



                foreach ($values as $value) {





                    $sql = 'SELECT DISTINCT

                            ' . $databasename . '.tbl_pos_area.areaid,

                            ' . $databasename . '.tbl_pos_area.areaname,

                            ' . $databasename . '.tbl_pos_servicetypemaster.shortcut,

                            ' . $databasename . '.tbl_pos_servicetypemaster.servicetypename,

                            ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid,

                            ' . $databasename . '.tbl_pos_areaservicetype.defaultrateservicetypeid

                        FROM

                            ' . $databasename . '.user_property_list_secgrp

                        INNER JOIN ' . $databasename . '.tbl_pos_area ON ' . $databasename . '.user_property_list_secgrp.areaid = ' . $databasename . '.tbl_pos_area.areaid

                        AND ' . $databasename . '.user_property_list_secgrp.propid = ' . $databasename . '.tbl_pos_area.propid

                        INNER JOIN ' . $databasename . '.tbl_pos_servicetypemaster ON ' . $databasename . '.user_property_list_secgrp.srvid =' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid

                        INNER JOIN ' . $databasename . '.tbl_pos_areaservicetype ON ' . $databasename . '.tbl_pos_area.areaid = ' . $databasename . '.tbl_pos_areaservicetype.areaid

                        WHERE

                        ' . $databasename . '.user_property_list_secgrp.usersecuritygrpid =' . $value['usersecuritygrpid'] . '

                        AND ' . $databasename . '.user_property_list_secgrp.propid = ' . $indiv_propid . '

                        AND ' . $databasename . '.user_property_list_secgrp.cmpid = ' . $cmpid . '

                        AND ' . $databasename . '.user_property_list_secgrp.areaid = ' . $value['areaid'] . '

                        AND ' . $databasename . '.user_property_list_secgrp.userid = ' . $userid . '

                        AND ' . $databasename . '.tbl_pos_servicetypemaster.servicests = 1

                        GROUP BY

                        ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid';





                     // echo $sql;

                    $query = $this->db->query($sql);

                    $servicelist = $query->result_array();







                    if (!empty($servicelist)) {

                        foreach ($servicelist as $value) {



                            $service_data[$value['areaid']][$value['servicetypeid']] = $value['servicetypename'];

                        }

                    }

                }

            }

        }



        /* echo '<pre>';

        print_r($service_data);

        echo '</pre>';*/

        //  $fromdate="2021-01-09";

        //  $todate= "2021-08-24";  

        //3.get service vice amount based on areaid and propid

        $sql = 'SELECT

                 ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid,

                 ' . $databasename . '.tbl_pos_servicetypemaster.propid,

                 ' . $databasename . '.tbl_pos_servicetypemaster.servicetypename,

                 ' . $databasename . '.tbl_pos_servicetypemaster.servicetype,

                 ' . $databasename . '.tbl_pos_servicetypemaster.servicests,

                 ' . $databasename . '.tbl_pos_servicetypemaster.added_userid,

                 ' . $databasename . '.tbl_pos_billheader.areaid,

                 ' . $databasename . '.tbl_pos_billheader.srvid,

                 ' . $databasename . '.tbl_pos_billheader.propid,

                 ' . $databasename . '.tbl_pos_billheader.billdatetime,

                 ' . $databasename . '.tbl_pos_billheader.added_userid,

                 sum(' . $databasename . '.tbl_pos_billcharges.amount) as amount,

                 ' . $databasename . '.tbl_pos_billcharges.chargeid

                from  ' . $databasename . '.tbl_pos_servicetypemaster

                INNER JOIN  ' . $databasename . '.tbl_pos_billheader ON ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid=' . $databasename . '.tbl_pos_billheader.srvid

                INNER JOIN ' . $databasename . '.tbl_pos_billcharges ON ' . $databasename . '.tbl_pos_billheader.billtrnid=' . $databasename . '.tbl_pos_billcharges.billtrnid

                WHERE ' . $databasename . '.tbl_pos_billcharges.propid=' . $indiv_propid . ' AND 

                ' . $databasename . '.tbl_pos_billheader.billcancelled=0 AND

                ' . $databasename . '.tbl_pos_billheader.billpayhdrid!="" AND

                ' . $databasename . '.tbl_pos_billheader.areaid IN (' . $areaids . ')  

                  AND DATE(' . $databasename . '.tbl_pos_billheader.billdatetime) BETWEEN "' . $fromdate . '" AND "' . $todate . '"

                GROUP BY ' . $databasename . '.tbl_pos_billheader.areaid,' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid';



        // echo $sql;



        $query = $this->db->query($sql);

        $amount = $query->result_array();



        $service_amount = array();

        if (!empty($amount)) {

            foreach ($amount  as $value) {

                $service_amount[$value['areaid']][$value['servicetypeid']] = $value['amount'];

            }

        }







        //4.get settlementlist_amount





        $sql = 'SELECT

                ' . $databasename . '.tbl_pos_billheader.areaid,

                ' . $databasename . '.tbl_pos_settlementmaster.settletype,

                ' . $databasename . '.tbl_pos_billpay_trans.paymodeid,

                sum(

                       ' . $databasename . '.tbl_pos_billpay_trans.amount

                )AS amount

            FROM

                   ' . $databasename . '.tbl_pos_billpay_trans

            INNER JOIN    ' . $databasename . '.tbl_pos_settlementmaster ON    ' . $databasename . '.tbl_pos_billpay_trans.paymodeid =    ' . $databasename . '.tbl_pos_settlementmaster.settleid

            INNER JOIN    ' . $databasename . '.tbl_pos_billheader ON    ' . $databasename . '.tbl_pos_billheader.billpayhdrid =    ' . $databasename . '.tbl_pos_billpay_trans.billpayhdrid

            WHERE

                   ' . $databasename . '.tbl_pos_billheader.billcancelled = 0

            AND date(' . $databasename . '.tbl_pos_billheader.billdatetime) BETWEEN "' . $fromdate . '"

            AND "' . $todate . '"

            AND  ' . $databasename . '.tbl_pos_billheader.areaid IN(' . $areaids . ')

            AND tbl_pos_billheader.propid=' . $indiv_propid . '

            GROUP BY

                tbl_pos_billheader.areaid,

                tbl_pos_billpay_trans.paymodeid;';



        //echo $sql;





        $query = $this->db->query($sql);

        $settleamount = $query->result_array();



        $settlement_amount = array();

        if (!empty($settleamount)) {

            foreach ($settleamount  as $value) {

                $settlement_amount[$value['areaid']][$value['settletype']] = $value['amount'];

            }

        }





        //5.line_chart_data



        $sql = 'SELECT

         ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid,

         ' . $databasename . '.tbl_pos_servicetypemaster.propid,

         ' . $databasename . '.tbl_pos_servicetypemaster.servicetypename,

         ' . $databasename . '.tbl_pos_servicetypemaster.servicetype,

         ' . $databasename . '.tbl_pos_servicetypemaster.servicests,

         ' . $databasename . '.tbl_pos_servicetypemaster.added_userid,

         ' . $databasename . '.tbl_pos_billheader.areaid,

         ' . $databasename . '.tbl_pos_billheader.srvid,

         ' . $databasename . '.tbl_pos_billheader.propid,

         ' . $databasename . '.tbl_pos_billheader.billdatetime,

            DATE(' . $databasename . '.tbl_pos_billheader.billdatetime) as date,

         ' . $databasename . '.tbl_pos_billheader.added_userid,

         sum(

             ' . $databasename . '.tbl_pos_billcharges.amount

         )AS amount,

         ' . $databasename . '.tbl_pos_billcharges.chargeid

     FROM

         ' . $databasename . '.tbl_pos_servicetypemaster

     INNER JOIN ' . $databasename . '.tbl_pos_billheader ON ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid = ' . $databasename . '.tbl_pos_billheader.srvid

     INNER JOIN ' . $databasename . '.tbl_pos_billcharges ON ' . $databasename . '.tbl_pos_billheader.billtrnid = ' . $databasename . '.tbl_pos_billcharges.billtrnid

     WHERE

         ' . $databasename . '.tbl_pos_billcharges.propid = ' . $indiv_propid . '

     AND ' . $databasename . '.tbl_pos_billheader.billcancelled = 0

     AND ' . $databasename . '.tbl_pos_billheader.areaid IN(' . $areaids . ')

     AND DATE(

         ' . $databasename . '.tbl_pos_billheader.billdatetime

     )BETWEEN "'.$fromdate .'"

     AND "'.$todate.'"

     GROUP BY

         ' . $databasename . '.tbl_pos_billheader.areaid,

         DATE(

         ' . $databasename . '.tbl_pos_billheader.billdatetime

     )';





        $query = $this->db->query($sql);

        $result = $query->result_array();



        $line_chart_data = array();

        if (!empty($result)) {

            foreach ($result  as $value) {

                $line_chart_data[$value['areaid']][$value['date']] = $value['amount'];

            }

        }





        $pos_all_data['arealist'] = $area_data;

        $pos_all_data['servicelist'] = $service_data;

        $pos_all_data['service_amount'] = $service_amount;

        $pos_all_data['settlement_amount'] =   $settlement_amount;

        $pos_all_data['line_chart_data'] = $line_chart_data;





        // echo '<pre>';

        // print_r($pos_all_data);

        // echo '</pre>';











        //echo $this->db->last_query();

        return   $pos_all_data;

    }

    public function get_all_pos_item_datas($fromdate,$todate,$indiv_propid,$areaid)

    {

        $pos_itemlist_data = array();

        $data = $this->session->userdata('propdetails');

        $userid = $this->session->userdata('userid'); 

        $databasename = $data[$indiv_propid]['databasename'];

        $cmpid = $data[$indiv_propid]['cmpid'];

        

        $sql='SELECT

         '.$databasename.'.tbl_pos_kotitems.kotitmtrnid,

        '.$databasename.'.tbl_pos_kotitems.propid,

        '.$databasename.'.tbl_pos_kotitems.billid,

        '.$databasename.'.tbl_pos_kotitems.kottrnid,

        '.$databasename.'.tbl_pos_kotitems.itemid,

        '.$databasename.'.tbl_pos_kotitems.itemname,

        '.$databasename.'.tbl_pos_kotitems.chargeid,

        '.$databasename.'.tbl_pos_kotitems.qty,

        '.$databasename.'.tbl_pos_kotitems.rate,

        '.$databasename.'.tbl_pos_kotitems.amount,

        '.$databasename.'.tbl_pos_kotheader.areaid,

        '.$databasename.'.tbl_pos_kotheader.srvid,

        '.$databasename.'.tbl_pos_kotitems.cankottrnid

        from '.$databasename.'.tbl_pos_kotitems

        INNER JOIN '.$databasename.'.tbl_pos_kotheader ON '.$databasename.'.tbl_pos_kotitems.kottrnid='.$databasename.'.tbl_pos_kotheader.kottrnid

        WHERE '.$databasename.'.tbl_pos_kotheader.areaid='.$areaid.' AND '.$databasename.'.tbl_pos_kotitems.propid='.$indiv_propid.' AND '.$databasename.'.tbl_pos_kotitems.chargeid=1  

        AND DATE('.$databasename.'.tbl_pos_kotheader.kotdate) BETWEEN "'.$fromdate.'" AND "'.$todate.'"';





      //  echo $sql;

        $query = $this->db->query($sql);

        $result= $query->result_array();



      //  echo '<pre>';

      //  print_r($result);

      //  echo '</pre>';



         $item_sold_list=array();

         $item_cancel_list=array();

        if($result)

        {

            foreach ($result as $value) {

            

            if (array_key_exists($value['itemid'],$pos_itemlist_data))

            {

                if($value['cankottrnid']==0)

                {

                $item_sold_list[$value['itemid']]['qty']=$item_sold_list[$value['itemid']]['qty']+$value['qty'];

                $item_sold_list[$value['itemid']]['amount']=$item_sold_list[$value['itemid']]['amount']+$value['amount'];

                }

                else

                {

                    $item_cancel_list[$value['itemid']]['qty']=$item_cancel_list[$value['itemid']]['qty']+$value['qty'];

                    $item_cancel_list[$value['itemid']]['amount']= $item_cancel_list[$value['itemid']]['amount']+$value['amount'];

                }

           

            }

            else

            {

                if($value['cankottrnid']==0)

                {

                $item_sold_list[$value['itemid']]=$value;

              

                }

                else

                {

                  $item_cancel_list[$value['itemid']]=$value;  

                }



            }   

           



               

               

            }



        }

        $sortarray=array();

        if($item_sold_list)

        {

            foreach ($item_sold_list as $value) {

                    $sortarray[$value['itemid']]=$value['qty'];



            }

        }

       



     /*   echo '<pre>';

        print_r($item_sold_list);

         echo '</pre>';

           echo '<br>';*/

      /*  echo '<br>';

        echo '<br>';

        echo '<br>';

        echo '<br>';

        echo '<br>';

        echo '<pre>';

        print_r($sortarray);

        echo '</pre>';

        echo '<br>';

        echo '<br>';

        echo '<br>';

        echo '<br>';

        echo '<br>';

        echo '<br>';*/

       /* arsort($sortarray);

        if($sortarray)

        {

         

        foreach($sortarray as $x => $x_value) {

             // $x=strval($x);

             // echo $x_value;

            $most_sold_item[$x]=$item_sold_list[$x];

          }

          asort($sortarray);

          foreach($sortarray as $x => $x_value) {

            //$x=strval($x);

            $least_sold_item[$x]=$item_sold_list[$x];

          }



        }

        else{

            $most_sold_item='';

            $least_sold_item='';

        }



       /* echo '<pre>';

       print_r($most_sold_item);

        echo '</pre>';



        echo '<pre>';

        print_r($least_sold_item);

         echo '</pre>';*/

        //return;*/

    

        $pos_itemlist_data['item_sold_list']= $item_sold_list;

        $pos_itemlist_data['item_cancel_list']= $item_cancel_list;

        $pos_itemlist_data['sort_array']=$sortarray;

       /* if($most_sold_item){

            $pos_itemlist_data['most_sold_item']=$most_sold_item;

        }

        if($least_sold_item)

        {

            $pos_itemlist_data['least_sold_item']=$least_sold_item;

        }*/



        return $pos_itemlist_data; 

    }



    public function get_pos_area_list($indiv_propid)

    {



    

        $data = $this->session->userdata('propdetails');

        $userid = $this->session->userdata('userid');

        $databasename = $data[$indiv_propid]['databasename'];

        $cmpid = $data[$indiv_propid]['cmpid'];

   

        //1.fst get arealist based on userid and some restrictions //intha userku intha proprtykikilla ithuna area 



        $sql = 'SELECT DISTINCT

                    ' . $databasename . '.user_master.userid,

                    ' . $databasename . '.user_master.username AS fullname,

                    ' . $databasename . '.user_master.cmpid,

                    ' . $databasename . '.user_property_list_secgrp.propid,

                    ' . $databasename . '.tbl_pos_area.areaid,

                    ' . $databasename . '.tbl_pos_area.areaname,

                    ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid,

                    ' . $databasename . '.tbl_pos_area.defaultservicetypeid,

                    ' . $databasename . '.tbl_pos_area.defaultprinter,

                    ' . $databasename . '.user_property_list_secgrp.usersecuritygrpid,

                    ' . $databasename . '.user_property_list_secgrp.srvid

                    FROM

                        ' . $databasename . '.user_master

                    INNER JOIN ' . $databasename . '.user_property_list_secgrp ON ' . $databasename . '.user_master.userid = ' . $databasename . '.user_property_list_secgrp.userid

                    LEFT JOIN ' . $databasename . '.user_role_master ON ' . $databasename . '.user_master.userroleid = ' . $databasename . '.user_role_master.roleid

                    INNER JOIN ' . $databasename . '.tbl_pos_area ON ' . $databasename . '.user_property_list_secgrp.areaid = ' . $databasename . '.tbl_pos_area.areaid

                    AND ' . $databasename . '.user_property_list_secgrp.propid = ' . $databasename . '.tbl_pos_area.propid

                    LEFT JOIN ' . $databasename . '.tbl_pos_servicetypemaster ON ' . $databasename . '.tbl_pos_area.defaultservicetypeid = ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid

                    LEFT JOIN ' . $databasename . '.tbl_pos_areaservicetype ON ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid = ' . $databasename . '.tbl_pos_areaservicetype.servicetypeid

                    INNER JOIN ' . $databasename . '.user_group_master_cmp ON ' . $databasename . '.user_property_list_secgrp.usersecuritygrpid = ' . $databasename . '.user_group_master_cmp.trnid

                    WHERE

                        ' . $databasename . '.user_master.userid = ' . $userid . '

                    AND ' . $databasename . '.user_group_master_cmp.module = "POS"

                    AND ' . $databasename . '.user_property_list_secgrp.propid=' . $indiv_propid . ' AND ' . $databasename . '.user_property_list_secgrp.cmpid= ' . $cmpid . ' 

                    AND ' . $databasename . '.user_master. STATUS = 1

                    GROUP BY

                        ' . $databasename . '.user_property_list_secgrp.areaid';



        //  echo $sql;



        $query = $this->db->query($sql);

        $arealist = $query->result_array();



        $area_data = array();

       

        if (!empty($arealist)) {

            foreach ($arealist as $value) {

                $area_data[$value['propid']][$value['areaid']] = $value['areaname'];

            }

        }



             return $area_data;



    }

}

