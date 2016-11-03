<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class AsyncProcess extends MY_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model('asyncProcessModel');
		}
		
		function index(){
			echo '비동기처리 controller의 index 함수입니다.';
		}
		
		function queryAsyncJobResult($jobid){
			$this->_require_login('/');
			$result = $this->asyncProcessModel->queryAsyncJobResult($jobid); 
			print(json_encode($result));
		}
		 
	}