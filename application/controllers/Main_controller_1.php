<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main_controller extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'array'));
        $this->load->library('session');
	//	$this->load->database();
        $this->makesetdatabase();
	   //$this->makesetdatabase();
		$this->load->model('Mis_model','mis');
        

        //$this->load->library('Curl');
        //$dbchange = $this->loaddatabase('root','goodday123','192.168.0.250','raspmaster');
        //S$this->db=$this->load->database($dbchange,true);
    }
	public function makesetdatabase()
    {        
      /*   $strdata=$_POST['strdata'];
         $strarray=json_decode($strdata);
         echo '<pre>';
         var_dump($_POST['strdata']);
         echo '</pre>';
     
         echo '<pre>';
         print_r(json_decode($strdata));
         echo '</pre>';

        foreach($strarray as $key=>$value)
		{
            echo $key.'</br>'.$value->propname;

        }*/





       //return;


        if($this->session->has_userdata('logindetails')) 
        { 
          //echo "return";
         return;
        }
		
		$dbserverip = $dbserveruserid = $dbserverpwd = $databasename = "";
        $str_json_data=$this->input->post('strdata');
		$j_datas=json_decode($str_json_data);
        $Module_datas=json_decode($this->input->post('module_list'));

    
		$j_data="";
        $databasedetails=[];
        $propdetails=[];
       
         foreach($j_datas as $key=>$value)
		{
			if($j_data=="")
			{
				$j_data=$value;
			}
            $userid=$value->userid;
            $propdetails[$value->propid]['cmpid']=$value->cmpid;
            $propdetails[$value->propid]['propname']=$value->propname;
            $propdetails[$value->propid]['propcity']=$value->propcity;
            $propdetails[$value->propid]['propcolor']=$value->propdashcolor;
            $propdetails[$value->propid]['databasename']=$value->databasename;


		}
    
		
           if($this->session->has_userdata('propdetails'))
           {
            $this->session->unset_userdata('propdetails');
           }
            $this->session->set_userdata('propdetails', $propdetails);

            if($this->session->has_userdata('userid'))
            {
                $this->session->unset_userdata('userid');
            }
            $this->session->set_userdata('userid', $userid);

           if($this->session->has_userdata('module_list'))
           {
                  $this->session->unset_userdata('module_list');

           }
            $this->session->set_userdata('module_list',$Module_datas);







		$my_data=json_decode(json_encode($j_data), true);

		$dbserverip = $dbserveruserid = $dbserverpwd = $databasename = "";
        $dbserverip = $my_data['dbserverip']; //uncmt
		//$dbserverip = '3.6.30.109';
        $dbserveruserid = $my_data['dbserveruserid']; //uncmt
		//$dbserveruserid = 'rasp_demo';
        $dbserverpwd = $this->decrpt_pwd($my_data['dbserverpwd']); //uncmt
		//$dbserverpwd = $this->decrpt_pwd('9FykGteu3UWxYgUccmUHkuf29ZmHEMe6U7eqIIyYMKaBN9WzAQCXMJNAIGmIf2epV8EkyR59Epn09jYZV8mMeDf59kY9F0YhKnAI69a0');
        $databasename = $my_data['databasename']; //uncmt
		//$databasename = 'rasp_bkg';

        if($dbserverip != "" && $dbserveruserid !="" && $dbserverpwd !="" && $databasename !="")
        {
            //$dbserverpwd=$this->decrpt_pwd($dbserverpwd);
			$sess_array = array(
                'dbserverip' => $dbserverip,
                'dbserveruserid' => $dbserveruserid,
                'dbserverpwd' => $dbserverpwd,
                'databasename' => $databasename
            );

			//echo '<pre>';
             // print_r($sess_array) ;
             // echo '</pre>';
			if($this->session->has_userdata('logindetails'))
            {
                $this->session->unset_userdata('logindetails');
            }
            $this->session->set_userdata('logindetails', $sess_array);
            

        }
    
    }
	public function index()
	{

        //return;
         // $data['deviceid'] = $this->input->post('deviceid');
		 // $data['userid'] = $this->input->post('userid');
		 // $data['cmpid']=$this->input->post('cmpid');

           if($this->input->post('propids'))
           {
             // echo 1;
                   
	       $data['propids']=$this->input->post('propids');

           }
           else
           {
                $propids=array();
                $data=$this->session->userdata('propdetails');
                foreach($data as $key=>$value)
                {
                  array_push($propids,$key);
                
                }
               
	          $data['propids']=implode(",", $propids);
                      
            

           }



	      // $data['propids']=$this->input->post('propids');






		//  $data['logouturl'] = $this->input->post('logouturl');
		 // $propids=(json_decode($data['propids'],true)); //array

		 // $propids=[12,13];
		 // $data['cmpid']=8;
		 // print_r($propids);
		  $data['allpropids']= explode(",",$data['propids']);
          $data['propcount']=count($data['allpropids']);
             //echo '<pre>';
           // print_r( $data['allpropids'] );
           //  echo '</pre>';
		  //$connect_database= $this->mis->get_all_prop_db_details($data['cmpid'], $data['allpropids']);
           /*echo '<pre>';
		   print_r($prop_db_info);
		   echo '</pre>';*/
		   
		 /* $alldatabase_names=array();
          foreach ($prop_db_info as $value) {
                     array_push($alldatabase_names,$value['databasename']);   
           }
		  $data['all_database_names']= implode(",",$alldatabase_names);*/

		   /*echo '<pre>';
		   print_r($data);
		   echo '</pre>';*/


           if($data['propcount']==1)
           {

                 $this->individual_prop($data['propcount']);

           }
           else
           {
               
		      $this->load->view('main_dashboard',$data);

           }
		   

		   
        


        
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










	public function individual_prop($propcount="")
	{
       $data['propid']=$this->input->get('propid');
     //  echo $data['propid'];

         //echo "1";
       $data['propcount']=$propcount;
	   $this->load->view('individual_prop/individual_prop',$data);
	}
	public function frontoffice()
	{
		

		$this->load->view('front_office/frontoffice');

	}
	public function food_beverages_sales()
	{


		$this->load->view('food_beverages/sales');
	}
	public function food_beverages_items()
	{


		$this->load->view('food_beverages/items');
	}
	
	public function banquet_others()
	{



			$this->load->view('banquet_others/banquet&others');
	}
	public function authentication()
	{


		$this->load->view('authentication/authentication');
	}
	public function alerts()
	{
       	$this->load->view('alerts/alerts');

	
	}

	//ajax function start
	public function get_fillter_values()
	{

        $fromdate = $this->input->post('fromdate');
		$todate = $this->input->post('todate');
		//$cmpid=$this->input->post('cmpid');
		//$propids=$this->input->post('propids');
		
        $data = $this->mis->get_all_module_values($fromdate,$todate);
        echo json_encode($data);





	}

	//database password decrypt method start
    	
  public function decrpt_pwd($epwd)
 {
        $tpwd =$this->decrpt($epwd);
        $tpwd = substr($tpwd,1,strlen($tpwd)-2);

        $id = substr($tpwd,0,1);

        $outstr = '';
        while(strlen($tpwd) > 0)
            {
                $id = substr($tpwd,0,1);
                $outstr = $outstr . substr($tpwd,$id+1,1);
                $tpwd = substr($tpwd,$id+2,strlen($tpwd) - ($id+1));
            }
        return  $outstr;
 }

 public function reverseBits($in)
 {
    $out = 0;
    if ($in & 0x01) { $out |= 0x80;}
    if ($in & 0x02) { $out |= 0x40;}
    if ($in & 0x04) { $out |= 0x20;}
    if ($in & 0x08) { $out |= 0x10;}
    if ($in & 0x10) { $out |= 0x08;}
    if ($in & 0x20) { $out |= 0x04;}
    if ($in & 0x40) { $out |= 0x02;}
    if ($in & 0x80) { $out |= 0x01;}
    return $out;
 }
 public function decrpt($dval)
 {
        $arr = array();
        $i = 0;

        $sltval = '';
        $sval = 0;
        $seed = 0;
        $res = 0;
        $resstr = '';
        // echo $dval . '  --  ';

        $arr = str_split($dval,2);

        for($i = 0; $i < sizeof($arr); $i++)
        {
            $sltval = $arr[$i];

            $sval = ord($sltval[0]);
            $seed = ord($sltval[1]);
            //echo $sval . ' ' . $seed . ':REV = ';
            $sval = $this->reverseBits($sval);
            //echo $sval . ': CALOUT = ' ;
            $res = ($sval - $seed);
            //echo $res . ' , OUTPUT = ';
            $resstr .= chr($res);
        }

 return $resstr;
 }


}
