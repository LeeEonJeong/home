<?php
 
class NetworksModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' ); 
	}
	
	//-------------<<공인ip>>--------------------------------------------
	
	function getlistPublicIpAddresses() { 
		$cmdArr = array (
				"command" => "listPublicIpAddresses",
				"apikey" => $_SESSION ['apikey'] 
		);
		
		$publicIpAddreses = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $publicIpAddreses;
	}
	
	function getPublicIpAddressByZoneId($zoneid){
		$cmdArr = array (
				"command" => "listPublicIpAddresses",
				"zoneid" => $zoneid,
				"apikey" => $_SESSION ['apikey']
		);
		
		$publicIpAddreses = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $publicIpAddreses;
	}
	
	function getPublicIpInfo() {
		$cmdArr = array (
				"command" => "listPublicIpAddresses",
				"id" => $_POST['publicip'],
				//"id" => '465e6db6-7b44-4ea4-9ab2-b4ff6c616494',
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
	 	
		if($result['count'] != 1){ } //error 정보 무조건 하나일거아냐....아닌가 나중에 바뀌나?
		
		$publicip = $result['publicipaddress'];
		
		return $publicip;
	}
	
	function updateIpAddress($desc, $id){ //ipdaddress에 대한 설명추가
		$cmdArr = array (
				"command" => "updateIpAddress",
				"desc" => $desc,
				"id" => $id,
				"apikey" => $_SESSION ['apikey']
		);
		
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	
	function disassociateIpAddress($id){
		$cmdArr = array (
				"command" => "disassociateIpAddress",
				"id" => $id,
				"apikey" => $_SESSION ['apikey']
		);
		
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	
	//--------존----------------------------------------------------------------------
	
	function getZonename($zoneid){
		$networks = $this->getNetworksByZoneid($zoneid);
		
		if($networks['count'] == 1){
			return $networks['network']['zonename'];//network, count키로 들어옴 network value는 count1이라도 배열
		}else{
			return $networks['network'][0]['zonename'];
		}
	}
	
	function getNetworksByZoneid($zoneid){
		$cmdArr = array (
				"command" => "listNetworks",
				"zoneid" => $zoneid,
				"apikey" => $_SESSION ['apikey']
		);
		
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	
	function getNASNetworkInfoByZoneid($zoneid){
		$result = $this->getNetworksByZoneid($zoneid);
		
		if($result['count'] == 1){
			$network =  $result['network'];
			$name = $network['displaytext'];
			if(strpos($name,"NAS") == 0){
				return $network;
			}
		}else{
			$networks = $result['network'];
			
			foreach($networks as $network){
				$name = $network['displaytext'];
				if(strpos($name,"NAS") == 0){
					return $network;
				}
			}
		}
		return false;
	}
	
	function getlistNetworks(){
		$cmdArr = array (
				"command" => "listNetworks",
				"apikey" => $_SESSION ['apikey']
		);
		
		$networks = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $networks;
	}
	
	function getNASzoneIds(){
		$networks = $this->getlistNetworks()['network'];
		
		$zoneids = array();
		foreach($networks as $network){ 
			$name = $network['name'];
			if(strpos($name,"NAS") === 0){ 
				array_push($zoneids, $network['zoneid']);
			}
		}
		 
		return $zoneids;
	}
	
	

	//-------------<<포트포워딩>>--------------------------------------------
	
	//전체 포트포워딩 규칙 가져오기
 	function getlistPortForwardingRules(){ 
 		$cmdArr = array (
 				"command" => "listPortForwardingRules",
 				"apikey" => $_SESSION ['apikey']
 		);
 		
 		$portforwardingRules = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 		
 		return $publicIpAddreses; 
 	}
 	
 	//ipaddress에 따라서 룰 가져오기
 	function getlistPortForwardingRulesByIpAdress($ipaddressid){
 		$cmdArr = array (
 				"command" => "listPortForwardingRules",
 				//"ipaddressid" => "465e6db6-7b44-4ea4-9ab2-b4ff6c616494",
 				"ipaddressid" =>$ipaddressid,
 				"apikey" => $_SESSION ['apikey']
 		);
 			
 		$portforwardingRules = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 			
 		return $portforwardingRules;
 	}
 	
 	function createPortForwarding(){ //비동기
 		$cmdArr = array (
 				"command" => "createPortForwardingRule",
 				"ipaddressid" => $_POST['ipaddressid'],
 				"publicport" => $_POST['publicport'],//포트 포워딩 규칙의 공개 포트 범위의 시작 포트
 				"publicendport" => $_POST['publicendport'],
 				"virtualmachineid" => $_POST["virtualmachineid"],
 				"privateport" => $_POST["privateport"],//포트 포워딩 규칙의 개인 포트 범위의 시작 포트
 				"privateendport" => $_POST["privateendport"],
 				"protocol" => $_POST["protocol"], 
 				"apikey" => $_SESSION ['apikey']
 		);
 		
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 		return $result;
 	}
 
 	function deletePortForwardingRule($portforwardingid){ //비동기
 		$cmdArr = array (
 				"command" => "deletePortForwardingRule",
 				"id" =>$portforwardingid, 
 				"apikey" => $_SESSION ['apikey']
 		);
 		
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 		return $result;
 	}
 	
 	//-------------<<방화벽>>--------------------------------------------
 	function getFirewallReuls(){
 		
 	}
 	

 	function getlistFirewallRules() {
 		$cmdArr = array (
 				"command" => "listFirewallRules",
 				"apikey" => $_SESSION ['apikey']
 		);
 	
 		$publicIpAddreses = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 	
 		return $publicIpAddreses;
 	}
 	
 	function getlistFireWallInfoByIpAddress($ipaddress) {
 		$cmdArr = array (
 				"command" => "listFirewallRules",
 				"ipaddressid" => $ipaddress,
 				"apikey" => $_SESSION ['apikey']
 		);
 	
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 		
 		if(count($result) == 1){
 			//attribute드간거
 			return null;
 		}
 		return $result;
 	}
 	
 	function createFirewallRule(){ //비동기
 		$cmdArr = array (
 				"command" => "createFirewallRule",
 				"ipaddressid" => $_POST['ipaddressid'],
 				"protocol" => $_POST["protocol"],
 				"cidrlist" => $_POST['cidrlist'], //Firewall에 등록할 source cidrlist ( 미기입시, 모든 IP 허용 정)
 				"startport" => $_POST["startport"],
 				"endport" => $_POST["endport"],
 				"apikey" => $_SESSION ['apikey']
 		);
 	
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 	
 	}
 	
 	
 	function deleteFirewallRule($firewallid){//비동기
 		$cmdArr = array (
 				"command" => "deleteFirewallRule",
 				"id" => $firewallid,
 				"apikey" => $_SESSION ['apikey']
 		);
 			
 		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
 	}
 	
}