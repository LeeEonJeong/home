<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Volumelist extends MY_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model('volumesModel');
		}
		
		function index(){
			$this->_head();
			$returnURI = '/networklist'; // 일단임의로 나중에 returnURI 다시 처리하자
			$this->_require_login($returnURI);
			
			$volumes = $this->volumesModel->getlistVolumes();
		  
			$volumeCount = $volumes['count'];
			 
			$volumelistdata = array(
					'volumes' => $volumes,
					'volumeCount' => $volumeCount
			); 
		
			$this->load->view('volumelist', $volumelistdata);
			$this->load->view('volumeManageMenu');
		    $this->load->view('volumeInfo');
			$this->_footer();
		}
		
		function searchVolumes($zoneid, $searchword){
			if($zoneid == 'all'){
				$listVolumes = $this->volumesModel->getlistVolumes(); 
			}else{
				$listVolumes = $this->volumesModel->getVolumesByCondition('zoneid',$zoneid);
			}
// 			echo var_dump($listVolumes);
			
			$result = array();
			
			if(count($listVolumes) <=1){
				return null;
			}
			
			$volumeCount = $listVolumes['count'];
				
			if($volumeCount == 0 || !isset($volumeCount)){
		
			}else{
				$volumes = $listVolumes["volume"];
				// 			    echo var_dump($vms).'<hr>';
					
				for($i=0; $i<$volumeCount; $i++){
					if($volumeCount == 1){
						$volume = $volumes;
					}else{
						$volume = $volumes[$i];
					}
					$isInclude = strpos($volume['name'], $searchword);
					// 					echo '<br>'.gettype($isInclude);
					// 					echo '<hr>'.$isInclude.' : '.$vm['displayname'];
					if($isInclude >= 0 && gettype($isInclude) == 'integer'){
						array_push($result,$volume);
					}
				}
			}
			print(json_encode($result));
		}
		
		function searchVolumsForArray($zoneid, $searchword){
			if($zoneid == 'all'){
				$listVolumes = $this->volumesModel->getlistVolumes();
			
			}else{
				$listVolumes = $this->volumesModel->getVolumesByCondition('zoneid',$zoneid);
			} 
			/*
			 * 없으면 array(1) { ["@attributes"]=> array(1) { ["cloud-stack-version"]=> string(7) "4.5.1.0" } }
			 * 있으면
			 * array(3) { ["@attributes"]=> array(1) { ["cloud-stack-version"]=> string(7) "4.5.1.0" } ["volume"]=> array(2) { [0]=> array(25) { ["id"]=> string(36) "53f8e330-0edc-475f-b216-be0b57c4c383" ["name"]=> string(11) "DATA-366814" ["zoneid"]=> string(36) "eceb5d65-6571-4696-875f-5a17949f3317" ["zonename"]=> string(4) "kr-1" ["type"]=> string(8) "DATADISK" ["deviceid"]=> string(1) "1" ["virtualmachineid"]=> string(36) "c3d03142-984f-4577-8969-b8b53999279e" ["vmname"]=> string(7) "serverA" ["vmdisplayname"]=> string(7) "serverA" ["vmstate"]=> string(7) "Running" ["provisioningtype"]=> string(4) "thin" ["size"]=> string(11) "85899345920" ["created"]=> string(24) "2016-10-24T11:10:22+0900" ["state"]=> string(5) "Ready" ["account"]=> string(17) "EPC_M172032_S1820" ["domainid"]=> string(36) "849e8028-dafc-4ad6-a649-800221fdf834" ["domain"]=> string(8) "EPC_USER" ["storagetype"]=> string(6) "shared" ["diskofferingid"]=> string(36) "cc85e4dd-bfd9-4cec-aa22-cf226c1da92f" ["diskofferingname"]=> string(20) "tier2-linuxbundle-80" ["diskofferingdisplaytext"]=> string(29) "tier2-linuxbundle Disk (80GB)" ["destroyed"]=> string(5) "false" ["isextractable"]=> string(4) "true" ["quiescevm"]=> string(5) "false" ["usageplantype"]=> NULL } [1]=> array(28) { ["id"]=> string(36) "6a5a5f29-8cf0-433f-87f1-0fc7fe19156a" ["name"]=> string(11) "ROOT-366814" ["zoneid"]=> string(36) "eceb5d65-6571-4696-875f-5a17949f3317" ["zonename"]=> string(4) "kr-1" ["type"]=> string(4) "ROOT" ["deviceid"]=> string(1) "0" ["virtualmachineid"]=> string(36) "c3d03142-984f-4577-8969-b8b53999279e" ["templateid"]=> string(36) "875620f4-5c92-4ff3-a1de-1de3929f3981" ["templatename"]=> string(18) "centos58-32-150202" ["templatedisplaytext"]=> string(18) "centos58-32-150202" ["vmname"]=> string(7) "serverA" ["vmdisplayname"]=> string(7) "serverA" ["vmstate"]=> string(7) "Running" ["provisioningtype"]=> string(4) "thin" ["size"]=> string(11) "21474836480" ["created"]=> string(24) "2016-10-24T11:10:22+0900" ["state"]=> string(5) "Ready" ["account"]=> string(17) "EPC_M172032_S1820" ["domainid"]=> string(36) "849e8028-dafc-4ad6-a649-800221fdf834" ["domain"]=> string(8) "EPC_USER" ["storagetype"]=> string(6) "shared" ["destroyed"]=> string(5) "false" ["serviceofferingid"]=> string(36) "d00301b7-1965-4ba7-9c18-450b65409163" ["serviceofferingname"]=> string(44) "tier3 1core 1GB Instance. Virtual Networking" ["serviceofferingdisplaytext"]=> string(44) "tier3 1core 1GB Instance. Virtual Networking" ["isextractable"]=> string(4) "true" ["quiescevm"]=> string(5) "false" ["usageplantype"]=> NULL } } ["count"]=> string(1) "2" } test
			*/
			 
			if(count($listVolumes) <= 1){ 
				return null;
			}
				
			$result = array();
			 
			$volumeCount = $listVolumes['count'];
			$resultcount=0;
			
			if($volumeCount == 0 || !isset($volumeCount)){
			
			}else{
				$volumes = $listVolumes["volume"];
				// 			    echo var_dump($vms).'<hr>';
					
				for($i=0; $i<$volumeCount; $i++){
					if($volumeCount == 1){
						$volume = $volumes;
					}else{
						$volume = $volumes[$i];
					}
					$isInclude = strpos($volume['name'], $searchword);
					// 					echo '<br>'.gettype($isInclude);
					// 					echo '<hr>'.$isInclude.' : '.$vm['displayname'];
					if($isInclude >= 0 && gettype($isInclude) == 'integer'){
						array_push($result,$volume);
						$resultcount++;
					}
				}
			}
			if($resultcount == 1){
				return array('volume' => $result[0], 'count' => $resultcount);
			}else{
				return array('volume' => $result, 'count' => $resultcount);
			}
		}
		
		function showSearchResult($zoneid, $searchword){
			$this->_head();
			$returnURI = '/volumelist'; // 일단임의로 나중에 returnURI 다시 처리하자
			$this->_require_login($returnURI);
		
			$volumes = $this->searchVolumsForArray($zoneid,$searchword);
			
			if($volumes == null){ 
				$_SESSION['message'] = '해당 검색에 알맞은 디스크 정보 찾을수없음';
				$this->session->mark_as_flash('message');
				redirect('/volumelist');
				return;
			} 
				
			$volumecount = $volumes['count']; 
			 
			$volumelistdata = array(
					'volumes' => $volumes,
					'volumeCount' => $volumecount
			);
			
			$this->load->view('volumelist', $volumelistdata);
			$this->load->view('volumeManageMenu');
			$this->load->view('volumeInfo');
			$this->_footer(); 
		}
		
		function showSearchResultByZoneId($zoneid){
			$this->_head();
			$returnURI = '/volumelist'; // 일단임의로 나중에 returnURI 다시 처리하자
			$this->_require_login($returnURI);
				
			$volumes = $this->volumesModel->getVolumesByCondition('zoneid',$zoneid);
			 
			if(count($volumes)<=1 || $volumes == null){
				$_SESSION['message'] = '해당 존에 디스크 정보 찾을수없음';
				$this->session->mark_as_flash('message');
				redirect('/volumelist');
				return;
			}
				
			$volumecount = $volumes['count']; 
			
			$volumelistdata = array(
					'volumes' => $volumes,
					'volumeCount' => $volumecount
			);
			
			$this->load->view('volumelist', $volumelistdata);
			$this->load->view('volumeManageMenu');
			$this->load->view('volumeInfo');
			$this->_footer(); ;
		}
		
		 
		
		function getlistVolumes(){
			$result =  $this->volumesModel->getlistVolumes();
			print( json_encode($result));
		}
		
		function searchVolume($volumeid){
			$result = $this->volumesModel->searchVolume($volumeid);
			
			print(json_encode($result));
		} 
		
		function getVolumes($virtualmachineid){
			$result = $this->volumesModel->getVolumes($virtualmachineid); 
			print(json_encode($result));
		}
		
		function attachVolume($id, $virtualmachineid){
			$result = $this->volumesModel->attachVolume($id, $virtualmachineid); 
			print(json_encode($result));
		}
		
		function detachVolume($id){
			$result = $this->volumesModel->detachVolume($id); 
			print(json_encode($result));
		}
		
		function deleteVolume($id){
			$result = $this->volumesModel->deleteVolume($id); 
			print(json_encode($result));
		}
	}