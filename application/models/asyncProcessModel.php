<?php
class AsyncProcessModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' ); 
	}
	
	function queryAsyncJobResult($jobid) {
		do {
			$cmdArr = array(
					"command" => "queryAsyncJobResult",
					"jobid" => $jobid,
					"apikey" => $_SESSION ['apikey']
			);
			
			$result = $this->callApiModel->callCommand(CallApiModel::URI, $cmdArr, $_SESSION['secretkey']);
			if($result == null){
				return 'error';
			}
			sleep(2);
			$jobStatus = $result["jobstatus"];
			if ($jobStatus == 2) { //실패
				printf($result["jobresult"]);
				exit; 
				return $result;
			}
		} while ($jobStatus != 1);
		
		return $result;
	}
	 
}