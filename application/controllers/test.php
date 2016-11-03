<?php
class Test extends MY_Controller{
	function __construct(){
		parent::__construct();
	}
	
// 	function test(){
// 		if(!$this->session->userdata('is_login')){
// 			echo site_url('/test/test');
// 			redirect('/auth/login?returnURL='.rawurlencode(site_url('/test/test')));
// 			//redirect('/auth/login?returnURL='.rawurlencode('http://localhost/project1/index.php/test/test'));
// 		}
// 		echo 'test';
// 		$this->load->view('test2');
// 	}
	
	function test(){
		$this->_head();
		$this->load->view('test');
	}
// 	function test(){
// // 		$this->load->view('js/test.js');
// 		echo strpos('test','e');
// 		echo '<br>';
// 		echo gettype(strpos('test','qwe'));
// 		echo '<br>';
// 		echo strpos('test','test');
// 		echo '<br>';
// 		echo strpos('test','s');
// 		echo '<br>';
		
// 		$result = strpos('test','qwe');
// 		if($result){ //false
// 			echo 'test';
// 		}else{
// 			echo 'test2';
// 		}
// 		//$this->load->view('test');
// 	}
	
// 	function test(){
// 		$this->load->model('callApiModel');
// 		$cmdArr = array (
// 				"command" => "addVolume",
// 				"apikey" => $_SESSION ['apikey'] 
// 		);
		
// 		$vms = $this->callApiModel->callCommandReponseJson( CallApiModel::NASURI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
// 		//var_dump($vms);
// 	}
}