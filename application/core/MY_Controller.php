<?php

class MY_Controller extends CI_Controller
{

	public $allowedActions = array();
	public $allowedCoordinator = array();
	public $allowedAdmin = array();
	public $allowStaff = array();

	function allow(){
		$this->allowedActions = array_merge($this->allowedActions, func_get_args());
	}
	
	function allowCoordinator(){
		$this->allowedCoordinator = array_merge($this->allowedCoordinator, func_get_args());
	}

	function allowAdmin(){
		$this->allowedAdmin = array_merge($this->allowedAdmin, func_get_args());
	}

	function allowStaff(){
		$this->allowStaff = array_merge($this->allowStaff, func_get_args());
	}


}