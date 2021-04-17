<!-- Nav -->
<div id="nav-header">
    <div class="container">
        <nav id="nav">
            <ul>
                <li class="<?php if($this->uri->segment(2)=="jobs" ||
                        $this->uri->segment(2)=="searchJobResult" ||
                        $this->uri->segment(2)=="viewJob" ) echo "active"; ?>">
                    <a href="<?php echo site_url('applicant_dashboard/jobs') ?>">Jobs</a>
                </li>
                <li class="<?php if($this->uri->segment(2)=="myApplications") echo "active"; ?>">
                    <a href="<?php echo site_url('applicant_dashboard/myApplications') ?>">My Applications</a>
                </li>
            </ul>
        </nav>
    </div>
</div>