<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->allow();
        $this->allowAdmin('inventory', 'addInventory', 'deleteInventory', 'respond', 'assign','unassign', 'trackInventory', 'contractExpenses','operationalExpenses','getSites','getJobs','measurements','measurementsAjax','addMeasurements','deleteMeasurements','bills', 'billsAjax', 'addBills', 'addReceipt', 'deleteBills','materialOrders');
		$this->allowAdmin('inventory', 'addInventory', 'deleteInventory', 'respond', 'assign','unassign', 'trackInventory', 'contractExpenses','operationalExpenses','getSites','getJobs','measurements','measurementsAjax','addMeasurements','deleteMeasurements','bills', 'billsAjax', 'addBills', 'addReceipt', 'deleteBills','materialOrders');

        $this->load->model('core_model');
        $this->load->model('ajax_model');
	}

	function inventory() {
		$result = $this->core_model->getInventories();
		if(!empty($result)){
			$data["inventories"] = $result['result'];
			$data["count"] = $result['count'];
		}else{
			$data["inventories"] = array();
			$data["count"] = 0;
		}
		
		$data["contracts"] = $this->core_model->get_select_arr('contracts', 'id, title', array('status'=>'ongoing'), 'id', 'asc');
		$data["active"] = "inventory";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "inventory";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	// add and edit Inventory (AJ)
	function addInventory() {
		$this->form_validation->set_rules('name', 'Inventory Name', 'required');
		if($this->form_validation->run()){
			$insert = $this->input->post();
			if($insert['id']>0){
				if($this->core_model->updateData('inventory', $insert, array('id' =>$insert['id']))){
					$this->session->set_flashdata('success', 'inventory item updated successfully!');
				}else{
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}else{
				if($this->core_model->insertData('inventory', $insert)){
					$this->session->set_flashdata('success', 'Inventory item added successfully!');
				}else{
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect('user/inventory');
	}	


	// delete Inventory(AJ)
    public function deleteInventory($id=0)
	{
		if($id > 0 && $this->core_model->delete('inventory', array('id' => $id)))
			$this->session->set_flashdata('success', 'Inventory item deleted successfully!');
		else
			$this->session->set_flashdata('error', 'Inventory item not deleted.');

		redirect($_SERVER['HTTP_REFERER']);
	}

	// add and edit Inventory (AJ)
	function respond() {
		$this->form_validation->set_rules('group1', 'Appove or deny', 'required');
		if($this->form_validation->run()){
			$insert = $this->input->post();
			if($insert['assign_id']>0){
				if($insert['group1'] == 'on'){
					$this->core_model->updateData('assign_inventories', array('status' =>'assigned'), array('id' =>$insert['assign_id']));
					$data = $this->core_model->get_single_row('assign_inventories', '*', array('id' => $insert['assign_id']));
					$this->core_model->updateData('assign_inventories', array('status' =>'deny'), array('status' =>'requested','inventory_id' =>$data['inventory_id']));
				}else{
					$this->core_model->updateData('assign_inventories', array('status' =>'deny'), array('id' =>$insert['assign_id']));
				}
				$this->session->set_flashdata('success', 'inventory item updated successfully!');
			}else{
				$this->session->set_flashdata('error', 'Id not found.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect('user/inventory');
	}

	// delete Inventory(AJ)
    public function unassign($id=0)
	{
		if($id > 0 && $this->core_model->updateData('assign_inventories', array('status' =>'unassigned'), array('id' =>$id)))
			$this->session->set_flashdata('success', 'Inventory item deleted successfully!');
		else
			$this->session->set_flashdata('error', 'Inventory item not deleted.');

		redirect($_SERVER['HTTP_REFERER']);
	}

	// delete Inventory(AJ)
    public function assign($id=0)
	{
		
		$this->form_validation->set_rules('inventory_id', 'Inventory Item', 'required');
		$this->form_validation->set_rules('site_id', 'Site', 'required');
		$this->form_validation->set_rules('start_date', 'start date', 'required');
		$this->form_validation->set_rules('end_date', 'end date', 'required');
		if($this->form_validation->run()){
			$insert = $this->input->post();
			$data = $this->core_model->get_single_row('sites', 'supervisor_id', array('id' => $insert['site_id']));
			$insert['supervisor_id'] = $data['supervisor_id'];
			$insert['status'] = 'assigned';
			$insert['start_date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $insert['start_date'])));
	        $insert['end_date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $insert['end_date'])));
			if($this->core_model->insertData('assign_inventories', $insert)){
				$this->session->set_flashdata('success', 'Inventory assign successfully!');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect('user/inventory');
	}

	function trackInventory($id=0) {
		$data["inventory"] = $this->core_model->get_single_row('inventory', '*', array('id' => $id));
		if(!empty($data["inventory"])){
			$data1 = $this->core_model->track_records($id,'assigned');
			if(!empty($data1))
				$data["track"] =$data1;

			$data2 = $this->core_model->track_records($id,'unassigned');
			if(empty($data1))
				$data["track"] =$data2;
			else if(!empty($data2))
				$data["track"] = array_merge($data1, $data2);

			$data["active"] = "inventory";
			$data['header'] = TRUE;
			$data['sidemenu'] = TRUE;
			$data['_view'] = "trackInventory";
			$data['footer'] = TRUE;
	        $this->load->view("basetemplate", $data);
	    }else{
	    	$this->session->set_flashdata('error', 'Invalid Inventory.');
			redirect('home/dashboard');
	    }
	}
	function getSites() {
		$data = $this->input->post();
		$return = '';
		if($data['id'] > 0 ){ 
			$result = $this->core_model->getSites($data['id']);
			$return .='<select id="siteDD" name="site_id" required>';
			$return .='<option value="" selected disabled>Select Site</option>';;
			foreach ($result as $key => $value) {

				$return .='<option value="'.$value['id'].'">'.$value['title'].'</option>';
			}
			$return .='</select>';
			$msg = array('errcode' => 0,'result'=>$return);
		}else{
			$msg = array('errcode' => 100,'result'=>$return);
		}
		echo json_encode($msg);
	}

	function getJobs() {
		$data = $this->input->post();
		$return = '';
		if($data['id'] > 0 ){ 
			$result = $this->core_model->get_select_arr('jobs', '*', array('site_id'=>$data['id']), 'id', 'asc');
			$return .='<select id="jobDD" name="job_id" required>';
			$return .='<option value="" selected disabled>Select Job</option>';;
			foreach ($result as $key => $value) {

				$return .='<option value="'.$value['id'].'">'.$value['title'].'</option>';
			}
			$return .='</select>';
			$msg = array('errcode' => 0,'result'=>$return);
		}else{
			$msg = array('errcode' => 100,'result'=>$return);
		}
		echo json_encode($msg);
	}

	public function measurements($id=0)
	{
		$data["active"] = "measurements";
		$data["id"]=$id;
		if($id>0){
			$data["job"] = $this->core_model->get_jobDetails($id);
			// pr($data["job"]);exit;
			if(!empty($data["job"]))
				$data["active"] = "contracts";
	
		}
		$data["contracts"] = $this->core_model->get_select_arr('contracts', 'id, title', array('status'=>'ongoing'), 'id', 'asc');
		$data["workers"] = $this->core_model->get_select_arr('users', 'id, name', array('user_type'=>'worker'), 'id', 'asc');
		
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "measurements";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	public function measurementsAjax()
	{
		$data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $id = $data['job_id'];
        $c_id=$data['contract_id'];

        $Total = $this->ajax_model->measurementsAjaxCount($searchVal, $id, $c_id);

        if ($Total) {
            $result = $this->ajax_model->measurementsAjax($searchVal, $sortColIndex, $sortBy, $limit, $offset, $id,$c_id);
            $i = $offset;
            foreach ($result as $key => $item) {
                $offset++;
                $row = [];
                // array_push($row, $offset);
                array_push($row,$item['c_title']);
                array_push($row,$item['s_title']);
                array_push($row,$item['j_title']);
                array_push($row,date("d/m/Y",strtotime($item['date'])));

                $action = "";
                if(!empty($item['file_name'])){
                	$action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger" href="'.base_url().'uploads/measurements/'.$item['file_name'].'" style="margin-right:5px;" target="_blank">
	                    VIEW
	                </a>';
                }else{
	                $action .= '<a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" style="margin-right:5px;" data-tooltip="No File">VIEW</a>';
                }
                
                $action .= '<a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="'.$item['id'].'">
                    DELETE
                </a>';
                
                array_push($row, $action);
                $columns[] = $row;
            }
        }
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $Total,
            'recordsFiltered' => $Total,
            '$limit' => $limit,
            '$offset' => $offset,
        ];
        echo json_encode($response);
	}

	// add Measurements (AJ)
	function addMeasurements() {

		$this->form_validation->set_rules('job_id', 'Job Id', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		if($this->form_validation->run()){
			$insert = array(
				'job_id'=> $this->input->post('job_id'),
				'date'=> $this->input->post('date')
			);
			
			$insert['date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $insert['date'])));
			
			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
				$config['upload_path']   = './uploads/measurements/'; 
				$config['allowed_types'] = '*'; 
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					$insert['file_name'] = $data['upload_data']['file_name'];
				}
			}

			if($this->core_model->insertData('measurements', $insert)){
				$this->session->set_flashdata('success', 'Measurements added successfully!');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	// delete Measurements(AJ)
    public function deleteMeasurements($id=0)
	{
		if($id > 0){
			$measurements = $this->core_model->get_single_row('measurements', '*', array('id' => $id));
	        if(!empty($measurements)){
	        	$this->core_model->delete('measurements', array('id' => $id));
				$url = FCPATH.'uploads/measurements/'.$measurements['file_name'];
	            unlink($url);
	            $this->session->set_flashdata('success', 'measurements deleted successfully!');
	        }else{
	        	$this->session->set_flashdata('error', 'measurements details not deleted.');
	        }
		}
		else{
			$this->session->set_flashdata('error', 'measurements details not deleted.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function bills($id=0)
	{
		$data["active"] = "bills";
		$data["id"]=$id;
		if($id>0){
			$data["job"] = $this->core_model->get_jobDetails($id);
			if(!empty($data["job"]))
				$data["active"] = "contracts";
	
		}
		$data["contracts"] = $this->core_model->get_select_arr('contracts', 'id, title', array('status'=>'ongoing'), 'id', 'asc');
		$data["workers"] = $this->core_model->get_select_arr('users', 'id, name', array('user_type'=>'worker'), 'id', 'asc');
		
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "bills";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	public function billsAjax()
	{
		$data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $id = $data['job_id'];
        $c_id=$data['contract_id'];

        $Total = $this->ajax_model->billsAjaxCount($searchVal, $id, $c_id);

        if ($Total) {
            $result = $this->ajax_model->billsAjax($searchVal, $sortColIndex, $sortBy, $limit, $offset, $id,$c_id);
            $i = $offset;
            foreach ($result as $key => $item) {
                $offset++;
                $row = [];
                // array_push($row, $offset);
                array_push($row,$item['c_title']);
                array_push($row,$item['s_title']);
                array_push($row,$item['j_title']);
                array_push($row,date("d/m/Y",strtotime($item['date'])));
                array_push($row,$item['amount']);
                $action = "";
                if($item['status'] == 'unpaid'){
                	array_push($row,'<span class="red badge">unpaid</span>');
                	$action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger payBtn" href="#billReceipt" data-id="'.$item['id'].'" style="margin-right:5px;margin-bottom:5px;">
                        PAY
                    </a>';
                    if(!empty($item['bill_file'])){
	                	$action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger" href="'.base_url().'uploads/bills/'.$item['bill_file'].'" style="margin-right:5px;margin-bottom:5px;" target="_blank">
		                    VIEW 
		                </a>';
	                }else{
		                $action .= '<a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" style="margin-right:5px;margin-bottom:5px;" data-tooltip="No File">VIEW</a>';
	                }
                }else{
                	array_push($row,'<span class="green badge">paid</span>');
                	if(!empty($item['bill_file'])){
	                	$action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger" href="'.base_url().'uploads/bills/'.$item['bill_file'].'" style="margin-right:5px;margin-bottom:5px;" target="_blank">
		                    VIEW 
		                </a>';
	                }else{
		                $action .= '<a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" style="margin-right:5px;margin-bottom:5px;" data-tooltip="No File">VIEW</a>';
	                }

	                if(!empty($item['receipt_file'])){
	                	$action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger" href="'.base_url().'uploads/bills/'.$item['receipt_file'].'" style="margin-right:5px;margin-bottom:5px;" target="_blank">
		                    RECEIPT
		                </a>';
	                }else{
		                $action .= '<a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" style="margin-right:5px;margin-bottom:5px;" data-tooltip="No File">RECEIPT</a>';
	                }
	                
                }
                

                
                
                $action .= '<a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="'.$item['id'].'">
                    DELETE
                </a>';
                
                array_push($row, $action);
                $columns[] = $row;
            }
        }
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $Total,
            'recordsFiltered' => $Total,
            '$limit' => $limit,
            '$offset' => $offset,
        ];
        echo json_encode($response);
	}

	// add bills (AJ)
	function addBills() {
		$this->form_validation->set_rules('job_id', 'Job Id', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('amount', 'Amount', 'required');
		if($this->form_validation->run()){

			$insert = array(
				'job_id'=> $this->input->post('job_id'),
				'date'=> $this->input->post('date'),
				'amount'=> $this->input->post('amount')
			);
			$insert['date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $insert['date'])));
			
			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
				$config['upload_path']   = './uploads/bills/'; 
				$config['allowed_types'] = '*'; 
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					$insert['bill_file'] = $data['upload_data']['file_name'];
				}
			}
			if($this->core_model->insertData('bills', $insert)){
				$this->session->set_flashdata('success', 'Bills added successfully!');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	// add Bill Receipt (AJ)
	function addReceipt() {
		$this->form_validation->set_rules('id', 'Id', 'required');
		if($this->form_validation->run()){
			$update = array('status'=>'paid');
			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
				$config['upload_path']   = './uploads/bills/'; 
				$config['allowed_types'] = '*'; 
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					$insert['receipt_file'] = $data['upload_data']['file_name'];
				}
			}
			if($this->core_model->updateData('bills', $update, array('id' =>$this->input->post('id')))){
				$this->session->set_flashdata('success', 'Bill Receipt updated successfully!');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	// delete Bills(AJ)
    public function deleteBills($id=0)
	{
		if($id > 0){
			$bills = $this->core_model->get_single_row('bills', '*', array('id' => $id));
	        if(!empty($bills)){
	        	$this->core_model->delete('bills', array('id' => $id));
				$url = FCPATH.'uploads/bills/'.$bills['bill_file'];
	            unlink($url);
	            if(!empty($bills['receipt_file'])){
	            	$url = FCPATH.'uploads/bills/'.$bills['receipt_file'];
	            	unlink($url);
	            }
	            $this->session->set_flashdata('success', 'bills deleted successfully!');
	        }else{
	        	$this->session->set_flashdata('error', 'bills details not deleted.');
	        }
		}
		else{
			$this->session->set_flashdata('error', 'bills details not deleted.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}


	public function orderItems($id=0)
	{
		$data["order"] = $this->core_model->get_single_row('material_orders', '*', array('id' => $id));
		$data["orderItems"] = $this->core_model->get_select_arr('order_items', '*', array('order_id'=>$id));
		$data["totalCost"] = 0;
		foreach ($data["orderItems"] as $key => $value) {
			$data["totalCost"] = $data["totalCost"] + ($value['quantity'] * $value['rate']);
		}
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data["active"] = "materialOrders";
		$data['_view'] = "orderItems";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	public function materialOrders($id=0)
	{
		$data["active"] = "materialOrders";
		$data["id"]=$id;
		if($id>0){
			$data["job"] = $this->core_model->get_jobDetails($id);
			if(!empty($data["job"]))
				$data["active"] = "contracts";
	
		}
		$data["contracts"] = $this->core_model->get_select_arr('contracts', 'id, title', array('status'=>'ongoing'), 'id', 'asc');
		$data["workers"] = $this->core_model->get_select_arr('users', 'id, name', array('user_type'=>'worker'), 'id', 'asc');

		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "materialOrders";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	public function materialOrdersAjax()
	{
		$data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $id = $data['job_id'];
        $c_id=$data['contract_id'];

        $Total = $this->ajax_model->materialOrdersAjaxCount($searchVal, $id, $c_id);

        if ($Total) {
            $result = $this->ajax_model->materialOrdersAjax($searchVal, $sortColIndex, $sortBy, $limit, $offset, $id,$c_id);
            $i = $offset;
            foreach ($result as $key => $item) {
                $offset++;
                $row = [];
                // array_push($row, $offset);
                array_push($row,$item['c_title']);
                array_push($row,$item['s_title']);
                array_push($row,$item['j_title']);
                array_push($row,date("d/m/Y",strtotime($item['date'])));
                array_push($row,$item['name']);
                array_push($row,'₹ '.$item['amount']);
                $action = "";
            	$action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn" href="'.base_url().'user/orderItems/'.$item['id'].'">VIEW</a>';

                $action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger editBtn" href="#editMaterialOrder" 
                data-id="'.$item['id'].'" 
                data-name="'.$item['name'].'" 
                data-jobid="'.$item['job_id'].'" 
                style="margin:0px 5px;">
                    EDIT
                </a>';
                
                $action .= '<a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="'.$item['id'].'">
                    DELETE
                </a>';
                
                array_push($row, $action);
                $columns[] = $row;
            }
        }
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $Total,
            'recordsFiltered' => $Total,
            '$limit' => $limit,
            '$offset' => $offset,
        ];
        echo json_encode($response);
	}

	// add Material Order (AJ)
	function addMaterialOrders() {
		$this->form_validation->set_rules('job_id', 'Job Id', 'required');
		$this->form_validation->set_rules('name', 'Mterial Name', 'required');
		// $this->form_validation->set_rules('item_name', 'Item Name', 'required');
		// $this->form_validation->set_rules('quantity', 'Quantity', 'required');
		// $this->form_validation->set_rules('rate', 'Rate', 'required');
		if($this->form_validation->run()){
			$data = $this->input->post();
			
			$insert = array(
				'date' =>date('Y-m-d'),
				'job_id' => $data['job_id'],
				'name' => $data['name']
			);
			
			$order_items =  array();
			
			if($data['id']>0){
				if($this->core_model->updateData('material_orders', $insert, array('id' =>$data['id']))){
					$this->core_model->delete('order_items', array('order_id' => $data['id']));
					foreach ($data['item_name'] as $key => $value) {
						$temp = array(
							'order_id' => $data['id'],
							'item_name' => $value,
							'quantity' => $data['quantity'][$key],
							'rate' => $data['rate'][$key]
						);
						$amount += ($data['quantity'][$key] * $data['rate'][$key]);
						array_push($order_items, $temp);
					}
					$amount = number_format((float)$amount, 2, '.', '');
					$this->core_model->updateData('material_orders', array('amount'=> $amount), array('id' =>$data['id']));
					$this->db->insert_batch('order_items', $order_items); 
					$this->session->set_flashdata('success', 'Material order details updated successfully!');
				}else{
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}else{
				if($this->core_model->insertData('material_orders', $insert)){
					$order_id = $this->db->insert_id();
					$amount = 0.00;
					foreach ($data['item_name'] as $key => $value) {
						$temp = array(
							'order_id' => $order_id,
							'item_name' => $value,
							'quantity' => $data['quantity'][$key],
							'rate' => $data['rate'][$key]
						);
						$amount += ($data['quantity'][$key] * $data['rate'][$key]);
						array_push($order_items, $temp);
					}
					$amount = number_format((float)$amount, 2, '.', '');
					$this->core_model->updateData('material_orders', array('amount'=> $amount), array('id' =>$order_id));
					$this->db->insert_batch('order_items', $order_items); 
					$this->session->set_flashdata('success', 'Material order details added successfully!');
				}else{
					$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
				}
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	function getItems($id) {
		$return = '';
		if($id > 0 ){ 
			$orders = $this->core_model->get_select_arr('order_items', '*', array('order_id'=>$id));
			foreach ($orders as $key => $value) {
				
				if($key == 0){
            		$return .= '<div class="row itemFirst orderItems">';
            	}else{
            		$return .= '<div class="row orderItems">';
            	}
		            $return .= '<div class="input-field col s4" style="padding: 0px;">
		                <input type="text" name="item_name[]" value="'.$value['item_name'].'">
		                <label for="item_name" style="left: 0px;">Item Name</label>
		            </div>
		            <div class="input-field col s3" style="padding-left: 10px;">
		                <input type="text" name="quantity[]" value="'.$value['quantity'].'">
		                <label for="quantity" style="left: 10px;">Quantity</label>
		            </div>
		            <div class="input-field col s3" style="padding-left: 10px;">
		                <input type="text" name="rate[]" value="'.$value['rate'].'">
		                <label for="rate" style="left: 10px;">Rate</label>
		            </div>
		            <div class="input-field col s2">';
		            	if($key == 0){
		            		$return .= '<a class="btn waves-effect waves-light gradient-45deg-green-teal smallBtn addMore">ADD</a>';
		            	}else{
		            		$return .= '<i class="material-icons dp48 removeItem">remove_circle</i>';
		            	}
		            $return .= '</div>
		        </div>';
			}
			$msg = array('errcode' => 0,'result'=>$return);
		}else{
			$msg = array('errcode' => 100,'result'=>$return);
		}
		echo json_encode($msg);
	}


	// delete Material Order(AJ)
    public function deleteMaterialOrders($id=0)
	{
		if($id > 0 && $this->core_model->delete('material_orders', array('id' => $id))){
			$this->session->set_flashdata('success', 'Material Order deleted successfully!');
		}
		else{
			$this->session->set_flashdata('error', 'Material Order not deleted.');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function contractExpenses($id=0)
	{
		$data["active"] = "contractExpenses";
		$data["id"]=$id;
		if($id>0){
			$data["job"] = $this->core_model->get_jobDetails($id);
			if(!empty($data["job"]))
				$data["active"] = "contracts";
	
		}
		$data["contracts"] = $this->core_model->get_select_arr('contracts', 'id, title', array('status'=>'ongoing'), 'id', 'asc');
		$data["workers"] = $this->core_model->get_select_arr('users', 'id, name', array('user_type'=>'worker'), 'id', 'asc');
		
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "contractExpenses";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	public function contractExpensesAjax()
	{
		$data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $id = $data['job_id'];
        $c_id=$data['contract_id'];

        $Total = $this->ajax_model->contractExpensesAjaxCount($searchVal, $id, $c_id);

        if ($Total) {
            $result = $this->ajax_model->contractExpensesAjax($searchVal, $sortColIndex, $sortBy, $limit, $offset, $id,$c_id);
            $i = $offset;
            foreach ($result as $key => $item) {
                $offset++;
                $row = [];
                // array_push($row, $offset);
                array_push($row,$item['c_title']);
                array_push($row,$item['s_title']);
                array_push($row,$item['j_title']);
                array_push($row,$item['title']);
                array_push($row,date("d/m/Y",strtotime($item['date'])));
                array_push($row,$item['amount']);
                $action = "";
                if(!empty($item['file_name'])){
                	$action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger" href="'.base_url().'uploads/expenses/'.$item['file_name'].'" style="margin-right:5px;" target="_blank">
	                    VIEW
	                </a>';
                }else{
	                $action .= '<a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" style="margin-right:5px;" data-tooltip="No File">VIEW</a>';
                }
                $action .= '<a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="'.$item['id'].'">
                    DELETE
                </a>';
                
                array_push($row, $action);
                $columns[] = $row;
            }
        }
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $Total,
            'recordsFiltered' => $Total,
            '$limit' => $limit,
            '$offset' => $offset,
        ];
        echo json_encode($response);
	}

	// add contract Expenses (AJ)
	function addContractExpenses() {
		$this->form_validation->set_rules('job_id', 'Job Id', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('amount', 'Smount', 'required');
		if($this->form_validation->run()){
			
			$insert = array(
				'job_id'=> $this->input->post('job_id'),
				'title'=> $this->input->post('title'),
				'date'=> $this->input->post('date'),
				'amount'=> $this->input->post('amount')
			);
			$insert['date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $insert['date'])));
			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
				
				$config['upload_path']   = './uploads/expenses/'; 
				$config['allowed_types'] = '*'; 
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					$insert['file_name'] = $data['upload_data']['file_name'];
				}
			}
			if($this->core_model->insertData('expenses', $insert)){
				$this->session->set_flashdata('success', 'Expenses added successfully!');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function operationalExpenses($id=0)
	{
		$data["months"] = array();
		$this->db->order_by('date', 'asc');
		$lastEntry = $this->db->get_where('expenses', array('job_id' => 0))->row_array();
		
		if(empty($lastEntry)){
			array_push($data["months"], date('F, Y'));
		}else{
			for ($i = 0; $i < 120; $i++) {
				array_push($data["months"], date('F, Y', strtotime("-$i month")));
				if(date('F, Y', strtotime($lastEntry['date'])) ==  date('F, Y', strtotime("-$i month"))){
					break;
				}
			}
		}
		$data["categories"] = $this->core_model->getExpensesCategory();
		$data["workers"] = $this->core_model->get_select_arr('users', 'id, name', array('user_type'=>'worker'), 'id', 'asc');
		// pr($data);exit;
		$data["active"] = "operationalExpenses";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "operationalExpenses";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}

	public function operationalExpensesAjax()
	{
		$data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $month = $data['month'];

        $Total = $this->ajax_model->operationalExpensesCount($searchVal, $month);
       
        if ($Total) {
            $result = $this->ajax_model->operationalExpensesAjax($searchVal, $sortColIndex, $sortBy, $limit, $offset, $month);
            $i = $offset;
            foreach ($result as $key => $item) {
                $offset++;
                $row = [];
                // array_push($row, $offset);
                array_push($row,$item['title']);
                array_push($row,date("d/m/Y",strtotime($item['date'])));
                array_push($row,$item['amount']);
                array_push($row,'<span class="green badge">'.$item['category'].'</span>');
                $action = "";
                if(!empty($item['file_name'])){
                	$action .= '<a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger" href="'.base_url().'uploads/expenses/'.$item['file_name'].'" style="margin-right:5px;" target="_blank">
	                    VIEW
	                </a>';
                }else{
	                $action .= '<a class="btn waves-effect waves-light grey lighten-1 smallBtn tooltipped" data-position="bottom" style="margin-right:5px;" data-tooltip="No File">VIEW</a>';
                }
                $action .= '<a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="'.$item['id'].'">
                    DELETE
                </a>';
                
                array_push($row, $action);
                $columns[] = $row;
            }
        }
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $Total,
            'recordsFiltered' => $Total,
            '$limit' => $limit,
            '$offset' => $offset,
        ];
        echo json_encode($response);
	}

	// add contract Expenses (AJ)
	function addOperationalExpenses() {

		$this->form_validation->set_rules('category', 'Category', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('amount', 'Smount', 'required');
		if($this->form_validation->run()){

			$insert = array(
				'job_id'=> 0,
				'category'=> strtolower(trim($this->input->post('category'))),
				'title'=> $this->input->post('title'),
				'date'=> $this->input->post('date'),
				'amount'=> $this->input->post('amount')
			);
			$insert['date'] =  date('Y-m-d', strtotime(str_replace('/', '-', $insert['date'])));
			if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
				$config['upload_path']   = './uploads/expenses/'; 
				$config['allowed_types'] = '*'; 
				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')) {
					$error = array('error' => $this->upload->display_errors());
					$this->session->set_flashdata('error', $error['error']);
				}else{
					$data = array('upload_data' => $this->upload->data());
					$insert['file_name'] = $data['upload_data']['file_name'];
				}
			}

			if($this->core_model->insertData('expenses', $insert)){
				$this->session->set_flashdata('success', 'Expenses added successfully!');
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, please try again later.');
			}
		}else{
            $this->session->set_flashdata('error', validation_errors());
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	// delete Expenses(AJ)
    public function deleteExpenses($id=0)
	{
		if($id > 0){
			$expenses = $this->core_model->get_single_row('expenses', '*', array('id' => $id));
	        if(!empty($expenses)){
	        	$this->core_model->delete('expenses', array('id' => $id));
				$url = FCPATH.'uploads/expenses/'.$expenses['file_name'];
	            unlink($url);
	            $this->session->set_flashdata('success', 'Expenses deleted successfully!');
	        }else{
	        	$this->session->set_flashdata('error', 'Expenses details not deleted.');
	        }
		}
		else{
			$this->session->set_flashdata('error', 'Expenses details not deleted.');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

}
