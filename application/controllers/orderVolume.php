<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class orderVolume extends MY_Controller{
		function __construct()
		{
			parent::__construct();
			$this->load->model('orderVolumeModel');
		}
		
		function orderVolume(){
			$result = $this->orderVolumeModel->orderVolume();
			echo json_encode($result);
		}
		
	}