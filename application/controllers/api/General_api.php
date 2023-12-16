<?php

defined('BASEPATH') or exit('No direct script access allowed');



require(APPPATH.'/libraries/REST_Controller.php');



     

class General_api extends REST_Controller {

    

    public function __construct() {

       parent::__construct();

       $this->load->model('api_models/general_api_model');

    }

    public function login_post() {

        $mobileNo = $this->input->post('contact_no');

        $roleId = $this->input->post('role_id');

        $checkNumber=$this->general_api_model->checkNumber($mobileNo, $roleId);

       // echo '<pre>';

       // json_encode($checkNumber);die;

        if(count((array)$checkNumber)==0) {

            $message=array("status"=>1, "message"=>'User not exist', "data"=>$mobileNo);

        }
        else {

            $userId=$checkNumber->id; 

            $userProfileData=$this->getSpProfile($userId);

            if($checkNumber->status=='1' && $checkNumber->del_action=='N') {

                $message=array("status"=>2, "message"=>'Number already exist', "data"=>$userProfileData['data']);

            }

            if($checkNumber->status=='0' && $checkNumber->del_action=='N') {

                $message=array("status"=>3, "message"=>'Please wait for admin approval, your profile has not been approved. ', "data"=>$mobileNo);

            }

            if($checkNumber->del_action=='Y') {

                $message=array("status"=>4, "message"=>'Your profile has been deleted, Please contact to administration', "data"=>$mobileNo);

            }

        }

        $this->response($message);

    }

