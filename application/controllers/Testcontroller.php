
<?php



class Testcontroller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library("session");

        $this->load->database();
        $this->load->helper(array('form', 'url', 'array'));
        date_default_timezone_set("Asia/Kolkata");


        $this->load->model('Testmodel');
    }
    public function index()
    {

        $this->load->view("home");
    }
    public function getdata()
    {
        // echo "hello world!";
        $data = $this->Testmodel->getdata();
        echo  json_encode($data);
    }
}

?>