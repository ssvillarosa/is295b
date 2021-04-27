<!-- Nav -->
<div id="nav-header">
    <div class="container">
        <nav id="nav">
            <ul>
                <li class="<?php if($this->uri->segment(1)=="admin_dashboard") echo "active"; ?>">
                    <a href="<?php echo site_url('admin_dashboard/overview') ?>">Dashboard</a>
                </li>
                <li class="<?php if($this->uri->segment(1)=="job_order" || 
                        $this->uri->segment(1)=="activity") echo "active"; ?>">                
                    <a href="<?php echo site_url('job_order/jobOrderList') ?>">Job Orders</a>
                </li>
                <li class="<?php if($this->uri->segment(1)=="applicant" || 
                        $this->uri->segment(1)=="registration") echo "active"; ?>">
                    <a href="<?php echo site_url('applicant/applicantList') ?>">Candidates</a>
                </li>
                <li class="<?php if($this->uri->segment(1)=="company") echo "active"; ?>">
                    <a href="<?php echo site_url('company/companyList') ?>">Companies</a>
                </li>
                <li class="<?php if($this->uri->segment(1)=="skill") echo "active"; ?>">
                    <a href="<?php echo site_url('skill/skillList') ?>">Skills</a>
                </li>
                <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                    <li class="admin-only <?php if($this->uri->segment(1)=="user") echo "active"; ?>">
                        <a href="<?php echo site_url('user/userList') ?>">Users</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>