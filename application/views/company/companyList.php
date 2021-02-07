<script>
    $(document).ready(function() {
        
        // Create a post request to delete user/s.
        $("#deleteForm").submit(function(e){
            e.preventDefault();
            $.post('<?php echo site_url('company/delete') ?>', 
            $(this).serialize(),
            function(data) {
                hideDialog();
                if(data.trim() === "Success"){
                    showToast("Deleted Successfully.",3000);
                    location.reload();
                    return;
                }
                showToast("Error occurred.",3000);
            }).fail(function() {
                showToast("Error occurred.",3000);
            });
        });
    });
    
    // Redirect to details view.
    function viewCompany(id){
        window.location.href = '<?php echo site_url('company/view') ?>?id='+id;
    }
    
    // Displays the dialog to confirm deletion.
    function showDeleteDialog(){
        var companies = []
        $('#company_table > tbody  > tr > td > .chk').each(function() {
            if($(this).is(":checked")){
                companies.push($(this).val());
            }
        });
        if(!companies.length){
            showToast("Please select items to delete.",3000);
            return;
        }
        $("#delete_dialog").fadeIn();
        $("#delCompanyIds").val(companies.join(','));
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
                    <?php if ($totalPage > 1): ?>
                        <div class="pagination">
                            <nav>
                                <ul class="pagination justify-content-center mb-0 font-weight-bold">
                                    <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo site_url('company/companyList?currentPage=1'); ?>">&#60;&#60;</a>
                                    </li>
                                    <li class="page-item <?php echo strval($currentPage) === "1" ? 'disabled' : ''; ?>">
                                        <a class="page-link" 
                                           href="<?php echo site_url('company/companyList?currentPage=').($currentPage > 1 ? $currentPage - 1 : 1); ?>"
                                           >&#60;</a>
                                    </li>
                                    <?php for($page=$currentPage-1;$page<$currentPage+2;$page++): ?>
                                        <?php if ($page < 1 || $page > $totalPage){ continue; } ?>
                                        <?php if (strval($currentPage) === strval($page)): ?>                                            
                                            <li class="page-item active">
                                                <a class="page-link" href="#">
                                                    <?php echo $page; ?>
                                                </a>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo site_url("company/companyList?currentPage=$page") ?>">
                                                    <?php echo $page; ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endfor;?>
                                    <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo site_url('company/companyList?currentPage=').($currentPage < $totalPage ? $currentPage + 1 : $totalPage); ?>">&#62;</a>
                                    </li>                            
                                    <li class="page-item <?php echo strval($currentPage) === strval($totalPage) ? 'disabled' : ''; ?>">
                                        <a class="page-link" 
                                           href="<?php echo site_url("company/companyList?currentPage=$totalPage") ?>">&#62;&#62;</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    <?php endif; ?>
                    <div class="row-statistics">
                        Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>

<div class="m2mj-dialog" id="delete_dialog">
    <div class="dialog-background"></div>
    <div class="m2mj-modal-content">
        <?php echo form_open('company/delete','id="deleteForm"'); ?>        
            <input type="hidden" name="delCompanyIds" id="delCompanyIds"/>
            <div class="modal-body">
                <strong class="modal-text">Are you sure you want to delete?</strong>
            </div>
            <div class="modal-footer p-2">
              <button type="button" class="btn btn-secondary m2mj-dialog-close">Close</button>
              <button type="submit" class="btn btn-danger" id="delete_confirm">Delete</button>
            </div>
        </form>
    </div>
</div>