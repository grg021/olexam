<?php
class FILEQUCA extends MY_Controller{

		function FILEQUCA(){
			parent::__construct();
		}


		public function index()
		{
			$data['title'] = "FILEQUCA | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('FILEQUCA/FILEQUCA_view', $data);
		}

		function getFILEQUCA(){
        
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "FILEQUCA";
	        $fields = array("QUCACODE","QUCAIDNO","DESCRIPTION","ORDER","DCREATED","TCREATED","DMODIFIED","TMODIFIED",);
	        $db = 'fr';
	        $filter = "";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "QUCACODE DESC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				"(QUCACODE LIKE '%$query%' OR QUCAIDNO LIKE '%$query%' OR DESCRIPTION LIKE '%$query%' OR ORDER LIKE '%$query%' OR DCREATED LIKE '%$query%' OR TCREATED LIKE '%$query%' OR DMODIFIED LIKE '%$query%' OR TMODIFIED LIKE '%$query%')";
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

		function addFILEQUCA(){
	        $db = 'fr';
	        $table = "FILEQUCA";
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

		function loadFILEQUCA(){
	        $db = "fr";
	        
	
	        $id=$this->input->post('id');
	        $table = "FILEQUCA";
			$param = "QUCACODE";
	
	        $filter = "$param = '$id'";
	        $fields = array("QUCACODE","QUCAIDNO","DESCRIPTION","ORDER","DCREATED","TCREATED","DMODIFIED","TMODIFIED",);
	        $records = array();
	        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);
	
	        $temp = array();
	
	        foreach($records as $row):
	            $data["data"] = $row;
	        endforeach;
	        $data['success'] = true;
	
	        die(json_encode($data));
	    }

		function updateFILEQUCA(){
	        $db = 'fr';
	
	        $table = "FILEQUCA";
	        
			$param = "QUCACODE";
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
	        if($this->lithefire->countFilteredRows($db, $table, "$fieldname = '".$this->input->post("$fieldname")."' AND QUCACODE != '$id'", "")){
	            $data['success'] = false;
	            $data['data'] = "Record already exists";
	            die(json_encode($data));
	        }
	
	
	        $data = $this->lithefire->updateRow($db, $table, $input, $filter);
	
	
	        die(json_encode($data));
	    }

		function deleteFILEQUCA(){
	        $table = "FILEQUCA";
	        $param = "QUCACODE";
	       
			$db = "fr";
	        $id=$this->input->post('id');
			$filter = "$param = '$id'";
	
	        $data = $this->lithefire->deleteRow($db, $table, $filter);
	
	        die(json_encode($data));
	    }

}