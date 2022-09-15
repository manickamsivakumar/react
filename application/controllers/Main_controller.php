<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_controller extends CI_Controller
{

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
        $this->load->model('Mis_model', 'mis');


        //$this->load->library('Curl');
        //$dbchange = $this->loaddatabase('root','goodday123','192.168.0.250','raspmaster');
        //S$this->db=$this->load->database($dbchange,true);
    }
    public function makesetdatabase()
    {
       /* echo '<pre>';
        print_r($_POST['deviceid']);
        echo '</pre>';
        echo '<pre>';
        print_r($_POST['logouturl']);
        echo '</pre>';*/

        // echo '<pre>';
        // var_dump($_POST['strdata']);
        // echo '</pre>';






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


        if ($this->session->has_userdata('logindetails')) {
            //echo "return";
            return;
        }

        $dbserverip = $dbserveruserid = $dbserverpwd = $databasename = "";
        $str_json_data = $this->input->post('strdata');
		
        $j_datas = json_decode($str_json_data);
        $Module_datas = json_decode($this->input->post('module_list'));


        $j_data = "";
        $databasedetails = [];
        $propdetails = [];

        foreach ($j_datas as $key => $value) {
            if ($j_data == "") {
                $j_data = $value;
            }
            $userid = $value->userid;
            $cmpid = $propdetails[$value->propid]['cmpid'] = $value->cmpid;
            $propdetails[$value->propid]['propname'] = $value->propname;
            $propdetails[$value->propid]['propcity'] = $value->propcity;
            $propdetails[$value->propid]['propcolor'] = $value->propdashcolor;
            $propdetails[$value->propid]['databasename'] = $value->databasename;
        }
        // echo"<pre>";
        // print_r($propdetails);
        // echo"</pre>";

        if ($this->session->has_userdata('propdetails')) {
            $this->session->unset_userdata('propdetails');
        }
        $this->session->set_userdata('propdetails', $propdetails);

        if ($this->session->has_userdata('userid')) {
            $this->session->unset_userdata('userid');
        }
        $this->session->set_userdata('userid', $userid);

        if ($this->session->has_userdata('cmpid')) {
            $this->session->unset_userdata('cmpid');
        }
        $this->session->set_userdata('cmpid', $cmpid);

        if ($this->session->has_userdata('module_list')) {
            $this->session->unset_userdata('module_list');
        }
        $this->session->set_userdata('module_list', $Module_datas);

        $my_data = json_decode(json_encode($j_data), true);

        $dbserverip = $dbserveruserid = $dbserverpwd = $databasename = "";
        $dbserverip = $my_data['dbserverip']; //uncmt
        //$dbserverip = '3.6.30.109';
        $dbserveruserid = $my_data['dbserveruserid']; //uncmt
        //$dbserveruserid = 'rasp_demo';
        $dbserverpwd = $this->decrpt_pwd($my_data['dbserverpwd']); //uncmt
        //$dbserverpwd = $this->decrpt_pwd('9FykGteu3UWxYgUccmUHkuf29ZmHEMe6U7eqIIyYMKaBN9WzAQCXMJNAIGmIf2epV8EkyR59Epn09jYZV8mMeDf59kY9F0YhKnAI69a0');
        $databasename = $my_data['databasename']; //uncmt
        //$databasename = 'rasp_bkg';

        if ($dbserverip != "" && $dbserveruserid != "" && $dbserverpwd != "" && $databasename != "") {
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
            if ($this->session->has_userdata('logindetails')) {
                $this->session->unset_userdata('logindetails');
            }
            $this->session->set_userdata('logindetails', $sess_array);
        }
        $deviceid=$this->input->post('deviceid');
        $logouturl=$this->input->post('logouturl');
        if ($this->session->has_userdata('deviceid')) {
            $this->session->unset_userdata('deviceid');
        }
        $this->session->set_userdata('deviceid',$deviceid);
        if ($this->session->has_userdata('logouturl')) {
            $this->session->unset_userdata('logouturl');
        }
        $this->session->set_userdata('logouturl',$logouturl);
    }
    
    public function authredirect($data)
	{

        $edata = $data['edata'];

        $msgdata = json_decode($edata);
        $msgdata = json_decode(json_encode($msgdata), true);

        $data = [];
        $data['propid'] = $data['msgdata'] = 0;
        if(count($msgdata)) {
            $details = $msgdata['details'];
            $data['propid'] = $details['propid'];
            $data['msgdata'] = $edata;
        }
        //$data['propid'] = $this->input->get('propid');

		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);

		$data['userid'] = $this->session->userdata('userid');
		$data['cmpid'] = $this->session->userdata('cmpid');

		$this->load->view('authentication/authentication',$data);	
    }
    
    public function index()
    {

        //return;
        // $data['deviceid'] = $this->input->post('deviceid');
        // $data['userid'] = $this->input->post('userid');
        // $data['cmpid']=$this->input->post('cmpid');

        if ($this->input->post('propids')) {
            // echo 1;

            $data['propids'] = $this->input->post('propids');
        } else {
            $propids = array();
            $data = $this->session->userdata('propdetails');
            foreach ($data as $key => $value) {
                array_push($propids, $key);
            }

            $data['propids'] = implode(",", $propids);
        }



        // $data['propids']=$this->input->post('propids');






        //  $data['logouturl'] = $this->input->post('logouturl');
        // $propids=(json_decode($data['propids'],true)); //array

        // $propids=[12,13];
        // $data['cmpid']=8;
        // print_r($propids);
        $data['allpropids'] = explode(",", $data['propids']);
        $data['propcount'] = count($data['allpropids']);
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
           
           

           $data['edata'] = 0;
           if ($this->input->post('edata')) {
            $data['edata'] = $this->input->post('edata');
        }

        

        if($data['edata']) {
            $this->authredirect($data);
        }
        else{
            if ($data['propcount'] == 1) {

                //var_dump(2);
             $this->individual_prop($data);
          } else {
               //var_dump(1);
             $this->load->view('main_dashboard', $data);
          }
        }
        
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


    public function individual_prop($sdata = "")
    {
        $propcount = '';
        $data['edata'] = 0;

        if($sdata)
        {
            $propcount = $sdata['propcount'];
            $data['edata'] = $sdata['edata'];
        }
        

        $data['propid'] = $this->input->get('propid');
        //  echo $data['propid'];

        if ($this->session->has_userdata('singlepropid')) {
            $this->session->unset_userdata('singlepropid');
        }
        $this->session->set_userdata('singlepropid', $data['propid']);

        //echo "1";
        $data['propcount'] = $propcount;

       //echo "<pre>";
        //print_r($data);
        //echo "</pre>";

        $this->load->view('individual_prop/individual_prop', $data);
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
    public function indiv_property()
    {
        $indivpropid['propid'] = $_GET['propid'];

        if ($this->session->has_userdata('singlepropid')) {
            $this->session->unset_userdata('singlepropid');
        }
        $this->session->set_userdata('singlepropid', $indivpropid['propid']);

        $this->load->view('individual_prop/indiv_prop.php', $indivpropid);
    }
    public function get_indiv_fillter_values()
    {

        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $propid = $this->input->post('propid');
        //$cmpid=$this->input->post('cmpid');
        //$propids=$this->input->post('propids');

        $data = $this->mis->get_indiv_module_values($fromdate, $todate, $propid);
        echo json_encode($data);
    }
    //ajax function start
    public function get_fillter_values()
    {

        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        //$cmpid=$this->input->post('cmpid');
        //$propids=$this->input->post('propids');

        $data = $this->mis->get_all_module_values($fromdate, $todate);
        echo json_encode($data);
    }

    //database password decrypt method start

    public function decrpt_pwd($epwd)
    {
        $tpwd = $this->decrpt($epwd);
        $tpwd = substr($tpwd, 1, strlen($tpwd) - 2);

        $id = substr($tpwd, 0, 1);

        $outstr = '';
        while (strlen($tpwd) > 0) {
            $id = substr($tpwd, 0, 1);
            $outstr = $outstr . substr($tpwd, $id + 1, 1);
            $tpwd = substr($tpwd, $id + 2, strlen($tpwd) - ($id + 1));
        }
        return  $outstr;
    }

    public function reverseBits($in)
    {
        $out = 0;
        if ($in & 0x01) {
            $out |= 0x80;
        }
        if ($in & 0x02) {
            $out |= 0x40;
        }
        if ($in & 0x04) {
            $out |= 0x20;
        }
        if ($in & 0x08) {
            $out |= 0x10;
        }
        if ($in & 0x10) {
            $out |= 0x08;
        }
        if ($in & 0x20) {
            $out |= 0x04;
        }
        if ($in & 0x40) {
            $out |= 0x02;
        }
        if ($in & 0x80) {
            $out |= 0x01;
        }
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

        $arr = str_split($dval, 2);

        for ($i = 0; $i < sizeof($arr); $i++) {
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

    //bnqt
    public function bnqt()
    {
        echo 'Work in under consrtuction';
       
    }
    public function pos_back()
    {
      
        $this->index();

      /* if($this->input->get('i')==0)
       {
         $this->individual_prop();
          // var_dump('a');
       }
       else
       {
        if($this->input->get('m')==1)
        {
            
           //   var_dump('b');
 
        }
        else
        {
             // return;
          //   var_dump('c');
              $this->indiv_property();
        }*/
    
       



    }
  
}
