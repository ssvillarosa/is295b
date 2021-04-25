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
        <h5 class="h5 text-white">My Upcoming Events</h5>
    </div>
    <div class="table-responsive event-table">
        <table class="table table-hover" id="event_table">
            <thead>
                <tr>
                    <?php createSortableHeader('Time/Date','applicant-header text-left w-25',$orderBy, $order, 'timestamp' ,'loadEventsPage'); ?>
                    <?php createSortableHeader('Title','applicant-header text-left w-25',$orderBy, $order, 'title' ,'loadEventsPage'); ?>
                    <?php createSortableHeader('Description','applicant-header text-left w-25',$orderBy, $order, 'description' ,'loadEventsPage'); ?>
                   <?php createSortableHeader('Created By','applicant-header text-center w-25',$orderBy, $order, 'created_by_user_name' ,'loadEventsPage'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr id="event-<?php echo $event->id; ?>" class="event-row-item">
                        <td class="text-left" onclick="viewPipelineDetails(<?php echo $event->pipeline_id; ?>)">
                            <?php echo $event->event_time; ?>
                        </td>
                        <td class="text-left" onclick="viewPipelineDetails(<?php echo $event->pipeline_id; ?>)">
                            <?php echo $event->title; ?>
                        </td>
                        <td class="text-left" onclick="viewPipelineDetails(<?php echo $event->pipeline_id; ?>)">
                            <?php echo strlen($event->description) > 75 ? 
                                substr($event->description,0,75)."..." : 
                                $event->description; ?>
                        </td>
                        <td class="text-center" onclick="viewPipelineDetails(<?php echo $event->pipeline_id; ?>)">
                            <?php echo $event->created_by_user_name; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="table_footer d-flex justify-content-between align-items-center">
        <div class="row-per-page">
            <div class="usr-icon" onclick="$('#events_rows_dropdown').toggle();">
                <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                    <?php echo $rowsPerPage; ?>
                </button> Items per page
                <div id="events_rows_dropdown" class="dropdown-content dropdown-menu">
                    <button class="dropdown-item" onclick="loadEventsPage(1,5)">5</button>
                    <button class="dropdown-item" onclick="loadEventsPage(1,15)">15</button>
                    <button class="dropdown-item" onclick="loadEventsPage(1,30)">30</button>
                </div>
            </div>
        </div>
        <?php if ($totalPage > 1){$this->view('admin_dashboard/eventsPagination');} ?>
        <div class="row-statistics">
            Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
        </div>
    </div>
</div>