    public function signup_post() {

        $mobileNo = $this->input->post('contact_no');

        $roleId = $this->input->post('role_id');

        $checkNumber=$this->general_api_model->checkNumber($mobileNo, $roleId);

        if(count((array)$checkNumber)==0) {

            $data=$this->input->post();

            $insertUser=$this->general_api_model->spSignup($data);

            if($insertUser) {

               $message=array("status"=>1, "message"=>'Insert Successfully', "data"=>["provider_id"=>$insertUser],); 

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

    public function getSpStatus_post() {

        $user_id=$this->input->post('user_id');

        $status=$this->general_api_model->getSpStatus($user_id);

        $message=array("status"=>1, "message"=>'Sp Provider Data', "data"=>$status); 

        $this->response($message);

    }

    public function getSpProfile($userId) {

        $userProfileData=$this->general_api_model->spProfileData($userId);

        $profileData['user_id']=$userProfileData->user_id;

        $profileData['provider_id']=$userProfileData->id;

        $profileData['full_name']=$userProfileData->full_name;

        $profileData['email']=$userProfileData->email;

        $profileData['contact_no']=$userProfileData->contact_no;

        $profileData['business_name']=$userProfileData->business_name;

        $profileData['proof_numer']=$userProfileData->proof_number;

        $profileData['expire_date']=$userProfileData->expire_date;

        $profileData['alt_contact']=$userProfileData->alt_contact;

        $profileData['address']=$userProfileData->address;

        $profileData['country_id']=$userProfileData->country_id;

        $profileData['country_name']=$userProfileData->country_name;

        $profileData['state_id']=$userProfileData->state_id;

        $profileData['state_name']=$userProfileData->state_name;

        $profileData['city']=$userProfileData->city;

        $profileData['business_year']=$userProfileData->business_year;

        $profileData['website_url']=$userProfileData->website_url;

        $profileData['business_type']=$userProfileData->business_type;

        $profileData['provider_status']=$userProfileData->provider_status;

        $profileData['company_logo']=base_url().DOCS_FOLDER_URL."company_logo/".$userProfileData->logo;



        $business_card=$this->general_api_model->getAttachmentData($userId,'business_card');

        $businessCard=array();

        if(!empty($business_card)) {

            foreach ($business_card as $businessData) {

                $busDocs['attachment_docs_id']=$businessData['id'];

                $busDocs['ref_docs']=base_url().DOCS_FOLDER_URL."business_card/".$businessData['ref_docs'];

                $busDocs['ref_type']=$businessData['ref_type'];

                $profileData['businessCard']=$busDocs;

            }

        }



        $review_pics=$this->general_api_model->getAttachmentData($userId,'review_pics');

        $reviewImg=array();

        if(!empty($review_pics)) {

            foreach ($review_pics as $reviewData) {

                $reviewDocs['attachment_docs_id']=$reviewData['id'];

                $reviewDocs['ref_docs']=base_url().DOCS_FOLDER_URL."review_img/".$reviewData['ref_docs'];

                $reviewDocs['ref_type']=$reviewData['ref_type'];

                $profileData['reviewImg']=$reviewDocs;

            }

        }

        $company_proof=$this->general_api_model->getAttachmentData($userId,'company_proof');

        $companyDocs=array();

        if(!empty($company_proof)) {

            foreach ($company_proof as $compData) {

                $compDocs['attachment_docs_id']=$compData['id'];

                $compDocs['ref_docs']=base_url().DOCS_FOLDER_URL."company_docs/".$compData['ref_docs'];

                $compDocs['ref_type']=$compData['ref_type'];

                $profileData['companyDocs']=$compDocs;

            }

        }

        $message=array("status"=>1, "message"=>'Profile Details', "data"=>$profileData); 

        return $message;

    }

    public function getCountry_post() {

        $countryData=$this->general_api_model->getCountryData();

        $message=array("status"=>1, "message"=>'Country Data', "data"=>$countryData); 

        $this->response($message);

    }

    public function getState_post() {

        $country_id='';

        $country_id=$this->input->post('country_id');

        if($country_id!='')

        {

            $country_id=$country_id;

        }

        $stateData=$this->general_api_model->getStateData($country_id);

        $message=array("status"=>1, "message"=>'State Data', "data"=>$stateData); 

        $this->response($message);

    }

    public function getCurrency_post() {

        $currencyData=$this->general_api_model->getCurrencyData();

        $message=array("status"=>1, "message"=>'Currency Data', "data"=>$currencyData); 

        $this->response($message);

    }

    public function getSector_post() {

        $sectorData=$this->general_api_model->getSectorData();

        $message=array("status"=>1, "message"=>'Sector Data', "data"=>$sectorData); 

        $this->response($message);

    }

    public function getCategory_post() {

        $sectorId='';

        $sectorId=$this->input->post('sector_id');

        if($sectorId!='') {

            $sectorId=$sectorId;

        }

        $categoryData=$this->general_api_model->getCategoryData($sectorId);

        $message=array("status"=>1, "message"=>'Category Data', "data"=>$categoryData); 

        $this->response($message);

    }

    public function getJobType_post() {

        $jobTypeData=$this->general_api_model->getJobTypeData();

        $message=array("status"=>1, "message"=>'Job Type Data', "data"=>$jobTypeData); 

        $this->response($message);

    }  

    public function getPaymentStructure_post() {

        $paymentStructureData=$this->general_api_model->getPaymentStructureData();

        $message=array("status"=>1, "message"=>'Payment Structure Data', "data"=>$paymentStructureData); 

        $this->response($message);

    }

    public function insertJobs_post() {

        $data=$this->input->post();

        $insertJobs=$this->general_api_model->insertJobData($data);

        if($insertJobs) {

            $message=array("status"=>1, "message"=>'Success', "data"=>$insertJobs); 

        }

        $this->response($message);

    }

    public function jobList_post() {

        $user_id=$this->input->post('user_id');

        $getJobDate=$this->general_api_model->getJobDate($user_id);

        $dateWiseJobList=array();

        foreach ($getJobDate as $key => $userJobDate) {

            $jobDate=$userJobDate['created_at']; 

            $explodeJobsIds=explode(',', $userJobDate['jobs_ids']);

            $singleJob=array();

            $jobs=array();

            foreach ($explodeJobsIds as $key => $singleJobId) {

                    $getJobList=$this->general_api_model->getJobList($singleJobId);

                    $jobs['job_id'] = $getJobList->id;

                    $jobs['title'] = $getJobList->title;

                    $jobs['job_type_id'] = $getJobList->job_type_id;

                    $jobs['job_type_name'] = $getJobList->job_type_name;
                    /* 
                    $jobs['payment_structure_id'] = $getJobList->payment_structure_id;

                    $jobs['payment_structure_name'] = $getJobList->payment_structure_name; 

                    $jobs['currency_id'] = $getJobList->currency_id;

                    $jobs['currency_symbol'] = $getJobList->currency_symbol; */

                    $jobs['from_date'] = $getJobList->from_date;

                    $jobs['to_date'] = $getJobList->to_date;

                    $jobs['expiry_date'] = $getJobList->expiry_date;

                    $jobs['job_description'] = $getJobList->job_description;

                    $jobs['country_id'] = $getJobList->country_id;

                    $jobs['country_name'] = $getJobList->country_name;

                    $jobs['state_id'] = $getJobList->state_id;

                    $jobs['state_name'] = $getJobList->state_name;

                    $jobs['location'] = $getJobList->location;

                    $jobs['sector_id'] = $getJobList->sector_id;

                    $jobs['sector_name'] = $getJobList->sector_name;

                    $jobs['user_id'] = $getJobList->user_id;

                    $jobs['total_response'] = 5;

                    $jobs['created_at'] = $getJobList->created_at;

                    $jobCatData = $this->general_api_model->getJobCategory($getJobList->category_id);

                    $jobCat['category_id']=$jobCatData['id'];

                    $jobCat['category_name']=$jobCatData['name'];
                    
                    $jobCat['sector_name']=$jobCatData['sector_name'];

                    $jobs['jobCategory']=$jobCat;   

                    $singleJob[]=$jobs;            

            }

            $dateWiseJobList[]=["jobPostDate"=>$jobDate, "jobList"=>$singleJob];

        }

        $message=array("status"=>1, "message"=>'Success', "data"=>$dateWiseJobList);

        $this->response($message);

    }

    public function jobDetail_post() {

        $singleJobId=$this->input->post('job_id');

        $getJobList=$this->general_api_model->getJobList($singleJobId);

        $jobs['job_id'] = $getJobList->id;

        $jobs['title'] = $getJobList->title;

        $jobs['job_type_id'] = $getJobList->job_type_id;

        $jobs['job_type_name'] = $getJobList->job_type_name;

        /* $jobs['payment_structure_id'] = $getJobList->payment_structure_id;

        $jobs['payment_structure_name'] = $getJobList->payment_structure_name;

        $jobs['currency_id'] = $getJobList->currency_id;

        $jobs['currency_symbol'] = $getJobList->currency_symbol; */

        $jobs['from_date'] = $getJobList->from_date;

        $jobs['to_date'] = $getJobList->to_date;

        $jobs['expiry_date'] = $getJobList->expiry_date;

        $jobs['job_description'] = $getJobList->job_description;

        $jobs['country_id'] = $getJobList->country_id;

        $jobs['country_name'] = $getJobList->country_name;

        $jobs['state_id'] = $getJobList->state_id;

        $jobs['state_name'] = $getJobList->state_name;

        $jobs['location'] = $getJobList->location;

        $jobs['sector_id'] = $getJobList->sector_id;

        $jobs['sector_name'] = $getJobList->sector_name;

        $jobs['user_id'] = $getJobList->user_id;

        $jobs['created_at'] = $getJobList->created_at;

        $jobCatData = $this->general_api_model->getJobCategory($getJobList->category_id);

        $jobCat['category_id']=$jobCatData['id'];

        $jobCat['category_name']=$jobCatData['name'];
        
        $jobCat['sector_name']=$jobCatData['sector_name'];

        $jobs['jobCategory']=$jobCat; 

        $jobResponse = $this->general_api_model->getJobResponseList($getJobList->id);

        $jobs['total_response'] = count($jobResponse);

        foreach ($jobResponse as $response) {
            $jobRes['response_id']  =  $response->id;
            $jobRes['user_id']      =  $response->user_id;
            $jobRes['name']         =  $response->name;
            $jobRes['description']  =  $response->description;
            $jobRes['created_at']   =  $response->created_at;

            $jobs['responses'][] = $jobRes;
        }



        $message=array("status"=>1, "message"=>'Success', "data"=>$jobs);

        $this->response($message);

    }

    public function jobResponse_post(){

        $responseId=$this->input->post('response_id');

        $response=$this->general_api_model->getJobResponse($responseId);

        $jobRes['response_id']  =  $response->id;
        $jobRes['user_id']      =  $response->user_id;
        $jobRes['name']         =  $response->name;
        $jobRes['description']  =  $response->description;
        $jobRes['status']       =  $response->status;
        $jobRes['created_at']   =  $response->created_at;

        $message=array("status"=>1, "message"=>'Success', "data"=>$jobRes);

        $this->response($message);
    }

    public function jobOffer_post(){

        $responseId=$this->input->post('response_id');
        $offerStatus=$this->input->post('offer_status');

        $response=$this->general_api_model->offerJob($responseId,$offerStatus);

        $jobRes['response_id']  =  $response->id;
        $jobRes['user_id']      =  $response->user_id;
        $jobRes['name']         =  $response->name;
        $jobRes['description']  =  $response->description;
        $jobRes['status']       =  $response->status;
        $jobRes['created_at']   =  $response->created_at;

        $message=array("status"=>1, "message"=>'Success', "data"=>$jobRes);

        $this->response($message);
    }

    public function additionalServiceList_post() {

        $getAdtServiceList=$this->general_api_model->getAdtServiceList();

        if(!empty($getAdtServiceList)) {

            $data=array();

            foreach($getAdtServiceList as $adtData) {

                $additionalData['additional_service_id']=$adtData['id'];

                $additionalData['service_name']=$adtData['name'];

                $additionalData['category_id']=$adtData['category_id'];

                $additionalData['category_name']=$adtData['category_name'];

                $additionalData['price']=$adtData['price'];

                $additionalData['qty']=$adtData['qty'];

                $additionalData['unit_id']=$adtData['unit_id'];

                $additionalData['unit_name']=$adtData['unit_name'];

                $additionalData['service_type']='additional';

                $data[]=$additionalData;

            }

            $message=array("status"=>1, "message"=>'Additional Service List', "data"=>$data);

        }

        else {

            $message=array("status"=>0, "message"=>'Additional Service not found', "data"=>[]);

        }

        $this->response($message);

    }

    public function serviceList_post() {

        $user_id=$this->input->post('user_id');

        $getServiceList=$this->general_api_model->getSPServiceList($user_id);



        if(!empty($getServiceList))

        {

        $data=array();

        foreach($getServiceList as $serviceData)

        {

            $serviceData['service_id']=$serviceData['id'];

            $serviceData['service_name']=$serviceData['name'];

            $additionalData['category_id']=$serviceData['category_id'];

            $additionalData['category_name']=$serviceData['category_name'];

            $serviceData['service_type']=$serviceData['service_type'];

            $serviceData['price_type']=$serviceData['price_type'];

            $serviceData['price']=$serviceData['price'];

            $serviceData['qty']=$serviceData['qty'];

            $serviceData['unit_id']=$serviceData['unit_id'];

            $serviceData['unit_name']=$serviceData['unit_name'];



            $data[]=$serviceData;

        }



        $message=array("status"=>1, "message"=>'Service List', "data"=>$data);

         

        }

        else

        {

            $message=array("status"=>0, "message"=>'Service not found', "data"=>[]);

        }

        $this->response($message);



    }

    public function getUnitList_post() {

        $getUnitData=$this->general_api_model->getUnitList();

        $data=array();

        foreach ($getUnitData as $unitData) {

            $unitDetails['unit_id']=$unitData['id'];

            $unitDetails['unit_name']=$unitData['name'];

            $data[]=$unitDetails;

        }

        $message=array("status"=>1, "message"=>'Unit List', "data"=>$data);

        $this->response($message);

    }

    public function addServiceBySP_post() {

        $data=$this->input->post();

        $checkServiceExist=$this->general_api_model->checkServiceNameExist($data['service_name'], $data['user_id']);

        if($checkServiceExist->total_count==0)

        {

            $serviceData=$this->general_api_model->insertServiceBySP($data);

            if($serviceData)

            {

                $message=array("status"=>1, "message"=>'Service Added', "data"=>[]);

            }

            else

            {

                $message=array("status"=>0, "message"=>'Something went wrong, please try again', "data"=>[]);

            }

        }

        else

        {

             $message=array("status"=>2, "message"=>'Service already exist', "data"=>[]);

        }

         $this->response($message);

    }

    public function createPackage_post() {

        $data=$this->input->post();



        $insertPackage=$this->general_api_model->createPackage($data);

        if($insertPackage)

        {

          $message=array("status"=>1, "message"=>'Package Added', "data"=>$insertPackage);  

        }

        else

        {

          $message=array("status"=>0, "message"=>'Something went wrong, please try again', "data"=>[]);

        }

        $this->response($message);

    }
    
    function packageList_post() {

        $user_id=$this->input->post('user_id');

        $packageList=$this->general_api_model->getPackageList($user_id);

        if(!empty($packageList))

        {

            $packageDetails=array();

            $data=array();

         foreach ($packageList as $packageData) {

                $packageDetails['package_id']=$packageData['package_id'];

                $packageDetails['package_name']=$packageData['package_name'];

                $packageDetails['sector_id']=$packageData['sector_id'];

                $packageDetails['sector_name']=$packageData['sector_name'];

                $packageDetails['category_id']=$packageData['category_id'];

                $packageDetails['category_name']=$packageData['category_name'];

                $packageDetails['total']=$packageData['total'];

                $packageDetails['created_at']=$packageData['created_at'];



                $gerpackageService=$this->general_api_model->getPackageServiceList($packageData['package_id']);

                //echo "<pre>"; print_r($gerpackageService); die;

                $pkgData=array();

                $pkgAllData=array();

                foreach($gerpackageService as $pkgServiceList)

                {

                 $pkgData['package_id']=$pkgServiceList['package_id'];

                 $pkgData['service_id']=$pkgServiceList['service_id'];

                 $pkgData['service_name']=$pkgServiceList['service_name'];

                 $pkgData['qty']=$pkgServiceList['qty'];

                 $pkgData['unit_id']=$pkgServiceList['unit_id'];

                 $pkgData['unit_name']=$pkgServiceList['unit_name'];

                 $pkgData['price']=$pkgServiceList['price'];

                 $pkgAllData[]=$pkgData;

                 $packageDetails['packageDetails']=$pkgAllData;

                }

                $data[]=$packageDetails;

            }

            $message=array("status"=>1, "message"=>'Package Data', "data"=>$data);   

        }

        else

        {

            $message=array("status"=>1, "message"=>'Data not found', "data"=>[]);

        }

        $this->response($message);

    }

    public function serviceByUserSector_post() {

        $data = $this->input->post();

        $serviceList=$this->general_api_model->serviceByUserSector($data);

        $message=array("status"=>1, "message"=>'Category Wise Service List', "data"=>$serviceList); 

        $this->response($message);

    }

    public function serviceListBySector_post() {

        $user_id = $this->input->post('user_id');

        $category_list = $this->general_api_model->serviceListBySector($user_id);

        if(!empty($category_list))

        {

            $message=array("status"=>1, "message"=>'Service List Group Wise', "data"=>$category_list); 

        }

        else

        {

            $message=array("status"=>1, "message"=>'Data not available', "data"=>[]);

        }

        $this->response($message);

    } 

    public function updateEmailBySp_post() {

        $user_id = $this->input->post('user_id');

        $email = $this->input->post('email');

        $updateEamil = $this->general_api_model->updateSpEmail($user_id, $email);

        if($updateEamil)

        {

            $message=array("status"=>1, "message"=>'Updated', "data"=>[]);

        }

        else

        {

            $message=array("status"=>0, "message"=>'Something went wrong, please try again', "data"=>[]);

        }

        $this->response($message);

    }

    /*
    public function updateSpProfile_post() {

        $data = $this->input->post();

        $updateProfile = $this->general_api_model->updateSpProfile($data);

        if($updateProfile)

        {

            $message=array("status"=>1, "message"=>'Updated', "data"=>[]);

        }

        else

        {

            $message=array("status"=>0, "message"=>'Something went wrong, please try again', "data"=>[]);

        }

        $this->response($message);

        

    }*/

	public function get_sp_profile_post() { 

		$user_id = $this->input->post('user_id');

        $userProfileData=$this->general_api_model->spProfileData($user_id);

        if(empty($userProfileData))

        {

            $message=array("status"=>0, "message"=>'Invalid User', "data"=>[]);

            $this->response($message); return false;

        }

        

        $profileData['user_id']=$userProfileData->user_id;

        $profileData['full_name']=$userProfileData->full_name;

        $profileData['email']=$userProfileData->email;

        $profileData['contact_no']=$userProfileData->contact_no;

        $profileData['business_name']=$userProfileData->business_name;

        $profileData['proof_numer']=$userProfileData->proof_number;

        $profileData['expire_date']=$userProfileData->expire_date;

        $profileData['alt_contact']=$userProfileData->alt_contact;

        $profileData['address']=$userProfileData->address;

        $profileData['country_id']=$userProfileData->country_id;

        $profileData['country_name']=$userProfileData->country_name;

        $profileData['state_id']=$userProfileData->state_id;

        $profileData['state_name']=$userProfileData->state_name;

        $profileData['city']=$userProfileData->city;

        $profileData['business_year']=$userProfileData->business_year;

        $profileData['website_url']=$userProfileData->website_url;

        $profileData['business_type']=$userProfileData->business_type;

        $profileData['provider_status']=$userProfileData->provider_status;

        $profileData['company_logo']=base_url().DOCS_FOLDER_URL."company_logo/".$userProfileData->logo;

        $business_card=$this->general_api_model->getAttachmentData($user_id,'business_card');

        $businessCard=array();

        if(!empty($business_card)) 

        {

            foreach ($business_card as $businessData) {

                $busDocs['attachment_docs_id']=$businessData['id'];

                $busDocs['ref_docs']=base_url().DOCS_FOLDER_URL."business_card/".$businessData['ref_docs'];

                $busDocs['ref_type']=$businessData['ref_type'];

                $profileData['businessCard']=$busDocs;

            }

        }



        $review_pics=$this->general_api_model->getAttachmentData($user_id,'review_pics');

        $reviewImg=array();

        if(!empty($review_pics)) 

        {

            foreach ($review_pics as $reviewData) {

                $reviewDocs['attachment_docs_id']=$reviewData['id'];

                $reviewDocs['ref_docs']=base_url().DOCS_FOLDER_URL."review_img/".$reviewData['ref_docs'];

                $reviewDocs['ref_type']=$reviewData['ref_type'];

                $profileData['reviewImg']=$reviewDocs;

            }

        }



        $company_proof=$this->general_api_model->getAttachmentData($user_id,'company_proof');

        $companyDocs=array();

        if(!empty($company_proof)) 

        {

            foreach ($company_proof as $compData) {

                $compDocs['attachment_docs_id']=$compData['id'];

                $compDocs['ref_docs']=base_url().DOCS_FOLDER_URL."company_docs/".$compData['ref_docs'];

                $compDocs['ref_type']=$compData['ref_type'];

                $profileData['companyDocs']=$compDocs;

            }

        }



        $message=array("status"=>1, "message"=>'Profile Details', "data"=>$profileData);

		$this->response($message);

    }

	public function update_spProfile_post() {

		$data = $this->input->post();

		$update_sp_profile=$this->general_api_model->update_spProfile($data);

		if($update_sp_profile)

		{

			$message=array("status"=>1, "message"=>'Profile update successfully', "data"=>[]);

		}

		else

		{

			$message=array("status"=>0, "message"=>'Something went wrong, please try again', "data"=>[]);

		}

		$this->response($message);

	}

	public function update_spCompanyProfile_post() {

		$data = $this->input->post();

		$update_spCompanyProfile=$this->general_api_model->update_sp_company_profile($data);

		if($update_spCompanyProfile)

		{

			$message=array("status"=>1, "message"=>'Company profile update successfully', "data"=>[]);

		}

		else

		{

			$message=array("status"=>0, "message"=>'Something went wrong, please try again', "data"=>[]);

		}

		$this->response($message);

	}	

	public function createEstimator_post() {

	   $data = $this->input->post();

	   $insertEstimator=$this->general_api_model->insert_estimator($data);

	   if($insertEstimator)

	   {

	       $message=array("status"=>1, "message"=>'Insert successfully', "data"=>$insertEstimator);

	   }

	   else

		{

			$message=array("status"=>0, "message"=>'Something went wrong, please try again', "data"=>[]);

		}

		$this->response($message);

	}

	public function estimator_list_post() {

	    $user_id = $this->input->post('user_id');

	    $getEstimatorList=$this->general_api_model->get_estimator_list($user_id);

	    $listData=array();

	    foreach($getEstimatorList as $row)

	    {

	        $eList['estimator_id'] = $row['id'];

	        $eList['title'] = $row['title'];

	        $eList['total_price'] = $row['total_price'];

	        $eList['estimator_status'] = $row['estimator_status'];

	        $eList['estimator_view_url'] = '';

	        $eList['created_at'] = $row['created_at'];

	        $listData[] = $eList;

	    }

	    $message=array("status"=>1, "message"=>'Estimator List', "data"=>$listData);

	    $this->response($message);

	}

	public function estimator_view_post() {

	    $estimator_id = $this->input->post('estimator_id');

	    $user_id = $this->input->post('user_id');

	    $getEstimator=$this->general_api_model->get_estimator_by_id($estimator_id, $user_id);

	     

	    $estimatorDetails['estimator_title'] = $getEstimator->title;

	    $estimatorDetails['accepted_by'] = $getEstimator->customer_name;

	    $estimatorDetails['estimator_status'] = $getEstimator->estimator_status; 

	    $estimatorDetails['created_at'] = $getEstimator->created_at;

	    $estimatorDetails['total_price'] = $getEstimator->total_price;

	    

	    $getEstimatorItems=$this->general_api_model->get_estimator_items($getEstimator->id);

	    $estimatorItemData = array();

	    foreach($getEstimatorItems as $items)

	    {

	        $eItems['estimator_id'] = $items['estimator_id'];

	        $eItems['service_id'] = $items['service_id'];

	        $eItems['service_name'] = $items['service_name'];

	        $eItems['description'] = $items['description'];

	        $eItems['qty'] = $items['qty'];

	        $eItems['price'] = $items['price'];

	        $eItems['total'] = $items['total'];

	        $eItems['created_at'] = $items['created_at'];

	        $estimatorItemData[]=$eItems;

	    }

	    

	    $estimatorDetails['estimatorItems']=$estimatorItemData;

	    

	    $getEstimatorMilestone=$this->general_api_model->get_estimator_milestone($getEstimator->id);

	    $estimatorMilestone = array();

	    foreach($getEstimatorMilestone as $milestone)

	    {

	        $eMilestone['estimator_id'] = $milestone['estimator_id'];

	        $eMilestone['title'] = $milestone['title'];

	        $eMilestone['amt_percentage'] = $milestone['amt_percentage'];

	        $eMilestone['due_date'] = $milestone['due_date'];

	        $eMilestone['created_at'] = $milestone['created_at'];

	        $estimatorMilestone[]=$eMilestone;

	    }

	    $estimatorDetails['estimatorMilestone']=$estimatorMilestone;

	    $message=array("status"=>1, "message"=>'Estimator Details', "data"=>$estimatorDetails);

	    $this->response($message);

	    

	}	

	public function addEmployee_post() {

	    $data = $this->input->post();

	    $employee_id = $this->general_api_model->insertEmployee($data); 

	    if($employee_id)

	    {

	        $checkExistingEmp = $this->general_api_model->checkExistingEmp($employee_id, $data['user_id']);

	        if($checkExistingEmp) {

	            $message=array("status"=>2, "message"=>'Employee already exist', "data"=>[]);

	        }

	        else {

	            $profile_pic = '';

	            if(isset($data['profile_pic']) && $data['profile_pic']!='')

	            {

    	            $folderPath = FCPATH."assets/users";   

        			if (!file_exists($folderPath)) {

        				mkdir($folderPath, 0777, true);

        			}

        			$cLogoBase64 = base64_decode($data['profile_pic']);

        			$imageName="users_".uniqid()."_".$employee_id.'.png';

        			$file = $folderPath.$imageName;

        			if(file_put_contents($file, $cLogoBase64))

        			{

        				$profile_pic = $imageName;

        			}

	            }
	            $empProfile = array(

                'employee_id' => $employee_id,

                'company_id' => $data['user_id'],

                'profile_pic' => $profile_pic

                );

                $checkExistingEmp = $this->general_api_model->insertEmpProfile($empProfile);

                if($checkExistingEmp){

                    $message=array("status"=>1, "message"=>'Added', "data"=>[]);

                }

	        }

	    }

	    else

	    {

	        $message=array("status"=>0, "message"=>'Something went wrong, please try again.', "data"=>[]);

	    }

	    

	    $this->response($message);

	}

	public function employeeList_post() {

	    $user_id = $this->input->post('user_id');

	    $getEmpList = $this->general_api_model->getEmployeeList($user_id);

	    

	    $data=array();

	    foreach($getEmpList as $row)

	    {

	        $empData['employee_id'] = $row['employee_id'];

	        $empData['full_name'] = $row['full_name'];

	        $empData['email'] = $row['email'];

	        $empData['contact_no'] = $row['contact_no'];

	        $empData['profile_pic'] = base_url().'assets/users/'.$row['profile_pic'];

	        $data[] = $empData;

	    }

	     $message=array("status"=>1, "message"=>'Employee List', "data"=>$data);

	     $this->response($message);

	}

    public function employeeDetail_post() {

	    $user_id = $this->input->post('employee_id');

	    $getEmpDetails = $this->general_api_model->getEmployeeDetail($user_id);

        $data['employee_id'] = $getEmpDetails['employee_id'];

        $data['full_name'] = $getEmpDetails['full_name'];

        $data['email'] = $getEmpDetails['email'];

        $data['contact_no'] = $getEmpDetails['contact_no'];

        $data['profile_pic'] = base_url().'assets/users/'.$getEmpDetails['profile_pic'];


	     $message=array("status"=>1, "message"=>'Employee Detail', "data"=>$data);

	     $this->response($message);

	}


}