<?php
class Tbl_faculty_evaluation_session extends MY_Controller{

		function Tbl_faculty_evaluation_session(){
			parent::__construct();
		}


		public function index()
		{
			$data['title'] = "Tbl_faculty_evaluation_session | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('Tbl_faculty_evaluation_session/Tbl_faculty_evaluation_session_view', $data);
		}

		function getTbl_faculty_evaluation_session(){
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "Tbl_faculty_evaluation_session";
	        $fields = array("id","question_set_id","title","description","start_date","end_date","section_id","faculty_id","dcreated","dmodified","created_by","modified_by",);
	        $db = 'exam';
	        $filter = "";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "id DESC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				"(id LIKE '%$query%' OR question_set_id LIKE '%$query%' OR title LIKE '%$query%' OR description LIKE '%$query%' OR start_date LIKE '%$query%' OR end_date LIKE '%$query%' OR section_id LIKE '%$query%' OR faculty_id LIKE '%$query%' OR dcreated LIKE '%$query%' OR dmodified LIKE '%$query%' OR created_by LIKE '%$query%' OR modified_by LIKE '%$query%')";
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

		function addTbl_faculty_evaluation_session(){
	        $db = 'exam';
	        $table = "Tbl_faculty_evaluation_session";
			$input = $this->input->post();
			
			/* uncomment for checking duplicates (change $fieldname)
			$fieldname = 'description';
	        if($this->lithefire->countFilteredRows($db, $table, "$fieldname = '".$this->input->post("$fieldname")."'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }*/
	        
	        //uncomment for FRs
			//$input['IDNO'] = $this->lithefire->getNextCharId($db, $table, 'IDNO', 5);
			
	        $data = $this->lithefire->insertRow($db, $table, $input);
	
	        die(json_encode($data));
    	}

		function loadTbl_faculty_evaluation_session(){
	        $db = "exam";
	        
	
	        $id=$this->input->post('id');
	        $table = "Tbl_faculty_evaluation_session";
			$param = "id";
	
	        $filter = "$param = '$id'";
	        $fields = array("id","question_set_id","title","description","start_date","end_date","section_id","faculty_id","dcreated","dmodified","created_by","modified_by",);
	        $records = array();
	        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);
	
	        $temp = array();
	
	        foreach($records as $row):
	            $data["data"] = $row;
	        endforeach;
	        $data['success'] = true;
	
	        die(json_encode($data));
	    }

		function updateTbl_faculty_evaluation_session(){
	        $db = 'exam';
	
	        $table = "Tbl_faculty_evaluation_session";
	        
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
			//check for duplicates (change $fieldname)
			$fieldname = 'description';
	        if($this->lithefire->countFilteredRows($db, $table, "$fieldname = '".$this->input->post("$fieldname")."' AND id != '$id'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }
	
	
	        $data = $this->lithefire->updateRow($db, $table, $input, $filter);
	
	
	        die(json_encode($data));
	    }

		function deleteTbl_faculty_evaluation_session(){
	        $table = "Tbl_faculty_evaluation_session";
	        $param = "id";
	       
			$db = "exam";
	        $id=$this->input->post('id');
			$filter = "$param = '$id'";
	
	        $data = $this->lithefire->deleteRow($db, $table, $filter);
	
	        die(json_encode($data));
	    }

}