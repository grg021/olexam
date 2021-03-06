<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ExamClassifications extends CI_Controller{
	
    function index(){
        parent::__construct();
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->database();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('hmvc/lithefire_model','lithefire',TRUE);
		$this->load->library('hmvc/layout', array('layout'=>$this->config->item('layout_file'))); 
		$data['header'] = 'Header Section';
		$data['footer'] = 'Footer Section';
		$data['title'] = "Dashboard | E-Online";
		$data['userId'] = $this->session->userData('userId');
		$data['userName'] = $this->session->userData('userName');
		$this->layout->view('exams/exam-classifications_view', $data);  

    }

    function getExamClassifications(){
        
        $this->load->model('lithefire_model','lithefire',TRUE);
        $start=$this->input->post('start');
        $limit=$this->input->post('limit');



        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');
        $query = $this->input->post('query');
        $queryby = "";



        $records = array();
        $table = "FILEEXCL";
        $fields = array("EXCLCODE", "EXCLIDNO", "description");

        $db = 'fr';
        $filter = "";
        $group = "";
		if(empty($sort) && empty($dir)){
            $sort = "EXCLCODE DESC";
        }else{
        	$sort = "$sort $dir";
        }
		
		if(!empty($query)){
            $filter = "(id LIKE '%$query%' OR code LIKE '%$query%' OR description LIKE '%$query%')";
        }
		 
		
		
		$records = $this->lithefire->getAllRecords($db, $table, $fields, $start, $limit, $sort, $filter, $group);

        $data['totalCount'] = $this->lithefire->countFilteredRows($db, $table, $filter, $group);

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
        die(json_encode($data));
    }
    

	function addExamClassification(){
		$this->load->model('lithefire_model','lithefire',TRUE);
        $db = 'fr';
        $table = "FILEEXCL";
		$input = $this->input->post();
		
        if($this->lithefire->countFilteredRows($db, $table, "EXCLIDNO = '".$this->input->post("EXCLIDNO")."' OR description = '".$this->input->post("description")."'", "")){
            $data['success'] = false;
            $data['data'] = "Record already exists";
            die(json_encode($data));
        }
        
        $data = $this->lithefire->insertRow($db, $table, $input);

        die(json_encode($data));
    }

    function loadExamClassification(){
        $this->load->model('lithefire_model','lithefire',TRUE);
        $db = "fr";
        

        $id=$this->input->post('id');
        $table = "FILEEXCL";
		$param = "EXCLIDNO";

        $filter = "$param = '$id'";
        $fields = array("EXCLCODE", "EXCLIDNO", "description");

        $records = array();
        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);

        $temp = array();

        foreach($records as $row):

            $data["data"] = $row;


        endforeach;
        $data['success'] = true;

        die(json_encode($data));
    }
    
    function updateExamClassification(){
        $this->load->model('lithefire_model', 'lithefire', TRUE);
        $db = 'fr';

        $table = "FILEEXCL";
        
       // $fields = $this->input->post();
		$param = "EXCLIDNO";
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

        if($this->lithefire->countFilteredRows($db, $table, "(EXCLIDNO = '".$this->input->post("EXCLIDNO")."' OR description = '".$this->input->post("description")."' ) AND EXCLIDNO != '$id'", "")){
            $data['success'] = false;
            $data['data'] = "Record already exists";
            die(json_encode($data));
        }


        $data = $this->lithefire->updateRow($db, $table, $input, $filter);


        die(json_encode($data));
    }

    function deleteExamClassification(){
        $this->load->model('lithefire_model', 'lithefire', TRUE);
        
        $table = "FILEEXCL";
        $param = "EXCLIDNO";
       // $fields = $this->input->post();
		$db = "fr";
        $id=$this->input->post('id');
		$filter = "$param = '$id'";
        $data = $this->lithefire->deleteRow($db, $table, $filter);

        die(json_encode($data));
    }
   
}
