<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontoffice_controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper(array("url", "form", "array"));
		$this->load->model("Frontoffice_model");
	}
	public function frontoffice()
	{
        $data['propid']=$this->input->get("propid");
		$data['m']=$this->input->get("m");
		//var_dump($data);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
		
		$this->load->view('front_office/frontoffice',$data);
	}
	public function frontoffice_sub_filter()
	{
		
		$propid=$this->input->post("propid");
		//var_dump($propid);
		
		$fromdate = $this->input->post("fromdate");
		$todate = $this->input->post("todate");
		$filtervalue = $this->input->post("filtervalue");

		$data = $this->Frontoffice_model->frontofficesales($fromdate, $todate, $filtervalue,$propid);
		
		echo json_encode($data);
	}
	public function arrival_frontoffice(){
		$data['propid']=$this->input->get("propid");
		//var_dump($data);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
		$this->load->view('front_office/foe_arrival',$data);


	}
	public function arrival_foe_filters(){

		$propid=$this->input->post("propid");
		//var_dump($propid);
		
		$fromdate = $this->input->post("fromdate");
		$todate = $this->input->post("todate");
		$filtervalue = $this->input->post("filtervalue");

		$data = $this->Frontoffice_model->foe_arrival_performance($fromdate, $todate, $filtervalue,$propid);
		
		echo json_encode($data);
	}
	public function highbalancereport(){
		$data['propid']=$this->input->get("propid");
		//var_dump($data);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
		$this->load->view('front_office/hbreport',$data);


	}
	public function gethighbalance(){
		$propid = $this->input->post("propid");
		//var_dump($propid);
				$data=$this->session->userdata('propdetails')[$propid];
		//	echo "<pre>";
			//print_r($data);
			//echo"</pre>";
			//$key=$propid;
		
			$dbname=$data['databasename'];
			$cmpid=$data['cmpid'];
			$propcity=$data['propcity'];
			$propcolor=$data['propcolor'];
			$propname=$data['propname'];
			$datas['data']=$data;
			$datas['hbreport']=$this->Frontoffice_model->gethighbalancereport($propid,$dbname,$cmpid);
            echo json_encode($datas);
	}

	public function currentOccupancy(){

		$data['propid']=$this->input->get("propid");
		//var_dump($data);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
		$this->load->view('front_office/Coccupancy',$data);



	}
	public function getcurrentoccupancy(){

		$propid = $this->input->post("propid");
		
		$today = $this->input->post("today");
		//var_dump($propid);
				$data=$this->session->userdata('propdetails')[$propid];
			//echo "<pre>";
			//print_r($data);
			//echo"</pre>";
			//$key=$propid;
			$dbname=$data['databasename'];
			$cmpid=$data['cmpid'];
			$propcity=$data['propcity'];
			$propcolor=$data['propcolor'];
			$propname=$data['propname'];
			$datas['data']=$data;
			$datas['occupancy']=$this->Frontoffice_model->getcurrentoccupancy($today,$propid,$dbname,$cmpid);
            echo json_encode($datas);

	}
	public function currentcheckin(){

		$data['propid']=$this->input->get("propid");
		//var_dump($data);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
		$this->load->view('front_office/checkin',$data);



	}
	public function getcurrentcheckin(){

		$propid = $this->input->post("propid");
		
		$today = $this->input->post("today");
		//var_dump($propid);
				$data=$this->session->userdata('propdetails')[$propid];
			//echo "<pre>";
			//print_r($data);
			//echo"</pre>";
			//$key=$propid;
			$dbname=$data['databasename'];
			$cmpid=$data['cmpid'];
			$propcity=$data['propcity'];
			$propcolor=$data['propcolor'];
			$propname=$data['propname'];
			$datas['data']=$data;
			$datas['occupancy']=$this->Frontoffice_model->getcheckin($today,$propid,$dbname,$cmpid);
            echo json_encode($datas);

	}
	public function currentcheckout(){

		$data['propid']=$this->input->get("propid");
		//var_dump($data);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
		$this->load->view('front_office/checkout',$data);



	}
	public function getcurrentcheckout(){

		$propid = $this->input->post("propid");
		
		$today = $this->input->post("today");
		//var_dump($propid);
				$data=$this->session->userdata('propdetails')[$propid];
			//echo "<pre>";
			//print_r($data);
			//echo"</pre>";
			//$key=$propid;
			$dbname=$data['databasename'];
			$cmpid=$data['cmpid'];
			$propcity=$data['propcity'];
			$propcolor=$data['propcolor'];
			$propname=$data['propname'];
			$datas['data']=$data;
			$datas['occupancy']=$this->Frontoffice_model->getcheckout($today,$propid,$dbname,$cmpid);
            echo json_encode($datas);

	}
	
	public function indivguestdetails(){

		$propid=$this->input->get("propid");
		$trnid=$this->input->get("trnid");
		
		//var_dump($propid);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $propid);
		$data=$this->session->userdata('propdetails')[$propid];
			//echo "<pre>";
			//print_r($data);
			//echo"</pre>";
			//$key=$propid;
			$dbname=$data['databasename'];
			$cmpid=$data['cmpid'];
			$propcity=$data['propcity'];
			$propcolor=$data['propcolor'];
			$propname=$data['propname'];
			$datas['propid']=$propid;
			$datas['data']=$data;
			$datas['guest']=$this->Frontoffice_model->getguestinformation($trnid,$propid,$dbname,$cmpid);
			//echo "<pre>";
			//print_r	($datas['guest']);
			//echo"</pre>";	
		$this->load->view('front_office/indivguest',$datas);



	}
	public function indivcheckin(){

		$propid=$this->input->get("propid");
		$trnid=$this->input->get("trnid");
		
		//var_dump($propid);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $propid);
		$data=$this->session->userdata('propdetails')[$propid];
			//echo "<pre>";
			//print_r($data);
			//echo"</pre>";
			//$key=$propid;
			$dbname=$data['databasename'];
			$cmpid=$data['cmpid'];
			$propcity=$data['propcity'];
			$propcolor=$data['propcolor'];
			$propname=$data['propname'];
			$datas['propid']=$propid;
			$datas['data']=$data;
			$datas['guest']=$this->Frontoffice_model->getguestinformation($trnid,$propid,$dbname,$cmpid);
			//echo "<pre>";
			//print_r	($datas['guest']);
			//echo"</pre>";	
		$this->load->view('front_office/indivchkin',$datas);



	}
	public function indivcheckout(){

		$propid=$this->input->get("propid");
		$trnid=$this->input->get("trnid");
		
		//var_dump($propid);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $propid);
		$data=$this->session->userdata('propdetails')[$propid];
			//echo "<pre>";
			//print_r($data);
			//echo"</pre>";
			//$key=$propid;
			$dbname=$data['databasename'];
			$cmpid=$data['cmpid'];
			$propcity=$data['propcity'];
			$propcolor=$data['propcolor'];
			$propname=$data['propname'];
			$datas['propid']=$propid;
			$datas['data']=$data;
			$datas['guest']=$this->Frontoffice_model->getguestinformation($trnid,$propid,$dbname,$cmpid);
			//echo "<pre>";
			//print_r	($datas['guest']);
			//echo"</pre>";	
		$this->load->view('front_office/indivchkout',$datas);



	}
	public function daysettlementreport(){
		$data['propid']=$this->input->get("propid");
		//var_dump($data);
		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
		
		$this->load->view('front_office/Daysettlement.php',$data);
	}
	public function getdaysettlement()
	{
		$propid = $this->input->post("propid");
//var_dump($propid);
		$data=$this->session->userdata('propdetails')[$propid];
    //echo "<pre>";
    //print_r($data);
    //echo"</pre>";
    //$key=$propid;
    $dbname=$data['databasename'];
    $cmpid=$data['cmpid'];
    $propcity=$data['propcity'];
    $propcolor=$data['propcolor'];
    $propname=$data['propname'];
   
		$rptdate=$this->input->post("today");
		//var_dump($date);
		
		
		$cashledgerid = 19;
		//$rptdate = date_format($date,"Y-m-d");
		//var_dump($rptdate);
		$prevdate = date('Y-m-d', strtotime("-1 days"));
		$gaccdate = "2017-04-01";
		//var_dump($prevdate);
		$closebalcash = $this->Frontoffice_model->get_closebal($propid, $cmpid, $cashledgerid, $gaccdate,$dbname, $gaccdate, $prevdate);
		$openbalcash = $this->Frontoffice_model->getopeningbal($propid, $cmpid,$dbname);
		$propaddress = $this->Frontoffice_model->getpropaddress($propid, $cmpid,$dbname);
        $start_from=0;
		$total_records=0;
		$total_pages = 0;
		$limit=999999;
		$from="00:00:00";
		$to="23:59:59";
		$contra_in=$this->Frontoffice_model->getSettle("CONTRA-IN",$rptdate,$start_from,$limit,$from,$to,$propid,$cmpid,$cashledgerid,$dbname);

		$advance=$this->Frontoffice_model->getSettle("ADVANCE",$rptdate,$start_from,$limit,$from,$to,$propid,$cmpid,$cashledgerid,$dbname);
		
		$receipt=$this->Frontoffice_model->getSettle("RECEIPT",$rptdate,$start_from,$limit,$from,$to,$propid,$cmpid,$cashledgerid,$dbname);

		$refund=$this->Frontoffice_model->getSettle("REFUND",$rptdate,$start_from,$limit,$from,$to,$propid,$cmpid,$cashledgerid,$dbname);
		$payment=$this->Frontoffice_model->getSettle("PAYMENT",$rptdate,$start_from,$limit,$from,$to,$propid,$cmpid,$cashledgerid,$dbname);


		$contra_out=$this->Frontoffice_model->getSettle("CONTRA-OUT",$rptdate,$start_from,$limit,$from,$to,$propid,$cmpid,$cashledgerid,$dbname);
         $settledata=array();
		$data=array();
		$propdata=array();
		$propdata['propname']=$propname;
		$propdata['propcity']=$propcity;
        $propdata['propcolor']=$propcolor;
		$propdata['closeingbalance']=$closebalcash;
		$propdata['openingbalance']=$openbalcash;
		$data['contra-in']=$contra_in;
		$data['advance']=$advance;
		$data['receipt']=$receipt;
		$data['payment']=$payment;
		$data['contra-out']=$contra_out;
		$data['refund']=$refund;
		$settledata['props']=$propdata;
		$settledata['settle']=$data;
	    echo json_encode($settledata);
		
	
	}

	
}





























		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

