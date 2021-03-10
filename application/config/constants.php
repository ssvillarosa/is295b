<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/* User-defined constants */
define('COOKIE_EXPIRATION',86500);

define('ERROR_CODE',-1);
define('SUCCESS_CODE',1);

define('USER_STATUS_ACTIVE',1);
define('USER_STATUS_BLOCKED',2);
define('USER_STATUS_DELETED',3);
define('USER_STATUS_ACTIVE_TEXT','Active');
define('USER_STATUS_BLOCKED_TEXT','Blocked');
define('USER_STATUS_DELETED_TEXT','Deleted');

define('APPLICANT_STATUS_ACTIVE',1);
define('APPLICANT_STATUS_BLOCKED',2);
define('APPLICANT_STATUS_ACTIVE_TEXT','Active');
define('APPLICANT_STATUS_BLOCKED_TEXT','Blocked');

define('USER_ROLE_ADMIN',1);
define('USER_ROLE_RECRUITER',2);
define('USER_ROLE_ADMIN_TEXT','Admin');
define('USER_ROLE_RECRUITER_TEXT','Recruiter');

define('JOB_ORDER_TYPE_REGULAR',1);
define('JOB_ORDER_TYPE_CONTRACTUAL',2);
define('JOB_ORDER_TYPE_REGULAR_TEXT','Regular');
define('JOB_ORDER_TYPE_CONTRACTUAL_TEXT','Contractual');

define('JOB_ORDER_STATUS_OPEN',1);
define('JOB_ORDER_STATUS_ON_HOLD',2);
define('JOB_ORDER_STATUS_CLOSED',3);
define('JOB_ORDER_STATUS_OPEN_TEXT','Open');
define('JOB_ORDER_STATUS_ON_HOLD_TEXT','On hold');
define('JOB_ORDER_STATUS_CLOSED_TEXT','Closed');

define('APPLICANT_CAN_RELOCATE_TRUE','1');
define('APPLICANT_CAN_RELOCATE_TRUE_TEXT','Yes');
define('APPLICANT_CAN_RELOCATE_FALSE','0');
define('APPLICANT_CAN_RELOCATE_FALSE_TEXT','No');

define('APPLICANT_CIVIL_STATUS_SINGLE',1);
define('APPLICANT_CIVIL_STATUS_SINGLE_TEXT','Single');
define('APPLICANT_CIVIL_STATUS_MARRIED',2);
define('APPLICANT_CIVIL_STATUS_MARRIED_TEXT','Married');
define('APPLICANT_CIVIL_STATUS_WIDOWED',3);
define('APPLICANT_CIVIL_STATUS_WIDOWED_TEXT','Widowed');

define('REGISTRATION_STATUS_PENDING',1);
define('REGISTRATION_STATUS_PENDING_TEXT','Pending');
define('REGISTRATION_STATUS_APPROVED',2);
define('REGISTRATION_STATUS_APPROVED_TEXT','Approved');

define('MAX_LOGIN_ATTEMPT',5);

define('IS_DELETED_TRUE','1');
define('IS_DELETED_FALSE','0');

define('SESS_USER_ID','user_id');
define('SESS_USERNAME','username');
define('SESS_USER_ROLE','user_role');
define('SESS_USER_EMAIL','user_email');
define('SESS_USER_FULL_NAME','user_full_name');
define('SESS_IS_LOGGED_IN','is_logged_in');

define('SESS_APPLICANT_ID','applicant_id');
define('SESS_APPLICANT_EMAIL','applicant_email');
define('SESS_APPLICANT_LAST_NAME','applicant_last_name');
define('SESS_APPLICANT_FIRST_NAME','applicant_first_name');
define('SESS_IS_APPLICANT_LOGGED_IN','is_applicant_logged_in');

define('COOKIE_USER_ROWS_PER_PAGE','user_rows_per_page');
define('COOKIE_USER_SEARCH_ROWS_PER_PAGE','user_search_rows_per_page');
define('COOKIE_ACTIVITY_ROWS_PER_PAGE','activity_rows_per_page');
define('COOKIE_COMPANY_ROWS_PER_PAGE','company_rows_per_page');
define('COOKIE_COMPANY_SEARCH_ROWS_PER_PAGE','company_search_rows_per_page');
define('COOKIE_JOB_ORDER_ROWS_PER_PAGE','job_order_rows_per_page');
define('COOKIE_JOB_ORDER_SEARCH_ROWS_PER_PAGE','job_order_search_rows_per_page');
define('COOKIE_JOB_ORDER_AJAX_ROWS_PER_PAGE','job_order_ajax_rows_per_page');
define('COOKIE_APPLICANT_ROWS_PER_PAGE','applicant_rows_per_page');
define('COOKIE_APPLICANT_SEARCH_ROWS_PER_PAGE','applicant_search_rows_per_page');
define('COOKIE_REGISTRATION_ROWS_PER_PAGE','registration_rows_per_page');
define('COOKIE_REGISTRATION_SEARCH_ROWS_PER_PAGE','registration_search_rows_per_page');

define('CONDITION_EQUALS','E');
define('CONDITION_NOT_EQUAL','NE');
define('CONDITION_STARTS_WITH','SW');
define('CONDITION_ENDS_WITH','EW');
define('CONDITION_CONTAINS','C');
define('CONDITION_LESS_THAN','B');
define('CONDITION_GREATER_THAN','A');
define('CONDITION_RANGE','R');