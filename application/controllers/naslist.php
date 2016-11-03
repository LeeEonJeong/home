<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	 
	class Naslist extends MY_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model('nasModel');
		}
		
		function index(){
			$this->_head();
			$returnURI = '/naslist'; // 일단임의로 나중에 returnURI 다시 처리하자
			$this->_require_login($returnURI);
			
			$result = $this->getRunningVolumes();
			$nasCount = $result['count'];
			
			if($nasCount == 0){
				echo "<script>alert('nas가 없습니다.')</script>";
				$naslistdata = array(
					'nasVolumes' => array(),
					'nasvolumeCount' => $nasCount
				);
			}else{
				//$nasvolumes = $this->getRunningVolumes()['response']; 
				$nasvolumes = $result['response'];
				$this->load->model('networksModel');
				
				for($i=0; $i<$nasCount; $i++){
					if($nasCount == 1){
						$nasVolume = $nasvolumes;
					}else{
						$nasVolume = $nasvolumes[$i];
					}
					
					$zonename = $this->networksModel->getZonename($nasVolume['zoneid']); 
					if($nasCount == 1){
						$nasvolumes['zonename'] = $zonename;
					}else{
						$nasvolumes[$i]['zonename'] = $zonename;
					}			
				}			 
				 
				$naslistdata = array(
						'nasVolumes' => $nasvolumes,
						'nasvolumeCount' => $nasCount
				);
			}
		
			$this->load->view('naslist', $naslistdata); 
		 	$this->load->view('nasManageMenu');
		    $this->load->view('nasInfo');
			$this->_footer();
		}
		
		function orderNas(){
			$this->_head();
			$this->load->view('orderNas');
			$this->_footer();
		} 
		
		function  deleteVolume($volumeid) {
			$result = $this->nasModel->deleteVolume($volumeid);
			print(json_encode($result));
		}
		 
		//networkid : listVolumes 하면 나옴
		function addNicToVirtualMachine($networkid, $virtualmachineid){//비동기
			$result = $this->nasModel->addNicToVirtualMachine($networkid, $virtualmachineid);
			print(json_encode($result));
		}
		
		//nicid : listVirtualMachines (NAS연결 시)
		function removeNicFromVirtualMachine($nicid, $virtualmachineid){//비동기
			$result = $this->nasModel->removeNicFromVirtualMachine($nicid, $virtualmachineid);
			print(json_encode($result));
		}
		
		function getlistVolumes(){
			$result = $this->nasModel->getlistVolumes();
			print(json_encode($result));
		}
		
		function getRunningVolumes(){
// 			$result = $this->nasModel->getVolumes('status', 'online');
// 			print(json_encode($result));
			return $this->nasModel->getVolumes('status', 'online');
		}
		
		function searchNas($nasid){
			$result = $this->nasModel->getVolumes('id', $nasid);
			print(json_encode($result));
		}
// 		function getRunningVolumeZones(){
// 			$result = $this->nasModel->getRunningVolumeZones();
// 			print(json_encode($result));
// 		}
	}