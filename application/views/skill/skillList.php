<script>
    // Redirect to details view.
    function viewJobOrder(id){
        window.location.href = '<?php echo site_url('skill/view') ?>?id='+id;
    }
</script>
<div id="skill-page" class="skill-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <div class="table_toolbar">
                    <button onclick="showAddDialog()" class="btn btn-primary">New</button>
                    <button onclick="showDeleteDialog()" class="btn btn-secondary">Delete</button>
                    <button onclick="showAddCategoryDialog()" class="btn btn-success float-right">Add Category</button>
                </div>
                <div class="table-responsive skill-table">
                    <table class="table table-hover" id="skill_table">
                        <thead>
                            <tr>
                                <th class="text-left"></th>
                                <th class="text-left">Name</th>
                                <th class="text-left">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($skills as $skill): ?>
                                <tr id="skill-<?php echo $skill->id; ?>" class="skill-row-item">
                                    <td class="text-left comp-chk">
                                        <input type="checkbox" class="chk" value="<?php echo $skill->id; ?>">
                                        <input type="hidden" class="sk_name" value="<?php echo $skill->name; ?>">
                                    </td>
                                    <td class="text-left" onClick="showUpdateDialog(<?php echo $skill->id; ?>,'<?php echo $skill->name; ?>',<?php echo $skill->category_id; ?>)">
                                        <?php echo $skill->name; ?>
                                    </td>
                                    <td class="text-left" onClick="showUpdateDialog(<?php echo $skill->id; ?>,'<?php echo $skill->name; ?>',<?php echo $skill->category_id; ?>)">
                                        <?php echo $skill->category_name; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="table_footer d-flex justify-content-between align-items-center">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#skill_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="skill_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('skill/skillList?rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('skill/skillList?rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('skill/skillList?rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($totalPage > 1){
                            $this->view('skill/pagination');
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

<?php $this->view('skill/listPageDelete'); ?>
<?php $this->view('skill/add'); ?>
<?php $this->view('skill/update'); ?>
<?php $this->view('skill/addCategory'); ?>
