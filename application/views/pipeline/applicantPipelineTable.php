<?php if(isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
        <?php return; ?>
    </div>
<?php endif; ?>
<div class="table_toolbar d-flex">
    <?php if(isset($user_has_access) && $user_has_access) : ?>
        <button onclick="$('#add_candidate_dialog').fadeIn();" class="btn btn-primary">Add Candidate</button>
        <button onclick="showDeleteDialog()" class="btn btn-secondary ml-1">Delete</button>
    <?php endif; ?>
    <a href="<?php echo site_url('pipeline/search') ?>" class="btn btn-success ml-1">Search</a>
</div>
<div class="table-responsive pipeline-table h-100">
    <table class="table table-hover" id="pipeline_table">
        <thead>
            <tr>
                <th class="text-left"></th>
                <th class="text-left">Rating</th>
                <th class="text-left">Applicant</th>
                <th class="text-center">Status</th>
                <th class="text-center">Assigned to</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pipelines as $pipeline): ?>
                <tr id="pipeline-<?php echo $pipeline->id; ?>" class="pipeline-row-item">
                    <td class="text-left comp-chk">
                        <input type="checkbox" class="chk" value="<?php echo $pipeline->id; ?>">
                    </td>
                    <td class="text-left">
                        <?php for($ctr=0;$ctr<MAX_RATING;$ctr++) {
                            if(intval($pipeline->rating) > $ctr){
                                echo "<img class='star-rating yellow-star' src='".base_url()."images/yellow-star.svg'>";
                            }else{
                                echo "<img class='star-rating black-star' src='".base_url()."images/black-star.svg'>";
                            }
                        } ?>
                    </td>
                    <td class="text-left">
                        <?php echo $pipeline->first_name." ".$pipeline->last_name; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $pipeline->status; ?>
                    </td>
                    <td class="text-center">
                        <?php echo $pipeline->username; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="table_footer d-flex justify-content-between align-items-center">
    <div class="row-per-page">
        <div class="usr-icon" onclick="$('#pipeline_rows_dropdown').toggle();">
            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                <?php echo $rowsPerPage; ?>
            </button> Items per page
            <div id="pipeline_rows_dropdown" class="dropdown-content dropdown-menu">
                <button class="dropdown-item" onclick="loadPage(1,25)">25</button>
                <button class="dropdown-item" onclick="loadPage(1,50)">50</button>
                <button class="dropdown-item" onclick="loadPage(1,100)">100</button>
            </div>
        </div>
    </div>
    <?php if ($totalPage > 1){$this->view('pipeline/pagination');} ?>
    <div class="row-statistics">
        Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
    </div>
</div>

<?php $this->view('pipeline/addApplicant');