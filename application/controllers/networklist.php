<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Networklist extends MY_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model('networksModel');
		}
		
		function index(){
			$this->_head();
			$returnURI = '/networklist'; // 일단임의로 나중에 returnURI 다시 처리하자
			$this->_require_login($returnURI);
			
			$publicIps = $this->networksModel->getlistPublicIpAddresses();
		  
			$publicIpCount = $publicIps['count'];
			 
			$networklistdata = array(
					'publicIps' => $publicIps,
					'publicIpCount' => $publicIpCount
			); 
		
			$this->load->view('networklist', $networklistdata); 
		 	$this->load->view('networkManageMenu');
		    $this->load->view('networkInfo');
			$this->_footer();
		} 
		
		function updateIpAddress($desc, $id){ //ipdaddress에 대한 설명추가
			$publicip = $this->networksModel->updateIpAddress($desc, $id);
			print(json_encode($publicip));
		}
		
		function disassociateIpAddress($id){
			$publicip = $this->networksModel->disassociateIpAddress($id); 
			print(json_encode($publicip));
		}
		
		function getPublicIpInfo(){
			$publicip = $this->networksModel->getPublicIpInfo(); 
			print(json_encode($publicip));
		}
		
		function getlistFireWallInfoByIpAddress($ipaddress){
			$firewallRules = $this->networksModel->getlistFireWallInfoByIpAddress($ipaddress);
			print(json_encode($firewallRules));
		}
		
		function getPublicIpAddressByZoneId($zoneid){
			$firewallRules = $this->networksModel->getPublicIpAddressByZoneId($zoneid);
			print(json_encode($firewallRules));
		}
		
		function getlistPortForwardingRulesByIpAdress($ipaddressid){
			$portforwardingRules = $this->networksModel->getlistPortForwardingRulesByIpAdress($ipaddressid);
			print(json_encode($portforwardingRules));
		}
		
		function createFirewallRule(){
			$result = $this->networksModel->createFirewallRule();
			print(json_encode($result));
		} 
		 
		
		function createPortForwarding(){
			$result = $this->networksModel->createPortForwarding();
			print(json_encode($result));
		} 
		
		function deletePortForwardingRule($portforwardingid){
			$result = $this->networksModel->deletePortForwardingRule($portforwardingid);
		    print(json_encode($result));
		}
		
		function deleteFirewallRule($firewallid){
			$result = $this->networksModel->deleteFirewallRule($firewallid);
			print(json_encode($result));
		}
		
		function getNetworksByZoneid($zoneid){
			$result = $this->networksModel->getNetworksByZoneid($zoneid);
			print(json_encode($result));
		}
		 
		function getNASNetworkInfoByZoneid($zoneid){
			$result = $this->networksModel->getNASNetworkInfoByZoneid($zoneid);
			print(json_encode($result));
		}
		
		function getlistNetworks(){
			$result = $this->networksModel->getlistNetworks();
			print(json_encode($result));
		}
		
		function getNASzoneIds(){
			$result = $this->networksModel->getNASzoneIds();
			print(json_encode($result));
		}
		 
	}