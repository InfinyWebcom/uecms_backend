<?php

class PreAction{

	function validate_user(){
		$this->CI =& get_instance();
		if(!$this->CI->session->userdata('id') && !in_array($this->CI->router->method, $this->CI->allowedActions)){
			redirect('home/login');
		}
		else if($this->CI->session->userdata('id')){
			switch($this->CI->session->userdata('type')){
			
			case 'coordinator':
				if(!in_array($this->CI->router->method, $this->CI->allowedcoordinator) && !in_array($this->CI->router->method, $this->CI->allowedActions))
					$this->CI->session->set_flashdata('error','Sorry, You do not have permission to access this module!');
					redirect('user/dashboard');
				break;
			case 'admin':
				if(!in_array($this->CI->router->method, $this->CI->allowedAdmin) && !in_array($this->CI->router->method, $this->CI->allowedActions)){
					$this->CI->session->set_flashdata('error','Sorry, You do not have permission to access this module!');
					redirect('admin/dashboard');
				}
				break;
			}
		}
		
	}
}