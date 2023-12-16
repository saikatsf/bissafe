<?php

defined('BASEPATH') or exit('No direct script access allowed');



class General_api_model extends CI_Model

{

    public function __construct() {

        parent::__construct();

    }

    public function checkNumber($mobileNo, $roleId) {

        $this->db->select('id, status, del_action');

        $this->db->from('users');

        $this->db->where('contact_no', $mobileNo);

        $this->db->where('role_id', $roleId);

        return $this->db->get()->row();

    }

    public function spSignup($data) {

        $userData = array(

            'full_name' =>  $data['full_name'],

            'email'     =>  $data['email'],

            'contact_no'=>  $data['contact_no'],

            'status'    =>  '1',

            'added_by'  =>  $data['added_by'],

            'role_id'   =>  2

        );

        $this->db->insert('users',$userData);

        $userInsert=$this->db->insert_id();

        

        if($userInsert)

        {

            /* ====== For Company Logo ========= */

            $company_logo='';

            if($data['company_logo']!='')

            {

                $folderPath = DOCS_FOLDER_PATH."company_logo/";   

                if (!file_exists($folderPath)) {

                    mkdir($folderPath, 0777, true);

                }

                $cLogoBase64 = base64_decode($data['company_logo']);

                $imageName="company_".uniqid()."_".$userInsert.'.png';

                $file = $folderPath.$imageName;

                if(file_put_contents($file, $cLogoBase64))

                {

                    $company_logo=$imageName;

                } 

            }

            /* ====== End Company Logo ========= */



            $userProfile = array(

            'user_id'       =>  $userInsert,

            'user_type'     =>  $data['user_type'],

            'business_name' =>  $data['business_name'],

            'proof_number'  =>  $data['proof_no'],

            'expire_date'   =>  $data['expire_date'],

            'alt_contact'   =>  $data['alt_contact'],

            'address'       =>  $data['address'],

            'country_id'    =>  $data['country_id'],

            'state_id'      =>  $data['state_id'],

            'city'          =>  $data['city'],

            'business_year' =>  $data['business_year'],

            'website_url'   =>  $data['website_url'],

            'logo'          =>  $company_logo,

            'business_type' =>  $data['business_type'],

            'provider_status' =>  0

            );



            $this->db->insert('sp_profile',$userProfile);

            $userProfile=$this->db->insert_id();



            if($userProfile)

            {

                /* ====== For Business Card Images ========= */

                if(!empty($data['business_card']) && $data['business_card']!='')

                {

                    $businessCard=json_decode($data['business_card']);

                    $folderPath = DOCS_FOLDER_PATH."business_card/";    

                    if (!file_exists($folderPath)) {

                        mkdir($folderPath, 0777, true);

                    }



                    foreach ($businessCard as $image) {

                        $bCbase64 = base64_decode($image);

                        $imageName="business_".uniqid()."_".$userInsert.'.png';

                        $file = $folderPath.$imageName;

                        if(file_put_contents($file, $bCbase64))

                        {

                            $businessCardData = array(  

                            'ref_id' => $userInsert,  

                            'ref_type'  => 'business_card',

                            'ref_docs' => $imageName

                            );  

                            $this->db->insert('attachment_docs', $businessCardData);

                        }

                    }

                }

                /* ====== End Business Card Images ========= */



                /* ====== For Business Card Images ========= */

                if(!empty($data['review_pic']) && $data['review_pic']!='')

                {

                    $reviewPic=json_decode($data['review_pic']);

                    $folderPath = DOCS_FOLDER_PATH."review_img/";    

                    if (!file_exists($folderPath)) {

                        mkdir($folderPath, 0777, true);

                    }



                    foreach ($reviewPic as $image) {

                        $rPbase64 = base64_decode($image);

                        $imageName="business_".uniqid()."_".$userInsert.'.png';

                        $file = $folderPath.$imageName;

                        if(file_put_contents($file, $rPbase64))

                        {

                            $reviewData = array(  

                            'ref_id' => $userInsert,  

                            'ref_type'  => 'review_pics',

                            'ref_docs' => $imageName

                            );  

                            $this->db->insert('attachment_docs', $reviewData);

                        }

                    }

                }

                 /* ====== End Business Card Images ========= */



                 /* ====== For Business Card Images ========= */

                if(!empty($data['proof_docs']) && $data['proof_docs']!='')

                {

                    $proofDocs=json_decode($data['proof_docs']);

                    $folderPath = DOCS_FOLDER_PATH."company_docs/";    

                    if (!file_exists($folderPath)) {

                        mkdir($folderPath, 0777, true);

                    }



                    foreach ($proofDocs as $image) {

                        $compDocbase64 = base64_decode($image);

                        $imageName="business_".uniqid()."_".$userInsert.'.png';

                        $file = $folderPath.$imageName;

                        if(file_put_contents($file, $compDocbase64))

                        {

                            $compData = array(  

                            'ref_id' => $userInsert,  

                            'ref_type'  => 'company_proof',

                            'ref_docs' => $imageName

                            );  

                            $this->db->insert('attachment_docs', $compData);

                        }

                    }

                }

                 /* ====== End Business Card Images ========= */    

            }



            return $userProfile;

        }

        else

        {

            return false;

        }   

    }

