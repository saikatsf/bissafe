<?php
defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');

     
class Employee extends REST_Controller {
    
    public function __construct() {
       parent::__construct();
       $this->load->model('api_models/employee_model', 'employee_model');
    }

    public function login_post() {
        $mobileNo = $this->input->post('contact_no');
        $roleId = $this->input->post('role_id');
        $checkNumber=$this->employee_model->checkNumber($mobileNo, $roleId);
        if(count((array)$checkNumber)==0) {
            $message=array("status"=>1, "message"=>'User not exist', "data"=>$mobileNo);
        }
        else {
            $userId=$checkNumber->id; 
            $userProfileData=$this->getEmployeeProfile($userId);
            if($checkNumber->status=='1' && $checkNumber->del_action=='N') {
                $message=array("status"=>2, "message"=>'Number already exist', "data"=>$userProfileData['data']);
            }

            if($checkNumber->status=='0' && $checkNumber->del_action=='N') {
                $message=array("status"=>3, "message"=>'Mobile number not verified ', "data"=>$mobileNo);
            }
            if($checkNumber->del_action=='Y')  {
                $message=array("status"=>4, "message"=>'Your profile has been deleted, Please contact to administration', "data"=>$mobileNo);
            }
        }
        $this->response($message);
    }

    public function signup_post() {

        $mobileNo = $this->input->post('contact_no');
        $roleId = $this->input->post('role_id');
        $checkNumber=$this->employee_model->checkNumber($mobileNo, $roleId);
        if(count((array)$checkNumber)==0) {
            $data=$this->input->post();
            $insertUser=$this->employee_model->employeeSignup($data);
            if($insertUser) {
               $message=array("status"=>1, "message"=>'Insert Successfully', "data"=>[]); 
            }
            else {
                $message=array("status"=>0, "message"=>'Something went wrong, Please try again.', "data"=>[]);
            }
            
        }
        else {
            $message=array("status"=>2, "message"=>'Number already exist', "data"=>$mobileNo);   
        }

        $this->response($message);
    }

    public function getEmployeeProfile($userId) {

        $userProfileData=$this->employee_model->employeeProfileData($userId);
        $profileData['user_id']=$userProfileData->user_id;
        $profileData['full_name']=$userProfileData->full_name;
        $profileData['email']=$userProfileData->email;
        $profileData['contact_no']=$userProfileData->contact_no;
        $message=array("status"=>1, "message"=>'Profile Details', "data"=>$profileData); 
        return $message;
    }

    public function jobList_post() {


        $getJobList=$this->employee_model->getJobList();

        foreach ($getJobList as $singleJob) {

            $jobs['job_id']                 = $singleJob->id;
            $jobs['title']                  = $singleJob->title;
            $jobs['job_type_id']            = $singleJob->job_type_id;
            $jobs['job_type_name']          = $singleJob->job_type_name;
            /* $jobs['payment_structure_id']   = $singleJob->payment_structure_id;
            $jobs['payment_structure_name'] = $singleJob->payment_structure_name;
            $jobs['currency_id']            = $singleJob->currency_id;
            $jobs['currency_symbol']        = $singleJob->currency_symbol; */
            $jobs['from_date']              = $singleJob->from_date;
            $jobs['to_date']                = $singleJob->to_date;
            $jobs['expiry_date']            = $singleJob->expiry_date;
            $jobs['job_description']        = $singleJob->job_description;
            $jobs['country_id']             = $singleJob->country_id;
            $jobs['country_name']           = $singleJob->country_name;
            $jobs['state_id']               = $singleJob->state_id;
            $jobs['state_name']             = $singleJob->state_name;
            $jobs['location']               = $singleJob->location;
            $jobs['sector_id']              = $singleJob->sector_id;
            $jobs['sector_name']            = $singleJob->sector_name;
            $jobs['user_id']                = $singleJob->user_id;
            //$jobs['total_response']       = 5;
            $jobs['created_at']             = $singleJob->created_at;

            $jobCatData = $this->employee_model->getJobCategory($singleJob->category_id);

            $jobCat['category_id']=$jobCatData['id'];

            $jobCat['category_name']=$jobCatData['name'];
            
            $jobCat['sector_name']=$jobCatData['sector_name'];

            $jobs['jobCategory']=$jobCat;

            $allJobslist[]                  =  $jobs;   
        } 


        $message=array("status"=>1, "message"=>'Success', "data"=>$allJobslist);

        $this->response($message);

    }
       
    public function jobDetail_post() {

        $singleJobId    = $this->input->post('job_id');

        $getJobList     = $this->employee_model->getJobDetail($singleJobId);

        $jobs['job_id']                 = $getJobList->id;

        $jobs['title']                  = $getJobList->title;

        $jobs['job_type_id']            = $getJobList->job_type_id;

        $jobs['job_type_name']          = $getJobList->job_type_name;

        /* $jobs['payment_structure_id']   = $getJobList->payment_structure_id;

        $jobs['payment_structure_name'] = $getJobList->payment_structure_name;

        $jobs['currency_id']            = $getJobList->currency_id;

        $jobs['currency_symbol']        = $getJobList->currency_symbol; */

        $jobs['from_date']              = $getJobList->from_date;

        $jobs['to_date']                = $getJobList->to_date;

        $jobs['expiry_date']            = $getJobList->expiry_date;

        $jobs['job_description']        = $getJobList->job_description;

        $jobs['country_id']             = $getJobList->country_id;

        $jobs['country_name']           = $getJobList->country_name;

        $jobs['state_id']               = $getJobList->state_id;

        $jobs['state_name']             = $getJobList->state_name;

        $jobs['location']               = $getJobList->location;

        $jobs['sector_id']              = $getJobList->sector_id;

        $jobs['sector_name']            = $getJobList->sector_name;

        $jobs['user_id']                = $getJobList->user_id;

        //$jobs['total_response']       = 5;

        $jobs['created_at']             = $getJobList->created_at;

        $jobCatData = $this->employee_model->getJobCategory($getJobList->category_id);

        $jobCat['category_id']=$jobCatData['id'];

        $jobCat['category_name']=$jobCatData['name'];
        
        $jobCat['sector_name']=$jobCatData['sector_name'];

        $jobs['jobCategory']=$jobCat;


        $message=array("status"=>1, "message"=>'Success', "data"=>$jobs);

        $this->response($message);

    }

    public function jobApply_post() {
        
        $data=$this->input->post();

        $applyJob=$this->employee_model->applyJob($data);

        if($applyJob) {

            $message=array("status"=>1, "message"=>'Success', "data"=>$applyJob); 

        }

        $this->response($message);
    } 

}