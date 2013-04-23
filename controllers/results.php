<?php
class results extends MY_Controller{

		function results(){
			parent::__construct();
			
		}


		public function index()
		{
			$data['title'] = "View Results | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('results/results_view', $data);
			
		}

		function getStudents(){
			
			$param = "a.evaluation_id";
	        $id=$this->input->post('evaluation_id');
	        $filter = "$param = '$id'";
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "tbl_faculty_evaluation_answers a JOIN lithefzj_ogs00004.COLLEGE b ON a.student_id = b.STUDCODE";
	        $fields = array("DISTINCT b.IDNO, b.NAME, b.STUDCODE");
	        $db = 'default';
	        //$filter = "";
	        $group = "a.student_id";
			if(empty($sort) && empty($dir)){
	            $sort = "b.NAME ASC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				"(NAME LIKE '%$query%')";
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
		
		function getQuestion(){
			
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
			
			$id=$this->input->post('selectedStudents');
			$param = "a.student_id";
			$temp2 = array();
	        if(empty($id))
	        	$filter = "$param IN ('')";
			else
	        	$filter = "$param IN ($id)";
			
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
			
			$s = $this->input->post('students');
			$s = str_replace("\\", "", $s);
			$s = json_decode($s); 
			 
	
	        $records = array();
	        $table = "tbl_faculty_evaluation_answers a LEFT JOIN tbl_question b ON a.question_id = b.id LEFT JOIN lithefzj_engine.FILEQUCL c ON b.classification_id = c.QUCLCODE LEFT JOIN lithefzj_engine.FILEQUCA d ON b.category_id = d.QUCACODE";
	        $fields = array("a.student_id, a.question_id, a.answer, a.answer_text, a.correct_flag, a.date_answered, b.description, c.DESCRIPTION AS classification, d.description AS category");
	        $db = 'default';
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "a.question_id ASC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				"(id LIKE '%$query%' description LIKE '%$query%')";
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


}