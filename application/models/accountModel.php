<?php
class AccountModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' ); 
	}
	
	function getlistAccounts($jobid) { 
		$cmdArr = array(
				"command" => "listAccounts", 
				"apikey" => $_SESSION ['apikey']
		);
		
		$result = $this->callApiModel->callCommand(CallApiModel::URI, $cmdArr, $_SESSION['secretkey']); 
		return $result;
	}
	
	
	 
}