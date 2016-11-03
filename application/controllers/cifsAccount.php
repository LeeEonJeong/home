<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	 
	class CifsAccount extends MY_Controller{
		function __construct()
		{
			parent::__construct(); 
			$this->load->model('cifsAccountModel');
		} 
		 
		function addAccountForNas(){ //NAS 서비스 이용을 위한 내부 계정을 관리서버에 등록한다.
			$result = $this->cifsAccountModel->addAccountForNas();
			//echo json_encode($result);
		}
		
		function addCifsAccount(){//CIFS 볼륨 접근에 필요한 ID를 생성한다. (최대 10개까지 생성 가능함)
			$result = $this->cifsAccountModel->addCifsAccount(); 
			echo json_encode($result);
			
			//print(json_encode($result));
			//{"errorcode":"530","errortext":"CIFS password format is invalid","status":"error"}
			// {"response":{"cifsid":"asdfasdf"},"status":"success"}
		} 
		
		function deleteCifsAccount($cifsId){//CIFS 아이디를 삭제한다.
			$result = $this->cifsAccountModel->deleteCifsAccount($cifsId);
			echo json_encode($result);
			//{"errorcode":"530","errortext":"Insert to CIFS ID","status":"error"}
			//{"response":null,"status":"success"}
		}
		
		function listAccountForNas(){//NAS 서비스 이용을 위한 내부 계정의정보를 조회한다.
			$result = $this->cifsAccountModel->listAccountForNas();
			echo json_encode($result);
			//{"response":{"cifsid":"asdfasdf","cifspwd":null,"cifsworkgroup":"EONJEONGGROUP","networkcount":"1","volumecount":"3"},"status":"success"}
		}
		

		function listCifsAccounts(){//CIFS 아이디의 목록을 조회한다.
			$result = $this->cifsAccountModel->listCifsAccounts();
			echo $result;
			//print json_encode($result); 
			//{"response":"asdfasdfawsed33awsed33awsed33","status":"success","totalcount":"3"}
		}
		 
		function updateAccountForNas($cifsworkgroup){ //NAS 서비스 이용을 위한 내부 계정의 cifs 인증정보를 갱신한다. -> workgroup변경시에 사용
			$result = $this->cifsAccountModel->updateAccountForNas($cifsworkgroup);
			print json_encode($result);
			//{"response":{"cifsid":"asdfasdf","cifsworkgroup":"TESTTEST2","networkcount":"1","volumecount":"3"},"status":"success"}
		}
		
		function getWorkGroupName(){
			echo $this->cifsAccountModel->getWorkGroupName();
		}
		
		function updateCifsAccount(){//CIFS 아이디의 비밀번호를 변경한다.
			//특수문자때문에 POST로
			$result = $this->cifsAccountModel->updateCifsAccount();
			print json_encode($result);
		}
		
		
	}
		