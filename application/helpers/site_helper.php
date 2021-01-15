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

