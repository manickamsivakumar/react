<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pos_controller extends CI_Controller
{
    function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(array("url", "form", "array"));
        $this->load->model("Pos_model", "pos");
    }

    public function getposareasrvsettlevalues()
    {
        //var_dump($_POST);
        $postdetails = $this->input->post('postdetails');
        echo json_encode($this->pos->getposareasrvsettlevalues($postdetails));
        //echo json_encode($data);
    }
    public function getposareaitemsettlevalues()
    {
        //var_dump($_POST);
        $postdetails = $this->input->post('postdetails');
        echo json_encode($this->pos->getposareaitemsettlevalues($postdetails));
        //echo json_encode($data);
    }
    public function getposareaitemkotdetails()
    {
        //var_dump($_POST);
        $postdetails = $this->input->post('postdetails');
        echo json_encode($this->pos->getposareaitemkotdetails($postdetails));
        //echo json_encode($data);
    }
    public function getposareagroupkotdetails()
    {
        $postdetails = $this->input->post('postdetails');
        echo json_encode($this->pos->getposareagroupkotdetails($postdetails));
        //echo json_encode($data);
    }
}
