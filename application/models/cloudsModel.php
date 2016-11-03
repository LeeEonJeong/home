<?php

class CloudsModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' );
 
	}
	
	function getlistVMs() { // 전체 VM들 가져오기
		$cmdArr = array (
				"command" => "listVirtualMachines",
				"apikey" => $_SESSION ['apikey'] 
		);
		
		$vms = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $vms;
	}
	 
	//서버다들고오는게 아니라 NIC가 있는 네트워크(존)에 있는 서버들만 가져와야함... 이라 생각함 근데 
	//올레콘솔은 NIC이랑 연결되어 있는 VM들고온다.
	function getVMsForNAS(){
		$result = $this->getlistVMs();
		$vms = $result['virtualmachine'];
		$count = $result['count'];
		for($i=0; $i<$count; $i++){
			$vmForNAS=array();
			
			if($count == 1){
				$vm = $vms;
			}else{
				$vm = $vms[$i];
			}
			
			$vmForNAS['vmid'] = $vm['id'];
			$vmForNAS['useNas'] = $this->isUseNAS($vm);
				
			if($vmForNAS['useNas']){ //nas를 가지고 있으면 nicid를 넣어
				$vmForNAS['nicid'] = $this->getNasNetworkId($vm);
			}
				
			$vmForNAS['displayname'] = $vm['displayname'];
			$vmForNAS['zoneid'] = $vm['zoneid'];
			$vmForNAS['zonename'] = $vm['zonename'];
			$vmForNAS['templatedisplaytext'] = $vm['templatedisplaytext'];
			$vmForNAS['serviceofferingname'] = $vm['serviceofferingname'];
			$vmForNAS['state'] = $vm['state'];
			$VMsForNASs[] = $vmForNAS; //array_push($VMsForNASs, $vmForNAS);
		} 
		
		return $VMsForNASs;
	}
	
	
	function getVMsForNAS2(){ 
		$this->load->model('networksModel'); 
		$nasZoneIds =  $this->networksModel->getNASzoneIds();
		
		$vms = array();
		foreach($nasZoneIds as $nasZoneId){
			$result = $this->getVMsByCondition('zoneid', $nasZoneId);
			if($result['count'] == 1){
				array_push($vms, $result['virtualmachine']);
			}else{
				foreach($result['virtualmachine'] as $vm){
					array_push($vms, $vm);
				}
			}
		}
		
// 		$result = $this->getlistVMs(); 
// 		$vms = $result['virtualmachine'];
		
		$VMsForNASs = array();
		
		//NAS사용여부(nic), zone(zonename), 서버명(displayname), 운영체제(templatedisplaytext), 스펙(serviceofferingname), 상태(state)
		foreach($vms as $vm){
			$vmForNAS=array();
			$vmForNAS['vmid'] = $vm['id'];
			$vmForNAS['useNas'] = $this->isUseNAS($vm);
			
			if($vmForNAS['useNas']){ //nas를 가지고 있으면 nicid를 넣어
				$vmForNAS['nicid'] = $this->getNasNetworkId($vm);
			}
			
			$vmForNAS['displayname'] = $vm['displayname'];
			$vmForNAS['zoneid'] = $vm['zoneid'];
			$vmForNAS['zonename'] = $vm['zonename'];
			$vmForNAS['templatedisplaytext'] = $vm['templatedisplaytext'];
			$vmForNAS['serviceofferingname'] = $vm['serviceofferingname'];
			$vmForNAS['state'] = $vm['state'];
			$VMsForNASs[] = $vmForNAS; //array_push($VMsForNASs, $vmForNAS);
		}
		
		//var_dump($VMsForNASs);
		
		return $VMsForNASs;
	}
	
	private function isUseNAS($vm){
		$niccount = count($vm['nic']);
		
		if($niccount > 1){
			$nics = $vm['nic'];
			 
			if(isset($nics['id'])){ //set되어있다면 하나인거지 nic가 
				return false;
			}
			 
			foreach($nics as $nic){
				if(strpos($nic['networkname'], "NAS") === 0)  // NAS로 시작 (0)
					return true;
			}	
		}
		return false;
	}
	
	private function getNasNetworkId($vm){
		$niccount = count($vm['nic']);
		
		if($niccount > 1){
			$nics = $vm['nic'];
		
			if(isset($nics['id'])){ //set되어있다면 하나인거지 nic가
				return false;
			} 
		
			foreach($nics as $nic){
				$name = $nic['networkname'];
// 				$temp = strpos($name, "NAS");
// 				echo $name.'<hr>'.$temp."<hr>";
				if(strpos($name, "NAS") === 0 ) 
					return $nic['id'];
			}
		}
		return false;
	}

	function searchVM($vmid){ //조건들에 맞는 vm찾기
		$cmdArr = array (
				"command" => "listVirtualMachines",
				"id" => $vmid,
				"apikey" => $_SESSION ['apikey']
		);
		
		$vm = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $vm;
	}
 
	
	function getVMsByCondition($condition, $value){
		$cmdArr = array (
				"command" => "listVirtualMachines",
				$condition => $value,
				"apikey" => $_SESSION ['apikey']
		);
		
		$vms = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $vms;
	}
	
	 
	
	/////////////////////////stupid code///////////////////////
	function getVMs($listVMs, $condition, $value){ //해당 VM들 중에서 condition은 비교할 조건(존같은), value는 비교할 값
		$vmCount= $listVMs['count'];
		$resultIndex = 0;
		$result = array();
		
		if($vmCount == 1){
			if($listVMs['virtualmachine'][$condition] == $value ){
				return $listVMs['virtualmachine'];
			}
		}else{
			for($i=0; $i<$vmCount; $i++){
				$vm = $listVMs['virtualmachine'][$i];
	
				if($vm[$condition] == $value){
					$result[$resultIndex++] = $vm;
				}
			}
			return $result;
		}
	}
	
	//------------서버 기능 
	
	function startVM(){
		$cmdArr = array(
		    "command" => "startVirtualMachine", 
		    "id" => $_POST['vmid'],
		    "apikey" => $_SESSION['apikey']
		);
		  
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	
	function stopVM(){ 
		$cmdArr = array(
				"command" => "stopVirtualMachine", 
				"id" => $_POST['vmid'],
				"apikey" => $_SESSION['apikey']
		); 
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	
	function rebootVM(){
		$cmdArr = array(
				"command" => "rebootVirtualMachine",
				"id" => $_POST['vmid'],
				"apikey" => $_SESSION['apikey']
		);
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
	
		return $result;
	}
	

	function initializeOS($vmid){
		$cmdArr = array(
				"command" => "restoreVirtualMachine",
				"virtualmachineid" => $vmid,
				"apikey" => $_SESSION['apikey']
		);
	
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
	
		return $result;
	}
	
	function resetPwdVM($vmid){
		$cmdArr = array(
				"command" => "resetPasswordForVirtualMachine",
				"id" => $vmid,
				"apikey" => $_SESSION['apikey']
		);
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	
	function deleteVM($vmid){
		$cmdArr = array(
				"command" => "destroyVirtualMachine",
				"id" => $vmid,
				"apikey" => $_SESSION['apikey']
		);
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	 
	
	function updateDisplayname($vmid, $newDisplayname){
		$cmdArr = array(
				"command" => "updateVirtualMachine",
				"virtualmachineid" => $vmid,
				"displayname" => $newDisplayname,
				"apikey" => $_SESSION['apikey']
		);
		
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	
}