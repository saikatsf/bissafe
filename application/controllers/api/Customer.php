<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');

     
class Customer extends REST_Controller {
    
    public function __construct() {
       parent::__construct();
       $this->load->model('api_models/customer_model', 'customer_model');
    }
       
    
    public function login_post()
    {
        $mobileNo = $this->input->post('contact_no');
        $roleId = $this->input->post('role_id');
        $checkNumber=$this->customer_model->checkNumber($mobileNo, $roleId);
        if(count((array)$checkNumber)==0)
        {
            $message=array("status"=>1, "message"=>'User not exist', "data"=>$mobileNo);
        }
        else
        {
            $userId=$checkNumber->id; 
            $userProfileData=$this->getCustomerProfile($userId);
            if($checkNumber->status=='1' && $checkNumber->del_action=='N')
            {
                $message=array("status"=>2, "message"=>'Number already exist', "data"=>$userProfileData['data']);
            }

            if($checkNumber->status=='0' && $checkNumber->del_action=='N')
            {
                $message=array("status"=>3, "message"=>'Mobile number not verified ', "data"=>$mobileNo);
            }
            if($checkNumber->del_action=='Y')
            {
                $message=array("status"=>4, "message"=>'Your profile has been deleted, Please contact to administration', "data"=>$mobileNo);
            }
        }
        $this->response($message);
    }

    public function signup_post()
    {
        $mobileNo = $this->input->post('contact_no');
        $roleId = $this->input->post('role_id');
        $checkNumber=$this->customer_model->checkNumber($mobileNo, $roleId);
        if(count((array)$checkNumber)==0)
        {
            $data=$this->input->post();
            $insertUser=$this->customer_model->customerSignup($data);
            if($insertUser)
            {
               $message=array("status"=>1, "message"=>'Insert Successfully', "data"=>[]); 
            }
            else
            {
                $message=array("status"=>0, "message"=>'Something went wrong, Please try again.', "data"=>[]);
            }
            
        }
        else
        {
            $message=array("status"=>2, "message"=>'Number already exist', "data"=>$mobileNo);   
        }

        $this->response($message);
    }


    public function getCustomerProfile($userId)
    {
        $userProfileData=$this->customer_model->customerProfileData($userId);
        $profileData['user_id']=$userProfileData->user_id;
        $profileData['full_name']=$userProfileData->full_name;
        $profileData['email']=$userProfileData->email;
        $profileData['contact_no']=$userProfileData->contact_no;
        $message=array("status"=>1, "message"=>'Profile Details', "data"=>$profileData); 
        return $message;
    }

   public function getSpBySectorId_post()
   {
       $user_type = $this->input->post('user_type');
       $sector_id = $this->input->post('sector_id');
       $spList = $this->customer_model->getSpProfileBySectorId($sector_id, $user_type);
       $data = array();
       foreach($spList as $row)
       {
           $sp_data['user_id'] = $row['user_id'];
           $sp_data['full_name'] = $row['full_name'];
           $sp_data['contact_no'] = $row['contact_no'];
           $sp_data['address'] = $row['address'];
           $sp_data['business_name'] = $row['business_name'];
           $sp_data['user_type'] = $row['user_type'];
           $sp_data['all_sector'] = $row['all_sector'];
           
           $data[] = $sp_data;
       }
     
       if(!empty($data))
       {
         $message=array("status"=>1, "message"=>'Sp Detail by Sector Wise', "data"=>$data); 
       }
       else
       {
          $message=array("status"=>0, "message"=>'Details not found', "data"=>$data);  
       }
       $this->response($message);
       
   }
   
   public function getSpPackageBySector_post()
   {
       $user_id = $this->input->post('user_id');
       $getData = $this->customer_model->getSpPackageBySector($user_id);
       if(!empty($getData))
       {
         $message=array("status"=>1, "message"=>'Package By Sector', "data"=>$getData); 
       }
       else
       {
          $message=array("status"=>0, "message"=>'Details not found', "data"=>[]);  
       }
       $this->response($message);
   }
	
	
       
}