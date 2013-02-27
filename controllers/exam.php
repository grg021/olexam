<?php
class exam extends MY_Controller{

		function exam(){
			parent::__construct();
			
		}


		public function index()
		{
			$data['title'] = "exam | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('exam/exam_view', $data);
			
		}

		function getExam(){
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "tbl_question_set";
	        $fields = array("id","name","description","timePerQuestion");
	        $db = 'default';
	        $filter = "";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "id ASC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				"(id LIKE '%$query%' OR name LIKE '%$query%' OR description LIKE '%$query%' OR timePerQuestion LIKE '%$query%')";
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

		function addExam(){
	        $db = 'default';
	        $table = 'tbl_question_set';
			$input = $this->input->post();
			
			$input['dcreated'] = date("Y-m-d H:i:s");
			$input['createdby'] = $this->session->userData("userName");
			
			//uncomment for checking duplicates (change $fieldname)
			$fieldname = 'description';
	        if($this->lithefire->countFilteredRows($db, $table, "name = '".$this->input->post("name")."'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }
	        
	        //uncomment for FRs
			//$input['IDNO'] = $this->lithefire->getNextCharId($db, $table, 'IDNO', 5);
			
	        $data = $this->lithefire->insertRow($db, $table, $input);
	
	        die(json_encode($data));
    	}

		function loadExam(){
	        $db = "default";
	        
	        $id=$this->input->post('id');
	        $table = "tbl_question_set";
			$param = "id";
	
	        $filter = "$param = '$id'";
	        $fields = array("*");
	        $records = array();
	        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);
	
	        $temp = array();
	
	        foreach($records as $row):
	            $data["data"] = $row;
	        endforeach;
	        $data['success'] = true;
	
	        die(json_encode($data));
	    }

		function updateExam(){
	        $db = 'default';
	
	        $table = "tbl_question_set";
			
			$param = "id";
	        $id=$this->input->post('id');
	        $filter = "$param = '$id'";
	
	        $input = array();
	        foreach($this->input->post() as $key => $val){
	            if($key == 'id')
	                continue;
	            if(isset($val) || !empty($val)){
	                $input[$key] = $val;
	            }
	        }
			
	        $input['dmodified'] = date("Y-m-d H:i:s");
			$input['modifiedby'] = $this->session->userData("userName");
			
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

		function deleteExam(){
	        $table = "tbl_question_set";
			$table2 = "tbl_question";
	        $param = "id";
	       
			$db = 'default';
	        $id=$this->input->post('id');
			$filter = "$param = '$id'";
			$records = $this->lithefire->fetchAllRecords($db, $table2, "question_set_id = '$id'", array("id"));
			if($records){
			foreach($records as $row):
				$this->lithefire->deleteRow($db, "tbl_question_choices", "question_id = '".$row['id']."'");
			endforeach;
			}
			$this->lithefire->deleteRow($db, $table2, "question_set_id = '$id'");
	        $data = $this->lithefire->deleteRow($db, $table, $filter);
			
	
	        die(json_encode($data));
	    }
		
		function getquestion(){
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
			$id=$this->input->post('id');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "question ";
	        $fields = array("id","classification_id","description");
	        $db = 'default';
	        $filter = "exam_id = '$id'";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "id DESC";
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

		function addquestion(){
	        $db = 'default';
	        $table = 'question';
			$post = $this->input->post();
			$id=$this->input->post('id');
			
			$input = $post;
			unset($input['id']);
			$input['dcreated'] = date("Y-m-d H:i:s");
			$input['createdby'] = $this->session->userData("userName");
			$input['exam_id'] = $id;
			
			
			// uncomment for checking duplicates (change $fieldname)
			$fieldname = 'description';
	        if($this->lithefire->countFilteredRows($db, $table, "$fieldname = '".$this->input->post("$fieldname")."' and exam_id = '$id'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }
	        
	        //uncomment for FRs
			//$input['IDNO'] = $this->lithefire->getNextCharId($db, $table, 'IDNO', 5);
			
	        $data = $this->lithefire->insertRow($db, $table, $input);
	
	        die(json_encode($data));
    	}

}