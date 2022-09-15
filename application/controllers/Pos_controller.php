<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_controller extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('form', 'url', 'array'));
        $this->load->model('Pos_model','pos');

    }
    



    

    public function food_beverages_sales()
	{
        $data['propid']=$this->input->get('propid');

       // echo '<pre>';
      //  var_dump($this->input->get('i'));
        
      //  echo '</pre>';

       
       
    
        if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
		$this->load->view('food_beverages/sales',$data);
	}
	public function food_beverages_items()
	{

        $data['propid']=$this->input->get('propid');

       /* if($this->input->get('i')==0)
        {
        // var_dump('a');
            $data['i']=$this->input->get('i');
            $data['m']=3;
        }
        else
        {
          // var_dump('b');
            if($this->input->get('m'))
            {
                $data['m']=$this->input->get('m');
            }
            else
            {
                $data['m']=0;
            }
        }*/
       
       
    
        if($this->session->has_userdata('singlepropid'))
		{
			$this->session->unset_userdata('singlepropid');
		}
		$this->session->set_userdata('singlepropid', $data['propid']);
       // $data['arealist']= $this->pos->get_all_pos_item_datas($fromdate='',$todate='', $data['propid']);

       // echo '<pre>';
      //  print_r($data);
      //  echo '</pre>';
		$this->load->view('food_beverages/items',$data);
	}
	
    public function get_pos_sales_datas()
    {
         $fromdate = $this->input->post('fromdate');
		 $todate = $this->input->post('todate');
         $propid = $this->input->post('propid');

        // echo $propid;
        // return;
	
        $data = $this->pos->get_all_pos_sales_datas($fromdate,$todate,$propid);
        echo json_encode($data);



    }

    public function get_pos_item_datas()
    {
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $propid = $this->input->post('propid');
        $areaid = $this->input->post('areaid');

        
        $data = $this->pos->get_all_pos_item_datas($fromdate,$todate,$propid,$areaid);
        echo json_encode($data);



    }
    public function get_pos_arealist()
    {

        $propid = $this->input->post('propid');
              
        $data = $this->pos->get_pos_area_list($propid);
        echo json_encode($data);



    }
    public function data_table()
    {

      $this->load->view('food_beverages/datatable');

    }




}