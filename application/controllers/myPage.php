<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class MyPage extends MY_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model('accountModel');
		}
		
		function index(){
			$this->_head();
			$returnURI = '/myPage'; // 일단임의로 나중에 returnURI 다시 처리하자
			$this->_require_login($returnURI);
			
			$accounts = $this->accountModel->getlistAccounts();
			$accountCount = $vms['count'];
				
			$accountlist = array( //새로 생성한 VM 비밀번호 확인
					'accounts' => $accounts,
					'accountCount' => $accountCount
			);
			
			$this->load->view('myPage',$accountlist);
		 	
			$this->_footer();
		}  
	}