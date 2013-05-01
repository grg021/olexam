<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Categories extends CI_Controller{
	/*
	function Exam(){
		parent::__construct();
		
	}
	*/
	function Categories(){
        parent::__construct();
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->database();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('hmvc/lithefire_model','lithefire',TRUE);
		$this->load->library('hmvc/layout', array('layout'=>$this->config->item('layout_file'))); 
    }
	
	function index(){
        
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('home/login', 'refresh');
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$data['header'] = 'Header Section';
            $data['footer'] = 'Footer Section';
			$data['title'] = "Dashboard | E-Online";
            $data['userId'] = $this->session->userData('userId');
            $data['userName'] = $this->session->userData('userName');

            
            $this->layout->view('exams/categories_view', $data);
            
		}
    }
	function getCategories(){
        
        $db = "default";

        $start=$this->input->post('start');
        $limit=$this->input->post('limit');
        
        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');
        $querystring = $this->input->post('query');
        $filter = "";
        $group = "";
        $logdb = $this->config->item("log_db");
        if(empty($sort) && empty($dir)){
            $sort = "id ASC";
        }else{
            $sort = "$sort $dir";
        }

        $fr_db = $this->config->item("fr_db");

        $records = array();
        $table = "question_categories";
		
        $fields = array("*");
        /*
        if(!empty($querystring))
            $filter = "(username LIKE '%$querystring%' OR login_time LIKE '%$querystring%')";
		*/
        $records = $this->lithefire->getAllRecords($db, $table, $fields, $start, $limit, $sort, $filter, $group);


        $temp = array();
        $total = 0;
        if($records){
        foreach($records as $row):
            $temp[] = $row;
            $total++;

        endforeach;
        }
        $data['data'] = $temp;
        $data['success'] = true;
        $data['totalCount'] = $this->lithefire->countFilteredRows($db, $table, $filter, "");
        die(json_encode($data));
    }

	function addCategory(){        
        $db = 'default';
        $table = "question_categories";
		
		$input = $this->input->post();
		
        if($this->lithefire->countFilteredRows($db, $table, "category = '".$this->input->post("category")."'", "")){
            $data['success'] = false;
            $data['data'] = "Record already exists";
            die(json_encode($data));
        }
        
        $data = $this->lithefire->insertRow($db, $table, $input);

        die(json_encode($data));
    }
	
	function loadCategory(){
        
        $db = "default";

        $id=$this->input->post('id');
		
		$fr_db = $this->config->item("fr_db");
		
        $table = "question_categories";
        $fields = array("*");
		$param = "id";

        $filter = "$param = '$id'";
        
        $records = array();
        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);

        $temp = array();

        foreach($records as $row):

            $data["data"] = $row;

        endforeach;
        $data['success'] = true;

        die(json_encode($data));
    }
	
	function updateCategory(){
        $db = 'default';

        $table = "question_categories";
        
		$param = "id";
        $id=$this->input->post('id');
        $filter = "$param = '$id'";

        $input = array();
        foreach($this->input->post() as $key => $val){
            if($key == 'id')
                continue;
            if(!empty($val)){
                $input[$key] = $val;
            }
        }

        if($this->lithefire->countFilteredRows($db, $table, "category = '".$this->input->post("category")."' AND id != '$id'", "")){
            $data['success'] = false;
            $data['data'] = "Record already exists";
            die(json_encode($data));
        }

        $data = $this->lithefire->updateRow($db, $table, $input, $filter);

        die(json_encode($data));
    }
	
	function deleteCategory(){
        
        $table = "question_categories";
        $param = "id";
       // $fields = $this->input->post();
		$db = "default";
        $id=$this->input->post('id');
		//$COURIDNO=$this->input->post('COURIDNO');
		$filter = "$param = $id";
		$this->lithefire->deleteRow($db, $table, "id = '$id'");
        $data = $this->lithefire->deleteRow($db, $table, $filter);

        die(json_encode($data));
    }
   
}