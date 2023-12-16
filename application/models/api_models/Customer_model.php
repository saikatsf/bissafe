<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function checkNumber($mobileNo, $roleId)
    {
        $this->db->select('id, status, del_action');
        $this->db->from('users');
        $this->db->where('contact_no', $mobileNo);
        $this->db->where('role_id', $roleId);
        return $this->db->get()->row();
    }

    public function customerSignup($data)
    {
        $userData = array(
            'full_name' =>  $data['full_name'],
            'email'     =>  $data['email'],
            'contact_no'=>  $data['contact_no'],
            'status'    =>  '1',
            'added_by'  =>  $data['added_by'],
            'role_id'   =>  4
        );
        $this->db->insert('users',$userData);
        $userInsert=$this->db->insert_id();
        return $userInsert;
    }

    public function customerProfileData($userId)
    {
        $this->db->select('users.*, users.id as user_id');
        $this->db->from('users');
        $this->db->where('users.id', $userId);
        return $this->db->get()->row();
        //echo $this->db->last_query(); die;
    }
    
    public function getSpProfileBySectorId($sector_id, $user_type=0)
    {
        $this->db->select('service.user_id, users.full_name, users.contact_no, sp_profile.business_name, sp_profile.user_type, GROUP_CONCAT(DISTINCT(sector.name)) as all_sector, sp_profile.address');
        $this->db->from('service');
        $this->db->join('users', 'users.id=service.user_id', 'INNER JOIN');
        $this->db->join('sp_profile', 'sp_profile.user_id=service.user_id', 'INNER JOIN');
        $this->db->join('sector', 'sector.id=service.sector_id', 'INNER JOIN');
        $this->db->where('service.sector_id', $sector_id);
        $this->db->where('users.role_id', '2');
        $this->db->where('users.status', '1');
        $this->db->where('users.del_action', 'N');
        $this->db->where('sp_profile.user_type', $user_type);
        $this->db->where('sp_profile.del_action', 'N');
        $this->db->group_by('service.user_id');
        return $this->db->get()->result_array();
    }
    
    public function getSpPackageBySector($user_id)
    {
        $this->db->select('package.sector_id as sector_id, sector.name as sector_name, count(package.id) as total_package');
        $this->db->from('package');
        $this->db->join('sector', 'sector.id=package.sector_id', 'INNER JOIN');
        $this->db->where('package.user_id', $user_id);
        $this->db->group_by('package.sector_id');
        return $this->db->get()->result_array();
    }
    

}
