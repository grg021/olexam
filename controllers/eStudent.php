<?php

class eStudent extends CI_Controller{

		

		private $form, $user_code;

		private $mc_str = "mc_", $essay_str = "essay_";

		

		function eStudent(){

			parent::__construct();

			$this->load->helper('url');

	        $this->load->helper('form');

	        $this->load->database();

			$this->load->library('ion_auth');

			$this->load->library('session');

			$this->load->library('form_validation');

			$this->load->model('hmvc/lithefire_model','lithefire',TRUE);

			$this->load->model('hmvc/commonmodel','',TRUE);		

			$this->load->model('hmvc/faculty_model','',TRUE);

			$this->load->library('hmvc/layout', array('layout'=>$this->config->item('layout_file'))); 

			if (!$this->ion_auth->logged_in())

			{

				//redirect them to the login page

				redirect('login', 'refresh');

			}

			

			$this->user_code = $this->session->userData('code');

			

		}

		

		public function takeEvaluation()

		{

			

			$data['userId'] = $this->session->userData('userId');

			$data['userName'] = $this->session->userData('userName');

			$data['title'] = "Take Evaluation | E-Online";

			

			

			

			$this->layout->view("eStudent/take_evaluation_view", $data);

		}

		

		public function evaluation($question_set_id = null, $evaluation_id = null)

		{

			$data['userId'] = $this->session->userData('userId');

			$data['userName'] = $this->session->userData('userName');

			$data['title'] = "Take Evaluation | E-Online";

			$data['fields'] = $this->loadQuestions($question_set_id, $evaluation_id);

			$data['question_set_id'] = $question_set_id;

			$data['evaluation_id'] = $evaluation_id;

			

			

			$this->layout->view("eStudent/evaluation_view", $data);

		}

		

		public function getFacultyEvaluation($value='')

