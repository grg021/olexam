<?php
class Tbl_preset_choices extends MY_Controller{

		function Tbl_preset_choices(){
			parent::__construct();
		}


		public function index()
		{
			$data['title'] = "Tbl_preset_choices | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('Tbl_preset_choices/Tbl_preset_choices_view', $data);
		}

		function getTbl_preset_choices(){
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
			$preset_id = $this->input->post("preset_id");
	        $table = "tbl_preset_choices b LEFT JOIN tbl_preset a ON a.id = b.preset_id";
	        $fields = array("b.id","b.preset_id","b.description","b.correct_flag");
	        $db = 'exam';
	        $filter = "a.id = '$preset_id'";
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

		function addTbl_preset_choices(){
	        $db = 'exam';
	        $table = "Tbl_preset_choices";
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

		function loadTbl_preset_choices(){
	        $db = "exam";
	        
	
	        $id=$this->input->post('id');
	        $table = "Tbl_preset_choices";
			$param = "id";
	
	        $filter = "$param = '$id'";
	        $fields = array("id","description","correct_flag",);
	        $records = array();
	        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);
	
	        $temp = array();
	
	        foreach($records as $row):
	            $data["data"] = $row;
	        endforeach;
	        $data['success'] = true;
	
	        die(json_encode($data));
	    }

		function updateTbl_preset_choices(){
	        $db = 'exam';
	
	        $table = "Tbl_preset_choices";
	        
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

		function deleteTbl_preset_choices(){
	        $table = "Tbl_preset_choices";
	        $param = "id";
	       
			$db = "exam";
	        $id=$this->input->post('id');
			$filter = "$param = '$id'";
	
	        $data = $this->lithefire->deleteRow($db, $table, $filter);
	
	        die(json_encode($data));
	    }

}