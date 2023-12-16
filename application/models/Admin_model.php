<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
    public function checkUser($email,$password){
        $this->load->database();

        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('password', $password);

        $result = $this->db->get()->result_array();
        
        return $result[0];

    }
    public function get_providers(){
        $this->load->database();

        $this->db->select('users.*, users.id as user_id, sp_profile.*');
        $this->db->from('users');
        $this->db->join('sp_profile', 'sp_profile.user_id=users.id', 'INNER');

        return $this->db->get()->result_array();
    }
    public function change_provider_status($user_id,$status){
        $this->load->database();

        $this->db->set('provider_status', $status);
        $this->db->where('id', $user_id);
        $this->db->update('sp_profile');

        return $this->db->affected_rows();
/* 
        $this->db->update('users.*, users.id as user_id, sp_profile.*, country.name as country_name, state.name as state_name');
        $this->db->from('users');
        $this->db->join('sp_profile', 'sp_profile.user_id=users.id', 'INNER');
        $this->db->join('country', 'country.id=sp_profile.country_id', 'INNER');
        $this->db->join('state', 'state.id=sp_profile.state_id', 'LEFT'); */

        /* return $this->db->get()->result_array(); */
    }
}