<?php
// db에서 사용자의 클라우드 가져오기
/*
 * 해당 유저의 서버 정보 가져오기
 * 서칭기능
 * 볼륨이 붙여진 클라우드 가져오기
 *
 */
class OrderCloudModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' ); 
	}
	
	function checkVirtualMachineName($checkname){
		$cmdArr = array (
				"command" => "checkVirtualMachineName",
				"display_name" => $checkname,
				"apikey" => $_SESSION ['apikey']
		);
			
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		return $result;
	}
	
	function orderVM(){
// 		$cmdArr = array (
// 				"command" => "deployVirtualMachine",
// 				"displayname" => $_POST['displayname'],
// 				"name" => $_POST['name'],
// 				"zoneid" => $_POST['zoneid'],
// 				"productcode" => $_POST['productcode'],
// 				"usageplantype" => $_POST['usageplantype'],
// 				"apikey" => $_SESSION ['apikey']
// 		);
		
		$cmdArr = array (
				"command" => "deployVirtualMachine",
				"displayname" => 'asdfzxcv',
				"name" =>'asdfzxcv',
				"zoneid" => "eceb5d65-6571-4696-875f-5a17949f3317",
				"productcode" => "std_wind 2008ent 32bit ko_1x1_rootonly",
				"usageplantype" => 'hourly',
				"apikey" => $_SESSION ['apikey']
		);
		 
		$result = $this->callApiModel->callCommand(CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
	 	
		return $result;  //file_get_contents에서 실패시 false return
	}
	
	function getlistAvailableProductTypesByZoneid($zoneid){
		$cmdArr = array (
				"command" => "listAvailableProductTypes",
				"zoneid" => $zoneid,
				//"zoneid" => 'eceb5d65-6571-4696-875f-5a17949f3317',
				"apikey" => $_SESSION ['apikey']
		);
			
		$listAvailableProductTypes = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $listAvailableProductTypes;
	}
	
	function getlistAvailableProductTypes($condition, $value){
		$cmdArr = array (
				"command" => "listAvailableProductTypes",
				$condition => $value,
				"apikey" => $_SESSION ['apikey']
		);
			
		$listAvailableProductTypes = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $listAvailableProductTypes;
	}

	function getPackagesByZoneid($zoneid){ //비효율적..?
		$availableProductTypes = $this->getlistAvailableProductTypesByZoneid($zoneid);
		$count = $availableProductTypes['count'];
		$productTypes = $availableProductTypes['producttypes'];
	 	 
		$index=0;
		
		if($count==0){
			return array();
		}
		$packages = $this->getUniqueValueList($productTypes, 'product');
// 		 
		return $packages;			
	}
	
	function getProductIds($productsArray){
		$count = count($productsArray);
		$productids = array();
		$index = 0;
		for($i=0; $i<$count; $i++){
			$product = $productsArray[$i];
			$productid = explode('_', $product['productid']);//array
			if(count($productid) == 3) //3개로 안되어있는것들도 있음..머지?
				$productids[$index++] = $productid;
		}
		return $productids;
	}
	
	function getOSlist($zoneid, $package){
		$productsArray = $this->getProductsByZoneidAndPackage($zoneid, $package);
		$productids = $this->getProductIds($productsArray['producttypes']);
		//index 0 producttype(std, high, ssd)
		//index 1 os
		//index 2 datadisk
		 
		$oslist = $this->getUniqueValueList($productids, 1);
		 
		return $oslist;
	}
	
	function getDatadisklist($zoneid, $package, $os){
		$productsArray = $this->getProductsByZoneidAndPackage($zoneid, $package, $os);
		$osname = urldecode($os);		
		$osproducts = $this->getProducts($productsArray['producttypes'], 'productid', $osname);
		 
		$productids = $this->getProductIds($osproducts);
		$disklist = $this->getUniqueValueList($productids, 2);
		//index 0 producttype(std, high, ssd)
		//index 1 os
		//index 2 datadisk
		return $disklist;
	}
	
	function getUniqueValueList($array,$condition){
		$resultasrray = array();
	
		$old = '';
		foreach($array as $key=>$value){
			$new = $value[$condition];
			if($old != $new && $new != null){
				array_push($resultasrray, $new);
				$old = $new;
			}
		}
	
		return $resultasrray;
	}
	
	function getProductsByZoneidAndPackage($zoneid, $package){
		$cmdArr = array (
				"command" => "listAvailableProductTypes",
				"package" =>$package,
				"zoneid" => $zoneid,
				"apikey" => $_SESSION ['apikey']
		);
			
		$result = $this->callApiModel->callCommand( CallApiModel::URI, $cmdArr, $this->session->userdata ( 'secretkey' ) );
		
		return $result;
	}
	
	function getProducts($productTypes, $condition, $substring){
		$products = array();

		foreach($productTypes as $key=>$value){
			$product = $value;
			
			$ishas = strpos($product[$condition], $substring);
			
			if(gettype($ishas) == 'integer' && $ishas >= 0){
				array_push($products, $product);
			}
		}
		return $products;
	}
	
	private function getAvailableProductTypes($condition, $value){
		$availableProductTypes = $this->getlistAvailableProductTypes();
		$count = $availableProductTypes['count'];
		 
		$productTypes = $availableProductTypes['producttypes'];
		$products = array();
		$index=0;
		
		for($i=0; $i<$count; $i++){
			$product = $productTypes[$i];
			 
			if($product[$condition] == $value){
				$products[$index++] = $product; 
			}
		}
		 
		return $products;
	}
	 
	  
}