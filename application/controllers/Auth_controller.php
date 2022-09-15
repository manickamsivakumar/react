<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth_controller extends CI_Controller
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
		$this->load->library("session");
		//$this->load->library("basefuncs");
		//$this->load->database();
		$this->load->helper(array('form', 'url', 'array'));
		date_default_timezone_set('Asia/Kolkata');
		//error_reporting(E_ALL | E_STRICT);
		//require("./application/libraries/phpMQTT.php");
		$this->load->model('Authmodel', 'aud');
	}

	/*----------------------------------authsection----------------------------------*/
	public function authpage()
	{

		$data['propid'] = $this->input->get('propid');

		if ($this->session->has_userdata('singlepropid')) {
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);

		$data['userid'] = $this->session->userdata('userid');
		$data['cmpid'] = $this->session->userdata('cmpid');

		//var_dump($data['propid']);
		/*$data['propid'] = 13;
		$data['cmpid'] = 8;
		$data['userid'] = 1;*/
		//var_dump($data);

		$this->load->view('authentication/authentication', $data);
	}

	public function getauthsresult()
	{
		//$propid = $this->input->post('propid');
		$authsresultfilter = $this->input->post('authsresultfilter');

		$data['propid'] = $this->session->userdata('singlepropid');
		$data['userid'] = $this->session->userdata('userid');
		$data['cmpid'] = $this->session->userdata('cmpid');

		//$data['propid'] = 13;
		//$data['cmpid'] = 8;
		//$data['userid'] = 1;

		$response = $this->aud->getauthsresult($data);
		echo json_encode($response);
	}

	public function readverifydetails()
	{
		//$propid = $this->input->post('propid');
		$verifydetails = $this->input->post('verifydetails');
		$response = $this->aud->readverifydetails($verifydetails);
		echo json_encode($response);
	}

	public function readauthdetails()
	{
		//$propid = $this->input->post('propid');
		$authdetails = $this->input->post('authdetails');
		$response = $this->aud->readauthdetails($authdetails);
		echo json_encode($response);
	}

	public function getalertscount()
	{
		//$propid = $this->input->post('propid');
		//$authsresultfilter = $this->input->post('authsresultfilter');

		$data['propid'] = $this->session->userdata('singlepropid');
		$data['userid'] = $this->session->userdata('userid');
		$data['cmpid'] = $this->session->userdata('cmpid');

		//$data['propid'] = 13;
		//$data['cmpid'] = 8;
		//$data['userid'] = 1;

		$response = $this->aud->getalertscount($data);
		echo json_encode($response);
	}

	// auth process

	public function authbtnprocess_verify()
	{
		//$propid = $this->input->post('propid');
		$cardvalue = $this->input->post('cardvalue');
		$authbtnmode = $this->input->post('authbtnmode');
		$response = $this->aud->authbtnprocess_verify($cardvalue, $authbtnmode);
		echo json_encode($response);
	}

	public function authbtnprocess_authorize()
	{
		//$propid = $this->input->post('propid');
		$cardvalue = $this->input->post('cardvalue');
		//echo "<pre>";
		//print_r($cardvalue);
		//echo "</pre>";
		$authbtnmode = $this->input->post('authbtnmode');
		$response = $this->aud->authbtnprocess_authorize($cardvalue, $authbtnmode);
		echo json_encode($response);
	}

	public function authbtnprocess_authorize_process()
	{
		$authdetails = $this->input->post('authdetails');
		echo "<pre>";
		print_r($authdetails);
		echo "</pre>";
		$authname = $this->input->post('authname');
		$authname = preg_replace('/\s+/', '', strtolower($authname));
		// echo "<pre>";
		// print_r($authname);
		// echo "</pre>";
		$authcalldata = $this->authcurlcalldetailsbuild($authdetails, $authname);
		echo "<pre>";
		print_r($authcalldata);
		echo "</pre>";

		//$response = $this->authcurlcallprocess($authcalldata);

		//echo json_encode($response);

	}

	public function authcurlcalldetailsbuild($authdetails, $authname)
	{
		//$authname = preg_replace('/\s+/', '', strtolower($authname));
		$calldetails = [];
		if ($authname == "discountrequest") {

			$callkeys = [];
			array_push($callkeys, "mainkey", "encryptval", "callurl", "checkinroomtrnid", "userid", "cusgstdetails", "propid", "areaid", "cmpid", "srvid", "prclamt", "printer", "discountmode", "discountpercent", "discountvalue", "discountreasonid");
			foreach ($callkeys as $callkey) {
				$callvalue = 0;
				if (array_key_exists($callkey, $authdetails)) {
					$callvalue = $authdetails[$callkey];
				}
				if ($callkey == "mainkey") {
					$calldetails["roomid"] = $calldetails["tbleid"] = $callvalue;
				} else if ($callkey == "discountreasonid") {
					$calldetails["disreasonid"] = $calldetails["disreason"] = $callvalue;
				} else if ($callkey == "cusgstdetails") {
					$calldetails["cusgstdetails"] = $calldetails["cusgstname"] = $calldetails["cusgstno"] = $calldetails["cusgstaddress"] = '';
					if ($callvalue && array_key_exists("cusgstname", $callvalue)) {
						$calldetails["cusgstname"] = $callvalue["cusgstname"];
						$calldetails["cusgstno"] = $callvalue["cusgstno"];
						$calldetails["cusgstaddress"] = $callvalue["cusgstaddress"];
					}
				} else if ($callkey == "discountmode") {
					$calldetails["distype"] = $calldetails["distyp"] = $callvalue;
				} else if ($callkey == "discountvalue") {
					$calldetails["disamt"] = $calldetails["disval"] = $callvalue;
				} else if ($callkey == "encryptval") {
					$calldetails["sky"] = $callvalue;
				} else {
					$calldetails[$callkey] = $callvalue;
				}
			}
			return $calldetails;
		} else if ($authname == "billreprint") {
			$callkeys = [];
			array_push($callkeys, "billid", "encryptval", "callurl");
			foreach ($callkeys as $callkey) {
				$callvalue = 0;
				if (array_key_exists($callkey, $authdetails)) {
					$callvalue = $authdetails[$callkey];
				}

				if ($callkey == "encryptval") {
					$calldetails["sky"] = $callvalue;
				} else {
					$calldetails[$callkey] = $callvalue;
				}
			}
			return $calldetails;
		} else if ($authname == "billcancel") {
			$callkeys = [];
			array_push($callkeys, "superuser", "areaid", "usersecgrpid", "propid", "userid", "cmpid", "billid", "encryptval", "callurl", "disreason");
			foreach ($callkeys as $callkey) {
				$callvalue = 0;
				if (array_key_exists($callkey, $authdetails)) {
					$callvalue = $authdetails[$callkey];
				}
				if ($callkey == "encryptval") {
					$calldetails["sky"] = $callvalue;
				} else if ($callkey == "disreason") {
					$calldetails["reason"] = $callvalue;
				} else {
					$calldetails[$callkey] = $callvalue;
				}
			}
			return $calldetails;
		} else if ($authname == "billdiscount") {
			$callkeys = [];
			array_push($callkeys, "oldbillid", "disreason", "disreasonid", "disval", "distype", "tbleid", "roomid", "encryptval", "callurl", "checkinroomtrnid", "userid", "propid", "areaid", "cmpid", "srvid", "prclamt", "printer", "discountpercent");
			foreach ($callkeys as $callkey) {
				$callvalue = 0;
				if (array_key_exists($callkey, $authdetails)) {
					$callvalue = $authdetails[$callkey];
				}
				if ($callkey == "encryptval") {
					$calldetails["sky"] = $callvalue;
				} else {
					$calldetails[$callkey] = $callvalue;
				}
			}
			return $calldetails;
		} else if ($authname == "netratealldate_fo") {				//done
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "foralldays", "checkpaxid", "applyrentincltax", "netrate", "rentincltaxstatus", "callurl");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			foralldays			= ____________(declr as 1 fopr all days netrate)
			checkpaxid			= ____________(declr as empty)
			applyrentincltax	= ____________(room rent or with ex. pax)
			netrate				= ____________(new net value)
			rentincltaxstatus	= ____________(inclusive or plus tax)*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "applydiscountalldate_fo") {				//done
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "foralldays", "checkpaxid", "discounttype", "discountrate", "callurl");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			foralldays			= ____________(declr as 1 fopr all days discount)
			checkpaxid			= ____________(declr as empty)
			discounttype		= ____________(declr type id as amount or prcent as 1 or 2)
			discountrate		= ____________(declr dis value)*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "requestcomplimentary_fo") {				//done
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "chargeid", "compreason", "callurl");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			chargeid			= ____________(pass as array )
			compreason			= ____________(pass int value )*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "paxchangealldate_fo") {				//done
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "chkinid", "chktrnid", "foralldays", "checkpaxid", "adultpax", "childpax", "freepax", "extrapax", "callurl", "modiarry");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			foralldays			= ____________(pass 1 )
			chkroomtype			= ____________(room type)
			adultpax				=____________(modfyed value )
			childpax			=____________(modfyed value )
			freepax				=____________(modfyed value )
			extrapax			=____________(modfyed value )
			noofpax				=____________(modfyed value )*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "paxchangeselectdate_fo") {				//done
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "chkinid", "chktrnid", "foralldays", "checkpaxid", "adultpax", "childpax", "freepax", "extrapax", "callurl", "modiarry");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			foralldays			= ____________(pass 0 )
			[modiarry] => [{"paxtrnid":"1701","roomtype":"1","chrgdate":"07-12-2021","adultpax":"2","childpax":"0","freepax":"0","extrapax":"0","chargepax":"2","noofpax":"2"}]
			[chkinid] => 162
			[chktrnid] => 238
			[roomtype] => 1
			[adultpax] => 2
			[childpax] => 0
			[freepax] => 0
			[extrapax] => 0
			[noofpax] => 2*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "netrateselectdate_fo") {				//done
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "foralldays", "checkpaxid", "applyrentincltax", "netrate", "rentincltaxstatus", "callurl");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			foralldays			= ____________(give empty)
			checkpaxid			= ____________(declr paxtrnid from check room pax)
			applyrentincltax	= ____________(room rent or with ex. pax)
			netrate				= ____________(new net value)
			rentincltaxstatus	= ____________(inclusive or plus tax)*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "changeaddress_fo") {				//done
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "billgstno", "billname", "billaddr", "netrate", "billnopax", "billhdrid", "callurl");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			billgstno			= ____________(pass gst no or empty )
			billname			= ____________(pass entr value )
			billcmpname			= ____________(pass entr value )
			billaddr			= ____________(pass entr value )
			billnopax			= ____________(pass entr value )
			billhdrid			= ____________(pass entr value )*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "cancelcharges_fo") {
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "roomchargeids", "callurl");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			roomchargeids		= ____________(pass multiple checkinrommcrgids seperted by comma)*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "canceladvance_fo") {
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "roomchargeids", "callurl");
			/*cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			roomchargeids		= ____________(pass multiple checkinrommcrgids seperted by comma)*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "changecheckindate_fo") {
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "checkindatetime", "callurl");
			/*
			cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			checkindatetime		= ____________(pass modified datetime)
			*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		} else if ($authname == "modifygracetime_fo") {
			$callkeys = [];
			array_push($callkeys, "cmpid", "propid", "userid", "encryptval", "checkintrnid", "checkinid", "checkindatetime", "gracemode", "chkingracetime", "chkoutgracetime", "callurl");
			/*
			cmpid				= ____________(common mantry)
			propid				= ____________(common mantry)
			userid				= ____________(common mantry)
			dbcon 				= ____________(common mantry)
			checkintrnid 		= ____________(common mantry)
			checkinid			= ____________(common mantry)
			gracemode			= ____________(pass 1 for cng ingracetym 0 for outgracetym)
			chkingracetime			= ____________(pass checkingracetime)
			chkoutgracetime			= ____________(pass checkoutgracetime)
			*/
			$calldetails = $this->buildauthcalldetails_fo($callkeys, $authdetails, $calldetails);
			return $calldetails;
		}
	}

	public function buildauthcalldetails_fo($callkeys, $authdetails, $calldetails)
	{
		//$calldetails = [];
		foreach ($callkeys as $callkey) {
			$callvalue = 0;
			if (array_key_exists($callkey, $authdetails)) {
				$callvalue = $authdetails[$callkey];
			}

			if ($callkey == "encryptval") {
				//$calldetails["dbcon"] = $callvalue;
				$callkey = "dbcon";
			}

			$calldetails[$callkey] = $callvalue;
		}
		return $calldetails;
	}

	public function authcurlcallprocess($authcalldata)
	{

		$result = [];

		$url = $authcalldata['callurl'];

		if ($url) {

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $authcalldata);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$dat = curl_exec($ch);

			if ($dat) {
				$result = json_decode($dat, true);
			} else {
				die("Curl failed: " . curl_error($ch));
			}
			curl_close($ch);
			return json_encode($result);
		} else {
			return json_encode($result);
		}
	}

	// auth process


	/*----------------------------------authsection----------------------------------*/
}