    public function getSpStatus($user_id) {

        $this->db->select('provider_status');

        $this->db->from('sp_profile');

        $this->db->where('id', $user_id);

        return $this->db->get()->row();

        //echo $this->db->last_query(); die;

    }

    public function spProfileData($userId) {

        $this->db->select('users.*, users.id as user_id, sp_profile.*, country.name as country_name, state.name as state_name');

        $this->db->from('users');

        $this->db->join('sp_profile', 'sp_profile.user_id=users.id', 'INNER');

        $this->db->join('country', 'country.id=sp_profile.country_id', 'INNER');

        $this->db->join('state', 'state.id=sp_profile.state_id', 'LEFT');

        $this->db->where('users.id', $userId);

        return $this->db->get()->row();

        //echo $this->db->last_query(); die;

    }

    public function getAttachmentData($userId, $refType) {

        $this->db->select('id, ref_docs, ref_type, del_action');

        $this->db->from('attachment_docs');

        $this->db->where('ref_id', $userId);

        $this->db->where('ref_type', $refType);

        $this->db->where('del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function getCountryData() {

        $this->db->select('country.id, country.name, currency.symbol as currency_symbol, currency.id as currency_id');

        $this->db->from('country');

        $this->db->join('currency', 'currency.id=country.currency_id', 'INNER');

        $this->db->where('country.del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function getStateData($country_id) {

        $this->db->select('id, name');

        $this->db->from('state');

        $this->db->where('del_action', 'N');

        if($country_id!='')

        {

            $this->db->where('country_id', $country_id);

        }

        return $this->db->get()->result_array();

    }

    public function getCurrencyData() {

        $this->db->select('id, name, symbol');

        $this->db->from('currency');

        $this->db->where('del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function getSectorData() {

        $this->db->select('id, name');

        $this->db->from('sector');

        $this->db->where('del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function getCategoryData($sectorId) {

        $this->db->select('category.id as category_id, category.name as category_name, category.sector_id as sector_id, sector.name as sector_name,');

        $this->db->from('category');

        $this->db->join('sector', 'sector.id=category.sector_id');

        $this->db->where('category.del_action', 'N');

        if($sectorId!='')

        {

            $this->db->where('category.sector_id', $sectorId);

        }

        return $this->db->get()->result_array();

    }

    public function getJobTypeData() {

        $this->db->select('id, name');

        $this->db->from('job_type');

        $this->db->where('del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function getPaymentStructureData() {

        $this->db->select('id, name');

        $this->db->from('payment_structure');

        $this->db->where('del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function insertJobData($data) {

        $jobsData['title']=$data['title'];

        $jobsData['job_type_id']=$data['job_type_id'];

       /*  $jobsData['payment_structure_id']=$data['payment_structure_id'];

        $jobsData['currency_id']=$data['currency_id']; */

        $jobsData['from_date']=date('Y-m-d H:i:s', strtotime($data['from_date']));

        $jobsData['to_date']=date('Y-m-d H:i:s', strtotime($data['to_date']));

        $jobsData['expiry_date']=date('Y-m-d H:i:s', strtotime($data['expiry_date']));

        $jobsData['job_description']=$data['job_description'];

        $jobsData['country_id']=$this->checkCountry($data['country']);

        $jobsData['state_id']=$this->checkState($data['state']);

        $jobsData['location']=$data['location'];

        $jobsData['sector_id']=$data['sector_id'];

        $jobsData['category_id']=$data['category_id'];

        $jobsData['user_id']=$data['user_id'];

        $this->db->insert('jobs',$jobsData);

        $job_id=$this->db->insert_id(); 

        if($job_id) {

            /* $categoryData=explode(",", $data['category_id']);

            foreach($categoryData as $category_id)

            {

                $jobCatData['job_id']=$job_id;

                $jobCatData['category_id']=$category_id;

                $this->db->insert('job_post_category',$jobCatData);

            } */

            return $job_id;

        }

        else {

            return false;

        }

    }

    public function checkCountry($country_name) {

        $this->db->where('name', $country_name);

        $getCountry=$this->db->get('country');

        if($getCountry->num_rows()>0) {

            return $getCountry->row()->id;

        }

        else {

         $data['name']=$country_name;

         $this->db->insert('country',$data);

         return $this->db->insert_id();

        }



    }

    public function checkState($state_name) {

        $this->db->where('name', $state_name);

        $getState=$this->db->get('state');

        if($getState->num_rows()>0)

        {

            return $getState->row()->id;

        }

        else {

         $data['name']=$state_name;

         $this->db->insert('state',$data);

         return $this->db->insert_id();

        }

    }

    public function getJobDate($user_id) {

        $this->db->select('group_concat(id) as jobs_ids, created_at');

        $this->db->from('jobs');

        $this->db->where('del_action','N');

        $this->db->group_by('DATE(created_at)');   

        return $this->db->get()->result_array();

    }

    public function getJobList($job_id='') {

        $this->db->select('jobs.*, job_type.name as job_type_name, country.name as country_name, state.name as state_name, sector.name as sector_name');

        $this->db->from('jobs');

        $this->db->join('job_type', 'job_type.id=jobs.job_type_id', 'INNER');

        $this->db->join('country', 'country.id=jobs.country_id', 'INNER');

        $this->db->join('state', 'state.id=jobs.state_id', 'INNER');

        $this->db->join('sector', 'sector.id=jobs.sector_id', 'INNER');

        $this->db->where('jobs.del_action','N');

        $this->db->where('jobs.id',$job_id);

        return $this->db->get()->row();

    }

    public function getJobCategory($category_id) {

        $this->db->select('category.*, sector.name as sector_name');

        $this->db->from('category');

        $this->db->join('sector', 'sector.id=category.sector_id', 'INNER');

        $this->db->where('category.id', $category_id);

        $this->db->where('category.del_action', 'N');

        return $this->db->get()->row_array();

    }

    public function getJobResponseList($job_id) {

        $this->db->select('*');

        $this->db->from('job_response');

        $this->db->where('job_id', $job_id);

        $this->db->where('del_action', 'N');

        return $this->db->get()->result();

    }

    public function getJobResponse($res_id) {

        $this->db->select('*');

        $this->db->from('job_response');

        $this->db->where('id', $res_id);

        $this->db->where('del_action', 'N');

        return $this->db->get()->row();

    }

    public function offerJob($res_id,$offer_status) {

        $this->db->set('status', $offer_status);

        $this->db->where('id', $res_id);

        $this->db->update('job_response'); 



        $this->db->select('*');

        $this->db->from('job_response');

        $this->db->where('id', $res_id);

        $this->db->where('del_action', 'N');

        return $this->db->get()->row();

    }

    public function getAdtServiceList() {

        $this->db->select('additional_service.id, additional_service.name, additional_service.category_id, category.name as category_name, additional_service.price, additional_service.qty, additional_service.unit_id, unit.name as unit_name');

        $this->db->from('additional_service');

        $this->db->join('unit', 'unit.id=additional_service.unit_id', 'INNER');

        $this->db->join('category', 'category.id=additional_service.category_id', 'INNER');

        $this->db->where('additional_service.del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function getSPServiceList($user_id) {

        $this->db->select('service.id, service.name, service.category_id, category.name as category_name, service.service_type, service.price_type, service.price, service.qty, service.unit_id, unit.name as unit_name');

        $this->db->from('service');

        $this->db->join('unit', 'unit.id=service.unit_id', 'INNER');

        $this->db->join('category', 'category.id=service.category_id', 'INNER');

        $this->db->where('service.user_id', $user_id);

        $this->db->where('service.del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function getUnitList() {

        $this->db->select('id, name');

        $this->db->from('unit');

        $this->db->where('del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function checkServiceNameExist($service_name, $user_id) {

        $this->db->select('count(id) as total_count');

        $this->db->from('service');

        $this->db->where('name', $service_name);

        $this->db->where('user_id', $user_id);

        return $this->db->get()->row();



    }

    /*
    public function insertServiceBySP($data) {

        $serviceData['name']=$data['service_name'];

        $serviceData['category_id']=$data['category_id'];

        $serviceData['price_type']=$data['price_type'];

        $serviceData['unit_id']=$data['unit_id'];

        $serviceData['price']=$data['price'];

        $serviceData['qty']=$data['qty'];

        $serviceData['service_type']=$data['service_type'];

        $serviceData['user_id']=$data['user_id'];

       

        $this->db->insert('service',$serviceData);

        return $this->db->insert_id(); 

    }
    */

    public function insertServiceBySP($data) {

        $serviceData['sector_id']=$data['sector_id'];

        $serviceData['category_id']=$data['category_id'];

        $serviceData['user_id']=$data['user_id'];

        $serviceData['name']=$data['service_name'];

        $serviceData['description']=$data['description'];

        $serviceData['price_type']=$data['price_type'];

        $serviceData['unit_id']=$data['unit_id'];

        $serviceData['price']=$data['price'];

        $serviceData['qty']=$data['qty'];

        $serviceData['service_type']=$data['service_type'];

        $this->db->insert('service',$serviceData);

        return $this->db->insert_id(); 

    }

    public function createPackage($data) {

        $package['name']=$data['package_name'];

        $package['sector_id']=$data['sector_id'];

        $package['category_id']=$data['category_id'];

        $package['user_id']=$data['user_id'];

        $this->db->insert('package',$package);

        $package_id = $this->db->insert_id(); 

        if($package_id)

        {

            $packageDetails=json_decode($data['packageDetails']);

            foreach ($packageDetails as $packageService) {

                $packageServiceData['package_id']=$package_id;

                $packageServiceData['service_id']=$packageService->service_id;

                $packageServiceData['qty']=$packageService->qty;

                $packageServiceData['unit_id']=$packageService->unit_id;

                $packageServiceData['price']=$packageService->price;

                $this->db->insert('package_service',$packageServiceData);

                $package_service_id = $this->db->insert_id(); 

            }

                /*$packageTotal['package_id']=$package_id;

                $packageTotal['total']=$data['total'];

                $this->db->insert('package_total',$packageTotal);

                $package_total_id = $this->db->insert_id(); */



                $this->db->set('total', $data['total']);

                $this->db->where('id', $package_id);

                $this->db->update('package'); 



            return $package_id;

        }

        else

        {

            return false;

        }



    }

    public function getPackageList($user_id) {

        $this->db->select('package.id as package_id, package.name as package_name, package.category_id, package.total, category.name as category_name, package.sector_id, sector.name as sector_name, package.created_at');

        $this->db->from('package');

        //$this->db->join('package_total', 'package_total.package_id=package.id', 'INNER');

        $this->db->join('sector', 'sector.id=package.sector_id', 'INNER');

        $this->db->join('category', 'category.id=package.category_id', 'INNER');

        $this->db->where('package.user_id',$user_id);

        $this->db->where('package.del_action','N');

        return $this->db->get()->result_array();

    }

    public function getPackageServiceList($package_id) {

        $this->db->select('package_service.id as package_service_id, package_service.package_id as package_id, package_service.service_id as service_id, service.name as service_name, package_service.qty, package_service.unit_id, unit.name as unit_name, package_service.price');

        $this->db->from('package_service');

        $this->db->join('service', 'service.id=package_service.service_id', 'INNER');

        $this->db->join('unit', 'unit.id=package_service.unit_id', 'INNER');

        $this->db->where('package_service.package_id',$package_id);

        $this->db->where('package_service.del_action','N');

        return $this->db->get()->result_array();

       // echo $this->db->last_query(); die;

    }

    public function serviceByUserSector($data) {

        $this->db->select('service.name as service_name, service.sector_id, sector.name as sector_name, service.category_id, category.name as category_name, service.description, service.price_type, service.unit_id, unit.name as unit_name, service.price, service.qty, service.service_type');

        $this->db->from('service');

        $this->db->join('sector', 'sector.id=service.sector_id', 'INNER');

        $this->db->join('category', 'category.id=service.category_id', 'INNER');

        $this->db->join('unit', 'unit.id=service.unit_id', 'INNER');

        $this->db->where('service.del_action', 'N');

        $this->db->where('service.user_id', $data['user_id']);

        if(isset($data['sector_id']) && $data['sector_id']!='')

            $this->db->where('service.sector_id', $data['sector_id']);

        if(isset($data['category_id']) && $data['category_id']!='')

            $this->db->where('service.category_id', $data['category_id']);

        return $this->db->get()->result_array();

    }

    public function serviceListBySector($user_id) {

        $query = "select sector.id as sector_id, sector.name as sector_name, (SELECT count(service.id) FROM service where service.sector_id=sector.id and user_id='".$user_id."' and service.del_action='N') as total_service from sector where sector.del_action='N' order by sector.name ASC";

        return $this->db->query($query)->result_array();

    }

    public function updateSpEmail($user_id, $email) {

        $this->db->set('email', $email);

        $this->db->where('id', $user_id);

        $this->db->where('role_id', 2);

        $this->db->update('users');

        return true;

    }

    /*   
    public function updateSpProfile($data) {

        $spProfile = array(

            'full_name'=>'',

            'contact_no'=>'',

            );

        $this->db->set('email', $email);

        $this->db->where('id', $user_id);

        $this->db->update('users');

        return true;

    }*/

    public function update_spProfile($data) {

        $userData = array(

            'full_name' =>  $data['full_name'],

            'email'     =>  $data['email'],

            'contact_no'=>  $data['contact_no']

        );

		$this->db->where('id', $data['user_id']);

		$this->db->update('users', $userData);

       

		$userProfile = array(

			'country_id'    =>  $data['country_id'],

			'state_id'      =>  $data['state_id'],

			'city'          =>  $data['city'],

			'address'       =>  $data['address']

		);



		$this->db->where('user_id', $data['user_id']);

		$this->db->update('sp_profile', $userProfile);

        return true; 
    }

    public function update_sp_company_profile($data) {

		$user_id = $data['user_id'];

        $userData = array(

            'contact_no'=>  $data['contact_no']

        );

		$this->db->where('id', $user_id);

		$this->db->update('users', $userData);

		

        

		/* ====== For Company Logo ========= */

		$company_logo='';

		if(isset($data['company_logo']) && $data['company_logo']!='') {

			$folderPath = DOCS_FOLDER_PATH."company_logo/";   

			if (!file_exists($folderPath)) {

				mkdir($folderPath, 0777, true);

			}

			$cLogoBase64 = base64_decode($data['company_logo']);

			$imageName="company_".uniqid()."_".$user_id.'.png';

			$file = $folderPath.$imageName;

			if(file_put_contents($file, $cLogoBase64)) {

				$company_logo=$imageName;

				$spCompanyLogo = array(

					'logo'=>  $company_logo

				);

				$this->db->where('user_id', $user_id);

				$this->db->update('sp_profile', $spCompanyLogo);

				

			} 

		}

		/* ====== End Company Logo ========= */



		$userProfile = array(

		'business_name' =>  $data['business_name'],

		'proof_number'  =>  $data['proof_no'],

		'expire_date'   =>  $data['expire_date'],

		'alt_contact'   =>  $data['alt_contact'],

		'business_year' =>  $data['business_year'],

		'website_url'   =>  $data['website_url']

		);

		

		$this->db->where('user_id', $user_id);

		$this->db->update('sp_profile', $userProfile);

				



		/* ====== For Business Card Images ========= */

		if(isset($data['business_card']) && !empty($data['business_card']) && $data['business_card']!='') {

			$businessCard=json_decode($data['business_card']);

			$folderPath = DOCS_FOLDER_PATH."business_card/";    

			if (!file_exists($folderPath)) {

				mkdir($folderPath, 0777, true);

			}



			foreach ($businessCard as $image) {

				$bCbase64 = base64_decode($image);

				$imageName="business_".uniqid()."_".$user_id.'.png';

				$file = $folderPath.$imageName;

				if(file_put_contents($file, $bCbase64)) {

					$this->db->where('ref_id', $user_id);

					$this->db->where('ref_type', 'business_card');

					$this->db->delete('attachment_docs');



					$businessCardData = array(  

					'ref_id' => $user_id,  

					'ref_type'  => 'business_card',

					'ref_docs' => $imageName

					);  

					$this->db->insert('attachment_docs', $businessCardData);

				}

			}

		}

		/* ====== End Business Card Images ========= */



		/* ====== For Business Card Images ========= */

		if(isset($data['review_pic']) && !empty($data['review_pic']) && $data['review_pic']!='') {

			$reviewPic=json_decode($data['review_pic']);

			$folderPath = DOCS_FOLDER_PATH."review_img/";    

			if (!file_exists($folderPath)) {

				mkdir($folderPath, 0777, true);

			}



			foreach ($reviewPic as $image) {

				$rPbase64 = base64_decode($image);

				$imageName="business_".uniqid()."_".$user_id.'.png';

				$file = $folderPath.$imageName;

				if(file_put_contents($file, $rPbase64)) {

					$this->db->where('ref_id', $user_id);

					$this->db->where('ref_type', 'review_pics');

					$this->db->delete('attachment_docs');

					

					$reviewData = array(  

					'ref_id' => $user_id,  

					'ref_type'  => 'review_pics',

					'ref_docs' => $imageName

					);  

					$this->db->insert('attachment_docs', $reviewData);

				}

			}

		}

		 /* ====== End Business Card Images ========= */



		 /* ====== For Business Card Images ========= */

		if(isset($data['proof_docs']) && !empty($data['proof_docs']) && $data['proof_docs']!='') {

			$proofDocs=json_decode($data['proof_docs']);

			$folderPath = DOCS_FOLDER_PATH."company_docs/";    

			if (!file_exists($folderPath)) {

				mkdir($folderPath, 0777, true);

			}



			foreach ($proofDocs as $image) {

				$compDocbase64 = base64_decode($image);

				$imageName="business_".uniqid()."_".$user_id.'.png';

				$file = $folderPath.$imageName;

				if(file_put_contents($file, $compDocbase64)) {

					$this->db->where('ref_id', $user_id);

					$this->db->where('ref_type', 'company_proof');

					$this->db->delete('attachment_docs');

					

					$compData = array(  

					'ref_id' => $user_id,  

					'ref_type'  => 'company_proof',

					'ref_docs' => $imageName

					);  

					$this->db->insert('attachment_docs', $compData);

				}

			}

		}

		 /* ====== End Business Card Images ========= */    



		return $user_id;       

    }

    public function insert_estimator($data) {

        $estimatorData = array(

	        'title' => $this->input->post('estimator_title'),

	        'total_price' => $this->input->post('total_price'),

	        'created_by' => $this->input->post('created_by')

	        );

        $this->db->insert('estimator',$estimatorData);

        $estimator_id = $this->db->insert_id();

        

        if($estimator_id)  {

            $estimatorDetails=json_decode($data['estimatorDetails']);

            foreach ($estimatorDetails as $item) {

                $estimatorItemData['estimator_id']=$estimator_id;

                $estimatorItemData['service_id']=$item->service_id;

                $estimatorItemData['service_name']=$item->service_name;

                $estimatorItemData['description']=$item->description;

                $estimatorItemData['qty']=$item->qty;

                $estimatorItemData['price']=$item->price;

                $estimatorItemData['total']=$item->total;

                $this->db->insert('estimator_items',$estimatorItemData);

            }

            

            $paymentMilestone=json_decode($data['paymentMilestone']);

            foreach ($paymentMilestone as $milestone) {

                $milestoneData['estimator_id']=$estimator_id;

                $milestoneData['title']=$milestone->milestone_title;

                $milestoneData['amt_percentage']=$milestone->amt_percentage;

                $milestoneData['due_date']=$milestone->due_date;

                $this->db->insert('payment_milestone',$milestoneData);

            }

        }

        return $estimator_id;

    }

    public function get_estimator_list($user_id) {

        $this->db->select('*');

        $this->db->from('estimator');

        $this->db->where('created_by', $user_id);

        $this->db->where('del_action', 'N');

        $this->db->order_by('created_at', 'DESC');

        return $this->db->get()->result_array();

    }

    public function get_estimator_by_id($estimator_id, $user_id) {

        $this->db->select('estimator.*, users.full_name as customer_name');

        $this->db->from('estimator');

        $this->db->join('users', 'users.id=estimator.accepted_by', 'LEFT');

        $this->db->where('estimator.id', $estimator_id);

        $this->db->where('estimator.created_by', $user_id);

        $this->db->where('estimator.del_action', 'N');

        $this->db->order_by('estimator.created_at', 'DESC');

        return $this->db->get()->row();

    }

    public function get_estimator_items($estimator_id) {

        $this->db->select('*');

        $this->db->from('estimator_items');

        $this->db->where('estimator_id', $estimator_id);

        $this->db->where('del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function get_estimator_milestone($estimator_id) {

        $this->db->select('*');

        $this->db->from('payment_milestone');

        $this->db->where('estimator_id', $estimator_id);

        $this->db->where('del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function insertEmployee($data) {

        $this->db->where('contact_no', $data['contact_no']);

    	$getEmp=$this->db->get('users');

    	if($getEmp->num_rows()>0) {

    		$employee_id = $getEmp->row()->id;

    	}

    	else {

            $empDetails = array(

            'full_name' =>  $data['full_name'],

            'email' => $data['email'],

            'contact_no' => $data['contact_no'],

            'status' =>  1,

            'role_id' =>  3

            );



            $this->db->insert('users',$empDetails);

            $employee_id=$this->db->insert_id();

    	}

    	return $employee_id;

    }

    public function checkExistingEmp($employee_id, $company_id) {

        $this->db->where('employee_id ', $employee_id);

        $this->db->where('company_id ', $company_id);

    	$getEmpProfile=$this->db->get('emp_profile');

    	if($getEmpProfile->num_rows()>0) {

    		return $getEmpProfile->row()->id;

    	}

    	else {

    	    return false;

    	}

    }

    public function insertEmpProfile($data) {

        $this->db->insert('emp_profile',$data);

        return $this->db->insert_id();

    }

    public function getEmployeeList($user_id) {

        $this->db->select('users.id as employee_id, users.full_name, users.email, users.contact_no, users.status, users.role_id, users.del_action, emp_profile.profile_pic');

        $this->db->from('users');

        $this->db->join('emp_profile', 'emp_profile.employee_id=users.id and emp_profile.del_action="N"', 'INNER');

        $this->db->where('emp_profile.company_id', $user_id);

        $this->db->where('users.del_action', 'N');

        return $this->db->get()->result_array();

    }

    public function getEmployeeDetail($user_id) {

        $this->db->select('users.id as employee_id, users.full_name, users.email, users.contact_no, users.status, users.role_id, users.del_action, emp_profile.profile_pic');

        $this->db->from('users');

        $this->db->join('emp_profile', 'emp_profile.employee_id=users.id and emp_profile.del_action="N"', 'INNER');

        $this->db->where('emp_profile.employee_id', $user_id);

        $this->db->where('users.del_action', 'N');

        return $this->db->get()->row_array();

    }

}

