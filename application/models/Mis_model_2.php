<?php
Class Mis_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->connectdatabase();
    }

    public function get_all_prop_db_details($cmpid,$propids)
    {

       
       
       $sql='SELECT
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
                property_master.cmpid = '.$cmpid.'
            AND property_master.propid IN('.$propids.')';
        
        
      
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

       return $data ;


    }

     public function connectdatabase()
    {        
        $data['logindetails'] = $this->session->userdata('logindetails');
        $dbserverip = $dbserveruserid = $dbserverpwd = $databasename = "";
        $dbserverip = $data['logindetails']['dbserverip'];
        $dbserveruserid = $data['logindetails']['dbserveruserid'];
        $dbserverpwd = $data['logindetails']['dbserverpwd'];
        $databasename = $data['logindetails']['databasename'];
        
        if($dbserverip != "" && $dbserveruserid !="" && $dbserverpwd !="" && $databasename !="")
        {
            $dbchange = $this->loaddatabase($dbserveruserid,$dbserverpwd,$dbserverip,$databasename);
            $this->db=$this->load->database($dbchange,true);
        }
        /*$name = $this->house->getdbname();
        echo "<pre>";
        print_r($name);
        echo "</pre>";*/
    }
    public function loaddatabase($userid="",$password="",$hostname="",$dbname="")
    {
        if(($userid!="")&&($password!="")&&($hostname!="")&&($dbname!=""))
        {
            $dsn = 'mysqli://'.$userid.':'.$password.'@'.$hostname.'/'.$dbname;            
            //$this->load->database($dsn,true);            
            //return $dsn;
            return $dsn;
        }
        else
        {
            //$this->load->database();
            return 'raspmaster';
        }
    }

    


 

 
    //database password decrypt method end




    public function get_all_module_values($fromdate,$todate)
    {
           /*  echo $this->db->username."</br>";
             echo $this->db->hostname."</br>";
             echo $this->db->username."</br>";
             echo $this->db->password."</br>";
             echo $this->db->database."</br>";*/
           // $data = [];
            $main_page_all_datas=array();
            $main_page_all_data=array();
            $module_list=array();


            $data=$this->session->userdata('propdetails');

           // echo '<pre>';
          //  print_r($data);
          //  echo '</pre>';
            $moduledata=$this->session->userdata('module_list');








            $allmoduledata=json_decode(json_encode($moduledata), true); 
        /* foreach($result as $values)
        {

            if(!array_key_exists($values['propid'],$module_list))
            {
                $module_list[$values['propid']]=array();
            }
                  array_push($module_list[$values['propid']],$values['modid']);

        }*/

                
         
        foreach($data as $key => $value)
        {
                $dbname=$value['databasename'];
                $propname=$value['propname'];
                $propcity=$value['propcity'];
                $propcolor=$value['propcolor'];

             //get_prop_details
                $main_page_all_data[$key]['propname']= $propname;
                $main_page_all_data[$key]['propcity']=$propcity;
                $main_page_all_data[$key]['propcolor']= $propcolor;
          
            //get pos_amount
            $sql='select sum(amount) as amount from '.$dbname.'.tbl_pos_billcharges WHERE DATE(added_date) BETWEEN "'.$fromdate.'" AND "'.$todate.'"'; 
           // echo $sql;
            $query = $this->db->query($sql);
            $data1 = $query->result_array();
        
            if($data1[0]['amount']!="")
            {
                $main_page_all_data[$key]['pos_total_bill_amount']=$data1[0]['amount'];
            }
            else
            {
                $main_page_all_data[$key]['pos_total_bill_amount']="0.00";
            }
            //get bnqt_amount
            $sql='select sum(amount) as amount from '.$dbname.'.tbl_bnqt_booking_charges WHERE DATE(addeddatetime) BETWEEN "'.$fromdate.'" AND "'.$todate.'"'; 
           // echo $sql;
            $query = $this->db->query($sql);
            $data2 = $query->result_array();
    
            if($data2[0]['amount']!="")
            {
                $main_page_all_data[$key]['bnqt_total_booking_charges_amount']=$data2[0]['amount'];
            }
            else
            {
                $main_page_all_data[$key]['bnqt_total_booking_charges_amount']="0.00";
            }

            //get_front_office_details
             $main_page_all_data[$key]['front_offize_total_amount']="15000.00";


            
       //line chart qries for FOE,POS,BNQT

          $foe_line_chart_data=array();
          $pos_line_chart_data=array();
          $bnqt_line_chart_data=array();


           //pos line chart qries
          $sql='select Date(added_date) as dates,SUM(amount) as amount from '.$dbname.'.tbl_pos_billcharges WHERE DATE(added_date) BETWEEN "2021-08-10" AND "2021-08-23"
                GROUP BY dates;';
          $query = $this->db->query($sql);
          $pos_line_chart_result = $query->result_array();
        
          if($pos_line_chart_result)
          {
             foreach($pos_line_chart_result as $value)
             {

                  // array_push($pos_line_chart_data,$value);
                if (array_key_exists($value["dates"],$pos_line_chart_data))
                {
               // echo "Key exists!";
                  // $pos_line_chart_result["dates"]=$value;
                      array_push($pos_line_chart_data[$value["dates"]],$value['amount']);
                }
                else
                {
               // echo "Key does not exist!";
                $pos_line_chart_data[$value["dates"]]=array();
              //  $pos_line_chart_result["mydates"]=$value;
                 array_push( $pos_line_chart_data[$value["dates"]],$value['amount']);
                }
                               


             }


          }

          // echo '<pre>';
          // print_r($pos_line_chart_data);
          // echo '</pre>';
          
           //bnqt line chart qries
          $sql='select Date(addeddatetime) as dates,sum(amount) as amount from '.$dbname.'.tbl_bnqt_booking_charges WHERE DATE(addeddatetime) BETWEEN "2019-09-21" AND "2021-08-21"
                GROUP BY dates;';
          $query = $this->db->query($sql);
          $bnqt_line_chart_result = $query->result_array();

           if($pos_line_chart_result)
          {
             foreach($pos_line_chart_result as $value)
             {

                  // array_push($pos_line_chart_data,$value);
                if (array_key_exists($value["dates"],$pos_line_chart_data))
                {
               // echo "Key exists!";
                  // $pos_line_chart_result["dates"]=$value;
                      array_push($pos_line_chart_data[$value["dates"]],$value['amount']);
                }
                else
                {
               // echo "Key does not exist!";
                $pos_line_chart_data[$value["dates"]]=array();
              //  $pos_line_chart_result["mydates"]=$value;
                 array_push( $pos_line_chart_data[$value["dates"]],$value['amount']);
                }
                               


             }


          }




        }
              
        











      //  echo '<pre>';
       // print_r($main_page_all_datas);
      //  echo '</pre>';


       
         $main_page_all_datas['module_list']=$allmoduledata;
         $main_page_all_datas['amount_details']=$main_page_all_data;
         
       return $main_page_all_datas;
 
   
     


    }
}

?>