<?php
class Question extends MY_Controller{

		function Question(){
			parent::__construct();
		}


		public function index()
		{
			$data['title'] = "Question | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('Question/Question_view', $data);
		}

		function getQuestion(){
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "Question a LEFT JOIN tbl_question_classification b ON a.classification_id = b.id";
			$exam_id = $this->input->post("exam_id");
	        $fields = array("a.id","b.description as classification","a.description");
	        $db = 'exam';
	        $filter = "a.exam_id = '$exam_id'";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "a.id DESC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				"(id LIKE '%$query%' OR a.exam_id LIKE '%$query%' OR b.description LIKE '%$query%' OR a.description LIKE '%$query%')";
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

		function addQuestion(){
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

		function loadQuestion(){
	        $db = "exam";
	        
	
	        $id=$this->input->post('id');
	        $table = "Question";
			$param = "id";
	
	        $filter = "$param = '$id'";
	        $fields = array("id","exam_id","classification_id","description","dcreated","dmodified","createdby","modifiedby",);
	        $records = array();
	        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);
	
	        $temp = array();
	
	        foreach($records as $row):
	            $data["data"] = $row;
	        endforeach;
	        $data['success'] = true;
	
	        die(json_encode($data));
	    }

		function updateQuestion(){
	        $db = 'exam';
	
	        $table = "Question";
	        
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

		function deleteQuestion(){
	        $table = "Question";
	        $param = "id";
	       
			$db = "exam";
	        $id=$this->input->post('id');
			$filter = "$param = '$id'";
	
	        $data = $this->lithefire->deleteRow($db, $table, $filter);
	
	        die(json_encode($data));
	    }
		
		function getClassificationCombo(){
        
        $db = "exam";

        $start=$this->input->post('start');
        $limit=$this->input->post('limit');
        //$db = "fr";


        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');
        $query = $this->input->post('query');
        
		
		
        if(empty($sort) && empty($dir)){
        	if(!empty($sortby))
            	$sort = "id";
			else 
				$sort = "id";
			
        }else{
        	$sort = "id";
        }
		
        $records = array();
        $table = "tbl_question_classification";
        $fields = array("id as id", "description as name");

        $filter = "";
		$group = "";
		$having = "";
		
		if(!empty($query))
			$filter .= " AND ($id LIKE '%$query%' OR $name LIKE '%$query%')";

        $records = $this->lithefire->getAllRecords($db, $table, $fields, $start, $limit, $sort, $filter, $group, $having);
       // die($this->lithefire->currentQuery());


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
        $data['totalCount'] = $this->lithefire->countFilteredRows($db, $table, $filter, $group);
        die(json_encode($data));
    }

}