		{

			$start=$this->input->post('start');

	        $limit=$this->input->post('limit');

	

	        $sort = $this->input->post('sort');

	        $dir = $this->input->post('dir');

	        $query = $this->input->post('query');

			

			$STUDCODE = $this->session->userData('code');

	

	        $records = array();

			$fr_db = $this->config->item("fr_db");
			$ogs_db = $this->config->item("ogs_db");

	        $table = "tbl_faculty_evaluation_session a LEFT JOIN $fr_db.FILEADVI b ON a.faculty_id = b.ADVICODE LEFT JOIN tbl_question_set c ON a.question_set_id = c.id
	        LEFT JOIN $ogs_db.FILESCHE d ON a.SCHEIDNO = d.SCHEIDNO
	        LEFT JOIN $ogs_db.FILESUBJ e ON d.SUBJIDNO = e.SUBJIDNO
	        LEFT JOIN $fr_db.FILEDAYS f ON d.DAYSIDNO = f.DAYSIDNO
	        LEFT JOIN $fr_db.FILETIME g ON d.TIMEIDNO = g.TIMEIDNO
	        LEFT JOIN $fr_db.FILESEME h ON d.SEMEIDNO = h.SEMEIDNO";

	        $fields = array("a.id","c.name as title","c.description","start_date", "end_date", "faculty_id", "b.ADVISER as faculty", "a.question_set_id",
	        "CONCAT(e.SUBJCODE, ' ', '(',e.COURSEDESC,')') as subject", "CONCAT(f.DAYS, ' ', g.TIME) as schedule");

	        $db = 'exam';

			

	        $filter = "a.id in (SELECT evaluation_id FROM tbl_faculty_evaluation_answers WHERE student_id = '$STUDCODE' GROUP BY evaluation_id) AND h.IS_ACTIVE = '1'";

	        $group = "";

			if(empty($sort) && empty($dir)){

	            $sort = "a.dcreated DESC";

	        }else{

	        	$sort = "$sort $dir";

	        }

			

			if(!empty($query)){

 				$filter .= " AND (title LIKE '%$query%' OR description LIKE '%$query%' OR start_date LIKE '%$query%' OR end_date LIKE '%$query%' OR dcreated LIKE '%$query%')";

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

		

		public function loadQuestions($question_set_id, $evaluation_id)

		{

			$pdo = new PDO($this->config->item("EXAM_DSN"), $this->config->item("USER"), $this->config->item("PASS"));

			

			$output = "";

			

			$db = "exam";

			$table = "tbl_question";

			$filter = "question_set_id = '$question_set_id' ORDER BY order_position";

			$fields = array("id", "classification_id", "category_id", "description");

			$records = $this->lithefire->fetchAllRecords($db, $table, $filter, $fields);

			$choices_query = $pdo->prepare("SELECT id, description FROM tbl_question_choices where question_id = ? ORDER BY id DESC");

			

			if($records){

				$r = 0;

				$ctr = count($records);

				foreach($records as $row):

					//$output .= "{xtype: 'label', text: '".($r+1).". ".$row['description']."', cls: 'questionlabel'},";

					switch ($row['classification_id']):

						case 5:

							

							$output .= "{

					            xtype: 'radiogroup',

					            fieldLabel: '<span class=\"questionlabel\">".($r+1).". ".$row['description']."</span>',

					            columns: 5,

					            cls: 'radioOdd',

					            items: [";

					      			$choices_query->setFetchMode(PDO::FETCH_OBJ);

						            $choices_query->execute(array($row['id']));

									$choices = $choices_query->fetchAll();

									$r_choices = 0;

									$ctr_choices = count($choices);

									$class = "";

									foreach ($choices as $choice) {

										if($r_choices%2 != 0){

											$class = "columnOdd";

										}else{

											$class = "columnEven";

										}

										$output .= "{boxLabel: '".$choice->description."', name: 'mc_".$row['id']."', inputValue: ".$choice->id.", itemCls: '$class'}";

										$r_choices++;

							

										if($r_choices != $ctr_choices){

											$output.=",";

										}

									}

					      

					      	$output.="      ]

					        }";

							

						break;

						case 2:

							$output .= "{xtype: 'textarea', fieldLabel: '<span class=\"questionlabel\">".($r+1).". ".$row['description']."</span>', anchor: '95%', name: 'essay_".$row['id']."', id: '".$row['id']."', height: 170, style: 'marginLeft: 50px'}";

					endswitch;

					

					$r++;

							

					if($r != $ctr){

					    $output.=",";

					}

				endforeach;

			}

			$pdo = null;

			return $output;

		}

		

		public function saveEvaluation()

		{

			$pdo = new PDO($this->config->item("EXAM_DSN"), $this->config->item("USER"), $this->config->item("PASS"));

			

			$post = $this->input->post();

			//die($this->user_code);

			$update_mc_query = $pdo->prepare("UPDATE tbl_faculty_evaluation_answers SET answer = ? WHERE evaluation_id = ? AND question_id = ? AND student_id = ?");

			$update_essay_query = $pdo->prepare("UPDATE tbl_faculty_evaluation_answers SET answer_text = ? WHERE evaluation_id = ? AND question_id = ? AND student_id = ?");

			foreach($post as $key => $val):

				

				if(strrpos($key, $this->mc_str) !== false){

					$q_id = trim($key, $this->mc_str);

					//die($val." ".$post['evaluation_id']." ".$q_id);

					$update_mc_query->execute(array($val, $post['evaluation_id'], $q_id, $this->user_code));

				}elseif(strrpos($key, $this->essay_str) !== false){

					$q_id = trim($key, $this->essay_str);

					$update_essay_query->execute(array($val, $post['evaluation_id'], $q_id, $this->user_code));

				}

				

				

			endforeach;

			

			$pdo = null;

			

			$data['success'] = true;

			$data['data'] = "Data Successfully Saved";

			die(json_encode($data));

		}

		

		public function loadAnswers($value='')

		{

			$post = $this->input->post();

			

			$temp = array();

			

			$db = "exam";

			$table = "tbl_faculty_evaluation_answers";

			$filter = "evaluation_id = '".$post['evaluation_id']."' AND student_id = '".$this->user_code."'";

			$fields = array("id", "question_id", "answer", "answer_text");

			$records = $this->lithefire->fetchAllRecords($db, $table, $filter, $fields);

			

			if($records){

				foreach($records as $row):

					$classification_id = $this->lithefire->getFieldWhere($db, "tbl_question", "id = '".$row['question_id']."'", "classification_id");

					if($classification_id == 5){

						$temp[$this->mc_str.$row['question_id']] = $row['answer'];

					}elseif($classification_id == 2){

						$temp[$this->essay_str.$row['question_id']] = $row['answer_text'];

					}

				endforeach;

			}

			

			$data['data'] = $temp;

			$data['success'] = true;

			

			

			die(json_encode($data));

			

		}

}



?>