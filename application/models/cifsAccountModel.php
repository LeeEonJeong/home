<?php
class CifsAccountModel extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'callApiModel' ); 
	} 
	 
	function addAccountForNas(){ //NAS 서비스 이용을 위한 내부 계정을 관리서버에 등록한다.  
		$cmdArr = array(
				"command" => "listAccounts",
				"apikey" => $_SESSION ['apikey']
		);
		$listAccountsResult = $this->callApiModel->callCommand(CallApiModel::URI, $cmdArr, $_SESSION['secretkey']);
		
// 		echo var_dump($listAccountsResult);
// 		echo '<hr>';
		$accountCount = $listAccountsResult['count'];
		$account = $listAccountsResult['account']; //알던  account 1개일 경우에만..
		 
// 		echo var_dump($accountCount);
// 		echo var_dump($account); 
		$cmdArr2 = array(
				"command" => "addAccountForNas",
				"accountid" => $account['id'],
				"apikey" => $_SESSION ['apikey']
		);

		$result = $this->callApiModel->callCommand(CallApiModel::NASURI, $cmdArr2, $_SESSION['secretkey']);

		echo var_dump($result); 
		return $result;
	} 
	
	function addCifsAccount() {//CIFS 볼륨 접근에 필요한 ID를 생성한다. (최대 10개까지 생성 가능함)
		$this->checkCreateCIFSAccountForFirst();
		$cmdArr = array(
				"command" => "addCifsAccount",
				"cifsId" => $_POST['cifsid'],
				"cifsPw" => $_POST['cifspwd'],
// 				"cifsId" => 'test213',
// 				"cifsPw" => 'test2$2sdfs',
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommand(CallApiModel::NASURI, $cmdArr, $_SESSION['secretkey']);
		return $result;
	}
	
	function checkCreateCIFSAccountForFirst(){ 
		$result = $this->listAccountForNas();
		//{"errorcode":"530", "errortext":"nas account is none"}
		//처음 cifs 볼륨 신청시에
		//addAccountForNas하고 나면 listAccountForNas 결과
		//{"response":{"cifsid":null,"cifspwd":null,"cifsworkgroup":null,"networkcount":"0","volumecount":"0"},"status":"success"}
		//한번 한 후에 addAccountForNas 결과
		//array(2) { ["errorcode"]=> string(3) "530" ["errortext"]=> string(28) "You already have an account." }
		 
		if(isset($result['errorcode'])){
			$this->addAccountForNAs();
		}
	}
	
	function deleteCifsAccount($cifsId){//CIFS 아이디를 삭제한다.
		$cmdArr = array(
				"command" => "deleteCifsAccount",
				"cifsId" => $cifsId, 
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommand(CallApiModel::NASURI, $cmdArr, $_SESSION['secretkey']);
		return $result;	
	}
	
	function listAccountForNas(){//NAS 서비스 이용을 위한 내부 계정의정보를 조회한다.
		$cmdArr = array(
				"command" => "listAccountForNas",  //accountid필요한데 안넣어도 나옴
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommand(CallApiModel::NASURI, $cmdArr, $_SESSION['secretkey']);
		return $result;	 
	} 
	
	function listCifsAccounts() {//CIFS 아이디의 목록을 조회한다.
		$cmdArr = array(
				"command" => "listCifsAccounts",
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommandResponseJSON(CallApiModel::NASURI, $cmdArr, $_SESSION['secretkey']);
		return $result;
	}
		
	function updateAccountForNas($cifsworkgroup){ //NAS 서비스 이용을 위한 내부 계정의 cifs 인증정보를 갱신한다. //????
		$cmdArr = array(
				"command" => "updateAccountForNas",
				//"accountid" => $accountid,
				//"cifsid" => $cifsId,
				//"cifspassword" => $cifspassword, //쓸 일 없을듯
				"cifsworkgroup" => $cifsworkgroup,
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommand(CallApiModel::NASURI, $cmdArr, $_SESSION['secretkey']);
		return $result;
	}  

	function getWorkGroupName(){
		$cmdArr = array(
				"command" => "updateAccountForNas",
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommand(CallApiModel::NASURI, $cmdArr, $_SESSION['secretkey']);
			
		if(isset($result['errortext'])){
			return '';
		}else{
			return $result['response']['cifsworkgroup'];
		}
	}
	
	function updateCifsAccount(){//CIFS 아이디의 비밀번호를 변경한다. 
			$cmdArr = array(
				"command" => "updateCifsAccount", 
				"cifsId" => $_POST['cifsid'],
				"cifsPw" => $_POST['cifspwd'],  
				"apikey" => $_SESSION ['apikey']
		);
	
		$result = $this->callApiModel->callCommand(CallApiModel::NASURI, $cmdArr, $_SESSION['secretkey']);
		return $result;
	
	}
	
}