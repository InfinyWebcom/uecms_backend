<?php

Class Core_Model extends CI_Model{
    

    //=============================================================================
    /**
        * Author: Ajay Salunkhe
        * 
        * Core Model
        * This modal is use for commaon queries
    */
    //=============================================================================



    // Get user data by user id 
    function getUserData($id = 0){
        return $this->db->get_where('users', array('id' => $id))->row_array();
    }

    // get full table data
    public function get_table_data($table)
    {
        $query = $this->db->get($table);
        return $query->result();
    }


    // get table data with where condition, selected column and order by
    // data is in array form
    public function get_select_arr($table, $select, $wheres = array(), $order_col = '', $order = '') {
        $this->db->select($select);
        $this->db->from($table);
        if(!empty($wheres)) {
            foreach ($wheres AS $key => $where) {
                $this->db->where($key, $where);
            }
        }
        if(!empty($order)) {
            $this->db->order_by($order_col, $order);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    // get single row query
    public function get_single_row($table, $select, $wheres = array()) {
        $this->db->select($select);
        $this->db->from($table);
        if(!empty($wheres)) {
            foreach ($wheres AS $key => $where) {
                $this->db->where($key, $where);
            }
        }
        $query = $this->db->get();
        return $query->row_array();
    }

    // insert sigle row
    public function insertData($table, $data) {
        $this->db->insert($table, $data);
        $last_id = $this->db->insert_id();
        return $last_id;
    }

    // update data
    public function updateData($table, $data, $condition) {
        $this->db->update($table, $data, $condition);
        return true;
    }

    // delete data
    public function delete($table, $condition) {
        $this->db->delete($table,$condition);
        // $this->db->where($col, $id);
        // $this->db->delete($table);
        return true;
    }

    // IN query with select and where condition
    // data is in array form
    public function get_where_in_arr($table, $select, $wheres = array()) {
        $this->db->select($select);
        $this->db->from($table);
        if(!empty($wheres)) {
            foreach ($wheres AS $key => $where) {
                $this->db->where_in($key, $where);
            }
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // Change Password 
    function changePassword($postArray){
        return $this->db->update('users', array('password' => md5($postArray['new_password'])), array('id' => $this->session->userdata('id')));
    }

     // Reset password after forgot password
    function resetPassword($postArray){
      return  $this->db->update('users', array('password' => md5($postArray['new_password']),'change_password_token' => ''), array('change_password_token' => $postArray['token'])); 
    }

    // Check Password 
    function checkPassword($postArray){
        $check = $this->db->get_where('users', array('id' => $this->session->userdata('id'), 'password' => md5($postArray['current_password'])))->row_array();
        if(empty($check)){
            return false;
        }
        else{
            return true;
        }
    }
    function deleteDocument($id=0)
    {
        $document = $this->core_model->get_single_row('documents', '*',  array('id' => $id));
        $url = FCPATH.'uploads/documents/'.$document['file'];
        $this->core_model->delete('documents', array('id' => $id));
        if(!empty($document)){
            unlink($url);
            return true;
        }
        return false;
    }

    function profile($data,$user)
    {
        if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
            $config['upload_path']   = './uploads/images/avatars/'; 
            $config['allowed_types'] = 'jpg|png|jpeg'; 
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error', $error['error']);
                return false;
            }else{
                $imageData = array('upload_data' => $this->upload->data());
                $data['profile_img'] = $imageData['upload_data']['file_name'];
                if(!empty($user['profile_img'])){
                    $url = FCPATH.'uploads/images/avatars/'.$user['profile_img'];
                    if(isset($url)){
                        unlink($url);
                    }
                }
            }
        }
        if($this->core_model->updateData('users', $data, array('id' => $this->session->userdata('id')))){
            return true;
        }
        else{
            return false;
        }
    }

    //get clients data with number of contracts
    public function get_clients() {
        return 
        $this->db->query('SELECT DISTINCT clients.*, 
           (SELECT COUNT(*) FROM contracts
            WHERE client_id = clients.id) AS contractsCount
        FROM clients'
        )->result_array();
    }


    //get contracts data
    public function getGraphData($date) {
        $this->db->where("YEAR(end_date) = '".date("Y", strtotime($date))."' AND Month(end_date) = '".date("m", strtotime($date))."'");
        $this->db->select('SUM(amount) as amount');
        $contracts = $this->db->get_where('contracts', array())->row_array();

        $this->db->where("YEAR(date) = '".date("Y", strtotime($date))."' AND Month(date) = '".date("m", strtotime($date))."'");
        $this->db->select('SUM(amount) as amount');
        $bills = $this->db->get_where('bills', array())->row_array();

        $this->db->where("YEAR(date) = '".date("Y", strtotime($date))."' AND Month(date) = '".date("m", strtotime($date))."'");
        $this->db->select('SUM(amount) as amount');
        $expenses = $this->db->get_where('expenses', array())->row_array();

        $this->db->where("YEAR(date) = '".date("Y", strtotime($date))."' AND Month(date) = '".date("m", strtotime($date))."'");
        $this->db->select('SUM(amount) as amount');
        $material_orders = $this->db->get_where('material_orders', array())->row_array();
        if($_SESSION['user_type'] == 'admin'){
            $return['data'] = array(
                number_format((float)$contracts['amount'], 2, '.', ''),
                number_format((float)$bills['amount'], 2, '.', ''),
                number_format((float)($expenses['amount']+ $material_orders['amount']), 2, '.', ''),
                number_format((float)$contracts['amount'] - ($bills['amount'] + $expenses['amount'] + $material_orders['amount']), 2, '.', '')
            );
            $return['labels'] = array("Contract Amount", "Billed Amount","Expenses","Profitability");
        }else{
            $return['data'] = array(
                number_format((float)$contracts['amount'], 2, '.', ''),
                number_format((float)$bills['amount'], 2, '.', '')
            );
            $return['labels'] = array("Contract Amount", "Billed Amount");
        }        
        return $return;
    }

    //get contracts data
    public function get_contracts() {
        $this->db->select('contracts.*,clients.name');
        $this->db->join('clients', 'clients.id=contracts.client_id', 'left');
        $this->db->order_by('contracts.id', 'desc');
        return $this->db->get_where('contracts', array())->result_array();
    }

    //get groups data with number of sites
    public function get_groups($id) {
        return $this->db->query("SELECT DISTINCT `groups`.*, `users`.name, (SELECT COUNT(*) FROM `sites` WHERE group_id = `groups`.id) AS sitesCount FROM `groups` JOIN `users` ON `users`.id = `groups`.manager_id WHERE `groups`.contract_id =".$id
        )->result_array();
    }

    //get groups data with number of sites
    public function get_sites($id) {
        return 
        $this->db->query("SELECT DISTINCT `sites`.*, users.name, (SELECT COUNT(*) FROM `jobs` WHERE site_id = `sites`.id) AS count FROM `sites` JOIN `users` ON users.id = `sites`.supervisor_id WHERE `sites`.group_id = ".$id
        )->result_array();
    }

    //get single contract,group,site details
    public function get_siteDetails($id) {
        $this->db->select("sites.*, users.name as username, groups.id as group_id, groups.title as g_title, contracts.id as contract_id, contracts.status, contracts.title as c_title");
        $this->db->from('sites');
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->where('sites.id', $id);
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        $this->db->join('users', 'users.id = sites.supervisor_id', 'left');
        return $this->db->get()->row_array();
    }

    //get single contract,group,site, job details
    public function get_jobDetails($id) {
        $this->db->select("jobs.*, jobs.status as jobStatus,sites.id as site_id,sites.title as s_title,groups.id as group_id, groups.title as g_title, contracts.id as contract_id, contracts.status, contracts.title as c_title");
        $this->db->from('jobs');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        $this->db->where('jobs.id', $id);
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        return $this->db->get()->row_array();
    }

    //get job listing
    public function getJobs($id) {
        $result = $this->core_model->get_select_arr('jobs', '*', array('site_id'=>$id), 'id', 'asc');
        foreach ($result as $key => $value) {
            $data = $this->core_model->get_single_row('measurements', 'COUNT(*) as col', array('job_id' => $value['id']));
            $result[$key]['measurements'] = $data['col'];

            $data = $this->core_model->get_single_row('material_orders', 'COUNT(*) as col', array('job_id' => $value['id']));
            $result[$key]['material_orders'] = $data['col'];

            $data = $this->core_model->get_single_row('expenses', 'COUNT(*) as col', array('job_id' => $value['id']));
            $result[$key]['expenses'] = $data['col'];

            $data = $this->core_model->get_single_row('bills', 'COUNT(*) as col', array('job_id' => $value['id']));
            $result[$key]['bills'] = $data['col'];

            $data = $this->core_model->get_single_row('bills', 'COUNT(*) as col', array('job_id' => $value['id'], 'status' => 'paid'));
            $result[$key]['paid_bills'] = $data['col'];
        }
        return $result;
    }

    //get single contract,group,site, job details
    public function getJobProgress($id) {
        $this->db->select("job_progress.*, users.name as worker");
        $this->db->from('job_progress');
        $this->db->join('users', 'users.id = job_progress.worker_id');
        $this->db->where('job_progress.job_id', $id);
        return $this->db->get()->result_array();
    }


    // get Inventories data with assign details(AJ)
    public function getInventories() {
        $result =array();
        $data= $this->db->get_where('inventory', array())->result_array();
        if(!empty($data)){
            $result['count'] = count($data);
            $i = 0;
            foreach ($data as $key => $value) {
                $temp = $value;
                $assign_inventories = $this->db->get_where('assign_inventories', array('status'=>'assigned','inventory_id'=>$value['id']))->row_array();
                if(empty($assign_inventories)){
                    $this->db->order_by('assign_inventories.id', 'desc');
                    $assign_inventories = $this->db->get_where('assign_inventories', array('status'=>'requested','inventory_id'=>$value['id']))->result_array();
                    if(!empty($assign_inventories)){
                        foreach ($assign_inventories as $k => $v) {
                            $temp['assign_id'] = $v['id'];
                            unset($v['id']);
                            $temp = array_merge($temp,$v);
                            $temp["site"] = $this->core_model->get_siteDetails($temp['site_id']);
                            $result['result'][$i] = $temp;
                            $i++;
                        }
                    }else{
                        $result['result'][$i] = $temp;
                        $i++;
                    }
                }else{
                    $temp['assign_id'] = $assign_inventories['id'];
                    unset($assign_inventories['id']);
                    $temp = array_merge($temp,$assign_inventories);
                    $temp["site"] = $this->core_model->get_siteDetails($temp['site_id']);
                    $result['result'][$i] = $temp;
                    $i++;
                }
            }
        }
        // pr($result);exit;
        return $result;
    }

    // get Inventories data with assign details(AJ)
    public function track_records($id, $status = 'assigned') {
        $this->db->select("inventory.name, users.name username, assign_inventories.*, contracts.title as c_title, sites.title as s_title");
        $this->db->from('inventory');
        $this->db->join('assign_inventories', 'inventory.id = assign_inventories.inventory_id', 'left');
        $this->db->where('inventory.id', $id);
        $this->db->where('assign_inventories.status', $status);
        $this->db->join('sites', 'sites.id = assign_inventories.site_id', 'left');
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        $this->db->join('users', 'users.id = assign_inventories.supervisor_id', 'left');
        return $this->db->get()->result_array();
    }

    // get sites(AJ)
    public function getSites($id) {
        $this->db->select("sites.title,sites.id");
        $this->db->from('contracts');
        $this->db->join('groups', 'contracts.id = groups.contract_id');
        $this->db->where('contracts.id', $id);
        $this->db->join('sites', 'groups.id = sites.group_id');
        return $this->db->get()->result_array();
    }

    // get Unassigned Inventory(AJ)
    public function getUnassignedInventory() {
        $cond = $this->db->query("SELECT GROUP_CONCAT(assign_inventories.inventory_id) as assign_inventories FROM `assign_inventories` WHERE status = 'assigned'")->row_array();
        if(empty($cond['assign_inventories'])){
            $cond['assign_inventories'] = 0;
        }
        $this->db->select("*");
        $this->db->from('inventory');
        $this->db->where('inventory.id NOT IN ('.$cond['assign_inventories'].')');
        return $this->db->get()->result_array();
    }

    // get Assigned Inventory(AJ)
    public function getAssignedInventory($id) {
        $this->db->select("assign_inventories.*, inventory.name");
        $this->db->from('inventory');
        $this->db->join('assign_inventories', 'inventory.id = assign_inventories.inventory_id');
        $this->db->where_in('assign_inventories.status', array('assigned','requested','deny'));
        $this->db->where('assign_inventories.site_id', $id);
        return $this->db->get()->result_array();
    }

    public function getExpensesCategory(){
        return $result= $this->db->query('SELECT category FROM `expenses` where job_id =0 group BY category')->result_array();
    }

    // get get User Attendance(AJ)
    public function getUserAttendance($id) {
        $return = array();
        $this->db->select("*");
        $this->db->from('user_attendance');
        $this->db->where('user_id', $id);
        $result = $this->db->get()->result_array();
        
        foreach ($result as $key => $value) {
            
            if(!empty($value['work_hours'])){
                $value['selected'] = 'work_hours';
                $temp = array('custom' => $value);
                $temp['start']= $value['date'];
                $temp['title']= 'Work Hours - '.$value['work_hours'];
                $temp['color']= '#3f51b5';
                array_push($return, $temp);
            }else if($value['attendance'] == 'Present' || $value['attendance']){
                $value['selected'] = 'work_hours';
                $temp = array('custom' => $value);
                $temp['start']= $value['date'];
                $temp['title']= $value['attendance'];
                $temp['color']= '#3f51b5';
                array_push($return, $temp);
            }

            if(!empty($value['ot_hours']) && $value['ot_hours'] > 0){
                $value['selected'] = 'ot_hours';
                $temp = array('custom' => $value);
                $temp['start']= $value['date'];
                $temp['title']= 'OT Hours - '.$value['ot_hours'];
                $temp['color']= '#00bcd4';
                array_push($return, $temp);
            }

            if(!empty($value['travel']) && $value['travel'] > 0){
                $value['selected'] = 'travel';
                $temp = array('custom' => $value);
                $temp['start']= $value['date'];
                $temp['title']= 'Travel: ₹ '.$value['travel'];
                $temp['color']= '#009688';
                array_push($return, $temp);
            }

            if(!empty($value['misc']) && $value['misc'] > 0){
                $value['selected'] = 'misc';
                $temp = array('custom' => $value);
                $temp['start']= $value['date'];
                $temp['title']= 'Misc.: ₹ '.$value['misc'];
                $temp['color']= '#009688';
                array_push($return, $temp);
            }

            if(!empty($value['debit']) && $value['debit'] > 0){
                $value['selected'] = 'debit';
                $temp = array('custom' => $value);
                $temp['start']= $value['date'];
                $temp['title']= 'Debit: ₹ '.$value['debit'];
                $temp['color']= '#e51c23';
                array_push($return, $temp);
            }
        }
        // pr($return);exit;
        return $return;
    }

    // get gpdf data of attendance (AJ)
    public function pdfData($date) {
        $this->db->select("*");
        $this->db->from('users');
        $this->db->where('user_type !=', 'admin');
        $return= $this->db->get()->result_array();
        
        foreach ($return as $key => $value) {
            $result= $this->db->query('SELECT 
                SUM(work_hours) AS Total_work_hours, 
                SUM(ot_hours) AS Total_ot_hours, 
                SUM(travel) AS Total_travel, 
                SUM(misc) AS Total_misc, 
                SUM(debit) AS Total_debit 
                FROM `user_attendance` 
                WHERE 
                YEAR(date) ="'.date("Y", strtotime($date)).'" 
                AND Month(date) ="'.date("m", strtotime($date)).'" 
                AND user_id = '.$value['id'])->row_array();

            

            $return[$key]['Total_ot_hours']= $result['Total_ot_hours']>0?$result['Total_ot_hours']:0;
            $return[$key]['Total_travel']= $result['Total_travel']>0?$result['Total_travel']:0;
            $return[$key]['Total_misc']= $result['Total_misc']>0?$result['Total_misc']:0;
            $return[$key]['Total_debit']= $result['Total_debit']>0?$result['Total_debit']:0;
            $payable = 0;
            if($value['user_type'] == 'worker'){
                $return[$key]['Total_work_hours']= $result['Total_work_hours']>0 ? $result['Total_work_hours'] : 0;
                $oneDayPayment = $value['daily_wage']/8;
                $return[$key]['payable'] = ($oneDayPayment*$return[$key]['Total_work_hours']) + ($oneDayPayment*$return[$key]['Total_ot_hours']) + $return[$key]['Total_travel'] + $return[$key]['Total_misc'] - $return[$key]['Total_debit'];
            }else{
                $result1= $this->db->query('SELECT COUNT(*) as count 
                FROM `user_attendance` 
                WHERE attendance="Present" AND
                YEAR(date) ="'.date("Y", strtotime($date)).'" 
                AND Month(date) ="'.date("m", strtotime($date)).'" 
                AND user_id = '.$value['id'].' 
                GROUP BY attendance')->row_array();
                $return[$key]['present_days']= !empty($result1) && $result1['count']>0 ? $result1['count']: 0;

                $result1= $this->db->query('SELECT COUNT(*) as count 
                FROM `user_attendance` 
                WHERE attendance="Absent" AND
                YEAR(date) ="'.date("Y", strtotime($date)).'" 
                AND Month(date) ="'.date("m", strtotime($date)).'" 
                AND user_id = '.$value['id'].' 
                GROUP BY attendance')->row_array();
                $return[$key]['absent_days']= !empty($result1) && $result1['count']>0 ? $result1['count']: 0;
                $return[$key]['Total_work_hours']= !empty($result1) && $result1['count']>0 ? $result1['count']*8: 0;
                $oneDayPayment = $value['monthly_salary']/30/8;
                $return[$key]['payable'] = ($value['monthly_salary'] - ($oneDayPayment*$return[$key]['Total_work_hours'])) + ($oneDayPayment*$return[$key]['Total_ot_hours']) + $return[$key]['Total_travel'] + $return[$key]['Total_misc'] - $return[$key]['Total_debit'];
            }
            
        }
        // pr($return);
        // exit;
        return $return;
        // pr($return);
        // exit;
    }
}
?>