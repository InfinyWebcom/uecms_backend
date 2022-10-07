<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->allow();
        $this->allowAdmin('groups', 'addGroup', 'deleteGroup', 'sites','addSite', 'deleteSite', 'siteDetails','deleteJob', 'jobDetails', 'addjobDetails', 'closeJob','deleteJobDetails', 'deleteRequest','request');
		$this->allowStaff('groups', 'addGroup', 'deleteGroup', 'sites','addSite', 'deleteSite', 'siteDetails','deleteJob', 'jobDetails', 'addjobDetails', 'closeJob','deleteJobDetails', 'deleteRequest','request');

        $this->load->model('core_model');
	}

	public function groups($id=0)
	{
		$data["contract"] = $this->core_model->get_single_row('contracts', '*', array('id' => $id));
		if(!empty($data["contract"])){
			$data["contract_id"] = $id;
			$data["groups"] = $this->core_model->get_groups($id);
			$data["managers"] = $this->core_model->get_select_arr('users', 'id, name', array('user_type'=>'manager'), 'id', 'asc');
			$data["active"] = "contracts";
			$data['header'] = TRUE;
			$data['sidemenu'] = TRUE;
			$data['_view'] = "groups";
			$data['footer'] = TRUE;
	        $this->load->view("basetemplate", $data);
		}else{
			$this->session->set_flashdata('error', 'Invalid contract id.');
			redirect('home/dashboard');
		}	
	}

	// add and edit groups(AJ)
	public function addGroup()
	{
		$data = $this->input->post();
		if($data['contract_id'] > 0){
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('manager_id', 'Manager', 'required');
			if($this->form_validation->run()){
				
				$insert = $data;
				if($data['id']>0){
					if($this->core_model->updateData('groups', $insert, array('id' =>$data['id']))){
						$this->session->set_flashdata('success', 'Groups details added successfully!');
					}else{
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}else{
					if($this->core_model->insertData('groups', $insert)){
						$this->session->set_flashdata('success', 'Groups details added successfully!');
					}else{
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}
			}else{
	            $this->session->set_flashdata('error', validation_errors());
			}
			redirect('contract/groups/'.$data['contract_id']);
		}else{
			$this->session->set_flashdata('error', 'Invalid contract id.');
			redirect($_SERVER['HTTP_REFERER']);
		}					
    }

    // delete Group(AJ)
    public function deleteGroup($id=0)
	{
		if($id > 0 && $this->core_model->delete('groups', array('id' => $id)))
			$this->session->set_flashdata('success', 'Groups details added successfully!');
		else
			$this->session->set_flashdata('error', 'Groups details not deleted.');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function sites($id=0)
	{
		$data["group"] = $this->core_model->get_single_row('groups', '*', array('id' => $id));
		if(!empty($data["group"])){
			$data["contract"] = $this->core_model->get_single_row('contracts', '*', array('id' => $data["group"]['contract_id']));
			$data["supervisors"] = $this->core_model->get_select_arr('users', 'id, name', array('user_type'=>'supervisor'), 'id', 'asc');
			$data["sites"] = $this->core_model->get_sites($id);
			$data["active"] = "contracts";
			$data['header'] = TRUE;
			$data['sidemenu'] = TRUE;
			$data['_view'] = "sites";
			$data['footer'] = TRUE;
	        $this->load->view("basetemplate", $data);
	    }else{
			$this->session->set_flashdata('error', 'Invalid Group.');
			redirect('home/dashboard');
		}
	}

	// add and edit sites(AJ)
	public function addSite()
	{
		$data = $this->input->post();
		if($data['group_id'] > 0){
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('supervisor_id', 'Supervisor', 'required');
			if($this->form_validation->run()){
				
				$insert = $data;
				if($data['id']>0){
					if($this->core_model->updateData('sites', $insert, array('id' =>$data['id']))){
						$this->session->set_flashdata('success', 'Site details added successfully!');
					}else{
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}else{
					if($this->core_model->insertData('sites', $insert)){
						$this->session->set_flashdata('success', 'Site details added successfully!');
					}else{
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}
			}else{
	            $this->session->set_flashdata('error', validation_errors());
			}
			redirect('contract/sites/'.$data['group_id']);
		}else{
			$this->session->set_flashdata('error', 'Invalid Group.');
			redirect($_SERVER['HTTP_REFERER']);
		}					
    }

    // delete Group(AJ)
    public function deleteSite($id=0)
	{
		if($id > 0 && $this->core_model->delete('sites', array('id' => $id)))
			$this->session->set_flashdata('success', 'Site added successfully!');
		else
			$this->session->set_flashdata('error', 'Site not deleted.');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function siteDetails($id=0)
	{
		$data["site"] = $this->core_model->get_siteDetails($id);
		if(!empty($data["site"])){
			$data["jobs"] = $this->core_model->getJobs($data["site"]['id']);
			$data["inventories"] = $this->core_model->getUnassignedInventory();
			$data["assignedInventories"] = $this->core_model->getAssignedInventory($id);
			$data["active"] = "contracts";
			$data['header'] = TRUE;
			$data['sidemenu'] = TRUE;
			$data['_view'] = "siteDetails";
			$data['footer'] = TRUE;
	        $this->load->view("basetemplate", $data);
	    }else{
			$this->session->set_flashdata('error', 'Invalid Job.');
			redirect('home/dashboard');
		}
	}

	// add and edit Job(AJ)
	public function addJob()
	{
		$data = $this->input->post();
		if($data['site_id'] > 0){
			$this->form_validation->set_rules('title', 'Title', 'required');
			$this->form_validation->set_rules('start_date', 'Start Date', 'required');
			$this->form_validation->set_rules('end_date', 'End Date', 'required');
			if($this->form_validation->run()){
				$insert = $data;
				$insert['start_date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $data['start_date'])));
	        	$insert['end_date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $data['end_date'])));
				if($data['id']>0){
					if($this->core_model->updateData('jobs', $insert, array('id' =>$data['id']))){
						$this->session->set_flashdata('success', 'job details updated successfully!');
					}else{
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}else{
					if($this->core_model->insertData('jobs', $insert)){
						$this->session->set_flashdata('success', 'job details added successfully!');
					}else{
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}
			}else{
	            $this->session->set_flashdata('error', validation_errors());
			}
			redirect('contract/siteDetails/'.$data['site_id']);
		}else{
			$this->session->set_flashdata('error', 'Invalid Group.');
			redirect($_SERVER['HTTP_REFERER']);
		}					
    }

    // delete Group(AJ)
    public function deleteJob($id=0)
	{
		if($id > 0 && $this->core_model->delete('jobs', array('id' => $id))){

			//delete all material_orders of same job id
			$this->core_model->delete('job_progress', array('job_id' => $id));

			//delete all material_orders of same job id
			$this->core_model->delete('material_orders', array('job_id' => $id));

			//delete all expenses of same job id and unlink uploaded files
			$data = $this->core_model->get_select_arr('expenses','id, file_name', array('job_id'=>$id), 'id', 'asc');

			foreach ($data as $key => $value) {

				$this->core_model->delete('expenses', array('id' => $value['id']));
				$url = FCPATH.'uploads/expenses/'.$value['file_name'];
	            unlink($url);
			}
			
			

			//delete all bills of same job id and unlink uploaded files
			$data = $this->core_model->get_select_arr('bills','id, bill_file, receipt_file', array('job_id'=>$id), 'id', 'asc');
			
			foreach ($data as $key => $value) {
				$this->core_model->delete('bills', array('id' => $value['id']));
				$url = FCPATH.'uploads/bills/'.$value['bill_file'];
	            unlink($url);
	            if(!empty($value['receipt_file'])){
	            	$url = FCPATH.'uploads/bills/'.$value['receipt_file'];
	            	unlink($url);
	            }
			}

			//delete all expenses of same job id and unlink uploaded files
			$data = $this->core_model->get_select_arr('measurements', 'id, file_name', array('job_id'=>$id), 'id', 'asc');
			foreach ($data as $key => $value) {
				$this->core_model->delete('measurements', array('id' => $value['id']));
				$url = FCPATH.'uploads/measurements/'.$value['file_name'];
	            unlink($url);
			}

			$this->session->set_flashdata('success', 'job deleted successfully!');
		}
		else{
			$this->session->set_flashdata('error', 'job not deleted.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	// delete Inventory Request(AJ)
    public function deleteRequest($id=0)
	{
		if($id > 0 && $this->core_model->delete('assign_inventories', array('id' => $id)))
			$this->session->set_flashdata('success', 'Inventory request deleted successfully!');
		else
			$this->session->set_flashdata('error', 'Inventory request not deleted.');

		
	}

	// request Inventory(AJ)
    public function request($id=0)
	{
		
		$this->form_validation->set_rules('inventory_id', 'Inventory Item', 'required');
		$this->form_validation->set_rules('site_id', 'Site', 'required');
		$this->form_validation->set_rules('start_date', 'start date', 'required');
		$this->form_validation->set_rules('end_date', 'end date', 'required');
		if($this->form_validation->run()){
			$insert = $this->input->post();
			$data = $this->core_model->get_single_row('sites', 'supervisor_id', array('id' => $insert['site_id']));
			$insert['supervisor_id'] = $data['supervisor_id'];
			$insert['status'] = 'requested';
			$insert['start_date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $insert['start_date'])));
	        $insert['end_date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $insert['end_date'])));
			if($this->core_model->insertData('assign_inventories', $insert)){
				$this->session->set_flashdata('success', 'Inventory requested.');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function jobDetails($id=0)
	{
		$data["job"] = $this->core_model->get_jobDetails($id);

		if(!empty($data["job"])){
			$data["jobs"] = $this->core_model->getJobProgress($data["job"]['id']);

			$data["workers"] = $this->core_model->get_select_arr('users', 'id, name', array('user_type'=>'worker'), 'id', 'asc');
			$data["active"] = "contracts";
			$data['header'] = TRUE;
			$data['sidemenu'] = TRUE;
			$data['_view'] = "jobDetails";
			$data['footer'] = TRUE;
	        $this->load->view("basetemplate", $data);
	    }else{
			$this->session->set_flashdata('error', 'Invalid Job details.');
			redirect('home/dashboard');
		}
	}

	// add job details(AJ)
	public function addjobDetails()
	{
		$data = $this->input->post();
		if($data['job_id'] > 0){
			$this->form_validation->set_rules('job_id', 'Job Id', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			$this->form_validation->set_rules('worker_id[]', 'Worker', 'required');
			$this->form_validation->set_rules('date', 'Date', 'required');
			if($this->form_validation->run()){
				$insert = $data;
				$insert['date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date'])));
				if($data['id']>0){
					if($this->core_model->updateData('job_progress', $insert, array('id' =>$data['id']))){
						$this->session->set_flashdata('success', 'job progress details updated successfully!');
					}else{
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}else{
					$batch = array();
					foreach ($data['worker_id'] as $key => $value) {
						$insert['worker_id'] = $value;
						array_push($batch, $insert);
					}
					
					if($this->db->insert_batch('job_progress', $batch)){
						$this->session->set_flashdata('success', 'job progress details added successfully!');
					}else{
						$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
					}
				}
			}else{
	            $this->session->set_flashdata('error', validation_errors());
			}
			redirect('contract/jobDetails/'.$data['job_id']);
		}else{
			$this->session->set_flashdata('error', 'Invalid Job.');
			redirect($_SERVER['HTTP_REFERER']);
		}					
    }

    // close job(AJ)
    public function closeJob()
	{
		$data = $this->input->post();
		if($data['job_id'] > 0){
			$this->form_validation->set_rules('closed_date', 'Date', 'required');
			$this->form_validation->set_rules('description', 'Description', 'required');
			if($this->form_validation->run()){
				$insert = array(
					'description'=>$data['description'],
					'status'=>'closed',
					'closed_date'=>date('Y-m-d', strtotime(str_replace('/', '-', $data['closed_date'])))
				);
				if($this->core_model->updateData('jobs', $insert, array('id' =>$data['job_id']))){
					$this->session->set_flashdata('success', 'job closed successfully!');
				}else{
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}else{
	            $this->session->set_flashdata('error', validation_errors());
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

    // delete job progress details(AJ)
    public function deleteJobDetails($id=0)
	{
		if($id > 0 && $this->core_model->delete('job_progress', array('id' => $id)))
			$this->session->set_flashdata('success', 'Job progress details deleted successfully!');
		else
			$this->session->set_flashdata('error', 'Job progress details not deleted.');
	
	}
}
