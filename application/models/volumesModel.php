<?php
// db에서 사용자의 클라우드 가져오기
/*
 * 해당 유저의 서버 정보 가져오기
 * 서칭기능
 * 볼륨이 붙여진 클라우드 가져오기
 *
 */
class VolumesModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' );
 
	}
	
	function getlistVolumes() { // 전체 VM들 가져오기
		$cmdArr = array (
				"command" => "listVolumes",
				"apikey" => $_SESSION ['apikey'] 
		);
		
		$volumes = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $volumes;
	}
	
	function searchVolume($volumeid){
		$cmdArr = array (
				"command" => "listVolumes",
				"id" => $volumeid,
				"apikey" => $_SESSION ['apikey']
		);
		
		$volume = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $volume;
	}
	
	
	function getVolumes($virtualmachineid){
		$cmdArr = array (
				"command" => "listVolumes",
				"virtualmachineid" => $virtualmachineid,
				"apikey" => $_SESSION ['apikey'] 
		);
		
		$volumes = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $volumes;
	}
	
	function getVolumesByCondition($condition, $value){
		$cmdArr = array (
				"command" => "listVolumes",
				$condition => $value,
				"apikey" => $_SESSION ['apikey']
		);
	
		$volumes = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
	
		return $volumes;
	}
	
	function attachVolume($id, $virtualmachineid){
		$cmdArr = array (
				"command" => "attachVolume",
				"id" => $id,
				"virtualmachineid" => $virtualmachineid,
				"apikey" => $_SESSION ['apikey']
		);
		
		$volumes = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $volumes;
	}
	
	function detachVolume($id){
		$cmdArr = array (
				"command" => "detachVolume",
				"id" => $id,
				"apikey" => $_SESSION ['apikey']
		);
	
		$volumes = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
	
		return $volumes;
	}
	
	function deleteVolume($id){
		$cmdArr = array (
				"command" => "deleteVolume",
				"id" => $id,
				"apikey" => $_SESSION ['apikey']
		);
	
		$volumes = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
	
		return $volumes;
	}
	 
}