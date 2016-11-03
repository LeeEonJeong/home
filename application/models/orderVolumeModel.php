<?php
// db에서 사용자의 클라우드 가져오기
/*
 * 해당 유저의 서버 정보 가져오기
 * 서칭기능
 * 볼륨이 붙여진 클라우드 가져오기
 *
 */
class OrderVolumeModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' ); 
	} 
	
	function orderVolume(){
		$cmdArr = array (
				"command" => "createVolume",
				"name" => $_POST['diskname'],
				"zoneid" => $_POST['zoneid'],
				"diskofferingid" => $_POST['diskofferingid'],
				"usageplantype" => $_POST['usageplantype'],
				"apikey" => $_SESSION ['apikey']
		);  
		$result = $this->callApiModel->callCommand(CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) ); 
		
		return $result;  
	}
 
}