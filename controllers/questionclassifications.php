<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class QuestionClassifications extends CI_Controller{
	
    function QuestionClassifications(){
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
	
	public function index($value='')
	{
		$data['title'] = "Question Classification | E-Online";
		$data['userId'] = $this->session->userData('userId');
		$data['userName'] = $this->session->userData('userName');
		$this->layout->view('exams/question-classfications_view', $data);
	}

    function getQuestionClassifications(){
        
        $start=$this->input->post('start');
        $limit=$this->input->post('limit');



        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');
        $query = $this->input->post('query');
        $queryby = "";



        $records = array();
        $table = "FILEQUCL";
        $fields = array("QUCLCODE", "QUCLIDNO", "description");

        $db = 'fr';
        $filter = "";
        $group = "";
		if(empty($sort) && empty($dir)){
            $sort = "QUCLIDNO";
        }else{
        	$sort = "$sort $dir";
        }
		
		if(!empty($query)){
            $filter = "(QUCLIDNO LIKE '%$query%' OR QUCLCODE LIKE '%$query%' OR description LIKE '%$query%')";
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
    

	function addQuestionClassification(){
		$this->load->model('lithefire_model','lithefire',TRUE);
        $db = 'fr';
        $table = "FILEQUCL";
		$input = $this->input->post();
		
        if($this->lithefire->countFilteredRows($db, $table, "description = '".$this->input->post("description")."'", "")){
            $data['success'] = false;
            $data['data'] = "Record already exists";
            die(json_encode($data));
        }
        
		$input['QUCLIDNO'] = $this-> lithefire->getNextCharId($db, $table, 'QUCLIDNO', 5);
        $data = $this->lithefire->insertRow($db, $table, $input);

        die(json_encode($data));
    }

    function loadQuestionClassification(){
        $this->load->model('lithefire_model','lithefire',TRUE);
        $db = "fr";
        

        $id=$this->input->post('id');
        $table = "FILEQUCL";
		$param = "QUCLIDNO";

        $filter = "$param = '$id'";
        $fields = array("QUCLIDNO", "QUCLCODE", "description");

        $records = array();
        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);

        $temp = array();

        foreach($records as $row):

            $data["data"] = $row;


        endforeach;
        $data['success'] = true;

        die(json_encode($data));
    }
    
    function updateQuestionClassification(){
        $this->load->model('lithefire_model', 'lithefire', TRUE);
        $db = 'fr';

        $table = "FILEQUCL";
        
       // $fields = $this->input->post();
		$param = "QUCLIDNO";
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

        if($this->lithefire->countFilteredRows($db, $table, "description = '".$this->input->post("description")."' AND QUCLIDNO != '$id'", "")){
            $data['success'] = false;
            $data['data'] = "Record already exists";
            die(json_encode($data));
        }


        $data = $this->lithefire->updateRow($db, $table, $input, $filter);


        die(json_encode($data));
    }

    function deleteQuestionClassification(){
        $this->load->model('lithefire_model', 'lithefire', TRUE);
        

        $table = "FILEQUCL";
        $param = "QUCLIDNO";
       // $fields = $this->input->post();
		$db = "fr";
        $id=$this->input->post('id');
		$filter = "$param = '$id'";

        $data = $this->lithefire->deleteRow($db, $table, $filter);

        die(json_encode($data));
    }
   
}
