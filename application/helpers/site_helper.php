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
            case USER_ROLE_ADMIN: return USER_ROLE_ADMIN_TEXT;
            case USER_ROLE_RECRUITER: return USER_ROLE_RECRUITER_TEXT;
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
                            <option value='".CONDITION_EQUALS."'>".getConditionDictionary(CONDITION_EQUALS)."</option>
                            <option value='".CONDITION_NOT_EQUAL."'>".getConditionDictionary(CONDITION_NOT_EQUAL)."</option>
                            <option value='".CONDITION_STARTS_WITH."'>".getConditionDictionary(CONDITION_STARTS_WITH)."</option>
                            <option value='".CONDITION_ENDS_WITH."'>".getConditionDictionary(CONDITION_ENDS_WITH)."</option>
                            <option value='".CONDITION_CONTAINS."'>".getConditionDictionary(CONDITION_CONTAINS)."</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <input type='text' class='form-control' id='value_$id' name='value_$id' maxLength='255'>
                    </div>
                    <input type='checkbox' class='chk mt-2 col-sm-1' name='display_".$id."' checked>
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
                            <option value='".CONDITION_EQUALS."'>".getConditionDictionary(CONDITION_EQUALS)."</option>
                            <option value='".CONDITION_NOT_EQUAL."'>".getConditionDictionary(CONDITION_NOT_EQUAL)."</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        {$selection}
                    </div>
                    <input type='checkbox' class='chk mt-2 col-sm-1' name='display_".$id."' checked>
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
                            <option value='".CONDITION_EQUALS."'>".getConditionDictionary(CONDITION_EQUALS)."</option>
                            <option value='".CONDITION_BEFORE."'>".getConditionDictionary(CONDITION_BEFORE)."</option>
                            <option value='".CONDITION_AFTER."'>".getConditionDictionary(CONDITION_AFTER)."</option>
                            <option value='".CONDITION_FROM."'>".getConditionDictionary(CONDITION_FROM)."</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <input type='date' class='form-control' id='value_$id' name='value_$id' maxLength='50'>
                    </div>
                    <input type='checkbox' class='chk mt-2 col-sm-1' name='display_".$id."' checked>
                </div>";
    }
}

if(!function_exists('getConditionDictionary')){
    /**
    * Returns the equivalent text of a condition.
     * 
    * @param    int     $condition   Condition integer.
    * @return   string
    */
    function getConditionDictionary($condition){
        switch ($condition){
            case CONDITION_EQUALS:
                return "Equals";
            case CONDITION_NOT_EQUAL:
                return "Not Equal";
            case CONDITION_STARTS_WITH:
                return "Starts With";
            case CONDITION_ENDS_WITH:
                return "Ends With";
            case CONDITION_CONTAINS:
                return "Contains";
            case CONDITION_BEFORE:
                return "Before";
            case CONDITION_AFTER:
                return "After";
            case CONDITION_FROM:
                return "From";
        }
    }
}

if(!function_exists('generateTextForFilters')){
    /**
    * Generates text for filters.
     * 
    * @param    search params object    $searchParams
    * @return   string
    */
    function generateTextForFilters($searchParams){
        $textFilters = [];
        foreach ($searchParams as $param){
            if(empty($param->value) || empty($param->condition)){
                continue;
            }
            $field = ucwords(str_replace("_", " ", $param->field));
            $condition = getConditionDictionary(strval($param->condition));
            if(strval($param->condition) == CONDITION_FROM){
                $textFilter = "$field $condition ".
                        $param->value." TO ".$param->value_2;
                array_push($textFilters, $textFilter);
                continue;
            }
            $textFilter = "$field $condition ".$param->value;
            array_push($textFilters, $textFilter);   
        }
        return $textFilters;
    }
}

if(!function_exists('getRowsPerPage')){
    /**
    * Returns the value of rows per page.
    * 
    * @return   int value
    */
    function getRowsPerPage($ctx,$module){        
        // Default rows per page(25) is set if rowsPerPage is not changed.
        $rowsPerPage = $ctx->input->cookie($module)?
                $ctx->input->cookie($module) : 25;
        // If user changes the number of rows per page, store it into cookie
        if($ctx->input->get('rowsPerPage')){
            set_cookie($module, $ctx->input->get('rowsPerPage'),
                    COOKIE_EXPIRATION);
            $rowsPerPage = $ctx->input->get('rowsPerPage');
        }
        return $rowsPerPage;
    }
}

if(!function_exists('setPaginationData')){
    /**
    * Creates pagination data.
    * 
    * @param    int  $totalCount    The total number of users in the database.   
    * @param    int  $rowsPerPage   The number of users per page.
    * @param    int  $currentPage   The active page.
    * @return   object(field,condition,value[,value_2])
    */
    function setPaginationData($totalCount,$rowsPerPage,$currentPage){        
        $totalPage = floor($totalCount/$rowsPerPage);
        if($totalCount%$rowsPerPage != 0){
            $totalPage++;
        }
        $offset = ($currentPage - 1) * $rowsPerPage;
        $data['totalPage'] = $totalPage;
        $data['rowsPerPage'] = $rowsPerPage;
        $data['currentPage'] = $currentPage;
        $data['totalCount'] = $totalCount;
        $data['offset'] = $offset;
        return $data;
    }
}


if(!function_exists('renderPage')){
    /**
    * Renders page.
    * 
    * @param    int  $ctx    The context of the page.   
    * @param    int  $data   The data bind to the page.
    * @param    int  $page   The active page.
    */
    function renderPage($ctx,$data,$page){
        $ctx->load->view('common/header');
        $ctx->load->view('common/nav');
        $ctx->load->view($page, $data);
        $ctx->load->view('common/footer');        
    }
}