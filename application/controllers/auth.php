<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Auth extends MY_Controller {
	function __construct() {
		parent::__construct ();
	}
	function login() {
		$this->_head ();
	
		$returnURL = $this->input->get('returnURL');
		
// 		if ($returnURL === false || $returnURL == null) {
// 			$returnURL = '/cloudlist';//기본페이지로 이동
// 		}
		
		if($this->session->userdata('is_login')){
			echo "<script> alert('로그아웃 후 사용해 주세요.'); </script>";
		}else{
			$this->load->view ( 'login', array (
					'returnURL' => $returnURL
			) );
		}
		
		$this->_footer ();
	}
	
	function logout() {
		$this->session->sess_destroy ();
		redirect ( '/auth/login' );
	}
	
	function authentication() {
		$this->load->model ( 'userModel' );
		
		$user = $this->userModel->getByEmail ( array (
				'email' => $this->input->post ( 'email' ) 
		) );
		
		if (! function_exists ( 'password_hash' )) {
			$this->load->helper('password' );
		}
		
		if ($this->input->post ( 'email' ) == $user->email && password_verify ( $this->input->post ( 'password' ), $user->password)) { 
			$this->session->set_userdata ( 'is_login', true );
			$this->session->set_userdata ( 'nickname', $user->nickname );
			$this->session->set_userdata ( 'apikey', $user->apikey );
			$this->session->set_userdata ( 'secretkey', $user->secretkey );
			$returnURL = $this->input->get ( 'returnURL' );
			 
			//echo "<script>alert('sdfsdf".$returnURL."');</script>";
			
			if ($returnURL === false || $returnURL == null) {
				redirect('/cloudlist'); //기본페이지로 이동
			}else{ 
				redirect ($returnURL ); //이전에 왔던 페이지로 이동
			}
		} else {
			//$this->session->set_flashdata ( 'message', '로그인에 실패 했습니다.' );
			$_SESSION['message'] = '로그인 실패하심';
			$this->session->mark_as_flash('message');
			redirect ( '/auth/login' ); //로그인실패하면 이전페이지로 가는거 안됨
		}
	}
	
	
	function register(){
		$this->_head(); 
		$this->load->library('form_validation');
	
		$this->form_validation->set_rules('email', '이메일 주소', 'required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('nickname', '닉네임', 'required|min_length[3]|max_length[20]');
		$this->form_validation->set_rules('password', '비밀번호', 'required|min_length[6]|max_length[30]|matches[re_password]');
		$this->form_validation->set_rules('re_password', '비밀번호 확인', 'required');
		$this->form_validation->set_rules('apikey', 'apikey', 'required');
		$this->form_validation->set_rules('secretkey', 'secretkey', 'required');
	
		if($this->form_validation->run() === false){
			$this->load->view('register');
		} else {
			if(!function_exists('password_hash')){
				$this->load->helper('password');
			}
			 
			$hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT);  
			$this->load->model('userModel');
			$this->userModel->add(array(
					'email'=>$this->input->post('email'),
					'password'=>$hash,
					'nickname'=>$this->input->post('nickname'),
					'apikey'=>$this->input->post('apikey'),
					'secretkey' => $this->input->post('secretkey')
			));
	
			$this->session->set_flashdata('message', '회원가입에 성공했습니다.'); 
			
			redirect('/cloudlist');
		} 
		$this->_footer();
	}
	
	
}
