<script>    
    // Redirect to details view.
    function viewPipelineDetails(id){
        window.location.href = '<?php echo site_url('activity/activityListByPipeline') ?>?pipelineId='+id;
    }
</script>

<div class="col-md-9">
    <?php if(isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
            <?php return; ?>
        </div>
    <?php endif; ?>
    <div class="table_toolbar d-flex">
        <h5 class="h5 text-white">Applications Assigned To Me</h5>
    </div>
    <div class="table-responsive user_pipeline-table">
        <table class="table table-hover" id="user_pipeline_table">
            <thead>
                <tr>
                    <?php createSortableHeader('Applicant','applicant-header text-left',$orderBy, $order, 'first_name' ,'loadAssignedToMePage'); ?>
                    <?php createSortableHeader('Job Order','applicant-header text-left',$orderBy, $order, 'title' ,'loadAssignedToMePage'); ?>
                    <?php createSortableHeader('Status','applicant-header text-center',$orderBy, $order, 'status' ,'loadAssignedToMePage'); ?>
                   <?php createSortableHeader('Rating','applicant-header text-center',$orderBy, $order, 'rating' ,'loadAssignedToMePage'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_pipelines as $user_pipeline): ?>
                    <tr id="user_pipeline-<?php echo $user_pipeline->id; ?>" class="user_pipeline-row-item">
                        <td class="text-left" onclick="viewPipelineDetails(<?php echo $user_pipeline->id; ?>)">
                            <a href="<?php echo site_url('applicant/view').'?id='.$user_pipeline->applicant_id; ?>">
                                <?php echo $user_pipeline->first_name." ".$user_pipeline->last_name; ?>
                            </a>
                        </td>
                        <td class="text-left" onclick="viewPipelineDetails(<?php echo $user_pipeline->id; ?>)">
                            <a href="<?php echo site_url('job_order/view').'?id='.$user_pipeline->job_order_id; ?>">
                                <?php echo $user_pipeline->title; ?>
                            </a>
                        </td>
                        <td class="text-center" onclick="viewPipelineDetails(<?php echo $user_pipeline->id; ?>)">
                            <?php echo $user_pipeline->status; ?>
                        </td>
                        <td class="text-center" onclick="viewPipelineDetails(<?php echo $user_pipeline->id; ?>)">
                            <?php for($ctr=0;$ctr<MAX_RATING;$ctr++) {
                                if(intval($user_pipeline->rating) > $ctr){
                                    echo "<img class='star-rating yellow-star' src='".base_url()."images/yellow-star.svg'>";
                                }else{
                                    echo "<img class='star-rating black-star' src='".base_url()."images/black-star.svg'>";
                                }
                            } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="table_footer d-flex justify-content-between align-items-center">
        <div class="row-per-page">
            <div class="usr-icon" onclick="$('#user_pipeline_rows_dropdown').toggle();">
                <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                    <?php echo $rowsPerPage; ?>
                </button> Items per page
                <div id="user_pipeline_rows_dropdown" class="dropdown-content dropdown-menu">
                    <button class="dropdown-item" onclick="loadAssignedToMePage(1,5)">5</button>
                    <button class="dropdown-item" onclick="loadAssignedToMePage(1,15)">15</button>
                    <button class="dropdown-item" onclick="loadAssignedToMePage(1,30)">30</button>
                </div>
            </div>
        </div>
        <?php if ($totalPage > 1){$this->view('admin_dashboard/assignedToMePagination');} ?>
        <div class="row-statistics">
            Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
        </div>
    </div>
</div>