<?php

Class Ajax_Model extends CI_Model{
    

    //=============================================================================
    /**
        * Author: Ajay Salunkhe
        * 
        * AJAX Model
        * This modal is use for Ajax data table queries
    */
    //=============================================================================


    protected $userDT_column = array(
        'contracts.title',
        'sites.title',
        'jobs.title',
        'measurements.date',
        ''
    );

    public function measurementsAjax($searchVal = '', $sortColIndex = 0, $sortBy = 'DESC', $limit = 0, $offset = 0,$id =0, $c_id=0) {
        $this->db->select("measurements.*,jobs.title as j_title,sites.title as s_title, groups.title as g_title,contracts.title as c_title");
        $this->db->from('measurements');
        $this->db->join('jobs', 'jobs.id = measurements.job_id', 'left');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        if($id>0){
            $this->db->where('jobs.id', $id);
        }
        if($c_id>0){
            $this->db->where('contracts.id', $c_id);
        }
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        if (strlen($searchVal)) {
            $searchCondition = "(
                contracts.title like '%$searchVal%' or
                sites.title like '%$searchVal%' or
                jobs.title like '%$searchVal%' or
                measurements.date like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by($this->userDT_column[$sortColIndex], $sortBy);
        return $this->db->get()->result_array();
    }

    public function measurementsAjaxCount($searchVal = '',$id =0, $c_id=0) {
        $this->db->select("count(measurements.id) as CountRows");
        $this->db->from('measurements');
        $this->db->join('jobs', 'jobs.id = measurements.job_id', 'left');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        if($id>0){
            $this->db->where('jobs.id', $id);
        }
        if($c_id>0){
            $this->db->where('contracts.id', $c_id);
        }
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        if (strlen($searchVal)) {
            $searchCondition = "(
                contracts.title like '%$searchVal%' or
                sites.title like '%$searchVal%' or
                jobs.title like '%$searchVal%' or
                measurements.date like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $query = $this->db->get()->row_array();
        return $query['CountRows'];
    }

    protected $DT_column = array(
        'contracts.title',
        'sites.title',
        'jobs.title',
        'bills.date',
        'bills.amount',
        'bills.status',
        ''
    );

    public function billsAjax($searchVal = '', $sortColIndex = 0, $sortBy = 'DESC', $limit = 0, $offset = 0,$id =0, $c_id=0) {
        $this->db->select("bills.*,jobs.title as j_title,sites.title as s_title, groups.title as g_title,contracts.title as c_title");
        $this->db->from('bills');
        $this->db->join('jobs', 'jobs.id = bills.job_id', 'left');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        if($id>0){
            $this->db->where('jobs.id', $id);
        }
        if($c_id>0){
            $this->db->where('contracts.id', $c_id);
        }
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        if (strlen($searchVal)) {
            $searchCondition = "(
                contracts.title like '%$searchVal%' or
                sites.title like '%$searchVal%' or
                jobs.title like '%$searchVal%' or
                bills.date like '%$searchVal%' or
                bills.amount like '%$searchVal%' or
                bills.status like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by($this->DT_column[$sortColIndex], $sortBy);
        return $this->db->get()->result_array();
    }

    public function billsAjaxCount($searchVal = '',$id =0, $c_id=0) {
        $this->db->select("count(bills.id) as CountRows");
        $this->db->from('bills');
        $this->db->join('jobs', 'jobs.id = bills.job_id', 'left');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        if($id>0){
            $this->db->where('jobs.id', $id);
        }
        if($c_id>0){
            $this->db->where('contracts.id', $c_id);
        }
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        if (strlen($searchVal)) {
            $searchCondition = "(
                contracts.title like '%$searchVal%' or
                sites.title like '%$searchVal%' or
                jobs.title like '%$searchVal%' or
                bills.date like '%$searchVal%' or
                bills.amount like '%$searchVal%' or
                bills.status like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $query = $this->db->get()->row_array();
        return $query['CountRows'];
    }


     protected $DT_column1 = array(
        'contracts.title',
        'sites.title',
        'jobs.title',
        'material_orders.date',
        'material_orders.name',
        ''
    );

    public function materialOrdersAjax($searchVal = '', $sortColIndex = 0, $sortBy = 'DESC', $limit = 0, $offset = 0,$id =0, $c_id=0) {
        $this->db->select("material_orders.*,jobs.title as j_title,sites.title as s_title, groups.title as g_title,contracts.title as c_title");
        $this->db->from('material_orders');
        $this->db->join('jobs', 'jobs.id = material_orders.job_id', 'left');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        if($id>0){
            $this->db->where('jobs.id', $id);
        }
        if($c_id>0){
            $this->db->where('contracts.id', $c_id);
        }
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        if (strlen($searchVal)) {
            $searchCondition = "(
                contracts.title like '%$searchVal%' or
                sites.title like '%$searchVal%' or
                jobs.title like '%$searchVal%' or
                material_orders.date like '%$searchVal%' or
                material_orders.name like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by($this->DT_column1[$sortColIndex], $sortBy);
        return $this->db->get()->result_array();
    }

    public function materialOrdersAjaxCount($searchVal = '',$id =0, $c_id=0) {
        $this->db->select("count(material_orders.id) as CountRows");
        $this->db->from('material_orders');
        $this->db->join('jobs', 'jobs.id = material_orders.job_id', 'left');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        if($id>0){
            $this->db->where('jobs.id', $id);
        }
        if($c_id>0){
            $this->db->where('contracts.id', $c_id);
        }
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        if (strlen($searchVal)) {
            $searchCondition = "(
                contracts.title like '%$searchVal%' or
                sites.title like '%$searchVal%' or
                jobs.title like '%$searchVal%' or
                material_orders.date like '%$searchVal%' or
                material_orders.name like '%$searchVal%' or
                material_orders.quantity like '%$searchVal%' or
                material_orders.rate like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $query = $this->db->get()->row_array();
        return $query['CountRows'];
    }

    protected $DT_column2 = array(
        'contracts.title',
        'sites.title',
        'jobs.title',
        'expenses.title',
        'expenses.date',
        'expenses.amount',
        ''
    );

    public function contractExpensesAjax($searchVal = '', $sortColIndex = 0, $sortBy = 'DESC', $limit = 0, $offset = 0,$id =0, $c_id=0) {
        $this->db->select("expenses.*,jobs.title as j_title,sites.title as s_title, groups.title as g_title,contracts.title as c_title");
        $this->db->from('expenses');
        $this->db->join('jobs', 'jobs.id = expenses.job_id', 'left');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        if($id>0){
            $this->db->where('jobs.id', $id);
        }
        if($c_id>0){
            $this->db->where('contracts.id', $c_id);
        }
        $this->db->where('expenses.job_id>', 0);
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        if (strlen($searchVal)) {
            $searchCondition = "(
                contracts.title like '%$searchVal%' or
                sites.title like '%$searchVal%' or
                jobs.title like '%$searchVal%' or
                expenses.title like '%$searchVal%' or
                expenses.date like '%$searchVal%' or
                expenses.amount like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by($this->DT_column2[$sortColIndex], $sortBy);
        return $this->db->get()->result_array();
    }

    public function contractExpensesAjaxCount($searchVal = '',$id =0, $c_id=0) {
        $this->db->select("count(expenses.id) as CountRows");
        $this->db->from('expenses');
        $this->db->join('jobs', 'jobs.id = expenses.job_id', 'left');
        $this->db->join('sites', 'sites.id = jobs.site_id', 'left');
        if($id>0){
            $this->db->where('jobs.id', $id);
        }
        if($c_id>0){
            $this->db->where('contracts.id', $c_id);
        }
        $this->db->where('expenses.job_id>', 0);
        $this->db->join('groups', 'groups.id = sites.group_id', 'left');
        $this->db->join('contracts', 'contracts.id = groups.contract_id', 'left');
        if (strlen($searchVal)) {
            $searchCondition = "(
                contracts.title like '%$searchVal%' or
                sites.title like '%$searchVal%' or
                jobs.title like '%$searchVal%' or
                expenses.title like '%$searchVal%' or
                expenses.date like '%$searchVal%' or
                expenses.amount like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $query = $this->db->get()->row_array();
        return $query['CountRows'];
    }

    protected $DT_column3 = array(
        'expenses.title',
        'expenses.date',
        'expenses.amount',
        'expenses.category',
        ''
    );

    public function operationalExpensesAjax($searchVal = '', $sortColIndex = 0, $sortBy = 'DESC', $limit = 0, $offset = 0,$month =0) {
        $this->db->select("*");
        $this->db->from('expenses');
        $this->db->where('expenses.job_id', 0);
        if(!empty($month)){
            $this->db->where("YEAR(date) = '".date("Y", strtotime($month))."' AND Month(date) = '".date("m", strtotime($month))."'");
        }
        if (strlen($searchVal)) {
            $searchCondition = "(
                expenses.title like '%$searchVal%' or
                expenses.date like '%$searchVal%' or
                expenses.amount like '%$searchVal%' or
                expenses.category like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by($this->DT_column3[$sortColIndex], $sortBy);
        return $this->db->get()->result_array();
    }

    public function operationalExpensesCount($searchVal = '',$month ='') {
        
        $this->db->select("count(expenses.id) as CountRows");
        $this->db->from('expenses');
        $this->db->where('expenses.job_id', 0);
        if(!empty($month)){
            $this->db->where("YEAR(date) = '".date("Y", strtotime($month))."' AND Month(date) = '".date("m", strtotime($month))."'");
        }
        if (strlen($searchVal)) {
            $searchCondition = "(
                expenses.title like '%$searchVal%' or
                expenses.date like '%$searchVal%' or
                expenses.amount like '%$searchVal%' or
                expenses.category like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $query = $this->db->get()->row_array();
        return $query['CountRows'];
    }

    protected $DT_column4 = array(
        'users.name',
        'users.user_type',
        'users.daily_wage',
        'users.monthly_salary',
        'users.phone',
        'users.address',
        ''
    );

    public function usersAjax($searchVal = '', $sortColIndex = 0, $sortBy = 'DESC', $limit = 0, $offset = 0) {
        $this->db->select("*");
        $this->db->from('users');
        if (strlen($searchVal)) {
            $searchCondition = "(
                users.name like '%$searchVal%' or
                users.user_type like '%$searchVal%' or
                users.daily_wage like '%$searchVal%' or
                users.monthly_salary like '%$searchVal%' or
                users.phone like '%$searchVal%' or
                users.address like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $this->db->where('user_type !=', 'admin');
        $this->db->limit($limit, $offset);
        $this->db->order_by($this->DT_column4[$sortColIndex], $sortBy);
        return $this->db->get()->result_array();
    }

    public function usersCount($searchVal = '') {
        
        $this->db->select("count(users.id) as CountRows");
        $this->db->from('users');
        if (strlen($searchVal)) {
            $searchCondition = "(
                users.name like '%$searchVal%' or
                users.user_type like '%$searchVal%' or
                users.daily_wage like '%$searchVal%' or
                users.monthly_salary like '%$searchVal%' or
                users.phone like '%$searchVal%' or
                users.address like '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }
        $this->db->where('user_type !=', 'admin');
        $query = $this->db->get()->row_array();
        return $query['CountRows'];
    }
}
?>