<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Exam extends CI_Controller{
	
    function index(){
        parent::__construct();
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->database();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('hmvc/lithefire_model','lithefire',TRUE);
		$this->load->library('hmvc/layout', array('layout'=>$this->config->item('layout_file'))); 
		$data['header'] = 'Header Section';
		$data['footer'] = 'Footer Section';
		$data['title'] = "Dashboard | E-Online";
		$data['userId'] = $this->session->userData('userId');
		$data['userName'] = $this->session->userData('userName');
		$this->layout->view('exams/exam_view', $data);  

    }

   
}
