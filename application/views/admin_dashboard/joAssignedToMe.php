<script>    
    // Redirect to details view.
    function viewJobOrderDetails(id){
        window.location.href = '<?php echo site_url('job_order/view') ?>?id='+id;
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
        <h5 class="h5 text-white">Job Orders Assigned To Me</h5>
    </div>
    <div class="table-responsive job_order-table">
        <table class="table table-hover" id="job_order_table">
            <thead>
                <tr>
                    <?php createSortableHeader('Job Order','job-order-header text-left',$orderBy, $order, 'title' ,'loadJoAssignedToMePage'); ?>
                    <?php createSortableHeader('Company','job-order-header text-center',$orderBy, $order, 'company' ,'loadJoAssignedToMePage'); ?>
                    <?php createSortableHeader('Status','job-order-header text-center',$orderBy, $order, 'status' ,'loadJoAssignedToMePage'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($job_orders as $job_order): ?>
                    <tr id="job_order-<?php echo $job_order->id; ?>" class="job_order-row-item">
                        <td class="text-left" onclick="viewJobOrderDetails(<?php echo $job_order->id; ?>)">
                            <?php echo $job_order->title; ?>
                        </td>
                        <td class="text-center" onclick="viewJobOrderDetails(<?php echo $job_order->id; ?>)">
                            <a href="<?php echo site_url('company/view').'?id='.$job_order->id; ?>">
                                <?php echo $job_order->company; ?>
                            </a>
                        </td>
                        <td class="text-center" onclick="viewJobOrderDetails(<?php echo $job_order->id; ?>)">
                            <?php echo $job_order->status; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="table_footer d-flex justify-content-between align-items-center">
        <div class="row-per-page">
            <div class="usr-icon" onclick="$('#job_order_rows_dropdown').toggle();">
                <button class="btn btn-secondary dropdown-toggle btn-sm" href="#">
                    <?php echo $rowsPerPage; ?>
                </button> Items per page
                <div id="job_order_rows_dropdown" class="dropdown-content dropdown-menu">
                    <button class="dropdown-item" onclick="loadJoAssignedToMePage(1,5)">5</button>
                    <button class="dropdown-item" onclick="loadJoAssignedToMePage(1,15)">15</button>
                    <button class="dropdown-item" onclick="loadJoAssignedToMePage(1,30)">30</button>
                </div>
            </div>
        </div>
        <?php if ($totalPage > 1){$this->view('admin_dashboard/joAssignedToMePagination');} ?>
        <div class="row-statistics">
            Showing <?php echo ($offset+1) ?>-<?php echo ($rowsPerPage*$currentPage < $totalCount) ? ($rowsPerPage*$currentPage): $totalCount; ?> out of <?php echo $totalCount; ?>
        </div>
    </div>
</div>