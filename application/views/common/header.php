<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
	<link href='<?php echo base_url(); ?>css/bootstrap/bootstrap.min.css' rel='stylesheet' type='text/css'>
	<link href='<?php echo base_url(); ?>css/style.css' rel='stylesheet' type='text/css'>
        <script src="<?php echo base_url(); ?>js/jquery-3.5.1.min.js"></script>
        <script src="<?php echo base_url(); ?>js/site.js"></script>
</head>
<body>
		<div id="wrapper">			
			<!-- Header -->
			<div id="header">
				<div class="container d-flex justify-content-between bd-highlight mb-3"> 
					
					<!-- Logo -->
					<div id="logo">
						<h1><a href="#">M2MJ</a></h1>
						<span>Human Resources Consulting</span>
					</div>
                        
                                        <div class="usr-icon" onclick="$('#user_profile_dropdown').toggle();">
                                            <a class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                                <?php echo $this->session->userdata(SESS_USERNAME); ?>
                                            </a>
                                            <div id="user_profile_dropdown" class="dropdown-content dropdown-menu">
                                                <a class="dropdown-item" href="<?php echo site_url('user/profile') ?>">Profile</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo site_url('user/changePassword') ?>">Change Password</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo site_url('user/log') ?>">Activity Log</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php echo site_url('auth/logout') ?>">Logout</a>
                                            </div>
                                        </div>
				</div>
			</div>
			<!-- /Header -->