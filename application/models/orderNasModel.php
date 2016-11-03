<?php
 
class OrderNasModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' ); 
	}
	 
	function addVolume() {
		$cmdArr = array (
						"command" => "addVolume",
						"name" => $_POST['name'],
						"usageplantype" =>$_POST['usageplantype'],
						"path" =>$_POST['path'],
						"totalsize" => $_POST['totalsize'],
						"volumetype" => $_POST['volumetype'],
						"zoneid" => $_POST['zoneid'],
						"apikey" => $_SESSION ['apikey']
				);//autoresize=false&usageplantype=monthly
		
		if($_POST['volumetype'] == 'cifs'){
			$this->load->model('cifsAccountModel');
			$this->cifsAccountModel->checkCreateCIFSAccountForFirst();
		}
// 		if($_POST['usageplantype'])
		
// 		$cmdArr = array (
// 				"command" => "addVolume",
// 				"name" => 'test',
// 				"usageplantype" =>'test',
// 				"path" =>'test',
// 				"totalsize" => 'test',
// 				"volumetype" => 'test',
// 				"zoneid" => 'test',
// 				"apikey" => $_SESSION ['apikey']
// 		);//autoresize=false&usageplantype=monthly
		
		$result = $this->callApiModel->callCommand( CallApiModel::NASURI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	} 
	 
}