<?php

if(!function_exists('checkUserLogin')){
    /**
    * Checks if user if logged in. If not, add url to query param and redirect 
    * the user to login page..
    */
    function checkUserLogin(){
        $ci = &get_instance();
        if(!$ci->session->has_userdata(SESS_IS_LOGGED_IN)){
            $referrer_value = getFullUrl();
            redirect('auth/login?referrer='.$referrer_value);
        }
    }
}

if(!function_exists('getFullUrl')){
    /**
    * Returns the full URL including parameters.
     * 
    * @return   string
    */
    function getFullUrl(){
        $ci = &get_instance();
        return uri_string().'?'.http_build_query($ci->input->get());
    }
}

if(!function_exists('getQueryParams')){
    /**
    * Returns query parameters of the current URL.
     * 
    * @return   string
    */
    function getQueryParams($excludedParams=[]){
        $ci = &get_instance();
        $params = $ci->input->get();
        foreach ($excludedParams as $removeParamKey){
            unset($params[$removeParamKey]);
        }
        return http_build_query($params);
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

if(!function_exists('hashThis')){
    /**
    * Returns the hashed value of the string using default algorithm.
     * 
    * @param    string     $text    String to be encrypted.
    * @return   string
    */
    function hashThis($text){
        return password_hash($text, PASSWORD_DEFAULT);
    }
}

if(!function_exists('logArray')){
    /**
    * Print array contents into the log file.
    * 
    * @param    string     $level   error, debug, or info
    * @param    string     $array   Array of strings
    */
    function logArray($level,$array){
        foreach($array as $key => $value) {
            log_message($level, "$key : $value");
        }
    }
}

if(!function_exists('createTextFilter')){
    /**
    * Creates a filter for text fields.
    * 
    * @param    string     $label   Label of the filter. Out of it, the ID will be generated.
    */
    function createTextFilter($label){
        if(!trim($label)){
            return;
        }
        $id = strtolower(str_replace(' ', '_', trim($label)));
        echo "  <div class='form-group row  d-flex justify-content-around'>
                    <label for='role' class='col-form-label col-sm-3 text-center' id='label_$id'>".ucwords($label)."</label>
                    <div class='col-sm-3'>
                        <select name='condition_$id' id='condition_$id' class='custom-select'>
                            <option value=''>Select Condition</option>
                            <option value='".CONDITION_EQUALS."'>Equals</option>
                            <option value='".CONDITION_NOT_EQUAL."'>Not Equal</option>
                            <option value='".CONDITION_STARTS_WITH."'>Starts With</option>
                            <option value='".CONDITION_ENDS_WITH."'>Ends With</option>
                            <option value='".CONDITION_CONTAINS."'>Contains</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <input type='text' class='form-control' id='value_$id' name='value_$id' maxLength='255'>
                    </div>
                    <input type='checkbox' class='chk mt-2 col-sm-1' name='display_".$id."'>
                </div>";
    }
}

if(!function_exists('createSelectionFilter')){
    /**
    * Creates a filter for selection fields.
    * 
    * @param    string     $label       Label of the filter. Out of it, the ID will be generated.
    * @param    string     $options     Key will be the value and value will be the label.
    */
    function createSelectionFilter($label,$options){
        if(!trim($label)){
            return;
        }
        $id = strtolower(str_replace(' ', '_', trim($label)));
        $selection = "<select name='value_$id' id='value_$id' class='custom-select'>";
        foreach ($options as $value => $text) {
            $selection .= "<option value='".$value."'>{$text}</option>";
        }
        $selection .= "</select>";
        echo "  <div class='form-group row  d-flex justify-content-around'>
                    <label for='role' class='col-form-label col-sm-3 text-center' id='label_$id'>".ucwords($label)."</label>
                    <div class='col-sm-3'>
                        <select name='condition_$id' id='condition_$id' class='custom-select'>
                            <option value=''>Select Condition</option>
                            <option value='".CONDITION_EQUALS."'>Equals</option>
                            <option value='".CONDITION_NOT_EQUAL."'>Not Equal</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        {$selection}
                    </div>
                    <input type='checkbox' class='chk mt-2 col-sm-1' name='display_".$id."'>
                </div>";
    }
}

if(!function_exists('createDateCondition')){
    /**
    * Creates a filter for date fields.
    * 
    * @param    string     $label   Label of the filter. Out of it, the ID will be generated.
    */
    function createDateCondition($label){
        if(!trim($label)){
            return;
        }
        $id = strtolower(str_replace(' ', '_', trim($label)));
        echo "  <div class='form-group row  d-flex justify-content-around' id='date_field_$id'>
                    <label for='role' class='col-form-label col-sm-3 text-center' id='label_$id'>".ucwords($label)."</label>
                    <div class='col-sm-3'>
                        <select name='condition_$id' id='condition_$id' class='custom-select date-field-select'>
                            <option value=''>Select Condition</option>
                            <option value='".CONDITION_EQUALS."'>On</option>
                            <option value='".CONDITION_BEFORE."'>Before</option>
                            <option value='".CONDITION_AFTER."'>After</option>
                            <option value='".CONDITION_FROM."'>From</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <input type='date' class='form-control' id='value_$id' name='value_$id' maxLength='50'>
                    </div>
                    <input type='checkbox' class='chk mt-2 col-sm-1' name='display_".$id."'>
                </div>";
    }
}
