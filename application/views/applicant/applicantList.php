<script>    
    // Redirect to details view.
    function viewApplicant(id){
        window.location.href = '<?php echo site_url('applicant/view') ?>?id='+id;
    }
</script>
<div id="applicant-page" class="applicant-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <div class="table_toolbar">
                    <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                        <a href="<?php echo site_url('applicant/add') ?>" class="btn btn-primary">New</a>
                        <button onclick="showDeleteDialog()" class="btn btn-secondary">Delete</button>
                    <?php endif; ?>
                    <a href="<?php echo site_url('applicant/search') ?>" class="btn btn-success">Search</a>
                </div>
                <div class="table-responsive applicant-table">
                    <table class="table table-hover" id="applicant_table">
                        <thead>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-left">Last Name</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Active Applications</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($applicants as $applicant): ?>
                                <tr id="applicant-<?php echo $applicant->id; ?>" class="applicant-row-item">
                                    <td class="text-left">
                                        <input type="checkbox" class="chk" value="<?php echo $applicant->id; ?>">
                                    </td>
                                    <td class="text-left" onClick="viewApplicant(<?php echo $applicant->id; ?>)">
                                        <?php echo $applicant->last_name; ?>
                                    </td>
                                    <td class="text-center" onClick="viewApplicant(<?php echo $applicant->id; ?>)">
                                        <?php echo $applicant->first_name; ?>
                                    </td>
                                    <td class="text-center" onClick="viewApplicant(<?php echo $applicant->id; ?>)">
                                        <?php echo $applicant->email; ?>
                                    </td>
                                    <td class="text-center" onClick="viewApplicant(<?php echo $applicant->id; ?>)">
                                        0
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table_footer d-flex justify-content-between align-items-center">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#applicant_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="applicant_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('applicant/applicantList?rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('applicant/applicantList?rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('applicant/applicantList?rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($totalPage > 1){
                            $this->view('applicant/pagination');
                        } 
                    ?>
                    <div class="row-statistics">
                        Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>

<?php $this->view('applicant/listPageDelete'); ?>