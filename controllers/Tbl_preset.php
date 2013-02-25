<?php
class Tbl_preset extends MY_Controller{

		function Tbl_preset(){
			parent::__construct();
		}


		public function index()
		{
			$data['title'] = "Tbl_preset | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('Tbl_preset/Tbl_preset_view', $data);
		}

		function getTbl_preset(){
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "tbl_preset";
	        $fields = array("id","description");
	        $db = 'exam';
	        $filter = "";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "id DESC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				"(description LIKE '%$query%')";
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

		function addTbl_preset(){
	        $db = 'exam';
	        $table = "tbl_preset";
			$table2 = "tbl_preset_choices";
			$input = $this->input->post();
			
			$input['dcreated'] = date("Y-m-d H:i:s");
			$input['created_by'] = $this->session->userData("userName");
			
			//uncomment for checking duplicates (change $fieldname)
			$fieldname = 'description';
	        if($this->lithefire->countFilteredRows($db, $table, "description = '".$this->input->post("description")."'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }
	        
	        //uncomment for FRs
			$input['id'] = $this->lithefire->getNextCharId($db, $table, 'id', 5);
			
			$param = "id";
			$id = $this->input->post('id');
			
			$records = $this->lithefire->fetchAllRecords($db, "tbl_question_choices", "question_id = '$id'", array("description","correct_flag"));
			foreach($records as $row):
				$row['preset_id'] = $this->lithefire->getNextCharId($db, $table, 'preset_id', 5);
				$this->lithefire->insertRow($db, "tbl_preset_choices", $row);
			endforeach;
			
	        $data = $this->lithefire->insertRow($db, $table, $input);
	
	        die(json_encode($data));
    	}

		public function add($value='')
		{
			$db = 'exam';
	        $table = "tbl_preset";
			$input = $this->input->post();
			
			$input['dcreated'] = date("Y-m-d H:i:s");
			$input['created_by'] = $this->session->userData("userName");
			
			//uncomment for checking duplicates (change $fieldname)
			$fieldname = 'description';
	        if($this->lithefire->countFilteredRows($db, $table, "description = '".$this->input->post("description")."'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }
	        
			$data = $this->lithefire->insertRow($db, $table, $input);
			
			die(json_encode($data));
		}

		function loadTbl_preset(){
	        $db = "exam";
	        
	
	        $id=$this->input->post('id');
	        $table = "tbl_preset";
			$param = "id";
	
	        $filter = "$param = '$id'";
	        $fields = array("id","description");
	        $records = array();
	        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);
	
	        $temp = array();
	
	        foreach($records as $row):
	            $data["data"] = $row;
	        endforeach;
	        $data['success'] = true;
	
	        die(json_encode($data));
	    }

		function updateTbl_preset(){
	        $db = 'exam';
	        $table = "tbl_preset";
	        
	        $id=$this->input->post('id');
			$param = 'id';
			
	        $filter = "$param = '$id'";
	
	        $input = array();
	        foreach($this->input->post() as $key => $val){
	            if($key == $param)
	                continue;
	            if(!empty($val)){
	                $input[$key] = $val;
	            }
	        }
			
			$input['dmodified'] = date("Y-m-d H:i:s");
			$input['modified_by'] = $this->session->userData("userName");
			
			//check for duplicates (change $fieldname)
			$fieldname = 'description';
	        if($this->lithefire->countFilteredRows($db, $table, "$fieldname = '".$this->input->post("$fieldname")."' AND $param != '$id'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }
	
	
	        $data = $this->lithefire->updateRow($db, $table, $input, $filter);
	
	
	        die(json_encode($data));
	    }

		function deleteTbl_preset(){
	        $table = "tbl_preset";
	        $param = "id";
	       
			$db = "exam";
	        $id=$this->input->post('id');
			$filter = "$param = '$id'";
			$this->lithefire->deleteRow($db, "tbl_preset_choices", "preset_id = '$id'");
	        $data = $this->lithefire->deleteRow($db, $table, $filter);
	
	        die(json_encode($data));
	    }
	
		function selectTbl_preset(){
			$db = 'exam';
	        $table = "Tbl_question_choices";
			$input = $this->input->post();
			
			$id = $this->input->post('id');
			$id2 = $this->input->post('id2');
			$param = "question_id";
			$filter = "$param = '$id2'";
			
			$this->lithefire->deleteRow($db, $table, $filter);
			$records = $this->lithefire->fetchAllRecords($db, "tbl_preset_choices", "preset_id = '$id'", array("description","correct_flag"));
			foreach($records as $row):
				$row['question_id'] = $id2;
				$data = $this->lithefire->insertRow($db, $table, $row);
			endforeach;
			
			die(json_encode($data));
			
	        
			
		}
		
		function appendTbl_preset(){
			$db = 'exam';
	        $table = "Tbl_question_choices";
			$input = $this->input->post();
			
			$id = $this->input->post('id');
			$id2 = $this->input->post('id2');
			$param = "question_id";
			$filter = "$param = '$id2'";
			
			$records = $this->lithefire->fetchAllRecords($db, "tbl_preset_choices", "preset_id = '$id'", array("description","correct_flag"));
			foreach($records as $row):
				$row['question_id'] = $id2;
				$data = $this->lithefire->insertRow($db, $table, $row);
			endforeach;
			
			die(json_encode($data));
			
	        
			
		}

}