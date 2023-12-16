<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->helper('url');
		$this->load->library('session');
    }

	public function login()
	{
		if($this->session->has_userdata('userDetail')){
			redirect(base_url().'admin');
		}
		$this->load->view('admin/login');
	}
	
	public function logout()
	{
		$this->session->unset_userdata('userDetail');
		redirect(base_url().'admin/login');
	}
	public function signin()
	{
            $email = $this->input->post('email');
			$password = $this->input->post('password');
            $checkUser = $this->Admin_model->checkUser($email,$password);
            if($checkUser)
            {
				$this->session->set_userdata('userDetail', $checkUser);
				redirect(base_url().'admin');
            }
            else
            {
				redirect(base_url().'admin/login');
            }
	}

	public function index()
	{
		if(!($this->session->has_userdata('userDetail'))){
			redirect(base_url().'admin/login');
		}else{
			$data['adminDetail'] = $this->session->userdata('userDetail');
		}
		$this->load->view('admin/template1',$data);
		$this->load->view('admin/dashboard');
		$this->load->view('admin/template2');
	}

    public function manageProviders()
	{  	
		if(!($this->session->has_userdata('userDetail'))){
			redirect(base_url().'admin/login');
		}else{
			$data['adminDetail'] = $this->session->userdata('userDetail');
		}
        $data['providers'] = $this->Admin_model->get_providers();
		$this->load->view('admin/template1',$data);
		$this->load->view('admin/providers',$data);
		$this->load->view('admin/template2');
	}
	public function changeProviderStatus($user_id,$status)
	{   
		$result = $this->Admin_model->change_provider_status($user_id,$status);

        redirect(base_url().'admin/manageProviders');
	} 
}
