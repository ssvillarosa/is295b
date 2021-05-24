<div class="col-md-9">
    <?php if(isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
            <?php return; ?>
        </div>
    <?php endif; ?>
    <div class="table_toolbar d-flex justify-content-between">
        <h5 class="h5 text-white">Public Upcoming Events</h5>
        <div class="arrow-up mt-2 mr-2"></div>
    </div>
    <div class="table-responsive event-table">
        <table class="table table-hover" id="event_table">
            <thead>
                <tr>
                    <?php createSortableHeader('Time/Date','applicant-header text-left w-25',$orderBy, $order, 'timestamp' ,'loadPublicEventsPage'); ?>
                    <?php createSortableHeader('Title','applicant-header text-left w-25',$orderBy, $order, 'title' ,'loadPublicEventsPage'); ?>
                    <?php createSortableHeader('Description','applicant-header text-left w-25',$orderBy, $order, 'description' ,'loadPublicEventsPage'); ?>
                   <?php createSortableHeader('Created By','applicant-header text-center w-25',$orderBy, $order, 'created_by_user_name' ,'loadPublicEventsPage'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr id="event-<?php echo $event->id; ?>" class="event-row-item">
                        <td class="text-left" onclick='viewEventDetails(<?php echo json_encode($event) ?>)'>
                            <?php echo $event->event_time; ?>
                        </td>
                        <td class="text-left" onclick='viewEventDetails(<?php echo json_encode($event) ?>)'>
                            <?php echo $event->title; ?>
                        </td>
                        <td class="text-left" onclick='viewEventDetails(<?php echo json_encode($event) ?>)'>
                            <?php echo strlen($event->description) > 75 ? 
                                substr($event->description,0,75)."..." : 
                                $event->description; ?>
                        </td>
                        <td class="text-center" onclick='viewEventDetails(<?php echo json_encode($event) ?>)'>
                            <?php echo $event->created_by_user_name; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="table_footer">
        <div class="row-per-page">
            <div class="usr-icon" onclick="$('#public_events_rows_dropdown').toggle();">
                <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                    <?php echo $rowsPerPage; ?>
                </button> Items per page
                <div id="public_events_rows_dropdown" class="dropdown-content dropdown-menu">
                    <button class="dropdown-item" onclick="loadPublicEventsPage(1,5)">5</button>
                    <button class="dropdown-item" onclick="loadPublicEventsPage(1,15)">15</button>
                    <button class="dropdown-item" onclick="loadPublicEventsPage(1,30)">30</button>
                </div>
            </div>
        </div>
        <?php if ($totalPage > 1){$this->view('admin_dashboard/publicEventsPagination');} ?>
        <div class="row-statistics">
            Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
        </div>
    </div>
</div>