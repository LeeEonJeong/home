 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class OrderNas extends MY_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model('orderNasModel');
		} 
		
		function index(){
			$this->_head();
			$returnURI = '/naslist'; // 일단임의로 나중에 returnURI 다시 처리하자
			$this->_require_login($returnURI);
		 
			$this->load->view('orderNas');
			$this->_footer();
		} 
		
		function addVolume(){
			$result = $this->orderNasModel->addVolume();
			print(json_encode($result));
		} 
	}