<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alerts_controller extends CI_Controller {

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

        $this->load->model('Alertsmodel', 'amd');
	}

	/*----------------------------------alertsection----------------------------------*/
	public function alerts()
	{
		$data['propid'] = $this->input->get('propid');

		if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);

		$data['userid'] = $this->session->userdata('userid');
		$data['cmpid'] = $this->session->userdata('cmpid');

		//$data['propid'] = 13;
		//$data['cmpid'] = 1;
		//$data['userid'] = 1;
		$this->load->view('alerts/alerts',$data);	
	}
	public function getalertsresult()
	{
		$alertsresultfilter = $this->input->post('alertsresultfilter');

		$alertsresultfilter['userid'] = $this->session->userdata('userid');
		$alertsresultfilter['cmpid'] = $this->session->userdata('cmpid');

		/*$alertsresultfilter['cmpid'] = 1;
		$alertsresultfilter['userid'] = 1;*/
		$response = $this->amd->getalertsresult($alertsresultfilter);
        echo json_encode($response);	
	}
	public function alertsprocess()
	{
		$data['alertdatavals'] = $this->input->post('alertdatavals');
		$data['processmode'] = $this->input->post('processmode');
		$data['propid'] = $this->input->post('propid');

		$data['userid'] = $this->session->userdata('userid');
		$data['cmpid'] = $this->session->userdata('cmpid');


		//$data['cmpid'] = 1;
		//$data['userid'] = 1;
		
		//$data['propid'] = 13;
		$response = $this->amd->alertsprocess($data);
        echo json_encode($response);	
	}

	public function getauthcount()
	{
		//$propid = $this->input->post('propid');
		$authsresultfilter = $this->input->post('authsresultfilter');

		$data['propid'] = $this->session->userdata('singlepropid');
		$data['userid'] = $this->session->userdata('userid');
		$data['cmpid'] = $this->session->userdata('cmpid');

		//$data['propid'] = 13;
		//$data['cmpid'] = 8;
		//$data['userid'] = 1;

		$response = $this->amd->getauthcount($data);
        echo json_encode($response);	
	}
	/*----------------------------------alertsection----------------------------------*/
}
