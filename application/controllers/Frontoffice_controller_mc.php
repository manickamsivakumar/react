<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontoffice_controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(array("url", "form", "array"));
        $this->load->model("Frontoffice_model");
    }
  
    public function frontoffice()
    {

        // $data['data']=$this->Main_model->frontofficesales();
        $this->load->view('front_office/frontoffice');
    }
    public function frontoffice_sub_filter()
    {
        $fromdate = $this->input->post("fromdate");
        $todate = $this->input->post("todate");
        $filtervalue = $this->input->post("filtervalue");

        $data = $this->Frontoffice_model->frontofficesales($fromdate, $todate, $filtervalue);
        echo json_encode($data);
    }
}
