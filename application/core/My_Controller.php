<?php
class MY_Controller extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->database();   
    }
    
    function _head(){ 
        $this->load->view('head');       
    }
    
    function _sidebar(){ //사용안해도 될듯
        $this->load->view('menulist');
    }
    
    function _footer(){
        $this->load->view('footer');
    }
    
    function _require_login($return_url){
        // 로그인이 되어 있지 않다면 로그인 페이지로 리다이렉션
        if(!$this->session->userdata('is_login')){
            redirect('/auth/login?returnURL='.rawurlencode($return_url));
        }
    } 
}