<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends MY_Controller {

	function __construct()
    {
        parent::__construct();
        $this->allow();
        $this->allowAdmin('index','usersAjax','addStaff', 'deleteStaff','deleteFile', 'attendance','addAttendance','downloadAttendance');
		$this->allowStaff('index','usersAjax','addStaff', 'deleteStaff','deleteFile', 'attendance','addAttendance','downloadAttendance');

        $this->load->model('core_model');
        $this->load->model('ajax_model');
        $this->load->model('pdf_model');
	}

	function index() {
        $data["months"] = array();
        $this->db->order_by('date', 'asc');
        $lastEntry = $this->db->get_where('user_attendance', array())->row_array();
        if(!empty($lastEntry)){
            for ($i = 0; $i < 120; $i++) {
                if(date('F, Y', strtotime($lastEntry['date'])) ==  date('F, Y', strtotime("-$i month"))){
                    break;
                }
                array_push($data["months"], date('F, Y', strtotime("-$i month")));
            }
        }
        
        $result = $this->core_model->get_single_row('users', 'count(id) count', array('user_type !=' => 'admin'));
        $data["totalUsers"] = $result['count'];
		$data["active"] = "staff";
		$data['header'] = TRUE;
		$data['sidemenu'] = TRUE;
		$data['_view'] = "staff";
		$data['footer'] = TRUE;
        $this->load->view("basetemplate", $data);
	}


	public function usersAjax()
	{
		$data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];

        $Total = $this->ajax_model->usersCount($searchVal);

        if ($Total) {
            $result = $this->ajax_model->usersAjax($searchVal, $sortColIndex, $sortBy, $limit, $offset);
            $i = $offset;
            foreach ($result as $key => $item) {
                $offset++;
                $row = [];
                array_push($row,ucwords($item['name']));
                array_push($row,$item['user_type']);
                array_push($row,$item['user_type'] == 'worker'?$item['daily_wage']:'N/A');
                array_push($row,$item['user_type'] != 'worker'?$item['monthly_salary']:'N/A');
                array_push($row,$item['phone']);
                array_push($row,$item['address']);

                if(!empty($item['pan'])){
                    array_push($row,'<div class="dropdown">
                      <button  class="dropbtn">uploaded</button>
                      <div id="" class="dropdown-content myDropdown12">
                        <a href="'.base_url().'uploads/documents/'.$item['pan'].'" target="_blank">View</a>
                        <a href="javascript:void(0)" class="deleteFile" data-id="pan_'.$item['id'].'">Delete</a>
                      </div>
                    </div>');
                }else{
                    array_push($row,'<form role="form" class="uploadFile" method="post" action="'.base_url().'staff/uploadFile" enctype="multipart/form-data">
                            <label for="file-input'.$item['id'].'_pan">
                            <div><span class="red badge">missing</span></div>
                            </label>
                            <input type="file" name="file" class="file-input" id="file-input'.$item['id'].'_pan"/>
                            <input type="hidden" name="type" value="pan">
                            <input type="hidden" name="id" value="'.$item['id'].'">
                        </form>');
                }

                if(!empty($item['aadhar'])){
                    array_push($row,'<div class="dropdown">
                      <button  class="dropbtn">uploaded</button>
                      <div id="" class="dropdown-content myDropdown12">
                        <a href="'.base_url().'uploads/documents/'.$item['aadhar'].'" target="_blank">View</a>
                        <a href="javascript:void(0)" class="deleteFile" data-id="aadhar_'.$item['id'].'">Delete</a>
                      </div>
                    </div>');
                    
                }else{
                    array_push($row,'<form role="form" class="uploadFile" method="post" action="'.base_url().'staff/uploadFile" enctype="multipart/form-data">
                            <label for="file-input'.$item['id'].'_aadhar">
                            <div><span class="red badge">missing</span></div>
                            </label>
                            <input type="file" name="file" class="file-input" id="file-input'.$item['id'].'_aadhar"/>
                            <input type="hidden" name="type" value="aadhar">
                            <input type="hidden" name="id" value="'.$item['id'].'">
                        </form>');
                }
                if(!empty($item['medical'])){
                    array_push($row,'<div class="dropdown">
                      <button  class="dropbtn">uploaded</button>
                      <div id="" class="dropdown-content myDropdown12">
                        <a href="'.base_url().'uploads/documents/'.$item['medical'].'" target="_blank">View</a>
                        <a href="javascript:void(0)" class="deleteFile" data-id="medical_'.$item['id'].'">Delete</a>
                      </div>
                    </div>');
                }else{
                    array_push($row,'<form role="form" class="uploadFile" method="post" action="'.base_url().'staff/uploadFile" enctype="multipart/form-data">
                            <label for="file-input'.$item['id'].'_medical">
                            <div><span class="red badge">missing</span></div>
                            </label>
                            <input type="file" name="file" class="file-input" id="file-input'.$item['id'].'_medical"/>
                            <input type="hidden" name="type" value="medical">
                            <input type="hidden" name="id" value="'.$item['id'].'">
                        </form>');
                }

                if(!empty($item['resume'])){
                    array_push($row,'<div class="dropdown">
                      <button  class="dropbtn">uploaded</button>
                      <div id="" class="dropdown-content myDropdown12">
                        <a href="'.base_url().'uploads/documents/'.$item['resume'].'" target="_blank">View</a>
                        <a href="javascript:void(0)" class="deleteFile" data-id="resume_'.$item['id'].'">Delete</a>
                      </div>
                    </div>');
                }else{
                    array_push($row,'<form role="form" class="uploadFile" method="post" action="'.base_url().'staff/uploadFile" enctype="multipart/form-data">
                            <label for="file-input'.$item['id'].'_resume">
                            <div><span class="red badge">missing</span></div>
                            </label>
                            <input type="file" name="file" class="file-input" id="file-input'.$item['id'].'_resume"/>
                            <input type="hidden" name="type" value="resume">
                            <input type="hidden" name="id" value="'.$item['id'].'">
                        </form>');
                }

                if(!empty($item['passbook'])){
                    array_push($row,'<div class="dropdown">
                      <button  class="dropbtn">uploaded</button>
                      <div id="" class="dropdown-content myDropdown12">
                        <a href="'.base_url().'uploads/documents/'.$item['passbook'].'" target="_blank">View</a>
                        <a href="javascript:void(0)" class="deleteFile" data-id="passbook_'.$item['id'].'">Delete</a>
                      </div>
                    </div>');
                }else{
                    array_push($row,'<form role="form" class="uploadFile" method="post" action="'.base_url().'staff/uploadFile" enctype="multipart/form-data">
                            <label for="file-input'.$item['id'].'_passbook">
                            <div><span class="red badge">missing</span></div>
                            </label>
                            <input type="file" name="file" class="file-input" id="file-input'.$item['id'].'_passbook"/>
                            <input type="hidden" name="type" value="passbook">
                            <input type="hidden" name="id" value="'.$item['id'].'">
                        </form>');
                }
             
                $action = "";
                $action .= '<a class="btn waves-effect waves-light orange smallBtn" href="'.base_url().'staff/attendance/'.$item['id'].'">
                    ATTENDANCE
                </a>
                <a class="btn waves-effect waves-light gradient-45deg-light-blue-cyan smallBtn modal-trigger editButton" href="#editStaff"
                data-id="'.$item['id'].'"
                data-name="'.$item['name'].'"
                data-user_type="'.$item['user_type'].'"
                data-daily_wage="'.$item['daily_wage'].'"
                data-monthly_salary="'.$item['monthly_salary'].'"
                data-phone="'.$item['phone'].'"
                data-email="'.$item['email'].'"
                data-address="'.$item['address'].'"
                >
                    EDIT
                </a>';
                $action .= ' <a class="btn waves-effect waves-light gradient-45deg-purple-deep-orange deleteButton smallBtn" data-id="'.$item['id'].'">
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

    public function addStaff()
    {
        $data = $this->input->post();
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('monthly_salary', 'Monthly alary', 'required');
        $this->form_validation->set_rules('user_type', 'Type', 'required');
        if($this->form_validation->run()){
            
            $insert = $data;
            if($data['id']>0){
                if($this->core_model->updateData('users', $insert, array('id' =>$data['id']))){
                    $this->session->set_flashdata('success', 'Staff updated successfully!');
                }else{
                    $this->session->set_flashdata('error', 'Something went wrong, please try again later.');
                }
            }else{
                $password = generateRandomString(6);
                $insert['password'] = md5($password);
                if($this->core_model->insertData('users', $insert)){
                    if($data['user_type'] == 'Site Co-ordinator'){
                        $insert['password'] = $password;
                        $emailContent = get_email_template('add staff', $insert);
                        email($insert['email'], $emailContent);
                    }
                    $this->session->set_flashdata('success', 'Staff added successfully!');
                }else{
                    $this->session->set_flashdata('error', 'Something went wrong, please try again later.');
                }
            }
        }else{
            $this->session->set_flashdata('error', validation_errors());
        } 
        redirect($_SERVER['HTTP_REFERER']);                 
    }

    public function uploadFile($id=0)
    {
        $config['upload_path']   = './uploads/documents/'; 
        $config['allowed_types'] = 'jpg|png|jpeg'; 
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error', $error['error']);
        }
        else { 
            $data = array('upload_data' => $this->upload->data());
            if($this->core_model->updateData('users', array($_POST['type']=> $data['upload_data']['file_name']), array('id' =>$_POST['id']))){
                $this->session->set_flashdata('success', 'File uploaded successfully!');
            }else{
                $this->session->set_flashdata('error', 'Something went wrong, please try again later.');
            }
        }
        redirect($_SERVER['HTTP_REFERER']); 
    }


    // delete Staff(AJ)
    public function deleteStaff($id=0)
    {
        if($id > 0){
            $users = $this->core_model->get_single_row('users', '*', array('id' => $id));
            if(!empty($users) && $this->core_model->delete('users', array('id' => $id))){
                
                $url = FCPATH.'uploads/documents/'.$users['pan'];
                if(!empty($users['pan']) && @getimagesize($url)){
                    unlink($url);
                }

                $url = FCPATH.'uploads/documents/'.$users['aadhar'];
                if(!empty($users['aadhar']) && @getimagesize($url)){
                    unlink($url);
                }

                $url = FCPATH.'uploads/documents/'.$users['medical'];
                if(!empty($users['medical']) && @getimagesize($url)){
                    unlink($url);
                }

                $url = FCPATH.'uploads/documents/'.$users['resume'];
                if(!empty($users['resume']) && @getimagesize($url)){
                    unlink($url);
                }

                $url = FCPATH.'uploads/documents/'.$users['passbook'];
                if(!empty($users['passbook']) && @getimagesize($url)){
                    unlink($url);
                }
                $this->session->set_flashdata('success', 'Staff deleted successfully!');
            }else{
                $this->session->set_flashdata('error', 'Staff details not found to delete.');
            }
        }
        else{
            $this->session->set_flashdata('error', 'Staff not deleted.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

    // delete document of Staff(AJ)
    public function deleteFile($parameters='')
    {
        $data = explode("_", $parameters);
        if(!empty($data) && !empty($data[0]) &&!empty($data[1])){
            $users = $this->core_model->get_single_row('users', '*', array('id' => $data[1]));
            if(!empty($users)){
                
                $url = FCPATH.'uploads/documents/'.$users[$data[0]];
                if(!empty($users[$data[0]]) && @getimagesize($url)){
                    unlink($url);
                    $this->core_model->updateData('users', array($data[0]=>''), array('id' =>$users['id']));
                }
                $this->session->set_flashdata('success', 'Staff deleted successfully!');
            }else{
                $this->session->set_flashdata('error', 'Staff details not found to delete.');
            }
        }
        else{
            $this->session->set_flashdata('error', 'Staff not deleted.');
        }

        redirect($_SERVER['HTTP_REFERER']);
    }

	function attendance($id=0) {
        $data["user"] = $this->core_model->get_single_row('users', '*', array('id' => $id));
        // pr($data["user"]);exit;
        if(!empty($data["user"])){
            $data["attendance"] =$this->core_model->getUserAttendance($id);
            $data["active"] = "staff";
            $data['header'] = TRUE;
            $data['sidemenu'] = TRUE;
            $data['_view'] = "attendance";
            $data['footer'] = TRUE;
            $this->load->view("basetemplate", $data);
        }else{
            redirect('home/dashboard');
        }	
	}

    public function addAttendance()
    {
        $data = $this->input->post();
        
        $this->form_validation->set_rules('type', 'Type', 'required');
        if($this->form_validation->run()){
            $user = $this->core_model->get_single_row('users', '*', array('id' => $data['user_id']));
           
            if(isset($data['edit']))
                echo $data['date'] = substr($data['date'],4,11);
            
            if($user['user_type'] != 'worker' && $data['type'] == 'work_hours'){
                $data['type'] = 'attendance';
                $data['value'] = $data['attendance'];
            }
            
            $data['date'] =  date('Y-m-d', strtotime($data['date']));
            $user_attendance = $this->core_model->get_single_row('user_attendance', '*', array('date' => $data['date'], 'user_id'=>$data['user_id']));
            if(empty($user_attendance)){
                $insert = array(
                    'user_id'=>$data['user_id'],
                    'date'=>$data['date'],
                    $data['type'] =>$data['value']
                );
                $this->core_model->insertData('user_attendance', $insert);
            }else{
               $this->core_model->updateData('user_attendance',array($data['type'] =>$data['value']), array('id' =>$user_attendance['id']));
            }
            $this->session->set_flashdata('success', 'Record added successfully!');
        }else{
            $this->session->set_flashdata('error', validation_errors());
        } 
        redirect($_SERVER['HTTP_REFERER']);                 
    }
    public function downloadAttendance($date='')
    {
        if(empty($date)){
            $date = date("Y-m-d");
        }
        $data = $this->core_model->pdfData($date);
        $this->pdf_model->downloadAttendance($data, $date);
    }

}
