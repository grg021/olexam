<?php
class FILEEXCL extends MY_Controller{

		function FILEEXCL(){
			parent::__construct();
		}


		public function index()
		{
			$data['title'] = "FILEEXCL | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('FILEEXCL/FILEEXCL_view', $data);
		}

		function getFILEEXCL(){
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "FILEEXCL";
	        $fields = array("EXCLCODE","EXCLIDNO","description",);
	        $db = 'fr';
	        $filter = "";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "EXCLCODE DESC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				"(EXCLCODE LIKE '%$query%' OR EXCLIDNO LIKE '%$query%' OR description LIKE '%$query%')";
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

		function addFILEEXCL(){
	        $db = 'fr';
	        $table = "FILEEXCL";
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

		function loadFILEEXCL(){
	        $db = "fr";
	        
	
	        $id=$this->input->post('id');
	        $table = "FILEEXCL";
			$param = "EXCLCODE";
	
	        $filter = "$param = '$id'";
	        $fields = array("EXCLCODE","EXCLIDNO","description",);
	        $records = array();
	        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);
	
	        $temp = array();
	
	        foreach($records as $row):
	            $data["data"] = $row;
	        endforeach;
	        $data['success'] = true;
	
	        die(json_encode($data));
	    }

		function updateFILEEXCL(){
	        $db = 'fr';
	
	        $table = "FILEEXCL";
	        
			$param = "EXCLCODE";
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
	        if($this->lithefire->countFilteredRows($db, $table, "$fieldname = '".$this->input->post("$fieldname")."' AND EXCLCODE != '$id'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }
	
	
	        $data = $this->lithefire->updateRow($db, $table, $input, $filter);
	
	
	        die(json_encode($data));
	    }

		function deleteFILEEXCL(){
	        $table = "FILEEXCL";
	        $param = "EXCLCODE";
	       
			$db = "fr";
	        $id=$this->input->post('id');
			$filter = "$param = '$id'";
	
	        $data = $this->lithefire->deleteRow($db, $table, $filter);
	
	        die(json_encode($data));
	    }

}