<!-- Nav -->
<div id="nav-header">
    <div class="container">
        <nav id="nav">
            <ul>
                <li class="<?php if($this->uri->segment(1)=="dashboard") echo "active"; ?>">
                    <a href="<?php echo site_url('dashboard/applicantOverview') ?>">Dashboard</a>
                </li>
            </ul>
        </nav>
    </div>
</div>