<?php

if(!function_exists('checkUserLogin')){
    /**
    * Checks if user if logged in. If not, add url to query param and redirect 
    * the user to login page..
    */
    function checkUserLogin(){
        $ci = &get_instance();
        if(!$ci->session->has_userdata(SESS_IS_LOGGED_IN)){
            $referrer_value = uri_string().'?'.$_SERVER['QUERY_STRING'];
            redirect('auth/login?referrer='.$referrer_value);
        }
    }
}

if(!function_exists('getRoleDictionary')){
    /**
    * Returns the equivalent text of a role.
     * 
    * @param    int     $role   Role integer.
    * @return   string
    */
    function getRoleDictionary($role){
        switch($role){
            case USER_ROLE_ADMIN: return "Admin";
            case USER_ROLE_RECRUITER: return "Recruiter";
        }
    }
}

if(!function_exists('getStatusDictionary')){
    /**
    * Returns the equivalent text of a status.
     * 
    * @param    int     $status   Status integer.
    * @return   string
    */
    function getStatusDictionary($status){
        switch($status){
            case USER_STATUS_ACTIVE: return "Active";
            case USER_STATUS_BLOCKED: return "Blocked";
            case USER_STATUS_DELETED: return "Deleted";
        }
    }
}
