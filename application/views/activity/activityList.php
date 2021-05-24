<script>
    $(document).ready(function() {
        $('#add_activity_page').hide();
    });
</script>
<?php $this->view('pipeline/detailsView'); ?>
<div id="activity-page" class="activity-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <?php if(isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                        <?php return; ?>
                    </div>
                <?php endif; ?>
                <?php if($this->session->userdata(SESS_USER_ROLE)== USER_ROLE_ADMIN ||
                        $this->session->userdata(SESS_USER_ID) == $pipeline->assigned_to): ?>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger mb-3" onclick="$('#delete_dialog').fadeIn();">Delete this pipeline</button>
                    </div>
                <?php endif; ?>
                <div class="table_toolbar">
                    <?php if($this->session->userdata(SESS_USER_ROLE)== USER_ROLE_ADMIN ||
                            $this->session->userdata(SESS_USER_ID) == $pipeline->assigned_to): ?>
                        <button class="btn btn-primary" onclick="$('#add_activity_page').slideDown();">Log Activity</button>
                    <?php endif; ?>
                </div>
                <?php $this->view('activity/addActivity'); ?>
                <div class="table-responsive activity-table">
                    <table class="table table-hover" id="activity_table">
                        <thead>
                            <tr>
                                <th class="text-center timestamp">Timestamp</th>
                                <th class="text-center logged-by">Logged By</th>
                                <th class="text-center activity-type">Activity Type</th>
                                <th class="text-left activity">Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activities as $activity): ?>
                                <tr id="activity-<?php echo $activity->id; ?>" class="activity-row-item">
                                    <td class="text-center">
                                        <?php echo date_format(date_create($activity->timestamp),"M j, Y g:i:s a"); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo $activity->name; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo getActivityTypeDictionary($activity->activity_type); ?>
                                    </td>
                                    <td class="text-left">
                                        <?php echo nl2br($activity->activity); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="table_footer d-flex justify-content-between align-items-center">
                    <div class="row-per-page">
                        <div class="usr-icon" onclick="$('#activity_rows_dropdown').toggle();">
                            <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                                <?php echo $rowsPerPage; ?>
                            </button> Items per page
                            <div id="activity_rows_dropdown" class="dropdown-content dropdown-menu">
                                <a class="dropdown-item" href="<?php echo site_url('activity/activityListByPipeline?pipelineId='.$pipeline->id.'&rowsPerPage=25') ?>">25</a>
                                <a class="dropdown-item" href="<?php echo site_url('activity/activityListByPipeline?pipelineId='.$pipeline->id.'&rowsPerPage=50') ?>">50</a>
                                <a class="dropdown-item" href="<?php echo site_url('activity/activityListByPipeline?pipelineId='.$pipeline->id.'&rowsPerPage=100') ?>">100</a>
                            </div>
                        </div>
                    </div>
                    <?php 
                        if ($totalPage > 1){
                            $this->view('activity/pagination');
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
<?php $this->view('pipeline/delete'); ?>