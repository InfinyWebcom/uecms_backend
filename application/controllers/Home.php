<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct()
    {
        parent::__construct();
		$this->allow('login', 'forgotPassword', 'resetPassword');
		$this->allowAdmin('dashboard', 'logout','changePassword', 'check_password', 'documents','uploadDocument','deleteDocument','profile','clients','addClient','deleteClient','contracts', 'addContract','closeContract');
		$this->allowStaff('dashboard', 'logout','changePassword', 'check_password', 'documents','uploadDocument','deleteDocument','profile','clients','addClient','deleteClient','contracts', 'addContract','closeContract');

		$this->load->model('core_model');
	}



	/**
		* Author: Ajay Salunkhe (AJ)
		* 
		* Admin or Staff can login using username and password
		* If already logged in then redirect to dashboard
	*/
	public function login()
	{

		if(!$this->session->userdata('id')){
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|xss_clean|trim');
			if(!$this->form_validation->run())
			{
				$data["_view"] = "login";
        		$this->load->view("basetemplate", $data);
			}
			else
			{
				$email = $this->input->post('email');
				$password = $this->input->post('password');

				$this->db->where_in('user_type', array('admin', 'Site Co-ordinator'));
				$result = $this->db->get_where('users',array('email' => $email, 'password' => md5($password),  'status' => 'ACTIVE'))->row_array();
		        if(empty($result))
		        {
		            $this->session->set_flashdata('error','Incorrect User Credentials');
		            redirect('home/login');
		        }
		        else{
		            unset($result['password']);
		            $this->session->set_userdata($result);
		            $this->session->set_flashdata('success', 'Welcome, you have logged in successfully.');
		            redirect('home/dashboard');
		        }
			}
		}
		else{
			redirect('home/dashboard');
		}
	}

	//logout and destroy session (AJ)
	function logout(){
        $this->session->sess_destroy();
		redirect("home/login");
	}

	public function forgotPassword()
	{

		if(!$this->session->userdata('id')){
			
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			if(!$this->form_validation->run())
			{
				$data["_view"] = "forgotPassword";
        		$this->load->view("basetemplate", $data);
			}
			else
			{
		        $userArray = $this->core_model->get_single_row('users', '*',  array('email' => $this->input->post('email'), 'status' => 'ACTIVE'));
		        if(empty($userArray)){
		            $this->session->set_flashdata('error', 'Email id not exist.');
		            redirect("home/forgotPassword");
		        }
		        else{
		        	$change_password_token = md5($userArray['id'].'_'.generateRandomString());
		        	$userArray['link'] = base_url().'home/resetPassword/'.$change_password_token;
		        	$this->core_model->updateData('users', array('change_password_token' => $change_password_token), array('id' => $userArray['id']));
		        	$emailContent = get_email_template('forgot passward', $userArray);
		        	email($userArray['email'], $emailContent);
		        	$this->session->set_flashdata('success', 'Password recovery email sent successfully.');
		        	redirect("home/login");
		        }
			}
		}
		else{
			redirect("home/forgotPassword");
		}
	}

	// Reset Password after forgot password (AJ)
	function resetPassword($token = ''){
		$userdata = $this->core_model->get_single_row('users', '*',  array('change_password_token' => trim($token)));
		$this->form_validation->set_rules('new_password', 'New Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
		if($this->form_validation->run()){
			$postArray = $this->input->post();
			if($this->core_model->updateData('users', array('password' => md5($postArray['new_password']),'change_password_token' => ''), array('change_password_token' => $postArray['token']))){
				$this->session->set_flashdata('success', 'Password changed successfully!');
			}
			else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
			redirect('home/login');
		}
		else{			
			$data['_view'] = "resetPassword";
			$data['userdata'] = $userdata ;
			$data['token'] = $token;
			if(empty($data['userdata'])){
				show_error('Link has been expired!');
			}
        	$this->load->view("basetemplate", $data);
		}
	}

	// Change Password after login(AJ)
	function changePassword($token = ''){
		$this->form_validation->set_rules('current_password', 'Password', 'required|callback_check_password');
		$this->form_validation->set_rules('new_password', 'New Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
		if($this->form_validation->run()){
			$postArray = $this->input->post();
			if($this->core_model->updateData('users', array('password' => md5($postArray['new_password'])), array('id' => $this->session->userdata('id')))){
				$this->session->set_flashdata('success', 'Password changed successfully!');
			}
			else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
			redirect('home/changePassword');
		}
		else{
            $this->session->set_flashdata('error', validation_errors());
		}
		$data["active"] = "dashboard";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;		
		$data['_view'] = "changePassword";
		$data['footer'] = TRUE;
    	$this->load->view("basetemplate", $data);
	}

	// Check Password (AJ)
	function checkPassword(){
		if($this->core_model->checkPassword($this->input->post()))
			$return = TRUE;
		else
			$return = FALSE;
		echo json_encode($return);
	}

	// Callback to check password (AJ)
	function check_password($str){
		$array['current_password'] = $str;
		if($this->core_model->checkPassword($array))
			return TRUE;
		else
			return FALSE;
	}

	// documents listing(AJ)
	public function documents()
	{
		$data["documents"] = $this->core_model->get_select_arr('documents', '*', array(), 'added_on', 'desc');
		$data["active"] = "dashboard";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "documents";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	// upload and edit document(AJ)
	public function uploadDocument()
	{
		$this->form_validation->set_rules('title', 'Password', 'required');
		if($this->form_validation->run()){
			$config['upload_path']   = './uploads/documents/'; 
			$config['allowed_types'] = 'pdf|jpg|png|jpeg'; 
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('file')) {
				$error = array('error' => $this->upload->display_errors());
				$this->session->set_flashdata('error', $error['error']);
			}
			else { 
				$data = array('upload_data' => $this->upload->data());
				$insert = array(
					'user_id'=>$this->session->userdata('id'),
					'title'=> $this->input->post('title'),
					'file'=> $data['upload_data']['file_name'],
					'added_on'=> date("Y-m-d H:i:s")
				);
				$this->core_model->insertData('documents', $insert);
				if($this->input->post('id')>0){
					$this->core_model->deleteDocument($this->input->post('id'));
				}
				$this->session->set_flashdata('success', 'Document uploaded successfully!');
			} 
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect('home/documents');
    }

    // delete document(AJ)
    public function deleteDocument($id=0)
	{
		if($this->core_model->deleteDocument($id))
			$return = TRUE;
		else
			$return = FALSE;
		echo json_encode($return);
	}

	//Edit Profile (AJ) 
	function profile(){
		$data["user"] = $this->core_model->get_single_row('users', '*',  array('id' => $this->session->userdata('id')));
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('phone', 'Phone Number', 'required');
		$this->form_validation->set_rules('email', 'email', 'required|valid_email');
		if($this->form_validation->run())
		{
			$updateData = $this->input->post();
			if($this->core_model->profile($updateData,$data["user"])){
				$result = $this->core_model->get_single_row('users', '*',  array('id' => $this->session->userdata('id')));
				$this->session->set_userdata($result);
				$this->session->set_flashdata('success', 'User data updated successfully!');
			}
			else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
			redirect('home/profile');
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}

		$data["active"] = "dashboard";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "profile";
		$data['footer'] = TRUE;
		$this->load->view("basetemplate", $data);
	}

	public function dashboard($date='')
	{
		$date = isset($date) && !empty($date) ? $date: date('F, Y');
		$date =  date('Y-m-d', strtotime(str_replace('/', '-', $date)));
		$result = $this->core_model->getGraphData($date);
		
		$data["graphData"] = $result['data'];
		$data["graphLabels"] = $result['labels'];
		// pr($data);exit;
		$data["months"] = array();
		$this->db->order_by('start_date', 'asc');
		$lastEntry = $this->db->get_where('contracts', array())->row_array();
		
		if(empty($lastEntry)){
			array_push($data["months"], date('F, Y'));
		}else{
			for ($i = 0; $i < 120; $i++) {
				array_push($data["months"], date('F, Y', strtotime("-$i month")));
				if(date('F, Y', strtotime($lastEntry['start_date'])) ==  date('F, Y', strtotime("-$i month"))){
					break;
				}
			}
		}
		$data["date"] = $date;
		$data["active"] = "dashboard";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "dashboard";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	function getGraphData() {
		$data = $this->input->post();
		if(!empty($data['date'])){ 
			$date =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date'])));
			$result = $this->core_model->getGraphData($date);
			$msg = array('errcode' => 0,'result'=>$result);
		}else{
			$msg = array('errcode' => 100,'result'=>'');
		}
		echo json_encode($msg);
	}

	public function clients()
	{

		$data["clients"] = $this->core_model->get_clients();
		$data["active"] = "clients";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "clients";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	// add and edit client(AJ)
	public function addClient()
	{
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		if($this->form_validation->run()){
			$data = $this->input->post();
			$insert = array(
				'name'=>trim($data['name']),
				'email'=> trim($data['email']),
				'phone'=> trim($data['phone']),
				'added_on'=> date("Y-m-d H:i:s")
			);
			if($data['id']>0){
				if($this->core_model->updateData('clients', $insert, array('id' =>$data['id']))){
					$this->session->set_flashdata('success', 'Client details added successfully!');
				}else{
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}else{
				if($this->core_model->insertData('clients', $insert)){
					$this->session->set_flashdata('success', 'Client details added successfully!');
				}else{
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect('home/clients');
    }

    // delete client(AJ)
    public function deleteClient($id=0)
	{
		if($id > 0 && $this->core_model->delete('clients', array('id' => $id)))
			$this->session->set_flashdata('success', 'Client details deleted successfully!');
		else
			$this->session->set_flashdata('error', 'Client details not deleted.');

		redirect('home/clients');
	}

	public function contracts()
	{
		$data["contracts"] = $this->core_model->get_contracts();
		$data["clients"] = $this->core_model->get_select_arr('clients', 'id, name', array(), 'added_on', 'desc');
		$data["active"] = "contracts";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "contracts";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	// add and edit Contract(AJ)
	public function addContract()
	{
		$this->form_validation->set_rules('contract', 'Contract', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('client_id', 'Client id', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'required');
		$this->form_validation->set_rules('start_date', 'Start date', 'required');
		$this->form_validation->set_rules('end_date', 'End date', 'required');
		if($this->form_validation->run()){
			$data = $this->input->post();
			$insert = $data;
			$insert['start_date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $data['start_date'])));
	        $insert['end_date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $data['end_date'])));
			
			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
				$config['upload_path']   = './uploads/documents/'; 
				$config['allowed_types'] = '*'; 
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					$insert['document_name'] = $data['upload_data']['file_name'];
				}
			}
			if($this->core_model->insertData('contracts', $insert)){
				$this->session->set_flashdata('success', 'Contract details added successfully!');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect('home/contracts');
    }

    // delete Contract(AJ)
    public function closeContract()
	{
		$id = $this->input->post('id');
		$update = array('status'=> 'closed');
		;
		if($id>0){

			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
				$config['upload_path']   = './uploads/documents/'; 
				$config['allowed_types'] = '*'; 
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					
					$update['certificate_name'] = $data['upload_data']['file_name'];
				}
			}
			$this->core_model->updateData('contracts', $update, array('id' =>$id));
			$this->session->set_flashdata('success', 'Contract details added successfully!');
		}else{
			$this->session->set_flashdata('error', 'Invalid contract id.');
		}
		redirect('home/contracts');


		$config['upload_path']   = './uploads/documents/'; 
		$config['allowed_types'] = 'pdf|jpg|png|jpeg'; 
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('error', $error['error']);
		}
		else {
			$id = $this->input->post('id');
			$upload_data = $this->upload->data();
			$update = array('status'=> 'closed');
			$update['certificate_name'] = $upload_data['file_name'];
			if($id>0 && $this->core_model->updateData('contracts', $update, array('id' =>$id)))
				$this->session->set_flashdata('success', 'Contract details added successfully!');
			else
				$this->session->set_flashdata('error', 'Invalid contract id.');

		}
		redirect('home/contracts');
	}
}
