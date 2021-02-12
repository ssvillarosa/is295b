<script>    
    // Redirect to details view.
    function viewCompany(id){
        window.location.href = '<?php echo site_url('company/view') ?>?id='+id;
    }
</script>
<div id="company-page" class="company-page">
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
                        <a href="<?php echo site_url('company/add') ?>" class="btn btn-primary">New</a>
                        <button onclick="showDeleteDialog()" class="btn btn-secondary">Delete</button>
                    <?php endif; ?>
                    <a href="<?php echo site_url('company/search') ?>" class="btn btn-success">Search</a>
                </div>
                <div class="table-responsive company-table">
                    <table class="table table-hover" id="company_table">
                        <thead>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-left">Company Name</th>
                                <th class="text-center">Active Jobs</th>
                                <th class="text-center">Completed Jobs</th>
                                <th class="text-center">Total Jobs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($companies as $company): ?>
                                <tr id="company-<?php echo $company->id; ?>" class="company-row-item">
                                    <td class="text-left comp-chk">
                                        <input type="checkbox" class="chk" value="<?php echo $company->id; ?>">
                                    </td>
                                    <td class="text-left comp-name" onClick="viewCompany(<?php echo $company->id; ?>)">
                                        <?php echo $company->name; ?>
                                    </td>
                                    <td class="text-center" onClick="viewCompany(<?php echo $company->id; ?>)">
                                        <?php echo 0; ?>
                                    </td>
                                    <td class="text-center" onClick="viewCompany(<?php echo $company->id; ?>)">
                                        <?php echo 0; ?>
                                    </td>
                                    <td class="text-center" onClick="viewCompany(<?php echo $company->id; ?>)">
                                        <?php echo 0; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table_footer d-flex justify-content-between align-items-center">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#company_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="company_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('company/companyList?rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('company/companyList?rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('company/companyList?rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($totalPage > 1){
                            $this->view('company/pagination');
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
<?php $this->view('company/delete'); ?>