<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee_model extends CI_Model {

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

    public function employeeSignup($data) {
        $userData = array(
            'full_name' =>  $data['full_name'],
            'email'     =>  $data['email'],
            'contact_no'=>  $data['contact_no'],
            'status'    =>  '1',
            'added_by'  =>  $data['added_by'],
            'role_id'   =>  3
        );
        $this->db->insert('users',$userData);
        $userInsert=$this->db->insert_id();
        return $userInsert;
    }

    public function employeeProfileData($userId) {
        $this->db->select('users.*, users.id as user_id');
        $this->db->from('users');
        $this->db->where('users.id', $userId);
        return $this->db->get()->row();
    }

    public function getJobList() {

        $this->db->select('jobs.*, job_type.name as job_type_name, country.name as country_name, state.name as state_name, sector.name as sector_name');

        $this->db->from('jobs');

        $this->db->join('job_type', 'job_type.id=jobs.job_type_id', 'INNER');

        $this->db->join('country', 'country.id=jobs.country_id', 'INNER');

        $this->db->join('state', 'state.id=jobs.state_id', 'INNER');

        $this->db->join('sector', 'sector.id=jobs.sector_id', 'INNER');

        $this->db->where('jobs.del_action','N');

        return $this->db->get()->result();

    }

    public function getJobCategory($category_id) {

        $this->db->select('category.*, sector.name as sector_name');

        $this->db->from('category');

        $this->db->join('sector', 'sector.id=category.sector_id', 'INNER');

        $this->db->where('category.id', $category_id);

        $this->db->where('category.del_action', 'N');

        return $this->db->get()->row_array();

    }

    public function getJobDetail($singleJobId) {

        $this->db->select('jobs.*, job_type.name as job_type_name, country.name as country_name, state.name as state_name, sector.name as sector_name');

        $this->db->from('jobs');

        $this->db->join('job_type', 'job_type.id=jobs.job_type_id', 'INNER');

        $this->db->join('country', 'country.id=jobs.country_id', 'INNER');

        $this->db->join('state', 'state.id=jobs.state_id', 'INNER');

        $this->db->join('sector', 'sector.id=jobs.sector_id', 'INNER');

        $this->db->where('jobs.id',$singleJobId);

        $this->db->where('jobs.del_action','N');

        return $this->db->get()->row();

    }

    public function applyJob($data) {

        $jobData['job_id']      = $data['job_id'];

        $jobData['user_id']     = $data['user_id'];

        $jobData['name']        = $data['name'];
        
        $jobData['email']        = $data['email'];

        $jobData['skills']      = $data['skills'];

        $jobData['experience']  = $data['experience'];

        $jobData['description'] = $data['description'];

        $this->db->insert('job_response',$jobData);

        $response_id = $this->db->insert_id(); 

        if($response_id) {

            /* ====== For Employee Sample Work Images ========= */

            if(!empty($data['sample_work']) && $data['sample_work']!='') {

                $sampleWork = json_decode($data['sample_work']);

                $folderPath = DOCS_FOLDER_PATH."sample_work/";    

                if (!file_exists($folderPath)) {

                    mkdir($folderPath, 0777, true);

                }



                foreach ($sampleWork as $image) {

                    $bCbase64 = base64_decode($image);

                    $imageName = "sampleW_".uniqid()."_".$response_id.'.png';

                    $file = $folderPath.$imageName;

                    if(file_put_contents($file, $bCbase64))

                    {

                        $sampleWorkData = array(  

                        'ref_id'    => $response_id,  

                        'ref_type'  => 'sample_work',

                        'ref_docs'  => $imageName

                        );  

                        $this->db->insert('attachment_docs', $sampleWorkData);

                    }

                }

            }

            /* ====== End Employee Sample Work Images ========= */

            return $response_id;
        }
        else {
            return false;
        }

    }

}
