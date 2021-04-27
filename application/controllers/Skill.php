<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Skill
 *
 * Handles skill api.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Skill extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('SkillCategoryModel');
        $this->load->model('SkillModel');
        $this->load->model('UserLogModel');
    }
    
    /**
    * List skills into json format.
    */
    public function getSkillsByCategory(){
        $skillCategoryId = $this->input->get("skillCategoyId");
        $skills = $this->SkillModel->getSkillByCategoryId($skillCategoryId);
        if($skills === ERROR_CODE){
            echo "Error";
        }
        echo json_encode($skills);
    }
    
    /**
    * Display list of job orders.
    */
    public function skillList(){
        checkUserLogin();
        $rowsPerPage = getRowsPerPage($this,COOKIE_SKILL_ROWS_PER_PAGE);
        $totalCount = $this->SkillModel->getSkillCount();
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $result = $this->SkillModel->getSkills($rowsPerPage,$data['offset']);        
        if($result === ERROR_CODE){
            $data["error_message"] = "Error occured.";        
        }
        $data['skills'] = $result;
        $skillCategories = $this->SkillCategoryModel->getSkillCategories(0,0,'name','asc');
        if($skillCategories === ERROR_CODE){
            return ERROR_CODE;
        }
        $data["skillCategories"] = $skillCategories;
        renderPage($this,$data,'skill/skillList');
    }
    
    /**
    * Add a new skill.
    */
    public function add(){
        checkUserLogin();
        $skill_name = $this->input->post('skill_name');
        if(!$skill_name){
            echo 'Skill name is required';
            return;
        }
        $category_id = $this->input->post('skill_category_id');
        if(!$category_id){
            echo 'Skill category is required';
            return;
        }
        if($this->SkillModel->skillExist($skill_name,$category_id)){
            echo 'Skill already exist';
            return;
        }
        $skill = (object)[
            'name'=>$skill_name,
            'category_id'=>$category_id,
            'created_by'=>$this->session->userdata(SESS_USER_ID),
            'is_deleted'=>0];
        $success = $this->SkillModel->addSkill($skill);
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Added skill '".$skill_name."'");
        echo 'Success';
    }
    
    /**
    * Delete skills.
    */
    public function delete(){
        checkUserLogin();
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $sids = $this->input->post('delSkillIds');
        if(!$sids){
            echo 'Invalid Skill ID';
            return;
        }
        $skill_ids = explode(",", $sids);
        $skill_names = $this->input->post('delSkillNames');
        if(!$sids){
            echo 'Invalid Skill ID';
            return;
        }
        $success = $this->SkillModel->deleteSkill($skill_ids,
                $this->session->userdata(SESS_USER_ID));
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Deleted skill/s : ".$skill_names);
        echo 'Success';
    }
    
    /**
    * Update skill details.
    */
    public function update(){
        checkUserLogin();
        $skill_id = $this->input->post('skill_id');
        if(!$skill_id){
            echo 'Error occured';
            return;
        }
        $skill_name = $this->input->post('update_skill_name');
        if(!$skill_name){
            echo 'Skill name is required';
            return;
        }
        $category_id = $this->input->post('update_cat_id');
        if(!$category_id){
            echo 'Skill category is required';
            return;
        }
        if($this->SkillModel->skillExist($skill_name,$category_id)){
            echo 'Skill already exist';
            return;
        }
        $skill = (object)[
            'name'=>$skill_name,
            'category_id'=>$category_id];
        $success = $this->SkillModel->updateSkill($skill,$skill_id);
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Updated skill '".$skill_name."'");
        echo 'Success';
    }
    
    public function addCategory(){
        checkUserLogin();
        $category_name = $this->input->post('category_name');
        if(!$category_name){
            echo 'Error occured';
            return;
        }
        if($this->SkillCategoryModel->skillCategoryExist($category_name)){
            echo 'Category already exist';
            return;
        }
        $skillCategory = (object)[
            'name' => $category_name,
        ];
        $success = $this->SkillCategoryModel->addSkillCategory($skillCategory);
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),
                "Added skill category '".$category_name."'");
        echo 'Success';
    }
}