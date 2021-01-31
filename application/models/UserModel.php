<?php
/**
 * UserModel
 *
 * Model class for user entity.
 * 
 * @category    Model
 * @author      Steven Villarosa
 */
Class UserModel extends CI_Model{

    /**
    * Class constructor.
    */
    public function __construct() {
        $this->load->database();
    }
    
    /**
    * Returns user object if username exist in the database.
    *
    * @param    string  $username   Username string
    * @return   user object
    */
    public function getUserByUsername($username){
        $this->db->where("username", $username);
        $this->db->where("status !=", USER_STATUS_DELETED);
        $query = $this->db->get("user");
        return $query->row();
    }

    /**
    * Returns user objects.
    *
    * @param    int     $limit  Limit count
    * @param    int     $offset Offset value
    * @return   array of user objects
    */
    public function getUsers($limit=25,$offset=0){
        $this->db->where("status !=", USER_STATUS_DELETED);
        $query = $this->db->get('user',$limit,$offset);
        return $query->result();
    }
    
    /**
    * Returns user object if userId exist in the database.
    *
    * @param    int     $userId
    * @return   user object
    */
    public function getUserById($userId){
        $this->db->where("id", $userId);
        $this->db->where("status !=", USER_STATUS_DELETED);
        $query = $this->db->get("user");
        return $query->row();
    }
    
    /**
    * Sets the user status to USER_STATUS_BLOCKED(1) and returns true if success.
    *
    * @param    int     $userId
    * @return   boolean
    */
    public function blockUser($userId){
        $this->db->where("id", $userId);
        $success = $this->db->update('user', array('status' => USER_STATUS_BLOCKED));
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return true;
    }
    
    /**
    * Sets the user status to USER_STATUS_BLOCKED(1) and returns true if success.
    *
    * @param    int     $userId
    * @return   boolean
    */
    public function activateUser($userId){
        $this->db->where("id", $userId);
        $success = $this->db->update('user', array('status' => USER_STATUS_ACTIVE));
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return true;
    }
    
    /**
    * Increments failed_login count.
    *
    * @param    int     $userId
    */
    public function addLoginFailed($userId){
        $this->db->where("id", $userId);
        $this->db->set('failed_login', 'failed_login+1', FALSE);
        $this->db->update('user');
    }
    
    /**
    * Resets failed_login count.
    *
    * @param    int     $userId
    */
    public function resetLoginFailed($userId){
        $this->db->where("id", $userId);
        $this->db->set('failed_login', 0);
        $this->db->update('user');
    }
    
    /**
    * Adds user to the database.
    *
    * @param    user object     $user
    * @return   id of the new user.
    */
    public function addUser($user){
        $userObj = $this->createUserObject($user);
        //Encrypt user password
        $userObj->password = hashThis($user->password);
        $success = $this->db->insert('user', $userObj);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return -1;
        }
        return $this->db->insert_id();
    }
    
    /**
    * Updates user details. Returns true if successful.
    *
    * @param    user object     $user
    * @return   boolean
    */
    public function updateUserDetails($user,$userId){
        $userObj = $this->createUserObject($user);
        unset($userObj->username);
        unset($userObj->password);
        unset($userObj->id);
        $this->db->where("id", $userId);
        $success = $this->db->update('user', $userObj);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return true;
    }
    
    /**
    * Updates user profile details. Returns true if successful.
    *
    * @param    user object     $user
    * @return   boolean
    */
    public function updateUserProfile($user,$userId){
        $userObj = $this->createUserObject($user);
        unset($userObj->username);
        unset($userObj->password);
        unset($userObj->role);
        unset($userObj->status);
        unset($userObj->id);
        $this->db->where("id", $userId);
        $success = $this->db->update('user', $userObj);
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return true;
    }
    
    /**
    * Creates user object to make sure that object properties are correct.
    * 
    * @return   user object
    */
    private function createUserObject($user,$userId=null){
        $userObj = (object)[
            'username' => $user->username,
            'password' => $user->password,
            'role' => $user->role,
            'status' => $user->status,
            'email' => $user->email,
            'contact_number' => $user->contact_number,
            'name' => $user->name,
            'address' => $user->address,
            'birthday' => $user->birthday,
        ];
        if($userId){
            $userObj->id = $userId;
        }
        return $userObj;
    }
    
    /**
    * Updates user password. Returns true if success.
    *
    * @param    string      $password
    * @return   boolean
    */
    public function updateUserPassword($userId,$password){
        $this->db->where("id", $userId);
        $hashedPw = hashThis($password);
        $this->db->set('password', $hashedPw);
        $success = $this->db->update('user');
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return true;
    }
        
    /**
    * Returns the total count of users that are not deleted.
    *
    * @param    int     $userId
    */
    public function getUserCount(){
        $this->db->where("status !=", USER_STATUS_DELETED);
        $this->db->from('user');
        return $this->db->count_all_results(); 
    }
    
    /**
    * Sets the user status to USER_STATUS_DELETED(2). Returns true if successful.
    *
    * @param    int[]     $userIds      array of user IDs.
    * @return   boolean
    */
    public function deleteUser($userIds){
        $this->db->where_in('id', $userIds);
        $success = $this->db->update('user', array('status' => USER_STATUS_DELETED));
        if(!$success){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return true;
    }
    
    /**
    * Returns array of users based on critera.
    *
    * @param    object     $searchParams    List of criteria includig display columns
    * @param    int     $offset Offset value
    * @return   array of user objects
    */
    public function searchUser($searchParams,$columns,$limit=25,$offset=0){
        if(!count($columns)){
            log_message('error', "searchUser: No columns to display");
            return false;
        }
        $this->db->select("id,".implode(",", $columns));
        $this->setWhereParams($searchParams);
        $query = $this->db->get('user',$limit,$offset);
        if(!$query){
            logArray('error',$this->db->error());
            log_message('error', "Query : ".$this->db->last_query());
            return false;
        }
        return $query->result_array();
    }
    
    /**
    * Returns the total count of users based on criteria.
    *
    * @param    search param object     $searchParams
    */
    public function searchUserCount($searchParams){
        $this->setWhereParams($searchParams);
        $this->db->from('user');
        $count = $this->db->count_all_results();
        return $count;
    }
    
    
    /**
    * Sets where condition for search.
    *
    * @param    search param object     $searchParams
    */
    private function setWhereParams($searchParams){
        $this->db->where("status !=", USER_STATUS_DELETED);
        foreach ($searchParams as $param){
            if(empty($param->value) || empty($param->condition)){
                continue;
            }
            switch (strval($param->condition)){
                case CONDITION_EQUALS:
                    $this->db->where($param->field, $param->value);
                    break;
                case CONDITION_NOT_EQUAL:
                    $this->db->where($param->field." !=", $param->value);
                    break;
                case CONDITION_STARTS_WITH:
                    $this->db->like($param->field, $param->value, 'after');
                    break;
                case CONDITION_ENDS_WITH:
                    $this->db->where($param->field, $param->value, 'before');
                    break;
                case CONDITION_CONTAINS:
                    $this->db->where($param->field, $param->value);
                    break;
                case CONDITION_BEFORE:
                    $this->db->where($param->field." <", $param->value);
                    break;
                case CONDITION_AFTER:
                    $this->db->where($param->field." >", $param->value);
                    break;
                case CONDITION_FROM:
                    $this->db->where($param->field." >=", $param->value);
                    $this->db->where($param->field." <=", $param->value_2);
                    break;
            }
        }
    }
}
