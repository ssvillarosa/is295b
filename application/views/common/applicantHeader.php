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
            <a href="<?php echo base_url(); ?>">
                <div id="logo"></div>
            </a>

            <?php if($this->session->has_userdata(SESS_IS_APPLICANT_LOGGED_IN)) : ?>
                <div class="usr-icon" onclick="$('#user_profile_dropdown').toggle();">
                    <a class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                        <?php echo $this->session->userdata(SESS_APPLICANT_FIRST_NAME); ?>
                    </a>
                    <div id="user_profile_dropdown" class="dropdown-content dropdown-menu">
                        <a class="dropdown-item" href="<?php echo site_url('applicant/profile') ?>">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('applicant/changePassword') ?>">Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url('applicantAuth/logout') ?>">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="usr-icon">
                    <a class="btn btn-primary" href="<?php echo site_url('applicantAuth/login'); ?>">Login</a>
                    <a class="btn btn-success" href="<?php echo site_url('registration/register'); ?>">Register</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- /Header -->