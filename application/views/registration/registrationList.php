<script>    
    // Redirect to details view.
    function viewRegistration(id){
        window.location.href = '<?php echo site_url('registration/view') ?>?id='+id;
    }
</script>
<div id="registration-page" class="registration-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h5>Pending Registration Entries</h5>
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <div class="table_toolbar d-flex">
                    <?php if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN): ?>
                        <button onclick="showApproveDialog()" class="btn btn-primary">Approve</button>
                        <button onclick="showDeleteDialog()" class="btn btn-secondary ml-1">Delete</button>
                    <?php endif; ?>
                    <a href="<?php echo site_url('registration/search') ?>" class="btn btn-success ml-1">Search</a>
                    <a href="<?php echo site_url('applicant/applicantList') ?>" class="btn btn-info ml-auto">Back</a>
                </div>
                <div class="table-responsive registration-table">
                    <table class="table table-hover" id="registration_table">
                        <thead>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-left">Last Name</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrations as $registration): ?>
                                <tr id="registration-<?php echo $registration->id; ?>" class="registration-row-item">
                                    <td class="text-left">
                                        <input type="checkbox" class="chk" value="<?php echo $registration->id; ?>">
                                    </td>
                                    <td class="text-left" onClick="viewRegistration(<?php echo $registration->id; ?>)">
                                        <?php echo $registration->last_name; ?>
                                    </td>
                                    <td class="text-center" onClick="viewRegistration(<?php echo $registration->id; ?>)">
                                        <?php echo $registration->first_name; ?>
                                    </td>
                                    <td class="text-center" onClick="viewRegistration(<?php echo $registration->id; ?>)">
                                        <?php echo $registration->email; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table_footer d-flex justify-content-between align-items-center">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#registration_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="registration_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('registration/registrationList?rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('registration/registrationList?rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('registration/registrationList?rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($totalPage > 1){
                            $this->view('registration/pagination');
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

<?php $this->view('registration/listPageDelete'); ?>
<?php $this->view('registration/listPageUpdateStatus'); ?>