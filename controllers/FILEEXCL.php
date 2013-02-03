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
		
}