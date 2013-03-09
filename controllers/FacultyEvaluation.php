<?php
class FacultyEvaluation extends MY_Controller{

		function FacultyEvaluation(){
			parent::__construct();
		}


		public function index()
		{
			$data['title'] = "FacultyEvaluation | E-Online";
			$data['userId'] = $this->session->userData('userId');
			$data['userName'] = $this->session->userData('userName');
			$this->layout->view('FacultyEvaluation/FacultyEvaluation_view', $data);
		}
		
		public function getFacultyEvaluation($value='')
		{
			$start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
			$fr_db = $this->config->item("fr_db");
			
	        $table = "tbl_faculty_evaluation_session a LEFT JOIN $fr_db.FILEADVI b ON a.faculty_id = b.ADVICODE LEFT JOIN tbl_question_set c ON a.question_set_id = c.id";
	        $fields = array("a.id","c.name as title","c.description","start_date", "end_date", "faculty_id", "b.ADVISER as faculty");
	        $db = 'exam';
			
	        $filter = "";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "a.dcreated DESC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				$filter = "(title LIKE '%$query%' OR description LIKE '%$query%' OR start_date LIKE '%$query%' OR end_date LIKE '%$query%' OR dcreated LIKE '%$query%')";
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

		function getStudents(){
        
	    $start=$this->input->post('start');
        $limit=$this->input->post('limit');
        $db = "ogs";
		$filter = "";


        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');
		
		$YEAR = $this->input->post('YEAR');
		$SECTIDNO = $this->input->post('SECTIDNO');

        $querystring = $this->input->post('query');
		
		if(!empty($YEAR) && strtolower($YEAR) != 'all year level')
            $filter = "YEAR = '$YEAR'";
		
		if(!empty($SECTIDNO)){	
			if(!empty($filter))
				$filter .= " AND SECTIDNO = '$SECTIDNO'";
			else
				$filter = "SECTIDNO = '$SECTIDNO'";
		}
		$group = "";
		$having = "";

        $query = array();

        if(!empty($querystring)){
		if(!empty($filter))
        	$filter .= " AND (STUDIDNO LIKE '%$querystring%' OR IDNO LIKE '%$querystring%' OR NAME LIKE '%$querystring%')";
		else
			$filter = "(STUDIDNO LIKE '%$querystring%' OR IDNO LIKE '%$querystring%' OR NAME LIKE '%$querystring%')";
		}
	

        if(empty($sort) && empty($dir)){
            $sort = "NAME ASC";
        }else{
        	$sort = "$sort $dir";
        }
		$fr_db = $this->config->item("fr_db");
		$default_db = $this->config->item("default_db");
        $records = array();
        $table = "COLLEGE";
        $fields = array("STUDCODE", "STUDIDNO", "NAME", "IDNO");
		
		

        $records = $this->lithefire->getAllRecords($db, $table, $fields, $start, $limit, $sort, $filter, $group, $having);
       // die($this->db->last_query());

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

		function addFacultyEvaluation(){
			$pdo = new PDO($this->config->item("EXAM_DSN"), $this->config->item("USER"), $this->config->item("PASS"));
			
	        $db = 'exam';
			$user = $this->session->userdata("userName");
	        $table = "tbl_faculty_evaluation_session";
			$post = $this->input->post();
			
			$s_date = date("Y-m-d H:i:s", strtotime($post['start_date']." ".$post['start_time']));
			$e_date = date("Y-m-d H:i:s", strtotime($post['end_date']." ".$post['end_time']));
			
			$input = array("question_set_id"=>$post['question_set_id'], "start_date"=>$s_date, "end_date"=>$e_date, "faculty_id"=>$post['faculty_id'], "created_by"=>$user);
	        $data = $this->lithefire->insertRow($db, $table, $input);
			
			$s = $this->input->post('students');
			$s = str_replace("\\", "", $s);
			$s = json_decode($s);
			
			$question_query = $pdo->prepare("SELECT id FROM tbl_question WHERE question_set_id = ?");
			$insert_query = $pdo->prepare("INSERT INTO tbl_faculty_evaluation_answers (evaluation_id, question_id, student_id) VALUES (?,?,?)");
			$question_query->execute(array($post['question_set_id']));
			
			$questions = $question_query->fetchAll();
			
			if(!empty($s->data)){
				foreach($s->data as $row):
					foreach($questions as $r):
							$insert_query->execute(array($data['id'], $r['id'], $row));
					endforeach;
				endforeach;
				
			}
			$pdo = null;
	        die(json_encode($data));
    	}

		function loadFacultyEvaluation(){
	        $db = "exam";
	        
	
	        $id=$this->input->post('id');
	        $table = "facultyevaluation";
			$param = "id";
	
	        $filter = "$param = '$id'";
	        $fields = array("id","description",);
	        $records = array();
	        $records = $this->lithefire->getRecordWhere($db, $table, $filter, $fields);
	
	        $temp = array();
	
	        foreach($records as $row):
	            $data["data"] = $row;
	        endforeach;
	        $data['success'] = true;
	
	        die(json_encode($data));
	    }

		function updateFacultyEvaluation(){
	        $db = 'exam';
	
	        $table = "facultyevaluation";
	        
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

		function deleteFacultyEvaluation(){
	        $table = "facultyevaluation";
	        $param = "id";
	       
			$db = "exam";
	        $id=$this->input->post('id');
			$filter = "$param = '$id'";
	
	        $data = $this->lithefire->deleteRow($db, $table, $filter);
	
	        die(json_encode($data));
	    }
		
		function getYearLevelCombo(){
        
	        $db = "fr";
	
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	        
			
			
	        if(empty($sort) && empty($dir)){
	        	if(!empty($sortby))
	            	$sort = "YEAR";
				else 
					$sort = "YEAR";
				
	        }else{
	        	$sort = "YEAR";
	        }
			
	        $records = array();
	        $table = "FILESTLE";
	        $fields = array("STLECODE as id", "YEAR as name");
	
	        $filter = "";
			$group = "";
			$having = "";
			
			if(!empty($query))
				$filter .= "(YEAR LIKE '%$query%')";
	
	        $records = $this->lithefire->getAllRecords($db, $table, $fields, $start, $limit, $sort, $filter, $group, $having);
	       // die($this->lithefire->currentQuery());
	
	
	        $temp = array();
	        $total = 0;
	        if($records){
	        	$temp[] = array("id"=>0, "name"=>"All Year Level");
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
		
		function getGenderCombo(){
        
	        $db = "fr";
	
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	        
			
			
	        if(empty($sort) && empty($dir)){
	        	if(!empty($sortby))
	            	$sort = "GENDER";
				else 
					$sort = "GENDER";
				
	        }else{
	        	$sort = "GENDER";
	        }
			
	        $records = array();
	        $table = "FILEGEND";
	        $fields = array("GENDIDNO as id", "GENDER as name");
	
	        $filter = "";
			$group = "";
			$having = "";
			
			if(!empty($query))
				$filter .= "(YEAR LIKE '%$query%')";
	
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
		
		function getSectionCombo(){
        
	        $db = "ogs";
	
	        $start=$this->input->post('start');
	        $limit=$this->input->post('limit');
			$year_level = $this->input->post('YEAR');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
			
	        if(empty($sort) && empty($dir)){
	            $sort = "SECTION";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
	        $records = array();
	        $table = "FILESECT";
	        $fields = array("SECTIDNO as id", "SECTION as name");
	
	        $filter = "ACTIVATED = 1";
			
			if($year_level && $year_level != "All Year Level")
				$filter .= " AND YEAR = '$year_level'";
			
			$group = "";
			$having = "";
			
			if(!empty($query))
				$filter .= " AND (SECTIDNO LIKE '%$query%' OR SECTION LIKE '%$query%')";
	
	        $records = $this->lithefire->getAllRecords($db, $table, $fields, $start, $limit, $sort, $filter, $group, $having);
	       // die($this->lithefire->currentQuery());
	
	
	        $temp = array();
	        $total = 0;
	        if($records){
	        	$temp[] = array("id"=>0, "name"=>"All Sections");
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

		function getSubjectCombo(){
        
	    $start=$this->input->post('start');
        $limit=$this->input->post('limit');
		$SECTIDNO = $this->input->post('SECTIDNO');
        $adviser_id = $this->session->userdata('userCode');

        $db = "ogs";


        $sort = $this->input->post('sort');
        $dir = $this->input->post('dir');
        $querystring = $this->input->post('query');
       // $ADVIIDNO = $this->input->post('ADVIIDNO');
		$filter = "";
		$group = "";
		$having = "";
		
		if($SECTIDNO)
            $filter="a.SECTIDNO = '$SECTIDNO'";
		
		if($this->session->userdata('userType') == "FACU"){
        if(empty($filter))
			$filter = "a.ADVIIDNO = '$adviser_id'";
		else
            $filter.=" AND a.ADVIIDNO = '$adviser_id'";
        }else{
        if(!empty($ADVIIDNO)){
		if(empty($filter))
			$filter = "a.ADVIIDNO = '$ADVIIDNO'";
		else
            $filter.=" AND a.ADVIIDNO = '$ADVIIDNO'";
		}
        }
        

        $query = array();

         if(!empty($querystring))
        $filter = "(a.SUBJCODE  LIKE '%$querystring%' OR   a.SCHEIDNO  LIKE '%$querystring%')";

        if(empty($sort) && empty($dir)){
            $sort = "SUBJCODE";
            
        }else{
        	$sort = "$sort $dir";
        }
		
		$fr_db = $this->config->item("fr_db");
		
		
       	$database = "";
        
        $records = array();
        $table = $database."FILESCHE a LEFT JOIN ".$fr_db.".FILESUBJ b ON a.SUBJIDNO = b.SUBJIDNO LEFT JOIN $fr_db.FILEADVI c ON a.ADVIIDNO = c.ADVIIDNO";
        $fields = array('a.SCHEIDNO', 'a.SUBJCODE', 'b.COURSEDESC', "b.UNITS_TTL", "c.ADVISER", "a.SECTIDNO", "a.COURIDNO");



        //$filter = "a.SUBJIDNO = b.SUBJIDNO AND a.DAYSIDNO = c.DAYSIDNO AND a.TIMEIDNO = d.TIMEIDNO";
        //$filter .= " AND a.SEMEIDNO = '$semester_id'";
        

        $records = $this->lithefire->getAllRecords($db, $table, $fields, $start, $limit, $sort, $filter, $group, $having);
       // die($this->db->last_query());


        $temp = array();
        $total = 0;
        if($records){
        foreach($records as $row):
			
			$section = $this->lithefire->getFieldWhere("ogs", $database."FILESECT", "SECTIDNO = '".$row['SECTIDNO']."'", "SECTION");
			$course = $this->lithefire->getFieldWhere("fr", "FILECOUR", "COURIDNO = '".$row['COURIDNO']."'", "COURSE");
			
            $tmp_row = array("id"=>$row['SCHEIDNO'], "name"=>$row['SUBJCODE']." (".$row['COURSEDESC'].")", 
            "description"=>$row['COURSEDESC'], 'UNITS_TTL'=>$row['UNITS_TTL'], "ADVISER"=>$row['ADVISER'], "SECTION"=>$section, "COURSE"=>$course);
            $temp[] = $tmp_row;
            $total++;

        endforeach;
        }
        $data['data'] = $temp;
        $data['success'] = true;
        $data['totalCount'] = $this->lithefire->countFilteredRows($db, $table, $filter, $group);
        die(json_encode($data));
    	}

		public function getQuestionSetCombo($value='')
		{
			$start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "tbl_question_set";
	        $fields = array("id", "name", "description");
	        $db = 'exam';
			
	        $filter = "";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "dcreated DESC";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				$filter = "(name LIKE '%$query%' OR description LIKE '%$query%')";
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

		public function getFacultyCombo($value='')
		{
			$start=$this->input->post('start');
	        $limit=$this->input->post('limit');
	
	        $sort = $this->input->post('sort');
	        $dir = $this->input->post('dir');
	        $query = $this->input->post('query');
	
	        $records = array();
	        $table = "FILEADVI";
	        $fields = array("ADVICODE as id", "ADVISER as name",);
	        $db = 'fr';
			
	        $filter = "";
	        $group = "";
			if(empty($sort) && empty($dir)){
	            $sort = "ADVISER";
	        }else{
	        	$sort = "$sort $dir";
	        }
			
			if(!empty($query)){
 				$filter = "(ADVISER LIKE '%$query%')";
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