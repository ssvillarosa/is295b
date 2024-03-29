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

if(!function_exists('checkApplicantLogin')){
    /**
    * Checks if checkApplicantLogin if logged in. If not, add url to query param and redirect 
    * the user to login page..
    */
    function checkApplicantLogin(){
        $ci = &get_instance();
        if(!$ci->session->has_userdata(SESS_IS_APPLICANT_LOGGED_IN)){
            $referrer_value = getFullUrl();
            redirect('applicantAuth/login?referrer='.$referrer_value);
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

if(!function_exists('getActivityTypeDictionary')){
    /**
    * Returns the equivalent text of an activity type.
     * 
    * @param    int     $activityType   Activity type integer.
    * @return   string
    */
    function getActivityTypeDictionary($activityType){
        switch($activityType){
            case ACTIVITY_TYPE_CHANGE_ASSIGNMENT: return ACTIVITY_TYPE_CHANGE_ASSIGNMENT_TEXT;
            case ACTIVITY_TYPE_STATUS_UPDATE: return ACTIVITY_TYPE_STATUS_UPDATE_TEXT;
            case ACTIVITY_TYPE_NOTE: return ACTIVITY_TYPE_NOTE_TEXT;
            case ACTIVITY_TYPE_EMAIL: return ACTIVITY_TYPE_EMAIL_TEXT;
            case ACTIVITY_TYPE_SCHEDULE_EVENTS: return ACTIVITY_TYPE_SCHEDULE_EVENTS_TEXT;
            case ACTIVITY_TYPE_RATING_UPDATE: return ACTIVITY_TYPE_RATING_UPDATE_TEXT;
            case ACTIVITY_TYPE_FILE_UPLOAD: return ACTIVITY_TYPE_FILE_UPLOAD_TEXT;
            case ACTIVITY_TYPE_ADDED_TO_PIPELINE: return ACTIVITY_TYPE_ADDED_TO_PIPELINE_TEXT;
            case ACTIVITY_CANDIDATE_SUBMIT_APPLICATION: return ACTIVITY_CANDIDATE_SUBMIT_APPLICATION_TEXT;
        }
    }
}

if(!function_exists('getPipelineStatusDictionary')){
    /**
    * Returns the equivalent text of a pipeline status.
     * 
    * @param    int                         $status     Status integer.
    * @param    array of pipelinestatus     $statuses   Statuses.
    * @return   string
    */
    function getPipelineStatusDictionary($status,$statuses){
        foreach($statuses as $pipeline_status){
            if($pipeline_status->id === $status){
                return $pipeline_status->status;
            }
        }
        return "UNKNOWN";
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
                            <option value='".CONDITION_NOT_EQUAL."'>".getConditionDictionary(CONDITION_NOT_EQUAL)."</option>
                            <option value='".CONDITION_LESS_THAN."'>".getConditionDictionary(CONDITION_LESS_THAN)."</option>
                            <option value='".CONDITION_GREATER_THAN."'>".getConditionDictionary(CONDITION_GREATER_THAN)."</option>
                            <option value='".CONDITION_RANGE."'>".getConditionDictionary(CONDITION_RANGE)."</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <input type='date' class='form-control' id='value_$id' name='value_$id' maxLength='50'>
                    </div>
                    <input type='checkbox' class='chk mt-2 col-sm-1' name='display_".$id."' checked>
                </div>";
    }
}

if(!function_exists('createNumberCondition')){
    /**
    * Creates a filter for number fields.
    * 
    * @param    string     $label   Label of the filter. Out of it, the ID will be generated.
    */
    function createNumberCondition($label){
        if(!trim($label)){
            return;
        }
        $id = strtolower(str_replace(' ', '_', trim($label)));
        echo "  <div class='form-group row  d-flex justify-content-around' id='number_field_$id'>
                    <label for='role' class='col-form-label col-sm-3 text-center' id='label_$id'>".ucwords($label)."</label>
                    <div class='col-sm-3'>
                        <select name='condition_$id' id='condition_$id' class='custom-select number-field-select'>
                            <option value=''>Select Condition</option>
                            <option value='".CONDITION_EQUALS."'>".getConditionDictionary(CONDITION_EQUALS)."</option>
                            <option value='".CONDITION_NOT_EQUAL."'>".getConditionDictionary(CONDITION_NOT_EQUAL)."</option>
                            <option value='".CONDITION_LESS_THAN."'>".getConditionDictionary(CONDITION_LESS_THAN)."</option>
                            <option value='".CONDITION_GREATER_THAN."'>".getConditionDictionary(CONDITION_GREATER_THAN)."</option>
                            <option value='".CONDITION_RANGE."'>".getConditionDictionary(CONDITION_RANGE)."</option>
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <input type='number' class='form-control' id='value_$id' name='value_$id' maxLength='50'>
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
            case CONDITION_LESS_THAN:
                return "Less than";
            case CONDITION_GREATER_THAN:
                return "Greater than";
            case CONDITION_RANGE:
                return "Range";
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
            if(strval($param->condition) == CONDITION_RANGE){
                $textFilter = "$field $condition ".
                        $param->value." TO ".$param->value_2;
                array_push($textFilters, $textFilter);
                continue;
            }
            $textFilter = "$field $condition ".$param->value;
            array_push($textFilters, $textFilter);   
        }
        return html_escape($textFilters);
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
        return html_escape($rowsPerPage);
    }
}

if(!function_exists('getJobOrderListFilter')){
    /**
    * Returns the value of job order list filter.
    * 
    * @return   int value
    */
    function getJobOrderListFilter($ctx,$module){        
        // Default filter is false
        $assignedToMe = $ctx->input->cookie($module)?
                $ctx->input->cookie($module) : "false";
        // If user changes filter, store it into cookie
        if($ctx->input->get('assignedToMe')){
            set_cookie($module, $ctx->input->get('assignedToMe'),
                    COOKIE_EXPIRATION);
            $assignedToMe = $ctx->input->get('assignedToMe');
        }
        return $assignedToMe === "true" ? true: false;
    }
}

if(!function_exists('getOrderBy')){
    /**
    * Returns the value of order by.
    * 
    * @return   int value
    */
    function getOrderBy($ctx,$module){        
        // Default order by(25) is set if orderBy is not changed.
        $getOrderBy = $ctx->input->cookie($module)?
                $ctx->input->cookie($module) : 'id';
        // If user changes the number of orderBy, store it into cookie
        if($ctx->input->get('orderBy')){
            set_cookie($module, $ctx->input->get('orderBy'),
                    COOKIE_EXPIRATION);
            $getOrderBy = $ctx->input->get('orderBy');
        }
        return $getOrderBy;
    }
}

if(!function_exists('getOrder')){
    /**
    * Returns the value of order.
    * 
    * @return   int value
    */
    function getOrder($ctx,$module){        
        // Default order by(25) is set if order is not changed.
        $getOrder = $ctx->input->cookie($module)?
                $ctx->input->cookie($module) : 'asc';
        // If user changes the number of order, store it into cookie
        if($ctx->input->get('order')){
            set_cookie($module, $ctx->input->get('order'),
                    COOKIE_EXPIRATION);
            $getOrder = $ctx->input->get('order');
        }
        return $getOrder;
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
    function setPaginationData($totalCount,$rowsPerPage,$currentPage,$orderBy='id',$order='asc'){        
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
        if($orderBy){
            $data['orderBy'] = $orderBy;
        }
        if($order){
            $data['order'] = $order;
        }
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

if(!function_exists('renderApplicantPage')){
    /**
    * Renders applicant page.
    * 
    * @param    int  $ctx    The context of the page.   
    * @param    int  $data   The data bind to the page.
    * @param    int  $page   The active page.
    */
    function renderApplicantPage($ctx,$data,$page){
        $ctx->load->view('common/applicantHeader');
        $ctx->load->view('common/applicantNav');
        $ctx->load->view($page, $data);
        $ctx->load->view('common/footer');        
    }
}

if(!function_exists('getSearchParam')){
    /**
    * Creates searchParameter object out of get input.
    * 
    * @param    string  $ctx    The context page of the caller.
    * @param    string  $field  The field to create the search param.
    * @return   object(field,condition,value[,value_2])
    */
    function getSearchParam($ctx,$field){
        if($ctx->input->get("condition_$field") && 
                $ctx->input->get("value_$field") !== null){
            $condition = strval($ctx->input->get("condition_$field"));
            $value = strval($ctx->input->get("value_$field"));
            $value2 = strval($ctx->input->get("value_{$field}_2"));
            $show = $ctx->input->get("display_$field")? true: false;
            // For date fields with F condition.
            if($condition == CONDITION_RANGE){
                return (object) [
                    'field' => $field,
                    'condition' => $condition,
                    'value' => $value,
                    'value_2' => $value2 ? $value2 : date('Y-m-d'),
                    'show' => $show,
                  ];                
            }
            return (object) [
                'field' => $field,
                'condition' => $condition,
                'value' => $value,
                'show' => $show,
              ];
        }
        if($ctx->input->get("display_$field")){
            $show = $ctx->input->get("display_$field")? true: false;
            return (object) [
                'field' => $field,
                'show' => $show,
              ];
        }
    }
}

if(!function_exists('setWhereParams')){
    /**
    * Sets where condition for search.
    *
    * @param    search param object     $searchParams
    */
    function setWhereParams($ctx,$searchParams){
        foreach ($searchParams as $param){
            if(!isset($param->value) || empty($param->condition)){
                continue;
            }
            switch (strval($param->condition)){
                case CONDITION_EQUALS:
                    $ctx->db->where($param->field, $param->value);
                    break;
                case CONDITION_NOT_EQUAL:
                    $ctx->db->where($param->field." !=", $param->value);
                    break;
                case CONDITION_STARTS_WITH:
                    $ctx->db->like($param->field, $param->value, 'after');
                    break;
                case CONDITION_ENDS_WITH:
                    $ctx->db->like($param->field, $param->value, 'before');
                    break;
                case CONDITION_CONTAINS:
                    $ctx->db->like($param->field, $param->value);
                    break;
                case CONDITION_LESS_THAN:
                    $ctx->db->where($param->field." <", $param->value);
                    break;
                case CONDITION_GREATER_THAN:
                    $ctx->db->where($param->field." >", $param->value);
                    break;
                case CONDITION_RANGE:
                    $ctx->db->where($param->field." >=", $param->value);
                    $ctx->db->where($param->field." <=", $param->value_2);
                    break;
            }
        }
    }
}

if(!function_exists('exportCSV')){
    /**
    * Export search result to CSV file.
    */
   function exportCSV($filename,$data,$header,$exclude=["id"]){ 
        // file name 
        $filename = $filename.'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // file creation 
        $file = fopen('php://output', 'w');

        fputcsv($file, $header);
        foreach ($data as $key=>$line){
            foreach ($exclude as $col){
                unset($line[$col]);
            }
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
    }
}

if(!function_exists('createPill')){
    /**
    * Creates a pill button.
     *
     * @param {string}  id              The ID of the button
     * @param {string}  buttonText      The text of the button
     * @param {string}  pillText        The text of the pill
     * @param {boolean} removable       Indicates whether the button is removable or not
     */
    function createPill($id,$buttonText,$pillText,$removable){
        $cls = $removable ? "pill-button-removable" : "pill-button";
        $pillBtn = "<button type='button' id='".$id."' class='btn btn-primary badge-pill btn-sm ".$cls." mr-1'>";
            $pillBtn .= "<span class='pill-button-text mr-1'>".$buttonText."</span>";
            $pillBtn .= $removable ? "<span class='remove-pill d-none'>Remove</span>" : "";
            $pillBtn .= $pillText ? "<span id='skill-".$buttonText."' class='badge badge-light badge-pill pill-text'>".$pillText."</span>" : "";
            $pillBtn .= "</button>";
        return $pillBtn;
    }
}

if(!function_exists('createSortableHeader')){
    /**
    * Creates a sortable header to a table.
     *
     * @param {string}  headerText  The text of the header.
     * @param {string}  class       The class applied to the header.
     * @param {string}  orderBy     Order by value.
     * @param {string} order        Order value.
     * @param {string} field        Field correspondin to this header.
     */
    function createSortableHeader($headerText, $class, $orderBy, $order, $field, $functionCall){
        $onclick = '';
        if($orderBy == $field){
            if($order === ORDER_ASC){
                $arrow = '<div class="arrow-up"></div>';
                $onclick = ' onclick="'.$functionCall.'(1,0,\''.$field.'\',\''.ORDER_DESC.'\')"';
            }else{
                $arrow = '<div class="arrow-down"></div>';
                $onclick = ' onclick="'.$functionCall.'(1,0,\'id\',\''.ORDER_ASC.'\')"';
            }
        }else{
            $arrow = '<div class="arrow-up-down"></div>';
            $onclick = ' onclick="'.$functionCall.'(1,0,\''.$field.'\',\''.ORDER_ASC.'\')"';
        }
        $openTag = '<th class="'.$class.'" '.$onclick.'>';
        $closeTag = '</th>';
        echo $openTag.$headerText.$arrow.$closeTag;
    }
}